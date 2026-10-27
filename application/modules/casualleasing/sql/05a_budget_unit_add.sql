-- =====================================================================
-- Modul Casual Leasing (CL) - migrasi Budget + Unit
-- Tahap A (aman / additive): kolom baru, migrasi nilai W1-W4, menu baru.
-- BELUM dijalankan otomatis. Jalankan setelah review.
--
-- Perubahan:
--   1. cl_lokasi.lokasi_nla  -> kapasitas NLA per lokasi (mis. Atrium).
--   2. cl_unit.w1..w4        -> nilai prospek per minggu.
--   3. Data lama: prospek + week_target dipetakan ke kolom minggu.
--   4. Menu: 001 = CL Budget, 002 = CL Unit, Master Tarif dihapus dari menu.
--
-- Tahap B (destruktif) ada di 05b_drop_tarif.sql dan dijalankan terpisah
-- setelah halaman Budget/Unit terbukti berjalan.
-- =====================================================================

SET NOCOUNT ON;
-- SET yang aman untuk tabel dengan filtered index (jika 06 sudah dijalankan).
SET ANSI_NULLS ON;
SET ANSI_PADDING ON;
SET ANSI_WARNINGS ON;
SET ARITHABORT ON;
SET CONCAT_NULL_YIELDS_NULL ON;
SET QUOTED_IDENTIFIER ON;
SET NUMERIC_ROUNDABORT OFF;
SET XACT_ABORT ON;
BEGIN TRAN;

-- ---------------------------------------------------------------------
-- 1. Kapasitas NLA lokasi
-- ---------------------------------------------------------------------
IF COL_LENGTH('dbo.cl_lokasi', 'lokasi_nla') IS NULL
BEGIN
    ALTER TABLE dbo.cl_lokasi
        ADD lokasi_nla decimal(18,2) NOT NULL
            CONSTRAINT df_cl_lokasi_nla DEFAULT (0);
END;

-- ---------------------------------------------------------------------
-- 2. Kolom prospek per minggu
-- ---------------------------------------------------------------------
IF COL_LENGTH('dbo.cl_unit', 'w1') IS NULL
    ALTER TABLE dbo.cl_unit ADD w1 decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w1 DEFAULT (0);
IF COL_LENGTH('dbo.cl_unit', 'w2') IS NULL
    ALTER TABLE dbo.cl_unit ADD w2 decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w2 DEFAULT (0);
IF COL_LENGTH('dbo.cl_unit', 'w3') IS NULL
    ALTER TABLE dbo.cl_unit ADD w3 decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w3 DEFAULT (0);
IF COL_LENGTH('dbo.cl_unit', 'w4') IS NULL
    ALTER TABLE dbo.cl_unit ADD w4 decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w4 DEFAULT (0);

