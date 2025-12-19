<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
function cekDesimal($angka){
	$bulat=round($angka);
	if($bulat>$angka){
		$jam=$bulat-1;
		$waktu=$jam.":30";
	}else{
		$jam=$bulat;
		$waktu=$jam.":00";
	}
	return $waktu;
}
if($_POST){ 
	// Ambil nilai dari POST tanpa mysqli_*, gunakan parameterized query SQL Server
	$id        = isset($_POST['id']) ? $_POST['id'] : '';
	$urut      = isset($_POST['no_urut']) ? $_POST['no_urut'] : '';
	$ketkain   = isset($_POST['ket_kain']) ? $_POST['ket_kain'] : '';
	$ket       = isset($_POST['ket']) ? $_POST['ket'] : '';
	$personil  = isset($_POST['personil']) ? $_POST['personil'] : '';
	$mesin     = isset($_POST['no_mesin']) ? $_POST['no_mesin'] : '';
	$mcfrom    = isset($_POST['mc_from']) ? $_POST['mc_from'] : '';
	$proses    = isset($_POST['proses']) ? $_POST['proses'] : '';
	$target    = isset($_POST['target']) ? $_POST['target'] : 0;
	$resep     = isset($_POST['no_resep']) ? $_POST['no_resep'] : '';
	$resep2    = isset($_POST['no_resep2']) ? $_POST['no_resep2'] : '';
	$status    = isset($_POST['status']) ? $_POST['status'] : '';

	$target1   = cekDesimal($target);

	$kk_kestabilan = (isset($_POST['kk_kestabilan']) && $_POST['kk_kestabilan'] == "1") ? "1" : "0";
	$kk_normal     = (isset($_POST['kk_normal']) && $_POST['kk_normal'] == "1") ? "1" : "0";

	$user_id   = $_SESSION['nama10']; 
	$getdate   = date('Y-m-d H:i:s'); 
	$remote_add= $_SERVER['REMOTE_ADDR'];
	
	$query_old = "SELECT * FROM db_dying.tbl_schedule WHERE id = '$id'";
	$q_old 		 = sqlsrv_query($con, $query_old);
  $d_old 		 = sqlsrv_fetch_array($q_old,SQLSRV_FETCH_ASSOC);

	// Ambil kapasitas mesin dari db_dying.tbl_mesin
	$sqlMesin   = "SELECT TOP 1 kapasitas FROM db_dying.tbl_mesin WHERE no_mesin = ?";
	$paramsMesin = array($mesin);
	$Qrycek     = sqlsrv_query($con, $sqlMesin, $paramsMesin);
	$rCek       = sqlsrv_fetch_array($Qrycek, SQLSRV_FETCH_ASSOC);
	$kapasitas  = $rCek ? $rCek['kapasitas'] : null;

	// Bangun query update tbl_schedule (db_dying) dengan parameter
	$sqlUpdate = "UPDATE db_dying.tbl_schedule SET 
				no_mesin = ?,
				kapasitas = ?,
				mc_from = ?,
				target = ?,
				proses = ?,
				no_urut = ?,
				no_sch = ?,
				no_resep = ?,
				no_resep2 = ?,
				ket_kain = ?,
				ket_status = ?,
				kk_kestabilan = ?,
		 	 	kk_normal = ?,
				personil = ?";

	$paramsUpdate = array(
		$mesin,
		$kapasitas,
		$mcfrom,
		$target,
		$proses,
		$urut,
		$urut,
		$resep,
		$resep2,
		$ketkain,
		$ket,
		$kk_kestabilan,
		$kk_normal,
		$personil
	);

	if ($status != "") {
		$sqlUpdate      .= ", status = ?";
		$paramsUpdate[]  = $status;
	}

	$sqlUpdate     .= " WHERE id = ?";
	$paramsUpdate[] = $id;

	$sqlupdate = sqlsrv_query($con, $sqlUpdate, $paramsUpdate);

	// Hitung menit dari target1 (format H:MM) untuk DATEADD
	$minutesToAdd = 0;
	if (!empty($target1)) {
		$parts = explode(":", $target1);
		if (count($parts) === 2) {
			$hours   = (int)$parts[0];
			$minutes = (int)$parts[1];
			$minutesToAdd = $hours * 60 + $minutes;
		}
	}

	// Update tgl_target di db_dying.tbl_montemp bila ada
	$sqlUpdateMon = "UPDATE db_dying.tbl_montemp
					 SET tgl_target = DATEADD(MINUTE, ?, tgl_buat)
					 WHERE id_schedule = ?";
	$paramsMon    = array($minutesToAdd, $id);
	$sqlupdate1   = sqlsrv_query($con, $sqlUpdateMon, $paramsMon);

	$query_log 		= "INSERT INTO db_dying.tbl_log_mc_schedule (
											id_schedule,
											nodemand,   
											nokk,       
											no_mc,      
											no_urut,    
											no_sch,     
											user_update,
											date_update,
											ip_update,  
											col_update) VALUES(?,?,?,?,?,?,?,?,?,'UPDATE_SCHEDULE' )";
	$params_log = [$id, $d_old['nodemand'], $d_old['nokk'], $mesin, 
									$urut, $urut, $user_id, $getdate, $remote_add];
	$sqlLog 	  	= sqlsrv_query($con, $query_log, $params_log);

	echo " <script>window.location='?p=Schedule';</script>";
				
		}
		

?>
