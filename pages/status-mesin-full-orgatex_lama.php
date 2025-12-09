<?php
ini_set("error_reporting", 1);
session_start();
include"./../koneksiORGATEX.php";
include"./../koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="30">
		<title>Status Mesin Dyeing ITTI</title>
<style>
td{
		padding: 1px 0px;
}	
			.blink_me {
  animation: blinker 1s linear infinite;
}
.blink_me1 {
  animation: blinker 7s linear infinite;
}
	@keyframes blinker {
  50% { opacity: 0; }
}
	body{
		font-family: Calibri, "sans-serif", "Courier New";  /* "Calibri Light","serif" */
		font-style: normal;
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
		<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
		<link rel="stylesheet" href="./../dist/css/skins/skin-purple.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

		<!-- Google Font -->
		<!--
  <link rel="stylesheet"
        href="./../dist/css/font/font.css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	-->

		<link rel="icon" type="image/png" href="./../dist/img/index.ico">
		<style type="text/css">
			.teks-berjalan {
				background-color: #03165E;
				color: #F4F0F0;
				font-family: monospace;
				font-size: 24px;
				font-style: italic;
			}

			.border-dashed {
				border: 4px dashed #083255;
			}

			.bulat {
				border-radius: 50%;
				/*box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);*/
			}

		</style>
	</head>

	<body>
		
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Status Mesin Dyeing ITTI - ORGATEX</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<a href="../index1.php?p=Status-Mesin-Orgatex" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="MiniScreen"><i class="fa fa-expand"></i></a>
						</div>
					</div>
					<div class="box-body table-responsive">
<?php
function NoMesin($mc)
{
	// Menghubungkan ke database
    include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
    $sql = "SELECT (Case When ms.OnlineState = 1 Then 'ON' When ms.OnlineState = 0 Then 'OFF' End) as [Online State], 
(Case When ms.RunState = 1 Then 'No Batch' When ms.RunState = 2 Then 'Batch Selected'
When ms.RunState = 3 Then 'Batch Running' When ms.RunState = 4 Then 'Controller Stopped' 
When ms.RunState = 5 Then 'Manual Operation' When ms.RunState = 6 Then 'Finished' End) as [Run State] FROM MachineStatus ms WHERE ms.Machine = ?";

    // Menyiapkan statement dengan parameter
    $params = array($mc); // Menyimpan parameter MachineCode
    $stmt = sqlsrv_query($connORG, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Mengambil hasil query
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); 
	
	if ($row['Run State']=='No Batch' and $row['Online State']=='OFF'){
		$warnaMc="bg-abu";
	}else if ($row['Run State']=='No Batch' and $row['Online State']=='ON'){
		$warnaMc="bg-abu blink_me";	
	}else if($row['Run State']=='Batch Running' and $row['Online State']=='OFF'){	
		$warnaMc="bg-green";
	}else if($row['Run State']=='Batch Running' and $row['Online State']=='ON'){	
		$warnaMc="bg-green blink_me";	
	}else if($row['Run State']=='Controller Stopped' and $row['Online State']=='OFF'){	
		$warnaMc="bg-black";
	}else if($row['Run State']=='Controller Stopped' and $row['Online State']=='ON'){	
		$warnaMc="bg-black blink_me";
	}else if($row['Run State']=='Manual Operation' and $row['Online State']=='OFF'){	
		$warnaMc="bg-yellow";	
	}else if($row['Run State']=='Manual Operation' and $row['Online State']=='ON'){	
		$warnaMc="bg-yellow blink_me";
	}else if($row['Run State']=='Finished' and $row['Online State']=='OFF'){	
		$warnaMc="bg-red";
	}else if($row['Run State']=='Finished' and $row['Online State']=='ON'){	
		$warnaMc="bg-red blink_me";	
	}else{
		
		$warnaMc="";
	}
			
	
    // Tutup koneksi
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($connORG);
	 
    return $warnaMc;
}
	function Rajut($mc)
	{
		// Menghubungkan ke database
		include "./../koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

	}

	function Waktu($mc){
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
		
	// Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
//    $sql1 = "SELECT 
//           DyelotRefNo
//        FROM MachineStatus 
//        WHERE Machine = ?";

    // Menyiapkan statement dengan parameter
//    $params1 = array($mc); // Menyimpan parameter MachineCode
//    $stmt1 = sqlsrv_query($connORG, $sql1, $params1);

    // Cek apakah query berhasil
//    if ($stmt1 === false) {
//        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
//    }

    // Mengambil hasil query
//    $row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC);
		
    // Tutup koneksi
//    sqlsrv_free_stmt($stmt1);
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
		$wkt=$jam.":".$menit."<br>".$row1['DyelotRefNo'];
	}
    return $wkt; // Kembalikan nilai DyelotRefNo saja		
    }

