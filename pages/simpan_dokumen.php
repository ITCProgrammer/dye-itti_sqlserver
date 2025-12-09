<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $catatan = mysqli_real_escape_string($con,$_POST['catatan']);
    $nodok = mysqli_real_escape_string($con,$_POST['nodok']);
    $dok = mysqli_real_escape_string($con,$_POST['dok']);
        $sqlupdate=mysqli_query($con,"INSERT INTO `tbl_dokumen` SET
				`no_dokumen`='$nodok',
				`nama_dokumen`='$dok',
				`catatan`='$catatan',
				`tgl_buat`=now(),
				`tgl_update`=now()
				");
        echo " <script>window.location='?p=Input-Dokumen';</script>";
    }