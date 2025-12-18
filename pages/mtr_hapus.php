<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];

    $sql = "SELECT id_schedule FROM db_dying.tbl_montemp WHERE id = ?";
    $params = [$modal_id];
    $cek = sqlsrv_query($con, $sql, $params);
    $r = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC);

    $sql = "SELECT no_mesin FROM db_dying.tbl_schedule WHERE id = ?";
    $params = [$r['id_schedule']];
    $cek1 = sqlsrv_query($con, $sql, $params);
    $r1 = sqlsrv_fetch_array($cek1, SQLSRV_FETCH_ASSOC);

    $sql = "DELETE FROM db_dying.tbl_montemp WHERE id = ?";
    $params = [$modal_id];
    $modal1 = sqlsrv_query($con, $sql, $params);

    if ($modal1) {
    sqlsrv_query($con, "UPDATE db_dying.tbl_schedule SET status='antri mesin' WHERE id = ?", [$r['id_schedule']]);
    sqlsrv_query($con, 
        "UPDATE db_dying.tbl_schedule SET status='antri mesin' 
         WHERE no_mesin = ? AND status = 'sedang jalan'",
        [$r1['no_mesin']]
    );
    echo "<script>
            swal({
                title: 'Data telah terhapus',
                text: 'Klik Ok untuk kembali',
                icon: 'success',
            }).then((result) => {
                if (result) {
                    window.location.href='?p=Monitoring-Tempelan';
                }
            });
          </script>";
    } else {
        echo "<script>
                swal({
                    title: 'Gagal Hapus',
                    text: 'Terjadi kesalahan saat menghapus data',
                    icon: 'error',
                }).then(() => {
                    window.location.href='?p=Monitoring-Tempelan';
                });
            </script>";
    }