?>


						<table width="100%" border="0">
							<tbody>
								<tr>
								  <td colspan="2" align="center" class="bg-purple">2400 KGs</td>
								  <td colspan="2" align="center" class="bg-blue">1200 KGs</td>
								  <td align="center" class="bg-yellow">900 KGs</td>
								  <td colspan="2" align="center" class="bg-red">800 KGs</td>
								  <td align="center" class="bg-purple">750 KGs</td>
								  <td colspan="2" align="center" class="bg-black"> 600 KGs </td>
								  <td align="center" class="bg-kuning">&nbsp;</td>
								  <td align="center" class="bg-kuning">&nbsp;</td>
								  <td colspan="2" align="center" class="bg-abu"> 400 KGs </td>
								  <td colspan="2" align="center" class="bg-fuchsia"> 300 KGs </td>
							  </tr>
								<tr>
								  <td colspan="16" align="center" ></td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg <?php echo NoMesin("1401"); ?>" id="1401" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1401"); ?>">1401
								    <p><?php echo Waktu("1401"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1402"); ?>" id="1402" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1402"); ?>">1402
								    <p><?php echo Waktu("1402"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1108"); ?>" id="1108" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1108"); ?>">1108
								    <p><?php echo Waktu("1108"); ?></p>
								    </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg <?php echo NoMesin("1114"); ?>" id="1114" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1114"); ?>">1114
									    <p><?php echo Waktu("1114"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg <?php echo NoMesin("2625"); ?>" id="2625" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2625"); ?>">2625
									    <p><?php echo Waktu("2625"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg <?php echo NoMesin("2634"); ?>" id="2634" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2634"); ?>">2634
									    <p><?php echo Waktu("2634"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg <?php echo NoMesin("1505"); ?>" id="1505" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1505"); ?>">1505
									    <p><?php echo Waktu("1505"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-lg <?php echo NoMesin("1410"); ?>" id="1410" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1410"); ?>">1410
									    <p><?php echo Waktu("1410"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-lg <?php echo NoMesin("2633"); ?>" id="2633" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2633"); ?>">2633
									    <p><?php echo Waktu("2633"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn  btn-lg <?php echo NoMesin("2230"); ?>" id="2230" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2230"); ?>">2230
									    <p><?php echo Waktu("2230"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn  btn-lg  <?php echo NoMesin("2231"); ?>" id="2231" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2231"); ?>">2231
									    <p><?php echo Waktu("2231"); ?></p></span> </td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("1413"); ?>" id="1413" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1413"); ?>">1413
									    <p><?php echo Waktu("1413"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg <?php echo NoMesin("1419"); ?>" id="1419" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1419"); ?>">1419
									    <p><?php echo Waktu("1419"); ?></p>
									  </span></td>
							  </tr>
								<tr>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("1406"); ?>" id="1406" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1406"); ?>">1406
									  <p><?php echo Waktu("1406"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1420"); ?>" id="1420" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1420"); ?>">1420
									  <p><?php echo Waktu("1420"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2348"); ?>" id="2348" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2348"); ?>">2348
									  <p><?php echo Waktu("2348"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2627"); ?>" id="2627" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2627"); ?>">2627
									    <p><?php echo Waktu("2627"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2229"); ?>" id="2229" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2229"); ?>">2229
									    <p><?php echo Waktu("2229"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn btn-lg  <?php echo NoMesin("1117"); ?>" id="1117" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1117"); ?>">1117
									    <p><?php echo Waktu("1117"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg <?php echo NoMesin("2632"); ?>" id="2632" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2632"); ?>">2632
									    <p><?php echo Waktu("2632"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg <?php echo NoMesin("1412"); ?>" id="1412" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1412"); ?>">1412
									    <p><?php echo Waktu("1412"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg <?php echo NoMesin("1449"); ?>" id="1449" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1449"); ?>">1449
									    <p><?php echo Waktu("1449"); ?></p>
									  </span></td>
							  </tr>
								<tr>
									<td height="96" align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1104"); ?>" id="1104" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1104"); ?>">1104
									  <p><?php echo Waktu("1104"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1421"); ?>" id="1421" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1421"); ?>">1421
									    <p><?php echo Waktu("1421"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("2637"); ?>" id="2637" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2637"); ?>">2637
									    <p><?php echo Waktu("2637"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2246"); ?>" id="2246" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2246"); ?>">2246
									    <p><?php echo Waktu("2246"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"> <span class="detail_status btn  btn-lg <?php echo NoMesin("1116"); ?>" id="1116" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1116"); ?>">1116
							      <p><?php echo Waktu("1116"); ?></p></span> </td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("1451"); ?>" id="1451" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1451"); ?>">1451
									    <p><?php echo Waktu("1451"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("1118"); ?>" id="1118" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1118"); ?>">1118
									    <p><?php echo Waktu("1118"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td bgcolor="#E0DDDD">&nbsp;</td>
									<td bgcolor="#E0DDDD">&nbsp;</td>
									<td bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("2636"); ?>" id="2636" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2636"); ?>">2636
									    <p><?php echo Waktu("2636"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("2247"); ?>" id="2247" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2247"); ?>">2247
									    <p><?php echo Waktu("2247"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1115"); ?>" id="1115" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1115"); ?>">1115
									    <p><?php echo Waktu("1115"); ?></p>
									  </span></td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#E0DDDD">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
									<td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
								  <td colspan="2" align="center" class="bg-black">1800 KGs</td>
								  <td align="center" class="bg-aqua"> 200 KGs </td>
								  <td colspan="2" align="center" class="bg-navy"> 150 KGs </td>
								  <td colspan="2" align="center" class="bg-info"> 100 KGs </td>
								  <td colspan="3" align="center" class="bg-maroon"> 50 KGs </td>
								  <td colspan="2" align="center" class="bg-green"> 30 KGs </td>
								  <td colspan="2" align="center" class="bg-gray"> 20 KGs </td>
								  <td align="center" class="bg-lime"> 10 KGs </td>
								  <td align="center" class="bg-teal"> 0 KGs </td>
							  </tr>
								<tr>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1411"); ?>" id="1411" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1411"); ?>">1411
								    <p><?php echo Waktu("1411"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2228"); ?>" id="2228" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2228"); ?>">2228
								      <p><?php echo Waktu("2228"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1409"); ?>" id="1409" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1409"); ?>">1409
								      <p><?php echo Waktu("1409"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("1450"); ?>" id="1450" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1450"); ?>">1450
								      <p><?php echo Waktu("1450"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2665"); ?>" id="2665" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2665"); ?>">2665
								      <p><?php echo Waktu("2665"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1452"); ?>" id="1452" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1452"); ?>">1452
								      <p><?php echo Waktu("1452"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("1457"); ?>" id="1457" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1457"); ?>">1457
								      <p><?php echo Waktu("1457"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("2660"); ?>" id="2660" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2660"); ?>">2660
								      <p><?php echo Waktu("2660"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2664"); ?>" id="2664" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2664"); ?>">2664
								      <p><?php echo Waktu("2664"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg <?php echo NoMesin("2626"); ?>" id="2626" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2626"); ?>">2626
								      <p><?php echo Waktu("2626"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg  <?php echo NoMesin("2042"); ?>" id="2042" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2042"); ?>">2042
								      <p><?php echo Waktu("2042"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("2641"); ?>" id="2641" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2641"); ?>">2641
								      <p><?php echo Waktu("2641"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("2638"); ?>" id="2638" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2638"); ?>">2638
								      <p><?php echo Waktu("2638"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg  <?php echo NoMesin("WS11"); ?>" id="WS11" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("WS11"); ?>">WS11
								      <p><?php echo Waktu("WS11"); ?></p>
								    </span></td>
							  </tr>
								<tr>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1103"); ?>" id="1103" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1103"); ?>">1103
								    <p><?php echo Waktu("1103"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("2666"); ?>" id="2666" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2666"); ?>">2666
								      <p><?php echo Waktu("2666"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1453"); ?>" id="1453" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1453"); ?>">1453
								      <p><?php echo Waktu("1453"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("1456"); ?>" id="1456" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1456"); ?>">1456
								      <p><?php echo Waktu("1456"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("2661"); ?>" id="2661" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2661"); ?>">2661
								      <p><?php echo Waktu("2661"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("1459"); ?>" id="1459" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1459"); ?>">1459
								      <p><?php echo Waktu("1459"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2043"); ?>" id="2043" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2043"); ?>">2043
								      <p><?php echo Waktu("2043"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2640"); ?>" id="2640" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2640"); ?>">2640
								      <p><?php echo Waktu("2640"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg  <?php echo NoMesin("CB11"); ?>" id="CB11" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("CB11"); ?>">CB11
								    <p><?php echo Waktu("CB11"); ?></p>
								    </span></td>
							  </tr>
								<tr>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1107"); ?>" id="1107" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1107"); ?>">1107
								    <p><?php echo Waktu("1107"); ?></p>
								    </span></td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn btn-lg  <?php echo NoMesin("2667"); ?>" id="2667" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2667"); ?>">2667
								      <p><?php echo Waktu("2667"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2622"); ?>" id="2622" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2622"); ?>">2622
								      <p><?php echo Waktu("2622"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("1455"); ?>" id="1455" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1455"); ?>">1455
								      <p><?php echo Waktu("1455"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2662"); ?>" id="2662" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2662"); ?>">2662
								      <p><?php echo Waktu("2662"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2624"); ?>" id="2624" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2624"); ?>">2624
								      <p><?php echo Waktu("2624"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2044"); ?>" id="2044" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2044"); ?>">2044
								      <p><?php echo Waktu("2044"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("2639"); ?>" id="2639" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2639"); ?>">2639
								      <p><?php echo Waktu("2639"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#E0DDDD">&nbsp;</td>
								  <td bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("1458"); ?>" id="1458" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1458"); ?>">1458
								      <p><?php echo Waktu("1458"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD"><span class="detail_status btn  btn-lg <?php echo NoMesin("2623"); ?>" id="2623" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2623"); ?>">2623
								      <p><?php echo Waktu("2623"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("1454"); ?>" id="1454" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("1454"); ?>">1454
								      <p><?php echo Waktu("1454"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("2663"); ?>" id="2663" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2663"); ?>">2663
								      <p><?php echo Waktu("2663"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn btn-lg  <?php echo NoMesin("2635"); ?>" id="2635" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2635"); ?>">2635
								      <p><?php echo Waktu("2635"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#E0DDDD">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7"><span class="detail_status btn  btn-lg <?php echo NoMesin("2045"); ?>" id="2045" data-toggle="tooltip" data-html="true" title="<?php echo Rajut("2045"); ?>">2045
								      <p><?php echo Waktu("2045"); ?></p>
								    </span></td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
								  <td align="center" bgcolor="#ECE7E7">&nbsp;</td>
							  </tr>
								<tr>
									<td colspan="3">Controller Stopped <span class="label btn-sm bg-black">&nbsp;<?php echo $totMCS;?></span></td>
									<td colspan="3">Controller Stopped and Connect <span class="label btn-sm bg-black blink_me">&nbsp;<?php echo $totMCS;?></span></td>
									<td colspan="3">&nbsp;</td>
									<td colspan="4">&nbsp;</td>
									<td colspan="3">&nbsp;</td>
								</tr>
								<tr>
								  <td colspan="3">Batch Running <span class="label label-success blink_me">&nbsp;<?php echo $totGRG;?></span></td>
								  <td colspan="3">&nbsp;</td>
								  <td colspan="3">&nbsp;</td>
								  <td colspan="4">&nbsp;</td>
								  <td colspan="3">&nbsp;</td>
							    </tr>
								<tr>
								  <td colspan="3">No Batch <span class="label bg-abu">&nbsp;<?php echo $totMCR;?></span></td>
								  <td colspan="3"><span style="padding: 1px;">No Batch and Connect <span class="label bg-abu blink_me">&nbsp;<?php echo $totMCR;?></span></span></td>
								  <td colspan="3">&nbsp;</td>
								  <td colspan="4">&nbsp;</td>
								  <td colspan="3">&nbsp;</td>
							  </tr>
								<tr>
								  <td colspan="3">Manual Operation <span class="label bg-yellow">&nbsp;<?php echo $totMCR;?></span></td>
								  <td colspan="3">Manual Operation and Connect<span class="label bg-yellow blink_me">&nbsp;<?php echo $totMCR;?></span></td>
								  <td colspan="3">&nbsp;</td>
								  <td colspan="4">&nbsp;</td>
								  <td colspan="3">&nbsp;</td>
							  </tr>
								<tr>
								  <td colspan="16" style="padding: 1px;">Finished <span class="label bg-red">&nbsp;<?php echo $totMCR;?></span></td>
							  </tr>
								<tr>
									<td colspan="16" style="padding: 5px;">
										<marquee class="teks-berjalan" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
											<?php
$news=mysqli_query($con,"SELECT GROUP_CONCAT(news_line SEPARATOR ' :: ') as news_line FROM tbl_news_line WHERE gedung='LT 1' AND status='Tampil'");
$rNews=mysqli_fetch_array($news);
$totMesin='0';
?>
											<?php echo $rNews['news_line'];?>
										</marquee>
									</td>
								</tr>								
								
								<!--
    <tr>
      <td colspan="26" style="padding: 5px;">&nbsp;</td>
    </tr> -->
							</tbody>
						</table>

				  </div>

				</div>

			</div>
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
				url: "./cek-status-mesin.php",
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

</html>
