<?PHP
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Hasil-Celup</title>
</head>

<body>
	<?php
		$tgl1 = isset($_POST['tgl1']) ? $_POST['tgl1'] : '';
		$tgl2 = isset($_POST['tgl2']) ? $_POST['tgl2'] : '';

		// Konversi filter tanggal ke sintaks SQL Server
		$whereTgl = "CAST(a.tgl_buat AS DATE) = CAST(GETDATE() AS DATE)";
		$paramsTgl = [];

		if ($tgl1 && $tgl2) {
			$whereTgl = "CAST(a.tgl_buat AS DATE) BETWEEN ? AND ?";
			$paramsTgl = [$tgl1, $tgl2];
		}

		$sqlData = "SELECT
						a.*,
						b.buyer,
						b.nodemand,
						b.no_order,
						b.no_mesin,
						b.warna,
						b.proses,
						b.target,
						a.id AS idh,
						c.id AS ids,
						b.id AS idm,
						a.rcode AS rcode_hasilcelup
					FROM
						db_dying.tbl_hasilcelup a
						LEFT JOIN db_dying.tbl_montemp c ON a.id_montemp = c.id
						LEFT JOIN db_dying.tbl_schedule b ON c.id_schedule = b.id
					WHERE
						$whereTgl
					ORDER BY
						a.id ASC";

		$data = sqlsrv_query($con, $sqlData, $paramsTgl);
		$no = 1;
		$n = 1;
		$c = 0;
	?>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="col-sm-2">
						<a href="?p=Form-Celup" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
						<a href="?p=Form-Stop-Mesin" class="btn btn-warning"><i class="fa fa-plus-circle"></i> Tambah Stop Mesin</a>
					</div>
					<!--<a href="pages/cetak/reports-cetak.php" class="btn btn-danger pull-right" target="_blank"><i class="fa fa-print"></i> Cetak</a> -->
					<div class="col-sm-4">
						<form action="" method="POST">
							<input type="date" name="tgl1" class="input-sm" value="<?= $tgl1; ?>"> S/D
							<input type="date" name="tgl2" class="input-sm" value="<?= $tgl2; ?>">
							<button type="submit" class="btn btn-primary btn-sm" name="sort" ><i class="fa fa-search"></i> Sort</button>
						</form>
					</div>
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-hover table-striped" width="100%">
						<thead class="bg-blue">
							<tr>
								<th width="52">
									<div align="center">
										<font size="-1">Mesin</font>
									</div>
								</th>
								<th width="115">
									<div align="center">
										<font size="-1">Shift</font>
									</div>
								</th>
								<th width="115">
									<div align="center">
										<font size="-1">Buyer</font>
									</div>
								</th>
								<th width="115">
									<div align="center">
										<font size="-1">No Demand</font>
									</div>
								</th>
								<th width="112">
									<div align="center">
										<font size="-1">Order</font>
									</div>
								</th>
								<th width="204">
									<div align="center">
										<font size="-1">Warna</font>
									</div>
								</th>
								<th width="144">
									<div align="center">
										<font size="-1">Proses</font>
									</div>
								</th>
								<th width="85">
									<div align="center">
										<font size="-1">Target</font>
									</div>
								</th>
								<th width="85">
									<div align="center">
										<font size="-1">Lama Prose</font>
									</div>
								</th>
								<th width="85">
									<div align="center">
										<font size="-1">Resep</font>
									</div>
								</th>
								<th width="85">
									<div align="center">
										<font size="-1">Kesetabilan Resep</font>
									</div>
								</th>
								<th width="237">
									<font size="-1">Colorist</font>
								</th>
								<th width="237">
									<div align="center">
										<font size="-1">Keterangan</font>
									</div>
								</th>
								<th width="70">
									<div align="center">
										<font size="-1">Action</font>
									</div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
								function cekDesimal($angka)
								{
									$bulat = round($angka);
									if ($bulat > $angka) {
										$jam = $bulat - 1;
										$waktu = $jam . ":30";
									} else {
										$jam = $bulat;
										$waktu = $jam . ":00";
									}
									return $waktu;
								}
								$col = 0;
								while ($rowd = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
									$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
									$qCek = sqlsrv_query(
										$con,
										"SELECT TOP 1 id AS idb 
										 FROM db_dying.tbl_potongcelup 
										 WHERE nokk = ? 
										 ORDER BY id DESC",
										[$rowd['nokk']]
									);
									$rCEk = sqlsrv_fetch_array($qCek, SQLSRV_FETCH_ASSOC);
							?>
								<tr bgcolor="<?php echo $bgcolor; ?>">
									<td align="center">
										<font size="-1"><?php echo $rowd['no_mesin']; ?></font>
									</td>
									<td align="center"><a href="#" class="shift_edit1" id="<?php echo $rowd['id']; ?>">
											<font size="-1"><?php echo $rowd['shift'] . $rowd['g_shift']; ?></font>
										</a></td>
									<td align="center">
										<font size="-2"><?php echo $rowd['buyer']; ?></font>
									</td>
									<td align="center">
										<font size="-2"><?php echo $rowd['nodemand']; ?></font>
									</td>
									<td align="center">
										<font size="-1"><?php echo $rowd['no_order']; ?></font>
									</td>
									<td>
										<font size="-2"><?php echo $rowd['warna']; ?></font>
									</td>
									<td align="left">
										<font size="-1"><?php echo $rowd['proses']; ?></font><br><i class="btn btn-xs bg-hijau">
											<font size="-2"><?php echo $rowd['operator_keluar']; ?></font>
										</i>
									</td>
									<td align="center">
										<font size="-1"><?php echo ($rowd['target']); ?></font>
									</td>
									<td align="center">
										<font size="-1"><?php echo $rowd['lama_proses']; ?></font>
									</td>
									<td align="center">
										<font size="-1"><?php echo $rowd['resep']; ?></font>
									</td>
									<td align="center">
										<font size="-1"><?php echo $rowd['k_resep']; ?></font>
									</td>
									<td align="center"><i class="btn btn-xs btn-info">
											<font size="-2"><?php echo $rowd['acc_keluar']; ?></font>
										</i>
									</td>
									<td><i class="label bg-abu">
											<font size="-2"><?php echo $rowd['nokk']; ?></font>
										</i><br>
										<font size="-2"><?php echo $rowd['ket']; ?></font><br>
										<i class="btn btn-xs <?php if ($rowd['status'] == "OK") {
																echo "bg-green";
															} else if ($rowd['status'] == "Gagal Proses") {
																echo "bg-red";
															} else if ($rowd['status'] == "Levelling-Matching") {
																echo "bg-primary";
															} else if ($rowd['status'] == "Pelunturan-Matching") {
																echo "bg-info";
															} ?>">
											<font size="-2"><?php echo $rowd['status']; ?></font>
										</i>
										<br>
										<?php echo $rowd['rcode_hasilcelup']; ?>
									</td>
									<td align="center">
										<div class="btn-group">
											<a href="pages/cetak/cetak_celup.php?id=<?php echo $rCEk['idb'] ?>" class="btn btn-xs btn-warning" target="_blank">
												<i class="fa fa-print"></i> </a>
											<a href="#" id='<?php echo $rCEk['idb']; ?>' class="btn btn-xs btn-info potong_edit">
												<i class="fa fa-edit"></i> 
											</a>
											<a href="#" onclick="confirm_del('?p=clp_hapus&id=<?php echo $rowd['id'] ?>');" class="btn btn-xs btn-danger <?php if ($_SESSION['lvl_id10'] == "3" or $rCEk['idb'] != "") { } ?>">
												<i class="fa fa-trash"></i> 
											</a>
											<br>
											<a href="?p=Form-Celup&id=<?php echo $rowd['idh'] ?>" class="btn btn-xs btn-primary" target="_blank">
												<i class="fa fa-edit"></i> Analisa Resep </a>
										</div>
									</td>
								</tr>
							<?php
								$no++;
							} ?>
						</tbody>
						<tfoot class="bg-red">
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="PotongEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<div id="ShiftEdit1" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<!-- Modal Popup untuk delete-->
	<div class="modal fade" id="delSchedule" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content" style="margin-top:100px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
				</div>

				<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
					<a href="#" class="btn btn-danger" id="del_link">Delete</a>
					<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
<script type="text/javascript">
	function confirm_del(delete_url) {
		$('#delSchedule').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('del_link').setAttribute('href', delete_url);
	}
</script>