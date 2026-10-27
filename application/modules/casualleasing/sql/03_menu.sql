-- =====================================================================
-- Modul Casual Leasing (CL) - entri menu sidebar
-- 1 grup + menu: CL Budget, CL Unit, CL Import, Master PIC/Tipe/Lokasi/Periode.
-- Master Tarif sudah dihapus. Idempoten.
-- Rollback: lihat docs/ROLLBACK_casualleasing.md
-- =====================================================================

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

-- Bersihkan menu Master Tarif lama.
DELETE FROM dbo.master_userprogramweb WHERE program_id = 183022003;
DELETE FROM dbo.master_programweb WHERE program_id = 183022003;

-- Akses administrator.
INSERT INTO dbo.master_userprogramweb (username, group_id, program_id)
SELECT 'administrator', 183022, p.program_id
FROM dbo.master_programweb p
WHERE p.program_id IN (183022001, 183022002, 183022004, 183022005, 183022006, 183022007, 183022008)
  AND NOT EXISTS (
      SELECT 1 FROM dbo.master_userprogramweb u
      WHERE u.username = 'administrator' AND u.program_id = p.program_id
  );
