<?php
// NOW
$nokk = $_GET['nokk'];

$sql_ITXVIEWKK  = db2_exec($conn2, "SELECT
                                                TRIM(PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                                TRIM(DEAMAND) AS DEMAND,
                                                ORIGDLVSALORDERLINEORDERLINE,
                                                PROJECTCODE,
                                                ORDPRNCUSTOMERSUPPLIERCODE,
                                                TRIM(SUBCODE01) AS SUBCODE01, TRIM(SUBCODE02) AS SUBCODE02, TRIM(SUBCODE03) AS SUBCODE03, TRIM(SUBCODE04) AS SUBCODE04,
                                                TRIM(SUBCODE05) AS SUBCODE05, TRIM(SUBCODE06) AS SUBCODE06, TRIM(SUBCODE07) AS SUBCODE07, TRIM(SUBCODE08) AS SUBCODE08,
                                                TRIM(SUBCODE09) AS SUBCODE09, TRIM(SUBCODE10) AS SUBCODE10, 
                                                TRIM(ITEMTYPEAFICODE) AS ITEMTYPEAFICODE,
                                                TRIM(SUBCODE05) AS NO_WARNA,
                                                TRIM(SUBCODE02) || '-' || TRIM(SUBCODE03)  AS NO_HANGER,
                                                TRIM(ITEMDESCRIPTION) AS ITEMDESCRIPTION,
                                                DELIVERYDATE,
                                                LOT
                                            FROM 
                                                ITXVIEWKK 
                                            WHERE 
                                                PRODUCTIONORDERCODE = '$nokk'");
$dt_ITXVIEWKK	= db2_fetch_assoc($sql_ITXVIEWKK);

$sql_pelanggan_buyer 	= db2_exec($conn2, "SELECT TRIM(LANGGANAN) AS PELANGGAN, TRIM(BUYER) AS BUYER FROM ITXVIEW_PELANGGAN 
                                                    WHERE ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' AND CODE = '$dt_ITXVIEWKK[PROJECTCODE]'");
$dt_pelanggan_buyer		= db2_fetch_assoc($sql_pelanggan_buyer);

$sql_demand		= db2_exec($conn2, "SELECT LISTAGG(TRIM(DEAMAND), ', ') AS DEMAND,
                                            LISTAGG(''''|| TRIM(ORIGDLVSALORDERLINEORDERLINE) ||'''', ', ')  AS ORIGDLVSALORDERLINEORDERLINE
                                            FROM ITXVIEWKK 
                                            WHERE PRODUCTIONORDERCODE = '$nokk'");
$dt_demand		= db2_fetch_assoc($sql_demand);

if (!empty($dt_demand['ORIGDLVSALORDERLINEORDERLINE'])) {
	$orderline	= $dt_demand['ORIGDLVSALORDERLINEORDERLINE'];
} else {
	$orderline	= '0';
}

$sql_po			= db2_exec($conn2, "SELECT TRIM(EXTERNALREFERENCE) AS NO_PO FROM ITXVIEW_KGBRUTO 
                                            WHERE PROJECTCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND ORIGDLVSALORDERLINEORDERLINE IN ($orderline)");
$dt_po    		= db2_fetch_assoc($sql_po);

$sql_noitem     = db2_exec($conn2, "SELECT * FROM ORDERITEMORDERPARTNERLINK WHERE INACTIVE = 0
                                            AND ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' 
                                            AND SUBCODE01 = '$dt_ITXVIEWKK[SUBCODE01]' AND SUBCODE02 = '$dt_ITXVIEWKK[SUBCODE02]' 
                                            AND SUBCODE03 = '$dt_ITXVIEWKK[SUBCODE03]' AND SUBCODE04 = '$dt_ITXVIEWKK[SUBCODE04]' 
                                            AND SUBCODE05 = '$dt_ITXVIEWKK[SUBCODE05]' AND SUBCODE06 = '$dt_ITXVIEWKK[SUBCODE06]'
                                            AND SUBCODE07 = '$dt_ITXVIEWKK[SUBCODE07]' AND SUBCODE08 ='$dt_ITXVIEWKK[SUBCODE08]'
                                            AND SUBCODE09 = '$dt_ITXVIEWKK[SUBCODE09]' AND SUBCODE10 ='$dt_ITXVIEWKK[SUBCODE10]'");
$dt_item        = db2_fetch_assoc($sql_noitem);

$sql_lebargramasi	= db2_exec($conn2, "SELECT i.LEBAR,
                                                        CASE
                                                            WHEN i2.GRAMASI_KFF IS NULL THEN i2.GRAMASI_FKF
                                                            ELSE i2.GRAMASI_KFF
                                                        END AS GRAMASI 
                                                    FROM 
                                                        ITXVIEWLEBAR i 
                                                    LEFT JOIN ITXVIEWGRAMASI i2 ON i2.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND i2.ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'
                                                    WHERE 
                                                    i.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND i.ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'");
$dt_lg				= db2_fetch_assoc($sql_lebargramasi);

$sql_warna		= db2_exec($conn2, "SELECT DISTINCT TRIM(WARNA) AS WARNA FROM ITXVIEWCOLOR 
                                        WHERE ITEMTYPECODE = '$dt_ITXVIEWKK[ITEMTYPEAFICODE]' 
                                            AND SUBCODE01 = '$dt_ITXVIEWKK[SUBCODE01]' 
                                            AND SUBCODE02 = '$dt_ITXVIEWKK[SUBCODE02]'
                                            AND SUBCODE03 = '$dt_ITXVIEWKK[SUBCODE03]' 
                                            AND SUBCODE04 = '$dt_ITXVIEWKK[SUBCODE04]'
                                            AND SUBCODE05 = '$dt_ITXVIEWKK[SUBCODE05]' 
                                            AND SUBCODE06 = '$dt_ITXVIEWKK[SUBCODE06]'
                                            AND SUBCODE07 = '$dt_ITXVIEWKK[SUBCODE07]' 
                                            AND SUBCODE08 = '$dt_ITXVIEWKK[SUBCODE08]'
                                            AND SUBCODE09 = '$dt_ITXVIEWKK[SUBCODE09]' 
                                            AND SUBCODE10 = '$dt_ITXVIEWKK[SUBCODE10]'");
$dt_warna		= db2_fetch_assoc($sql_warna);

$sql_qtyorder   = db2_exec($conn2, "SELECT DISTINCT
												GROUPSTEPNUMBER,
                                                INITIALUSERPRIMARYQUANTITY AS QTY_ORDER,
                                                INITIALUSERSECONDARYQUANTITY AS QTY_ORDER_YARD
                                            FROM 
                                                VIEWPRODUCTIONDEMANDSTEP 
                                            WHERE 
                                                PRODUCTIONORDERCODE = '$nokk'
											ORDER BY
												GROUPSTEPNUMBER ASC LIMIT 1");
$dt_qtyorder    = db2_fetch_assoc($sql_qtyorder);

$sql_roll		= db2_exec($conn2, "SELECT count(*) AS ROLL, s2.PRODUCTIONORDERCODE
                                            FROM STOCKTRANSACTION s2 
                                            WHERE s2.ITEMTYPECODE ='KGF' AND s2.PRODUCTIONORDERCODE = '$dt_ITXVIEWKK[PRODUCTIONORDERCODE]'
                                            GROUP BY s2.PRODUCTIONORDERCODE");
$dt_roll   		= db2_fetch_assoc($sql_roll);

$sql_mesinknt	= db2_exec($conn2, "SELECT DISTINCT
                                                s.LOTCODE,
                                                CASE
                                                    WHEN a.VALUESTRING IS NULL THEN '-'
                                                    ELSE a.VALUESTRING
                                                END AS VALUESTRING
                                            FROM STOCKTRANSACTION s 
                                            LEFT JOIN PRODUCTIONDEMAND p ON p.CODE = s.LOTCODE 
                                            LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.NAMENAME = 'MachineNo'
                                            WHERE s.PRODUCTIONORDERCODE = '$nokk'");
$dt_mesinknt	= db2_fetch_assoc($sql_mesinknt);

$sql_prod_reservation   = db2_exec($conn2, "SELECT
                                                        TRIM(SUBCODE04) AS SUBCODE04
                                                    FROM
                                                        PRODUCTIONRESERVATION
                                                    WHERE
                                                        ITEMTYPEAFICODE = 'KGF'
                                                        AND PRODUCTIONORDERCODE = '$nokk'
                                                        AND ORDERCODE = '$dt_ITXVIEWKK[DEMAND]' 
                                                    LIMIT 1");
$row_prod_reservation   = db2_fetch_assoc($sql_prod_reservation);
// NOW
?>
<script type="text/javascript">
	function bonresep1() {
		var no_resep = document.getElementById("no_resep").value;
		var prod_order = no_resep.substring(0, 8);
		var group_number = no_resep.substring(9);
		// alert("no_resep");

		$.get("api_schedule.php?prod_order=" + prod_order + "&group_number=" + group_number, function(data) {
			document.getElementById("suffix").value = data.SUFFIX_CODE;
		});
	}

	function bonresep2() {
		var no_resep2 = document.getElementById("no_resep2").value;
		var prod_order2 = no_resep2.substring(0, 8);
		var group_number2 = no_resep2.substring(9);
		// alert("no_resep");

		$.get("api_schedule.php?prod_order=" + prod_order2 + "&group_number=" + group_number2, function(data2) {
			document.getElementById("suffix2").value = data2.SUFFIX_CODE;
		});
	}
</script>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Input Data Buka Resep</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nokk" class="col-sm-3 control-label">Production Order</label>
					<div class="col-sm-4">
						<input name="nokk" type="text" class="form-control" id="nokk" onchange="window.location='?p=Form-Matching-Dyeing&nokk='+this.value" value="<?php echo $_GET['nokk']; ?>" placeholder="Production Order" required>
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Production Demand</label>
					<div class="col-sm-8">
						<input name="demand" type="text" class="form-control" value="<?= $dt_demand['DEMAND']; ?>" placeholder="Production Demand">
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Langganan</label>
					<div class="col-sm-8">
						<input name="langganan" type="text" class="form-control" readonly value="<?= $dt_pelanggan_buyer['PELANGGAN']; ?>" placeholder="Langganan">
					</div>
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-8">
						<input name="buyer" type="text" class="form-control" readonly value="<?= $dt_pelanggan_buyer['BUYER']; ?>" placeholder="Buyer">
					</div>
				</div>
				<div class="form-group">
					<label for="no_order" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="no_order" type="text" class="form-control" readonly value="<?= $dt_ITXVIEWKK['PROJECTCODE']; ?>" placeholder="No Order">
					</div>
				</div>
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">PO</label>
					<div class="col-sm-5">
						<input name="no_po" type="text" class="form-control" readonly value="<?= $dt_po['NO_PO']; ?>" placeholder="PO">
					</div>
				</div>
				<div class="form-group">
					<label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
					<div class="col-sm-3">
						<input name="no_hanger" type="text" class="form-control" readonly value="<?= $dt_ITXVIEWKK['NO_HANGER'] ?>" placeholder="No Hanger">
					</div>
					<div class="col-sm-3">
						<input name="no_item" type="text" class="form-control" readonly value="<?= $dt_item['EXTERNALITEMCODE'] ?>" placeholder="No Item">
					</div>
				</div>
				<div class="form-group">
					<label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
					<div class="col-sm-8">
						<textarea name="jns_kain" class="form-control" readonly placeholder="Jenis Kain"><?= $dt_ITXVIEWKK['ITEMDESCRIPTION'] ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="tgl_delivery" type="text" readonly class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?= $dt_ITXVIEWKK['DELIVERYDATE']; ?>" required />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
					<div class="col-sm-2">
						<input name="lebar" type="text" class="form-control" readonly value="<?= $dt_lg['LEBAR']; ?>" placeholder="0" required>
					</div>
					<div class="col-sm-2">
						<input name="grms" type="text" class="form-control" readonly value="<?= $dt_lg['GRAMASI']; ?>" placeholder="0" required>
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-8">
						<input name="warna" type="text" class="form-control" readonly value="<?= $dt_warna['WARNA']; ?>" placeholder="Warna">
					</div>
				</div>
				<div class="form-group">
					<label for="no_warna" class="col-sm-3 control-label">No Warna</label>
					<div class="col-sm-8">
						<input name="no_warna" type="text" class="form-control" readonly value="<?= $dt_ITXVIEWKK['NO_WARNA']; ?>" placeholder="No Warna">
					</div>
				</div>
				<div class="form-group">
					<label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty1" type="text" class="form-control" readonly value="<?= $dt_qtyorder['QTY_ORDER']; ?>" placeholder="0.00" required>
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="lot" class="col-sm-3 control-label">Lot</label>
					<div class="col-sm-2">
						<input name="lot" type="text" class="form-control" readonly value="<?= $dt_ITXVIEWKK['LOT']; ?>" placeholder="Lot">
					</div>
				</div>
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Roll &amp; Qty</label>
					<div class="col-sm-2">
						<input name="qty3" type="text" class="form-control" readonly value="<?= $dt_roll['ROLL']; ?>" placeholder="0.00" required>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty4" type="text" class="form-control" readonly value="<?= $dt_qtyorder['QTY_ORDER']; ?>" placeholder="0.00" style="text-align: right;" required>
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
				</div>
			</div>
			<!-- col -->
			<div class="col-md-6">
				<div class="form-group">
					<label class="col-sm-3 control-label">Jenis Proses Kain</label>
					<div class="col-sm-2">
						<select name="jenis_proses" class="form-control" required>
							<option value="">Pilih</option>
							<?php
							$q_prosses = mysqli_query($con, "SELECT * FROM tbl_jenis_proses ORDER BY id ASC");
							?>
							<?php while ($row_prosses	= mysqli_fetch_array($q_prosses)) { ?>
								<option value="<?= $row_prosses['proses_name'] . "/" . $row_prosses['std_waktu']; ?>"><?= $row_prosses['proses_name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Shift</label>
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
					<label for="ket" class="col-sm-3 control-label">Jam Terima / Tgl Terima (Aktual Komputer)</label>
					<div class="col-sm-5">
						<input name="jam_terima" type="datetime" class="form-control" value="<?= date('Y-m-d H:i:s'); ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Colorist Acc Untuk Proses Matching</label>
					<div class="col-sm-8">
						<select class="form-control select2" name="acc_matching">
							<option selected disabled value="-">Dipilih</option>
							<?php
							$q_staff = mysqli_query($con, "SELECT * FROM tbl_staff ");
							?>
							<?php while ($row_staff 	= mysqli_fetch_array($q_staff)) { ?>
								<option value="<?= $row_staff['nama']; ?>"><?= $row_staff['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Operator Penerima</label>
					<div class="col-sm-8">
						<select class="form-control select2" name="operator_penerima">
							<option selected disabled value="-">Dipilih</option>
							<?php
							$q_staff = mysqli_query($con, "SELECT * FROM tbl_staff WHERE jabatan = 'Operator'");
							?>
							<?php while ($row_staff 	= mysqli_fetch_array($q_staff)) { ?>
								<option value="<?= $row_staff['nama']; ?>"><?= $row_staff['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan</label>
					<div class="col-sm-5">
						<textarea name="ket" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Matching-Dyeing'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
			<button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
		</div>
	</div>
</form>

<?php
if ($_POST['save'] == "save") {
	$pair = explode("/", $_POST["jenis_proses"]);

	$nama   = $pair[0];
	$std_waktu = $pair[1];

	$q_simpan   = mysqli_query($con, "INSERT INTO tbl_matching_dyeing 
	                                            SET nokk = '$_POST[nokk]',
	                                                nodemand = '$_POST[demand]',
	                                                no_order = '$_POST[no_order]',
	                                                shift = '$_POST[shift]',
	                                                gshift = '$_POST[g_shift]',
	                                                langganan = '$_POST[langganan]',
	                                                jenis_kain = '$_POST[jns_kain]',
	                                                no_warna = '$_POST[no_warna]',
	                                                warna = '$_POST[warna]',
	                                                buyer = '$_POST[buyer]',
	                                                jam_terima = '$_POST[jam_terima]',
	                                                acc_matching = '$_POST[acc_matching]',
	                                                operator_penerima = '$_POST[operator_penerima]',
	                                                keterangan = '$_POST[ket]',
													std_waktu_prosses = '$std_waktu',
													jenis_prosses ='$nama', 
	                                                createdatetime = now()");
	if ($q_simpan) {
		echo "<script>swal({
	                title: 'Data Tersimpan',   
	                text: 'Klik Ok untuk input data kembali',
	                type: 'success',
	                }).then((result) => {
	                if (result.value) {
	                    window.location.href='?p=Form-Matching-Dyeing'; 
	                }
	            });</script>";
	} else {
		echo "Error: " . mysqli_error($con);
	}
}
?>