<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
// Tampilkan peringatan jika ada query SQL Server yang gagal
function warnOnError($context){
	$errors = sqlsrv_errors(SQLSRV_ERR_ERRORS);
	if ($errors === null) {
		return;
	}
	$messages = array();
	foreach ($errors as $error) {
		$messages[] = isset($error["message"]) ? $error["message"] : "Unknown error";
	}
	$alert = addslashes($context . " error: " . implode(" | ", $messages));
	echo "<script>alert('".$alert."'); window.history.back();</script>";
	exit;
}
// Pastikan nilai numeric dikirim sebagai angka atau NULL agar tidak memicu konversi varchar->numeric
function toNumericOrNull($value){
	if ($value === null) {
		return null;
	}
	if (is_string($value)) {
		$value = trim($value);
		if ($value === "") {
			return null;
		}
	}
	if (is_numeric($value)) {
		return $value + 0; // cast ke int/float
	}
	return null;
}
function cekDesimal($angka){
	if ($angka === null) {
		return "";
	}
	if (is_string($angka)) {
		$angka = trim($angka);
		if ($angka === "") {
			return "";
		}
		if (strpos($angka, ":") !== false) {
			$parts = explode(":", $angka, 2);
			if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
				$jam = (int)$parts[0];
				$menit = (int)$parts[1];
				return $jam . ":" . str_pad((string)$menit, 2, "0", STR_PAD_LEFT);
			}
			return "";
		}
		if (!is_numeric($angka)) {
			return "";
		}
	}
	$angka = (float)$angka;
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

	// Paksa numeric jika kolom database bertipe angka
	$target    = toNumericOrNull($target);
	$urut      = toNumericOrNull($urut);
	$mcfrom    = toNumericOrNull($mcfrom);
	
	$query_old = "SELECT * FROM db_dying.tbl_schedule WHERE id = '$id'";
	$q_old 		 = sqlsrv_query($con, $query_old);
	if ($q_old === false) {
		warnOnError("Load schedule");
	}
  $d_old 		 = sqlsrv_fetch_array($q_old,SQLSRV_FETCH_ASSOC);

	// Ambil kapasitas mesin dari db_dying.tbl_mesin
	$sqlMesin   = "SELECT TOP 1 kapasitas FROM db_dying.tbl_mesin WHERE no_mesin = ?";
	$paramsMesin = array($mesin);
	$Qrycek     = sqlsrv_query($con, $sqlMesin, $paramsMesin);
	if ($Qrycek === false) {
		warnOnError("Load kapasitas mesin");
	}
	$rCek       = sqlsrv_fetch_array($Qrycek, SQLSRV_FETCH_ASSOC);
	$kapasitas  = toNumericOrNull($rCek ? $rCek['kapasitas'] : null);

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
	if ($sqlupdate === false) {
		warnOnError("Update schedule");
	}

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
	if ($sqlupdate1 === false) {
		warnOnError("Update montemp");
	}

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
	if ($sqlLog === false) {
		warnOnError("Log schedule");
	}

	echo " <script>window.location='?p=Schedule';</script>";
				
		}
		

?>
