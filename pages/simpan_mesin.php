<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $note = mysqli_real_escape_string($con,$_POST['note']);
    $mesin = mysqli_real_escape_string($con,$_POST['no_mesin']);
    $kap = mysqli_real_escape_string($con,$_POST['kap']);
	$l_r = mysqli_real_escape_string($con,$_POST['l_r']);
	$kd = mysqli_real_escape_string($con,$_POST['kode']);
        $sqlupdate=mysqli_query($con,"INSERT INTO `tbl_mesin` SET
				`no_mesin`='$mesin',
				`l_r`='$l_r',
				`kapasitas`='$kap',
				`kode`='$kd',
				`ket`='$note'
				");
        echo " <script>window.location='?p=Mesin';</script>";
    }