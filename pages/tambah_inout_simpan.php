<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $sts = mysqli_real_escape_string($con,$_POST['sts']);
	$catatan = mysqli_real_escape_string($con,$_POST['catatan']);
	$tgl = mysqli_real_escape_string($con,$_POST['tgl']);
	
        $sqlupdate=mysqli_query($con,"INSERT INTO `tbl_dokumen_detail` SET
				`id_dokumen`='$_POST[id]',
				`sts`='$sts',
				`tgl_status`='$tgl',
				`catatan`='$catatan',
				`tgl_update`=now()
				");
        echo " <script>window.location='?p=Input-Dokumen';</script>";
    }