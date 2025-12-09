<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id = mysqli_real_escape_string($con,$_POST['id']);
	$jenis = mysqli_real_escape_string($con,strtoupper($_POST['jenis'])); 
	$target = mysqli_real_escape_string($con,$_POST['target']); 
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_std_jam` SET 
				`jenis`='$jenis', 
				`target`='$target'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Std-Target';</script>";
						
		}
		

?>