-- ---------------------------------------------------------------------
-- 3. Migrasi data lama (hanya untuk baris yang belum punya distribusi)
--    week_target lama menjadi kolom minggu yang sesuai; nilainya = prospek.
-- ---------------------------------------------------------------------
IF COL_LENGTH('dbo.cl_unit', 'week_target') IS NOT NULL
BEGIN
    -- Dynamic SQL agar batch tetap valid di instalasi baru yang tidak punya week_target.
    EXEC sp_executesql N'
    UPDATE dbo.cl_unit
       SET w1 = CASE WHEN UPPER(ISNULL(week_target,'''')) NOT IN (''W2'',''W3'',''W4'')
                     THEN ISNULL(prospek,0) ELSE w1 END,
           w2 = CASE WHEN UPPER(ISNULL(week_target,'''')) = ''W2'' THEN ISNULL(prospek,0) ELSE w2 END,
           w3 = CASE WHEN UPPER(ISNULL(week_target,'''')) = ''W3'' THEN ISNULL(prospek,0) ELSE w3 END,
           w4 = CASE WHEN UPPER(ISNULL(week_target,'''')) = ''W4'' THEN ISNULL(prospek,0) ELSE w4 END
     WHERE ISNULL(w1,0) = 0 AND ISNULL(w2,0) = 0
       AND ISNULL(w3,0) = 0 AND ISNULL(w4,0) = 0
       AND ISNULL(prospek,0) > 0;';
END;

-- Fallback: bila tidak ada week_target (atau nilainya tidak dikenal), simpan prospek di W1.
-- Dynamic SQL: kolom w1..w4 baru ditambahkan pada batch ini.
EXEC sp_executesql N'
UPDATE dbo.cl_unit
   SET w1 = ISNULL(prospek,0)
 WHERE ISNULL(w1,0) = 0 AND ISNULL(w2,0) = 0
   AND ISNULL(w3,0) = 0 AND ISNULL(w4,0) = 0
   AND ISNULL(prospek,0) > 0;';

-- Pastikan total prospek = jumlah kolom minggu untuk baris yang sudah punya distribusi.
EXEC sp_executesql N'
UPDATE dbo.cl_unit
   SET prospek = ISNULL(w1,0) + ISNULL(w2,0) + ISNULL(w3,0) + ISNULL(w4,0)
 WHERE (ISNULL(w1,0) + ISNULL(w2,0) + ISNULL(w3,0) + ISNULL(w4,0)) > 0
   AND prospek <> (ISNULL(w1,0) + ISNULL(w2,0) + ISNULL(w3,0) + ISNULL(w4,0));';

-- ---------------------------------------------------------------------
-- 4. Menu: Budget utama + Unit terpisah, Master Tarif dihapus dari menu
-- ---------------------------------------------------------------------
IF NOT EXISTS (SELECT 1 FROM dbo.master_groupweb WHERE group_id = 183022)
    INSERT INTO dbo.master_groupweb (group_id, group_name, group_icon, group_code, group_isdisabled)
    VALUES (183022, 'Casual Leasing', 'icon-briefcase', 'N', 0);

IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022001)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022001, 'CL Budget', 'icon-bar-chart', 'index.php/casualleasing/casualleasing/load', 'casualleasing', 'system', 0);
ELSE
    UPDATE dbo.master_programweb
       SET program_title = 'CL Budget',
           program_icon  = 'icon-bar-chart',
           program_url   = 'index.php/casualleasing/casualleasing/load'
     WHERE program_id = 183022001;

IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022002)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022002, 'CL Unit', 'icon-briefcase', 'index.php/casualleasing/casualleasing/unit_master', 'casualleasing', 'system', 0);
ELSE
    UPDATE dbo.master_programweb
       SET program_title = 'CL Unit',
           program_icon  = 'icon-briefcase',
           program_url   = 'index.php/casualleasing/casualleasing/unit_master'
     WHERE program_id = 183022002;

-- Master Tarif tidak dipakai lagi.
DELETE FROM dbo.master_userprogramweb WHERE program_id = 183022003;
DELETE FROM dbo.master_programweb WHERE program_id = 183022003;

-- Pastikan menu lain tetap ada.
IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022004)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022004, 'CL Import', 'icon-cloud-upload', 'index.php/casualleasing/casualleasing/import', 'casualleasing', 'system', 0);

IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022005)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022005, 'Master PIC', 'fa fa-users', 'index.php/casualleasing/casualleasing/master_pic', 'casualleasing', 'system', 0);

IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022006)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022006, 'Master Tipe', 'fa fa-list', 'index.php/casualleasing/casualleasing/master_tipe', 'casualleasing', 'system', 0);

IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022007)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022007, 'Master Lokasi', 'fa fa-map-marker', 'index.php/casualleasing/casualleasing/master_lokasi', 'casualleasing', 'system', 0);

IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022008)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022008, 'Master Periode', 'fa fa-calendar', 'index.php/casualleasing/casualleasing/master_periode', 'casualleasing', 'system', 0);

-- Akses administrator untuk menu yang masih aktif.
INSERT INTO dbo.master_userprogramweb (username, group_id, program_id)
SELECT 'administrator', 183022, p.program_id
FROM dbo.master_programweb p
WHERE p.program_id IN (183022001, 183022002, 183022004, 183022005, 183022006, 183022007, 183022008)
  AND NOT EXISTS (
      SELECT 1 FROM dbo.master_userprogramweb u
      WHERE u.username = 'administrator' AND u.program_id = p.program_id
  );

COMMIT;

PRINT '05a selesai: kolom Budget/Unit dan menu baru sudah siap.';
PRINT 'Jalankan 05b_drop_tarif.sql hanya setelah halaman Budget dan Unit diverifikasi.';
