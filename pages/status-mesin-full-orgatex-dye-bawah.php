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
          
            <title>Status Mesin Dyeing Bawah</title>
            <meta name="description" content="Figma htmlGenerator">
            <meta name="author" content="htmlGenerator">
			<meta http-equiv="refresh" content="20">  
            
            <link rel="stylesheet" href="styles-dye-bawah.css">              
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
				window.location.href = "status-mesin-full-orgatex-dye-atas.php"; // Ganti dye 01 dengan URL tujuan yang diinginkan
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

	function Waktu($mc){
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
		$wkt="<strong><font class='big-text'>".$jam.":".$menit."</font></strong>";
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
?>          
          <body>
            <div class=e36_270>
				<a href="#"><div id="1108" class="e36_271<?php echo NoMesin("1108"); ?> detail_status"><?php echo Waktu("1108"); ?><?php $suhu=Suhu("1108"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1442" class="e36_272<?php echo NoMesin("1442"); ?> detail_status"><?php echo Waktu("1442"); ?><?php $suhu=Suhu("1442s"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1411" class="e36_273<?php echo NoMesin("1411"); ?> detail_status"><?php echo Waktu("1411"); ?><?php $suhu=Suhu("1411"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1443" class="e36_274<?php echo NoMesin("1443"); ?> detail_status"><?php echo Waktu("1443"); ?><?php $suhu=Suhu("1443"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1444" class="e36_275<?php echo NoMesin("1444"); ?> detail_status"><?php echo Waktu("1444"); ?><?php $suhu=Suhu("1444"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1445" class="e36_276<?php echo NoMesin("1445"); ?> detail_status"><?php echo Waktu("1445"); ?><?php $suhu=Suhu("1445"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1420" class="e36_277<?php echo NoMesin("1420"); ?> detail_status"><?php echo Waktu("1420"); ?><?php $suhu=Suhu("1420"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1107" class="e36_278<?php echo NoMesin("1107"); ?> detail_status"><?php echo Waktu("1107"); ?><?php $suhu=Suhu("1107"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1406" class="e36_279<?php echo NoMesin("1406"); ?> detail_status"><?php echo Waktu("1406"); ?><?php $suhu=Suhu("1406"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1505" class="e36_280<?php echo NoMesin("1505"); ?> detail_status"><?php echo Waktu("1505"); ?><?php $suhu=Suhu("1505"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1104" class="e36_281<?php echo NoMesin("1104"); ?> detail_status"><?php echo Waktu("1104"); ?><?php $suhu=Suhu("1104"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1103" class="e36_282<?php echo NoMesin("1103"); ?> detail_status"><?php echo Waktu("1103"); ?><?php $suhu=Suhu("1103"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<a href="#"><div id="1402" class="e36_283<?php echo NoMesin("1402"); ?> detail_status"><?php echo Waktu("1402"); ?><?php $suhu=Suhu("1402"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?>					
					</div></a>
				<a href="#"><div id="1401" class="e36_284<?php echo NoMesin("1401"); ?> detail_status"><?php echo Waktu("1401"); ?><?php $suhu=Suhu("1401"); if($suhu>0){ ?><div class="round-icon"><?php echo $suhu;?> <i class="fa fa-thermometer-full"></i></div><?php } ?></div></a>
				<div  class="e36_285"></div>
				<div  class="e36_286"></div>
				<div  class="e36_287"></div>
				<div  class="e36_288"></div>
				<div  class="e36_289"></div>
				<div  class="e36_290"></div>
				<div  class="e36_291"></div>
				<div  class="e36_292"></div>
				<div  class="e36_293"></div>
				<div  class="e36_294"></div>
				<div  class="e36_298"></div>
				<div  class="e36_299"></div>
				<div  class="e36_300"></div>
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
