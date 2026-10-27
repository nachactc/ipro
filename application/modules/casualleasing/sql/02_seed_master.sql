-- =====================================================================
-- Modul Casual Leasing (CL) - data master awal
-- Idempoten: aman dijalankan ulang.
-- =====================================================================

-- ---------- Periode ----------
IF NOT EXISTS (SELECT 1 FROM dbo.cl_periode WHERE periode_id = '2026-10')
    INSERT INTO dbo.cl_periode (periode_id, periode_name, periode_start, periode_end, periode_isactive, createby, createdate)
    VALUES ('2026-10', 'OCTOBER 2026', '2026-10-01', '2026-10-31', 1, 'system', GETDATE());

-- ---------- Tipe lokasi ----------
IF NOT EXISTS (SELECT 1 FROM dbo.cl_tipe WHERE tipe_id = 'ATRIUM')
    INSERT INTO dbo.cl_tipe (tipe_id, tipe_name, tipe_order, tipe_isactive) VALUES ('ATRIUM', 'ATRIUM', 1, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_tipe WHERE tipe_id = 'KORIDOR')
    INSERT INTO dbo.cl_tipe (tipe_id, tipe_name, tipe_order, tipe_isactive) VALUES ('KORIDOR', 'KORIDOR', 2, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_tipe WHERE tipe_id = 'VACANT')
    INSERT INTO dbo.cl_tipe (tipe_id, tipe_name, tipe_order, tipe_isactive) VALUES ('VACANT', 'VACANT UNIT', 3, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_tipe WHERE tipe_id = 'OTHER')
    INSERT INTO dbo.cl_tipe (tipe_id, tipe_name, tipe_order, tipe_isactive) VALUES ('OTHER', 'OTHER', 4, 1);

-- ---------- Lokasi ----------
-- ATRIUM
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'ATRIUM' AND lokasi_code = 'LG')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('ATRIUM', 'LG', 'LG', 1, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'ATRIUM' AND lokasi_code = 'GF')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('ATRIUM', 'GF', 'GF', 2, 1);

-- KORIDOR
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'KORIDOR' AND lokasi_code = 'LG')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('KORIDOR', 'LG', 'LG', 1, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'KORIDOR' AND lokasi_code = 'GF A')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('KORIDOR', 'GF A', 'GF A', 2, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'KORIDOR' AND lokasi_code = 'GF B')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('KORIDOR', 'GF B', 'GF B', 3, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'KORIDOR' AND lokasi_code = 'F1')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('KORIDOR', 'F1', 'F1', 4, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'KORIDOR' AND lokasi_code = 'F2')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('KORIDOR', 'F2', 'F2', 5, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'KORIDOR' AND lokasi_code = 'F3')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('KORIDOR', 'F3', 'F3', 6, 1);

-- VACANT UNIT (kode lokasi tanpa kata VACANT; tipe sudah menunjukkan VACANT)
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'VACANT' AND lokasi_code = 'LG')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('VACANT', 'LG', 'LG', 1, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'VACANT' AND lokasi_code = 'GF')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('VACANT', 'GF', 'GF', 2, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'VACANT' AND lokasi_code = 'F1')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('VACANT', 'F1', 'F1', 3, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'VACANT' AND lokasi_code = 'F2')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('VACANT', 'F2', 'F2', 4, 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'VACANT' AND lokasi_code = 'F3')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('VACANT', 'F3', 'F3', 5, 1);

-- OTHER
IF NOT EXISTS (SELECT 1 FROM dbo.cl_lokasi WHERE tipe_id = 'OTHER' AND lokasi_code = 'ALL')
    INSERT INTO dbo.cl_lokasi (tipe_id, lokasi_code, lokasi_name, lokasi_order, lokasi_isactive) VALUES ('OTHER', 'ALL', 'Other', 1, 1);

-- ---------- PIC ----------
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'A')  INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('A', 'A', 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'G')  INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('G', 'G', 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'RJ') INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('RJ', 'RJ', 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'YP') INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('YP', 'YP', 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'D')  INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('D', 'D', 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'E')  INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('E', 'E', 1);
IF NOT EXISTS (SELECT 1 FROM dbo.cl_pic WHERE pic_id = 'S')  INSERT INTO dbo.cl_pic (pic_id, pic_name, pic_isactive) VALUES ('S', 'S', 1);

-- Tarif per m2 sudah dihapus. Budget diinput langsung per unit;
-- ARR dihitung otomatis di aplikasi (budget / NLA).
-- Kapasitas NLA lokasi (mis. Atrium) diisi lewat Master Lokasi.
