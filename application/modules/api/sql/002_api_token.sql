/* =====================================================================
   IPRO API — Tahap 2: tabel token user (login/logout)
   ---------------------------------------------------------------------
   Prasyarat : 001_api_tables.sql sudah dieksekusi (ada api_client).
   Idempotent: aman dieksekusi berulang.
   Token plaintext DIBERIKAN ke client sekali saat login; di database
   hanya disimpan SHA-256 hex (token_hash) — kebocoran DB tidak
   membocorkan token aktif.
   ===================================================================== */

IF NOT EXISTS (SELECT 1 FROM sys.tables WHERE name = 'api_token')
BEGIN
    CREATE TABLE api_token (
        api_token_id   INT IDENTITY(1,1) PRIMARY KEY,
        token_hash     CHAR(64)     NOT NULL,        -- SHA-256 hex dari token plaintext
        api_client_id  INT          NOT NULL,        -- client yang membuat token
        username       NVARCHAR(50) NOT NULL,
        created_at     DATETIME     NOT NULL DEFAULT GETDATE(),
        expires_at     DATETIME     NOT NULL,
        last_used_at   DATETIME     NULL,
        revoked_at     DATETIME     NULL
    );
END
GO

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'UX_api_token_hash'
      AND object_id = OBJECT_ID('api_token')
)
BEGIN
    CREATE UNIQUE INDEX UX_api_token_hash ON api_token (token_hash);
END
GO

IF NOT EXISTS (
    SELECT 1 FROM sys.indexes
    WHERE name = 'IX_api_token_username'
      AND object_id = OBJECT_ID('api_token')
)
BEGIN
    CREATE NONCLUSTERED INDEX IX_api_token_username ON api_token (username);
END
GO

SELECT COUNT(*) AS api_token_rows FROM api_token;
GO
