<?php
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="30">
	<title>Status Mesin Orgatex</title>

	<style>
		.btn-outline-custom {
			outline: 1px solid #CCCCCC;
		}

		.wrap {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}

		.wrap div {
			width: 50px;
			height: 50px;
			margin: 3px 6px 3px 6px;
			padding: 0;
			text-align: center;
		}

		.detail_status_orgatex {
			display: inline-block;
			text-align: center;
		}

		.machine_number {
			display: block;
		}

		.machine_time {
			font-size: 10px;
		}


		td {
			padding: 1px 0px;

		}

		p {
			line-height: 4px;
			font-size: 10px;
		}
	</style>
	<style type="text/css">
		.teks-berjalan {
			background-color: #03165E;
			color: #F4F0F0;
			font-family: monospace;
			font-size: 24px;
			font-style: italic;
		}
	.blink_me {  animation: blinker 1s linear infinite;
}
    </style>
</head>

<body>
	<div class="row">
		<div class="col-xs-12">
			<div class="box table-responsive">
				<div class="box-header with-border">
					<h3 class="box-title">Status Mesin Dyeing ITTI-Orgatex</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<a href="pages/status-mesin-full-orgatex-dye-bawah.php" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="Dyeing Bawah" target="_blank"><i class="fa fa-expand"></i> 1</a>
						<a href="pages/status-mesin-full-orgatex-dye-atas.php" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="Dyeing Atas"  target="_blank"><i class="fa fa-expand"></i> 2</a>						
						<a href="pages/status-mesin-full-orgatex-bawah-knt.php" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="Bawah Knitting"  target="_blank"><i class="fa fa-expand"></i> 3</a>
						
					</div>
				</div>
				<div class="box-body">
					<table border="0" width="100%">
						<thead>
							<tr>
<?php
function NoMesin($mc)
{
	// Menghubungkan ke database
    include "koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

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
		$warnaMc="bg-abu border-dashed";
	}else if ($row['Run State']=='No Batch' and $row['Online State']=='ON'){
		$warnaMc="bg-abu";	
	}else if($row['Run State']=='Batch Running' and $row['Online State']=='OFF'){	
		$warnaMc="bg-green border-dashed";
	}else if($row['Run State']=='Batch Running' and $row['Online State']=='ON'){	
		$warnaMc="bg-green";	
	}else if($row['Run State']=='Controller Stopped' and $row['Online State']=='OFF'){	
		$warnaMc="bg-black border-dashed";
	}else if($row['Run State']=='Controller Stopped' and $row['Online State']=='ON'){	
		$warnaMc="bg-black";
	}else if($row['Run State']=='Manual Operation' and $row['Online State']=='OFF'){	
		$warnaMc="bg-yellow border-dashed";	
	}else if($row['Run State']=='Manual Operation' and $row['Online State']=='ON'){	
		$warnaMc="bg-yellow";
	}else if($row['Run State']=='Finished' and $row['Online State']=='OFF'){	
		$warnaMc="bg-red border-dashed";
	}else if($row['Run State']=='Finished' and $row['Online State']=='ON'){	
		$warnaMc="bg-red";	
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
		include "koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

	}

	function Waktu($mc){
	// Menghubungkan ke database
    include "koneksiORGATEX.php"; // Memastikan file koneksi sudah benar

    // Membuat query untuk mengambil data DyelotRefNo dari tabel MachineStatus
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
		$wkt=$jam.":".$menit;
	}
    return $wkt; // Kembalikan nilai DyelotRefNo saja		
    }

