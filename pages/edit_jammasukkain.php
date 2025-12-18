<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

if ($_POST) {

    $id = $_POST['id'];
    $jammasukkain = $_POST['jammasukkain'] . ' ' . $_POST['tglmasukkain'];

    list($t_jam, $t_menit) = explode(":", $_POST['target']);
    $total_menit = ($t_jam * 60) + $t_menit;

    // SQL Server UPDATE
    $sql = "UPDATE db_dying.tbl_montemp
                SET 
                    jammasukkain = ?,
                    tgl_buat     = ?,
                    tgl_target   = DATEADD(MINUTE, ?, ?),
                    tgl_update   = GETDATE()
                WHERE id = ?
    ";

    $params = [
        $jammasukkain,
        $jammasukkain,
        $total_menit,
        $jammasukkain,
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
