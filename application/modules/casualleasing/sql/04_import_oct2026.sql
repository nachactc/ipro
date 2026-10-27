-- =====================================================================
-- Modul Casual Leasing - import data OCTOBER 2026 (120 baris dari Excel)
-- Sumber: docs/Template_CL_OCT_2026_CIBUBUR.xlsx
-- Nilai prospek = W1 + W2 + W3 + W4 (disimpan eksplisit agar konsisten).
-- Mapping W mengikuti posisi kolom tiap sheet: ATRIUM O:R, KORIDOR/VACANT N:Q, OTHER P:S.
-- Bila semua W kosong, total PROSPEK ditempatkan di W1 sebagai fallback.
-- Bila hanya satu kolom W terisi dan total PROSPEK berbeda (GFC 01A), total dipakai
-- di kolom W tersebut agar prospek = jumlah W.
-- Bila status = OCCUPIED tetapi masih ada W/prospek (kesalahan di Excel),
-- nilai tersebut dipindahkan ke occupied dan kolom W/prospek dikosongkan.
-- Untuk DB live yang sudah dikoreksi 22 Okt 2026, jangan jalankan file ini lagi;
-- gunakan menu Import mode Ganti bila perlu mengimpor ulang.
-- Jalankan setelah 01_schema (instalasi baru) atau setelah 05a (DB lama yang
-- belum punya kolom w1-w4).
-- Idempoten bila belum ada baris import yang diedit. Jika ada edit, transaksi
-- dibatalkan agar tidak membuat duplikat; gunakan menu Import mode Ganti bila perlu.
-- =====================================================================

SET NOCOUNT ON;
-- Wajib bila tabel memiliki filtered index (setelah 06).
SET ANSI_NULLS ON;
SET ANSI_PADDING ON;
SET ANSI_WARNINGS ON;
SET ARITHABORT ON;
SET CONCAT_NULL_YIELDS_NULL ON;
SET QUOTED_IDENTIFIER ON;
SET NUMERIC_ROUNDABORT OFF;
SET XACT_ABORT ON;
BEGIN TRAN;

DELETE FROM dbo.cl_unit
 WHERE periode_id = '2026-10' AND createby = 'import' AND modifyby IS NULL;

INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 1, N'ATRIUM', N'G', 82.50, N'OCCUPIED', N'METRO/SENTRA', N'WEEKLY', '2026-11-16', '2026-11-22', N'16-22 NOV 2026', 35662824.21, 30000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 2, N'ATRIUM', N'G', 82.50, N'OCCUPIED', N'METRO/SENTRA', N'WEEKLY', '2026-11-23', '2026-11-29', N'23-29 NOV 2026', 35662824.21, 30000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 3, N'ATRIUM', N'A', 165.00, N'VACANT', N'GEBYAR KULINER', N'WEEKLY', '2026-11-30', '2026-12-13', N'30 NOV - 13 DES 2026', 71325648.41, 0.00, 0.00, 0.00, 0.00, 100000000.00, 100000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 4, N'ATRIUM', N'YP', 131.25, N'OCCUPIED', N'DISDAGIN', N'WEEKLY', '2026-11-09', '2026-11-15', N'9-15 NOV 2026', 48212840.32, 25000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 5, N'ATRIUM', N'RJ', 131.25, N'OCCUPIED', N'WELLNESS', N'WEEKLY', '2026-11-16', '2026-11-22', N'16-22 NOV 2026', 48212840.32, 20000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 6, N'ATRIUM', N'RJ', 131.25, N'VACANT', N'WELLNESS', N'WEEKLY', '2026-11-23', '2026-11-29', N'23-29 NOV 2026', 48212840.32, 0.00, 0.00, 0.00, 0.00, 80000000.00, 80000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'ATRIUM', l.lokasi_id, 7, N'ATRIUM', N'RJ', 131.25, N'VACANT', N'GATSBY', N'WEEKLY', NULL, '2026-12-06', N'30 NIV - 6 DES 2026', 48212840.32, 0.00, 0.00, 0.00, 0.00, 100000000.00, 100000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'ATRIUM' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 1, N'SAMPING SNEAKER BRO', N'G', 4.00, N'OCCUPIED', N'SOX GALLERY', N'MONTHLY', '2026-11-09', '2026-12-08', N'9 NOV - 8 DES 2026', 4294947.11, 5000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 2, N'LG ADD12', N'YP', 6.00, N'VACANT', N'ZIPPO', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 8574132.49, 0.00, 0.00, 0.00, 0.00, 8000000.00, 8000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 3, N'ADD A6', N'RJ', 8.00, N'VACANT', N'MELAWAI/', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 11432176.66, 0.00, 0.00, 0.00, 8000000.00, 0.00, 8000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 4, N'LGi 40', N'G', 20.00, N'OCCUPIED', N'Luna''s', N'YEARLY', '2025-12-22', '2026-01-21', N'22 DES - 21 JAN 2026', 28580441.64, 20000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 5, N'LGC 38A', N'G', 10.00, N'OCCUPIED', N'TOSHIKO', N'3 MONTHS', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 14290220.82, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 6, N'LGC 38', N'G', 20.00, N'OCCUPIED', N'TOSHIKO', N'3 MONTHS', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 28580441.64, 28000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 7, N'LGi 37', N'YP', 20.00, N'OCCUPIED', N'Faeyza', N'3 MONTHS', '2026-11-25', '2026-12-24', N'25 NOV - 24 DEC 2026', 28580441.64, 25000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 8, N'LGi 36', N'YP', 20.00, N'OCCUPIED', N'MAMAYAYA', N'3 MONTHS', '2026-11-02', '2026-12-01', N'2 NOV - 1  DES 2026', 28580441.64, 30000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 9, N'Lgi-26', N'YP', 20.00, N'VACANT', N'PANAMA', N'MONTHLY', '2026-10-26', '2026-11-25', N'26 OCT - 25 NOV 2026', 28580441.64, 0.00, 0.00, 0.00, 15000000.00, 0.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 10, N'LGi 27', N'YP', 20.00, N'OCCUPIED', N'JMG', N'3 MONTHS', '2026-11-08', '2026-12-07', N'8 NOV - 7 DES 2026', 28580441.64, 36000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 11, N'LGC 11 - LGC 10', N'G', 9.00, N'OCCUPIED', N'DZMOON', N'3 MONTHS', '2026-12-12', '2027-01-11', N'12 DES - 11 JAN 2027', 12861198.74, 12500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 12, N'LGi 28', N'G', 20.00, N'RENEWAL', N'MANDALIKA', N'YEARLY', '2025-12-16', '2026-02-15', N'16 DES - 15 FEB 2026', 0.00, 100000000.00, 45000000.00, 0.00, 0.00, 0.00, 45000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 13, N'LG ADD B2', N'G', 6.00, N'OCCUPIED', N'CIRENG CORNER', N'6 MONTHS', '2026-11-18', '2026-12-17', N'18 NOV - 17 DES 2026', 8574132.49, 8500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 14, N'LG ADD B2', N'G', 6.00, N'RENEWAL', N'RISSOLES', N'6 MONTHS', '2026-12-17', '2027-01-16', N'17 DES - 16 JAN 2027', 8574132.49, 0.00, 0.00, 0.00, 0.00, 9200000.00, 9200000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 15, N'LG-B1', N'YP', 9.00, N'OCCUPIED', N'SUSU MBOK DARMI (BARU DP DI SEP,BARU ADA TERMIN LAGI DI DES)', N'YEARLY', NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 16, N'LGC 01', N'G', 12.00, N'RENEWAL', N'MOOI', N'6 MONTHS', '2025-11-29', '2026-10-28', N'29 NOV - 28 OCT 2026', 17148264.98, 0.00, 0.00, 0.00, 0.00, 6000000.00, 6000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 17, N'LGC 02', N'G', 12.00, N'OCCUPIED', N'ROUPING ROTI', N'6 MONTHS', '2026-12-02', '2026-12-01', N'2 DES - 1 DES 2026', 17148264.98, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 18, N'LGC 03', N'G', 6.00, N'RENEWAL', N'JAMBU BONBON', N'6 MONTHS', '2026-12-15', '2027-01-14', N'15 DES - 14 JAN 2027', 8574132.49, 0.00, 0.00, 0.00, 0.00, 8000000.00, 8000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 19, N'LGC 03', N'G', 6.00, N'OCCUPIED', N'WAFFEL', N'6 MONTHS', '2026-11-09', '2026-12-08', N'9 NOV - 8 DES 2026', 8574132.49, 6000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 20, N'LG-06', N'G', 12.00, N'VACANT', N'UMEDA', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 17148264.98, 0.00, 0.00, 0.00, 0.00, 12000000.00, 12000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 21, N'LGC 05', N'G', 12.00, N'RENEWAL', N'OXONE', N'6 MONTHS', '2025-12-16', '2026-01-15', N'16 DES - 15 JAN 2026', 17148264.98, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 22, N'LGC 07', N'G', 12.00, N'VACANT', N'ROVOS', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 17148264.98, 0.00, 0.00, 0.00, 19000000.00, 0.00, 19000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 23, N'LGC 08', N'G', 12.00, N'VACANT', N'ROVOS', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 17148264.98, 0.00, 0.00, 0.00, 19000000.00, 0.00, 19000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 24, N'LGC-09', N'YP', 6.00, N'VACANT', N'NAUGHTY TOYS/COWAY/TITAN', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 8574132.49, 0.00, 0.00, 0.00, 10000000.00, 0.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 25, N'LGL 04', N'YP', 15.00, N'OCCUPIED', N'KID CITY (REVENUE SHARING)', N'MONTHLY', '2026-11-01', '2026-11-30', N'1  NOV -30 NOV 2026', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 26, N'LGL 11', N'G', 12.00, N'OCCUPIED', N'MAHARANI', N'6 MONTHS', '2026-11-01', '2026-11-30', N'1  NOV -30 NOV 2026', 17148264.98, 15000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 27, N'LGL 12', N'G', 12.00, N'OCCUPIED', N'DUMDUM', N'YEARLY', '2026-12-09', '2027-01-08', N'9 DES - 8 JAN 2027', 17148264.98, 15000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 28, N'POCKET', N'A', 12.00, N'VACANT', N'SUMMARECON BOGOR', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12884841.33, 0.00, 0.00, 0.00, 0.00, 40000000.00, 40000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 29, N'POCKET', N'A', 12.00, N'VACANT', N'BUKIT CIMANGGU VILLA', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12884841.33, 0.00, 0.00, 0.00, 0.00, 50000000.00, 50000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 30, N'A1-A3', N'YP', 60.00, N'OCCUPIED', N'OTOMOTIIF', N'YEARLY', '2026-10-26', '2026-11-22', N'26 OCT - 22 NOV 2026', 64424206.63, 65000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 31, N'GF A5', N'G', 20.00, N'RENEWAL', N'DREAME', N'MONTHLY', '2025-12-19', '2026-01-18', N'19 DES - 18 JAN 2026', 21474735.54, 0.00, 0.00, 0.00, 0.00, 15765765.00, 15765765.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 32, N'GF-A6', N'G', 20.00, N'OCCUPIED', N'FLYCO', N'6 MONTHS', '2025-12-26', '2026-01-25', N'26 DEC - 25 JAN 2026', 21474735.54, 17000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 33, N'GF A7', N'G', 20.00, N'RENEWAL', N'HEAVENT SCENT', N'YEARLY', '2025-12-11', '2026-02-10', N'11 DEC - 10 FEB 2026', 21474735.54, 100000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 34, N'GF A8', N'G', 20.00, N'RENEWAL', N'HEAVENT SCENT', N'YEARLY', '2025-12-11', '2026-02-10', N'11 DEC - 10 FEB 2026', 21474735.54, 100000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF A';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 35, N'GFC 01', N'RJ', 20.00, N'RENEWAL', N'CELLINI', N'MONTHLY', '2026-10-12', '2026-11-11', N'12 OCT - 11 NOV 2026', 19959459.46, 0.00, 16666666.67, 0.00, 0.00, 0.00, 16666666.67, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 36, N'GFC 01A', N'RJ', 20.00, N'RENEWAL', N'CELLINI', N'MONTHLY', '2026-10-12', '2026-11-11', N'12 OCT - 11 NOV 2026', 19959459.46, 0.00, 0.00, 0.00, 16666666.67, 0.00, 16666666.67, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 37, N'GFC 02', N'RJ', 20.00, N'RENEWAL', N'CELLINI', N'MONTHLY', '2026-10-12', '2026-11-11', N'12 OCT - 11 NOV 2026', 19959459.46, 0.00, 16666666.67, 0.00, 0.00, 0.00, 16666666.67, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 38, N'GFC 02A', N'YP', 20.00, N'RENEWAL', N'BATIK ARNAWARNA', N'3 MONTHS', '2026-12-14', '2027-01-13', N'14 DES - 13 JAN 2027', 19959459.46, 0.00, 0.00, 0.00, 0.00, 13513513.51, 13513513.51, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 39, N'GFC 03', N'RJ', 20.00, N'VACANT', N'KALAWANGSA PARFUM', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 19959459.46, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 40, N'GFC 03A', N'G', 20.00, N'OCCUPIED', N'TYESO', N'YEARLY', '2026-01-02', '2026-02-01', N'2 JAN - 1 FEB 2026', 19959459.46, 20727273.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 41, N'GFC 05', N'YP', 20.00, N'OCCUPIED', N'CRUSITA', N'6 MONTHS', '2026-11-17', '2026-12-16', N'17 NOV - 16 DES 2026', 19959459.46, 13000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 42, N'GFC 05A', N'YP', 20.00, N'VACANT', N'BONAVIE', N'MONTHLY', '2026-11-16', '2026-12-15', N'16 NOV - 15 DES 2026', 19959459.46, 0.00, 0.00, 0.00, 30000000.00, 0.00, 30000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 43, N'GFC 06', N'A', 20.00, N'VACANT', N'DUBAI PARFUME BY APS', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 19959459.46, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 44, N'GFC 06 A', N'YP', 20.00, N'OCCUPIED', N'VERITES', N'3 MONTHS', '2026-11-01', '2026-11-30', N'1  NOV - 30 NOV 2026', 19959459.46, 17000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 45, N'GFC 06B', N'A', 20.00, N'VACANT', N'K WALK', N'MONTHLY', '2026-11-16', '2026-12-15', N'16 NOV - 15 DES 2026', 19959459.46, 0.00, 0.00, 0.00, 30000000.00, 0.00, 30000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'GF B';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 46, N'F1 09', N'YP', 20.00, N'RENEWAL', N'TAZBIYA', N'3 MONTHS', '2026-12-15', '2027-01-14', N'15 DES - 14 JAN 2027', 13470588.24, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 47, N'F1-08A', N'YP', 20.00, N'VACANT', N'LOZY', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 10000000.00, 0.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 48, N'F1 08', N'G', 20.00, N'RENEWAL', N'ZASKIA', N'6 MONTHS', '2026-12-27', '2027-01-26', N'27 DES - 26 JAN 2027', 13470588.24, 0.00, 0.00, 0.00, 0.00, 12000000.00, 12000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 49, N'F1i 03', N'G', 20.00, N'RENEWAL', N'KISSERA', N'6 MONTHS', '2026-11-13', '2026-12-12', N'13 NOV 26 - 12 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 50, N'F1i 05', N'YP', 20.00, N'RENEWAL', N'NOBBY', N'3 MONTHS', '2027-01-18', '2027-02-17', N'18 JAN - 17 FEB 2027', 13470588.24, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 51, N'F1i 05A', N'YP', 20.00, N'OCCUPIED', N'MAFAAZA', N'YEARLY', '2027-01-13', '2027-02-14', N'13 JAN - 14 FEB 2027', 13470588.24, 14400000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 52, N'F1 01', N'RJ', 20.00, N'RENEWAL', N'TRU FATMA', N'MONTHLY', '2026-11-08', '2026-12-07', N'8 NOV - 7 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 8018018.00, 0.00, 8018018.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 53, N'F1 02', N'G', 20.00, N'OCCUPIED', N'RODEO', N'6 MONTHS', '2027-01-14', '2027-02-13', N'14 JAN 26 - 13 FEB 2027', 13470588.24, 13000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 54, N'F1 03', N'G', 20.00, N'OCCUPIED', N'GREET NIGHT', N'6 MONTHS', '2026-11-07', '2026-12-06', N'7 NOV - 6 DES 2026', 13470588.24, 11000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 55, N'F1 03A', N'YP', 20.00, N'OCCUPIED', N'ERIGO', N'6 MONTHS', '2026-12-28', '2027-01-27', N'28 DEC - 27 JAN 2027', 13470588.24, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 59, N'F1 05', N'YP', 20.00, N'VACANT', N'ERSPRO', N'MONTHLY', '2026-11-14', '2026-12-14', N'14 NOV - 14 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 0.00, 9009009.00, 9009009.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 57, N'F-06A', N'YP', 20.00, N'VACANT', N'3 SECOND', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 56, N'F1 05 A', N'YP', 20.00, N'OCCUPIED', N'OPELLON', N'3 MONTHS', '2026-11-01', NULL, N'1  NOV - 31 NO V 2026', 13470588.24, 8000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 58, N'F1 06', N'YP', 20.00, N'OCCUPIED', N'MANZIL', N'3 MONTHS', NULL, NULL, N'17 NOV-16 DES', 13470588.24, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 60, N'F1-07', N'YP', 20.00, N'VACANT', N'HAMMER', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 61, N'F1-07 A', N'A', 20.00, N'VACANT', N'POLO', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 13470588.24, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 62, N'F2i 21', N'G', 20.00, N'RENEWAL', N'SAFARI SPIN', N'4 MONTHS', '2027-01-01', '2027-01-31', N'1 JAN - 31 JAN 2027', 12797169.81, 0.00, 0.00, 0.00, 0.00, 13000000.00, 13000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 63, N'F2i 11', N'YP', 10.00, N'OCCUPIED', N'PLAY N WIN', N'6 MONTHS', '2025-12-22', '2026-01-21', N'22 DES - 21 JAN 2026', 12797169.81, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 64, N'F2i 11', N'YP', 10.00, N'RENEWAL', N'GROLIER', N'MONTHLY', '2026-10-26', '2026-11-25', N'26 OCT - 25 NOV 2026', 25594339.62, 0.00, 0.00, 0.00, 5000000.00, 0.00, 5000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 65, N'F2i-12', N'YP', 20.00, N'OCCUPIED', N'ONIOLA', N'6 MONTHS', '2026-11-28', '2026-12-27', N'28 NOV - 27 DES 2026', 6398584.91, 5000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 66, N'F2i 15', N'A', 20.00, N'OCCUPIED', N'JETE', N'YEARLY', '2027-02-01', '2027-02-28', N'1 FEB - 28 FEB 2027', 6398584.91, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 67, N'F2i 16', N'A', 20.00, N'RENEWAL', N'QUADRAN', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12797169.81, 0.00, 0.00, 0.00, 7000000.00, 0.00, 7000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 68, N'F2i 17', N'YP', 40.00, N'OCCUPIED', N'NEOHAUS (REVENUE SHARING)', N'MONTHLY', NULL, NULL, NULL, 12797169.81, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 69, N'F2I-01', N'G', 10.00, N'OCCUPIED', N'FOOM', N'6 MONTHS', '2026-11-06', '2026-12-05', N'6 NOV - 5 DES 2026', 25594339.62, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 70, N'F2i 18', N'G', 20.00, N'VACANT', N'FANTASY LOLYPOP /COCOLELE', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 7038443.40, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 71, N'F2i 19', N'YP', 12.00, N'OCCUPIED', N'PERFECT RELAX', N'6 MONTHS', '2025-12-16', '2026-01-15', N'16 DES - 15 JAN 2026', 6398584.91, 12000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 72, N'F2i-20', N'G', 12.00, N'OCCUPIED', N'FATHARANI ACC', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12797169.81, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 73, N'F2i 23', N'YP', 8.00, N'RENEWAL', N'PERFECT RELAX', N'4 MONTHS', '2026-12-21', '2027-01-19', N'21 DES - 19 JAN 2027', 7678301.89, 0.00, 0.00, 0.00, 0.00, 6000000.00, 6000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 74, N'F2i-25', N'YP', 11.00, N'OCCUPIED', N'MIRACLE TOYS', N'3 MONTHS', '2026-12-08', '2027-01-07', N'8 DES - 7 JAN 2027', 7678301.89, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 75, N'F2i 27', N'YP', 15.00, N'OCCUPIED', N'PLAY WITH DINO', N'6 MONTHS', '2026-11-21', '2026-12-21', N'21  NOV - 21 DES 2026', 5118867.92, 9600000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 76, N'F2i-26', N'G', 10.00, N'OCCUPIED', N'PIJATKU', N'MONTHLY', '2026-12-01', '2026-12-31', N'1  DES - 31 DES 2026', 25594339.62, 15000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 77, N'F2i 05', N'YP', 20.00, N'OCCUPIED', N'FAEYZA', N'3 MONTHS', '2026-11-25', '2026-12-26', N'25 NOV - 26 DEC 2026', 9597877.36, 15000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 78, N'F2i 03', N'A', 40.00, N'VACANT', N'GRAMEDIA/PASAR LITERASI', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12797169.81, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 80, N'F2i-28', NULL, 20.00, N'RENEWAL', N'SVRG', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 25594339.62, 0.00, 0.00, 0.00, 0.00, 5000000.00, 5000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 81, N'F2i-28a', N'YP', 40.00, N'RENEWAL', N'SVRG', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 2559433.96, 0.00, 0.00, 0.00, 0.00, 5000000.00, 5000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 82, N'F2i 29', N'A', 20.00, N'VACANT', N'CASE NESIA', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12797169.81, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 83, N'F2i-29A', N'A', 20.00, N'VACANT', N'KIIP/ANKER', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12797169.81, 0.00, 0.00, 0.00, 0.00, 20000000.00, 20000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 84, N'F2i-30', N'A', 20.00, N'VACANT', N'PILLOWBOX', N'MONTHLY', '2026-11-26', '2026-12-25', N'26 NOV - 25 DES 2026', 12797169.81, 7500000.00, 18018018.02, 0.00, 0.00, 0.00, 18018018.02, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 85, N'F2i-31', N'YP', 20.00, N'VACANT', NULL, N'MONTHLY', NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 86, N'F2i-31A', N'YP', 20.00, N'VACANT', N'PACTHME', N'MONTHLY', '2026-10-26', '2026-11-25', N'26 OCT - 25 NOV 2026', 6398584.91, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 79, N'F2( kor Go FIT)', N'G', 4.00, N'OCCUPIED', N'ULTIFRESH', N'3 MONTHS', '2026-10-30', '2026-11-29', N'30 OCT - 29 NOV 2026', 12797169.81, 3500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 87, N'RAILLING', N'A', 20.00, N'VACANT', N'VR', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 12797169.81, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 88, N'F3', N'YP', 18.00, N'OCCUPIED', N'SELFIE TIME', N'YEARLY', NULL, NULL, NULL, 26030536.24, 21500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 89, N'F3', N'YP', 18.00, N'RENEWAL', N'SELFIE TIME', N'YEARLY', '2025-12-21', '2026-05-20', N'21 DES - 20 MEI 2026', 26030536.24, 0.00, 0.00, 0.00, 0.00, 132000000.00, 132000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 90, N'F3', N'G', 2.00, N'OCCUPIED', N'POKEMON VM', N'3 MONTHS', '2026-11-09', '2026-12-08', N'9 NOV - 8 DES 2026', 2892281.80, 2000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 91, N'F3', N'YP', 4.00, N'OCCUPIED', N'CATTON CANDY', N'6 MONTHS', '2026-10-29', '2026-11-28', N'29 OCT - 28 NOV 2026', 5784563.61, 5000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 92, N'F3', N'YP', 4.00, N'OCCUPIED', N'PIKA PIKU', N'MONTHLY', '2026-10-13', '2026-11-12', N'13 OCT - 12 NOV 2026', 5784563.61, 9009009.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'KORIDOR', l.lokasi_id, 93, N'F3', N'A', 10.00, N'VACANT', N'FUN CLAW', N'MONTHLY', '2026-11-09', '2026-12-08', N'9 NOV - 8 DES 2026', 14461409.02, 0.00, 0.00, 0.00, 10000000.00, 0.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'KORIDOR' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 1, N'LG 11', N'G', 6.00, N'OCCUPIED', N'NAD', N'6 MONTHS', '2026-12-01', '2026-12-31', N'1 DEC - 31  DES 2026', 2327292.76, 10000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 2, N'Lgi-01A', N'G', 8.00, N'OCCUPIED', N'MACARONI', N'6 MONTHS', '2026-12-01', '2026-12-31', N'1 DES - 31 DES 2026', 3103057.01, 10500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 3, N'Lgi 02', N'D', 8.00, N'OCCUPIED', N'TAHU GO', N'YEARLY', '2026-11-25', '2026-12-24', N'25 NOV - 24 DEC 2026', 3103057.01, 11500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 4, N'Lgi-02A', N'G', 6.00, N'OCCUPIED', N'GEMOY', N'3 MONTHS', '2026-11-20', '2026-12-19', N'20 NOV - 19 DES 2026', 2327292.76, 9000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 5, N'UNIX EX KOREAN 77', N'G', 119.00, N'OCCUPIED', N'PHOTOMATICS', N'6 MONTHS', '2026-01-01', '2026-01-31', N'1 JAN - 31 JAN 2026', 23800000.00, 23800000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'LG';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 6, N'GF FACILITY', N'RJ', 100.00, N'VACANT', N'HSI', N'MONTHLY', '2026-11-17', '2026-12-16', N'17 NOV - 16 DES 2026', 20000000.00, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 7, N'EX CHARLES AND KEITH', N'S', 148.00, N'VACANT', N'MALINDA', N'MONTHLY', '2026-10-20', '2026-11-19', N'20 OCT - 19 NOV 2026', 29600000.00, 0.00, 0.00, 0.00, 19980000.00, 0.00, 19980000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 8, N'GF FACILITY', N'E', 108.00, N'VACANT', N'SCANDIA', N'MONTHLY', '2026-11-17', '2026-12-16', N'17 NOV - 16 DES 2026', 21600000.00, 0.00, 0.00, 0.00, 0.00, 25000000.00, 25000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 9, N'G-58', N'E', 97.00, N'VACANT', N'SLEEP N CO', N'MONTHLY', '2026-11-09', '2026-12-10', N'9 NOV - 10DES 2026', 19400000.00, 0.00, 0.00, 0.00, 0.00, 25000000.00, 25000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'GF';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 10, N'EX LINA KARTIKA', N'RJ', 70.00, N'VACANT', N'SALEZONE', N'MONTHLY', '2026-11-26', '2026-12-15', N'26 NOV - 15 DES 2026', 14000000.00, 0.00, 0.00, 0.00, 0.00, 10000000.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 11, N'EX BENEUNDER', NULL, 88.00, N'VACANT', N'STUDIO TUI', N'MONTHLY', '2026-11-02', '2026-12-01', N'2 NOV - 1 DES 2026', 17600000.00, 0.00, 0.00, 0.00, 0.00, 15000000.00, 15000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'F1';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 12, N'EX MINISO', N'RJ', 208.00, N'VACANT', N'IDEMU BY VIVERE', N'MONTHLY', '2026-11-19', '2026-12-18', N'19 NOV - 18 DES 2026', 41600000.00, 0.00, 0.00, 0.00, 0.00, 20000000.00, 20000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 13, N'2-19D', N'E', 53.00, N'VACANT', N'TOMICA', N'MONTHLY', '2026-11-02', '2026-12-01', N'2 NOV - 1 DES 2026', 10600000.00, 0.00, 0.00, 0.00, 10000000.00, 0.00, 10000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'F2';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 14, N'UNIT EX WARDANI', N'E', 77.00, N'OCCUPIED', N'INA CRAFT', N'3 MONTHS', '2026-11-28', '2026-12-27', N'28 NOV - 27 DES 2026', 15400000.00, 7000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'VACANT', l.lokasi_id, 15, N'EX PANCIOUS', N'YP', 70.00, N'VACANT', N'DISDAGIN', N'MONTHLY', '2026-11-09', '2026-12-15', N'9 NOV - 15 DES 2026', 14000000.00, 0.00, 0.00, 0.00, 0.00, 5000000.00, 5000000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'VACANT' AND l.lokasi_code = N'F3';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'OTHER', l.lokasi_id, 1, N'F2 GUDANG', N'D', 14.00, N'RENEWAL', N'GUDANG DREAME', NULL, '2025-12-19', '2026-01-18', N'19 DES - 18 JAN 2026', 5430349.77, 0.00, 0.00, 0.00, 0.00, 1500000.00, 1500000.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'OTHER' AND l.lokasi_code = N'ALL';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'OTHER', l.lokasi_id, 2, N'PARKIRAN', N'D', 17.00, N'OCCUPIED', N'AUTOGLZE', NULL, '2026-12-01', '2026-12-31', N'1 DES - 31 DES 2026', 6593996.15, 17000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'OTHER' AND l.lokasi_code = N'ALL';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'OTHER', l.lokasi_id, 3, N'GUDANG B1', N'D', 14.00, N'VACANT', N'GUDANG TEAZI', NULL, '2027-10-18', '2027-11-17', N'18 OCT - 17 NOV 2027', 5430349.77, 15000000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'OTHER' AND l.lokasi_code = N'ALL';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'OTHER', l.lokasi_id, 4, N'F2 GUDANG', N'D', 14.00, N'RENEWAL', N'GUDANG FUJJI SNACK', NULL, '2026-11-11', '2027-02-09', N'11  NOV - 9 FEB 2027', 5430349.77, 7500000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'OTHER' AND l.lokasi_code = N'ALL';
INSERT INTO dbo.cl_unit (periode_id, tipe_id, lokasi_id, unit_no, unit_name, pic_id, nla, unit_status, tenant, periode_type, periode_start, periode_end, periode_text, budget, occupied, w1, w2, w3, w4, prospek, remarks, unit_isactive, createby, createdate)
SELECT '2026-10', N'OTHER', l.lokasi_id, 5, N'PARKIR', NULL, 0.00, N'VACANT', N'OLX', NULL, '2026-11-02', '2026-12-01', N'2 NOV - 1 DES 2026', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1, 'import', GETDATE()
FROM dbo.cl_lokasi l WHERE l.tipe_id = N'OTHER' AND l.lokasi_code = N'ALL';

-- validasi: pastikan jumlah baris = 120
IF (SELECT COUNT(*) FROM dbo.cl_unit WHERE periode_id = '2026-10' AND createby = 'import') <> 120
BEGIN
    ROLLBACK TRAN;
    RAISERROR('Import gagal: jumlah baris tidak sesuai. Kemungkinan ada baris hasil import yang sudah diedit; gunakan menu Import mode Ganti.', 16, 1);
END
ELSE
BEGIN
    COMMIT TRAN;
    PRINT 'Import selesai: 120 baris.';
END
