<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id 	= mysqli_real_escape_string($con,$_POST['id']);
	$shift 	= mysqli_real_escape_string($con,$_POST['shift']); 
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_montemp` SET 
				`g_shift`='$shift'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Monitoring-Tempelan';</script>";
						
		}
		

?>
