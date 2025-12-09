<?php
 //Memanggil conn.php yang telah kita buat sebelumnya
 include 'koneksi.php';

 $prod_order    = $_GET['prod_order'];
 $group_number  = $_GET['group_number'];
 // Syntax MySql untuk melihat semua record yang
 $sql = "SELECT
            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
            TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
            TRIM(SUFFIXCODE) AS SUFFIXCODE
        FROM
            PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
        WHERE
            PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$prod_order'
            AND PRODUCTIONRESERVATION.GROUPLINE = '$group_number'
        ORDER BY
            PRODUCTIONRESERVATION.GROUPLINE ASC";
  
 //Execetute Query diatas
 $query = db2_exec($conn2, $sql);
 $dt    = db2_fetch_assoc($query);

    //Menampung data yang dihasilkan
    $json = array(
        'SUFFIX_CODE'    => $dt['SUFFIXCODE']
    );
 
 //Merubah data kedalam bentuk JSON
 header('Content-Type: application/json');
 echo json_encode($json);
