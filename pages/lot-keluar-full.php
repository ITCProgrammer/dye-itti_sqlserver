<?php
ini_set("error_reporting", 1);
//session_start();
include "../koneksi.php";
include "../helpers.php";

$sqJam= sqlsrv_query($con,"SELECT 
							GETDATE() AS jskrng,
							CONVERT(VARCHAR(10), DATEADD(DAY, -1, GETDATE()), 120) AS jsblm;");
$rJam= sqlsrv_fetch_array($sqJam);

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
<div class="row">
	<div class="col-xs-3">
			<?php 
				if($sf=="1" or $sf=="2"){
					$sqJam1= sqlsrv_query($con,"SELECT FORMAT(GETDATE(), 'yyyy-MM-dd') AS tgl");
					$rJam1= sqlsrv_fetch_array($sqJam1);
				}else{
					$sqJam1= sqlsrv_query($con,"SELECT FORMAT(DATEADD(DAY, -1, GETDATE()), 'yyyy-MM-dd') AS tgl");
					$rJam1= sqlsrv_fetch_array($sqJam1);
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
			// echo 	$sf;
			if($sf=="1" or $sf=="2"){
				$query = "SELECT
							a.no_mesin,
							a.kapasitas,
							b.operator,
							b.g_shift,
							b.bruto,
							b.lama,
							b.warna,
							b.proses,
							b.tgl,
							b.tgl1,
							b.tgl2,
							CASE 
								WHEN g_shift IS NOT NULL THEN 1 
								ELSE NULL
							END AS lotkeluar
						FROM db_dying.tbl_mesin a
						LEFT JOIN (
						SELECT
								b.tgl_buat,
								a.no_mesin,
								b.g_shift,
								b.operator_keluar AS operator,
								a.jenis_kain,
								a.proses,
								a.warna,
								CASE
									WHEN TRY_CONVERT(time, b.lama_proses) IS NULL
										OR TRY_CONVERT(datetime, c.tgl_mulai) IS NULL
										OR TRY_CONVERT(datetime, c.tgl_stop) IS NULL
										THEN b.lama_proses
									ELSE
										RIGHT('0' + CAST(
											FLOOR((
												(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) * 60
												+ DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)))
												- DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
											) / 60) AS VARCHAR(2)), 2)
										+ ':' +
										RIGHT('0' + CAST(
											(
												(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) * 60
												+ DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)))
												- DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
											) % 60 AS VARCHAR(2)), 2)
								END AS lama,
								b.point,
								b.k_resep,
								CASE 
									WHEN a.target <
										(
											CASE 
												WHEN TRY_CONVERT(datetime, c.tgl_mulai) IS NULL
													OR TRY_CONVERT(datetime, c.tgl_stop) IS NULL
													THEN
														DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses))
														+ 
														ROUND(DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0, 2)
												ELSE
													(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses))+ ROUND(DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0, 2))
													-
													(DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai) / 60.0)
											END
										)
										THEN 'Over'
									ELSE 'OK'
								END AS ket,
								a.target,
								c.bruto,
								c.rol,
								c.tgl_buat AS tgl_in,
								b.tgl_buat AS tgl_out,
								CAST(CONVERT(date, DATEADD(DAY, -2, GETDATE())) AS varchar(10)) AS tgl,
								CAST(CONVERT(date, DATEADD(DAY, -1, GETDATE())) AS varchar(10)) AS tgl1,
								CAST(CONVERT(date, GETDATE()) AS varchar(10)) AS tgl2
							FROM db_dying.tbl_schedule a
							INNER JOIN db_dying.tbl_montemp c 
								ON a.id = c.id_schedule
							INNER JOIN db_dying.tbl_hasilcelup b 
								ON c.id = b.id_montemp
							WHERE 
								a.status = 'selesai'
								AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
								AND b.tgl_buat BETWEEN 
										CAST(CONVERT(date, GETDATE()) AS datetime) + '07:15'
									AND CAST(CONVERT(date, GETDATE()) AS datetime) + '15:14'
						--        AND b.tgl_buat BETWEEN '2025-12-15 07:15' AND '2025-12-15 15:14'
						) b ON b.no_mesin = a.no_mesin
						WHERE a.kapasitas > 0
						ORDER BY a.kapasitas DESC";	
				}else{
					$query = "SELECT
								a.no_mesin,
								a.kapasitas,
								b.operator,
								b.g_shift,
								b.bruto,
								b.lama,
								b.warna,
								b.proses,
								b.tgl,
								b.tgl1,
								b.tgl2,
								CASE WHEN b.g_shift IS NOT NULL THEN '1' ELSE '' END AS lotkeluar
							FROM db_dying.tbl_mesin a
							LEFT JOIN
							(
								SELECT
									DATEADD(MINUTE, (15*60)+14, CAST(DATEADD(DAY, -1, CONVERT(date, GETDATE())) AS datetime)) AS test,
									DATEADD(MINUTE, (7*60)+15, CAST(DATEADD(DAY, -1, CONVERT(date, GETDATE())) AS datetime)) AS test2,
									a.no_mesin,
									b.g_shift,
									b.operator_keluar AS operator,
									a.jenis_kain,
									a.proses,
									a.warna,
									CASE
										WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN 
											CONVERT(VARCHAR(5), b.lama_proses, 108)
										ELSE
											RIGHT('0' + CAST(
												FLOOR(
													(
														ISNULL(DATEDIFF(MINUTE, 0, TRY_CONVERT(time, b.lama_proses)),0)
														- ISNULL(DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai),0)
													) / 60
												) AS VARCHAR(2)
											), 2)
											+ ':' +
											RIGHT('0' + CAST(
												(
													ISNULL(DATEDIFF(MINUTE, 0, TRY_CONVERT(time, b.lama_proses)),0)
													- ISNULL(DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai),0)
												) % 60 AS VARCHAR(2)
											), 2)
									END AS lama,
									b.point,
									b.k_resep,
									CASE 
										WHEN a.target <
											(
												ISNULL(
													DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) 
													+ (DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0),
													0
												)
												-
												(ISNULL(DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai),0) / 60.0)
											)
										THEN 'Over'
										ELSE 'OK'
									END AS ket,
									a.target,
									c.bruto,
									c.rol,
									c.tgl_buat AS tgl_in,
									b.tgl_buat AS tgl_out,
									FORMAT(DATEADD(DAY, -2, GETDATE()), 'yyyy-MM-dd') AS tgl,
									FORMAT(DATEADD(DAY, -1, GETDATE()), 'yyyy-MM-dd') AS tgl1,
									FORMAT(GETDATE(), 'yyyy-MM-dd') AS tgl2
								FROM db_dying.tbl_schedule a
								INNER JOIN db_dying.tbl_montemp c ON a.id = c.id_schedule
								INNER JOIN db_dying.tbl_hasilcelup b ON c.id = b.id_montemp
								WHERE
									a.status = 'selesai'
									AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
									AND b.tgl_buat BETWEEN 
											DATEADD(MINUTE, (7*60)+15, CAST(DATEADD(DAY, -1, CONVERT(date, GETDATE())) AS datetime))
										AND DATEADD(MINUTE, (15*60)+14, CAST(DATEADD(DAY, -1, CONVERT(date, GETDATE())) AS datetime))
										) b
							ON b.no_mesin = a.no_mesin
							WHERE 
								a.kapasitas > 0
								AND (b.proses NOT LIKE 'Cuci Mesin%' OR b.proses IS NULL)
							ORDER BY 
								a.kapasitas DESC";	
								}
					// echo $query;
					$sqlM=sqlsrv_query($con,$query);	
					while($rM=sqlsrv_fetch_array($sqlM)){
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
<div class="col-xs-3">
			<?php 
				if($sf=="2" or $sf=="3"){
					$sqJam2= sqlsrv_query($con,"SELECT FORMAT(GETDATE(), 'yyyy-MM-dd') AS tgl");
					$rJam2= sqlsrv_fetch_array($sqJam2);
				}else{
					$sqJam2= sqlsrv_query($con,"SELECT FORMAT(DATEADD(DAY, -1, GETDATE()), 'yyyy-MM-dd') AS tgl");
					$rJam2= sqlsrv_fetch_array($sqJam2);
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
						$query = "SELECT
								a.no_mesin,
								a.kapasitas,
								b.operator,
								b.g_shift,
								b.bruto,
								b.lama,
								b.warna,
								b.proses,
								b.tgl,
								b.tgl1,
								b.tgl2,
								CASE 
									WHEN g_shift IS NOT NULL THEN 1 
									ELSE NULL
								END AS lotkeluar
							FROM db_dying.tbl_mesin a
							LEFT JOIN (
							SELECT
									b.tgl_buat,
									a.no_mesin,
									b.g_shift,
									b.operator_keluar AS operator,
									a.jenis_kain,
									a.proses,
									a.warna,
									CASE
										WHEN TRY_CONVERT(time, b.lama_proses) IS NULL
											OR TRY_CONVERT(datetime, c.tgl_mulai) IS NULL
											OR TRY_CONVERT(datetime, c.tgl_stop) IS NULL
											THEN b.lama_proses
										ELSE
											RIGHT('0' + CAST(
												FLOOR((
													(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) * 60
													+ DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)))
													- DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
												) / 60) AS VARCHAR(2)), 2)
											+ ':' +
											RIGHT('0' + CAST(
												(
													(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) * 60
													+ DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)))
													- DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
												) % 60 AS VARCHAR(2)), 2)
									END AS lama,
									b.point,
									b.k_resep,
									CASE 
										WHEN a.target <
											(
												CASE 
													WHEN TRY_CONVERT(datetime, c.tgl_mulai) IS NULL
														OR TRY_CONVERT(datetime, c.tgl_stop) IS NULL
														THEN
															DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses))
															+ 
															ROUND(DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0, 2)
													ELSE
														(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses))+ ROUND(DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0, 2))
														-
														(DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai) / 60.0)
												END
											)
											THEN 'Over'
										ELSE 'OK'
									END AS ket,
									a.target,
									c.bruto,
									c.rol,
									c.tgl_buat AS tgl_in,
									b.tgl_buat AS tgl_out,
									CAST(CONVERT(date, DATEADD(DAY, -2, GETDATE())) AS varchar(10)) AS tgl,
									CAST(CONVERT(date, DATEADD(DAY, -1, GETDATE())) AS varchar(10)) AS tgl1,
									CAST(CONVERT(date, GETDATE()) AS varchar(10)) AS tgl2
								FROM db_dying.tbl_schedule a
								INNER JOIN db_dying.tbl_montemp c 
									ON a.id = c.id_schedule
								INNER JOIN db_dying.tbl_hasilcelup b 
									ON c.id = b.id_montemp
								WHERE 
									a.status = 'selesai'
									AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
									AND b.tgl_buat BETWEEN 
											CAST(CONVERT(date, GETDATE()) AS datetime) + '15:15'
										AND CAST(CONVERT(date, GETDATE()) AS datetime) + '23:14'
							--        AND b.tgl_buat BETWEEN '2025-12-15 07:15' AND '2025-12-15 15:14'
							) b ON b.no_mesin = a.no_mesin
							WHERE a.kapasitas > 0
							ORDER BY a.kapasitas DESC";
						}else{
						$query= " SELECT
										a.no_mesin,
										a.kapasitas,
										b.operator,
										b.g_shift,
										b.bruto,
										b.lama,
										b.warna,
										b.proses,
										b.tgl,
										b.tgl1,
										b.tgl2,
										CASE WHEN b.g_shift IS NOT NULL THEN '1' ELSE '' END AS lotkeluar
									FROM 
										db_dying.tbl_mesin a
									LEFT JOIN
									(
										SELECT
											a.no_mesin,
											b.g_shift,
											b.operator_keluar AS operator,
											a.jenis_kain,
											a.proses,
											a.warna,
											CASE 
										WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN 
											CONVERT(VARCHAR(5), b.lama_proses, 108)
										ELSE
											(
												CASE 
													WHEN TRY_CONVERT(time, b.lama_proses) IS NOT NULL THEN
														DATEDIFF(MINUTE, 0, TRY_CONVERT(time, b.lama_proses))
													ELSE 
														0 
												END
												-
												CASE 
													WHEN c.tgl_mulai IS NOT NULL AND c.tgl_stop IS NOT NULL THEN
														DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
													ELSE 0
												END
											) END AS lama_raw,
											RIGHT('0' + CAST(FLOOR(
												CASE 
													WHEN TRY_CONVERT(time, b.lama_proses) IS NOT NULL THEN
														DATEDIFF(MINUTE, 0, TRY_CONVERT(time, b.lama_proses))
														- CASE WHEN c.tgl_mulai IS NOT NULL AND c.tgl_stop IS NOT NULL 
															THEN DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai) ELSE 0 END
													ELSE 0
												END
											/ 60) AS VARCHAR(2)), 2)
											+ ':' +
											RIGHT('0' + CAST(
												CASE 
													WHEN TRY_CONVERT(time, b.lama_proses) IS NOT NULL THEN
														DATEDIFF(MINUTE, 0, TRY_CONVERT(time, b.lama_proses))
														- CASE WHEN c.tgl_mulai IS NOT NULL AND c.tgl_stop IS NOT NULL 
															THEN DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai) ELSE 0 END
													ELSE 0
												END
											% 60 AS VARCHAR(2)), 2) AS lama,
											b.point,
											b.k_resep,
											CASE 
												WHEN a.target <
													(
														CASE 
															WHEN TRY_CONVERT(time, b.lama_proses) IS NULL THEN 0
															ELSE DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) 
																+ (DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0)
														END
														-
														(
															CASE 
																WHEN c.tgl_mulai IS NOT NULL AND c.tgl_stop IS NOT NULL THEN
																	DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai) / 60.0
																ELSE 0
															END
														)
													)
												THEN 'Over'
												ELSE 'OK'
											END AS ket,
											a.target,
											c.bruto,
											c.rol,
											c.tgl_buat AS tgl_in,
											b.tgl_buat AS tgl_out,
											FORMAT(DATEADD(DAY, -2, GETDATE()), 'yyyy-MM-dd') AS tgl,
											FORMAT(DATEADD(DAY, -1, GETDATE()), 'yyyy-MM-dd') AS tgl1,
											FORMAT(GETDATE(), 'yyyy-MM-dd') AS tgl2
										FROM db_dying.tbl_schedule a
										INNER JOIN db_dying.tbl_montemp c 
											ON a.id = c.id_schedule
										INNER JOIN db_dying.tbl_hasilcelup b 
											ON c.id = b.id_montemp
										WHERE 
											a.status = 'selesai'
											AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
											AND b.tgl_buat BETWEEN 
													DATEADD(MINUTE,  (15*60)+15, CAST(CAST(DATEADD(DAY,-1,GETDATE()) AS date) AS datetime))  
												AND DATEADD(MINUTE,  (23*60)+14, CAST(CAST(DATEADD(DAY,-1,GETDATE()) AS date) AS datetime))
									) b ON b.no_mesin = a.no_mesin
									WHERE 
										a.kapasitas > 0
									ORDER BY 
										a.kapasitas DESC;";	
						}
						// echo $query;
					$sqlM=sqlsrv_query($con,$query);
					while($rM=sqlsrv_fetch_array($sqlM)){
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
<div class="col-xs-3">
			<?php 
				if($sf=="3"){
					$sqJam3= sqlsrv_query($con,"SELECT FORMAT(GETDATE(), 'yyyy-MM-dd') AS tgl");
					$rJam3= sqlsrv_fetch_array($sqJam3);
				}else{
					$sqJam3= sqlsrv_query($con,"SELECT FORMAT(DATEADD(DAY, -1, GETDATE()), 'yyyy-MM-dd') AS tgl");
					$rJam3= sqlsrv_fetch_array($sqJam3);
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
			<?php $query = " SELECT
									a.no_mesin,
									a.kapasitas,
									b.operator,
									b.g_shift,
									b.bruto,
									b.lama,
									b.warna,
									b.proses,
									b.tgl,
									b.tgl1,
									b.tgl2,
									CASE 
										WHEN g_shift IS NOT NULL THEN 1 
										ELSE NULL
									END AS lotkeluar
								FROM db_dying.tbl_mesin a
								LEFT JOIN (
								SELECT
										b.tgl_buat,
										a.no_mesin,
										b.g_shift,
										b.operator_keluar AS operator,
										a.jenis_kain,
										a.proses,
										a.warna,
										CASE
											WHEN TRY_CONVERT(time, b.lama_proses) IS NULL
												OR TRY_CONVERT(datetime, c.tgl_mulai) IS NULL
												OR TRY_CONVERT(datetime, c.tgl_stop) IS NULL
												THEN b.lama_proses
											ELSE
												RIGHT('0' + CAST(
													FLOOR((
														(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) * 60
														+ DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)))
														- DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
													) / 60) AS VARCHAR(2)), 2)
												+ ':' +
												RIGHT('0' + CAST(
													(
														(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses)) * 60
														+ DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)))
														- DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
													) % 60 AS VARCHAR(2)), 2)
										END AS lama,
										b.point,
										b.k_resep,
										CASE 
											WHEN a.target <
												(
													CASE 
														WHEN TRY_CONVERT(datetime, c.tgl_mulai) IS NULL
															OR TRY_CONVERT(datetime, c.tgl_stop) IS NULL
															THEN
																DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses))
																+ 
																ROUND(DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0, 2)
														ELSE
															(DATEPART(HOUR, TRY_CONVERT(time, b.lama_proses))+ ROUND(DATEPART(MINUTE, TRY_CONVERT(time, b.lama_proses)) / 60.0, 2))
															-
															(DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai) / 60.0)
													END
												)
												THEN 'Over'
											ELSE 'OK'
										END AS ket,
										a.target,
										c.bruto,
										c.rol,
										c.tgl_buat AS tgl_in,
										b.tgl_buat AS tgl_out,
										CAST(CONVERT(date, DATEADD(DAY, -2, GETDATE())) AS varchar(10)) AS tgl,
										CAST(CONVERT(date, DATEADD(DAY, -1, GETDATE())) AS varchar(10)) AS tgl1,
										CAST(CONVERT(date, GETDATE()) AS varchar(10)) AS tgl2
									FROM db_dying.tbl_schedule a
									INNER JOIN db_dying.tbl_montemp c 
										ON a.id = c.id_schedule
									INNER JOIN db_dying.tbl_hasilcelup b 
										ON c.id = b.id_montemp
									WHERE 
										a.status = 'selesai'
										AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
										AND b.tgl_buat BETWEEN 
												DATEADD(MINUTE, 1394, CAST(CONVERT(VARCHAR(10), DATEADD(DAY, -1, GETDATE()), 120) AS DATETIME))
											AND DATEADD(MINUTE, 434, CAST(CONVERT(VARCHAR(10), GETDATE(), 120) AS DATETIME))
								--        AND b.tgl_buat BETWEEN '2025-12-15 07:15' AND '2025-12-15 15:14'
								) b ON b.no_mesin = a.no_mesin
								WHERE a.kapasitas > 0
								ORDER BY a.kapasitas DESC";
				// echo $query;
				$sqlM=sqlsrv_query($con,$query);
				while($rM=sqlsrv_fetch_array($sqlM)){
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
<div class="col-xs-2">
<div class="box-body table-responsive">
	<i style="font-size: 8px;"><strong>TOTAL LOT </strong></i>	
	<table width="100%" border="0" id="tblr1" style="font-size: 8px;">
		<thead class="bg-blue"> 
			<tr align="center">
				<td scope="col">No Mesin</td>
				<td scope="col">Cap </td>
				<td scope="col"><?php echo formatDateTime($rJam['jskrng'],'Y-m-d'); ?></td>
				<td scope="col"><?php echo formatDateTime($rJam['jsblm'],'Y-m-d'); ?></td>
			</tr>
		</thead>   
		<tbody>
				<?php 
					$sql = "SELECT 
								x.*, 
								y.jml AS jmlsblm
							FROM 
							(
								SELECT
									a.no_mesin,
									a.kapasitas,
									SUM(b.lotkeluar) AS jml
								FROM db_dying.tbl_mesin a
								LEFT JOIN (
									SELECT
										a.no_mesin,
										CASE WHEN b.g_shift IS NOT NULL THEN 1 ELSE 0 END AS lotkeluar,
										CONVERT(date, DATEADD(day, +1, GETDATE())) AS tgl1,
										CONVERT(date, GETDATE()) AS tgl2
									FROM db_dying.tbl_mesin a
									LEFT JOIN (
										SELECT
											a.no_mesin,
											b.g_shift,
											b.operator_keluar AS operator,
											a.jenis_kain,
											a.proses,
											a.warna,
											a.kategori_warna,
											CASE 
												WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL 
													THEN CONVERT(VARCHAR(5), b.lama_proses, 108)
												ELSE
													RIGHT('0' + CAST(
														FLOOR(((DATEPART(HOUR,b.lama_proses)*60 + DATEPART(MINUTE,b.lama_proses)) 
															- DATEDIFF(MINUTE,c.tgl_stop,c.tgl_mulai)) / 60) AS VARCHAR(2))
													,2)
													+ ':' +
													RIGHT('0' + CAST(
														((DATEPART(HOUR,b.lama_proses)*60 + DATEPART(MINUTE,b.lama_proses)) 
														- DATEDIFF(MINUTE,c.tgl_stop,c.tgl_mulai)) % 60 AS VARCHAR(2))
													,2)
											END AS lama,
											b.point,
											b.k_resep,
											CASE 
												WHEN a.target <
												(
													CASE 
														WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN
															DATEPART(HOUR,b.lama_proses) + (DATEPART(MINUTE,b.lama_proses)/60.0)
														ELSE
															DATEPART(HOUR,b.lama_proses) + (DATEPART(MINUTE,b.lama_proses)/60.0)
															- (DATEDIFF(MINUTE,c.tgl_stop,c.tgl_mulai)/60.0)
													END
												) THEN 'Over'
												ELSE 'OK'
											END AS ket,
											a.target,
											c.bruto,
											c.rol,
											c.tgl_buat AS tgl_in,
											b.tgl_buat AS tgl_out
										FROM db_dying.tbl_schedule a
										INNER JOIN db_dying.tbl_montemp c ON a.id = c.id_schedule
										INNER JOIN db_dying.tbl_hasilcelup b ON c.id = b.id_montemp
										WHERE 
											a.status = 'selesai'
											AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
											AND b.tgl_buat BETWEEN 
												DATEADD(MINUTE, 435, CONVERT(datetime, CONVERT(date, GETDATE()))) 
												AND DATEADD(MINUTE, 434, DATEADD(day, +1, CONVERT(datetime, CONVERT(date, GETDATE()))))
									) b ON b.no_mesin = a.no_mesin
								) b ON b.no_mesin = a.no_mesin
								WHERE a.kapasitas > 0
								GROUP BY a.no_mesin, a.kapasitas
							) x
							LEFT JOIN
							(
								SELECT
									a.no_mesin,
									a.kapasitas,
									SUM(b.lotkeluar) AS jml
								FROM db_dying.tbl_mesin a
								LEFT JOIN (
									SELECT
										a.no_mesin,
										CASE WHEN b.g_shift IS NOT NULL THEN 1 ELSE 0 END AS lotkeluar
									FROM db_dying.tbl_mesin a
									LEFT JOIN (
										SELECT
											a.no_mesin,
											b.g_shift,
											b.operator_keluar AS operator,
											a.jenis_kain,
											a.proses,
											a.warna,
											a.kategori_warna,
											CASE 
												WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL 
													THEN CONVERT(VARCHAR(5), b.lama_proses, 108)
												ELSE
													RIGHT('0' + CAST(
														FLOOR(((DATEPART(HOUR,b.lama_proses)*60 + DATEPART(MINUTE,b.lama_proses)) 
															- DATEDIFF(MINUTE,c.tgl_stop,c.tgl_mulai)) / 60) AS VARCHAR(2))
													,2)
													+ ':' +
													RIGHT('0' + CAST(
														((DATEPART(HOUR,b.lama_proses)*60 + DATEPART(MINUTE,b.lama_proses)) 
														- DATEDIFF(MINUTE,c.tgl_stop,c.tgl_mulai)) % 60 AS VARCHAR(2))
													,2)
											END AS lama,
											b.point,
											b.k_resep,
											CASE 
												WHEN a.target <
												(
													CASE 
														WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN
															DATEPART(HOUR,b.lama_proses) + (DATEPART(MINUTE,b.lama_proses)/60.0)
														ELSE
															DATEPART(HOUR,b.lama_proses) + (DATEPART(MINUTE,b.lama_proses)/60.0)
															- (DATEDIFF(MINUTE,c.tgl_stop,c.tgl_mulai)/60.0)
													END
												) THEN 'Over'
												ELSE 'OK'
											END AS ket,
											a.target,
											c.bruto,
											c.rol,
											c.tgl_buat AS tgl_in,
											b.tgl_buat AS tgl_out
										FROM db_dying.tbl_schedule a
										INNER JOIN db_dying.tbl_montemp c ON a.id = c.id_schedule
										INNER JOIN db_dying.tbl_hasilcelup b ON c.id = b.id_montemp
										WHERE 
											a.status = 'selesai'
											AND (a.proses NOT LIKE 'Cuci Mesin%' OR a.proses IS NULL)
											AND b.tgl_buat BETWEEN 
												DATEADD(MINUTE, 435, DATEADD(day, -1, CONVERT(datetime, CONVERT(date, GETDATE()))))
												AND DATEADD(MINUTE, 434, CONVERT(datetime, CONVERT(date, GETDATE())))
									) b ON b.no_mesin = a.no_mesin
								) b ON b.no_mesin = a.no_mesin
								WHERE a.kapasitas > 0
								GROUP BY a.no_mesin, a.kapasitas
							) y ON x.no_mesin = y.no_mesin
							ORDER BY x.kapasitas DESC";
					$sqlM=sqlsrv_query($con,$sql);
					while($rM=sqlsrv_fetch_array($sqlM)){
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
