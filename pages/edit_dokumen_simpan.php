<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $nama = mysqli_real_escape_string($con,$_POST['dok']);
	$nodok = mysqli_real_escape_string($con,$_POST['nodok']);
	$id = mysqli_real_escape_string($con,$_POST['id']);
        $sqlupdate=mysqli_query($con,"UPDATE `tbl_dokumen` SET
				`nama_dokumen`='$nama',
				`no_dokumen`='$nodok',
				`tgl_update`=now()
				WHERE id='$id'
				");
        echo " <script>window.location='?p=Input-Dokumen';</script>";
    }