<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
    
    $sql = "DELETE FROM db_dying.tbl_staff WHERE id = ?";
    $params = array($modal_id);
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo "<script>
                swal({
                    title: 'Berhasil!',
                    text: 'Data staff berhasil dihapus.',
                    type: 'success'
                }).then(function() {
                    window.location = '?p=Staff';
                });
              </script>";
    } else {
        echo "<script>swal('Gagal!', 'Gagal menghapus data staff.', 'error');</script>";
    }
