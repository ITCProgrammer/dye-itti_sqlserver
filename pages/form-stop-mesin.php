<?php
	ini_set("error_reporting", 1);
	session_start();
	include "koneksi.php";

	/* -------------------- Util: preview kode berikutnya hari ini -------------------- */
	$prefix = 'SM'.date('y').date('md'); // SM + yy + mmdd
	$qPrev  = mysqli_query($con, "
		SELECT COALESCE(MAX(CAST(SUBSTRING(no_stop, 9) AS UNSIGNED)), 0) AS last_seq
		FROM tbl_stopmesin
		WHERE DATE(tgl_buat) = CURDATE()
	");
	$rPrev        = $qPrev ? mysqli_fetch_assoc($qPrev) : ['last_seq'=>0];
	$previewCode  = sprintf('%s%02d', $prefix, ((int)$rPrev['last_seq']) + 1);

	/* -------------------- Build opsi mesin (tanpa filter kapasitas) -------------------- */
	$mcOptions = '';
	$qMC = mysqli_query($con, "SELECT no_mesin FROM tbl_mesin ORDER BY no_mesin ASC");
	while ($r = mysqli_fetch_assoc($qMC)) {
		$val = htmlspecialchars($r['no_mesin'], ENT_QUOTES);
		$mcOptions .= "<option value=\"{$val}\">{$val}</option>";
	}

	/* -------------------- Proses Submit -------------------- */
	if (isset($_POST['save']) && $_POST['save'] === "save") {

		// Ambil & validasi input dasar
		$shift   = $_POST['shift']   ?? '';
		$g_shift = $_POST['g_shift'] ?? '';
		$proses  = $_POST['proses']  ?? '';
		$kodesm  = $_POST['kodesm']  ?? '';
		$ket     = $_POST['ket']     ?? '';

		// Kumpulan mesin dari form dinamis
		$mesins = isset($_POST['no_mesin']) ? (array)$_POST['no_mesin'] : [];
		$mesins = array_values(array_filter(array_map('trim', $mesins)));

		if (empty($shift) || empty($g_shift) || empty($proses) || empty($mesins)) {
			echo "<script>swal('Data belum lengkap','Lengkapi Shift/Group/Proses dan pilih minimal 1 mesin','warning');</script>";
		} elseif (count($mesins) !== count(array_unique($mesins))) {
			echo "<script>swal('Duplikat No MC','Ada pilihan mesin yang sama','warning');</script>";
		} else {

			// waktu (boleh kosong kalau kodesm kosong)
			$mulai   = ($kodesm !== "" ? (($_POST['mulaism'] ?? '')." ".($_POST['waktu_mulai'] ?? '')) : null);
			$selesai = ($kodesm !== "" ? (($_POST['selesaism'] ?? '')." ".($_POST['waktu_stop']  ?? '')) : null);

			// Ambil kapasitas per mesin dari DB (sekali query)
			$mesinsUnique = array_values(array_unique($mesins));
			$inList = implode(',', array_map(function($m) use ($con){
				return "'".mysqli_real_escape_string($con, $m)."'";
			}, $mesinsUnique));
			$kapMap = [];
			if ($inList) {
				$qCap = mysqli_query($con, "SELECT no_mesin, kapasitas FROM tbl_mesin WHERE no_mesin IN ($inList)");
				while ($row = mysqli_fetch_assoc($qCap)) {
					$kapMap[$row['no_mesin']] = (int)$row['kapasitas'];
				}
			}

			// Mulai transaksi agar urutan kode aman
			mysqli_begin_transaction($con);
			try {
				// Kunci urutan hari ini
				$res = mysqli_query($con, "
					SELECT COALESCE(MAX(CAST(SUBSTRING(no_stop, 9) AS UNSIGNED)), 0) AS last_seq
					FROM tbl_stopmesin
					WHERE DATE(tgl_buat) = CURDATE()
					FOR UPDATE
				");
				$row = mysqli_fetch_assoc($res);
				$seq = (int)$row['last_seq'];

				// Siapkan statement INSERT (2 versi: dengan waktu & tanpa waktu)
				if ($kodesm !== "") {
					$stmt = mysqli_prepare($con, "INSERT INTO tbl_stopmesin
						(no_stop, shift, g_shift, kapasitas, no_mesin, proses, kd_stopmc, mulai, selesai, keterangan, tgl_buat, tgl_update)
						VALUES (?,?,?,?,?,?,?,?,?, ?, NOW(), NOW())");
					if (!$stmt) throw new Exception('Prepare failed: '.mysqli_error($con));
				} else {
					$stmt = mysqli_prepare($con, "INSERT INTO tbl_stopmesin
						(no_stop, shift, g_shift, kapasitas, no_mesin, proses, kd_stopmc, keterangan, tgl_buat, tgl_update)
						VALUES (?,?,?,?,?,?,?, ?, NOW(), NOW())");
					if (!$stmt) throw new Exception('Prepare failed: '.mysqli_error($con));
				}

				foreach ($mesins as $mc) {
					$seq++;
					$no_stop = sprintf('%s%02d', $prefix, $seq); // contoh: SM25102001
					$kapasitas = (int)($kapMap[$mc] ?? 0);       // kapasitas otomatis dari tbl_mesin

					if ($kodesm !== "") {
						mysqli_stmt_bind_param(
							$stmt,
							"sssissssss",
							$no_stop, $shift, $g_shift, $kapasitas, $mc, $proses, $kodesm, $mulai, $selesai, $ket
						);
					} else {
						mysqli_stmt_bind_param(
							$stmt,
							"sssissss",
							$no_stop, $shift, $g_shift, $kapasitas, $mc, $proses, $kodesm, $ket
						);
					}

					if (!mysqli_stmt_execute($stmt)) {
						throw new Exception('Execute failed: '.mysqli_stmt_error($stmt));
					}
				}

				mysqli_commit($con);
				echo "<script>swal({
					title:'Data Tersimpan',
					text:'Berhasil membuat nomor stop per-mesin',
					type:'success'
				}).then(()=>{ window.location='?p=Hasil-Celup'; });</script>";

			} catch (Throwable $e) {
				mysqli_rollback($con);
				$msg = htmlspecialchars($e->getMessage(), ENT_QUOTES);
				echo "<script>swal('Gagal menyimpan', '$msg', 'error');</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Input Data Stop Mesin</title>
		<link rel="stylesheet" href="/css/all.min.css"/>
		<link href="/css/nunito.css" rel="stylesheet">
		<link href="/css/sb-admin-2.css" rel="stylesheet">
		<link rel="stylesheet" href="/css/flatpickr.min.css">
		<style>.help-block{font-size:12px;color:#777}</style>
	</head>
	<body>

	<script>
		// Toggle field waktu saat kode stop diubah
		function aktif(){
			var f = document.forms['form1']; if(!f) return;
			var on = f['kodesm'].value !== "";
			['waktu_mulai','waktu_stop','mulaism','selesaism'].forEach(function(name){
				var el = f[name]; if(!el) return;
				if (on){ el.removeAttribute('disabled'); el.setAttribute('required', true); }
				else   { el.setAttribute('disabled', true); el.removeAttribute('required'); }
			});
		}
	</script>

	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Input Data Stop Mesin</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="col-md-7">
					<!-- Preview No Stop (kode pertama hari ini) -->
					<div class="form-group">
						<label class="col-sm-3 control-label">No Stop Mesin</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" value="<?php echo htmlspecialchars($previewCode, ENT_QUOTES); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Shift</label>
						<div class="col-sm-3">
							<select name="shift" class="form-control" required>
								<option value="">Pilih</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Group Shift</label>
						<div class="col-sm-3">
							<select name="g_shift" class="form-control" required>
								<option value="">Pilih</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</div>
					</div>
					<!-- No MC dinamis (+/−), tanpa Kapasitas -->
					<div class="form-group">
						<label class="col-sm-3 control-label">No MC</label>
						<div class="col-sm-6">
							<div id="mc-list">
								<div class="mc-row" style="margin-bottom:6px;">
									<select name="no_mesin[]" class="form-control" required>
										<option value="">Pilih</option>
										<?= $mcOptions ?>
									</select>
								</div>
							</div>
							<small class="help-block">Klik (+) untuk tambah baris mesin, (−) untuk hapus baris terakhir.</small>
						</div>
						<div class="col-sm-3" style="display:flex;gap:6px;align-items:flex-start;">
							<button type="button" id="btnAddMc" class="btn btn-success">+</button>
							<button type="button" id="btnRemoveMc" class="btn btn-danger" disabled>−</button>
						</div>
					</div>
					<!-- Template baris MC -->
					<template id="mc-template">
						<div class="mc-row" style="margin-bottom:6px;">
							<select name="no_mesin[]" class="form-control" required>
								<option value="">Pilih</option>
								<?= $mcOptions ?>
							</select>
						</div>
					</template>
					<div class="form-group">
						<label class="col-sm-3 control-label">Proses</label>
						<div class="col-sm-5">
							<select name="proses" id="proses" class="form-control" required>
								<option value="">Pilih</option>
								<option value="Stop">Stop</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kode Stop Mesin</label>
						<div class="col-sm-3">
							<select name="kodesm" class="form-control" onChange="aktif();" id="kodesm">
								<option value="">Pilih</option>
								<option value="LM">LM</option><option value="KM">KM</option>
								<option value="PT">PT</option><option value="KO">KO</option>
								<option value="AP">AP</option><option value="PA">PA</option>
								<option value="PM">PM</option><option value="GT">GT</option>
								<option value="TG">TG</option><option value="OK">OK</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Mulai Stop Mesin</label>
						<div class="col-sm-3">
							<div class="input-group">
								<input type="text" class="form-control timepicker" name="waktu_mulai" id="waktu_mulai" placeholder="00:00" disabled>
								<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-group date">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input name="mulaism" type="text" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="" disabled />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Selesai Stop Mesin</label>
						<div class="col-sm-3">
							<div class="input-group">
								<input type="text" class="form-control timepicker" name="waktu_stop" placeholder="00:00" disabled>
								<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-group date">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input name="selesaism" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="" disabled />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Keterangan</label>
						<div class="col-sm-8">
							<textarea name="ket" class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Hasil-Celup'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
				<button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
			</div>
		</div>
	</form>

	<!-- JS untuk add/remove baris No MC + validasi duplikat -->
	<script>
		(function(){
			var list   = document.getElementById('mc-list');
			var addBtn = document.getElementById('btnAddMc');
			var delBtn = document.getElementById('btnRemoveMc');
			var tpl    = document.getElementById('mc-template');

			function updateButtons(){
				var rows = list.querySelectorAll('.mc-row');
				delBtn.disabled = (rows.length <= 1);
			}

			if (addBtn){
				addBtn.addEventListener('click', function(){
					if (!tpl) return;
					var clone = document.importNode(tpl.content, true);
					list.appendChild(clone);
					updateButtons();
				});
			}
			if (delBtn){
				delBtn.addEventListener('click', function(){
					var rows = list.querySelectorAll('.mc-row');
					if (rows.length > 1){
						rows[rows.length - 1].remove();
						updateButtons();
					}
				});
			}

			// Cegah duplikat MC saat submit
			var form = document.forms['form1'];
			if (form){
				form.addEventListener('submit', function(e){
					var selects = list.querySelectorAll('select[name="no_mesin[]"]');
					var picked  = [];
					for (var i=0;i<selects.length;i++){
						var v = (selects[i].value || '').trim();
						if (!v){
							alert('Ada baris No MC yang belum dipilih.');
							e.preventDefault(); return false;
						}
						if (picked.indexOf(v) !== -1){
							alert('No MC tidak boleh duplikat: ' + v);
							e.preventDefault(); return false;
						}
						picked.push(v);
					}
				});
			}

			updateButtons();
		})();
	</script>

	</body>
</html>
