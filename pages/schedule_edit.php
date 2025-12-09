<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$modal_id = $_GET['id'];
$modal = mysqli_query($con, "SELECT * FROM `tbl_schedule` WHERE id='$modal_id' ");
while ($r = mysqli_fetch_array($modal)) {
?>

	<div class="modal-dialog modal1">
		<div class="modal-content">
			<form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_schedule" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Schedule</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id" name="id" value="<?php echo $r['id']; ?>">
					<input type="hidden" id="personil" name="personil" value="<?php echo $_SESSION['nama10']; ?>">
					<input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['user_id10'];?>">
					<div class="form-group">
						<label for="no_mesin" class="col-md-4 control-label">No Mesin</label>

						<div class="col-md-3">
							<select name="no_mesin" class="form-control">
								<option value="">Pilih</option>
								<?php
								$sqlKap = mysqli_query($con, "SELECT no_mesin FROM tbl_mesin ORDER BY no_mesin ASC");
								while ($rK = mysqli_fetch_array($sqlKap)) {
								?>
									<option value="<?php echo $rK['no_mesin']; ?>" <?php if ($rK['no_mesin'] == $r['no_mesin']) {
																						echo "SELECTED";
																					} ?>><?php echo $rK['no_mesin']; ?></option>
								<?php } ?>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="urutan" class="col-md-4 control-label">Urutan</label>
						<div class="col-md-3">
							<select name="no_urut" class="form-control">
								<option value="">Pilih</option>
								<?php
								$sqlKap = mysqli_query($con, "SELECT no_urut FROM tbl_urut ORDER BY no_urut ASC");
								while ($rK = mysqli_fetch_array($sqlKap)) {
								?>
									<option value="<?php echo $rK['no_urut']; ?>" <?php if ($rK['no_urut'] == $r['no_urut']) {
																						echo "SELECTED";
																					} ?>><?php echo $rK['no_urut']; ?></option>
								<?php } ?>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="proses" class="col-md-4 control-label">Proses</label>
						<div class="col-md-5">
							<select name="proses" class="form-control">
								<option value="">Pilih</option>
								<?php
								$sqlKap = mysqli_query($con, "SELECT proses FROM tbl_proses ORDER BY proses ASC");
								while ($rK = mysqli_fetch_array($sqlKap)) {
								?>
									<option value="<?php echo $rK['proses']; ?>" <?php if ($rK['proses'] == $r['proses']) {
																						echo "SELECTED";
																					} ?>><?php echo $rK['proses']; ?></option>
								<?php } ?>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="no_resep" class="col-md-4 control-label">No Resep 1</label>
						<div class="col-md-3">
							<input name="no_resep" type="text" class="form-control" id="no_resep" value="<?php echo $r['no_resep']; ?>" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="no_resep2" class="col-md-4 control-label">No Resep 2</label>
						<div class="col-md-3">
							<input name="no_resep2" type="text" class="form-control" id="no_resep2" value="<?php echo $r['no_resep2']; ?>" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="target" class="col-md-4 control-label">Std Target</label>
						<div class="col-md-3">
							<div class="input-group">
								<input name="target" type="text" class="form-control" id="target" value="<?php echo $r['target']; ?>" placeholder="0" style="text-align: right;">
								<span class="input-group-addon">Jam</span>
								<span class="help-block with-errors"></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="ket_kain" class="col-md-4 control-label">Ket Kain</label>
						<div class="col-md-5">
							<select name="ket_kain" class="form-control" onChange="aktifmesin();" id="ket_kain">
								<option value="">Pilih</option>
								<option value="Sudah Buka Kain" <?php if ($r['ket_kain'] == "Sudah Buka Kain") {
																	echo "SELECTED";
																} ?>>Sudah Buka Kain</option>
								<option value="Belum Buka Kain" <?php if ($r['ket_kain'] == "Belum Buka Kain") {
																	echo "SELECTED";
																} ?>>Belum Buka Kain</option>
								<option value="Kain Basah" <?php if ($r['ket_kain'] == "Kain Basah") {
																echo "SELECTED";
															} ?>>Kain Basah</option>
								<option value="Kain Kering" <?php if ($r['ket_kain'] == "Kain Kering") {
																echo "SELECTED";
															} ?>>Kain Kering</option>
								<option value="Sudah Jahit Pinggir <?php if ($r['ket_kain'] == "Sudah Jahit Pinggir") {
																		echo "SELECTED";
																	} ?>">Sudah Jahit Pinggir</option>
								<option value="Pindah Dari Mesin" <?php if ($r['ket_kain'] == "Pindah Dari Mesin") {
																		echo "SELECTED";
																	} ?>>Pindah Dari Mesin</option>
								<option value="Kain Sudah Priset" <?php if ($r['ket_kain'] == "Kain Sudah Priset") {
																		echo "SELECTED";
																	} ?>>Kain Sudah Priset</option>
								<option value="Urgent" <?php if ($r['ket_kain'] == "Urgent") {
															echo "SELECTED";
														} ?>>Urgent</option>
								<option value="Test Kestabilan" <?php if ($r['ket_kain'] == "Test Kestabilan") {
																	echo "SELECTED";
																} ?>>Test Kestabilan</option>
							</select>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="ket" class="col-sm-4 control-label">Keterangan</label>
						<div class="col-sm-5">
							<select name="ket" class="form-control" id="ket">
								<option value="">Pilih</option>
								<option value='Cuci YD' <?php if ($r['ket_status'] == "Cuci YD") {
															echo "SELECTED";
														} ?>>Cuci YD</option>
								<option value='Cuci Misty' <?php if ($r['ket_status'] == "Cuci Misty") {
																echo "SELECTED";
															} ?>>Cuci Misty</option>
								<option value='Development Sample' <?php if ($r['ket_status'] == "Development Sample") {
																		echo "SELECTED";
																	} ?>>Development Sample</option>
								<option value='First Lot' <?php if ($r['ket_status'] == "First Lot") {
																echo "SELECTED";
															} ?>>First Lot</option>
								<option value='Gagal Proses' <?php if ($r['ket_status'] == "Cuci YD") {
																	echo "SELECTED";
																} ?>>Gagal Proses</option>
								<option value='Greige' <?php if ($r['ket_status'] == "Greige") {
															echo "SELECTED";
														} ?>>Greige</option>
								<option value='Greige Delay' <?php if ($r['ket_status'] == "Greige Delay") {
																	echo "SELECTED";
																} ?>>Greige Delay</option>
								<option value='Mini Bulk' <?php if ($r['ket_status'] == "Mini Bulk") {
																echo "SELECTED";
															} ?>>Mini Bulk</option>
								<option value='Perbaikan' <?php if ($r['ket_status'] == "Perbaikan") {
																echo "SELECTED";
															} ?>>Perbaikan</option>
								<option value='Salesmen Sample' <?php if ($r['ket_status'] == "Salesmen Sample") {
																	echo "SELECTED";
																} ?>>Salesmen Sample</option>
								<option value='Relaxing-Preset' <?php if ($r['ket_status'] == "Relaxing-Preset") {
																	echo "SELECTED";
																} ?>>Relaxing-Preset</option>
								<option value='Scouring-Preset' <?php if ($r['ket_status'] == "Scouring-Preset") {
																	echo "SELECTED";
																} ?>>Scouring-Preset</option>
								<option value='Tolak Basah' <?php if ($r['ket_status'] == "Tolak Basah") {
																echo "SELECTED";
															} ?>>Tolak Basah</option>
								<option value='Proses AKW' <?php if ($r['ket_status'] == "Proses AKW") {
																echo "SELECTED";
															} ?>>Proses AKW</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="mc_from" class="col-md-4 control-label">Dari Mesin</label>
						<div class="col-md-3">
							<select name="mc_from" class="form-control" id="mc_from">
								<option value="">Pilih</option>
								<?php
								$sqlKap = mysqli_query($con, "SELECT no_mesin FROM tbl_mesin ORDER BY no_mesin ASC");
								while ($rK = mysqli_fetch_array($sqlKap)) {
								?>
									<option value="<?php echo $rK['no_mesin']; ?>" <?php if ($rK['no_mesin'] == $r['mc_from']) {
																						echo "SELECTED";
																					} ?>><?php echo $rK['no_mesin']; ?></option>
								<?php } ?>
							</select>
							<span class="help-block with-errors"></span>
						</div>						
					</div>
					<div class="form-group">
						<label for="jml_bruto" class="col-md-4 control-label">&nbsp;</label>
						<div class="col-sm-3">
							<input type="checkbox" name="kk_kestabilan" id="kk_kestabilan" value="1" onclick="aktif2();" <?php if ($r['kk_kestabilan'] == "1") {
																																echo "checked";
																															} ?>>
							<label> KK Kestabilan</label>
						</div>
						<div class="col-sm-3">
							<input type="checkbox" name="kk_normal" id="kk_normal" onclick="aktif3();" value="1" <?php if ($r['kk_normal'] == "1") {
																														echo "checked";
																													} ?>>
							<label> KK Normal</label>
						</div>
					</div>
					<?php if ($r['ket_status'] == "MC Stop" or $r['ket_status'] == "MC Rusak" or $r['ket_status'] == "Cuci Mesin") { ?>
						<div class="form-group">
							<label for="status" class="col-md-4 control-label">Status</label>
							<div class="col-md-4">
								<select name="status" class="form-control">
									<option value="">Pilih</option>
									<option value="antri mesin" <?php if ($r['status'] == "antri mesin") {
																	echo "SELECTED";
																} ?>>Stop</option>
									<option value="selesai" <?php if ($r['status'] == "selesai") {
																echo "SELECTED";
															} ?>>Start</option>
								</select>
								<span class="help-block with-errors"></span>
							</div>
						</div>
						<div class="form-group">
							<label for="selesaism" class="col-sm-4 control-label">Selesai Stop Mesin</label>
							<div class="col-sm-3">
								<div class="input-group">
									<input type="text" class="form-control timepicker" name="jam_mulai" placeholder="00:00" value="<?php echo $r['jamM']; ?>">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group date">
									<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
									<input name="tgl_mulai" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $r['tglM']; ?>" />
								</div>
							</div>

						</div>
					<?php } ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
