<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
	extract($_POST);
	$id 	= isset($_POST['id']) ? $_POST['id'] : '';
	$proses	= isset($_POST['a_proses']) ? $_POST['a_proses'] : '';
				$sqlupdate=sqlsrv_query($con,"UPDATE db_dying.tbl_hasilcelup SET 
				proses='$proses'
				WHERE id='$id'");
				echo " <script>window.location='?p=Hasil-Celup';</script>";
						
		}
		

?>
