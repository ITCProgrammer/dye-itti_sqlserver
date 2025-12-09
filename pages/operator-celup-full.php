<?php
ini_set("error_reporting", 1);
session_start();
include"./../koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="180">
		<title>Operator Celup Dyeing ITTI</title>
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
<?php 

		function shf($mc, $shft){
			include"./../koneksi.php";
			if($shft=="1"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' ) ";
			}else if($shft=="2"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' ) ";
			}else{
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' ) ";
			}
			$qry1=mysqli_query($con," 
			SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai'
	AND a.no_mesin = '$mc' 
	$Wshft 
ORDER BY
	b.tgl_buat DESC LIMIT 1
			");
			$row1=mysqli_fetch_array($qry1);
			
			return $row1['g_shift'];
		}
		function opr($mc,$shft){
			include"./../koneksi.php";
			if($shft=="1"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' ) ";
			}else if($shft=="2"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' ) ";
			}else{
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' ) ";
			}
			$qry1=mysqli_query($con," 
			SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai'
	AND a.no_mesin = '$mc' 
	$Wshft 
ORDER BY
	b.tgl_buat DESC LIMIT 1
			");
			$row1=mysqli_fetch_array($qry1);
			
			return $row1['operator'];
		}
		function brto($mc,$shft){
			include"./../koneksi.php";
			if($shft=="1"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' ) ";
			}else if($shft=="2"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' ) ";
			}else{
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' ) ";
			}
			$qry1=mysqli_query($con," 
			SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai'
	AND a.no_mesin = '$mc' 
	$Wshft 
ORDER BY
	b.tgl_buat DESC LIMIT 1
			");
			$row1=mysqli_fetch_array($qry1);
			
			return $row1['bruto'];
		}
function wp($mc,$shft){
			include"./../koneksi.php";
			if($shft=="1"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' ) ";
			}else if($shft=="2"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' ) ";
			}else{
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' ) ";
			}
			$qry1=mysqli_query($con," 
			SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai'
	AND a.no_mesin = '$mc' 
	$Wshft 
ORDER BY
	b.tgl_buat DESC LIMIT 1
			");
			$row1=mysqli_fetch_array($qry1);
			
			return $row1['lama'];
		}
		function wrn($mc,$shft){
			include"./../koneksi.php";
			if($shft=="1"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' ) ";
			}else if($shft=="2"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' ) ";
			}else{
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' ) ";
			}
			$qry1=mysqli_query($con," 
			SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai'
	AND a.no_mesin = '$mc' 
	$Wshft 
ORDER BY
	b.tgl_buat DESC LIMIT 1
			");
			$row1=mysqli_fetch_array($qry1);
			
			return $row1['kategori_warna'];
		}
		function prs($mc,$shft){
			include"./../koneksi.php";
			if($shft=="1"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' ) ";
			}else if($shft=="2"){
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' ) ";
			}else{
				$Wshft= "  AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' ) ";
			}
			$qry1=mysqli_query($con," 
			SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai'
	AND a.no_mesin = '$mc' 
	$Wshft 
ORDER BY
	b.tgl_buat DESC LIMIT 1
			");
			$row1=mysqli_fetch_array($qry1);
			
			return $row1['proses'];
		}
		?>		
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
<div class="box-body table-responsive">
<table width="100%" border="0" id="tblr1" style="font-size: 7.4px;">
   <thead class="bg-blue"> 
	<tr align="center">
      <td scope="col">No Mesin</td>
      <td scope="col">Cap </td>
      <td scope="col">Shf</td>
      <td scope="col">Operator</td>
      <td scope="col">Lot Keluar</td>
      <td scope="col">Qty</td>
      <td scope="col">Waktu Proses</td>
      <td scope="col">Warna</td>
      <td scope="col">Proses</td>
      <td scope="col">Keterangan</td>
      <td scope="col">No Mesin</td>
      <td scope="col">Cap </td>
      <td scope="col">Shf</td>
      <td scope="col">Operator</td>
      <td scope="col">Lot Keluar</td>
      <td scope="col">Qty</td>
      <td scope="col">Waktu Proses</td>
      <td scope="col">Warna</td>
      <td scope="col">Proses</td>
      <td scope="col">Keterangan</td>
      <td scope="col">No Mesin</td>
      <td scope="col">Cap </td>
      <td scope="col">Shf</td>
      <td scope="col">Operator</td>
      <td scope="col">Lot Keluar</td>
      <td scope="col">Qty</td>
      <td scope="col">Waktu Proses</td>
      <td scope="col">Warna</td>
      <td scope="col">Proses</td>
      <td scope="col">Keterangan</td>
      <td scope="col">No Mesin</td>
      <td scope="col">Cap</td>
      <td scope="col">Tgl Skrg</td>
      <td scope="col">Tgl Sblm</td>
    </tr>
	</thead>   
	<tbody>
    <tr>
      <td align="center"><strong>1401</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td align="center"><strong><?php echo shf("1401","1");?></strong></td>
      <td align="center"><strong><?php echo opr("1401","1");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong><?php echo brto("1401","1");?></strong></td>
      <td align="center"><strong><?php echo wp("1401","1");?></strong></td>
      <td align="center"><strong><?php echo wrn("1401","1");?></strong></td>
      <td align="center"><strong><?php echo prs("1401","1");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong>1401</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td align="center"><strong><?php echo shf("1401","2");?></strong></td>
      <td align="center"><strong><?php echo opr("1401","2");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong><?php echo brto("1401","2");?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1401</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td align="center"><strong><?php echo shf("1401","3");?></strong></td>
      <td align="center"><strong><?php echo opr("1401","3");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong><?php echo brto("1401","3");?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1401</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center" bgcolor="#F5DDDD"><strong>1406</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td align="center"><strong><?php echo shf("1406","1");?></strong></td>
      <td align="center"><strong><?php echo opr("1406","1");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong><?php echo brto("1406","1");?></strong></td>
      <td align="center"><strong><?php echo wp("1406","1");?></strong></td>
      <td align="center"><strong><?php echo wrn("1406","1");?></strong></td>
      <td align="center"><strong><?php echo prs("1406","1");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong>1406</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td align="center"><strong><?php echo shf("1406","2");?></strong></td>
      <td align="center"><strong><?php echo opr("1406","2");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong><?php echo brto("1406","2");?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1406</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td align="center"><strong><?php echo shf("1406","3");?></strong></td>
      <td align="center"><strong><?php echo opr("1406","3");?></strong></td>
      <td>&nbsp;</td>
      <td align="center"><strong><?php echo brto("1406","3");?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1406</strong></td>
      <td align="center"><strong>2400</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1103</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1103</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1103</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1103</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1107</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1107</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1107</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1107</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1411</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1411</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1411</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1411</strong></td>
      <td align="center"><strong>1800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1402</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1402</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1402</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1402</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1104</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1104</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1104</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1104</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1108</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1108</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1108</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1108</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1420</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1420</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1420</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1420</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1421</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1421</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1421</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1421</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2348</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2348</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2348</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2348</strong></td>
      <td align="center"><strong>1200</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1114</strong></td>
      <td align="center"><strong>900</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1114</strong></td>
      <td align="center"><strong>900</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1114</strong></td>
      <td align="center"><strong>900</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1114</strong></td>
      <td align="center"><strong>900</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2625</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2625</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2625</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2625</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2627</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2627</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2627</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2627</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2228</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2228</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2228</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2228</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2229</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2229</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2229</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2229</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2634</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2634</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2634</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2634</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2636</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2636</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2636</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2636</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2637</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2637</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2637</strong></td>
      <td align="center"><strong>800</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2637</strong></td>
      <td align="center"><strong>800</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1505</strong></td>
      <td align="center"><strong>750</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1505</strong></td>
      <td align="center"><strong>750</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1505</strong></td>
      <td align="center"><strong>750</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1505</strong></td>
      <td align="center"><strong>750</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1410</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1410</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1410</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1410</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1115</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1115</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1115</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1115</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1116</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1116</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1116</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1116</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1117</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1117</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1117</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1117</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2632</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2632</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2632</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2632</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2633</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2633</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2633</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2633</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1451</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1451</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1451</strong></td>
      <td align="center"><strong>600</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1451</strong></td>
      <td align="center"><strong>600</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2230</strong></td>
      <td align="center"><strong>400</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2230</strong></td>
      <td align="center"><strong>400</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2230</strong></td>
      <td align="center"><strong>400</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2230</strong></td>
      <td align="center"><strong>400</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2231</strong></td>
      <td align="center"><strong>400</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2231</strong></td>
      <td align="center"><strong>400</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2231</strong></td>
      <td align="center"><strong>400</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2231</strong></td>
      <td align="center"><strong>400</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1412</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1412</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1412</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1412</strong></td>
      <td align="center"><strong>300</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1413</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1413</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1413</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1413</strong></td>
      <td align="center"><strong>300</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1118</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1118</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1118</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1118</strong></td>
      <td align="center"><strong>300</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1419</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1419</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1419</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1419</strong></td>
      <td align="center"><strong>300</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1449</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1449</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1449</strong></td>
      <td align="center"><strong>300</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1449</strong></td>
      <td align="center"><strong>300</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1409</strong></td>
      <td align="center"><strong>150</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1409</strong></td>
      <td align="center"><strong>150</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1409</strong></td>
      <td align="center"><strong>150</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1409</strong></td>
      <td align="center"><strong>150</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1450</strong></td>
      <td align="center"><strong>150</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1450</strong></td>
      <td align="center"><strong>150</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1450</strong></td>
      <td align="center"><strong>150</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1450</strong></td>
      <td align="center"><strong>150</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2622</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2622</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2622</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2622</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2623</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2623</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2623</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2623</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2246</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2246</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2246</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2246</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2247</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2247</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2247</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2247</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1452</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1452</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1452</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1452</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1453</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1453</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1453</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1453</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1458</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1458</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1458</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1458</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2265</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2265</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2265</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2265</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2666</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2666</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2666</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2666</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2667</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2667</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2667</strong></td>
      <td align="center"><strong>100</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2667</strong></td>
      <td align="center"><strong>100</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2624</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2624</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2624</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2624</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2635</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2635</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2635</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2635</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1454</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1454</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1454</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1454</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1455</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1455</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1455</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1455</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1456</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1456</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1456</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1456</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1457</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1457</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1457</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1457</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1459</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1459</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1459</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1459</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2660</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2660</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2660</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2660</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2661</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2661</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2661</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2661</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2662</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2662</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2662</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2662</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2663</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2663</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2663</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2663</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2664</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2664</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2664</strong></td>
      <td align="center"><strong>50</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2664</strong></td>
      <td align="center"><strong>50</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2626</strong></td>
      <td align="center"><strong>30</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2626</strong></td>
      <td align="center"><strong>30</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2626</strong></td>
      <td align="center"><strong>30</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2626</strong></td>
      <td align="center"><strong>30</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2639</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2639</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2639</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2639</strong></td>
      <td align="center"><strong>20</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2640</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2640</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2640</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2640</strong></td>
      <td align="center"><strong>20</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2641</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2641</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2641</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2641</strong></td>
      <td align="center"><strong>20</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2642</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2642</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2642</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2642</strong></td>
      <td align="center"><strong>20</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2643</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2643</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2643</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2643</strong></td>
      <td align="center"><strong>20</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>2644</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2644</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2644</strong></td>
      <td align="center"><strong>20</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2644</strong></td>
      <td align="center"><strong>20</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>2638</strong></td>
      <td align="center"><strong>10</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2638</strong></td>
      <td align="center"><strong>10</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2638</strong></td>
      <td align="center"><strong>10</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>2638</strong></td>
      <td align="center"><strong>10</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><strong>1468</strong></td>
      <td align="center"><strong>5</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1468</strong></td>
      <td align="center"><strong>5</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1468</strong></td>
      <td align="center"><strong>5</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1468</strong></td>
      <td align="center"><strong>5</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#F5DDDD">
      <td align="center"><strong>1469</strong></td>
      <td align="center"><strong>5</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1469</strong></td>
      <td align="center"><strong>5</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1469</strong></td>
      <td align="center"><strong>5</strong></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong>1469</strong></td>
      <td align="center"><strong>5</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="bg-blue">
      <td>Tot</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

				  </div>

				</div>

			</div>
		</div>
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
