-- =====================================================================
-- Modul Casual Leasing (CL) - Master Unit + link ke Budget
-- Tujuan:
--   1. Memisahkan master unit (lokasi + no unit + nama + NLA) dari budget.
--   2. Mengubah data 120 baris lama menjadi 1 master unit + 1 budget.
--   3. Menetapkan satu budget per unit per periode.
--   4. Menu: CL Budget -> daftar/input budget, CL Unit -> master unit.
--
-- Urutan yang disarankan pada DB live:
--   05a_budget_unit_add.sql -> 06_unit_master_add.sql -> verifikasi -> 05b
-- Pada fresh install: 01 -> 02 -> 03 -> 04 -> 05a -> 06 -> (05b).
-- 06 boleh dijalankan ulang; baris budget yang belum terhubung akan di-link.
-- =====================================================================

SET NOCOUNT ON;
-- Wajib untuk filtered index (ux_cl_unit_period_master).
SET ANSI_NULLS ON;
SET ANSI_PADDING ON;
SET ANSI_WARNINGS ON;
SET ARITHABORT ON;
SET CONCAT_NULL_YIELDS_NULL ON;
SET QUOTED_IDENTIFIER ON;
SET NUMERIC_ROUNDABORT OFF;
SET XACT_ABORT ON;
BEGIN TRAN;
DECLARE @unlinked int, @dupes int;

-- ---------------------------------------------------------------------
-- 1. Tabel master unit
-- ---------------------------------------------------------------------
IF OBJECT_ID('dbo.cl_unit_master', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_unit_master (
        unit_master_id  int           IDENTITY(1,1) NOT NULL CONSTRAINT pk_cl_unit_master PRIMARY KEY,
        lokasi_id       int           NOT NULL,
        unit_no         int           NOT NULL,
        unit_name       nvarchar(150) NOT NULL,
        nla             decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_master_nla DEFAULT (0),
        unit_isactive   int           NOT NULL CONSTRAINT df_cl_unit_master_active DEFAULT (1),
        createby        nvarchar(50)  NULL,
        createdate      datetime      NULL,
        modifyby        nvarchar(50)  NULL,
        modifydate      datetime      NULL
    );
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'ux_cl_unit_master_lokasi_no'
      AND object_id = OBJECT_ID('dbo.cl_unit_master')
)
BEGIN
    CREATE UNIQUE INDEX ux_cl_unit_master_lokasi_no
        ON dbo.cl_unit_master (lokasi_id, unit_no);
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'ix_cl_unit_master_lokasi'
      AND object_id = OBJECT_ID('dbo.cl_unit_master')
)
BEGIN
    CREATE INDEX ix_cl_unit_master_lokasi
        ON dbo.cl_unit_master (lokasi_id);
END;

-- ---------------------------------------------------------------------
-- 2. Kolom penghubung di tabel budget (cl_unit)
-- ---------------------------------------------------------------------
IF COL_LENGTH('dbo.cl_unit', 'unit_master_id') IS NULL
BEGIN
    ALTER TABLE dbo.cl_unit ADD unit_master_id int NULL;
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'ix_cl_unit_master_link'
      AND object_id = OBJECT_ID('dbo.cl_unit')
)
BEGIN
    -- Dynamic SQL: unit_master_id baru ditambahkan pada batch ini.
    EXEC sp_executesql N'
    CREATE INDEX ix_cl_unit_master_link
        ON dbo.cl_unit (unit_master_id, periode_id);';
END;

-- ---------------------------------------------------------------------
-- 3. Backfill master unit dari data budget lama
--    unit_no sudah unik per lokasi pada data live (120 baris).
-- ---------------------------------------------------------------------
IF EXISTS (SELECT 1 FROM dbo.cl_unit WHERE unit_no IS NULL)
BEGIN
    ROLLBACK;
    RAISERROR('Migrasi dibatalkan: ada baris cl_unit dengan unit_no NULL. Lengkapi unit_no terlebih dahulu.', 16, 1);
    RETURN;
END;

INSERT INTO dbo.cl_unit_master
    (lokasi_id, unit_no, unit_name, nla, unit_isactive, createby, createdate)
SELECT
    u.lokasi_id,
    u.unit_no,
    MAX(u.unit_name) AS unit_name,
    MAX(u.nla) AS nla,
    1,
    'migration-06',
    GETDATE()
FROM dbo.cl_unit u
WHERE u.unit_no IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM dbo.cl_unit_master m
      WHERE m.lokasi_id = u.lokasi_id
        AND m.unit_no = u.unit_no
  )
GROUP BY u.lokasi_id, u.unit_no;

-- Dynamic SQL: unit_master_id baru ditambahkan pada batch ini.
EXEC sp_executesql N'
UPDATE u
   SET u.unit_master_id = m.unit_master_id
FROM dbo.cl_unit u
JOIN dbo.cl_unit_master m
  ON m.lokasi_id = u.lokasi_id
 AND m.unit_no   = u.unit_no
WHERE u.unit_master_id IS NULL;';

EXEC sp_executesql N'
SELECT @c = COUNT(*) FROM dbo.cl_unit WHERE unit_master_id IS NULL;',
N'@c int OUTPUT', @unlinked OUTPUT;

IF @unlinked > 0
BEGIN
    ROLLBACK;
    RAISERROR('Migrasi dibatalkan: %d baris budget belum terhubung ke master unit.', 16, 1, @unlinked);
    RETURN;
END;

-- Satu unit hanya boleh punya satu budget pada periode yang sama.
EXEC sp_executesql N'
SELECT @c = COUNT(*)
FROM (
    SELECT periode_id, unit_master_id
    FROM dbo.cl_unit
    WHERE unit_master_id IS NOT NULL
    GROUP BY periode_id, unit_master_id
    HAVING COUNT(*) > 1
) d;',
N'@c int OUTPUT', @dupes OUTPUT;

IF @dupes > 0
BEGIN
    ROLLBACK;
    RAISERROR('Migrasi dibatalkan: ada unit yang memiliki lebih dari satu budget pada periode yang sama.', 16, 1);
    RETURN;
END;

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'ux_cl_unit_period_master'
      AND object_id = OBJECT_ID('dbo.cl_unit')
)
BEGIN
    EXEC sp_executesql N'
    CREATE UNIQUE INDEX ux_cl_unit_period_master
        ON dbo.cl_unit (periode_id, unit_master_id)
        WHERE unit_master_id IS NOT NULL;';
END;

-- ---------------------------------------------------------------------
-- 4. Menu final: CL Budget = daftar/input budget, CL Unit = master unit
-- ---------------------------------------------------------------------
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

DELETE FROM dbo.master_userprogramweb WHERE program_id = 183022003;
DELETE FROM dbo.master_programweb WHERE program_id = 183022003;

INSERT INTO dbo.master_userprogramweb (username, group_id, program_id)
SELECT 'administrator', 183022, p.program_id
FROM dbo.master_programweb p
WHERE p.program_id IN (183022001, 183022002, 183022004, 183022005, 183022006, 183022007, 183022008)
  AND NOT EXISTS (
      SELECT 1 FROM dbo.master_userprogramweb u
      WHERE u.username = 'administrator' AND u.program_id = p.program_id
  );

COMMIT;

PRINT '06 selesai: master unit dibuat, budget lama terhubung, satu budget per unit/periode, menu diperbarui.';
