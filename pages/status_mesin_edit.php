<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
if(isset($_POST['ubah'])){ 
	extract($_POST);
	//tangkap data array dari form
    $urut   = $_POST['no_urut'];
    $personil = $_POST['personil'];
    //foreach
    foreach ($urut as $urut_key => $urut_value) {
        // Ambil data urutan lama dari database
        $q_old = mysqli_query($con, "SELECT no_urut FROM tbl_schedule WHERE id = '$urut_key'");
        $d_old = mysqli_fetch_assoc($q_old);
        $no_urut_lama = $d_old['no_urut'];

        // Cek jika urutan berubah baru lakukan update
        if ($urut_value != $no_urut_lama) {
            $nama_personil = mysqli_real_escape_string($con, $personil[$urut_key]);

            $query = "UPDATE `tbl_schedule` 
                        SET `no_urut` =  '$urut_value',
                            `personil`=  '$nama_personil'
                        WHERE `id` = '$urut_key' LIMIT 1;";
            $result = mysqli_query($con, $query);

            if (!$result) {
                die('Gagal update: ' . mysqli_error($con));
            }else{
                echo " <script>window.location='?p=Schedule';</script>";
            }
        } else {
            echo " <script>window.location='?p=Schedule';</script>";
        }
    }
}elseif(isset($_POST['ubah_stdtarget'])){
    extract($_POST);
    //tangkap data array dari form
    $urut               = $_POST['no_urut'];
    $personil           = $_POST['personil'];
    $creationdatetime	= date('Y-m-d H:i:s');
    //foreach
    foreach ($urut as $urut_key => $urut_value) {
        $target = $_POST['target'][$urut_key];
        $nama_personil = mysqli_real_escape_string($con, $personil[$urut_key]);

        $query = "UPDATE `tbl_schedule` 
                    SET `target`  = '$target',
                        personil_stdtarget = '$nama_personil',
                        lastupdatetime_stdtarget = '$creationdatetime' 
                    WHERE `id` = '$urut_key' LIMIT 1 ;";
        $result = mysqli_query($con, $query);
    }
    
    if (!$result) {
        die ('cant update:' .mysqli_error($con));
    }else{
        echo " <script>window.location='?p=Schedule';</script>";
    }
}		
?>
