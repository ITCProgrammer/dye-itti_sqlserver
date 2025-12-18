<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

if ($_POST) {
    $id 	= $_POST['id'];
    $shift 	= $_POST['shift']; 

    $sql = "UPDATE db_dying.tbl_montemp
                SET 
					g_shift = ?
                WHERE id = ?
    ";

    $params = [
        $shift,
        $id
    ];

    // print_r($params);
    $sqlupdate = sqlsrv_query($con, $sql, $params);

    if ($sqlupdate) {
        echo "<script>
                swal({
                    title: 'Data berhasil diubah',
                    text: 'Klik Ok untuk kembali',
                    icon: 'success'
                }).then((result) => {
                    if (result) {
                        window.location.href='?p=Monitoring-Tempelan';
                    }
                });
              </script>";
    } else {
        $err = print_r(sqlsrv_errors(), true);
        echo "<script>
                swal({
                    title: 'Gagal Update',
                    text: 'Error SQL: " . addslashes($err) . "',
                    icon: 'error'
                });
              </script>";
    }
}
?>
