<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $sts = mysqli_real_escape_string($con,$_POST['sts']);
	$id  = mysqli_real_escape_string($con,$_POST['id']);
        $sqlupdate=mysqli_query($con,"UPDATE `tbl_dokumen` SET
				`sts`='$sts',
				`tgl_update`=now()
				WHERE id='$id'
				");
        echo " <script>window.location='?p=Input-Dokumen';</script>";
    }