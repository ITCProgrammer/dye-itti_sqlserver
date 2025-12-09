<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id			= mysqli_real_escape_string($con,$_POST['id']);
	$kap		= mysqli_real_escape_string($con,$_POST['kap']); 
	$l_r		= mysqli_real_escape_string($con,$_POST['l_r']);
	$kd			= mysqli_real_escape_string($con,$_POST['kode']);
	$nomesin	= mysqli_real_escape_string($con,$_POST['no_mesin']);
	$note 		= mysqli_real_escape_string($con,$_POST['note']); 
	$sqlupdate	= mysqli_query($con,"UPDATE `tbl_mesin` SET 
									`kapasitas`='$kap', 
									`l_r`='$l_r',
									`kode`='$kd',
									`ket`='$note',
									`no_mesin`='$nomesin'
									WHERE `id`='$id' LIMIT 1");
									echo " <script>window.location='?p=Mesin';</script>";
						
		}
		

?>
