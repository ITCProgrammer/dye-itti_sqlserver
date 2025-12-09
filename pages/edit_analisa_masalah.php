<?php
ini_set("error_reporting", 1);
if($_POST){ 
	extract($_POST);
	$id = mysqli_real_escape_string($cond,$_POST['id']);
	$awal= $_POST['awal'];
	$akhir=$_POST['akhir'];
	$analisa = mysqli_real_escape_string($cond,$_POST['analisa_masalah']);	
				$sqlupdate=mysqli_query($cond,"UPDATE `tbl_ncp_qcf_new` SET 
				`analisa_masalah`='$analisa'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Status-NCP-NEW&id=$id';</script>";
				//echo " <script>window.location.reload(window.history.go(-1));</script>";
				
		}
		

?>
