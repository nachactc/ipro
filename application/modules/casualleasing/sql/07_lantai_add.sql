-- =====================================================================
-- Modul Casual Leasing (CL) - Master Lantai / Area (denah statis)
-- Tujuan:
--   1. Tabel referensi posisi fisik: LG, GF, F1, F2, F3 + OTHER (AREA).
--   2. Denah statis per lantai: file PNG/JPG diupload, ditampilkan sebagai
--      gambaran prospos/occupied/vacant (bukan pengganti data master).
--   3. Mapping opsional lantai -> lokasi (cl_lokasi.lantai_id) supaya
--      ringkasan OCCUPIED/RENEWAL/VACANT per lantai bisa dihitung.
--   4. Menu: Master Lantai (program 183022009).
--
-- Catatan:
--   - OTHER adalah area non-lantai (PARKIRAN, GUDANG, dll), boleh tanpa denah.
--   - Tidak ada FK ke tabel ipro; hanya index biasa (pola modul CL).
--   - Idempoten; boleh dijalankan ulang. Tidak ada perubahan pada cl_unit
--     maupun cl_unit_master.
--
-- Urutan di DB live: 06_unit_master_add.sql selesai -> 07_lantai_add.sql.
-- =====================================================================

SET NOCOUNT ON;
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
-- 1. Tabel master lantai / area
-- ---------------------------------------------------------------------
IF OBJECT_ID('dbo.cl_lantai', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_lantai (
        lantai_id       int           IDENTITY(1,1) NOT NULL CONSTRAINT pk_cl_lantai PRIMARY KEY,
        lantai_code     nvarchar(10)  NOT NULL,
        lantai_name     nvarchar(100) NOT NULL,
        lantai_order    int           NOT NULL CONSTRAINT df_cl_lantai_order DEFAULT (0),
        lantai_jenis    nvarchar(10)  NOT NULL CONSTRAINT df_cl_lantai_jenis DEFAULT ('LANTAI'),
        map_file        nvarchar(255) NULL,
        lantai_isactive int           NOT NULL CONSTRAINT df_cl_lantai_active DEFAULT (1),
        createby        nvarchar(50)  NULL,
        createdate      datetime      NULL,
        modifyby        nvarchar(50)  NULL,
        modifydate      datetime      NULL
    );
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'uq_cl_lantai_code'
      AND object_id = OBJECT_ID('dbo.cl_lantai')
)
BEGIN
    CREATE UNIQUE INDEX uq_cl_lantai_code
        ON dbo.cl_lantai (lantai_code);
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'ix_cl_lantai_order'
      AND object_id = OBJECT_ID('dbo.cl_lantai')
)
BEGIN
    CREATE INDEX ix_cl_lantai_order
        ON dbo.cl_lantai (lantai_order, lantai_code);
END;

-- ---------------------------------------------------------------------
-- 2. Mapping opsional lantai -> lokasi
-- ---------------------------------------------------------------------
IF COL_LENGTH('dbo.cl_lokasi', 'lantai_id') IS NULL
BEGIN
    ALTER TABLE dbo.cl_lokasi ADD lantai_id int NULL;
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'ix_cl_lokasi_lantai'
      AND object_id = OBJECT_ID('dbo.cl_lokasi')
)
BEGIN
    CREATE INDEX ix_cl_lokasi_lantai
        ON dbo.cl_lokasi (lantai_id);
END;

-- ---------------------------------------------------------------------
-- 3. Seed label standar. Nama hanya diisi bila baris belum punya nama
--    custom, supaya jalannya ulang tidak menimpa hasil edit user.
-- ---------------------------------------------------------------------
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lantai WHERE lantai_code = 'LG')
    INSERT INTO dbo.cl_lantai (lantai_code, lantai_name, lantai_order, lantai_jenis, lantai_isactive, createby, createdate)
    VALUES ('LG', 'Lower Ground', 1, 'LANTAI', 1, 'migration-07', GETDATE());

IF NOT EXISTS (SELECT 1 FROM dbo.cl_lantai WHERE lantai_code = 'GF')
    INSERT INTO dbo.cl_lantai (lantai_code, lantai_name, lantai_order, lantai_jenis, lantai_isactive, createby, createdate)
    VALUES ('GF', 'Ground Floor', 2, 'LANTAI', 1, 'migration-07', GETDATE());

IF NOT EXISTS (SELECT 1 FROM dbo.cl_lantai WHERE lantai_code = 'F1')
    INSERT INTO dbo.cl_lantai (lantai_code, lantai_name, lantai_order, lantai_jenis, lantai_isactive, createby, createdate)
    VALUES ('F1', 'Floor 1', 3, 'LANTAI', 1, 'migration-07', GETDATE());

IF NOT EXISTS (SELECT 1 FROM dbo.cl_lantai WHERE lantai_code = 'F2')
    INSERT INTO dbo.cl_lantai (lantai_code, lantai_name, lantai_order, lantai_jenis, lantai_isactive, createby, createdate)
    VALUES ('F2', 'Floor 2', 4, 'LANTAI', 1, 'migration-07', GETDATE());

IF NOT EXISTS (SELECT 1 FROM dbo.cl_lantai WHERE lantai_code = 'F3')
    INSERT INTO dbo.cl_lantai (lantai_code, lantai_name, lantai_order, lantai_jenis, lantai_isactive, createby, createdate)
    VALUES ('F3', 'Floor 3', 5, 'LANTAI', 1, 'migration-07', GETDATE());

IF NOT EXISTS (SELECT 1 FROM dbo.cl_lantai WHERE lantai_code = 'OTHER')
    INSERT INTO dbo.cl_lantai (lantai_code, lantai_name, lantai_order, lantai_jenis, lantai_isactive, createby, createdate)
    VALUES ('OTHER', 'Area Lain (PARKIRAN, GUDANG, dll)', 6, 'AREA', 1, 'migration-07', GETDATE());

-- OTHER wajib berjenis AREA (bukan lantai).
UPDATE dbo.cl_lantai
   SET lantai_jenis = 'AREA'
 WHERE lantai_code = 'OTHER'
   AND lantai_jenis <> 'AREA';

COMMIT;

-- ---------------------------------------------------------------------
-- 4. Menu: Master Lantai
-- ---------------------------------------------------------------------
IF NOT EXISTS (SELECT 1 FROM dbo.master_programweb WHERE program_id = 183022009)
    INSERT INTO dbo.master_programweb (program_id, program_title, program_icon, program_url, program_controller, program_creator, program_isdisabled)
    VALUES (183022009, 'Master Lantai', 'fa fa-building', 'index.php/casualleasing/casualleasing/master_lantai', 'casualleasing', 'system', 0);
ELSE
    UPDATE dbo.master_programweb
       SET program_title = 'Master Lantai',
           program_icon  = 'fa fa-building',
           program_url   = 'index.php/casualleasing/casualleasing/master_lantai'
     WHERE program_id = 183022009;

INSERT INTO dbo.master_userprogramweb (username, group_id, program_id)
SELECT 'administrator', 183022, p.program_id
FROM dbo.master_programweb p
WHERE p.program_id = 183022009
  AND NOT EXISTS (
      SELECT 1 FROM dbo.master_userprogramweb u
      WHERE u.username = 'administrator' AND u.program_id = p.program_id
  );

PRINT '07 selesai: cl_lantai dibuat, seed LG/GF/F1/F2/F3/OTHER, mapping cl_lokasi.lantai_id, menu Master Lantai.';
