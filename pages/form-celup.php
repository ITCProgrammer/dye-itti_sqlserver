<script>
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
			/*
					document.form1.k_resep.removeAttribute("disabled");
					document.form1.k_resep.setAttribute("required",true);*/

		} else {
			document.form1.suhu_poly.setAttribute("readonly", true);
			document.form1.suhu_poly.removeAttribute("required");
			document.form1.ph_poly.setAttribute("readonly", true);
			document.form1.ph_poly.removeAttribute("required");
			/*document.form1.k_resep.setAttribute("disabled",true);
			document.form1.k_resep.removeAttribute("required");  */
		}
	}

	function aktif2() {
		if ((document.forms['form1']['sts'].value == "1" || document.forms['form1']['sts'].value == "5") && document.forms['form1']['sts_analisa'].value == "melebihi target") {
			document.form1.analisa.removeAttribute("disabled");
			document.form1.analisa.setAttribute("required", true);
			document.form1.jml_topping.setAttribute("disabled", true);
			document.form1.jml_topping.removeAttribute("required");
		} else if (document.forms['form1']['sts'].value == "1" || document.forms['form1']['sts'].value == "5") {
			/*document.form1.k_resep.removeAttribute("disabled");
			document.form1.k_resep.setAttribute("required",true);*/
			document.form1.ket.removeAttribute("required");
			document.form1.jml_topping.setAttribute("disabled", true);
			document.form1.jml_topping.removeAttribute("required");
			document.form1.analisa.setAttribute("disabled", true);
			document.form1.analisa.removeAttribute("required");
		} else if (document.forms['form1']['sts'].value == "2") {
			document.form1.jml_topping.removeAttribute("disabled");
			document.form1.jml_topping.setAttribute("required", true);
			document.form1.analisa.removeAttribute("disabled");
			document.form1.analisa.setAttribute("required", true);
			/*document.form1.k_resep.setAttribute("disabled",true);
			document.form1.k_resep.removeAttribute("required");	*/
		} else {
			document.form1.jml_topping.setAttribute("disabled", true);
			document.form1.jml_topping.removeAttribute("required");
			document.form1.analisa.setAttribute("disabled", true);
			document.form1.analisa.removeAttribute("required");
			/*document.form1.k_resep.setAttribute("disabled",true);
			document.form1.k_resep.removeAttribute("required");*/
			document.form1.ket.removeAttribute("required");
		}
	}

	function aktif3() {
		var str = document.forms['form1']['proses'].value;
		if (str.substr(0, 10) == "Cuci Mesin") {
			document.form1.point_proses.setAttribute("disabled", true);
			document.form1.point_proses.removeAttribute("required");
		} else {
			document.form1.point_proses.removeAttribute("disabled");
			document.form1.point_proses.setAttribute("required", true);
		}
		if (str.substr(0, 15) != "Celup Perbaikan") {
			document.form1.status_proses.setAttribute("disabled", true);
			document.form1.status_proses.removeAttribute("required");
		} else {
			document.form1.status_proses.removeAttribute("disabled");
			document.form1.status_proses.setAttribute("required", true);
		}
	}

	function aktif4() {
		var str = document.forms['form1']['gerobak'].value;
		if (str == "") {
			document.form1.jns_gerobak.setAttribute("disabled", true);
		} else {
			document.form1.jns_gerobak.removeAttribute("disabled");
		}
	}

	function aktif5() {
		if ((document.forms['form1']['k_resep'].value == "1x" || document.forms['form1']['k_resep'].value == "2x" || document.forms['form1']['k_resep'].value == "3x" || document.forms['form1']['k_resep'].value == "4x" || document.forms['form1']['k_resep'].value == "5x" || document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.analisa_topping.removeAttribute("disabled");
			document.form1.analisa_topping.setAttribute("required", true);
		} else {
			document.form1.analisa_topping.setAttribute("disabled", true);
			document.form1.analisa_topping.removeAttribute("required");
		}
	}

	function aktif6() {
		if ((document.forms['form1']['k_resep'].value == "1x" || document.forms['form1']['k_resep'].value == "2x" || document.forms['form1']['k_resep'].value == "3x" || document.forms['form1']['k_resep'].value == "4x" || document.forms['form1']['k_resep'].value == "5x" || document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.tambah_obat1.removeAttribute("disabled");
			document.form1.tambah_obat1.setAttribute("required", true);
		} else {
			document.form1.tambah_obat1.setAttribute("disabled", true);
			document.form1.tambah_obat1.removeAttribute("required");
		}
		if ((document.forms['form1']['k_resep'].value == "2x" || document.forms['form1']['k_resep'].value == "3x" || document.forms['form1']['k_resep'].value == "4x" || document.forms['form1']['k_resep'].value == "5x" || document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.tambah_obat2.removeAttribute("disabled");
			document.form1.tambah_obat2.setAttribute("required", true);
		} else {
			document.form1.tambah_obat2.setAttribute("disabled", true);
			document.form1.tambah_obat2.removeAttribute("required");
		}
		if ((document.forms['form1']['k_resep'].value == "3x" || document.forms['form1']['k_resep'].value == "4x" || document.forms['form1']['k_resep'].value == "5x" || document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.tambah_obat3.removeAttribute("disabled");
			document.form1.tambah_obat3.setAttribute("required", true);
		} else {
			document.form1.tambah_obat3.setAttribute("disabled", true);
			document.form1.tambah_obat3.removeAttribute("required");
		}
		if ((document.forms['form1']['k_resep'].value == "4x" || document.forms['form1']['k_resep'].value == "5x" || document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.tambah_obat4.removeAttribute("disabled");
			document.form1.tambah_obat4.setAttribute("required", true);
		} else {
			document.form1.tambah_obat4.setAttribute("disabled", true);
			document.form1.tambah_obat4.removeAttribute("required");
		}
		if ((document.forms['form1']['k_resep'].value == "5x" || document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.tambah_obat5.removeAttribute("disabled");
			document.form1.tambah_obat5.setAttribute("required", true);
		} else {
			document.form1.tambah_obat5.setAttribute("disabled", true);
			document.form1.tambah_obat5.removeAttribute("required");
		}
		if ((document.forms['form1']['k_resep'].value == "6x" || document.forms['form1']['k_resep'].value == "7x" || document.forms['form1']['k_resep'].value == "8x" || document.forms['form1']['k_resep'].value == "9x" || document.forms['form1']['k_resep'].value == "10x" || document.forms['form1']['k_resep'].value == ">10x")) {
			document.form1.tambah_obat6.removeAttribute("disabled");
			document.form1.tambah_obat6.setAttribute("required", true);
		} else {
			document.form1.tambah_obat6.setAttribute("disabled", true);
			document.form1.tambah_obat6.removeAttribute("required");
		}
	}

	window.addEventListener('DOMContentLoaded', function() {
		const noMcSelect = document.getElementById('no_mc');
		const outToSelect = document.getElementById('out_to');

		if (noMcSelect && outToSelect) {
  	  const selectedNoMc = (noMcSelect.value || '').trim();
  	  outToSelect.disabled = (selectedNoMc !== 'BB11');
  	}
	});
</script>
<script>
  // Tambah baris baru
  $(document).on('click', '#addAnalisa', function (e) {
    e.preventDefault();
    const idx = nextAnalisaIndex();
    createAnalisaRow(idx);
    renumberAnalisaLabels();
    syncAnalisaDisabled();
    updateAnalisaCombined();
  });

  $(document).on('click', '.remove-analisa', function () {
    $(this).closest('.analisa-line').remove();
    renumberAnalisaLabels();
    updateAnalisaCombined();
  });

  $(document).on('change', '#analisa-wrapper .analisa-select', updateAnalisaCombined);

  $(function () {
    renumberAnalisaLabels();
    syncAnalisaDisabled();   // ➜ set awal: ikut baris pertama
    updateAnalisaCombined();
  });

  // ---------- Helpers ----------
  function nextAnalisaIndex() {
    return $('#analisa-wrapper .analisa-line').length + 1;
  }

  function renumberAnalisaLabels() {
    $('#analisa-wrapper .analisa-line').each(function (i) {
      $(this).find('.analisa-label').text('Analisa ' + (i + 1));
    });
  }

  function updateAnalisaCombined() {
    const vals = $('#analisa-wrapper .analisa-select')
      .map(function(){ return $(this).val(); })
      .get()
      .filter(v => v && v.trim() !== '');
    $('#analisaCombined').val(vals.join(' | '));
  }

  function syncAnalisaDisabled() {
    const isDisabled = $('#analisa').is(':disabled');
    $('#analisa-wrapper .analisa-select').prop('disabled', isDisabled);
  }

  function createAnalisaRow(idx) {
    const optionsHtml = $('#analisa').html();
    const isDisabled = $('#analisa').is(':disabled');  // ➜ copy status enable/disable

    const rowHtml = [
      '<div class="row analisa-line" data-index="'+idx+'">',
        '<label class="col-sm-3 control-label analisa-label">Analisa '+idx+'</label>',
        '<div class="col-sm-5">',
          '<select name="analisa'+idx+'" class="form-control analisa-select" id="analisa'+idx+'" '+(isDisabled?'disabled':'')+' required>',
            optionsHtml,
          '</select>',
        '</div>',
        '<div class="col-sm-1 d-flex-center">',
          '<button type="button" class="btn btn-danger remove-analisa" title="Hapus baris">-</button>',
        '</div>',
      '</div>'
    ].join('');

    $('#analisaCombined').before(rowHtml);
  }
</script>

<style>
  #analisa-wrapper .analisa-line { 
    margin-bottom: 16px;              /* ➜ lebih renggang */
  }
  /* rapikan vertical align tombol */
  #analisa-wrapper .d-flex-center {
    display: flex; 
    align-items: center;
  }
  /* samakan tinggi tombol */
  #analisa-wrapper .btn { 
    padding-top: 6px; 
    padding-bottom: 6px; 
  }
</style>

<?php
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
$nokk = $_GET['nokk'];
	function rcode($nokk, $resep){
	$host = "10.0.4.7\SQLEXPRESS";
	$username = "sa";
	$password = "123";
	$db_name = "TICKET";
	$connInfo = array("Database" => $db_name, "UID" => $username, "PWD" => $password);
	$conn1     = sqlsrv_connect($host, $connInfo);
	if ($resep != '') {
		$ket .= " AND ID_NO='$resep' ";
	} else {
		$ket .= "";
	}
	$sqlc = "select USER28 from ticket_title where YARN='$nokk' " . $ket . " order by createtime Desc";
	//--lot
	// $qryc = sqlsrv_query($conn1, $sqlc);
	// $row = sqlsrv_fetch_array($qryc);
	// $rcode = $row['USER28'];
	// return $rcode;
}
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

$sqlCek1 = mysqli_query($con, "SELECT
										c.*,a.id as ids,b.id as idm 
									FROM
										tbl_schedule a
									INNER JOIN tbl_montemp b ON a.id=b.id_schedule
									INNER JOIN tbl_hasilcelup c ON b.id=c.id_montemp
									WHERE
										a.nokk = '$nokk' and b.status='selesai'
									ORDER BY
										a.id DESC 
										LIMIT 1");
$cek1 = mysqli_num_rows($sqlCek1);
$rcek1 = mysqli_fetch_array($sqlCek1);
$qryLama = mysqli_query($con, "SELECT
										TIME_FORMAT( timediff( now(), b.tgl_buat ), '%H:%i' ) AS lama 
									FROM
										tbl_schedule a
										LEFT JOIN tbl_montemp b ON a.id = b.id_schedule 
									WHERE
										b.nokk = '$nokk' 
										AND b.STATUS = 'sedang jalan' 
									ORDER BY
										a.no_urut ASC");
$rLama = mysqli_fetch_array($qryLama);
$sqlCek2 = mysqli_query($con, "SELECT
										id,
										if(COUNT(lot)>1,'Gabung Kartu','') as ket_kartu,
										if(COUNT(lot)>1,CONCAT('(',COUNT(lot),'kk',')'),'') as kk,
										GROUP_CONCAT(nokk SEPARATOR ', ') as g_kk,
										no_mesin,
										no_urut,	
										sum(rol) as rol,
										sum(bruto) as bruto
									FROM
										tbl_schedule 
									WHERE
										(`status` = 'sedang jalan' or `status` = 'antri mesin') and no_mesin='$rcek[no_mesin]' and no_urut='$rcek[no_urut]'
									GROUP BY
										no_mesin,
										no_urut 
									ORDER BY
										id ASC");
$cek2 = mysqli_num_rows($sqlCek2);
$rcek2 = mysqli_fetch_array($sqlCek2);
if ($rcek2['ket_kartu'] != "") {
	$ketsts = $rcek2['ket_kartu'] . "\n(" . $rcek2['g_kk'] . ")";
} else {
	$ketsts = "";
}
$sqlCek3 = mysqli_query($con, "SELECT
										* 
									FROM
										tbl_montemp 
									WHERE
										nokk = '$nokk' 
										AND ( STATUS = 'antri mesin' OR STATUS = 'sedang jalan' ) 
									ORDER BY
										id DESC 
										LIMIT 1");
$cek3 = mysqli_num_rows($sqlCek3);
$rcek3 = mysqli_fetch_array($sqlCek3);
$sqlCekAir = mysqli_query($con, "SELECT
										air_awal,
										waktu_tunggu 
									FROM
										tbl_montemp 
									WHERE
										nokk = '$nokk' 
									ORDER BY
										id DESC 
										LIMIT 1");
$cekAir = mysqli_num_rows($sqlCekAir);
$rcekAir = mysqli_fetch_array($sqlCekAir);
$sqlRcode = mysqli_query($con, "SELECT
										no_resep
									FROM
										tbl_schedule 
									WHERE
										nokk = '$nokk' 
									ORDER BY
										id DESC 
										LIMIT 1");
$rRcode = mysqli_fetch_array($sqlRcode);
$sqlTopping = mysqli_query($con, "SELECT
											jml_topping 
										FROM
											tbl_hasilcelup 
										WHERE
											nokk = '$nokk' 
										ORDER BY
											id DESC 
											LIMIT 1");
$rTopping = mysqli_fetch_array($sqlTopping);
$sqltarget = mysqli_query($con, "SELECT
										IF( b.tgl_target <= now(), 'melebihi target', 'sedang berjalan' ) AS cek_delay,
											a.target,(round( LEFT ( c.lama_proses, 2 ))+ round( RIGHT ( c.lama_proses, 2 )/ 60, 2 )) AS lama_proses,
										IF(isnull( c.lama_proses ),'jalan',IF(a.target >=(round(LEFT ( c.lama_proses, 2 ))+ round( RIGHT ( c.lama_proses, 2 )/ 60, 2 )),'sesuai target','melebihi target')) AS sts 
										FROM
											db_dying.tbl_schedule a
										LEFT JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule
										LEFT JOIN db_dying.tbl_hasilcelup c ON b.id = c.id_montemp 
										WHERE
											b.nokk = '$nokk' 
										ORDER BY
											b.id DESC 
											LIMIT 1");
$cktarget = mysqli_fetch_array($sqltarget);

// UPDATE NILO
$q_hasilcelup	= mysqli_query($con, "SELECT 
													*,
													a.`status` AS sts_celup,
													a.shift AS shift_celup,
													a.g_shift as g_shift_celup,
													a.analisa AS analisa_celup,
													a.kd_stop AS kd_stop_celup,
													a.mulai_stop AS mulai_stop_celup,
													a.selesai_stop AS selesai_stop_celup,
													a.proses AS proses_celup
												FROM
													tbl_hasilcelup a
													LEFT JOIN tbl_montemp c ON a.id_montemp = c.id
													LEFT JOIN tbl_schedule b ON c.id_schedule = b.id
												WHERE
													a.id = '$_GET[id]'");
$row_hasilcelup	= mysqli_fetch_assoc($q_hasilcelup);

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

$sql_kode_kategori_warna	= db2_exec($conn2, "SELECT
														u.CODE,
														a.VALUESTRING,
														CASE
															WHEN SUBSTR(a.VALUESTRING, 1,1) = 'D' THEN 'Dark'
															WHEN SUBSTR(a.VALUESTRING, 1,1) = 'H' THEN 'Heater'
															WHEN SUBSTR(a.VALUESTRING, 1,1) = 'L' THEN 'Light'
															WHEN SUBSTR(a.VALUESTRING, 1,1) = 'M' THEN 'Medium'
															WHEN SUBSTR(a.VALUESTRING, 1,1) = 'S' THEN 'Special'
															WHEN SUBSTR(a.VALUESTRING, 1,1) = 'W' THEN 'White'
														END AS KATEGORI_WARNA	
													FROM
														USERGENERICGROUP u
													LEFT JOIN ADSTORAGE a ON a.UNIQUEID = u.ABSUNIQUEID AND a.FIELDNAME = 'ColorGroupCode'
													LEFT JOIN USERGENERICGROUP u2 ON u2.CODE = a.VALUESTRING AND u2.USERGENERICGROUPTYPECODE = 'CLG'
													WHERE
														u.USERGENERICGROUPTYPECODE = 'CL1'
														AND NOT u.SHORTDESCRIPTION LIKE '%delete%'
														AND u.CODE = '$dt_ITXVIEWKK[NO_WARNA]'");
$dt_kode_kategori_warna	= db2_fetch_assoc($sql_kode_kategori_warna);
// UPDATE NILO
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
			<?php if(!empty($_GET['id'])) : ?>
				<h3 class="box-title">Ubah Data Kartu Kerja</h3>
			<?php else : ?>
				<h3 class="box-title">Input Data Kartu Kerja</h3>
			<?php endif; ?>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">Production Order</label>
					<div class="col-sm-4">
						<?php if(!empty($_GET['id'])) : ?>
							<input name="nokk" type="text" class="form-control" id="nokk" value="<?= $row_hasilcelup['nokk']; ?>" placeholder="No KK" required readonly>
						<?php else : ?>
							<input name="nokk" type="text" class="form-control" id="nokk" onchange="window.location='?p=Form-Celup&nokk='+this.value" value="<?php echo $_GET['nokk']; ?>" placeholder="No KK" required>
						<?php endif; ?>
					</div>
					<div class="col-sm-4">
						<input name="id" type="hidden" class="form-control" id="id" value="<?php if(!empty($_GET['id'])){ 
																								echo $row_hasilcelup['id_montemp'];
																								}else { 
																								echo $rcek['idm'];
																							} ?>" placeholder="ID">
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Production Demand</label>
					<div class="col-sm-8">
						<input name="demand" type="text" class="form-control" id="demand" value="<?php if (!empty($_GET['id'])) {
																										echo $row_hasilcelup['nodemand'];
																									}else{ 
																										echo $rcek['nodemand'];
																									} ?>" placeholder="Production Demand" <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Langganan</label>
					<div class="col-sm-8">
						<input name="langganan" type="text" class="form-control" id="langganan" placeholder="Langganan" value="<?php if (!empty($_GET['id'])) {
																																	echo $row_hasilcelup['langganan'];
																																} else {
																																	echo $rcek['langganan'];
																																} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-8">
						<input name="buyer" type="text" class="form-control" id="buyer" placeholder="Buyer" value="<?php if (!empty($_GET['id'])) {
																														echo $row_hasilcelup['buyer'];
																													} else {
																														echo $rcek['buyer'];
																													} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="no_order" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="no_order" type="text" required class="form-control" id="no_order" placeholder="No Order" value="<?php if (!empty($_GET['id'])) {
																																			echo $row_hasilcelup['no_order'];
																																		} else {
																																			echo $rcek['no_order'];
																																		} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">PO</label>
					<div class="col-sm-5">
						<input name="no_po" type="text" class="form-control" id="no_po" placeholder="PO" value="<?php if (!empty($_GET['id'])) {
																													echo $row_hasilcelup['po'];
																												} else {
																													echo $rcek['po'];
																												} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
					<div class="col-sm-3">
						<input name="no_hanger" type="text" class="form-control" id="no_hanger" placeholder="No Hanger" value="<?php if (!empty($_GET['id'])) {
																																	echo $row_hasilcelup['no_hanger'];
																																} else {
																																	echo $rcek['no_hanger'];
																																} ?>" readonly="readonly">
					</div>
					<div class="col-sm-3">
						<input name="no_item" type="text" class="form-control" id="no_item" placeholder="No Item" value="<?php if (!empty($_GET['id'])) {
																																echo $row_hasilcelup['no_item'];
																															} else {
																																echo $rcek['no_item'];
																															} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
					<div class="col-sm-8">
						<textarea name="jns_kain" readonly="readonly" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if (!empty($_GET['id'])) {
																																		echo $row_hasilcelup['jenis_kain'];
																																	} else {
																																		echo $rcek['jenis_kain'];
																																	} ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="tgl_delivery" type="text" disabled="disabled" required class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if (!empty($_GET['id'])) {
																																														echo $row_hasilcelup['tgl_delivery'];
																																													} else {
																																														echo $rcek['tgl_delivery'];
																																													} ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="l_g" class="col-sm-3 control-label">L X Grm Permintaan</label>
					<div class="col-sm-2">
						<input name="lebar" type="text" required class="form-control" id="lebar" placeholder="0" value="<?php if (!empty($_GET['id'])) {
																															echo $row_hasilcelup['lebar'];
																														} else {
																															echo $rcek['lebar'];
																														} ?>" readonly="readonly">
					</div>
					<div class="col-sm-2">
						<input name="grms" type="text" required class="form-control" id="grms" placeholder="0" value="<?php if (!empty($_GET['id'])) {
																															echo $row_hasilcelup['gramasi'];
																														} else {
																															echo $rcek['gramasi'];
																														} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-8">
						<input name="warna" type="text" class="form-control" id="warna" placeholder="Warna" value="<?php if (!empty($_GET['id'])) {
																														echo $row_hasilcelup['warna'];
																													} else {
																														echo $rcek['warna'];
																													} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="no_warna" class="col-sm-3 control-label">No Warna</label>
					<div class="col-sm-8">
						<input name="no_warna" type="text" class="form-control" id="no_warna" placeholder="No Warna" value="<?php if (!empty($_GET['id'])) {
																																echo $row_hasilcelup['no_warna'];
																															} else {
																																echo $rcek['no_warna'];
																															} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty1" type="text" required class="form-control" id="qty1" placeholder="0.00" value="<?php if (!empty($_GET['id'])) {
																																	echo $row_hasilcelup['qty_order'];
																																} else {
																																	echo $rcek['qty_order'];
																																} ?>" readonly="readonly">
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group">
							<input name="qty2" type="text" required class="form-control" id="qty2" placeholder="0.00" style="text-align: right;" value="<?php if (!empty($_GET['id'])) {
																																							echo $row_hasilcelup['pjng_order'];
																																						} else {
																																							echo $rcek['pjng_order'];
																																						} ?>" readonly="readonly">
							<span class="input-group-addon">
								<select name="satuan1" disabled="disabled" style="font-size: 12px;">
									<option value="Yard" <?php if ($rcek['satuan_order'] == "Yard" OR $row_hasilcelup['satuan_order'] == "Yard") {
																echo "SELECTED";
															} ?>>Yard</option>
									<option value="Meter" <?php if ($rcek['satuan_order'] == "Meter" OR $row_hasilcelup['satuan_order'] == "Meter") {
																echo "SELECTED";
															} ?>>Meter</option>
									<option value="PCS" <?php if ($rcek['satuan_order'] == "PCS" OR $row_hasilcelup['satuan_order'] == "PCS") {
															echo "SELECTED";
														} ?>>PCS</option>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="lot" class="col-sm-3 control-label">Lot</label>
					<div class="col-sm-2">
						<input name="lot" type="text" class="form-control" id="lot" placeholder="Lot" value="<?php if (!empty($_GET['id'])) {
																													echo $rcek['lot'];
																												} else {
																													echo $row_hasilcelup['lot'];
																												} ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
					<div class="col-sm-2">
						<input name="qty3" type="text" required class="form-control" id="qty3" placeholder="0.00" value="<?= $row_hasilcelup['rol']; ?><?php if ($cek2 > 0) {
																																							echo $rcek2['rol'] . $rcek2['kk'];
																																						} else {
																																							if ($r['RollCount'] != "") {
																																								echo round($r['RollCount']);
																																							} else if ($nokk != "") {
																																								echo $cekM['jml_roll'];
																																							}
																																						} ?>" readonly="readonly">
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty4" type="text" required class="form-control" id="qty4" placeholder="0.00" style="text-align: right;" value="<?= $row_hasilcelup['bruto']; ?><?php if ($cek2 > 0) {
																																															echo $rcek2['bruto'];
																																														} else {
																																															if ($r['Weight'] != "") {
																																																echo round($r['Weight'], 2);
																																															} else if ($nokk != "") {
																																																echo $cekM['bruto'];
																																															}
																																														} ?>" readonly="readonly">
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
				</div>
				<?php
				if ($cek > 0 and $_GET['kap'] != "") {
					$loading = round($rcek['bruto'] / $_GET['kap'], 4) * 100;
				} else {
					if ($r['Weight'] != "" and $_GET['kap'] != "") {
						$loading = round($r['Weight'] / $_GET['kap'], 4) * 100;
					} else if ($nokk != "" and $_GET['kap'] != "") {
						$loading = round($cekM['bruto'] / $_GET['kap'], 4) * 100;
					}
				}
				?>
				<div class="form-group">
					<label for="kapasitas" class="col-sm-3 control-label">Kapasitas Mesin</label>
					<div class="col-sm-3">
						<select name="kapasitas" disabled="disabled" class="form-control">
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT kapasitas FROM tbl_mesin GROUP BY kapasitas ORDER BY kapasitas DESC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['kapasitas']; ?>" <?php if ($rcek['kapasitas'] == $rK['kapasitas'] OR $row_hasilcelup['kapasitas'] == $rK['kapasitas']) {
																					echo "SELECTED";
																				} ?>><?php echo $rK['kapasitas']; ?> KGs</option>
							<?php } ?>
						</select>
					</div>

				</div>
				<?php
				if ($cek > 0 and ($rcek['kapasitas'] != "" and $rcek['kapasitas'] != "0")) {
					$loading = round($rcek['bruto'] / $rcek['kapasitas'], 4) * 100;
				} else {
					if ($r['Weight'] != "" and ($rcek['kapasitas'] != "" and $rcek['kapasitas'] != "0")) {
						$loading = round($r['Weight'] / $rcek['kapasitas'], 4) * 100;
					} else if ($nokk != "" and ($rcek['kapasitas'] != "" and $rcek['kapasitas'] != "0")) {
						$loading = round($cekM['bruto'] / $rcek['kapasitas'], 4) * 100;
					}
				}
				?>
				<div class="form-group">
					<label for="no_mc" class="col-sm-3 control-label">No MC</label>
					<div class="col-sm-2">
						<select id="no_mc" name="no_mc" disabled="disabled" class="form-control">
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT no_mesin FROM tbl_mesin WHERE kapasitas='$rcek[kapasitas]$row_hasilcelup[kapasitas]' ORDER BY no_mesin ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['no_mesin']; ?>"
								<?php if ($rcek['no_mesin'] == $rK['no_mesin'] OR $row_hasilcelup['no_mesin'] == $rK['no_mesin']) {
										echo "SELECTED";
									}
									?>>
									<?php echo $rK['no_mesin']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label for="out_to" class="col-sm-2 control-label">Out To</label>
					<div class="col-sm-2">
						<select id="out_to" name="out_to" disabled="disabled" class="form-control">
							<option value="-">Pilih</option>
							<option value="PPC">PPC</option>
							<option value="CB">CB</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="rcode1" class="col-sm-3 control-label">Rcode</label>
					<div class="col-sm-3">
						<!-- <input name="rcode1" type="text" class="form-control" id="rcode1" value="<?= trim(rcode($nokk, $rRcode['no_resep'])); ?>"> -->
						<?php
							if($_GET['nokk']){
							$nokk = $_GET['nokk'];
							}else{
							$nokk = $row_hasilcelup['nokk'];
						}
						$cari_dari_greige	 = mysqli_query($con, "SELECT * FROM `tbl_schedule` WHERE nokk = '$nokk' AND ket_status = 'Greige'");
						$row_schedule_greige = mysqli_fetch_assoc($cari_dari_greige);

							if($row_schedule_greige['suffix'] == 001){
								$_noprod    = substr($row_schedule_greige['no_resep2'], 0,8);
							$_groupline	= substr($row_schedule_greige['no_resep2'], 9);
							}else{
								$_noprod    = substr($row_schedule_greige['no_resep'], 0,8);
							$_groupline	= substr($row_schedule_greige['no_resep'], 9);
						}

						$db2_rcode			= db2_exec($conn2, "SELECT 
																		a.VALUESTRING AS RCODE
																	FROM
																		PRODUCTIONRESERVATION p
																	LEFT JOIN RECIPE r ON r.SUBCODE01 = p.SUBCODE01 AND r.SUFFIXCODE = p.SUFFIXCODE 
																	LEFT JOIN ADSTORAGE a ON a.UNIQUEID = r.ABSUNIQUEID AND a.FIELDNAME = 'RCode'
																	WHERE 
																		p.PRODUCTIONORDERCODE = '$_noprod' AND GROUPLINE = '$_groupline'");
						$dt_rcode    		= db2_fetch_assoc($db2_rcode);

						$data_rcode = $dt_rcode['RCODE'];
						?>
						<input name="rcode1" type="text" class="form-control" id="rcode1" value="<?= $data_rcode; ?>" <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>

					</div>
				</div>
				<div class="form-group">
					<label for="sts" class="col-sm-3 control-label">Status</label>
					<div class="col-sm-5">
						<select name="sts" class="form-control" id="sts" onChange="aktif2();" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="1" <?php if($row_hasilcelup['sts_celup'] == "OK") { echo "Selected"; } ?>>OK</option>
							<option value="5" <?php if($row_hasilcelup['sts_celup'] == "Celup Poly Dulu-Matching") { echo "Selected"; } ?>>Celup Poly Dulu-Matching</option>
							<option value="2" <?php if($row_hasilcelup['sts_celup'] == "Gagal Proses") { echo "Selected"; } ?>>Gagal Proses</option>
							<option value="3" <?php if($row_hasilcelup['sts_celup'] == "Levelling-Matching") { echo "Selected"; } ?>>Levelling-Matching</option>
							<option value="4" <?php if($row_hasilcelup['sts_celup'] == "Pelunturan-Matching") { echo "Selected"; } ?>>Pelunturan-Matching</option>
							<option value="6" <?php if($row_hasilcelup['sts_celup'] == "Scouring Turun") { echo "Selected"; } ?>>Scouring Turun</option>
							<option value="7" <?php if($row_hasilcelup['sts_celup'] == "Continuous - Bleaching") { echo "Selected"; } ?>>Continuous - Bleaching</option>
							<option value="8" <?php if($row_hasilcelup['sts_celup'] == "Relaxing - Priset") { echo "Selected"; } ?>>Relaxing - Priset</option>
							<option value="9" <?php if($row_hasilcelup['sts_celup'] == "Tunggu Review") { echo "Selected"; } ?>>Tunggu Review</option>
						</select>
					</div>
					<div class="col-sm-3">
						<select name="jml_topping" class="form-control" id="jml_topping" required disabled="disabled">
							<option value="">Jml Topping</option>
							<option value="-">-</option>
							<option value="0x" <?php if ($rTopping['jml_topping'] == "0x") {
													echo "SELECTED";
												} ?>>0x</option>
							<option value="1x" <?php if ($rTopping['jml_topping'] == "1x") {
													echo "SELECTED";
												} ?>>1x</option>
							<option value="2x" <?php if ($rTopping['jml_topping'] == "2x") {
													echo "SELECTED";
												} ?>>2x</option>
							<option value="3x" <?php if ($rTopping['jml_topping'] == "3x") {
													echo "SELECTED";
												} ?>>3x</option>
							<option value="4x" <?php if ($rTopping['jml_topping'] == "4x") {
													echo "SELECTED";
												} ?>>4x</option>
							<option value="5x" <?php if ($rTopping['jml_topping'] == "5x") {
													echo "SELECTED";
												} ?>>5x</option>
							<option value="6x" <?php if ($rTopping['jml_topping'] == "6x") {
													echo "SELECTED";
												} ?>>6x</option>
							<option value="7x" <?php if ($rTopping['jml_topping'] == "7x") {
													echo "SELECTED";
												} ?>>7x</option>
							<option value="8x" <?php if ($rTopping['jml_topping'] == "8x") {
													echo "SELECTED";
												} ?>>8x</option>
							<option value="9x" <?php if ($rTopping['jml_topping'] == "9x") {
													echo "SELECTED";
												} ?>>9x</option>
							<option value="10x" <?php if ($rTopping['jml_topping'] == "10x") {
													echo "SELECTED";
												} ?>>10x</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="shift" class="col-sm-3 control-label">Shift</label>
					<div class="col-sm-2">
						<select name="shift" class="form-control" required <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="1" <?php if($row_hasilcelup['shift_celup'] == "1") { echo "Selected"; } ?>>1</option>
							<option value="2" <?php if($row_hasilcelup['shift_celup'] == "2") { echo "Selected"; } ?>>2</option>
							<option value="3" <?php if($row_hasilcelup['shift_celup'] == "3") { echo "Selected"; } ?>>3</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="g_shift" class="col-sm-3 control-label">Group Shift</label>
					<div class="col-sm-2">
						<select name="g_shift" class="form-control" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="A" <?php if($row_hasilcelup['g_shift_celup'] == "A") { echo "Selected"; } ?>>A</option>
							<option value="B" <?php if($row_hasilcelup['g_shift_celup'] == "B") { echo "Selected"; } ?>>B</option>
							<option value="C" <?php if($row_hasilcelup['g_shift_celup'] == "C") { echo "Selected"; } ?>>C</option>
						</select>
					</div>
					<div class="col-sm-6">
						<input name="sts_analisa" type="text" class="form-control" id="sts_analisa" value="<?php if ($cktarget['sts'] == "jalan") {
																												echo $cktarget['cek_delay'];
																											} else {
																												echo $cktarget['sts'];
																											} ?>" placeholder="" readonly>
					</div>
				</div>
				<div class="form-group" id="analisa-wrapper">
				  <label class="col-sm-3 control-label">Analisa</label>

				  <div class="col-sm-5 analisa-row" data-index="1">
				    <select name="analisa" class="form-control analisa-select" id="analisa" disabled="disabled" required>
							<option value="">Pilih</option>
							<?php
							$sqlAn = mysqli_query($con, "SELECT * FROM tbl_analisa ORDER BY nama ASC");
							while ($rAn = mysqli_fetch_array($sqlAn)) {
							?>
								<option value="<?php echo $rAn['nama']; ?>"
									<?php if ($rcek['analisa'] == $rAn['nama'] || $row_hasilcelup['analisa'] == $rAn['nama']) echo "selected"; ?>>
									<?php echo $rAn['nama']; ?>
								</option>
							<?php } ?>
				    </select>
				  </div>
				  <div class="col-sm-1 text-center">
				    <button type="button" id="addAnalisa" class="btn btn-success" title="Tambah analisa">+</button>
				  </div>

				  <?php 
				    $allowed_users = ['andri','luqman','aris.miyanta','rohman','dit'];
				    if (isset($_SESSION['user_id10']) && in_array(strtolower($_SESSION['user_id10']), $allowed_users)) { ?>
				      <div class="col-sm-1">
				        <a href="#" data-toggle="modal" data-target="#DataAnalisa" class="btn btn-primary">...</a>
				      </div>
				  <?php } ?>
						
				  <div class="col-sm-12" id="analisa-spacer" style="margin-top:10px;"></div>
				  <input type="hidden" name="analisaCombined" id="analisaCombined">
				</div>
			</div>
			<!-- col -->
			<div class="col-md-6">
				<div class="form-group">
					<label for="kodesm" class="col-sm-3 control-label">Kode Stop Mesin</label>
					<div class="col-sm-2">
						<select name="kodesm" class="form-control" onChange="aktif();" id="kodesm"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="LM" <?php if($row_hasilcelup['kd_stop_celup'] == "LM") { echo "Selected"; } ?>>LM</option>
							<option value="KM" <?php if($row_hasilcelup['kd_stop_celup'] == "KM") { echo "Selected"; } ?>>KM</option>
							<option value="PT" <?php if($row_hasilcelup['kd_stop_celup'] == "PT") { echo "Selected"; } ?>>PT</option>
							<option value="KO" <?php if($row_hasilcelup['kd_stop_celup'] == "KO") { echo "Selected"; } ?>>KO</option>
							<option value="AP" <?php if($row_hasilcelup['kd_stop_celup'] == "AP") { echo "Selected"; } ?>>AP</option>
							<option value="PA" <?php if($row_hasilcelup['kd_stop_celup'] == "PA") { echo "Selected"; } ?>>PA</option>
							<option value="PM" <?php if($row_hasilcelup['kd_stop_celup'] == "PM") { echo "Selected"; } ?>>PM</option>
							<option value="GT" <?php if($row_hasilcelup['kd_stop_celup'] == "GT") { echo "Selected"; } ?>>GT</option>
							<option value="TG" <?php if($row_hasilcelup['kd_stop_celup'] == "TG") { echo "Selected"; } ?>>TG</option>
							<option value="OK" <?php if($row_hasilcelup['kd_stop_celup'] == "OK") { echo "Selected"; } ?>>OK</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" class="form-control timepicker" name="waktu_mulai" id="waktu_mulai" placeholder="00:00" disabled >
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="mulaism" type="text" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="<?= $row_hasilcelup['mulai_stop_celup']; ?>" disabled />
						</div>
					</div>

				</div>
				<div class="form-group">
					<label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" class="form-control timepicker" name="waktu_stop"  placeholder="00:00" disabled>
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="selesaism" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?= $row_hasilcelup['selesai_stop_celup']; ?>" disabled />
						</div>
					</div>

				</div>
				<div class="form-group">
					<label for="proses" class="col-sm-3 control-label">Aktual Proses</label>
					<div class="col-sm-5">
						<select name="proses" class="form-control" id="proses" onChange="aktif3();" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT proses FROM tbl_proses ORDER BY proses ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['proses']; ?>" <?php if($row_hasilcelup['proses_celup'] == $rK['proses']) { echo "SELECTED"; } ?>><?php echo $rK['proses']; ?></option>
							<?php } ?>
							<option value="Bakar Bulu">Bakar Bulu</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="shift" class="col-sm-3 control-label">Status Proses</label>
					<div class="col-sm-5">
						<select name="status_proses" class="form-control" id="status_proses" disabled="disabled" required>
							<option value="">Pilih</option>
							<?php
							$sqlAn = mysqli_query($con, "SELECT * FROM tbl_status_proses ORDER BY nama ASC");
							while ($rAn = mysqli_fetch_array($sqlAn)) {
							?>
								<option value="<?php echo $rAn['nama']; ?>" <?php if ($rcek['status_proses'] == $rAn['nama'] OR $row_hasilcelup['status_proses'] == $rAn['nama']) {
																				echo "SELECTED";
																			} ?>><?php echo $rAn['nama']; ?></option>
							<?php } ?>

						</select>

					</div>
					<?php 
						$allowed_users = ['andri', 'luqman', 'aris.miyanta', 'rohman','dit'];
						if (isset($_SESSION['user_id10']) && in_array(strtolower($_SESSION['user_id10']), $allowed_users)) { ?>
							<div class="col-sm-1">
								<a href="#" data-toggle="modal" data-target="#DataStatusProses" class="btn btn-primary">...</a>
							</div>
					<?php } ?>

				</div>
				<div class="form-group">
					<label for="no_resep" class="col-sm-3 control-label">No Bon Resep 1</label>
					<div class="col-sm-3">
						<input name="no_resep" type="text" class="form-control" id="no_resep" value="<?php if (!empty($_GET['id'])) {
																											echo $row_hasilcelup['no_resep'];
																										}else{
																											echo $rcek['no_resep'];
																										} ?>" placeholder="No Bon Resep 1"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
					</div>
					<div class="col-sm-3">
						<input name="suffix1" type="text" class="form-control" id="suffix1" value="<?php if (!empty($_GET['id'])) {
																										echo $row_hasilcelup['suffix'];
																										}else{
																										echo $rcek['suffix'];
																										} ?>" placeholder="Suffix"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group">
					<label for="no_resep2" class="col-sm-3 control-label">No Bon Resep 2</label>
					<div class="col-sm-3">
						<input name="no_resep2" type="text" class="form-control" id="no_resep2" value="<?php if (!empty($_GET['id'])) {
																											echo $row_hasilcelup['no_resep2'];
																										}else{
																											echo $rcek['no_resep2'];
																										} ?>" placeholder="No Bon Resep 2" <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
					</div>
					<div class="col-sm-3">
						<input name="suffix2" type="text" class="form-control" id="suffix2" value="<?php if (!empty($_GET['id'])) {
																										echo $row_hasilcelup['suffix2'];
																										}else{
																										echo $rcek['suffix2'];
																										} ?>" placeholder="Suffix2"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group">
					<label for="resep" class="col-sm-3 control-label">Resep</label>
					<div class="col-sm-3">
						<select name="resep" class="form-control" id="resep" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="Baru" <?php if ($rcek['resep'] == 'Baru' OR $row_hasilcelup['resep'] == 'Baru') {
														echo "SELECTED";
													} ?>>Baru</option>
							<option value="Lama" <?php if ($rcek['resep'] == 'lama' OR $row_hasilcelup['resep'] == 'lama') {
														echo "SELECTED";
													} ?>>Lama</option>
							<option value="Setting" <?php if ($rcek['resep'] == 'Setting' OR $row_hasilcelup['resep'] == 'Setting') {
														echo "SELECTED";
													} ?>>Setting</option>
						</select>
					</div>
					<label for="resep" class="col-sm-2 control-label">Arah Warna</label>
					<div class="col-sm-3">
						<?php
						$q_arah_warna = db2_exec($conn2, "SELECT
																a.VALUESTRING,
																SUBSTRING(a2.OPTIONS, 
																			POSITION(';' || a.VALUESTRING || '=' IN a2.OPTIONS) + LENGTH(a.VALUESTRING) + 2,
																			POSITION(';' IN SUBSTRING(a2.OPTIONS, POSITION(';' || a.VALUESTRING || '=' IN a2.OPTIONS) + LENGTH(a.VALUESTRING) + 2)) - 1
																		) AS ARAH_WARNA
															FROM
																RECIPE r
															LEFT JOIN ADSTORAGE a ON a.UNIQUEID = r.ABSUNIQUEID AND a.FIELDNAME = 'Chroma'
															LEFT JOIN ADADDITIONALDATA a2 ON a2.NAME = a.FIELDNAME 
															WHERE
																r.SUFFIXCODE = '$rcek[suffix]'");
						$dt_arah_warna = db2_fetch_assoc($q_arah_warna);
						?>
						<input name="arah_warna" class="form-control" value="<?= $dt_arah_warna['ARAH_WARNA'] ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="kategori_warna" class="col-sm-3 control-label">Kategori Warna</label>
					<div class="col-sm-3">
						<select name="kategori_warna" class="form-control" id="kategori_warna"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<?php
							$q_kategori_warna	= db2_exec($conn2, "SELECT
																		TRIM(u.CODE) AS CODE,
																		u.LONGDESCRIPTION,
																		u.SHORTDESCRIPTION,
																		u.SEARCHDESCRIPTION,
																		CASE
																			WHEN SUBSTR(u.CODE, 1,1) = 'D' THEN 'Dark'
																			WHEN SUBSTR(u.CODE, 1,1) = 'H' THEN 'Heater'
																			WHEN SUBSTR(u.CODE, 1,1) = 'L' THEN 'Light'
																			WHEN SUBSTR(u.CODE, 1,1) = 'M' THEN 'Medium'
																			WHEN SUBSTR(u.CODE, 1,1) = 'S' THEN 'Special'
																			WHEN SUBSTR(u.CODE, 1,1) = 'W' THEN 'White'
																		END AS KATEGORI_WARNA	
																	FROM
																		USERGENERICGROUP u
																	WHERE
																		u.USERGENERICGROUPTYPECODE = 'CLG'
																		AND NOT u.CODE = 'NO'");
							?>
							<?php while ($row_kategori_warna = db2_fetch_assoc($q_kategori_warna)) : ?>
								<option value="<?= $row_kategori_warna['CODE'] ?>"
									<?php if($dt_kode_kategori_warna['VALUESTRING'] == $row_kategori_warna['CODE']) { echo "SELECTED"; } ?>>
									<?= $row_kategori_warna['CODE'] ?> - <?= $row_kategori_warna['LONGDESCRIPTION'] ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
					<label for="status_warna" class="col-sm-2 control-label">Status Warna</label>
					<div class="col-sm-3">
						<select name="status_warna" class="form-control" id="status_warna" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="Warna Baru" <?php if ($row_hasilcelup['resep'] == 'Warna Baru') {
															echo "SELECTED";
														} ?>>Warna Baru</option>
							<option value="Warna Lama" <?php if ($row_hasilcelup['resep'] == 'Warna Lama') {
															echo "SELECTED";
														} ?>>Warna Lama</option>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="point_proses" class="col-sm-3 control-label">Point Proses</label>
					<div class="col-sm-4">
						<select name="point_proses" class="form-control" id="point_proses" required <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT proses,point FROM tbl_point_greige ORDER BY proses ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['proses'] . " #" . $rK['point']; ?>" <?php if($row_hasilcelup['point'] == $rK['point'] && $row_hasilcelup['proses_point'] == $rK['proses']) {echo "SELECTED";} ?>><?php echo $rK['proses']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label for="point_proses" class="col-sm-1 control-label">Point</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="point2" value="<?= $rcek['target']; ?>" readonly>
					</div>
				</div>
				<div class="form-group" hidden="">
					<label for="point" class="col-sm-3 control-label">Point</label>
					<div class="col-sm-2">
						<input name="point" type="number" class="form-control" id="point" value="" placeholder="0">
					</div>

				</div>
				<div class="form-group">
					<label for="k_resep" class="col-sm-3 control-label">Kestabilan Resep</label>
					<div class="col-sm-2">
						<select name="k_resep" class="form-control" id="k_resep" onChange="aktif5(); aktif6();" required <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="0x" <?php if($row_hasilcelup['k_resep'] == '0x') { echo "SELECTED"; } ?>>0x</option>
							<option value="1x" <?php if($row_hasilcelup['k_resep'] == '1x') { echo "SELECTED"; } ?>>1x</option>
							<option value="2x" <?php if($row_hasilcelup['k_resep'] == '2x') { echo "SELECTED"; } ?>>2x</option>
							<option value="3x" <?php if($row_hasilcelup['k_resep'] == '3x') { echo "SELECTED"; } ?>>3x</option>
							<option value="4x" <?php if($row_hasilcelup['k_resep'] == '4x') { echo "SELECTED"; } ?>>4x</option>
							<option value="5x" <?php if($row_hasilcelup['k_resep'] == '5x') { echo "SELECTED"; } ?>>5x</option>
							<option value="6x" <?php if($row_hasilcelup['k_resep'] == '6x') { echo "SELECTED"; } ?>>6x</option>
							<option value="7x" <?php if($row_hasilcelup['k_resep'] == '7x') { echo "SELECTED"; } ?>>7x</option>
							<option value="8x" <?php if($row_hasilcelup['k_resep'] == '8x') { echo "SELECTED"; } ?>>8x</option>
							<option value="9x" <?php if($row_hasilcelup['k_resep'] == '9x') { echo "SELECTED"; } ?>>9x</option>
							<option value="10x" <?php if($row_hasilcelup['k_resep'] == '10x') { echo "SELECTED"; } ?>>10x</option>
							<option value=">10x" <?php if($row_hasilcelup['k_resep'] == '>10x') { echo "SELECTED"; } ?>>>10x</option>
						</select>
					</div>
					<div class="col-sm-6">
						<select name="analisa_topping" class="form-control" id="analisa_topping" disabled="disabled" required>
							<option value="">Pilih</option>
							<option value="RESEP BARU">Resep Baru</option>
							<option value="LOADING RENDAH">Loading Rendah</option>
							<option value="RUBAH L:R / AIR">Rubah L:R / Air</option>
							<option value="KESTABILAN OPR">Kestabilan Opr</option>
							<option value="SALAH TOPPING SPEKTRO">Salah Topping Spektro</option>
							<option value="SALAH INSTRUKSI">Salah Instruksi</option>
							<option value="SALAH BUKA RESEP">Salah Buka Resep</option>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="acc_keluar" class="col-sm-3 control-label">Acc Keluar Kain </label>
					<div class="col-sm-3">
						<select name="acc_keluar" class="form-control" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['acc_keluar'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label for="tambah_obat" class="col-sm-3 control-label">Tambah Obat Terakhir </label>
					<div class="col-sm-3">
						<select name="tambah_obat" class="form-control" <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="operatorpolyester" class="col-sm-3 control-label">Operator Polyester </label>
					<div class="col-sm-4">
						<select name="operatorpolyester" class="form-control" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="-" > - </option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['operator_keluar'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="operatorcotton" class="col-sm-3 control-label">Operator Cotton </label>
					<div class="col-sm-4">
						<select name="operatorcotton" class="form-control" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
													<option value="-" > - </option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['operator_keluar'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="operator" class="col-sm-3 control-label">Operator Keluar Kain </label>
					<div class="col-sm-4">
						<select name="operator" class="form-control" required  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['operator_keluar'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label for="tambah_obat1" class="col-sm-2 control-label">Tambah Obat 1x </label>
					<div class="col-sm-3">
						<select name="tambah_obat1" id="tambah_obat1" class="form-control" disabled="disabled">
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat1'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group hidden">
					<label for="operator_potong" class="col-sm-3 control-label">Operator Potong Celup</label>
					<div class="col-sm-5">
						<select name="operator_potong" class="form-control">
							<option value="">Pilih</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH &amp; Suhu Tes Cuci Bulu</label>
					<div class="col-sm-2">
						<input name="ph_cb" type="text" class="form-control" id="ph_cb" value="<?= $row_hasilcelup['ph_cb']; ?>" placeholder="0" style="text-align: right;" <?php if ($rcek['dyestuff'] == "D+R") {
																																											} else if ($rcek['dyestuff'] == "R" or $rcek['dyestuff'] == "OBA") {
																																											} else {
																																												echo "readonly";
																																											} ?>>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input name="suhu_cb" type="text" class="form-control" id="suhu_cb" value="<?= $row_hasilcelup['suhu_cb']; ?>" placeholder="0" style="text-align: right;" <?php if ($rcek['dyestuff'] == "D+R") {
																																														} else if ($rcek['dyestuff'] == "R" or $rcek['dyestuff'] == "OBA") {
																																														} else {
																																															echo "readonly";
																																														} ?>>
							<span class="input-group-addon">&deg;</span>
						</div>
					</div>
					<label for="tambah_obat2" id="tambah_obat2" class="col-sm-2 control-label">Tambah Obat 2x </label>
					<div class="col-sm-3">
						<select name="tambah_obat2" class="form-control" disabled="disabled">
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat2'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH &amp; Suhu Tes Poly</label>
					<div class="col-sm-2">
						<input name="ph_poly" type="text" class="form-control" id="ph_poly" value="<?= $row_hasilcelup['ph_poly']; ?>" placeholder="0" style="text-align: right;" <?php if ($rcek['dyestuff'] == "D+R") {
																																													} else if ($rcek['dyestuff'] == "D") {
																																													} else {
																																														echo "readonly";
																																													} ?>>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input name="suhu_poly" type="text" class="form-control" id="suhu_poly" value="<?= $row_hasilcelup['suhu_poly']; ?>" placeholder="0" style="text-align: right" <?php if ($rcek['dyestuff'] == "D+R") {
																																															} else if ($rcek['dyestuff'] == "D") {
																																															} else {
																																																echo "readonly";
																																															} ?>>
							<span class="input-group-addon">&deg;</span>
						</div>
					</div>
					<label for="tambah_obat3" class="col-sm-2 control-label">Tambah Obat 3x </label>
					<div class="col-sm-3">
						<select name="tambah_obat3" id="tambah_obat3" class="form-control" disabled="disabled">
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat3'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH &amp; Suhu Tes Cotton</label>
					<div class="col-sm-2">
						<input name="ph_cott" type="text" class="form-control" id="ph_cott" value="<?= $row_hasilcelup['ph_cott']; ?>" placeholder="0" style="text-align: right;" <?php if ($rcek['dyestuff'] == "D+R") {
																																													} else if ($rcek['dyestuff'] == "R") {
																																													} else {
																																														echo "readonly";
																																													} ?>>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input name="suhu_cott" type="text" class="form-control" id="suhu_cott" value="<?= $row_hasilcelup['suhu_cott']; ?>" placeholder="0" style="text-align: right" <?php if ($rcek['dyestuff'] == "D+R") {
																																															} else if ($rcek['dyestuff'] == "R") {
																																															} else {
																																																echo "readonly";
																																															} ?>>
							<span class="input-group-addon">&deg;</span>
						</div>
					</div>
					<label for="tambah_obat4" class="col-sm-2 control-label">Tambah Obat 4x </label>
					<div class="col-sm-3">
						<select name="tambah_obat4" id="tambah_obat4" class="form-control" disabled="disabled">
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat4'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Berat Jenis</label>
					<div class="col-sm-2">
						<input name="berat_jns" type="text" class="form-control" id="berat_jns" value="<?= $row_hasilcelup['berat_jns']; ?>" placeholder="0" style="text-align: right;" <?php if ($rcek['dyestuff'] == "D+R") {
																																														} else if ($rcek['dyestuff'] == "R") {
																																														} else {
																																															echo "readonly";
																																														} ?>>
					</div>
					<label for="tambah_obat5" class="col-sm-4 control-label">Tambah Obat 5x </label>
					<div class="col-sm-3">
						<select name="tambah_obat5" id="tambah_obat5" class="form-control" disabled="disabled">
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat5'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH Na<sub>2</sub>CO<sub>3</sub></label>
					<div class="col-sm-2">
						<input name="ph_naco" type="text" class="form-control" id="ph_naco" value="<?= $row_hasilcelup['ph_naco']; ?>" placeholder="0" style="text-align: right;" <?php if ($rcek['dyestuff'] == "D+R") {
																																													} else if ($rcek['dyestuff'] == "R") {
																																													} else {
																																														echo "readonly";
																																													} ?>>
					</div>
					<label for="tambah_obat6" class="col-sm-4 control-label">Tambah Obat 6x </label>
					<div class="col-sm-3">
						<select name="tambah_obat6" id="tambah_obat6" class="form-control" disabled="disabled">
							<option value="">Pilih</option>
							<option value="0X">0X</option>
							<?php
							$sqlKap = mysqli_query($con, "SELECT nama FROM tbl_staff WHERE jabatan='SPV' or jabatan='Colorist' or jabatan='Asst. Manager' or jabatan='Manager' or jabatan='Senior Manager' or jabatan='DMF' ORDER BY nama ASC");
							while ($rK = mysqli_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>" <?php if($row_hasilcelup['tambah_obat6'] == $rK['nama']) { echo "SELECTED"; } ?>><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!--  
					<div class="form-group">
					<label for="air" class="col-sm-3 control-label">Air</label>
					<div class="col-sm-2">
								<input name="a_dingin" type="text" class="form-control" id="a_dingin" 
								value="" placeholder="Dingin" style="text-align: right;">
							</div>
					<div class="col-sm-2">
								<input name="a_panas" type="text" class="form-control" id="a_panas" 
								value="" placeholder="Panas" style="text-align: right;">
							</div>	
					</div>	
				-->
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Lama Proses</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="lama_proses" type="text" class="form-control" id="lama_proses" placeholder="HH:MM" value="<?php if(!empty($_GET['id'])){ 
																																		echo $row_hasilcelup['lama_proses'];
																																	}else{
																																		echo $rLama['lama'];
																																	} ?>" readonly="readonly">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<input name="air_awal" type="text" class="form-control" id="air_awal" value="<?php if(!empty($_GET['id'])){ 
																											echo $row_hasilcelup['air_awal'];
																											}else{
																											echo $rcekAir['air_awal'];
																											}?>" placeholder="Air Awal" style="text-align: right;" readonly>
					</div>
					<div class="col-sm-3">
						<input name="air_akhir" type="text" class="form-control" id="air_akhir" value="<?= $row_hasilcelup['air_akhir']; ?>" placeholder="Air Akhir" style="text-align: right;" pattern=".*\S.*" maxlength="12" required>
					</div>
				</div>
				<div class="form-group">
					<label for="lama_tunggu_mesin" class="col-sm-3 control-label">Machine Idle</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="lama_tunggu_mesin" type="text" class="form-control" id="lama_tunggu_mesin" placeholder="0.00" value="<?php if(!empty($_GET['id'])){ 
																																					echo $row_hasilcelup['waktu_tunggu'];
																																				}else{
																																					echo $rcekAir['waktu_tunggu'];
																																				} ?>" readonly="readonly">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
					<label for="tambah_obat" class="col-sm-3 control-label">Tambah Dyestuff</label>
					<div class="col-sm-3">
						<select name="tambah_dyestuff" class="form-control" required>
							<option value="" disabled selected>Pilih</option>
							<option value="0x" <?php if($row_hasilcelup['tambah_dyestuff'] == '0x') { echo "SELECTED"; } ?>>0x</option>
							<option value="1x" <?php if($row_hasilcelup['tambah_dyestuff'] == '1x') { echo "SELECTED"; } ?>>1x</option>
							<option value="2x" <?php if($row_hasilcelup['tambah_dyestuff'] == '2x') { echo "SELECTED"; } ?>>2x</option>
							<option value="3x" <?php if($row_hasilcelup['tambah_dyestuff'] == '3x') { echo "SELECTED"; } ?>>3x</option>
							<option value="4x" <?php if($row_hasilcelup['tambah_dyestuff'] == '4x') { echo "SELECTED"; } ?>>4x</option>
							<option value="5x" <?php if($row_hasilcelup['tambah_dyestuff'] == '5x') { echo "SELECTED"; } ?>>5x</option>
							<option value="6x" <?php if($row_hasilcelup['tambah_dyestuff'] == '6x') { echo "SELECTED"; } ?>>6x</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="gerobak" class="col-sm-3 control-label">Jumlah Gerobak</label>
					<div class="col-sm-2">
						<select name="gerobak" class="form-control" id="gerobak" onChange="aktif4();"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>>
							<option value="">Pilih</option>
							<option value="1" <?php if($row_hasilcelup['gerobak'] == '1'){ echo "SELECTED"; } ?>>1</option>
							<option value="2" <?php if($row_hasilcelup['gerobak'] == '2'){ echo "SELECTED"; } ?>>2</option>
							<option value="3" <?php if($row_hasilcelup['gerobak'] == '3'){ echo "SELECTED"; } ?>>3</option>
							<option value="4" <?php if($row_hasilcelup['gerobak'] == '4'){ echo "SELECTED"; } ?>>4</option>
							<option value="5" <?php if($row_hasilcelup['gerobak'] == '5'){ echo "SELECTED"; } ?>>5</option>
							<option value="6" <?php if($row_hasilcelup['gerobak'] == '6'){ echo "SELECTED"; } ?>>6</option>
							<option value="7" <?php if($row_hasilcelup['gerobak'] == '7'){ echo "SELECTED"; } ?>>7</option>
							<option value="8" <?php if($row_hasilcelup['gerobak'] == '8'){ echo "SELECTED"; } ?>>8</option>
							<option value="9" <?php if($row_hasilcelup['gerobak'] == '9'){ echo "SELECTED"; } ?>>9</option>
							<option value="10" <?php if($row_hasilcelup['gerobak'] == '10'){ echo "SELECTED"; } ?>>10</option>
						</select>
					</div>
					<div class="col-sm-3">
						<select name="jns_gerobak" class="form-control" id="jns_gerobak" disabled="disabled">
							<option value="">Pilih</option>
							<option value="Profil Tank" <?php if($row_hasilcelup['jns_gerobak'] == 'Profil Tank'){ echo "SELECTED"; } ?>>Profil Tank</option>
							<option value="Fiber" <?php if($row_hasilcelup['jns_gerobak'] == 'Fiber'){ echo "SELECTED"; } ?>>Fiber</option>
							<option value="Greige" <?php if($row_hasilcelup['jns_gerobak'] == 'Greige'){ echo "SELECTED"; } ?>>Greige</option>
						</select>
					</div>
					<label for="gerobak" class="col-sm-1 control-label">Leader</label>
					<div class="col-sm-3">
						<select name="leader" class="form-control" id="leader" >
							<option value="">Pilih</option>
							<?php
							$q_leader = mysqli_query($con, "SELECT * FROM tbl_leader ORDER BY id ASC");
							while ($row_leader = mysqli_fetch_array($q_leader)) {
							?>
								<option value="<?php echo $row_leader['leader']; ?>" <?php if($row_leader['leader'] == $row_hasilcelup['leader']) { echo "SELECTED"; } ?>><?php echo $row_leader['leader']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan Schedule</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $rcek['ket_status']; ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan</label>
					<div class="col-sm-8">
						<textarea name="ket" class="form-control" <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>><?php echo $ketsts; ?><?= $row_hasilcelup['ket']; ?></textarea>
					</div>
				</div>
				<label for="gerobak" class="col-sm-3 control-label">Penanggung Jawab Buyer</label>
					<div class="col-sm-2">
						<?php
							if($_SESSION['nama10'] == 'Rica'){
								$required = "";
							}else{
								$required = "required";
							}
						?>
						<select name="penanggungjawabbuyer" class="form-control" <?php echo $required; ?>>
							<option value="" disabled selected>Pilih</option>
							<option value="Mr. Jiang" <?php if($row_hasilcelup['penanggungjawabbuyer'] == 'Mr. Jiang'){ echo "SELECTED"; } ?>>Mr. Jiang</option>
							<option value="M. Subihadi" <?php if($row_hasilcelup['penanggungjawabbuyer'] == 'M. Subihadi'){ echo "SELECTED"; } ?>>M. Subihadi</option>
							<option value="Dwijo Maulana" <?php if($row_hasilcelup['penanggungjawabbuyer'] == 'Dwijo Maulana'){ echo "SELECTED"; } ?>>Dwijo Maulana</option>
						</select>
					</div>
				<?php if(!empty($_GET['id'])) : ?>
					<div class="form-group">
						<label for="ket" class="col-sm-3 control-label">Status Resep</label>
						<div class="col-sm-8">
							<select name="status_resep" style="font-size: 12px;" class="form-control">
								<option value="Belum Analisa" <?php if($row_hasilcelup['status_resep'] == 'Belum Analisa'){ echo "SELECTED"; } ?>>Belum Analisa</option>
								<option value="Follow" <?php if($row_hasilcelup['status_resep'] == 'Follow'){ echo "SELECTED"; } ?>>Follow</option>
								<option value="Test LAB" <?php if($row_hasilcelup['status_resep'] == 'Test LAB'){ echo "SELECTED"; } ?>>Test LAB</option>
								<option value="Oke" <?php if($row_hasilcelup['status_resep'] == 'Oke'){ echo "SELECTED"; } ?>>Oke</option>
								<option value="Tidak Oke" <?php if($row_hasilcelup['status_resep'] == 'Tidak Oke'){ echo "SELECTED"; } ?>>Tidak Oke </option>
								<option value="Review" <?php if($row_hasilcelup['status_resep'] == 'Review'){ echo "SELECTED"; } ?>>Review </option>
								<option value="Test Celup" <?php if($row_hasilcelup['status_resep'] == 'Test Celup'){ echo "SELECTED"; } ?>>Test Celup</option>
								<option value="Tidak Analisa" <?php if($row_hasilcelup['status_resep'] == 'Tidak Analisa'){ echo "SELECTED"; } ?>>Tidak Analisa</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="ket" class="col-sm-3 control-label">Keterangan Analisa Resep</label>
						<div class="col-sm-8">
							<textarea name="analisa_resep" class="form-control"><?php echo $ketsts; ?><?= $row_hasilcelup['analisa_resep']; ?></textarea>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<input type="hidden" value="<?php if (!empty($_GET['id'])) {
											echo $rcek['no_ko'];
										} else {
											echo $rKO['KONo'];
										} ?>" name="no_ko">
			<input type="hidden" value="<?php if ($cek > 0) {
											echo $rcek['no_mesin'];
										} ?>" name="no_mesin">


		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Hasil-Celup'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
			<?php if (!empty($_GET['id'])) {?>
				<button type="submit" class="btn btn-primary pull-right" name="update" value="update">Ubah <i class="fa fa-edit"></i></button>
				<!-- <button class="btn btn-primary pull-right" >Ubah <i class="fa fa-edit"></i></button> -->
			<?php } else { ?>
				<button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
			<?php } ?>
		</div>
	</div>
	<?php if (!empty($_GET['id'])) : ?>
		<div class="box box-info">
			<div class="box-body">
				<div class="col-md-12">
					<table id="example1" class="table table-bordered table-hover table-striped" width="100%">
						<thead class="bg-blue">
							<th>PRD. RSV. LINK GROUP CODE</th>
							<th>WHITENESS</th>
							<th>YELLOWNESS</th>
							<th>TINT</th>
							<th>LR</th>
							<th>SUFFIX</th>
							<th>DESCRIPTION</th>
						</thead>
						<tbody>
							<?php
							$q_qa 		= db2_exec($conn2, "SELECT DISTINCT 
																		p.GROUPLINE,
																		p.GROUPSTEPNUMBER,
																		p.PRODRESERVATIONLINKGROUPCODE,
																		w.WHITENESS,
																		y.YELLOWNESS,
																		t.TINT,
																		TRIM(p.SUBCODE01) || '-' ||TRIM(p.SUFFIXCODE) AS SUFFIX,
																		p.PICKUPQUANTITY AS LR,
																		r.SEARCHDESCRIPTION AS DESKRIPSI
																	FROM 
																		PRODUCTIONRESERVATION p 
																	LEFT JOIN 
																		(SELECT
																			a.VALUEINT,
																			v.PRODUCTIONORDERCODE,
																			v.CHARACTERISTICCODE,
																			v.VALUEQUANTITY AS WHITENESS
																		FROM
																			VIEWQUALITYDOCHEADERLINE v 
																		LEFT JOIN ADSTORAGE a ON a.UNIQUEID = v.ABSUNIQUEID ) w ON w.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND w.CHARACTERISTICCODE = 'WHITENESS' AND w.VALUEINT = p.GROUPSTEPNUMBER 
																	LEFT JOIN 
																		(SELECT
																			a.VALUEINT,
																			v.PRODUCTIONORDERCODE,
																			v.CHARACTERISTICCODE,
																			v.VALUEQUANTITY AS YELLOWNESS
																		FROM
																			VIEWQUALITYDOCHEADERLINE v 
																		LEFT JOIN ADSTORAGE a ON a.UNIQUEID = v.ABSUNIQUEID ) y ON y.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND y.CHARACTERISTICCODE = 'YELLOWNESS' AND y.VALUEINT = p.GROUPSTEPNUMBER 
																	LEFT JOIN 
																		(SELECT
																			a.VALUEINT,
																			v.PRODUCTIONORDERCODE,
																			v.CHARACTERISTICCODE,
																			v.VALUEQUANTITY AS TINT
																		FROM
																			VIEWQUALITYDOCHEADERLINE v 
																		LEFT JOIN ADSTORAGE a ON a.UNIQUEID = v.ABSUNIQUEID ) t ON t.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND t.CHARACTERISTICCODE = 'TINT' AND t.VALUEINT = p.GROUPSTEPNUMBER 
																	LEFT JOIN RECIPE r ON r.ITEMTYPECODE = p.ITEMTYPEAFICODE AND
																		r.SUBCODE01 = p.SUBCODE01 AND
																		r.SUFFIXCODE = p.SUFFIXCODE
																	WHERE 
																		(SUBSTR(p.SUBCODE01, 1, 2) = 'SC' OR 
																		SUBSTR(p.SUBCODE01, 1, 2) = 'TC' OR 
																		SUBSTR(p.SUBCODE01, 1, 2) = 'CB' OR 
																		SUBSTR(p.SUFFIXCODE, 1, 2) = 'SC' OR
																		SUBSTR(p.SUFFIXCODE, 1, 2) = 'TC')
																		AND p.PRODUCTIONORDERCODE = '$row_hasilcelup[nokk]'
																		AND NOT w.WHITENESS IS NULL
																		AND NOT y.YELLOWNESS IS NULL 
																		AND NOT t.TINT IS NULL
																	ORDER BY
																		p.GROUPLINE ASC");
							$col = 0;
							while ($row_qa   = db2_fetch_assoc($q_qa)) {
								$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
							?>
								<tr bgcolor="<?php echo $bgcolor; ?>">
									<td><?= $row_qa['PRODRESERVATIONLINKGROUPCODE']; ?></td>
									<td><?= number_format($row_qa['WHITENESS'], 2); ?></td>
									<td><?= number_format($row_qa['YELLOWNESS'], 2); ?></td>
									<td><?= number_format($row_qa['TINT'], 2); ?></td>
									<td><?= number_format($row_qa['LR'], 2); ?></td>
									<td><?= $row_qa['SUFFIX']; ?></td>
									<td><?= $row_qa['DESKRIPSI']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
</form>
<div class="modal fade modal-super-scaled" id="DataAnalisa">
	<div class="modal-dialog ">
		<div class="modal-content">
			<form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=simpan_analisa" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Data Analisa</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Input Analisa</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="nama" name="nama" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<table id="example2" class="table table-bordered table-hover table-striped" width="100%">
						<thead class="bg-green">
							<tr>
								<th width="144">
									<div align="center">Analisa</div>
								</th>
								<th width="144">
									<div align="center">Action</div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$c = 1;
							$sqlAn1 = mysqli_query($con, "SELECT * FROM tbl_analisa ORDER BY nama ASC");
							while ($rAn1 = mysqli_fetch_array($sqlAn1)) {
								$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
							?>
								<tr bgcolor="<?php echo $bgcolor; ?>">
									<td align="center">
										<?php echo $rAn1['nama']; ?>
									</td>
									<td align="center">
										<a href="#" class="btn btn-danger btn-xs" onClick="hapusAnalisa('<?php echo $rAn1['id']; ?>');" title="Hapus Analisa"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php
							} ?>
						</tbody>

					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-super-scaled" id="DataStatusProses">
	<div class="modal-dialog ">
		<div class="modal-content">
			<form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=simpan_status_proses" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Data Status Proses</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Input Status Proses</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="nama" name="nama" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<table id="example2" class="table table-bordered table-hover table-striped" width="100%">
						<thead class="bg-green">
							<tr>
								<th width="144">
									<div align="center">Status Proses</div>
								</th>
								<th width="144">
									<div align="center">Action</div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$c = 1;
							$sqlAn1 = mysqli_query($con, "SELECT * FROM tbl_status_proses ORDER BY nama ASC");
							while ($rAn1 = mysqli_fetch_array($sqlAn1)) {
								$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
							?>
								<tr bgcolor="<?php echo $bgcolor; ?>">
									<td align="center">
										<?php echo $rAn1['nama']; ?>
									</td>
									<td align="center">
										<a href="#" class="btn btn-danger btn-xs" onClick="hapusStatusProses('<?php echo $rAn1['id']; ?>');" title="Hapus Status Proses"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php
							} ?>
						</tbody>

					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function hapusAnalisa(id) {
		if (confirm('Yakin ingin menghapus data analisa ini?')) {
			$.ajax({
				url: 'pages/hapus-celup.php',
				type: 'POST',
				data: {
					id: id
				},
				success: function(res) {
					alert('Data analisa berhasil dihapus!');
					location.reload();
				},
				error: function(xhr) {
					alert('Gagal menghapus data analisa! ' + xhr.responseText);
				}
			});
		}
	}
	function hapusStatusProses(id) {
		if (confirm('Yakin ingin menghapus Data Status Proses ini?')) {
			$.ajax({
				url: 'pages/hapus-celup.php',
				type: 'POST',
				data: {
					id: id
				},
				success: function(res) {
					alert('Data analisa berhasil dihapus!');
					location.reload();
				},
				error: function(xhr) {
					alert('Gagal menghapus data analisa! ' + xhr.responseText);
				}
			});
		}
	}
</script>
<?php
if ($_POST['save'] == "save") {
	$ket = str_replace("'", "''", $_POST['ket']);
	$analisa =	str_replace("'", "''", $_POST['analisa']);
	$point = substr($_POST['point_proses'], (strpos($_POST['point_proses'], "#") + 1), 2);
	$propoint = substr($_POST['point_proses'], 0, (strpos($_POST['point_proses'], "#") - 1));
	$mulai = $_POST['mulaism'] . " " . $_POST['waktu_mulai'];
	$selesai = $_POST['selesaism'] . " " . $_POST['waktu_stop'];
	if ($_POST['kodesm'] != "") {
		$jam_stop = " mulai_stop='$mulai', selesai_stop='$selesai', ";
	} else {
		$jam_stop = " ";
	}
	$sqlData = mysqli_query($con, "INSERT INTO tbl_hasilcelup SET
								id_montemp='" . $_POST['id'] . "',
								nokk='" . $_POST['nokk'] . "',
								nodemand='" . $_POST['demand'] . "',
								shift='" . $_POST['shift'] . "',
								g_shift='" . $_POST['g_shift'] . "',
								lama_proses='" . $_POST['lama_proses'] . "',
								`status`='" . $_POST['sts'] . "',		
								ph_cb='" . $_POST['ph_cb'] . "',
								suhu_cb='" . $_POST['suhu_cb'] . "',
								ph_poly='" . $_POST['ph_poly'] . "',
								suhu_poly='" . $_POST['suhu_poly'] . "',
								ph_cott='" . $_POST['ph_cott'] . "',
								suhu_cott='" . $_POST['suhu_cott'] . "',
								berat_jns='" . $_POST['berat_jns'] . "',
								ph_naco='" . $_POST['ph_naco'] . "',
								a_panas='" . $_POST['a_panas'] . "',
								a_dingin='" . $_POST['a_dingin'] . "',
								`point`='$point', 
								proses_point='$propoint',
								proses='" . $_POST['proses'] . "',
								status_proses='" . $_POST['status_proses'] . "',
								k_resep='" . $_POST['k_resep'] . "',
								jml_topping='" . $_POST['jml_topping'] . "',
								analisa='" . $_POST['analisaCombined'] . "',
								rcode='" . $_POST['rcode1'] . "',
								operator_keluar='" . $_POST['operator'] . "',
								operator_potong='" . $_POST['operator_potong'] . "',
								operatorcotton='" . $_POST['operatorcotton'] . "',
								operatorpolyester='" . $_POST['operatorpolyester'] . "',
								acc_keluar='" . $_POST['acc_keluar'] . "',
								tambah_obat='" . $_POST['tambah_obat'] . "',
								tambah_obat1='" . $_POST['tambah_obat1'] . "',
								tambah_obat2='" . $_POST['tambah_obat2'] . "',
								tambah_obat3='" . $_POST['tambah_obat3'] . "',
								tambah_obat4='" . $_POST['tambah_obat4'] . "',
								tambah_obat5='" . $_POST['tambah_obat5'] . "',
								tambah_obat6='" . $_POST['tambah_obat6'] . "',
								kd_stop='" . $_POST['kodesm'] . "',
								$jam_stop 
								ket='$ket',
								air_akhir='" . $_POST['air_akhir'] . "',
								gerobak='" . $_POST['gerobak'] . "',
								jns_gerobak='" . $_POST['jns_gerobak'] . "',
								analisa_topping='" . $_POST['analisa_topping'] . "',
								no_resep='" . $_POST['no_resep'] . "',
								no_resep2='" . $_POST['no_resep2'] . "',
								resep='" . $_POST['resep'] . "',
								kategori_warna='" . $_POST['kategori_warna'] . "',
								tgl_buat=now(),
								tgl_update=now(),
								status_resep='Belum Analisa',
								tambah_dyestuff='" . $_POST['tambah_dyestuff'] . "',
								arah_warna='" . $_POST['arah_warna'] . "',
								status_warna='" . $_POST['status_warna'] . "',
								leader='" . $_POST['leader'] . "',
								point2='" . $_POST['point2'] . "',
								penanggungjawabbuyer='" . $_POST['penanggungjawabbuyer'] . "'") or die(mysqli_error($con));

	if ($sqlData) {
		/* awal form potong */
		$sqlCekP = mysqli_query($con, "SELECT a.*,c.k_resep,c.acc_keluar,c.operator_keluar,c.shift as shift_keluar,c.g_shift as g_shift_keluar,c.id as idcelup from tbl_schedule a
											INNER JOIN tbl_montemp b ON a.id=b.id_schedule
											INNER JOIN tbl_hasilcelup c ON b.id=c.id_montemp 
											WHERE a.nokk='" . $_POST['nokk'] . "' ORDER BY c.id DESC LIMIT 1");
		$rcekP = mysqli_fetch_array($sqlCekP);
		$dataSche = mysqli_query(
			$con,
			"SELECT
					no_resep,
					kapasitas,
					ket_status,
					jenis_kain,
					tgl_delivery,
					lot,
					no_rajut,
					g_shift,
					ket_kain,
					kk_kestabilan,
					kk_normal
				FROM
					tbl_schedule 
				WHERE
					nokk = '" . $_POST['nokk'] . "'
				ORDER BY
					id DESC 
					LIMIT 1"
		);
		$rSche = mysqli_fetch_array($dataSche);
		$sqlDataP = mysqli_query($con, "INSERT INTO tbl_potongcelup SET
			id_hasilcelup='" . $rcekP['idcelup'] . "',
			nokk='" . $_POST['nokk'] . "',
			shift='" . $_POST['shift'] . "',
			g_shift='" . $_POST['g_shift'] . "',
			operator='" . $_POST['operator_potong'] . "',
			tgl_buat=now(),
			tgl_update=now()");
		/* akhir form potong */
		$sqlMonT = mysqli_query($con, "SELECT * FROM tbl_montemp WHERE id='" . $_POST['id'] . "'");
		$rMonT = mysqli_fetch_array($sqlMonT);
		$sqlD = mysqli_query($con, "UPDATE tbl_schedule SET 
			`status`='selesai',
			tgl_update=now()
			WHERE no_mesin = '" . $rcek['no_mesin'] . "' and no_urut='1' and `status`='sedang jalan' ");
		$sqlDT = mysqli_query($con, "UPDATE tbl_montemp SET 
			`status`='selesai',
			tgl_update=now()
			WHERE id='" . $_POST['id'] . "'");
		$sqlUrut = mysqli_query($con, "UPDATE tbl_schedule 
			SET no_urut = no_urut - 1 
			WHERE no_mesin = '" . $rcek['no_mesin'] . "' 
			AND `status` = 'antri mesin' AND not no_urut='1' ");

		if ($sqlDataP) {
			$out_to = $_POST['out_to'] ?? '';
			if ($out_to == 'CB') {
				$warna = str_replace("'", "''", $_POST['warna']);
				$nowarna = str_replace("'", "''", $_POST['no_warna']);
				$jns = str_replace("'", "''", $_POST['jns_kain']);
				$po = str_replace("'", "''", $_POST['no_po']);
				$lot = trim($_POST['lot']);
				$no_urut = $rcek2['no_urut'];
				$kapasitas = $rSche['kapasitas'];
				$ket_status = $rSche['ket_status'];
				$jenis_kain = $rSche['jenis_kain'];
				$tgl_delivery = $rSche['tgl_delivery'];
				$no_rajut = $rSche['no_rajut'];
				$g_shift = $rSche['g_shift'];
				$ket_kain = $rSche['ket_kain'];
				$kk_kestabilan = $rSche['kk_kestabilan'];
				$kk_normal = $rSche['kk_normal'];
				if (!empty($_POST['qty4']) && !empty($_POST['kapasitas'])) {
					$loading1 = round($_POST['qty4'] / $_POST['kapasitas'], 4) * 100;
				} else {
					$loading1 = '0';
				}
				$sqlSchedule = mysqli_query(
					$con,
					"INSERT INTO tbl_schedule SET
						nokk='" . $_POST['nokk'] . "',
						nodemand='" . $_POST['demand'] . "',
						langganan='" . $_POST['langganan'] . "',
						buyer='" . $_POST['buyer'] . "',
						no_order='" . $_POST['no_order'] . "',
						po='$po',
						no_hanger='" . $_POST['no_hanger'] . "',
						no_item='" . $_POST['no_item'] . "',
						jenis_kain='$jenis_kain',
						tgl_delivery='$tgl_delivery',
						lebar='" . $_POST['lebar'] . "',
						gramasi='" . $_POST['grms'] . "',
						warna='$warna',
						no_warna='$nowarna',
						qty_order='" . $_POST['qty1'] . "',
						pjng_order='" . $_POST['qty2'] . "',
						satuan_order='" . $_POST['satuan1'] . "',
						lot='$lot',
						rol='" . $_POST['qty3'] . "',
						bruto='" . $_POST['qty4'] . "',
						no_rajut='$no_rajut',
						shift='" . $_POST['shift'] . "',
						g_shift='" . $_POST['g_shift'] . "'',
						kapasitas='" . $_POST['kapasitas'] . "'',
						no_mesin='CB11',
						no_urut='$no_urut',
						no_sch='$no_urut',
						loading='$loading1',
						resep='" . $_POST['resep'] . "',
						no_resep='" . $_POST['no_resep'] . "',
						no_resep2='" . $_POST['no_resep2'] . "',
						suffix='" . $_POST['suffix1'] . "',
						suffix2='" . $_POST['suffix2'] . "',
						energi='',
						dyestuff='" . $_POST['dyestuff'] . "',
						proses='Continuous - Bleaching',
						revisi='',
						kategori_warna='" . $_POST['kategori_warna'] . "',
						ket_status='$ket',
						ket_kain='$ket_kain',
						tgl_masuk=now(),
						personil='" . $_POST['operator'] . "',
						target='" . $_POST['target'] . "',
						kk_kestabilan='$kk_kestabilan',
						kk_normal='$kk_normal',
						tgl_update=now()"
				);
			}
		}

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
if ($_POST['update'] == "update") {
	$analisaresep		= addslashes($_POST['analisa_resep']);
	$sqlData = mysqli_query($con, "UPDATE tbl_hasilcelup SET 
											analisa_resep = '$analisaresep',
											status_resep = '$_POST[status_resep]'
											WHERE nokk='" . $_POST['nokk'] . "'");

	if ($sqlData) {
		echo "<script>swal({
				title: 'Data Telah DiUbah',   
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