<script>
	function no_msn() {
		if (document.forms['form1']['kapasitas'].value == "2400") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option></option><option value='1401'>1401</option><option value='1406'>1406</option>";
		} else if (document.forms['form1']['kapasitas'].value == "1800") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1103'>1103</option><option value='1107'>1107</option><option value='1411'>1411</option>";
		} else if (document.forms['form1']['kapasitas'].value == "1200") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih<option value='1104'>1104</option><option value='1108'>1108</option><option value='1402'>1402</option><option value='1420'>1420</option><option value='1421'>1421</option><option value='2348'>2348</option>";
		} else if (document.forms['form1']['kapasitas'].value == "900") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1114'>1114</option>";
		} else if (document.forms['form1']['kapasitas'].value == "800") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='2229'>2229</option><option value='2246'>2246</option><option value='2247'>2247</option><option value='2625'>2625</option><option value='2627'>2627</option><option value='2634'>2634</option><option value='2636'>2636</option>";
		} else if (document.forms['form1']['kapasitas'].value == "750") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1505'>1505</option>";
		} else if (document.forms['form1']['kapasitas'].value == "600") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1115'>1115</option><option value='1116'>1116</option><option value='1117'>1117</option><option value='1410'>1410</option><option value='1451'>1451</option><option value='2632'>2632</option><option value='2633'>2633</option><option value='1474'>1474</option>";
		} else if (document.forms['form1']['kapasitas'].value == "400") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='2230'>2230</option><option value='2231'>2231</option>";
		} else if (document.forms['form1']['kapasitas'].value == "300") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1118'>1118</option><option value='1412'>1412</option><option value='1413'>1413</option><option value='1419'>1419</option><option value='1449'>1449</option>";
		} else if (document.forms['form1']['kapasitas'].value == "200") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='2228'>2228</option>";
		} else if (document.forms['form1']['kapasitas'].value == "150") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1409'>1409</option><option value='1450'>1450</option>";
		} else if (document.forms['form1']['kapasitas'].value == "100") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1452'>1452</option><option value='1453'>1453</option><option value='1458'>1458</option><option value='2622'>2622</option><option value='2623'>2623</option><option value='2665'>2665</option><option value='2666'>2666</option><option value='2667'>2667</option>";
		} else if (document.forms['form1']['kapasitas'].value == "50") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1482'>1482</option><option value='1481'>1481</option><option value='1477'>1477</option><option value='1476'>1476</option><option value='1454'>1454</option><option value='1455'>1455</option><option value='1456'>1456</option><option value='1457'>1457</option><option value='1459'>1459</option><option value='2624'>2624</option><option value='2635'>2635</option><option value='2660'>2660</option><option value='2661'>2661</option><option value='2662'>2662</option><option value='2663'>2663</option><option value='2664'>2664</option>";
		} else if (document.forms['form1']['kapasitas'].value == "30") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1478'>1478</option><option value='1475'>1475</option><option value='2626'>2626</option>";
		} else if (document.forms['form1']['kapasitas'].value == "20") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='2042'>2042</option><option value='2043'>2043</option><option value='2044'>2044</option><option value='2045'>2045</option><option value='2639'>2639</option><option value='2640'>2640</option><option value='2641'>2641</option>";
		} else if (document.forms['form1']['kapasitas'].value == "10") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='2638'>2638</option>";
		} else if (document.forms['form1']['kapasitas'].value == "5") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='1468'>1468</option></option><option value='1469'>1469</option><option value='1470'>1470</option></option><option value='1471'>1471</option><option value='1472'>1472</option></option><option value='1473'>1473</option>";
		} else if (document.forms['form1']['kapasitas'].value == "0") {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option><option value='WS11'>WS11</option><option value='CB11'>CB11</option>";
		} else {
			document.getElementById("no_mesin").innerHTML = "<option value=''>Pilih</option>";
		}
	}

	function hload() {
		var nokk = document.forms['form1']['nokk'].value;
		var bruto = document.forms['form1']['qty4'].value;
		var kap = document.forms['form1']['kapasitas'].value;
		var loading;
		if (nokk != "") {
			loading = roundToTwo((bruto * 100) / kap).toFixed(2);
			document.forms['form1']['loading'].value = loading;
		}
	}

	function aktif() {
		if (document.forms['form1']['kodesm'].value == "") {
			document.form1.waktu_mulai.setAttribute("disabled", true);
			document.form1.waktu_mulai.removeAttribute("required");
			document.form1.waktu_stop.setAttribute("disabled", true);
			document.form1.waktu_stop.removeAttribute("required");
			document.form1.datepicker.setAttribute("disabled", true);
			document.form1.datepicker.removeAttribute("required");
			document.form1.datepicker3.setAttribute("disabled", true);
			document.form1.datepicker3.removeAttribute("required");
		} else {
			document.form1.waktu_mulai.removeAttribute("disabled");
			document.form1.waktu_mulai.setAttribute("required", true);
			document.form1.waktu_stop.removeAttribute("disabled");
			document.form1.waktu_stop.setAttribute("required", true);
			document.form1.datepicker.removeAttribute("disabled");
			document.form1.datepicker.setAttribute("required", true);
			document.form1.datepicker3.removeAttribute("disabled");
			document.form1.datepicker3.setAttribute("required", true);

		}

	}

	function aktif1() {
		if (document.forms['form1']['dyestuff'].value == "D") {
			document.form1.suhu_poly.removeAttribute("readonly");
			document.form1.suhu_poly.setAttribute("required", true);
			document.form1.ph_poly.removeAttribute("readonly");
			document.form1.ph_poly.setAttribute("required", true);
			document.form1.k_resep.removeAttribute("disabled");
			document.form1.k_resep.setAttribute("required", true);

		} else {
			document.form1.suhu_poly.setAttribute("readonly", true);
			document.form1.suhu_poly.removeAttribute("required");
			document.form1.ph_poly.setAttribute("readonly", true);
			document.form1.ph_poly.removeAttribute("required");
			document.form1.k_resep.setAttribute("disabled", true);
			document.form1.k_resep.removeAttribute("required");
		}
	}

	function aktif2() {
		if (document.forms['form1']['sts'].value == "1" || document.forms['form1']['sts'].value == "5") {
			document.form1.k_resep.removeAttribute("disabled");
			document.form1.k_resep.setAttribute("required", true);
		} else {
			document.form1.k_resep.setAttribute("disabled", true);
			document.form1.k_resep.removeAttribute("required");
		}
	}