$result = mysqli_query($con, "SELECT DISTINCT kapasitas FROM tbl_mesin ORDER BY kapasitas DESC");

								while ($row = mysqli_fetch_assoc($result)) {
									$kapasitas = $row['kapasitas'];

									$machinesByCapacity[$kapasitas] = array();
								}

								$dataMesin = mysqli_query($con, "SELECT no_mesin, kapasitas FROM tbl_mesin");

								while ($row = mysqli_fetch_assoc($dataMesin)) {
									$kapasitas = $row['kapasitas'];
									$machinesByCapacity[$kapasitas][] = $row;
								}

								foreach ($machinesByCapacity as $capacity => $machines) {
									$countMachine = count($machines);
									$length = 0;
									if ($countMachine <= 5) {
										$length = 1;
									} else if ($countMachine <= 10) {
										$length = 2;
									} else {
										$length = 3;
									}
									$width = 62 * $length;

									$backgroundColor = '';
									switch ($capacity) {
										case '2400':
											$backgroundColor = 'bg-purple';
											break;
										case '1800':
											$backgroundColor = 'bg-black';
											break;
										case '1200':
											$backgroundColor = 'bg-blue';
											break;
										case '900':
											$backgroundColor = 'bg-yellow';
											break;
										case '800':
											$backgroundColor = 'bg-red';
											break;
										case '750':
											$backgroundColor = 'bg-purple';
											break;
										case '600':
											$backgroundColor = 'bg-black';
											break;
										case '400':
											$backgroundColor = 'bg-abu';
											break;
										case '300':
											$backgroundColor = 'bg-fuchsia';
											break;
										case '200':
											$backgroundColor = 'bg-aqua';
											break;
										case '150':
											$backgroundColor = 'bg-yellow';
											break;
										case '100':
											$backgroundColor = 'bg-info';
											break;
										case '50':
											$backgroundColor = 'bg-maroon';
											break;
										case '30':
											$backgroundColor = 'bg-green';
											break;
										case '20':
											$backgroundColor = 'bg-gray';
											break;
										case '10':
											$backgroundColor = 'bg-lime';
											break;
										case '5':
											$backgroundColor = 'bg-blue';
											break;
										case '0':
											$backgroundColor = 'bg-teal';
											break;
										default:
											$backgroundColor = 'bg-primary';
											break;
									}

									echo '<td align="center" style="width:' . $width . 'px; padding: 0; vertical-align: top;" class="' . $backgroundColor . '">' . $capacity . ' KGs</td>';
								}
								?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								$machinesByCapacity = array();

								$result = mysqli_query($con, "SELECT DISTINCT kapasitas FROM tbl_mesin ORDER BY kapasitas DESC");

								while ($row = mysqli_fetch_assoc($result)) {
									$kapasitas = $row['kapasitas'];

									$machinesByCapacity[$kapasitas] = array();
								}

								$dataMesin = mysqli_query($con, "SELECT no_mesin, kapasitas FROM tbl_mesin");

								while ($row = mysqli_fetch_assoc($dataMesin)) {
									$kapasitas = $row['kapasitas'];
									$machinesByCapacity[$kapasitas][] = $row;
								}


								foreach ($machinesByCapacity as $capacity => $machines) {
									$countMachine = count($machines);
									asort($machines);
									$length = 0;
									if ($countMachine <= 5) {
										$length = 1;
									} else if ($countMachine <= 10) {
										$length = 2;
									} else {
										$length = 3;
									}
									$width = 62 * $length;

									echo '<td align="center" bgcolor="#E0DDDD" style="width:' . $width . 'px; padding: 0; vertical-align: top;">';

									echo '<div class="wrap">';
									foreach ($machines as $machine) {
										echo '<div class="detail_status_orgatex btn btn-sm ' . NoMesin($machine['no_mesin']) . '" " id="' . $machine['no_mesin'] . '" data-toggle="tooltip" data-html="true">';
										echo '<span class="machine_number">' . $machine['no_mesin'] . '</span>';
										echo '<p class="machine_time">' . Waktu($machine['no_mesin']) . '</p>';
										echo '</div>';
									}



									echo '</div>';

									echo '</td>';
								}
								?>
							</tr>
						</tbody>
					</table>
					<br>
					<table width="100%">
						<tbody>
							<tr>
								<td>Controller Stopped <span class="label btn-sm bg-black border-dashed">&nbsp;<?php echo $totMCS;?></span></td>
								<td>No Batch <span class="label bg-abu border-dashed">&nbsp;<?php echo $totMCR;?></span></td>
								<td>Batch Running <span class="label label-success border-dashed">&nbsp;<?php echo $totGRG;?></span></td>
								<td>Manual Operation <span class="label bg-yellow border-dashed">&nbsp;<?php echo $totMCR;?></span></td>
								<td><span style="padding: 1px;">Finished <span class="label bg-red">&nbsp;<?php echo $totMCR;?></span></span></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Controller Stopped and Connect <span class="label btn-sm bg-black">&nbsp;<?php echo $totMCS;?></span></td>
								<td><span style="padding: 1px;">No Batch and Connect <span class="label bg-abu">&nbsp;<?php echo $totMCR;?></span></span></td>
								<td>Batch Running and Connect<span class="label label-success">&nbsp;<?php echo $totGRG;?></span></td>

								<td>Manual Operation and Connect<span class="label bg-yellow">&nbsp;<?php echo $totMCR;?></span></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<br>

					<marquee class="teks-berjalan" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
						<?php
						$news = mysqli_query($con, "SELECT GROUP_CONCAT(news_line SEPARATOR ' :: ') as news_line FROM tbl_news_line WHERE gedung='LT 1' AND status='Tampil'");
						$rNews = mysqli_fetch_array($news);
						$totMesin = '0';
						?>
						<?php echo $rNews['news_line']; ?>
					</marquee>

				</div>
			</div>
		</div>
	</div>
	<div id="CekDetailStatusOrgatex" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
</body>
<!-- Tooltips -->
<script src="dist/js/tooltips.js"></script>
<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>

</html>