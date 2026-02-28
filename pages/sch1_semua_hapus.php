<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

$sql = sqlsrv_query(
    $con,
    "SELECT a.id
     FROM db_dying.tbl_schedule a
     INNER JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule
     WHERE (
        a.[status] <> b.[status]
        OR (
            ISNULL(a.mc_from, '') = ''
            AND ISNULL(CAST(a.no_urut AS VARCHAR(50)), '') = ''
            AND ISNULL(CAST(a.no_mesin AS VARCHAR(50)), '') = ''
            AND a.[status] IN ('sedang jalan', 'antri mesin')
        )
     )"
);

if ($sql !== false) {
    while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $modal_id = isset($rowd['id']) ? (int)$rowd['id'] : 0;
        if ($modal_id <= 0) {
            continue;
        }

        $modal1 = sqlsrv_query(
            $con,
            "UPDATE db_dying.tbl_schedule SET [status] = 'selesai' WHERE id = ?",
            array($modal_id)
        );
        if ($modal1 !== false) {
            @sqlsrv_free_stmt($modal1);
        }

        $modal2 = sqlsrv_query(
            $con,
            "UPDATE db_dying.tbl_montemp SET [status] = 'selesai' WHERE id_schedule = ?",
            array($modal_id)
        );
        if ($modal2 !== false) {
            @sqlsrv_free_stmt($modal2);
        }
    }
    @sqlsrv_free_stmt($sql);
}

echo "<script>window.location='?p=Schedule-Cek';</script>";