</script>
<?php
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
$today = date("Y-m-d");
//Cari no_stop terakhir pada hari ini
$sql = "SELECT max(no_stop) FROM tbl_stopmesin WHERE tgl_buat LIKE '$today%'";
$query = mysqli_query($con, $sql) or die(mysqli_error());

$stopno = mysqli_fetch_array($query);

if ($stopno) {
	$nilai = substr($stopno[0], 8);
	$kode = (int) $nilai;

	//tambahkan sebanyak + 1
	$tahun = substr(date("Y"), 2, 2);
	$tgl = date("md");
	$kode = $kode + 1;
	$auto_kode = "SM" . $tahun . $tgl . str_pad($kode, 2, "0",  STR_PAD_LEFT);
} else {
	$auto_kode = "SM20100101";
}
?>
<?php
$nostop = $_GET['no_stop'];
$sqlCek = mysqli_query($con, "SELECT
	a.*,b.id as idm 
FROM
	tbl_schedule a
INNER JOIN tbl_montemp b ON a.id=b.id_schedule	
WHERE
	a.nokk = '$nokk' 
ORDER BY
	a.id DESC 
	LIMIT 1");
$cek = mysqli_num_rows($sqlCek);
$rcek = mysqli_fetch_array($sqlCek);
?>
<?php
$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
$Item		= isset($_POST['item']) ? $_POST['item'] : '';
$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
?>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Input Data Stop Mesin</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="no_stop" class="col-sm-3 control-label">No Stop Mesin</label>
					<div class="col-sm-4">
						<input name="no_stop" type="text" class="form-control" id="no_stop" value="<?php echo $auto_kode; ?>" placeholder="" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="shift" class="col-sm-3 control-label">Shift</label>
					<div class="col-sm-2">
						<select name="shift" class="form-control" required>
							<option value="">Pilih</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="g_shift" class="col-sm-3 control-label">Group Shift</label>
					<div class="col-sm-2">
						<select name="g_shift" class="form-control" required>
							<option value="">Pilih</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="kapasitas" class="col-sm-3 control-label">Kapasitas Mesin</label>
					<div class="col-sm-3">
						<select name="kapasitas" onchange="window.location='?p=Form-Stop-Mesin&kap='+this.value" class="form-control">
							<option value="">Pilih</option>
							<?php
								$sqlKap = mysqli_query($con, "SELECT kapasitas FROM tbl_mesin GROUP BY kapasitas ORDER BY kapasitas DESC");
								while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['kapasitas']; ?>" <?php if ($_GET['kap'] == $rK['kapasitas']) {
																					echo "SELECTED";
																				} ?>><?php echo $rK['kapasitas']; ?> KGs</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="no_mesin" class="col-sm-3 control-label">No MC</label>
					<div class="col-sm-2">
						<select name="no_mesin" class="form-control" required>
							<option value="">Pilih</option>
							<?php if($_GET['kap']) : ?>
								<?php
									$sqlKap = mysqli_query($con, "SELECT no_mesin FROM tbl_mesin WHERE kapasitas='$_GET[kap]' ORDER BY no_mesin ASC");
									while ($rK = mysqli_fetch_array($sqlKap)) {
								?>
									<option value="<?php echo $rK['no_mesin']; ?>"><?php echo $rK['no_mesin']; ?></option>
								<?php } ?>	 
							<?php endif; ?>	 
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="proses" class="col-sm-3 control-label">Proses</label>
					<div class="col-sm-5">
						<select name="proses" class="form-control" id="proses" required>
							<option value="">Pilih</option>
							<option <?php if ($rcek['proses'] == "Stop") { ?> selected=selected <?php }; ?>value="Stop">Stop</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="kodesm" class="col-sm-3 control-label">Kode Stop Mesin</label>
					<div class="col-sm-2">
						<select name="kodesm" class="form-control" onChange="aktif();" id="kodesm">
							<option value="">Pilih</option>
							<option value="LM">LM</option>
							<option value="KM">KM</option>
							<option value="PT">PT</option>
							<option value="KO">KO</option>
							<option value="AP">AP</option>
							<option value="PA">PA</option>
							<option value="PM">PM</option>
							<option value="GT">GT</option>
							<option value="TG">TG</option>
							<option value="OK">OK</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" class="form-control timepicker" name="waktu_mulai" id="waktu_mulai" placeholder="00:00" disabled>
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="mulaism" type="text" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="" disabled />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" class="form-control timepicker" name="waktu_stop" placeholder="00:00" disabled>
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="selesaism" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="" disabled />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan</label>
					<div class="col-sm-8">
						<textarea name="ket" class="form-control"><?php echo $ketsts; ?></textarea>
					</div>
				</div>
			</div>

		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Hasil-Celup'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
			<button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>

		</div>
		<!-- /.box-footer -->
	</div>
