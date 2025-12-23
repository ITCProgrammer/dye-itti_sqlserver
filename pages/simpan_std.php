<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    $kode = strtoupper($_POST['kode']);
    $jns = $_POST['jenis'];
    $target = $_POST['target'];

    $sql = "INSERT INTO db_dying.tbl_std_jam (kode, jenis, target) VALUES (?, ?, ?)";
    $params = array($kode, $jns, $target);

    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo "<script>
                swal({
                    title: 'Berhasil!',
                    text: 'Data standard target berhasil disimpan.',
                    type: 'success'
                }).then(function() {
                    window.location = '?p=Std-Target';
                });
              </script>";
    } else {
        $errorMessage = "Gagal menyimpan data. Silakan coba lagi.";
        // Untuk debugging: error_log(print_r(sqlsrv_errors(), true));
        echo "<script>swal('Gagal!', " . json_encode($errorMessage) . ", 'error');</script>";
    }
}