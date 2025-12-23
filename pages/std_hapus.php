<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
    $sql = "DELETE FROM db_dying.tbl_std_jam WHERE id = ?";
    $params = array($modal_id);
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo "<script>
                swal({
                    title: 'Berhasil!',
                    text: 'Data standard target berhasil dihapus.',
                    type: 'success'
                }).then(function() {
                    window.location = '?p=Std-Target';
                });
              </script>";
    } else {
        echo "<script>swal('Gagal!', 'Gagal menghapus data standard target.', 'error');</script>";
    }
