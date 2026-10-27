-- =====================================================================
-- Modul Casual Leasing (CL) - skema tabel
-- Tabel terpisah, prefix cl_, TIDAK berelasi dengan tabel ipro yang ada.
-- Idempoten: aman dijalankan ulang.
-- =====================================================================

-- Wajib untuk filtered index (ux_cl_unit_period_master).
SET ANSI_NULLS ON;
SET ANSI_PADDING ON;
SET ANSI_WARNINGS ON;
SET ARITHABORT ON;
SET CONCAT_NULL_YIELDS_NULL ON;
SET QUOTED_IDENTIFIER ON;
SET NUMERIC_ROUNDABORT OFF;

IF OBJECT_ID('dbo.cl_periode', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_periode (
        periode_id       varchar(7)    NOT NULL CONSTRAINT pk_cl_periode PRIMARY KEY,
        periode_name     nvarchar(30)  NOT NULL,
        periode_start    date          NULL,
        periode_end      date          NULL,
        periode_isactive int           NOT NULL CONSTRAINT df_cl_periode_active DEFAULT (1),
        createby         nvarchar(50)  NULL,
        createdate       datetime      NULL,
        modifyby         nvarchar(50)  NULL,
        modifydate       datetime      NULL
    );
END;

IF OBJECT_ID('dbo.cl_tipe', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_tipe (
        tipe_id         varchar(20)   NOT NULL CONSTRAINT pk_cl_tipe PRIMARY KEY,
        tipe_name       nvarchar(50)  NOT NULL,
        tipe_order      int           NOT NULL CONSTRAINT df_cl_tipe_order DEFAULT (0),
        tipe_isactive   int           NOT NULL CONSTRAINT df_cl_tipe_active DEFAULT (1)
    );
END;

IF OBJECT_ID('dbo.cl_lokasi', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_lokasi (
        lokasi_id       int           IDENTITY(1,1) NOT NULL CONSTRAINT pk_cl_lokasi PRIMARY KEY,
        tipe_id         varchar(20)   NOT NULL,
        lokasi_code     varchar(20)   NOT NULL,
        lokasi_name     nvarchar(50)  NOT NULL,
        lokasi_nla      decimal(18,2) NOT NULL CONSTRAINT df_cl_lokasi_nla DEFAULT (0),
        lokasi_order    int           NOT NULL CONSTRAINT df_cl_lokasi_order DEFAULT (0),
        lokasi_isactive int           NOT NULL CONSTRAINT df_cl_lokasi_active DEFAULT (1),
        CONSTRAINT uq_cl_lokasi UNIQUE (tipe_id, lokasi_code)
    );
END;

IF OBJECT_ID('dbo.cl_pic', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_pic (
        pic_id          varchar(10)   NOT NULL CONSTRAINT pk_cl_pic PRIMARY KEY,
        pic_name        nvarchar(50)  NULL,
        pic_isactive    int           NOT NULL CONSTRAINT df_cl_pic_active DEFAULT (1)
    );
END;

-- Master unit: unit fisik + NLA, dipilih saat membuat budget.
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

IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE name = 'ux_cl_unit_master_lokasi_no' AND object_id = OBJECT_ID('dbo.cl_unit_master'))
BEGIN
    CREATE UNIQUE INDEX ux_cl_unit_master_lokasi_no
        ON dbo.cl_unit_master (lokasi_id, unit_no);
END;

IF OBJECT_ID('dbo.cl_unit', 'U') IS NULL
BEGIN
    CREATE TABLE dbo.cl_unit (
        unit_id         int           IDENTITY(1,1) NOT NULL CONSTRAINT pk_cl_unit PRIMARY KEY,
        unit_master_id  int           NULL,
        periode_id      varchar(7)    NOT NULL,
        tipe_id         varchar(20)   NOT NULL,
        lokasi_id       int           NOT NULL,
        unit_no         int           NULL,
        unit_name       nvarchar(150) NOT NULL,
        pic_id          varchar(10)   NULL,
        nla             decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_nla DEFAULT (0),
        unit_status     varchar(20)   NOT NULL CONSTRAINT df_cl_unit_status DEFAULT ('VACANT'),
        tenant          nvarchar(200) NULL,
        periode_type    varchar(20)   NULL,
        periode_start   date          NULL,
        periode_end     date          NULL,
        periode_text    nvarchar(100) NULL,
        budget          decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_budget DEFAULT (0),
        occupied        decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_occ DEFAULT (0),
        w1              decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w1 DEFAULT (0),
        w2              decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w2 DEFAULT (0),
        w3              decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w3 DEFAULT (0),
        w4              decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_w4 DEFAULT (0),
        prospek         decimal(18,2) NOT NULL CONSTRAINT df_cl_unit_prospek DEFAULT (0),
        remarks         nvarchar(255) NULL,
        unit_isactive   int           NOT NULL CONSTRAINT df_cl_unit_active DEFAULT (1),
        createby        nvarchar(50)  NULL,
        createdate      datetime      NULL,
        modifyby        nvarchar(50)  NULL,
        modifydate      datetime      NULL
    );
END;

IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE name = 'ix_cl_unit_periode' AND object_id = OBJECT_ID('dbo.cl_unit'))
BEGIN
    CREATE INDEX ix_cl_unit_periode
        ON dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no);
END;

IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE name = 'ix_cl_unit_master_link' AND object_id = OBJECT_ID('dbo.cl_unit'))
BEGIN
    CREATE INDEX ix_cl_unit_master_link
        ON dbo.cl_unit (unit_master_id, periode_id);
END;

IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE name = 'ux_cl_unit_period_master' AND object_id = OBJECT_ID('dbo.cl_unit'))
BEGIN
    CREATE UNIQUE INDEX ux_cl_unit_period_master
        ON dbo.cl_unit (periode_id, unit_master_id)
        WHERE unit_master_id IS NOT NULL;
END;
