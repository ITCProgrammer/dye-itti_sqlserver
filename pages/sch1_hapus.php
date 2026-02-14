<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

$sql = sqlsrv_query($con, "
    SELECT a.id
    FROM db_dying.tbl_schedule a
    INNER JOIN db_dying.tbl_montemp b ON a.id=b.id_schedule
    WHERE ((NOT a.[status]=b.[status])
        OR (mc_from='' AND no_urut='' AND no_mesin='' AND (a.[status]='sedang jalan' OR a.[status]='antri mesin')))
");

while($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)){
    $modal_id = $rowd['id'];
    $modal1 = sqlsrv_query($con, "UPDATE db_dying.tbl_schedule SET [status]='selesai' WHERE id='$modal_id'");
    $modal1 = sqlsrv_query($con, "UPDATE db_dying.tbl_montemp SET [status]='selesai' WHERE id_schedule='$modal_id'");
}

echo "<script>window.location='?p=Schedule-Cek';</script>";
?>