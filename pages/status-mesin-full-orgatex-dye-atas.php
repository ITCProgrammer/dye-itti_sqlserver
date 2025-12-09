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
          
            <title>Status Mesin Dyeing Atas</title>
            <meta name="description" content="Figma htmlGenerator">
            <meta name="author" content="htmlGenerator">
			<meta http-equiv="refresh" content="20">  
            
            <link rel="stylesheet" href="styles_dye_atas.css">              
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
            	font-size: 5px; /* Menggunakan em, px, atau rem sesuai kebutuhan */
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
				window.location.href = "status-mesin-full-orgatex-bawah-knt.php"; // Ganti dye 01 dengan URL tujuan yang diinginkan
			}, 120000); // 10000 ms = 10 detik
    	  	</script>
          </head>
<?php
function NoMesin($mc)
{
	// Menghubungkan ke database
    include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
    $sql = " SELECT a.Dyelot,(Case When ms.OnlineState = 1 Then 'ON' When ms.OnlineState = 0 Then 'OFF' End) as [Online State], 
(Case When ms.RunState = 1 Then 'No Batch' When ms.RunState = 2 Then 'Batch Selected'
When ms.RunState = 3 Then 'Batch Running' When ms.RunState = 4 Then 'Controller Stopped' 
When ms.RunState = 5 Then 'Manual Operation' When ms.RunState = 6 Then 'Finished' End) as [Run State] FROM MachineStatus ms 
LEFT JOIN Dyelots a ON ms.DyelotRefNo = a.DyelotRefNo
WHERE ms.RunState> '1' AND ms.Machine = ? ";

    // Menyiapkan statement dengan parameter
    $params = array($mc); // Menyimpan parameter MachineCode
    $stmt = sqlsrv_query($connORG, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Mengambil hasil query
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); 
	
	if($row['Run State']=='Batch Selected' and $row['Dyelot']!=""){	
		$warnaMc="_bs";		
	}else if($row['Run State']=='Batch Running' and $row['Dyelot']!=""){	
		$warnaMc="_r";		
	}else if($row['Run State']=='Controller Stopped' and $row['Dyelot']!=""){	
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
    $sql = " SELECT a.Dyelot,(Case When ms.OnlineState = 1 Then 'ON' When ms.OnlineState = 0 Then 'OFF' End) as [Online State], 
(Case When ms.RunState = 1 Then 'No Batch' When ms.RunState = 2 Then 'Batch Selected'
When ms.RunState = 3 Then 'Batch Running' When ms.RunState = 4 Then 'Controller Stopped' 
When ms.RunState = 5 Then 'Manual Operation' When ms.RunState = 6 Then 'Finished' End) as [Run State] FROM MachineStatus ms 
LEFT JOIN Dyelots a ON ms.DyelotRefNo = a.DyelotRefNo
WHERE ms.RunState> '1' AND ms.Machine = ? ";

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
    $sql = "SELECT (ms.InfoWord1/66.6) as [Temperature] FROM MachineStatus ms INNER JOIN Dyelots a ON ms.DyelotRefNo = a.DyelotRefNo WHERE ms.RunState='3' AND ms.Machine = ?";

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
           FLOOR(ms.TimeToEnd / 60) AS Hours,
           ms.TimeToEnd % 60 AS Minutes
        FROM MachineStatus ms
		INNER JOIN Dyelots a ON ms.DyelotRefNo = a.DyelotRefNo
        WHERE ms.Machine = ?";

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
	function EffPer($machine_no, $time_range) {
		$url = "http://10.0.0.10/laporan/stop_machine_efficency_cek.php";

		// Build query string
		$query = http_build_query([
			'machine_no' => $machine_no,
			'time_range' => $time_range
		]);

		// Initialize cURL
		$ch = curl_init("$url?$query");

		// Set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		// Execute cURL request
		$response = curl_exec($ch);

		// Check for cURL errors
		if (curl_errno($ch)) {
			echo "cURL Error: " . curl_error($ch);
			curl_close($ch);
			return null;
		}

		// Close cURL session
		curl_close($ch);

		// Decode JSON response
		$data = json_decode($response, true);

		// Check if decoding was successful and key exists
		if (isset($data['persentase_efficiency_machine'])) {			
			echo $data['persentase_efficiency_machine'];
		} else {
			echo "0";
		}
	}

	

	//echo EffPer("2228", "week"); 


?>          
          <body>
            <div class=e117_487>
				<a href="#"><div id="2632" class="e131_494<?php echo NoMesin("2632"); ?> detail_status"><?php echo Waktu("2632","2"); ?><?php $suhu=Suhu("2632"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="anti pilling" class="e131_495<?php echo NoMesin("anti pilling"); ?> detail_status"><?php echo Waktu("anti pilling","2"); ?><?php $suhu=Suhu("anti pilling"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2633" class="e131_496<?php echo NoMesin("2633"); ?> detail_status"><?php echo Waktu("2633","2"); ?><?php $suhu=Suhu("2633"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2634" class="e131_497<?php echo NoMesin("2634"); ?> detail_status"><?php echo Waktu("2634","2"); ?><?php $suhu=Suhu("2634"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2635" class="e131_498<?php echo NoMesin("2635"); ?> detail_status"><?php echo Waktu("2635","2"); ?><?php $suhu=Suhu("2635"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2636" class="e131_500<?php echo NoMesin("2636"); ?> detail_status"><?php echo Waktu("2636","2"); ?><?php $suhu=Suhu("2636"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1474" class="e131_501<?php echo NoMesin("1474"); ?> detail_status"><?php echo Waktu("1474","2"); ?><?php $suhu=Suhu("1474"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2641" class="e131_502<?php echo NoMesin("2641"); ?> detail_status"><?php echo Waktu("2641","2"); ?><?php $suhu=Suhu("2641"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2640" class="e131_503<?php echo NoMesin("2640"); ?> detail_status"><?php echo Waktu("2640","2"); ?><?php $suhu=Suhu("2640"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2639" class="e131_504<?php echo NoMesin("2639"); ?> detail_status"><?php echo Waktu("2639","2"); ?><?php $suhu=Suhu("2639"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2638" class="e131_505<?php echo NoMesin("2638"); ?> detail_status"><?php echo Waktu("2638","2"); ?><?php $suhu=Suhu("2638"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="test soaping" class="e131_506<?php echo NoMesin("test soaping"); ?> detail_status"><?php echo Waktu("test soaping","3"); ?><?php $suhu=Suhu("test soaping"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1470" class="e131_507<?php echo NoMesin("1470"); ?> detail_status"><?php echo Waktu("1470","3"); ?><?php $suhu=Suhu("1470"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1471" class="e131_508<?php echo NoMesin("1471"); ?> detail_status"><?php echo Waktu("1471","3"); ?><?php $suhu=Suhu("1471"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1472" class="e131_509<?php echo NoMesin("1472"); ?> detail_status"><?php echo Waktu("1472","3"); ?><?php $suhu=Suhu("1472"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1473" class="e131_510<?php echo NoMesin("1473"); ?> detail_status"><?php echo Waktu("1473","3"); ?><?php $suhu=Suhu("1473"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1468" class="e131_511<?php echo NoMesin("1468"); ?> detail_status"><?php echo Waktu("1468","3"); ?><?php $suhu=Suhu("1468"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1469" class="e131_512<?php echo NoMesin("1469"); ?> detail_status"><?php echo Waktu("1469","3"); ?><?php $suhu=Suhu("1469"); if($suhu>0){ ?><div class="xsmall-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div class="e131_513"></div></a>
				<a href="#"><div id="2229" class="e131_514<?php echo NoMesin("2229"); ?> detail_status"><?php echo Waktu("2229","2"); ?><?php $suhu=Suhu("2229"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2231" class="e131_515<?php echo NoMesin("2231"); ?> detail_status"><?php echo Waktu("2231","2"); ?><?php $suhu=Suhu("2231"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2230" class="e131_516<?php echo NoMesin("2230"); ?> detail_status"><?php echo Waktu("2230","2"); ?><?php $suhu=Suhu("2230"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2228" class="e131_517<?php echo NoMesin("2228"); ?> detail_status"><?php echo Waktu("2228","2"); ?><?php $suhu=Suhu("2228"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2626" class="e131_519<?php echo NoMesin("2626"); ?> detail_status"><?php echo Waktu("2626","2"); ?><?php $suhu=Suhu("2626"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2625" class="e131_520<?php echo NoMesin("2625"); ?> detail_status"><?php echo Waktu("2625","2"); ?><?php $suhu=Suhu("2625"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2624" class="e131_521<?php echo NoMesin("2624"); ?> detail_status"><?php echo Waktu("2624","2"); ?><?php $suhu=Suhu("2624"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2623" class="e131_522<?php echo NoMesin("2623"); ?> detail_status"><?php echo Waktu("2623","2"); ?><?php $suhu=Suhu("2623"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="2622" class="e131_523<?php echo NoMesin("2622"); ?> detail_status"><?php echo Waktu("2622","2"); ?><?php $suhu=Suhu("2622"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1421" class="e131_524<?php echo NoMesin("1421"); ?> detail_status"><?php echo Waktu("1421","1"); ?><?php $suhu=Suhu("1421"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<div  class="e131_525"></div>
				<div  class="e131_526"></div>
				<div  class="e131_527"></div>
				<div  class="e131_528"></div>
				<div  class="e131_529"></div>
				<div  class="e131_530"></div>
				<div  class="e131_531"></div>
				<div  class="e131_532"></div>
				<div  class="e131_533"></div>
				<div  class="e131_534"></div>
				<div  class="e131_535"></div>
				<div  class="e131_536"></div>
				<div  class="e131_537"></div>
				<div  class="e131_538"></div>
				<div  class="e131_539"></div>
				<div  class="e131_541"></div>
				<div  class="e131_542"></div>
				<div  class="e131_543"></div>
				<div  class="e131_544"></div>
				<div  class="e131_545"></div>
				<div  class="e131_546"></div>
				<div  class="e131_548"></div>
				<div  class="e131_549"></div>
				<div  class="e131_550"></div>
				<div  class="e131_551"></div>
				<div  class="e131_552"></div>
				<div  class="e131_553"></div>
				<a href="#"><div class="e131_540"></div></a>
				<div  class="e131_499"></div>
				<a href="#"><div id="2627" class="e131_518<?php echo NoMesin("2627"); ?> detail_status"><?php echo Waktu("2627","2"); ?><?php $suhu=Suhu("2627"); if($suhu>0){ ?><div class="medium-round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<div  class="e131_547"></div>
			  </div>
		  
	<div>
	  
	</div>		  
	<div id="CekDetailStatus" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<?php
			  // Example usage
//		$machine_no = 1401;
//		$time_range = "week";
//		$response = getMachineEfficiency($machine_no, $time_range);

//		if ($response !== null) {
		//	echo "Machine Efficiency Data: " . $response;
//		} else {
		//	echo "Failed to retrieve machine efficiency data.";
//		}
	?>
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