</form>




<?php
if ($_POST['save'] == "save") {
	$ket = str_replace("'", "''", $_POST['ket']);
	$mulai = $_POST['mulaism'] . " " . $_POST['waktu_mulai'];
	$selesai = $_POST['selesaism'] . " " . $_POST['waktu_stop'];
	if ($_POST['kodesm'] != "") {
		$jam_stop = " mulai='$mulai', selesai='$selesai', ";
	} else {
		$jam_stop = " ";
	}
	$sqlData = mysqli_query($con, "INSERT INTO tbl_stopmesin SET
	  	no_stop='$_POST[no_stop]',
		shift='$_POST[shift]',
		g_shift='$_POST[g_shift]',
		kapasitas='$_POST[kapasitas]',
		no_mesin='$_POST[no_mesin]',
		proses='$_POST[proses]',
		kd_stopmc='$_POST[kodesm]',
		$jam_stop 
		keterangan='$ket',
		tgl_buat=now(),
		tgl_update=now()
        ");

	if ($sqlData) {
		echo "<script>swal({
        title: 'Data Tersimpan',   
        text: 'Klik Ok untuk input data kembali',
        type: 'success',
        }).then((result) => {
        if (result.value) {
            
            window.location.href='?p=Hasil-Celup'; 
        }
        });</script>";
	}
}
?>