<?php
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="180">
	<title>Status Mesin</title>

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

		.detail_status {
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
	</style> 
</head>

<body>
	<div class="row">
		<div class="col-xs-12">
			<div class="box table-responsive">
				<div class="box-header with-border">
					<h3 class="box-title">Status Mesin Dyeing ITTI</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<a href="pages/status-mesin-full.php" class="btn btn-xs" data-toggle="tooltip" data-html="true" data-placement="bottom" title="FullScreen"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<div class="box-body">
					<table border="0" width="100%">
						<thead>
							<tr>
								<?php
								function NoMesin($mc)
								{
									include "koneksi.php";
									$qMC = sqlsrv_query(
										$con,
										"SELECT 
											a.ket_status,
											CASE 
												WHEN DATEDIFF(DAY, a.tgl_delivery, GETDATE()) > 0 THEN 'Urgent'
												WHEN DATEDIFF(DAY, a.tgl_delivery, GETDATE()) > -4 THEN 'Potensi Delay'
												ELSE ''
											END AS sts
										FROM db_dying.tbl_schedule a 
										LEFT JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule
										WHERE a.no_mesin = ? 
										  AND (b.status = 'sedang jalan' OR a.status = 'antri mesin')
										ORDER BY a.no_urut ASC",
										array($mc)
									);
									$dMC = sqlsrv_fetch_array($qMC, SQLSRV_FETCH_ASSOC);

									$qLama = sqlsrv_query(
										$con,
										"SELECT 
											DATEDIFF(HOUR, GETDATE(), b.tgl_target) AS lama 
										FROM db_dying.tbl_schedule a
										LEFT JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule
										WHERE a.no_mesin = ? 
										  AND b.status = 'sedang jalan'
										ORDER BY a.no_urut ASC",
										array($mc)
									);
									$dLama = sqlsrv_fetch_array($qLama, SQLSRV_FETCH_ASSOC);

									if ($dMC['ket_status'] == "Tolak Basah") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "btn-warning blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "btn-warning border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "btn-warning blink_me";
										} else {
											$warnaMc = "btn-warning";
										}
									} else if ($dMC['ket_status'] == "Mini Bulk") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "btn-primary blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "btn-primary border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "btn-primary blink_me";
										} else {
											$warnaMc = "btn-primary";
										}
									} else if ($dMC['ket_status'] == "MC Stop") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-black blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-black border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-black blink_me";
										} else {
											$warnaMc = "bg-black";
										}
									} else if ($dMC['ket_status'] == "MC Rusak") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-abu blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-abu border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-abu blink_me";
										} else {
											$warnaMc = "bg-abu";
										}
									} else if ($dMC['ket_status'] == "MC Dibongkar") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-aqua blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-aqua border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-aqua blink_me";
										} else {
											$warnaMc = "bg-aqua";
										}
									} else if ($dMC['ket_status'] == "Test Proses") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-navy blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-navy border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-navy blink_me";
										} else {
											$warnaMc = "bg-navy";
										}
									} else if ($dMC['ket_status'] == "Cuci Misty") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-teal blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-teal border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-teal blink_me";
										} else {
											$warnaMc = "bg-teal";
										}
									} else if ($dMC['ket_status'] == "Kain Basah") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-maroon blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-maroon border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-maroon blink_me";
										} else {
											$warnaMc = "bg-maroon";
										}
									} else if ($dMC['ket_status'] == "Relaxing-Preset" or $dMC['ket_status'] == "Scouring-Preset" or $dMC['ket_status'] == "Continuous") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-purple blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-purple border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-purple blink_me";
										} else {
											$warnaMc = "bg-purple";
										}
									} else if ($dMC['ket_status'] == "Greige") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "btn-success blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "btn-success border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "btn-success blink_me";
										} else {
											$warnaMc = "btn-success";
										}
									} else if ($dMC['ket_status'] == "Perbaikan") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "btn-danger blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "btn-danger border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "btn-danger blink_me";
										} else {
											$warnaMc = "btn-danger";
										}
									} else if ($dMC['ket_status'] == "Gagal Proses") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-kuning blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {

											$warnaMc = "bg-kuning border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-kuning blink_me";
										} else {
											$warnaMc = "bg-kuning";
										}
									} else if ($dMC['ket_status'] == "Cuci YD") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-hijau blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-hijau border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-hijau blink_me";
										} else {
											$warnaMc = "bg-hijau";
										}
									} else if ($dMC['ket_status'] == "Development Sample") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-fuchsia blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-fuchsia border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-fuchsia blink_me";
										} else {
											$warnaMc = "bg-fuchsia";
										}
									} else if ($dMC['ket_status'] == "Salesmen Sample" or $dMC['ket_status'] == "First Lot") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-lime blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-lime border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-lime blink_me";
										} else {
											$warnaMc = "bg-lime";
										}
									} else if ($dMC['ket_status'] == "Cuci Mesin") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "bg-violet blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "bg-violet border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "bg-violet blink_me";
										} else {
											$warnaMc = "bg-violet";
										}
									} else if ($dMC['ket_status'] == "Greige Delay") {
										if ($dLama['lama'] < "1" and $dLama['lama'] != "") {
											$warnaMc = "btn-default blink_me1";
										} else if ($dMC['sts'] == "Potensi Delay") {
											$warnaMc = "'btn'-default border-dashed";
										} else if ($dMC['sts'] == "Urgent") {
											$warnaMc = "btn-default blink_me";
										} else {
											$warnaMc = "btn-default";
										}
									} else {
										$warnaMc = "btn-outline-custom";
									}

									return $warnaMc;
								}
								function Waktu($mc)
								{
									include "koneksi.php";

									// Hitung sisa waktu proses (lama) menggunakan SQL Server
									$qLama = sqlsrv_query(
										$con,
										"SELECT TOP 1
											b.tgl_buat,
											a.target,
											DATEADD(
												MINUTE,
												(CAST(FLOOR(a.target) AS INT) * 60) + CAST(ROUND((a.target - FLOOR(a.target)) * 100, 0) AS INT),
												b.tgl_buat
											) AS tgl_buat_target,
											CASE 
												WHEN b.tgl_mulai IS NOT NULL AND b.tgl_stop IS NOT NULL THEN
													a.target - 
													CAST(
														DATEDIFF(
															MINUTE,
															DATEADD(
																MINUTE,
																(CAST(FLOOR(a.target) AS INT) * 60) + CAST(ROUND((a.target - FLOOR(a.target)) * 100, 0) AS INT),
																b.tgl_buat
															),
															GETDATE()
														) - DATEDIFF(MINUTE, b.tgl_mulai, b.tgl_stop)
													AS FLOAT) / 60.0
												ELSE
													CAST(
														DATEDIFF(
															MINUTE,
															GETDATE(),
															DATEADD(
																MINUTE,
																(CAST(FLOOR(a.target) AS INT) * 60) + CAST(ROUND((a.target - FLOOR(a.target)) * 100, 0) AS INT),
																b.tgl_buat
															)
														)
													AS FLOAT) / 60.0
											END AS lama
										FROM db_dying.tbl_schedule a
										LEFT JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule
										WHERE a.no_mesin = ?
										  AND b.status = 'sedang jalan'
										ORDER BY a.no_urut ASC",
										array($mc)
									);

									$dLama = sqlsrv_fetch_array($qLama, SQLSRV_FETCH_ASSOC);

									if ($dLama && $dLama['lama'] !== null && $dLama['lama'] !== '') {
										// Format ke jam:menit (HH:MM) di PHP
										$minutes = (int)round($dLama['lama'] * 60);
										$hours = floor($minutes / 60);
										$mins = $minutes % 60;
										echo sprintf('%02d:%02d', $hours, $mins);
									} else {
										echo '';
									}
								}

								function InfoMesin($mc) {
								    include "koneksi.php";
								    $q = sqlsrv_query(
										$con,
										"SELECT TOP 1 a.no_order, a.langganan, a.warna, a.proses 
										 FROM db_dying.tbl_schedule a 
										 LEFT JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule 
										 WHERE a.no_mesin = ? AND b.status = 'sedang jalan' 
										 ORDER BY a.no_urut ASC",
										array($mc)
									);
								    $d = sqlsrv_fetch_array($q, SQLSRV_FETCH_ASSOC);
								    if ($d) {
								        return htmlspecialchars($d['no_order'] . ' | ' . $d['langganan'] . ' | ' . $d['warna'] . ' | ' . $d['proses']);
								    } else {
								        return 'Mesin: ' . $mc;
								    }
								}

								/* Total Status Mesin */
								$sqlStatus = sqlsrv_query($con, "SELECT no_mesin FROM db_dying.tbl_mesin");
								while ($rM = sqlsrv_fetch_array($sqlStatus, SQLSRV_FETCH_ASSOC)) {
									$sts = NoMesin($rM['no_mesin']);
									if (
										$sts == "btn-primary" or
										$sts == "btn-primary border-dashed" or
										$sts == "btn-primary blink_me1" or
										$sts == "btn-primary blink_me"
									) {
										$MB = "1";
									} else {
										$MB = "0";
									}
									if (
										$sts == "bg-purple" or
										$sts == "bg-purple border-dashed" or
										$sts == "bg-purple blink_me1" or
										$sts == "bg-purple blink_me"
									) {
										$SPT = "1";
									} else {
										$SPT = "0";
									}
									if (
										$sts == "btn-warning" or
										$sts == "btn-warning border-dashed" or
										$sts == "btn-warning blink_me1" or
										$sts == "btn-warning blink_me"
									) {
										$FL = "1";
									} else {
										$FL = "0";
									}
									if (
										$sts == "btn-danger" or
										$sts == "btn-danger border-dashed" or
										$sts == "btn-danger blink_me1" or
										$sts == "btn-danger blink_me"
									) {
										$PBK = "1";
									} else {
										$PBK = "0";
									}
									if (
										$sts == "btn-success" or
										$sts == "btn-success border-dashed" or
										$sts == "btn-success blink_me1" or
										$sts == "btn-success blink_me"
									) {
										$GRG = "1";
									} else {
										$GRG = "0";
									}
									if (
										$sts == "btn-default" or
										$sts == "btn-default border-dashed" or
										$sts == "btn-default blink_me1" or
										$sts == "btn-default blink_me"
									) {
										$GD = "1";
									} else {
										$GD = "0";
									}
									if (
										$sts == "bg-kuning" or
										$sts == "bg-kuning border-dashed" or
										$sts == "bg-kuning blink_me1" or
										$sts == "bg-kuning blink_me"
									) {
										$GPS = "1";
									} else {
										$GPS = "0";
									}
									if (
										$sts == "bg-hijau" or
										$sts == "bg-hijau border-dashed" or
										$sts == "bg-hijau blink_me1" or
										$sts == "bg-hijau blink_me"
									) {
										$CYD = "1";
									} else {
										$CYD = "0";
									}
									if (
										$sts == "bg-black" or
										$sts == "bg-black border-dashed" or
										$sts == "bg-black blink_me1" or
										$sts == "bg-black blink_me"
									) {
										$MCS = "1";
									} else {
										$MCS = "0";
									}
									if (
										$sts == "bg-abu" or
										$sts == "bg-abu border-dashed" or
										$sts == "bg-abu blink_me1" or
										$sts == "bg-abu blink_me"
									) {
										$MCR = "1";
									} else {
										$MCR = "0";
									}
									if (
										$sts == "bg-aqua" or
										$sts == "bg-aqua border-dashed" or
										$sts == "bg-aqua blink_me1" or
										$sts == "bg-aqua blink_me"
									) {
										$MCB = "1";
									} else {
										$MCB = "0";
									}
									if (
										$sts == "bg-teal" or
										$sts == "bg-teal border-dashed" or
										$sts == "bg-teal blink_me1" or
										$sts == "bg-teal blink_me"
									) {
										$CMY = "1";
									} else {
										$CMY = "0";
									}
									if (
										$sts == "bg-fuchsia" or
										$sts == "bg-fuchsia border-dashed" or
										$sts == "bg-fuchsia blink_me1" or
										$sts == "bg-fuchsia blink_me"
									) {
										$DTS = "1";
									} else {
										$DTS = "0";
									}
									if (
										$sts == "bg-lime" or
										$sts == "bg-lime border-dashed" or
										$sts == "bg-lime blink_me1" or
										$sts == "bg-lime blink_me"
									) {
										$SMS = "1";
									} else {
										$SMS = "0";
									}
									if (
										$sts == "bg-violet" or
										$sts == "bg-violet border-dashed" or
										$sts == "bg-violet blink_me1" or
										$sts == "bg-violet blink_me"
									) {
										$CMS = "1";
									} else {
										$CMS = "0";
									}
									if (
										$sts == "bg-abu border-dashed" or
										$sts == "bg-black border-dashed" or
										$sts == "bg-aqua border-dashed" or
										$sts == "bg-kuning border-dashed" or
										$sts == "bg-hijau border-dashed" or
										$sts == "btn-success border-dashed" or
										$sts == "btn-danger border-dashed" or
										$sts == "btn-warning border-dashed" or
										$sts == "btn-primary border-dashed" or
										$sts == "bg-teal border-dashed" or
										$sts == "bg-purple border-dashed" or
										$sts == "bg-fuchsia border-dashed" or
										$sts == "bg-lime border-dashed" or
										$sts == "bg-violet border-dashed"
									) {
										$PTD = "1";
									} else {
										$PTD = "0";
									}
									if (
										$sts == "bg-abu blink_me" or
										$sts == "bg-black blink_me" or
										$sts == "bg-aqua blink_me" or
										$sts == "bg-kuning blink_me" or
										$sts == "bg-hijau blink_me" or
										$sts == "btn-success blink_me" or
										$sts == "btn-danger blink_me" or
										$sts == "btn-warning blink_me" or
										$sts == "btn-primary blink_me" or
										$sts == "bg-teal blink_me" or
										$sts == "bg-fuchsia blink_me" or
										$sts == "bg-lime blink_me" or
										$sts == "bg-purple blink_me" or
										$sts == "bg-violet blink_me"
									) {
										$URG = "1";
									} else {
										$URG = "0";
									}

									$totPTD = $totPTD + $PTD;
									$totURG = $totURG + $URG;
									$totGRG = $totGRG + $GRG;
									$totCYD = $totCYD + $CYD;
									$totGPS = $totGPS + $GPS;
									$totPBK = $totPBK + $PBK;
									$totFL = $totFL + $FL;
									$totMB = $totMB + $MB;
									$totGD = $totGD + $GD;
									$totSPT = $totSPT + $SPT;
									$totMCR = $totMCR + $MCR;
									$totMCS = $totMCS + $MCS;
									$totMCB = $totMCB + $MCB;
									$totCMY = $totCMY + $CMY;
									$totDTS = $totDTS + $DTS;
									$totSMS = $totSMS + $SMS;
									$totCMS = $totCMS + $CMS;
								}

								$machinesByCapacity = array();

								$result = sqlsrv_query($con, "SELECT DISTINCT kapasitas FROM db_dying.tbl_mesin ORDER BY kapasitas DESC");

								while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
									$kapasitas = $row['kapasitas'];

									$machinesByCapacity[$kapasitas] = array();
								}

								$dataMesin = sqlsrv_query($con, "SELECT no_mesin, kapasitas FROM db_dying.tbl_mesin");

								while ($row = sqlsrv_fetch_array($dataMesin, SQLSRV_FETCH_ASSOC)) {
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

								$result = sqlsrv_query($con, "SELECT DISTINCT kapasitas FROM db_dying.tbl_mesin ORDER BY kapasitas DESC");

								while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
									$kapasitas = $row['kapasitas'];

									$machinesByCapacity[$kapasitas] = array();
								}

								$dataMesin = sqlsrv_query($con, "SELECT no_mesin, kapasitas FROM db_dying.tbl_mesin");

								while ($row = sqlsrv_fetch_array($dataMesin, SQLSRV_FETCH_ASSOC)) {
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
										echo '<div class="detail_status_orgatex btn btn-sm ' . NoMesin($machine['no_mesin']) . '" id="' . $machine['no_mesin'] . '" data-toggle="tooltip" data-html="true" title="' . InfoMesin($machine['no_mesin']) . '">';
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
								<td>Greige <span class="label label-success">&nbsp;<?php echo $totGRG; ?></span></td>
								<td>Gagal Proses <span class="label bg-kuning">&nbsp;<?php echo $totGPS; ?></span></td>
								<td>Tolak Basah <span class="label label-warning">&nbsp;<?php echo $totFL; ?></span></td>
								<td>Mini Bulk <span class="label label-primary">&nbsp;<?php echo $totMB; ?></span></td>
								<td>
									Development Sample <span class="label bg-fuchsia"> &nbsp;<?php echo $totDTS; ?></span>
								</td>
								<td>Urgent <span class="label bg-abu blink_me">&nbsp;<?php echo $totURG; ?></span></td>
								<td>Greige Delay <span class="label label-default"> &nbsp;<?php echo $totGD; ?></span></td>
								<td>Mesin Dibongkar <span class="label bg-aqua">&nbsp;<?php echo $totMCB; ?></span></td>
								<td>Mesin Rusak <span class="label bg-abu">&nbsp;<?php echo $totMCR; ?></span></td>
							</tr>
							<tr>
								<td>Cuci Y/D <span class="label bg-hijau">&nbsp;<?php echo $totCYD; ?></span></td>
								<td>Perbaikan <span class="label label-danger">&nbsp;<?php echo $totPBK; ?></span></td>
								<td>Cuci Misty <span class="label bg-teal">&nbsp;<?php echo $totCMY; ?></span></td>

								<td>
									Cont/Scour/Relax-Preset <span class="label btn-sm bg-purple">&nbsp;<?php echo $totSPT; ?></span>
								</td>
								<td>
									Salesmen Sample-1st Lot <span class="label bg-lime">&nbsp;<?php echo $totSMS; ?></span>
								</td>
								<td>Potensi Delay <span class="label bg-abu border-dashed">&nbsp;<?php echo $totPTD; ?></span></td>
								<td>Cuci Mesin <span class="label bg-violet">&nbsp;<?php echo $totCMS; ?></span></td>
								<td>Mesin Stop <span class="label btn-sm bg-black">&nbsp;<?php echo $totMCS; ?></span></td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<br>

					<marquee class="teks-berjalan" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
						<?php
						$news = sqlsrv_query($con, "SELECT STRING_AGG(news_line, ' :: ') as news_line FROM db_dying.tbl_news_line WHERE gedung = 'LT 1' AND status = 'Tampil'");
						$rNews = sqlsrv_fetch_array($news, SQLSRV_FETCH_ASSOC);
						$totMesin = '0';
						?>
						<?php echo $rNews['news_line']; ?>
					</marquee>

				</div>
			</div>
		</div>
	</div>
	<div id="CekDetailStatus" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
</body>
<!-- Tooltips -->
 <script src="./../bower_components/toast-master/js/jquery.toast.js"></script>
	<!-- Tooltips -->
	<script src="./../../dist/js/tooltips.js"></script>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip({container: 'body'});
			// Klik: tampilkan modal detail
			$(document).on('click', '.detail_status_orgatex', function(e) {
				var m = $(this).attr('id');
				$.ajax({
					url: 'pages/cek-status-mesin.php',
					type: 'GET',
					data: { id: m },
					success: function(ajaxData) {
						$('#CekDetailStatus').html(ajaxData);
						$('#CekDetailStatus').modal('show');
					},
					error: function() {
						$('#CekDetailStatus').html('<div class="modal-body">Gagal memuat detail mesin.</div>');
						$('#CekDetailStatus').modal('show');
					}
				});
			});
		});
	</script>

</html>
