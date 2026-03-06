<?php
//include "../koneksi.php"; // koneksi ke database
require_once __DIR__ . "/../koneksi.php";

// cek data yang perlu diupdate
$sql_check = "
SELECT a.id
FROM db_dying.tbl_schedule a
INNER JOIN db_dying.tbl_montemp b 
    ON a.id = b.id_schedule
INNER JOIN db_dying.tbl_hasilcelup c 
    ON b.id = c.id_montemp
WHERE a.status = 'sedang jalan'
";

$result = sqlsrv_query($con, $sql_check);

if($result === false){
    die(print_r(sqlsrv_errors(), true));
}

$rows = [];
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    $rows[] = $row['id'];
}

if(count($rows) > 0){

    // update status
    $sql_update = "
    UPDATE a
    SET a.status = 'selesai'
    FROM db_dying.tbl_schedule a
    INNER JOIN db_dying.tbl_montemp b 
        ON a.id = b.id_schedule
    INNER JOIN db_dying.tbl_hasilcelup c 
        ON b.id = c.id_montemp
    WHERE a.status = 'sedang jalan'
    ";
    $update = sqlsrv_query($con, $sql_update);

    if($update === false){
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Update berhasil. Total schedule selesai: ".count($rows);

}else{

    echo "Tidak ada data yang perlu diupdate.";

}
?>