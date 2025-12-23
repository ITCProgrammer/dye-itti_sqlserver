<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if ($_POST) {
    extract($_POST);
    $note = str_replace("'", "''", $_POST['note']);
    $mesin = str_replace("'", "''", $_POST['no_mesin']);
    $kap = str_replace("'", "''", $_POST['kap']);
    $l_r = str_replace("'", "''", $_POST['l_r']);
    $kd = str_replace("'", "''", $_POST['kode']);
    
    $sqlupdate = "INSERT INTO db_dying.tbl_mesin (no_mesin, l_r, kapasitas, kode, ket) VALUES (?, ?, ?, ?, ?)";
    $params = [$mesin, $l_r, $kap, $kd, $note];
    $update = sqlsrv_query($con, $sqlupdate, $params);

    if ($update) {
        echo "<script>
                swal({
                    title: 'Berhasil!',
                    text: 'Data mesin berhasil disimpan.',
                    type: 'success'
                }).then(function() {
                    window.location = '?p=Mesin';
                });
              </script>";
    } else {
        $error_message = "Gagal menyimpan data. Silakan coba lagi.";
        echo "<script>
                swal('Gagal!', " . json_encode($error_message) . ", 'error');
              </script>";
    }
}