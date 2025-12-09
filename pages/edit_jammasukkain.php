<?php
    ini_set("error_reporting", 1);
    session_start();
    include("../koneksi.php");
    if ($_POST) {
        extract($_POST);
        $id             = mysqli_real_escape_string($con, $_POST['id']);
        $jammasukkain   = mysqli_real_escape_string($con, $_POST['jammasukkain'] . ' ' . $_POST['tglmasukkain']);
        $sqlupdate = mysqli_query($con, "UPDATE tbl_montemp 
                                            SET jammasukkain    = '$jammasukkain',
                                                tgl_buat        = '$jammasukkain',
                                                tgl_target      = ADDDATE( '$jammasukkain', INTERVAL '$_POST[target]' HOUR_MINUTE ),
                                                tgl_update      = now()
                                            WHERE
                                                id = '$id' 
                                            LIMIT 1");
        echo "<script>swal({
                title: 'Data berhasil diubah',   
                text: 'Klik Ok untuk kembali',
                type: 'success',
                }).then((result) => {
                if (result.value) {
                    window.location.href='?p=Monitoring-Tempelan'; 
                }
                });</script>";
    }
?>
