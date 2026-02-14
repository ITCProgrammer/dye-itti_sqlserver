<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
	$sql= sqlsrv_query($con,"SELECT a.id FROM  db_dying.tbl_schedule a
INNER JOIN  db_dying.tbl_montemp b ON a.id=b.id_schedule 
WHERE ((not a.`status`=b.`status`) or (mc_from='' and no_urut='' and no_mesin='' and (a.`status`='sedang jalan' or a.`status`='antri mesin')))");	
  while($rowd=sqlsrv_fetch_array($sql)){
    $modal_id=$rowd['id'];
    $modal1= sqlsrv_query($con,"UPDATE  db_dying.tbl_schedule SET `status`='selesai' WHERE id='$modal_id' ");
	$modal1= sqlsrv_query($con,"UPDATE  db_dying.tbl_montemp SET `status`='selesai' WHERE id_schedule='$modal_id'");    
  }
echo "<script>window.location='?p=Schedule-Cek';</script>";
