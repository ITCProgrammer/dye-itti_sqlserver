<script>
	function roundToTwo(num) {
		return +(Math.round(num + "e+2") + "e-2");
	}

	function no_msn() {
		if (document.forms['form1']['kapasitas'].value == "2400") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option></option><option value='1401'>1401</option><option value='1406'>1406</option>";
		} else if (document.forms['form1']['kapasitas'].value == "1800") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1103'>1103</option><option value='1107'>1107</option><option value='1411'>1411</option>";
		} else if (document.forms['form1']['kapasitas'].value == "1200") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih<option value='1104'>1104</option><option value='1108'>1108</option><option value='1402'>1402</option><option value='1420'>1420</option><option value='1421'>1421</option><option value='2348'>2348</option>";
		} else if (document.forms['form1']['kapasitas'].value == "900") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1114'>1114</option>";
		} else if (document.forms['form1']['kapasitas'].value == "800") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='2229'>2229</option><option value='2246'>2246</option><option value='2247'>2247</option><option value='2625'>2625</option><option value='2627'>2627</option><option value='2634'>2634</option><option value='2636'>2636</option>";
		} else if (document.forms['form1']['kapasitas'].value == "750") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1505'>1505</option>";
		} else if (document.forms['form1']['kapasitas'].value == "600") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1115'>1115</option><option value='1116'>1116</option><option value='1117'>1117</option><option value='1410'>1410</option><option value='1451'>1451</option><option value='2632'>2632</option><option value='2633'>2633</option><option value='1474'>1474</option>";
		} else if (document.forms['form1']['kapasitas'].value == "400") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='2230'>2230</option><option value='2231'>2231</option>";
		} else if (document.forms['form1']['kapasitas'].value == "300") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1118'>1118</option><option value='1412'>1412</option><option value='1413'>1413</option><option value='1419'>1419</option><option value='1449'>1449</option>";
		} else if (document.forms['form1']['kapasitas'].value == "200") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='2228'>2228</option>";
		} else if (document.forms['form1']['kapasitas'].value == "150") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1409'>1409</option><option value='1450'>1450</option>";
		} else if (document.forms['form1']['kapasitas'].value == "100") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1452'>1452</option><option value='1453'>1453</option><option value='1458'>1458</option><option value='2622'>2622</option><option value='2623'>2623</option><option value='2665'>2665</option><option value='2666'>2666</option><option value='2667'>2667</option>";
		} else if (document.forms['form1']['kapasitas'].value == "50") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1482'>1482</option><option value='1481'>1481</option><option value='1477'>1477</option><option value='1476'>1476</option><option value='1454'>1454</option><option value='1455'>1455</option><option value='1456'>1456</option><option value='1457'>1457</option><option value='1459'>1459</option><option value='2624'>2624</option><option value='2635'>2635</option><option value='2660'>2660</option><option value='2661'>2661</option><option value='2662'>2662</option><option value='2663'>2663</option><option value='2664'>2664</option>";
		} else if (document.forms['form1']['kapasitas'].value == "30") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1478'>1478</option><option value='1475'>1475</option><option value='2626'>2626</option>";
		} else if (document.forms['form1']['kapasitas'].value == "20") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='2042'>2042</option><option value='2043'>2043</option><option value='2044'>2044</option><option value='2045'>2045</option><option value='2639'>2639</option><option value='2640'>2640</option><option value='2641'>2641</option>";
		} else if (document.forms['form1']['kapasitas'].value == "10") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='2638'>2638</option>";
		} else if (document.forms['form1']['kapasitas'].value == "5") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='1468'>1468</option></option><option value='1469'>1469</option><option value='1470'>1470</option></option><option value='1471'>1471</option><option value='1472'>1472</option></option><option value='1473'>1473</option>";
		} else if (document.forms['form1']['kapasitas'].value == "0") {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option><option value='WS11'>WS11</option><option value='CB11'>CB11</option>";
		} else {
			document.getElementById("no_mc").innerHTML = "<option value=''>Pilih</option>";
		}
	}

	function select_resep(){
		var cb = document.getElementById("no_mc").value;
        var _noprodorder = document.getElementById("nokk").value;
		if(cb == 'CB11'){
			$.get("api_CB.php?noprod="+_noprodorder,function(item){
				if(item.CB_BONRESEP1){
					document.getElementById("no_resep").value = item.CB_BONRESEP1;
					document.getElementById("suffix").value = item.CB_SUFFIX;
					document.getElementById("no_resep2").value = item.CB_BONRESEP2;
				}else{
					alert("CBL1 TIDAK TERSEDIA DI PRODUCTION RESERVATION. SILAHKAN PERIKSA KEMBALI ATAU TULIS MANUAL BON RESEP.");
				}
			});
		}
	}

	function cekpro() {
		var str = document.forms['form1']['proses'].value;
		var res = str.substr(0, 5);
		if (res == "Celup" || res == "celup") {
			document.forms['form1']['dyestuff'].removeAttribute("disabled");
			document.forms['form1']['dyestuff'].value = "";
			document.forms['form1']['energi'].removeAttribute("disabled");
			document.forms['form1']['energi'].value = "";
		} else {
			document.forms['form1']['dyestuff'].setAttribute("disabled", true);
			document.forms['form1']['dyestuff'].value = "";
			document.forms['form1']['energi'].setAttribute("disabled", true);
			document.forms['form1']['energi'].value = "";
		}
	}

	function cekpro1() {
		var str = document.forms['form1']['proses'].value;
		var res = str.substr(0, 15);
		if (res == "Celup Perbaikan" || res == "celup perbaikan") {
			document.forms['form1']['revisi'].removeAttribute("disabled");
			document.forms['form1']['revisi'].value = "0";
		} else {
			document.forms['form1']['revisi'].setAttribute("disabled", true);
			document.forms['form1']['revisi'].value = "0";
		}
	}

	function cekpro2() {
		var str = document.forms['form1']['proses'].value;
		var res = str.substr(0, 5);
		if (res == "Celup" || res == "celup") {
			document.forms['form1']['resep'].removeAttribute("disabled");
			document.forms['form1']['resep'].setAttribute("required", true);
			document.forms['form1']['resep'].value = "";
			document.forms['form1']['kategori_warna'].removeAttribute("disabled");
			// document.forms['form1']['kategori_warna'].value = "";
		} else {
			document.forms['form1']['resep'].setAttribute("disabled", true);
			document.forms['form1']['resep'].value = "";
			document.forms['form1']['kategori_warna'].setAttribute("disabled", true);
			document.forms['form1']['kategori_warna'].value = "";
		}
	}

	function aktif_staff() {
		if (document.forms['form1']['personil'].value == "bayu" || document.forms['form1']['personil'].value == "putri") {
			document.form1.acc_staff.removeAttribute("disabled");
			document.form1.acc_staff.setAttribute("required", true);
		} else {
			document.form1.acc_staff.setAttribute("disabled", true);
			document.form1.acc_staff.removeAttribute("required");
		}
	}

	function aktif() {
		if (document.forms['form1']['manual'].checked == true) {
			document.form1.nokk.setAttribute("readonly", true);
			document.form1.nokk.removeAttribute("required");
			document.form1.nokk.value = "";
			document.form1.datepicker2.setAttribute("readonly", true);
			document.form1.datepicker2.removeAttribute("required");
			document.form1.datepicker2.value = "";
			document.form1.langganan.setAttribute("readonly", true);
			document.form1.langganan.removeAttribute("required");
			document.form1.langganan.value = "";
			document.form1.buyer.setAttribute("readonly", true);
			document.form1.buyer.removeAttribute("required");
			document.form1.buyer.value = "";
			document.form1.no_order.setAttribute("readonly", true);
			document.form1.no_order.removeAttribute("required");
			document.form1.no_order.value = "";
			document.form1.no_po.setAttribute("readonly", true);
			document.form1.no_po.removeAttribute("required");
			document.form1.no_po.value = "";
			document.form1.no_hanger.setAttribute("readonly", true);
			document.form1.no_hanger.removeAttribute("required");
			document.form1.no_hanger.value = "";
			document.form1.no_item.setAttribute("readonly", true);
			document.form1.no_item.removeAttribute("required");
			document.form1.no_item.value = "";
			document.form1.jns_kain.setAttribute("readonly", true);
			document.form1.jns_kain.removeAttribute("required");
			document.form1.jns_kain.value = "";
			document.form1.lebar.setAttribute("readonly", true);
			document.form1.lebar.removeAttribute("required");
			document.form1.lebar.value = "";
			document.form1.grms.setAttribute("readonly", true);
			document.form1.grms.removeAttribute("required");
			document.form1.grms.value = "";
			document.form1.warna.setAttribute("readonly", true);
			document.form1.warna.removeAttribute("required");
			document.form1.warna.value = "";
			document.form1.no_warna.setAttribute("readonly", true);
			document.form1.no_warna.removeAttribute("required");
			document.form1.no_warna.value = "";
			document.form1.qty1.setAttribute("readonly", true);
			document.form1.qty1.removeAttribute("required");
			document.form1.qty1.value = "";
			document.form1.qty2.setAttribute("readonly", true);
			document.form1.qty2.removeAttribute("required");
			document.form1.qty2.value = "";
			document.form1.satuan1.setAttribute("disabled", true);
			document.form1.satuan1.removeAttribute("required");
			document.form1.satuan1.value = "";
			document.form1.lot.setAttribute("readonly", true);
			document.form1.lot.removeAttribute("required");
			document.form1.lot.value = "";
			document.form1.qty3.setAttribute("readonly", true);
			document.form1.qty3.removeAttribute("required");
			document.form1.qty3.value = "";
			document.form1.qty4.setAttribute("readonly", true);
			document.form1.qty4.removeAttribute("required");
			document.form1.qty4.value = "";
			document.form1.loading.setAttribute("readonly", true);
			document.form1.loading.removeAttribute("required");
			document.form1.loading.value = "";
			document.form1.no_rajut.setAttribute("readonly", true);
			document.form1.no_rajut.removeAttribute("required");
			document.form1.no_rajut.value = "";
			document.form1.kategori_warna.setAttribute("disabled", true);
			document.form1.kategori_warna.removeAttribute("required");
			// document.form1.kategori_warna.value = "";
			document.form1.no_resep.setAttribute("readonly", true);
			document.form1.no_resep.removeAttribute("required");
			document.form1.no_resep.value = "";
			document.form1.no_resep2.setAttribute("readonly", true);
			document.form1.no_resep2.removeAttribute("required");
			document.form1.no_resep2.value = "";
			document.form1.resep.setAttribute("disabled", true);
			document.form1.resep.removeAttribute("required");
			document.form1.resep.value = "";
		} else {
			document.form1.nokk.removeAttribute("readonly");
			document.form1.nokk.setAttribute("required", true);
			document.form1.datepicker2.removeAttribute("readonly");
			document.form1.datepicker2.setAttribute("required", true);
			document.form1.langganan.removeAttribute("readonly");
			document.form1.langganan.setAttribute("required", false);
			document.form1.buyer.removeAttribute("readonly");
			document.form1.buyer.setAttribute("required", false);
			document.form1.no_order.removeAttribute("readonly");
			document.form1.no_order.setAttribute("required", false);
			document.form1.no_po.removeAttribute("readonly");
			document.form1.no_po.setAttribute("required", false);
			document.form1.no_hanger.removeAttribute("readonly");
			document.form1.no_hanger.setAttribute("required", false);
			document.form1.no_item.removeAttribute("readonly");
			document.form1.no_item.setAttribute("required", false);
			document.form1.jns_kain.removeAttribute("readonly");
			document.form1.jns_kain.setAttribute("required", false);
			document.form1.lebar.removeAttribute("readonly");
			document.form1.lebar.setAttribute("required", true);
			document.form1.grms.removeAttribute("readonly");
			document.form1.grms.setAttribute("required", true);
			document.form1.warna.removeAttribute("readonly");
			document.form1.warna.setAttribute("required", false);
			document.form1.no_warna.removeAttribute("readonly");
			document.form1.no_warna.setAttribute("required", false);
			document.form1.qty1.removeAttribute("readonly");
			document.form1.qty1.setAttribute("required", true);
			document.form1.qty2.removeAttribute("readonly");
			document.form1.qty2.setAttribute("required", true);
			document.form1.satuan1.removeAttribute("disabled");
			document.form1.satuan1.setAttribute("required", true);
			document.form1.lot.removeAttribute("readonly");
			document.form1.lot.setAttribute("required", true);
			document.form1.qty3.removeAttribute("readonly");
			document.form1.qty3.setAttribute("required", true);
			document.form1.qty4.removeAttribute("readonly");
			document.form1.qty4.setAttribute("required", true);
			document.form1.loading.removeAttribute("readonly");
			document.form1.loading.setAttribute("required", true);
			document.form1.no_rajut.removeAttribute("readonly");
			document.form1.no_rajut.setAttribute("required", false);
			document.form1.kategori_warna.removeAttribute("disable");
			document.form1.kategori_warna.setAttribute("required", false);
			document.form1.no_resep.removeAttribute("readonly");
			document.form1.no_resep.setAttribute("required", false);
			document.form1.no_resep2.removeAttribute("readonly");
			document.form1.no_resep2.setAttribute("required", false);
			document.form1.resep.removeAttribute("disabled");
			document.form1.resep.setAttribute("required", false);
		}
	}

	function rd() {
		if (document.forms['form1']['dyestuff'].value == "D" || document.forms['form1']['dyestuff'].value == "D+R") {
			document.forms['form1']['energi'].removeAttribute("disabled");
			document.forms['form1']['energi'].value = "";
		} else {
			document.forms['form1']['energi'].setAttribute("disabled", true);
			document.forms['form1']['energi'].value = "";
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

	function ketstatus() {
		if (document.forms['form1']['manual'].checked == true) {
			document.getElementById("ket").innerHTML = "<option value=''>Pilih</option><option value='Cuci Mesin'>Cuci Mesin</option> <option value='MC Rusak'>MC Rusak</option><option value='MC Stop'>MC Stop</option><option value='MC Dibongkar'>MC Dibongkar</option><option value='STOP'>STOP</option>";
			document.getElementById("ket_kain").innerHTML = "<option value=''>Pilih</option><option value='Ex Cuci Mesin'>Ex Cuci Mesin</option><option value='Ex Scouring'>Ex Scouring</option><option value='Ex Warna Muda'>Ex Warna Muda</option><option value='Ex Warna Tua'>Ex Warna Tua</option><option value='Ex White'>Ex White</option><option value='MESIN DIBONGKAR'>MESIN DIBONGKAR</option>";
		} else {
			document.getElementById("ket").innerHTML = "<option value=''>Pilih</option><option value='Cuci YD'>Cuci YD</option><option value='Cuci Misty'>Cuci Misty</option><option value= 'Development Sample' >Development Sample</option><option value= 'First Lot' >First Lot</option><option value= 'Gagal Proses' >Gagal Proses</option><option value= 'Greige' >Greige</option><option value= 'Greige Delay' >Greige Delay</option><option value= 'Mini Bulk' >Mini Bulk</option><option value= 'Perbaikan' >Perbaikan</option><option value= 'Salesmen Sample' >Salesmen Sample</option><option value= 'Relaxing-Preset' >Relaxing-Preset</option><option value= 'Scouring-Preset' >Scouring-Preset</option><option value= 'Continuous' >Continuous</option><option value='Tolak Basah'>Tolak Basah</option>";
			//<option value= 'Test Mesin' >Test Mesin</option><option value= 'Test Obat' >Test Obat</option><option value= 'Test Proses' >Test Proses</option>
			document.getElementById("ket_kain").innerHTML = "<option value=''>Pilih</option><option value='Sudah Buka Kain'>Sudah Buka Kain</option><option value='Belum Buka Kain'>Belum Buka Kain</option><option value='Kain Basah'>Kain Basah</option><option value='Kain Kering'>Kain Kering</option><option value='Sudah Dokumen'>Sudah Dokumen</option><option value='Sudah Jahit Pinggir'>Sudah Jahit Pinggir</option><option value='Kain Sudah Preset'>Kain Sudah Preset</option><option value='Celup Poly Dulu (T-Side)'>Celup Poly Dulu (T-Side)</option><option value='Urgent'>Urgent</option><option value='Test Kestabilan'>Test Kestabilan</option>";
		}
	}

	function angka(e) {
		if (!/^[0-9 .]+$/.test(e.value)) {
			e.value = e.value.substring(0, e.value.length - 1);
		}
	}

	function aktif2() {
		if (document.forms['form1']['kk_kestabilan'].checked == true) {
			document.form1.kk_normal.setAttribute("disabled", true);
		} else {
			document.form1.kk_normal.removeAttribute("disabled");
		}
	}

	function aktif3() {
		if (document.forms['form1']['kk_normal'].checked == true) {
			document.form1.kk_kestabilan.setAttribute("disabled", true);
		} else {
			document.form1.kk_kestabilan.removeAttribute("disabled");
		}
	}
</script>
<?php
	if($_GET['nokk']){
		ini_set("error_reporting", 1);
		session_start();
		include "koneksi.php";
		function nourut(){
			include "koneksi.php";
			global $con;
			$format = date("ymd");
			$sql = "SELECT TOP 1 nokk
					FROM db_dying.tbl_schedule
					WHERE SUBSTRING(nokk, 1, 6) LIKE ?
					ORDER BY nokk DESC";
			$params = array('%' . $format . '%');
			$stmt = sqlsrv_query($con, $sql, $params);
			if ($stmt && ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
				$d   = $r['nokk'];
				$str = substr($d, 6, 2);
				$Urut = (int)$str;
			} else {
				$Urut = 0;
			}
			$Urut = $Urut + 1;
			$Nol = "";
			$nilai = 2 - strlen($Urut);
			for ($i = 1; $i <= $nilai; $i++) {
				$Nol = $Nol . "0";
			}
			$nipbr = $format . $Nol . $Urut;
			return $nipbr;
		}
		// echo $nou;
		$nou = nourut();
		$nokk = $_GET['nokk'];
		
		$child = $r['ChildLevel'];
		if ($nokk != "") {
			
		}
		$sqlCek1 = "SELECT COUNT(*) AS jml FROM db_dying.tbl_schedule WHERE nokk = ? AND (status = 'antri mesin' OR status = 'sedang jalan')";
		$paramsCek1 = array($nokk);
		$stmtCek1 = sqlsrv_query($con, $sqlCek1, $paramsCek1);
		$rowCek1 = sqlsrv_fetch_array($stmtCek1, SQLSRV_FETCH_ASSOC);
		$cek1 = $rowCek1 ? (int)$rowCek1['jml'] : 0;

		// NOW
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
											PRODUCTIONORDERCODE = '$nokk'
										ORDER BY
											DELIVERYDATE ASC");
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

			// $sql_bonresep1	= db2_exec($conn2, "SELECT
			// 										TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
			// 										TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
			// 										TRIM(SUFFIXCODE) AS SUFFIXCODE
			// 									FROM
			// 										PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
			// 									WHERE
			// 										PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$nokk' 
			// 										AND NOT SUFFIXCODE = '001'
			// 									ORDER BY
			// 										PRODUCTIONRESERVATION.GROUPLINE ASC LIMIT 1");
			// $dt_bonresep1	= db2_fetch_assoc($sql_bonresep1);

			// $sql_bonresep2	= db2_exec($conn2, "SELECT
			// 										TRIM( PRODUCTIONRESERVATION.PRODUCTIONORDERCODE ) AS PRODUCTIONORDERCODE,
			// 										TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP2,
			// 										TRIM(SUFFIXCODE) AS SUFFIXCODE
			// 									FROM
			// 										PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
			// 									WHERE
			// 										PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$nokk' 
			// 										AND NOT SUFFIXCODE = '001'
			// 									ORDER BY
			// 										PRODUCTIONRESERVATION.GROUPLINE DESC LIMIT 1");
			// $dt_bonresep2	= db2_fetch_assoc($sql_bonresep2);
		// NOW
	}
?>
<?php
	$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
	$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
	$Item		= isset($_POST['item']) ? $_POST['item'] : '';
	$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
	$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
?>
<script type="text/javascript">
	function bonresep1(){
		var no_resep		= document.getElementById("no_resep").value;
		var prod_order		= no_resep.substring(0, 8);
		var group_number	= no_resep.substring(9);
		// alert("no_resep");

		$.get("api_schedule.php?prod_order="+prod_order+"&group_number="+group_number,function(data){
			document.getElementById("suffix").value = data.SUFFIX_CODE;
		});
	}

	function bonresep2(){
		var no_resep2		= document.getElementById("no_resep2").value;
		var prod_order2		= no_resep2.substring(0, 8);
		var group_number2	= no_resep2.substring(9);
		// alert("no_resep");

		$.get("api_schedule.php?prod_order="+prod_order2+"&group_number="+group_number2,function(data2){
			document.getElementById("suffix2").value = data2.SUFFIX_CODE;
		});
	}
		
</script>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Input Data Kartu Kerja</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nokk" class="col-sm-3 control-label">Production Order</label>
					<div class="col-sm-4">
						<input name="nokk" type="text" class="form-control" id="nokk" onchange="window.location='?p=Form-Schedule&nokk='+this.value" value="<?php echo $_GET['nokk']; ?>" placeholder="Production Order" required>
					</div>
					<div class="col-sm-2">
						<input type="checkbox" name="manual" id="manual" onClick="aktif();ketstatus();"> Manual
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Production Demand</label>
					<div class="col-sm-8">
						<input name="demand" type="text" class="form-control" id="demand" value="<?= $dt_demand['DEMAND']; ?><?php if ($cek > 0) {
																											echo $rcek['nodemand'];
																										} ?>" placeholder="Production Demand">
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Langganan</label>
					<div class="col-sm-8">
						<input name="langganan" type="text" class="form-control" id="langganan" value="<?= $dt_pelanggan_buyer['PELANGGAN']; ?><?php if ($cek > 0) {
																											echo $rcek['langganan'];
																										} else {
																											echo $pelanggan;
																										} ?>" placeholder="Langganan">
					</div>
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-8">
						<input name="buyer" type="text" class="form-control" id="buyer" value="<?= $dt_pelanggan_buyer['BUYER']; ?><?php if ($cek > 0) {
																									echo $rcek['buyer'];
																								} else {
																									echo $buyer;
																								} ?>" placeholder="Buyer">
					</div>
				</div>
				<div class="form-group">
					<label for="no_order" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="no_order" type="text" class="form-control" id="no_order" value="<?= $dt_ITXVIEWKK['PROJECTCODE']; ?><?php if ($cek > 0) {
																											echo $rcek['no_order'];
																										} else {
																											if ($r['NoOrder'] != "") {
																												echo $r['NoOrder'];
																											} else if ($nokk != "") {
																												echo $cekM['no_order'];
																											}
																										} ?>" placeholder="No Order">
					</div>
				</div>
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">PO</label>
					<div class="col-sm-5">
						<input name="no_po" type="text" class="form-control" id="no_po" value="<?= $dt_po['NO_PO']; ?><?php if ($cek > 0) {
																									echo $rcek['po'];
																								} else {
																									if ($r['PONumber'] != "") {
																										echo $r['PONumber'];
																									} else if ($nokk != "") {
																										echo $cekM['no_po'];
																									}
																								} ?>" placeholder="PO">
					</div>
				</div>
				<div class="form-group">
					<label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
					<div class="col-sm-3">
						<input name="no_hanger" type="text" class="form-control" id="no_hanger" value="<?= $dt_ITXVIEWKK['NO_HANGER'] ?><?php if ($cek > 0) {
																											echo $rcek['no_hanger'];
																										} else {
																											if ($r['HangerNo']) {
																												echo $r['HangerNo'];
																											} else if ($nokk != "") {
																												echo $cekM['no_item'];
																											}
																										} ?>" placeholder="No Hanger">
					</div>
					<div class="col-sm-3">
						<input name="no_item" type="text" class="form-control" id="no_item" value="<?= $dt_item['EXTERNALITEMCODE'] ?><?php if ($rcek['no_item'] != "") {
																										echo $rcek['no_item'];
																									} else if ($r['ProductCode'] != "") {
																										echo $r['ProductCode'];
																									} else {
																										if ($r['HangerNo']) {
																											echo $r['HangerNo'];
																										} else if ($nokk != "") {
																											echo $cekM['no_item'];
																										}
																									} ?>" placeholder="No Item">
					</div>
				</div>
				<div class="form-group">
					<label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
					<div class="col-sm-8">
						<textarea name="jns_kain" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?= $dt_ITXVIEWKK['ITEMDESCRIPTION'] ?><?php if ($cek > 0) {
																													echo $rcek['jenis_kain'];
																												} else {
																													if ($r['ProductDesc'] != "") {
																														echo $r['ProductDesc'];
																													} else if ($nokk != "") {
																														echo $cekM['jenis_kain'];
																													}
																												} ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="tgl_delivery" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?= $rcek['tgl_delivery']; ?><?= $dt_ITXVIEWKK['DELIVERYDATE']; ?>" required />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
					<div class="col-sm-2">
						<input name="lebar" type="text" class="form-control" id="lebar" value="<?= $dt_lg['LEBAR']; ?><?php if ($cek > 0) {
																									echo $rcek['lebar'];
																								} else {
																									echo round($r['Lebar']);
																								} ?>" placeholder="0" required>
					</div>
					<div class="col-sm-2">
						<input name="grms" type="text" class="form-control" id="grms" value="<?= $dt_lg['GRAMASI']; ?><?php if ($cek > 0) {
																									echo $rcek['gramasi'];
																								} else {
																									echo round($r['Gramasi']);
																								} ?>" placeholder="0" required>
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-8">
						<input name="warna" type="text" class="form-control" id="warna" value="<?= $dt_warna['WARNA']; ?><?php if ($cek > 0) {
																									echo $rcek['warna'];
																								} else {
																									if ($r['Color'] != "") {
																										echo $r['Color'];
																									} else if ($nokk != "") {
																										echo $cekM['warna'];
																									}
																								} ?>" placeholder="Warna">
					</div>
				</div>
				<div class="form-group">
					<label for="no_warna" class="col-sm-3 control-label">No Warna</label>
					<div class="col-sm-8">
						<input name="no_warna" type="text" class="form-control" id="no_warna" value="<?= $dt_ITXVIEWKK['NO_WARNA']; ?><?php if ($cek > 0) {
																											echo $rcek['no_warna'];
																										} else {
																											if ($r['ColorNo'] != "") {
																												echo $r['ColorNo'];
																											} else if ($nokk != "") {
																												echo $cekM['no_warna'];
																											}
																										} ?>" placeholder="No Warna">
					</div>
				</div>
				<div class="form-group">
					<label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty1" type="text" class="form-control" id="qty1" value="<?= $dt_qtyorder['QTY_ORDER']; ?><?php if ($cek > 0) {
																										echo $rcek['qty_order'];
																									} else {
																										echo round($r['BatchQuantity'], 2);
																									} ?>" placeholder="0.00" required>
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group">
							<input name="qty2" type="text" class="form-control" id="qty2" value="<?= $dt_qtyorder['QTY_ORDER_YARD']; ?><?php if ($cek > 0) {
																										echo $rcek['pjng_order'];
																									} else {
																										echo round($r['Quantity'], 2);
																									} ?>" placeholder="0.00" style="text-align: right;" required>
							<span class="input-group-addon">
								<select name="satuan1" style="font-size: 12px;" id="satuan1">
									<option value="">Pilih</option>
									<option value="Yard" <?php if ($r['UnitID'] OR $dt_qtyorder['SATUAN_QTY'] == "21") {
																echo "SELECTED";
															} ?>>Yard</option>
									<option value="Meter" <?php if ($r['UnitID'] OR $dt_qtyorder['SATUAN_QTY'] == "10") {
																echo "SELECTED";
															} ?>>Meter</option>
									<option value="PCS" <?php if ($r['UnitID'] OR $dt_qtyorder['SATUAN_QTY'] == "1") {
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
						<input name="lot" type="text" class="form-control" id="lot" value="<?= $dt_ITXVIEWKK['LOT']; ?>" placeholder="Lot">
					</div>
				</div> 
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Roll &amp; Qty</label>
					<div class="col-sm-2">
						<?php
							if(!empty($dt_roll['ROLL'])){
								$roll = $dt_roll['ROLL'];
							}else{
								if ($cek > 0) {
									$roll	= $rcek['rol'];
								} else {
									if ($r['RollCount'] != "") {
										$roll = round($r['RollCount']);
									} else if ($nokk != "") {
										$roll = $cekM['jml_roll'];
									}
								}
							}
						?>
						<input name="qty3" type="text" class="form-control" id="qty3" value="<?= $roll;  ?>" placeholder="0.00" required>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty4" type="text" class="form-control" id="qty4" value="<?= $dt_qtyorder['QTY_ORDER']; ?><?php if ($cek > 0) {
																										echo $rcek['bruto'];
																									} else {
																										if ($r['Weight'] != "") {
																											echo round($r['Weight'], 2);
																										} else if ($nokk != "") {
																											echo $cekM['bruto'];
																										}
																									} ?>" placeholder="0.00" style="text-align: right;" required>
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-3">
						<input type="checkbox" name="kk_kestabilan" id="kk_kestabilan" value="1" onClick="aktif2();" <?php if ($rcek['kk_kestabilan'] == "1") {
																															echo "checked";
																														} ?> required>
						<label> KK Kestabilan</label>
					</div>
					<div class="col-sm-3">
						<input type="checkbox" name="kk_normal" id="kk_normal" onClick="aktif3();" value="1" <?php if ($rcek['kk_normal'] == "1") {
																													echo "checked";
																												} ?> required>
						<label> KK Normal</label>
					</div>
				</div>
			</div>
			<!-- col -->
			<div class="col-md-6">
				<div class="form-group">
					<label for="kapasitas" class="col-sm-3 control-label">Kapasitas Mesin</label>
					<?php
						$kapasitasGet = (isset($_GET['kap']) && $_GET['kap'] !== '') ? $_GET['kap'] : '0';
					?>
					<?php // if($_SERVER['REMOTE_ADDR'] == '10.0.5.132') : ?>
						<div class="col-sm-3">
							<select name="kapasitas" onchange="window.location='?p=Form-Schedule&nokk='+document.getElementById('nokk').value+'&kap='+this.value" class="form-control">
								<option value="">Pilih</option>
								<option value="0" <?php if ($kapasitasGet == "0") {
															echo "SELECTED";
														} ?>>0 KGs</option>
								<?php
								$sqlKap = sqlsrv_query($con, "SELECT DISTINCT kapasitas FROM db_dying.tbl_mesin ORDER BY kapasitas DESC");
								while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
									if ((string)$rK['kapasitas'] === "0") {
										continue;
									}
								?>
									<option value="<?php echo $rK['kapasitas']; ?>" <?php if ($kapasitasGet == $rK['kapasitas']) {
																						echo "SELECTED";
																					} ?>><?php echo $rK['kapasitas']; ?> KGs</option>
								<?php } ?>
							</select>
						</div>
					<?php // endif; ?>
				</div>
				<div class="form-group">
					<label for="no_mc" class="col-sm-3 control-label">No MC</label>
					<?php // if($_SERVER['REMOTE_ADDR'] == '10.0.5.132') : ?>
						<div class="col-sm-2">
							<select name="no_mc" class="form-control" required>
								<option value="">Pilih</option>
								<?php
									$sqlKap = sqlsrv_query($con, "SELECT no_mesin FROM db_dying.tbl_mesin WHERE kapasitas = ? ORDER BY no_mesin ASC", array($kapasitasGet));
									while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
									?>
									<option value="<?php echo $rK['no_mesin']; ?>"><?php echo $rK['no_mesin']; ?></option>
								<?php } ?>	 
							</select>
						</div>
					<?php // endif; ?>
				</div>
				<div class="form-group">
					<label for="no_urut" class="col-sm-3 control-label">No Urut</label>
					<div class="col-sm-2">
						<select name="no_urut" class="form-control" id="no_urut" required>
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT no_urut FROM db_dying.tbl_urut ORDER BY no_urut ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
							?>
								<option value="<?php echo $rK['no_urut']; ?>"><?php echo $rK['no_urut']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="loading" class="col-sm-3 control-label">Loading</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="loading" type="text" style="text-align: right;" class="form-control" id="loading" value="" placeholder="0.00">
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="no_rajut" class="col-sm-3 control-label">No Mesin Rajut</label>
					<div class="col-sm-3">
						<input name="no_rajut" type="text" class="form-control" id="no_rajut" value="<?= $dt_mesinknt['VALUESTRING']; ?>" placeholder="No Mesin Rajut">
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
					<label for="proses" class="col-sm-3 control-label">Proses</label>
					<div class="col-sm-5">
						<select name="proses" class="form-control" id="proses" onChange="cekpro(); cekpro1(); cekpro2(); aktif_staff();" required>
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT proses FROM db_dying.tbl_proses ORDER BY proses ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
							?>
								<option value="<?php echo $rK['proses']; ?>"><?php echo $rK['proses']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<select name="revisi" id="revisi" class="form-control" disabled>
							<option value="0" <?php if ($rcek['revisi'] == "") {
													echo "SELECTED";
												} ?>>Revisi Ke 0</option>
							<option value="1" <?php if ($rcek['revisi'] == "0") {
													echo "SELECTED";
												} ?>>Revisi Ke 1</option>
							<option value="2" <?php if ($rcek['revisi'] == "1") {
													echo "SELECTED";
												} ?>>Revisi Ke 2</option>
							<option value="3" <?php if ($rcek['revisi'] == "2") {
													echo "SELECTED";
												} ?>>Revisi Ke 3</option>
							<option value="4" <?php if ($rcek['revisi'] == "3") {
													echo "SELECTED";
												} ?>>Revisi Ke 4</option>
							<option value="5" <?php if ($rcek['revisi'] == "4") {
													echo "SELECTED";
												} ?>>Revisi Ke 5</option>
							<option value="6" <?php if ($rcek['revisi'] == "5") {
													echo "SELECTED";
												} ?>>Revisi Ke 6</option>
							<option value="7" <?php if ($rcek['revisi'] == "6") {
													echo "SELECTED";
												} ?>>Revisi Ke 7</option>
							<option value="8" <?php if ($rcek['revisi'] == "7") {
													echo "SELECTED";
												} ?>>Revisi Ke 8</option>
							<option value="9" <?php if ($rcek['revisi'] == "8") {
													echo "SELECTED";
												} ?>>Revisi Ke 9</option>

						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="no_resep" class="col-sm-3 control-label">No Bon Resep 1</label>
					<div class="col-sm-3">
						<!-- <input name="no_resep" type="text" class="form-control" id="no_resep" value="<?= $rcek['no_resep']; ?><?= $dt_bonresep1['BONRESEP1']; ?>" placeholder="No Bon Resep 1"> -->
						<select name="no_resep" class="form-control select2" id="no_resep" onchange="bonresep1()">
							<option disabled selected>Pilih Bon Resep</option>
							<?php
								$q_bonresep				= db2_exec($conn2, "SELECT
																				TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
																				TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
																				TRIM(SUFFIXCODE) AS SUFFIXCODE
																			FROM
																				PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
																			WHERE
																				(PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' OR PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF')
																				AND	PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$nokk'
																			ORDER BY
																				PRODUCTIONRESERVATION.GROUPLINE ASC");
								while ($row_bonresep 	= db2_fetch_assoc($q_bonresep)) {
							?>
								<option value="<?= $row_bonresep['BONRESEP1'] ?>"><?= $row_bonresep['BONRESEP1'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<!-- <input name="suffix" type="text" class="form-control" id="suffix" value="<?= $rcek['suffix']; ?><?= $dt_bonresep1['SUFFIXCODE']; ?>" placeholder="Suffix 1"> -->
						<input name="suffix" type="text" class="form-control" id="suffix" value="" placeholder="Suffix 1">
					</div>
				</div>
				<div class="form-group">
					<label for="no_resep2" class="col-sm-3 control-label">No Bon Resep 2</label>
					<div class="col-sm-3">
						<!-- <input name="no_resep2" type="text" class="form-control" id="no_resep2" value="<?= $rcek['no_resep2']; ?><?= $dt_bonresep2['BONRESEP2']; ?>" placeholder="No Bon Resep 2"> -->
						<select name="no_resep2" class="form-control select2" id="no_resep2" onchange="bonresep2()">
							<option disabled selected>Pilih Bon Resep</option>
							<?php
								$q_bonresep2				= db2_exec($conn2, "SELECT
																				TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
																				TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) || '-' || TRIM(PRODUCTIONRESERVATION.GROUPLINE) AS BONRESEP1,
																				TRIM(SUFFIXCODE) AS SUFFIXCODE
																			FROM
																				PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
																			WHERE
																				(PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' OR PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFF')
																				AND	PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$nokk'
																			ORDER BY
																				PRODUCTIONRESERVATION.GROUPLINE ASC");
								while ($row_bonresep2 	= db2_fetch_assoc($q_bonresep2)) {
							?>
								<option value="<?= $row_bonresep2['BONRESEP1'] ?>"><?= $row_bonresep2['BONRESEP1'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<input name="suffix2" type="text" class="form-control" id="suffix2" value="" placeholder="Suffix 2">
					</div>
				</div>
				<div class="form-group">
					<label for="resep" class="col-sm-3 control-label">Resep</label>
					<div class="col-sm-3">
						<select name="resep" disabled="disabled" required class="form-control" id="resep">
							<option value="-">Pilih</option>
							<option value="Baru">Baru</option>
							<option value="Lama">Lama</option>
							<option value="Setting">Setting</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="kategori_warna" class="col-sm-3 control-label">Kategori Warna</label>
					<div class="col-sm-3">
						<select name="kategori_warna" class="form-control" id="kategori_warna">
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

				</div>
				<div class="form-group">
					<label for="dyestuff" class="col-sm-3 control-label">Dyestuff</label>
					<div class="col-sm-2">
						<select name="dyestuff" id="dyestuff" class="form-control" onChange="rd();" disabled>
							<option value="">Pilih</option>
							<option value="D">D</option>
							<option value="R">R</option>
							<option value="D+R">D+R</option>
							<option value="OBA">OBA</option>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="energi" class="col-sm-3 control-label">Energy</label>
					<div class="col-sm-3">
						<select name="energi" class="form-control" disabled>
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT kode FROM db_dying.tbl_energi ORDER BY kode ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
							?>
								<option value="<?php echo $rK['kode']; ?>"><?php echo $rK['kode']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="personil" class="col-sm-3 control-label">Personil</label>
					<div class="col-sm-5">
						<input name="personil" type="text" class="form-control" id="personil" value="<?php echo $_SESSION['nama10']; ?>" placeholder="personil" readonly>
					</div>

				</div>
				<div class="form-group">
					<label for="acc_staff" class="col-sm-3 control-label">Acc</label>
					<div class="col-sm-5">
						<select name="acc_staff" class="form-control" id="acc_staff" disabled>
							<option value="">Pilih</option>
							<option value="-">-</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT nama FROM db_dying.tbl_staff WHERE jabatan IN ('SPV','Asst. Manager','Manager','Senior Manager','DMF') ORDER BY nama ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
							?>
								<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Keterangan</label>
					<div class="col-sm-5">
						<select name="ket" class="form-control" id="ket" required>
							<option value="">Pilih</option>
							<option value='Cuci YD'>Cuci YD</option>
							<option value='Cuci Misty'>Cuci Misty</option>
							<option value='Development Sample'>Development Sample</option>
							<option value='First Lot'>First Lot</option>
							<option value='Gagal Proses'>Gagal Proses</option>
							<option value='Greige'>Greige</option>
							<option value='Greige Delay'>Greige Delay</option>
							<option value='Mini Bulk'>Mini Bulk</option>
							<option value='Perbaikan'>Perbaikan</option>
							<option value='Salesmen Sample'>Salesmen Sample</option>
							<option value='Relaxing-Preset'>Relaxing-Preset</option>
							<option value='Scouring-Preset'>Scouring-Preset</option>
							<option value='Continuous'>Continuous</option>
							<!--<option value='Test Mesin' >Test Mesin</option>
							    <option value='Test Obat' >Test Obat</option>
							  	<option value='Test Proses' >Test Proses</option>-->
							<option value='Tolak Basah'>Tolak Basah</option>
							<option value='Proses AKW'>Proses AKW</option>
							<option value='Ganti Kain Internal'>Ganti Kain Internal</option>
							<option value='Ganti Kain External'>Ganti Kain External</option>
						</select>
					</div>
					<div class="col-sm-4">
						<select name="ket_kain" id="ket_kain" class="form-control" required>
							<option value="">Pilih</option>
							<option value="Sudah Buka Kain">Sudah Buka Kain</option>
							<option value="Belum Buka Kain">Belum Buka Kain</option>
							<option value="Kain Basah">Kain Basah</option>
							<option value="Kain Kering">Kain Kering</option>
							<option value="Sudah Dokumen">Sudah Dokumen</option>
							<option value="Sudah Jahit Pinggir">Sudah Jahit Pinggir</option>
							<option value="Kain Sudah Preset">Kain Sudah Preset</option>
							<option value="Celup Poly Dulu (T-Side)">Celup Poly Dulu (T-Side)</option>
							<option value="Urgent">Urgent</option>
							<option value="Test Kestabilan">Test Kestabilan</option>
						</select>
					</div>

				</div>
			</div>
			<input type="hidden" value="<?php if ($cek > 0) {
											echo $rcek['no_ko'];
										} else {
											echo $rKO['KONo'];
										} ?>" name="no_ko">

		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Schedule'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
			<?php if ($cek1 > 0) { ?>
				<!-- <button type="submit" class="btn btn-primary pull-right" name="update" value="update">Ubah <i class="fa fa-edit"></i></button> -->
			<?php } else { ?>
				<button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
			<?php } ?>

		</div>
	</div>
</form>

<?php
	function toDateOrNull($v) {
    	return ($v === '' || $v === null) ? null : $v; 
	}
	function round2OrNull($value) {
		if ($value === '' || $value === null) {
			return null;
		}
		$value = str_replace(',', '.', $value);

		if (!is_numeric($value)) {
			return null;
		}

		return round((float)$value, 2);
	}
	if ($_POST['save'] == "save") {
		function sqlsrv_last_insert_id($con) {
			$stmt = sqlsrv_query($con, "SELECT SCOPE_IDENTITY() AS last_id");
			$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
			return $row['last_id'] ?? null;
		}
		// Cek mesin sedang jalan untuk no_urut 1
		$sqlCekMesin = "SELECT COUNT(*) AS jml FROM db_dying.tbl_schedule WHERE status = 'sedang jalan' AND no_mesin = ?";
		$paramsCekMesin = array($_POST['no_mc']);
		$qryCek = sqlsrv_query($con, $sqlCekMesin, $paramsCekMesin);
		$rowCek = sqlsrv_fetch_array($qryCek, SQLSRV_FETCH_ASSOC);
		$row = $rowCek ? (int)$rowCek['jml'] : 0;
		if ($row > 0 and $_POST['no_urut'] == "1") {
			echo "<script> swal({
				title: 'Tidak bisa input urutan ke-`1`, mesin masih jalan',
				text: ' Klik OK untuk Input No Urut kembali',
				type: 'warning'
			}, function(){
				window.location='';
			});</script>";
		} else {
			if ($_POST['nokk'] != "") {
				$kartu = $_POST['nokk'];
			} else {
				$kartu = 'asdf';
			}
			$warna = str_replace("'", "''", $_POST['warna']);
			$nowarna = str_replace("'", "''", $_POST['no_warna']);
			$jns = str_replace("'", "''", $_POST['jns_kain']);
			$po = str_replace("'", "''", $_POST['no_po']);
			$lot = trim($_POST['lot']);
			if (!empty($_POST['qty4']) && !empty($_POST['kapasitas'])) {
				$loading1 = round($_POST['qty4'] / $_POST['kapasitas'], 4) * 100;
			} else {
				$loading1 = '0';
			}
			if ($_POST['kk_kestabilan'] == "1") {
				$kk_kestabilan = "1";
			} else {
				$kk_kestabilan = "0";
			}
			if ($_POST['kk_normal'] == "1") {
				$kk_normal = "1";
			} else {
				$kk_normal = "0";
			}
			// batasi panjang sesuai definisi kolom varchar(19) di SQL Server
			$ket_status_db = isset($_POST['ket']) ? substr($_POST['ket'], 0, 19) : null;
			$ket_kain_db   = isset($_POST['ket_kain']) ? substr($_POST['ket_kain'], 0, 19) : null;
			// normalisasi tgl_delivery agar tidak kirim '0000-00-00' ke SQL Server
			$paramTglDelivery = $_POST['tgl_delivery'];
			if ($paramTglDelivery === '0000-00-00' || $paramTglDelivery === '' || $paramTglDelivery === '0000-00-00 00:00:00') {
				$paramTglDelivery = null;
			}
			$sqlInsert = "INSERT INTO db_dying.tbl_schedule
				(nokk, 
				nodemand, 
				langganan, 
				buyer, 
				no_order, 
				po, 
				no_hanger, 
				no_item, 
				jenis_kain,
				tgl_delivery, 
				lebar, 
				gramasi, 
				warna, 
				no_warna, 
				qty_order, 
				pjng_order, 
				satuan_order,
				lot, rol, bruto, no_rajut, shift, g_shift, kapasitas, no_mesin, no_urut, no_sch,
				 loading, resep, no_resep, no_resep2, suffix, suffix2, energi, dyestuff, proses,
				 revisi, kategori_warna, ket_status, ket_kain, personil, tgl_masuk,
				 kk_kestabilan, kk_normal, tgl_update)
				OUTPUT INSERTED.id
				VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
				 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, GETDATE())";
			// $sqlInsert = "INSERT INTO db_dying.tbl_schedule
			// 	(nokk, 
			// 	nodemand, 
			// 	langganan, 
			// 	buyer, 
			// 	no_order, 
			// 	po, 
			// 	no_hanger, 
			// 	no_item, 
			// 	jenis_kain,
			// 	tgl_delivery, 
			// 	lebar, 
			// 	gramasi, 
			// 	warna, 
			// 	no_warna, 
			// 	qty_order, 
			// 	pjng_order, 
			// 	satuan_order,
			// 	lot, rol, bruto, no_rajut, shift, g_shift, kapasitas, no_mesin, no_urut, no_sch,
			// 	 loading, resep, no_resep, no_resep2, suffix, suffix2, energi, dyestuff, proses,
			// 	 revisi, kategori_warna, ket_status, ket_kain, tgl_masuk,
			// 	 kk_kestabilan, kk_normal, tgl_update)
			// 	OUTPUT INSERTED.id
			// 	VALUES
			// 	($kartu, $_POST[demand], $_POST[langganan], $_POST[buyer], $_POST[no_order], $po, $_POST[no_hanger], $_POST[no_item], $jns, $paramTglDelivery, $_POST[lebar], $_POST[grms], $warna, $nowarna, $_POST[qty1], $_POST[qty2], $_POST[satuan1], $lot, $_POST[qty3], $_POST[qty4], $_POST[no_rajut], $_POST[shift], $_POST[g_shift], $_POST[kapasitas], $_POST[no_mc], $_POST[no_urut], $_POST[no_urut], $loading1, $_POST[resep], $_POST[no_resep], $_POST[no_resep2], $_POST[suffix], $_POST[suffix2], $_POST[energi], $_POST[dyestuff], $_POST[proses], $_POST[revisi], $_POST[kategori_warna], $ket_status_db, $ket_kain_db, GETDATE(), $kk_kestabilan, $kk_normal, GETDATE())";

				//  echo $kartu; // Debug: Tampilkan query insert

			$paramsInsert = array(
				$kartu,
				$_POST['demand'],
				$_POST['langganan'],
				$_POST['buyer'],
				$_POST['no_order'],
				$po,
				$_POST['no_hanger'],
				$_POST['no_item'],
				$jns,
				$paramTglDelivery,
				(int)toDateOrNull($_POST['lebar']),
				(int)toDateOrNull($_POST['grms']),
				$warna,
				$nowarna,
				round2OrNull($_POST['qty1']),
				round2OrNull($_POST['qty2']),
				$_POST['satuan1'],
				$lot,
				(int)toDateOrNull($_POST['qty3']),
				round2OrNull($_POST['qty4']),
				$_POST['no_rajut'],
				$_POST['shift'],
				$_POST['g_shift'],
				$_POST['kapasitas'],
				$_POST['no_mc'],
				$_POST['no_urut'],
				$_POST['no_urut'],
				$loading1,
				$_POST['resep'],
				$_POST['no_resep'],
				$_POST['no_resep2'],
				$_POST['suffix'],
				$_POST['suffix2'],
				$_POST['energi'],
				$_POST['dyestuff'],
				$_POST['proses'],
				$_POST['revisi'],
				$_POST['kategori_warna'],
				$ket_status_db,
				$ket_kain_db,
				$_POST['personil'],
				$kk_kestabilan,
				$kk_normal
			);

			$sqlData = sqlsrv_query($con, $sqlInsert, $paramsInsert);
			if ($sqlData) {
				$rowInsert = sqlsrv_fetch_array($sqlData, SQLSRV_FETCH_ASSOC);
				$last_id_schedule = $rowInsert['id'];
				// $last_id_schedule = sqlsrv_last_insert_id($con); 
				$nodemand   = $_POST['demand']; 
				$nokk       = $kartu;           
				$nomc       = $_POST['no_mc'];  
				$urut       = $_POST['no_urut'];  
				$user_id    = $_SESSION['nama10']; 
				$getdate    = date('Y-m-d H:i:s'); 
				$remote_add = $_SERVER['REMOTE_ADDR']; 
				$query_log 	= "INSERT INTO db_dying.tbl_log_mc_schedule(id_schedule,
																nodemand,
																nokk,
																no_mc,
																user_update,
																user_insert,
																date_insert,
																date_update,
																no_urut,
																no_sch,
																ip_update,
																ip_insert,
																col_update)
																VALUES(?,?,?,?,?,?,?,?,?,?,?,?,'FIRST_INSERT_SCHEDULE')";
				$params_log = [$last_id_schedule,$nodemand,$nokk,$nomc,$user_id,
								$user_id,$getdate,$getdate,$urut,$urut,$remote_add,$remote_add];
				$sqlLog 		= sqlsrv_query($con, $query_log, $params_log);
				echo "<script>swal({
				title: 'Data Tersimpan',   
				text: 'Klik Ok untuk input data kembali',
				type: 'success',
				}).then((result) => {
				if (result.value) {
					window.location.href='?p=Schedule'; 
				}
				});</script>";
			} else {
				// Debug error SQL Server jika insert gagal
				$errors = sqlsrv_errors();
				if ($errors) {
					echo '<pre>SQL Insert Error:\n';
					foreach ($errors as $err) {
						echo 'SQLSTATE: ' . $err['SQLSTATE'] . ' - Code: ' . $err['code'] . ' - ' . $err['message'] . "\n";
					}
					echo '</pre>';
				}
			}
		}
	}
	if ($_POST['update'] == "update") {
		$warna = str_replace("'", "''", $_POST['warna']);
		$nowarna = str_replace("'", "''", $_POST['no_warna']);
		$jns = str_replace("'", "''", $_POST['jns_kain']);
		$po = str_replace("'", "''", $_POST['no_po']);
		$lot = trim($_POST['lot']);
		if(!empty($_POST['qty4']) && !empty($_POST['kapasitas'])){
			$loading1 = round($_POST['qty4'] / $_POST['kapasitas'], 4) * 100;
		}else{
			$loading1 = '0';
		}
		if ($_POST['kk_kestabilan'] == "1") {
			$kk_kestabilan = "1";
		} else {
			$kk_kestabilan = "0";
		}
		if ($_POST['kk_normal'] == "1") {
			$kk_normal = "1";
		} else {
			$kk_normal = "0";
		}
		// batasi panjang teks ket_status & ket_kain
		$ket_status_db = isset($_POST['ket']) ? substr($_POST['ket'], 0, 19) : null;
		$ket_kain_db   = isset($_POST['ket_kain']) ? substr($_POST['ket_kain'], 0, 19) : null;
		$paramTglDelivery = $_POST['tgl_delivery'];
		if ($paramTglDelivery === '0000-00-00' || $paramTglDelivery === '' || $paramTglDelivery === '0000-00-00 00:00:00') {
			$paramTglDelivery = null;
		}
		$sqlUpdate = "UPDATE db_dying.tbl_schedule SET 
				nodemand = ?,
				kapasitas = ?,
				no_mesin = ?,
				no_urut = ?,
				no_sch = ?,
				loading = ?,
				resep = ?,
				no_resep = ?,
				no_resep2 = ?,
				suffix = ?,
				suffix2 = ?,
				energi = ?,
				dyestuff = ?,
				proses = ?,
				revisi = ?,
				kategori_warna = ?,
				shift = ?,
				g_shift = ?,
				no_rajut = ?,
				ket_status = ?,
				ket_kain = ?,
				personil = ?,
				target = ?,
				tgl_stop = GETDATE(),
				kk_kestabilan = ?,
				kk_normal = ?,
				tgl_update = GETDATE()
			WHERE nokk = ?";

		$paramsUpdate = array(
			$_POST['demand'],
			$_POST['kapasitas'],
			$_POST['no_mc'],
			$_POST['no_urut'],
			$_POST['no_urut'],
			$loading1,
			$_POST['resep'],
			$_POST['no_resep'],
			$_POST['no_resep2'],
			$_POST['suffix'],
			$_POST['suffix2'],
			$_POST['energi'],
			$_POST['dyestuff'],
			$_POST['proses'],
			$_POST['revisi'],
			$_POST['kategori_warna'],
			$_POST['shift'],
			$_POST['g_shift'],
			$_POST['no_rajut'],
			$ket_status_db,
			$ket_kain_db,
			$_POST['personil'],
			$_POST['target'],
			$kk_kestabilan,
			$kk_normal,
			$_POST['nokk']
		);

		$sqlData = sqlsrv_query($con, $sqlUpdate, $paramsUpdate);

		if ($sqlData) {
			echo "<script>swal({
				title: 'Data Telah DiUbah',   
				text: 'Klik Ok untuk input data kembali',
				type: 'success',
				}).then((result) => {
				if (result.value) {
					
					window.location.href='?p=Schedule'; 
				}
				});</script>";
		} else {
			$errors = sqlsrv_errors();
			if ($errors) {
				echo '<pre>SQL Update Error:\n';
				foreach ($errors as $err) {
					echo 'SQLSTATE: ' . $err['SQLSTATE'] . ' - Code: ' . $err['code'] . ' - ' . $err['message'] . "\n";
				}
				echo '</pre>';
			}
		}
	}
?>
