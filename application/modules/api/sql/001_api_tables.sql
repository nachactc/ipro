/* =====================================================================
   IPRO API v1 (read-only) — DDL tabul autentikasi & logging API
   ---------------------------------------------------------------------
   Eksekusi: SSMS / sqlcmd, dengan login yang punya hak CREATE TABLE
   di database aktif IPRO (lihat application/config/database.php).
   Idempotent: aman dieksekusi berulang (cek IF NOT EXISTS).
   ===================================================================== */

IF NOT EXISTS (SELECT 1 FROM sys.tables WHERE name = 'api_client')
BEGIN
    CREATE TABLE api_client (
        api_client_id          INT IDENTITY(1,1) PRIMARY KEY,
        client_name            NVARCHAR(100) NOT NULL,
        api_key                NVARCHAR(64)  NOT NULL,
        api_secret             NVARCHAR(128) NOT NULL,
        is_active              BIT           NOT NULL DEFAULT 1,
        rate_limit_per_minute  INT           NOT NULL DEFAULT 60,
        created_at             DATETIME      NOT NULL DEFAULT GETDATE(),
        updated_at             DATETIME      NULL
    );
END
GO

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'UX_api_client_api_key'
      AND object_id = OBJECT_ID('api_client')
)
BEGIN
    CREATE UNIQUE INDEX UX_api_client_api_key ON api_client (api_key);
END
GO

IF NOT EXISTS (SELECT 1 FROM sys.tables WHERE name = 'api_log')
BEGIN
    CREATE TABLE api_log (
        api_log_id     INT IDENTITY(1,1) PRIMARY KEY,
        api_client_id  INT           NULL,
        api_key        NVARCHAR(64)  NULL,
        http_method    VARCHAR(10)   NOT NULL,
        uri_path       NVARCHAR(255) NOT NULL,
        http_status    INT           NOT NULL,
        response_ms    INT           NOT NULL DEFAULT 0,
        ip_address     NVARCHAR(45)  NULL,
        error_message  NVARCHAR(500) NULL,
        created_at     DATETIME      NOT NULL DEFAULT GETDATE()
    );
END
GO

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'IX_api_log_client_created'
      AND object_id = OBJECT_ID('api_log')
)
BEGIN
    CREATE NONCLUSTERED INDEX IX_api_log_client_created
    ON api_log (api_client_id, created_at);
END
GO

/* ---------------------------------------------------------------------
   Seed 1 client pertama.
   api_key  : 32 hex (1 GUID minus dash)
   api_secret: 64 hex (2 GUID minus dash, digabung)
   Nilai dibuat saat eksekusi — TIDAK di-hardcode di file ini.
   Script me-SELECT hasilnya, catat sekali lalu simpan di tempat aman
   (secret ada di tabel api_client dan bisa di-query ulang bila perlu).
   --------------------------------------------------------------------- */
DECLARE @api_key    NVARCHAR(64);
DECLARE @api_secret NVARCHAR(128);

IF NOT EXISTS (SELECT 1 FROM api_client WHERE client_name = N'IPRO Dev Client')
BEGIN
    SELECT @api_key    = LOWER(REPLACE(CONVERT(NVARCHAR(36), NEWID()), '-', ''));
    SELECT @api_secret = LOWER(REPLACE(CONVERT(NVARCHAR(36), NEWID()), '-', ''))
                       + LOWER(REPLACE(CONVERT(NVARCHAR(36), NEWID()), '-', ''));

    INSERT INTO api_client (client_name, api_key, api_secret, is_active, rate_limit_per_minute)
    VALUES (N'IPRO Dev Client', @api_key, @api_secret, 1, 60);
END

SELECT api_client_id, client_name, api_key, api_secret, rate_limit_per_minute
FROM   api_client;
GO
