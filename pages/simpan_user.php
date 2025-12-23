<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if($_POST){ 
    $nama = $_POST['nama'];
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $repass = $_POST['re_password'];
    $level = $_POST['level'];
    $status = $_POST['status'];

    // Check if username exists
    $sqlCheck = "SELECT COUNT(*) as jml FROM db_dying.tbl_user WHERE username = ?";
    $paramsCheck = array($user);
    $stmtCheck = sqlsrv_query($con, $sqlCheck, $paramsCheck);
    
    if ($stmtCheck === false) {
        echo "<script>swal('Error!', 'Gagal memeriksa username.', 'error');</script>";
        exit;
    }

    $row = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);

    if ($row['jml'] > 0) {
        echo "<script>swal('Gagal!', 'Username sudah digunakan!', 'warning').then(function() { window.history.back(); });</script>";
    } else if ($pass != $repass) {
        echo "<script>swal('Gagal!', 'Password dan Re-Password tidak cocok!', 'warning').then(function() { window.history.back(); });</script>";
    } else {
        $sqlInsert = "INSERT INTO db_dying.tbl_user (nama, username, password, level, status, foto, dept, tgl_update) VALUES (?, ?, ?, ?, ?, 'avatar', 'DYE', GETDATE())";
        $paramsInsert = array($nama, $user, $pass, $level, $status);
        $stmtInsert = sqlsrv_query($con, $sqlInsert, $paramsInsert);

        if ($stmtInsert) {
            echo "<script>
                    swal({
                        title: 'Berhasil!',
                        text: 'Data user berhasil disimpan.',
                        type: 'success'
                    }).then(function() {
                        window.location = '?p=User';
                    });
                  </script>";
        } else {
            echo "<script>swal('Gagal!', 'Gagal menyimpan data user.', 'error');</script>";
        }
    }
}

?>