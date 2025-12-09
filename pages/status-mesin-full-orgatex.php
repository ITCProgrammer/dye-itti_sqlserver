<?php
ini_set("error_reporting", 1);
session_start();
include"./../koneksiORGATEX.php";
include"./../koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <meta charset="utf-8">
          
            <title>Status Mesin Dyeing Bawah KNT</title>
            <meta name="description" content="Figma htmlGenerator">
            <meta name="author" content="htmlGenerator">
<!--			<meta http-equiv="refresh" content="10">  -->
            
            <link rel="stylesheet" href="styles_bawah_knt.css">              
            <style>
              /*
                Figma Background for illustrative/preview purposes only.
                You can remove this style tag with no consequence
              */
              body {background: #FFFFFF; }
				
        		.big-text {
            	font-size: 27px; /* Menggunakan em, px, atau rem sesuai kebutuhan */
				border: 2px solid #000; /* Border dengan ketebalan 2px dan warna hitam */
            	padding: 0px; /* Ruang di dalam border */
            	width: fit-content; /* Ukuran konten agar pas dengan teks */
				border-radius: 10px; /* Membuat sudut border melengkung */	
        		}
				.medium-text {
            	font-size: 14px; /* Menggunakan em, px, atau rem sesuai kebutuhan */
				border: 2px solid #000; /* Border dengan ketebalan 2px dan warna hitam */
            	padding: 0px; /* Ruang di dalam border */
            	width: fit-content; /* Ukuran konten agar pas dengan teks */
				border-radius: 5px; /* Membuat sudut border melengkung */	
        		}
				.small-text {
            	font-size: 11px; /* Menggunakan em, px, atau rem sesuai kebutuhan */
				border: 2px solid #000; /* Border dengan ketebalan 2px dan warna hitam */
            	padding: 0px; /* Ruang di dalam border */
            	width: fit-content; /* Ukuran konten agar pas dengan teks */
				border-radius: 3px; /* Membuat sudut border melengkung */	
        		}
				.xsmall-text {
            	font-size: 9px; /* Menggunakan em, px, atau rem sesuai kebutuhan */
				border: 1px solid #000; /* Border dengan ketebalan 2px dan warna hitam */
            	padding: 0px; /* Ruang di dalam border */
            	width: fit-content; /* Ukuran konten agar pas dengan teks */
				border-radius: 1px; /* Membuat sudut border melengkung */	
        		}
				.round-button {
				width: 30px; /* Lebar tombol */
				height: 30px; /* Tinggi tombol, sama dengan lebar agar berbentuk bulat */
				background: linear-gradient(45deg, #ff0000, #ff4d4d); /* Gradien merah */
				border: 3px solid #000; /* Border hitam dengan ketebalan 3px */
				border-radius: 50%; /* Membuat bentuk bulat sempurna */
				color: white; /* Warna teks di dalam tombol */
				font-size: 12px; /* Ukuran font */
				cursor: pointer; /* Mengubah kursor menjadi pointer saat diarahkan ke tombol */
				text-align: center; /* Memposisikan teks di tengah */
				line-height: 50px; /* Menyejajarkan teks secara vertikal */
				animation: blink 1s infinite; /* Menambahkan animasi blink */
				}
				.round-icon {
				font-size: 20px; /* Ukuran ikon lebih besar */
            	color: #ff0000; /* Warna merah untuk ikon */
				font-weight: bold; /* Membuat ikon bold */	
            	animation: blink 1s infinite; /* Animasi berkedip */
				}
				.medium-round-icon {
				font-size: 16px; /* Ukuran ikon lebih besar */
            	color: #ff0000; /* Warna merah untuk ikon */
				font-weight: bold; /* Membuat ikon bold */	
            	animation: blink 1s infinite; /* Animasi berkedip */
				}
				.small-round-icon {
				font-size: 11px; /* Ukuran ikon lebih besar */
            	color: #ff0000; /* Warna merah untuk ikon */
				font-weight: bold; /* Membuat ikon bold */	
            	animation: blink 1s infinite; /* Animasi berkedip */
				}
				.xsmall-round-icon {
				font-size: 9px; /* Ukuran ikon lebih besar */
            	color: #ff0000; /* Warna merah untuk ikon */
				font-weight: bold; /* Membuat ikon bold */	
            	animation: blink 1s infinite; /* Animasi berkedip */
				}
				/* Animasi blink */
				@keyframes blink {
					0%, 100% {
						opacity: 1; /* Penuh (tidak transparan) */
					}
					50% {
						opacity: 0; /* Transparan di tengah-tengah */
					}
				}
            </style>
			<link rel="stylesheet" href="./../bower_components/bootstrap/dist/css/bootstrap.min.css">
			<!-- Font Awesome -->
			<link rel="stylesheet" href="./../bower_components/font-awesome/css/font-awesome.min.css">
			<!-- Ionicons -->
			<link rel="stylesheet" href="./../bower_components/Ionicons/css/ionicons.min.css">
			<!-- Theme style -->
			<link rel="stylesheet" href="./../dist/css/AdminLTE.min.css">
			<!-- toast CSS -->
			<link href="./../bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
			<!-- DataTables -->
			<link rel="stylesheet" href="./../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
			<!-- bootstrap datepicker -->
			<link rel="stylesheet" href="./../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
			<link rel="stylesheet" href="./../dist/css/skins/skin-purple.min.css">
			<link rel="icon" type="image/png" href="./../dist/img/index.ico">
          	<script>
			// Fungsi untuk melakukan refresh ke halaman baru
			setTimeout(function() {
				window.location.href = "status-mesin-full-orgatex-dye-bawah.php"; // Ganti dye 01 dengan URL tujuan yang diinginkan
			}, 10000); // 10000 ms = 10 detik
    	  	</script>
          </head>
<?php
function NoMesin($mc)
{
	// Menghubungkan ke database
    include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
    $sql = "SELECT (Case When ms.OnlineState = 1 Then 'ON' When ms.OnlineState = 0 Then 'OFF' End) as [Online State], 
(Case When ms.RunState = 1 Then 'No Batch' When ms.RunState = 2 Then 'Batch Selected'
When ms.RunState = 3 Then 'Batch Running' When ms.RunState = 4 Then 'Controller Stopped' 
When ms.RunState = 5 Then 'Manual Operation' When ms.RunState = 6 Then 'Finished' End) as [Run State] FROM MachineStatus ms WHERE NOT (ms.RunState='1' OR ms.RunState='2') AND ms.Machine = ?";

    // Menyiapkan statement dengan parameter
    $params = array($mc); // Menyimpan parameter MachineCode
    $stmt = sqlsrv_query($connORG, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Mengambil hasil query
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); 
	
	if ($row['Run State']=='No Batch'){
		$warnaMc="";	
	}else if($row['Run State']=='Batch Running'){	
		$warnaMc="_r";		
	}else if($row['Run State']=='Controller Stopped'){	
		$warnaMc="_s";
	}else{		
		$warnaMc="";
	}
			
	
    // Tutup koneksi
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($connORG);
	 
    return $warnaMc;
}
	function McConnect($mc)
	{
		// Menghubungkan ke database
    include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
    $sql = "SELECT (Case When ms.OnlineState = 1 Then 'ON' When ms.OnlineState = 0 Then 'OFF' End) as [Online State], 
(Case When ms.RunState = 1 Then 'No Batch' When ms.RunState = 2 Then 'Batch Selected'
When ms.RunState = 3 Then 'Batch Running' When ms.RunState = 4 Then 'Controller Stopped' 
When ms.RunState = 5 Then 'Manual Operation' When ms.RunState = 6 Then 'Finished' End) as [Run State] FROM MachineStatus ms WHERE NOT (ms.RunState='1' OR ms.RunState='2') AND ms.Machine = ?";

    // Menyiapkan statement dengan parameter
    $params = array($mc); // Menyimpan parameter MachineCode
    $stmt = sqlsrv_query($connORG, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Mengambil hasil query
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); 
	
	if ($row['Online State']=='ON'){
		$CMc="round-button";
	}else if ($row['Online State']=='OFF'){
		$CMc="";	
	}else{	
		$CMc="";
	}
			
	
    // Tutup koneksi
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($connORG);
	 
    return $CMc;

	}
	function Suhu($mc)
	{
		// Menghubungkan ke database
    include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
    $sql = "SELECT (ms.InfoWord1/66.6) as [Temperature] FROM MachineStatus ms WHERE ms.RunState='3' AND ms.Machine = ?";

    // Menyiapkan statement dengan parameter
    $params = array($mc); // Menyimpan parameter MachineCode
    $stmt = sqlsrv_query($connORG, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Mengambil hasil query
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); 
		
	$SHMc=round($row['Temperature'],1);			
	
    // Tutup koneksi
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($connORG);
	 
    return $SHMc;

	}

	function Waktu($mc,$size){
	// Menghubungkan ke database
    include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data Run Time dari tabel MachineStatus
    $sql = "SELECT 
           FLOOR(TimeToEnd / 60) AS Hours,
           TimeToEnd % 60 AS Minutes
        FROM MachineStatus 
        WHERE Machine = ?";

    // Menyiapkan statement dengan parameter
    $params = array($mc); // Menyimpan parameter MachineCode
    $stmt = sqlsrv_query($connORG, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Mengambil hasil query
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		
    // Tutup koneksi
    sqlsrv_free_stmt($stmt);
	
    sqlsrv_close($connORG);	
	
	if(strlen(trim($row['Hours']))==1){
		$jam="0".$row['Hours'];
	}else{
		$jam=$row['Hours'];
	}
	if(strlen(trim($row['Minutes']))==1){
		$menit="0".$row['Minutes'];
	}else{
		$menit=$row['Minutes'];
	}	
	if($row['Hours']==0 and $row['Minutes']==0){
		$wkt="";
	}else{
		if($size==1){
		$wkt="<strong><font class='big-text'>".$jam.":".$menit."</font></strong>";
		}else if($size==2){
		$wkt="<strong><font class='medium-text'>".$jam.":".$menit."</font></strong>";
		}else if($size==3){
		$wkt="<strong><font class='small-text'>".$jam.":".$menit."</font></strong>";
		}else if($size==4){
		$wkt="<strong><font class='xsmall-text'>".$jam.":".$menit."</font></strong>";
		}
		
	}
    return $wkt; // Kembalikan nilai DyelotRefNo saja		
    }

?>          
          <body>
            <div class=e72_204>
				<a href="#"><div id="1449" class="e72_144<?php echo NoMesin("1449"); ?> detail_status"></div></a>
				<a href="#"><div class="e72_145"></div></a>
				<a href="#"><div class="e72_146"></div></a>
				<div  class="e72_193"></div>
				<a href="#"><div id="1449" class="e72_147<?php echo NoMesin("1449"); ?> detail_status"><?php echo Waktu("1449","2"); ?><?php $suhu=Suhu("1449"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1419" class="e72_148<?php echo NoMesin("1419"); ?> detail_status"><?php echo Waktu("1419","2"); ?><?php $suhu=Suhu("1419"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1484" class="e72_149<?php echo NoMesin("1484"); ?> detail_status"><?php echo Waktu("1484","2"); ?><?php $suhu=Suhu("1484"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1412" class="e72_156<?php echo NoMesin("1412"); ?> detail_status"><?php echo Waktu("1412","2"); ?><?php $suhu=Suhu("1412"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1118" class="e72_154<?php echo NoMesin("1118"); ?> detail_status"><?php echo Waktu("1118","2"); ?><?php $suhu=Suhu("1118"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1457" class="e72_157<?php echo NoMesin("1457"); ?> detail_status"><?php echo Waktu("1457","3"); ?><?php $suhu=Suhu("1457"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1483" class="e72_158<?php echo NoMesin("1483"); ?> detail_status"></div></a>
				<a href="#"><div id="1454" class="e72_159<?php echo NoMesin("1454"); ?> detail_status"><?php echo Waktu("1454","3"); ?><?php $suhu=Suhu("1454"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1478" class="e72_160<?php echo NoMesin("1478"); ?> detail_status"><?php echo Waktu("1478","4"); ?><?php $suhu=Suhu("1478"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1477" class="e72_161<?php echo NoMesin("1477"); ?> detail_status"><?php echo Waktu("1477","4"); ?><?php $suhu=Suhu("1477"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1476" class="e72_162<?php echo NoMesin("1476"); ?> detail_status"><?php echo Waktu("1482","4"); ?><?php $suhu=Suhu("1482"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1482" class="e72_164<?php echo NoMesin("1482"); ?> detail_status"><?php echo Waktu("1482","4"); ?><?php $suhu=Suhu("1482"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1475" class="e72_163<?php echo NoMesin("1475"); ?> detail_status"><?php echo Waktu("1475","4"); ?><?php $suhu=Suhu("1475"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1481" class="e72_165<?php echo NoMesin("1481"); ?> detail_status"><?php echo Waktu("1481","4"); ?><?php $suhu=Suhu("1481"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1479" class="e72_167<?php echo NoMesin("1479"); ?> detail_status"><?php echo Waktu("1479","4"); ?><?php $suhu=Suhu("1479"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1480" class="e72_166<?php echo NoMesin("1480"); ?> detail_status"><?php echo Waktu("1480","4"); ?><?php $suhu=Suhu("1480"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1455" class="e72_168<?php echo NoMesin("1455"); ?> detail_status"><?php echo Waktu("1455","3"); ?><?php $suhu=Suhu("1455"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1467" class="e72_171<?php echo NoMesin("1467"); ?> detail_status"><?php echo Waktu("1467","3"); ?><?php $suhu=Suhu("1467"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1456" class="e72_169<?php echo NoMesin("1456"); ?> detail_status"><?php echo Waktu("1456","3"); ?><?php $suhu=Suhu("1456"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1466" class="e72_172<?php echo NoMesin("1466"); ?> detail_status"><?php echo Waktu("1466","3"); ?><?php $suhu=Suhu("1466"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1459" class="e72_170<?php echo NoMesin("1459"); ?> detail_status"><?php echo Waktu("1459","3"); ?><?php $suhu=Suhu("1459"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1465" class="e72_173<?php echo NoMesin("1465"); ?> detail_status"><?php echo Waktu("1465","3"); ?><?php $suhu=Suhu("1465"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1452" class="e72_174<?php echo NoMesin("1452"); ?> detail_status"><?php echo Waktu("1452","3"); ?><?php $suhu=Suhu("1452"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1453" class="e72_175<?php echo NoMesin("1453"); ?> detail_status"><?php echo Waktu("1453","3"); ?><?php $suhu=Suhu("1453"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1458" class="e72_176<?php echo NoMesin("1458"); ?> detail_status"><?php echo Waktu("1458","3"); ?><?php $suhu=Suhu("1458"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1409" class="e72_177<?php echo NoMesin("1409"); ?> detail_status"><?php echo Waktu("1409","3"); ?><?php $suhu=Suhu("1409"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1450" class="e72_178<?php echo NoMesin("1450"); ?> detail_status"><?php echo Waktu("1450","3"); ?><?php $suhu=Suhu("1450"); if($suhu>0){ ?><div class="small-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2348" class="e72_183<?php echo NoMesin("2348"); ?> detail_status"><?php echo Waktu("2348","1"); ?><?php $suhu=Suhu("2348"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2247" class="e72_182<?php echo NoMesin("2247"); ?> detail_status"><?php echo Waktu("2247","1"); ?><?php $suhu=Suhu("2247"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2246" class="e72_181<?php echo NoMesin("2246"); ?> detail_status"><?php echo Waktu("2246","1"); ?><?php $suhu=Suhu("2246"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1114" class="e72_150<?php echo NoMesin("1114"); ?> detail_status"><?php echo Waktu("1114","1"); ?><?php $suhu=Suhu("1114"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1117" class="e72_153<?php echo NoMesin("1117"); ?> detail_status"><?php echo Waktu("1117","1"); ?><?php $suhu=Suhu("1117"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1116" class="e72_152<?php echo NoMesin("1116"); ?> detail_status"><?php echo Waktu("1116","1"); ?><?php $suhu=Suhu("1116"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1451" class="e72_180<?php echo NoMesin("1451"); ?> detail_status"><?php echo Waktu("1451","1"); ?><?php $suhu=Suhu("1451"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1410" class="e72_179<?php echo NoMesin("1410"); ?> detail_status"><?php echo Waktu("1410","1"); ?><?php $suhu=Suhu("1410"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1115" class="e72_151<?php echo NoMesin("1115"); ?> detail_status"><?php echo Waktu("1115","1"); ?><?php $suhu=Suhu("1115"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<div  class="e72_184"></div>
				<div  class="e72_185"></div>
				<div  class="e72_186"></div>
				<div  class="e72_187"></div>
				<div  class="e72_188"></div>
				<div  class="e72_189"></div>
				<div  class="e72_190"></div>
				<div  class="e72_191"></div>
				<div  class="e72_192"></div>
				<div  class="e72_194"></div>
				<div  class="e72_195"></div>
				<div  class="e72_196"></div>
				<div  class="e72_197"></div>
				<div  class="e74_206"></div>
				<div  class="e72_200"></div>
				<div  class="e72_201"></div>
				<div  class="e72_202"></div>
				<div  class="e72_203"></div>
				<div  class="e72_155"></div>
			  </div>
		  	  
	<div id="CekDetailStatus" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

	</body>
	<!-- Tooltips -->
	<!-- jQuery 3 -->
	<script src="./../bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="./../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="./../dist/js/adminlte.min.js"></script>

	<!-- DataTables -->
	<script src="./../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- bootstrap datepicker -->
	<script src="./../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
	<script src="./../bower_components/toast-master/js/jquery.toast.js"></script>
	<!-- Tooltips -->
	<script src="./../../dist/js/tooltips.js"></script>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
	<!-- Javascript untuk popup modal Edit-->
	<script type="text/javascript">
		$(document).on('click', '.detail_status', function(e) {
			var m = $(this).attr("id");
			$.ajax({
				url: "./cek-status-mesin-orgatex.php",
				type: "GET",
				data: {
					id: m,
				},
				success: function(ajaxData) {
					$("#CekDetailStatus").html(ajaxData);
					$("#CekDetailStatus").modal('show', {
						backdrop: 'true'
					});
				}
			});
		});

		//            tabel lookup KO status terima
		$(function() {
			$("#lookup").dataTable();
		});

	</script>
<!--
	<script>
		$(document).ready(function() {
			"use strict";
			// toat popup js
			$.toast({
				heading: 'Selamat Datang',
				text: 'Dyeing Indo Taichen',
				position: 'bottom-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 3500,
				stack: 6
			})


		});
		$(".tst1").on("click", function() {
			var msg = $('#message').val();
			var title = $('#title').val() || '';
			$.toast({
				heading: 'Info',
				text: msg,
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'info',
				hideAfter: 3000,
				stack: 6
			});

		});

	</script>
-->
</html>
