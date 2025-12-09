<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
	extract($_POST);
	$id			= mysqli_real_escape_string($con, $_POST['id']);

	$stop   	= $_POST['tgl_stop'] . " " . $_POST['jam_stop'];
	$stop2   	= $_POST['tgl_stop2'] . " " . $_POST['jam_stop2'];
	$stop3   	= $_POST['tgl_stop3'] . " " . $_POST['jam_stop3'];
	$stop4   	= $_POST['tgl_stop4'] . " " . $_POST['jam_stop4'];

	$mulai  	= $_POST['tgl_mulai'] . " " . $_POST['jam_mulai'];
	$mulai2  	= $_POST['tgl_mulai2'] . " " . $_POST['jam_mulai2'];
	$mulai3  	= $_POST['tgl_mulai3'] . " " . $_POST['jam_mulai3'];
	$mulai4 	= $_POST['tgl_mulai4'] . " " . $_POST['jam_mulai4'];

	$sisa		= $_POST['sisa_waktu'];

	$qCek 		= mysqli_query($con, "SELECT * FROM `tbl_montemp` WHERE `id`='$id' LIMIT 1");
	$rCek 		= mysqli_fetch_array($qCek);
	$lama		= $rCek['sisa_waktu'];

	if ($_POST['tgl_mulai'] != "" or $_POST['jam_mulai'] != "") {
		// $qmulai = ", `tgl_mulai`='$mulai' , `tgl_target` = ADDDATE('$mulai', INTERVAL '$lama' HOUR_MINUTE ) ";
		$qmulai = "`tgl_mulai`='$mulai'";
	} else {
		$qmulai = "`sisa_waktu`='$sisa' ";
	}
	if ($_POST['tgl_mulai2'] != "" or $_POST['jam_mulai2'] != "") {
		// $qmulai = ", `tgl_mulai2`='$mulai' , `tgl_target` = ADDDATE('$mulai', INTERVAL '$lama' HOUR_MINUTE ) ";
		$qmulai2 = "`tgl_mulai2`='$mulai2'";
	} else {
		$qmulai2 = "`sisa_waktu`='$sisa' ";
	}
	if ($_POST['tgl_mulai3'] != "" or $_POST['jam_mulai3'] != "") {
		// $qmulai = ", `tgl_mulai3`='$mulai' , `tgl_target` = ADDDATE('$mulai', INTERVAL '$lama' HOUR_MINUTE ) ";
		$qmulai3 = "`tgl_mulai3`='$mulai3'";
	} else {
		$qmulai3 = "`sisa_waktu`='$sisa' ";
	}
	if ($_POST['tgl_mulai4'] != "" or $_POST['jam_mulai4'] != "") {
		// $qmulai = ", `tgl_mulai4`='$mulai' , `tgl_target` = ADDDATE('$mulai', INTERVAL '$lama' HOUR_MINUTE ) ";
		$qmulai4 = "`tgl_mulai4`='$mulai4'";
	} else {
		$qmulai4 = "`sisa_waktu`='$sisa' ";
	}
	$sqlupdate = mysqli_query($con, "UPDATE `tbl_montemp` SET 
											`ket_stopmesin` = '$_POST[ket_stopmesin]',
											`ket_stopmesin2` = '$_POST[ket_stopmesin2]',
											`ket_stopmesin3` = '$_POST[ket_stopmesin3]',
											`ket_stopmesin4` = '$_POST[ket_stopmesin4]',
											`tgl_stop`='$stop',
											`tgl_stop2`='$stop2',
											`tgl_stop3`='$stop3',
											`tgl_stop4`='$stop4',
											$qmulai,
											$qmulai2,
											$qmulai3,
											$qmulai4
											WHERE `id`='$id' LIMIT 1");
	if($sqlupdate){
		echo " <script>window.location='?p=Monitoring-Tempelan';</script>";
	}else{
		echo "UPDATE `tbl_montemp` SET 
		`ket_stopmesin` = '$_POST[ket_stopmesin]',
		`ket_stopmesin2` = '$_POST[ket_stopmesin2]',
		`ket_stopmesin3` = '$_POST[ket_stopmesin3]',
		`ket_stopmesin4` = '$_POST[ket_stopmesin4]',
		`tgl_stop`='$stop',
		`tgl_stop2`='$stop2',
		`tgl_stop3`='$stop3',
		`tgl_stop4`='$stop4',
		$qmulai,
		$qmulai2,
		$qmulai3,
		$qmulai4
		WHERE `id`='$id' LIMIT 1";
	}
}
