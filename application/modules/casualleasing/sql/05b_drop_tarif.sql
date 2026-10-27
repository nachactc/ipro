-- =====================================================================
-- Modul Casual Leasing (CL) - migrasi Budget + Unit
-- Tahap B (DESTRUKTIF): hapus tarif dan kolom week_target lama.
--
-- Jalankan HANYA setelah:
--   1. 05a_budget_unit_add.sql selesai.
--   2. Halaman CL Budget, CL Unit, form, import, export, dan cetak diverifikasi.
--   3. Backup tabel cl_unit / cl_lokasi / cl_tarif tersedia.
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

-- Menu Master Tarif (biasanya sudah dihapus di 05a).
DELETE FROM dbo.master_userprogramweb WHERE program_id = 183022003;
DELETE FROM dbo.master_programweb WHERE program_id = 183022003;

-- Tabel master tarif.
IF OBJECT_ID('dbo.cl_tarif', 'U') IS NOT NULL
    DROP TABLE dbo.cl_tarif;

-- Kolom tarif pada unit. Drop default constraint apa pun namanya.
IF COL_LENGTH('dbo.cl_unit', 'tarif_per_m2') IS NOT NULL
BEGIN
    DECLARE @tarif_df sysname;
    SELECT @tarif_df = dc.name
      FROM sys.default_constraints dc
      JOIN sys.columns c
        ON c.object_id = dc.parent_object_id
       AND c.column_id = dc.parent_column_id
     WHERE dc.parent_object_id = OBJECT_ID('dbo.cl_unit')
       AND c.name = 'tarif_per_m2';
    IF @tarif_df IS NOT NULL
        EXEC('ALTER TABLE dbo.cl_unit DROP CONSTRAINT [' + @tarif_df + ']');
    EXEC('ALTER TABLE dbo.cl_unit DROP COLUMN tarif_per_m2');
END;

-- Kolom week tunggal sudah diganti w1..w4. Drop default constraint apa pun namanya.
IF COL_LENGTH('dbo.cl_unit', 'week_target') IS NOT NULL
BEGIN
    DECLARE @week_df sysname;
    SELECT @week_df = dc.name
      FROM sys.default_constraints dc
      JOIN sys.columns c
        ON c.object_id = dc.parent_object_id
       AND c.column_id = dc.parent_column_id
     WHERE dc.parent_object_id = OBJECT_ID('dbo.cl_unit')
       AND c.name = 'week_target';
    IF @week_df IS NOT NULL
        EXEC('ALTER TABLE dbo.cl_unit DROP CONSTRAINT [' + @week_df + ']');
    EXEC('ALTER TABLE dbo.cl_unit DROP COLUMN week_target');
END;

COMMIT;

PRINT '05b selesai: tarif dan week_target lama sudah dihapus.';
