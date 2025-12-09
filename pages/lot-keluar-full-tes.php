<?php
ini_set("error_reporting", 1);
//session_start();
include"./../koneksi.php";

$sqJam= mysqli_query($con,"SELECT now() as jskrng,DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as jsblm ");
$rJam= mysqli_fetch_array($sqJam);

if(date("H:i:s")>="23:00:00" && date("H:i:s")<="06:59:59"){$sf="3";}
else if(date("H:i:s")>="07:00:00" && date("H:i:s")<="14:59:59"){$sf="1";}
else if(date("H:i:s")>="15:00:00" && date("H:i:s")<="22:59:59"){$sf="2";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="360">
		<title><?php echo "SHIFT: ".$sf; ?> Lot Keluar Celup Dyeing ITTI</title>
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
		<div class="row1">
			<div class="col1-xs-3">
<?php 
				if($sf=="1" or $sf=="2"){
					$sqJam1= mysqli_query($con,"SELECT DATE_FORMAT( now(), '%Y-%m-%d' ) as tgl ");
					$rJam1= mysqli_fetch_array($sqJam1);
				}else{
					$sqJam1= mysqli_query($con,"SELECT DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl ");
					$rJam1= mysqli_fetch_array($sqJam1);
				}?>	
<div class="box-body table-responsive">
<i style="font-size: 8px;"><strong>Tgl: <?php echo $rJam1['tgl']; ?> SHIFT: 1</strong></i>	
<table width="100%" border="0" id="tblr1" style="font-size: 8px;">
   <thead class="bg-blue" > 
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
      <td scope="col">Status</td>
      </tr>
	</thead>   
	<tbody>
	<?php 	
if($sf=="1" or $sf=="2"){
$sqlM=mysqli_query($con,"SELECT a.no_mesin,a.kapasitas,b.operator,b.g_shift,b.bruto,b.lama,b.warna,b.proses,b.tgl,b.tgl1,b.tgl2,if(not isnull(g_shift),1,'') as lotkeluar FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna,if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 2 DAY), '%Y-%m-%d' ) as tgl,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( now(), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 15:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0 
ORDER BY a.kapasitas DESC");	
}else{
$sqlM=mysqli_query($con,"SELECT a.no_mesin,a.kapasitas,b.operator,b.g_shift,b.bruto,b.lama,b.warna,b.proses,b.tgl,b.tgl1,b.tgl2,if(not isnull(g_shift),1,'') as lotkeluar FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 2 DAY), '%Y-%m-%d' ) as tgl,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0 and (not b.proses like 'Cuci Mesin%' or isnull(b.proses))
ORDER BY a.kapasitas DESC");	
}		

		while($rM=mysqli_fetch_array($sqlM)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
			?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
      <td align="center"><strong><?php echo  $rM['no_mesin']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['kapasitas']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['g_shift']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['operator']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['lotkeluar']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['bruto']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['lama']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['warna']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['proses']; ?></strong></td>
      <td>&nbsp;</td>
      </tr>
	<?php 
			if($rM['lotkeluar']!=""){
				$LK1=$rM['lotkeluar'];
			}else{
				$LK1=0;
			}
			$tLK1+=$LK1;
			$tKGS1+=$rM['bruto'];
		} ?>	
  </tbody>
  <tfoot class="bg-blue">
	<tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">Total</td>
      <td align="center"><?php echo $tLK1; ?></td>
      <td align="center"><?php echo $tKGS1; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	</tfoot>	
</table>

			  </div>
		  </div>
			<div class="col1-xs-3">
<?php 
				if($sf=="2" or $sf=="3"){
					$sqJam2= mysqli_query($con,"SELECT DATE_FORMAT( now(), '%Y-%m-%d' ) as tgl ");
					$rJam2= mysqli_fetch_array($sqJam2);
				}else{
					$sqJam2= mysqli_query($con,"SELECT DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl ");
					$rJam2= mysqli_fetch_array($sqJam2);
				}
?>			
<div class="box-body table-responsive">
<i style="font-size: 8px;"><strong>Tgl: <?php echo $rJam2['tgl']; ?> SHIFT: 2</strong></i>	
<table width="100%" border="0" id="tblr1" style="font-size: 8px;">
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
      <td scope="col">Status</td>
      </tr>
	</thead>   
	<tbody>
	<?php 
if($sf=="2" or $sf=="3"){
$sqlM=mysqli_query($con," SELECT a.no_mesin,a.kapasitas,b.operator,b.g_shift,b.bruto,b.lama,b.warna,b.proses,b.tgl,b.tgl1,b.tgl2,if(not isnull(g_shift),1,'') as lotkeluar FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna, if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 2 DAY), '%Y-%m-%d' ) as tgl,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( now(), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 23:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0
ORDER BY a.kapasitas DESC");
}else{

$sqlM=mysqli_query($con," SELECT a.no_mesin,a.kapasitas,b.operator,b.g_shift,b.bruto,b.lama,b.warna,b.proses,b.tgl,b.tgl1,b.tgl2,if(not isnull(g_shift),1,'') as lotkeluar FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 2 DAY), '%Y-%m-%d' ) as tgl,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 15:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0
ORDER BY a.kapasitas DESC");	
}
		while($rM=mysqli_fetch_array($sqlM)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
			?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
      <td align="center"><strong><?php echo  $rM['no_mesin']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['kapasitas']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['g_shift']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['operator']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['lotkeluar']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['bruto']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['lama']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['warna']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['proses']; ?></strong></td>
      <td>&nbsp;</td>
      </tr>
	<?php 
		if($rM['lotkeluar']!=""){
				$LK2=$rM['lotkeluar'];
			}else{
				$LK2=0;
			}
			$tLK2+=$LK2;
			$tKGS2+=$rM['bruto'];
		} ?>	
  </tbody>
  <tfoot class="bg-blue">
	<tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">Total</td>
      <td align="center"><?php echo $tLK2; ?></td>
      <td align="center"><?php echo $tKGS2; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	</tfoot>	
</table>

			  </div>
		  </div>
			<div class="col1-xs-3">
<?php 
				if($sf=="3"){
					$sqJam3= mysqli_query($con,"SELECT DATE_FORMAT( now(), '%Y-%m-%d' ) as tgl ");
					$rJam3= mysqli_fetch_array($sqJam3);
				}else{
					$sqJam3= mysqli_query($con,"SELECT DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl ");
					$rJam3= mysqli_fetch_array($sqJam3);
				}
?>									
<div class="box-body table-responsive">
<i style="font-size: 8px;"><strong>Tgl: <?php echo $rJam3['tgl']; ?> SHIFT: 3 </strong></i>	
<table width="100%" border="0" id="tblr1" style="font-size: 8px;">
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
      <td scope="col">Status</td>
      </tr>
	</thead>   
	<tbody>
	<?php $sqlM=mysqli_query($con," SELECT a.no_mesin,a.kapasitas,b.operator,b.g_shift,b.bruto,b.lama,b.warna,b.proses,b.tgl,b.tgl1,b.tgl2,if(not isnull(g_shift),1,'') as lotkeluar FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 2 DAY), '%Y-%m-%d' ) as tgl,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 23:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0
ORDER BY a.kapasitas DESC");
		while($rM=mysqli_fetch_array($sqlM)){
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';	
			?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
      <td align="center"><strong><?php echo  $rM['no_mesin']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['kapasitas']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['g_shift']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['operator']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['lotkeluar']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['bruto']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['lama']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['warna']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['proses']; ?></strong></td>
      <td>&nbsp;</td>
      </tr>    
	<?php 
		if($rM['lotkeluar']!=""){
				$LK3=$rM['lotkeluar'];
			}else{
				$LK3=0;
			}
			$tLK3+=$LK3;
			$tKGS3+=$rM['bruto'];
		} ?>	
  </tbody>
  <tfoot class="bg-blue">
	<tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">Total</td>
      <td align="center"><?php echo $tLK3; ?></td>
      <td align="center"><?php echo $tKGS3; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	</tfoot>	
</table>

			  </div>
		  </div>
			<div class="col1-xs-2">
<div class="box-body table-responsive">
<i style="font-size: 8px;"><strong>TOTAL LOT </strong></i>	
<table width="100%" border="0" id="tblr1" style="font-size: 8px;">
   <thead class="bg-blue"> 
	<tr align="center">
      <td scope="col">No Mesin</td>
      <td scope="col">Cap </td>
      <td scope="col"><?php echo substr($rJam['jskrng'],0,10); ?></td>
      <td scope="col"><?php echo substr($rJam['jsblm'],0,10); ?></td>
      </tr>
	</thead>   
	<tbody>
	<?php $sqlM=mysqli_query($con,"
	select x.*,y.jml as jmlsblm FROM
(select a.no_mesin,a.kapasitas, sum(lotkeluar) as jml from 
tbl_mesin a 
left join 
(SELECT a.no_mesin,if(not isnull(g_shift),1,0) as lotkeluar,b.tgl1,b.tgl2 FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL -1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( now(), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( DATE_SUB(now(), INTERVAL -1 DAY), '%Y-%m-%d 07:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0 
ORDER BY a.kapasitas desc) b on a.no_mesin =b.no_mesin
WHERE a.kapasitas > 0
group by a.no_mesin 
ORDER BY a.kapasitas desc) x
left join 
(select a.no_mesin,a.kapasitas, sum(lotkeluar) as jml from 
tbl_mesin a 
left join 
(SELECT a.no_mesin,if(not isnull(g_shift),1,0) as lotkeluar,b.tgl1,b.tgl2 FROM tbl_mesin a
left join 
( SELECT
	a.no_mesin,
	b.g_shift,
	b.operator_keluar as operator,
	a.jenis_kain,
	a.proses,
	a.warna,
	a.kategori_warna,	if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),b.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(b.lama_proses)*60)+MINUTE(b.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))) as lama,
	b.point,
	b.k_resep,
	if(a.target<(if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),(HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2)),((HOUR(b.lama_proses)+round(MINUTE(b.lama_proses)/60,2))-(HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))+round(MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))/60,2))))),'Over','OK') as ket,
	a.target,
	c.bruto,
	c.rol,
	c.tgl_buat AS tgl_in,
	b.tgl_buat AS tgl_out,
	DATE_FORMAT( DATE_SUB(now(), INTERVAL -1 DAY), '%Y-%m-%d' ) as tgl1,
	DATE_FORMAT( now( ), '%Y-%m-%d' ) as tgl2
FROM
	tbl_schedule a
	INNER JOIN tbl_montemp c ON a.id = c.id_schedule
	INNER JOIN tbl_hasilcelup b ON c.id = b.id_montemp 
WHERE
	a.`status` = 'selesai' AND (not a.proses like 'Cuci Mesin%' or isnull(a.proses))
	AND DATE_FORMAT( b.tgl_buat, '%Y-%m-%d %H:%i' ) BETWEEN DATE_FORMAT( DATE_SUB(now(), INTERVAL 1 DAY), '%Y-%m-%d 07:15' ) 
	AND DATE_FORMAT( now(), '%Y-%m-%d 07:14' )
) b on b.no_mesin=a.no_mesin 
WHERE a.kapasitas > 0 
ORDER BY a.kapasitas desc) b on a.no_mesin =b.no_mesin
WHERE a.kapasitas > 0
group by a.no_mesin 
ORDER BY a.kapasitas desc) y on x.no_mesin=y.no_mesin
 
");
		while($rM=mysqli_fetch_array($sqlM)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';	
			?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
      <td align="center"><strong><?php echo  $rM['no_mesin']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['kapasitas']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['jml']; ?></strong></td>
      <td align="center"><strong><?php echo  $rM['jmlsblm']; ?></strong></td>

      </tr>    
	<?php 
		$totJ+=$rM['jml'];
		$totJS+=$rM['jmlsblm'];	
		} ?>	
  </tbody>
  <tfoot class="bg-blue">
	  <tr>
      <td align="center">&nbsp;</td>
      <td align="center">Total</td>
      <td align="center"><?php echo $totJ; ?></td>
      <td align="center"><?php echo $totJS; ?></td>
    </tr>
	</tfoot>	
</table>

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
