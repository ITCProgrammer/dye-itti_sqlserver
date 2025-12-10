<?php
date_default_timezone_set('Asia/Jakarta');
// $host="10.0.0.174";
// $username="ditprogram";
// $password="Xou@RUnivV!6";
// $db_name="TM";
// $connInfo = array( "Database"=>$db_name, "UID"=>$username, "PWD"=>$password);
// $conn     = sqlsrv_connect( $host, $connInfo);
// $con=mysqli_connect("10.0.0.10","dit","4dm1n","db_dying");
$cond=mysqli_connect("10.0.0.10","dit","4dm1n","db_qc");
// Koneksi SQL Server baru (dye-itti)
$hostSVR19    = "10.0.0.221";
$usernameSVR19 = "sa";
$passwordSVR19 = "Ind@taichen2024";
$dbnow_gdb     = "db_dying";

$db_dbnow_gdb = array(
    "Database" => $dbnow_gdb,
    "UID"      => $usernameSVR19,
    "PWD"      => $passwordSVR19,
);

$con = sqlsrv_connect($hostSVR19, $db_dbnow_gdb);

if ($con === false) {
    die(print_r(sqlsrv_errors(), true));
}
// SQL Server: database nowprd (migrated from MySQL)
$nowprdServer = "10.0.0.221";
$nowprdOptions = array(
    "Database" => "nowprd",
    "UID" => "sa",
    "PWD" => "Ind@taichen2024",
    "CharacterSet" => "UTF-8"
);
$con_nowprd = sqlsrv_connect($nowprdServer, $nowprdOptions);
if ($con_nowprd === false) {
    exit("SQL Server (nowprd) connection failed: " . print_r(sqlsrv_errors(), true));
}
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
    }

$hostname="10.0.0.21";
$database = "NOWPRD";
$user = "db2admin";
$passworddb2 = "Sunkam@24809";
$port="25000";
$conn_string = "DRIVER={IBM ODBC DB2 DRIVER}; HOSTNAME=$hostname; PORT=$port; PROTOCOL=TCPIP; UID=$user; PWD=$passworddb2; DATABASE=$database;";
$conn2 = db2_connect($conn_string,'', '');
if($conn2) {
}
else{
    exit("DB2 Connection failed");
    }


