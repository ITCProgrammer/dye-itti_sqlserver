<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    $nama = strtoupper($_POST['nama']);
    $jab = $_POST['jabatan'];

    $sql = "INSERT INTO db_dying.tbl_staff (nama, jabatan) VALUES (?, ?)";
    $params = array($nama, $jab);
    $stmt = sqlsrv_query($con, $sql, $params);

    if ($stmt) {
        echo "<script>
                swal({
                    title: 'Berhasil!',
                    text: 'Data staff berhasil disimpan.',
                    type: 'success'
                }).then(function() {
                    window.location = '?p=Staff';
                });
              </script>";
    } else {
        echo "<script>swal('Gagal!', 'Gagal menyimpan data staff.', 'error');</script>";
    }
}