<?php } ?>
<script>
	//Date picker
	$('#datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true,
	});
	//Timepicker
	$('#timepicker').timepicker({
		showInputs: false,
	});

	$(function() {
		//Timepicker
		$('.timepicker').timepicker({
				minuteStep: 1,
				showInputs: true,
				showMeridian: false,
				defaultTime: false

			}),

	});

	function aktifmesin() {

		if (document.forms['modal_popup']['ket_kain'].value == "Pindah Dari Mesin") {

			document.modal_popup.mc_from.removeAttribute("disabled");
		} else {
			document.modal_popup.mc_from.setAttribute("disabled", true);
		}
	}

	function aktif2() {
		if (document.forms['modal_popup']['kk_kestabilan'].checked == true) {
			document.modal_popup.kk_normal.setAttribute("disabled", true);
		} else {
			document.modal_popup.kk_normal.removeAttribute("disabled");
		}
	}

	function aktif3() {
		if (document.forms['modal_popup']['kk_normal'].checked == true) {
			document.modal_popup.kk_kestabilan.setAttribute("disabled", true);
		} else {
			document.modal_popup.kk_kestabilan.removeAttribute("disabled");
		}
	}
	// function aktif2(){
	// 	if(document.forms['modal_popup']['kk_kestabilan'].checked==true){
	// 	$("#kk_normal").css("display", "");  // To unhide
	// 	}else{
	// 		$("#kk_normal").css("display", "none");  // To hide
	// 	}
	// }
	// function aktif3(){
	// 	if(document.forms['modal_popup']['kk_normal'].checked==true){
	// 	$("#kk_kestabilan").css("display", "");  // To unhide
	// 	}else{
	// 		$("#kk_kestabilan").css("display", "none");  // To hide
	// 	}
	// }
</script>