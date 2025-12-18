<?php
// include "koneksiLAB.php";
include "koneksi.php";
include "helpers.php";
//db_connect($db_name);
$nokk = $_GET['nokk'];
if ($nokk) {
	$sqlCek = sqlsrv_query($con, "SELECT TOP 1 COUNT(*) OVER() as total_rows, * FROM db_dying.tbl_schedule WHERE nokk='$nokk' ORDER BY id DESC");
	$rcek = sqlsrv_fetch_array($sqlCek);
	$cek = $rcek['total_rows'];
}
$splitresep = explode('-', $rcek['no_resep']);
$prdorder 	= $splitresep[0];
$grpline 	= $splitresep[1];
// $no_mesin 	= print_r($rcek['no_mesin']);
$query_waktu = "SELECT
					TOP 1 th.operator_keluar,
					th.tgl_buat as jam_stop ,
					GETDATE() as jam_start
				FROM
					db_dying.tbl_hasilcelup th
				INNER JOIN db_dying.tbl_montemp tm on
					th.id_montemp = tm.id
				INNER JOIN db_dying.tbl_schedule ts on
					tm.id_schedule = ts.id
				WHERE
					ts.no_mesin = '" . $rcek['no_mesin'] . "'
				ORDER BY
					th.id DESC";
// echo $query_waktu;
$sqlCekWaktu 	= sqlsrv_query($con, $query_waktu );
$rcekW 			= sqlsrv_fetch_array($sqlCekWaktu);
$awalP  		= strtotime(formatDateTime($rcekW['jam_stop'],"H:i:s"));
$akhirP 		= strtotime(formatDateTime($rcekW['jam_start'],"H:i:s"));
$diffP  		= ($akhirP - $awalP);
// $diffP  		= 3700;
$tjamP  		= round($diffP / (60 * 60), 2);

$query_Mc		="SELECT
						no_mesin,
						kode,
						waktu_tunggu,
						wt_des,
						ket
					FROM
						db_dying.tbl_mesin
					WHERE
						no_mesin = '" . $rcek['no_mesin'] . "'";
// echo $query_Mc;
$sqlCekMc = sqlsrv_query($con, $query_Mc);
$rCekMc = sqlsrv_fetch_array($sqlCekMc);

$query_Cek1 ="SELECT
					TOP 1 *
				FROM
					db_dying.tbl_montemp
				WHERE
					nokk = '$nokk'
					and (status = 'antri mesin'
						or status = 'sedang jalan')
				ORDER BY
					id DESC";
$sqlCek1 = sqlsrv_query($con,$query_Cek1 );
// $cek1 = mysqli_num_rows($sqlCek1);
$rcek1 = sqlsrv_fetch_array($sqlCek1);

$query_Cek2 ="SELECT
				MAX(id) as id,
				CASE
					WHEN COUNT(lot)>1 THEN 'Gabung Kartu'
					ELSE ''
				END AS ket_kartu,
				CASE 
					WHEN COUNT(lot) > 1 
					THEN CONCAT('(', CAST(COUNT(lot) AS VARCHAR), 'kk', ')') 
					ELSE '' 
				END AS kk,
				STRING_AGG(nokk, ', ') AS g_kk,
				no_mesin,
				no_urut,	
				SUM(rol) as rol,
				SUM(bruto) as bruto
			FROM
				db_dying.tbl_schedule 
			WHERE
				NOT status = 'selesai' 
				AND no_mesin='" . $rcek['no_mesin'] . "' and no_urut='" . $rcek['no_urut'] . "'
			GROUP BY
				no_mesin,
				no_urut 
			ORDER BY
				id ASC";
// echo $query_Cek2;
$sqlcek2 = sqlsrv_query($con,$query_Cek2);
// $cek2 = mysqli_num_rows($sqlcek2);
$rcek2 = sqlsrv_fetch_array($sqlcek2);
if ($rcek2['ket_kartu'] != "") {
	$ketsts = $rcek2['ket_kartu'] . "\n(" . $rcek2['g_kk'] . ")";
} else {
	$ketsts = "";
}
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
function Des2($angka)
{
	$bulat = round($angka);
	if ($bulat > $angka) {
		$n = $bulat;
		$h = $n . ".0";
	} else {
		$n = $bulat;
		$h = $n . ".5";
	}
	return $h;
}
?>
<?php
// $sqlc = "select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25 from ticket_title where ID_NO='" . $rcek['no_resep'] . "' order by createtime Desc";
//--lot
// $qryc = sqlsrv_query($conn1, $sqlc, array(), array("Scrollable" => "static"));

// $countdata = sqlsrv_num_rows($qryc);

// if ($countdata > 0) {
// 	date_default_timezone_set('Asia/Jakarta');

// 	$tglsvr = sqlsrv_query($conn1, "select CONVERT(VARCHAR(10),GETDATE(),105) AS  tgk");
// 	$sr = sqlsrv_fetch_array($tglsvr);
// 	$sqls = sqlsrv_query($conn, "select processcontrolJO.SODID,salesorders.ponumber,processcontrol.productid,salesorders.customerid,joborders.documentno,
// 								salesorders.buyerid,processcontrolbatches.lotno,productcode,productmaster.color,colorno,description,weight,cuttablewidth,SOSampleColor.OtherDesc,SOSampleColor.Flag from Joborders 
// 								left join processcontrolJO on processcontrolJO.joid = Joborders.id
// 								left join salesorders on soid= salesorders.id
// 								Left join SOSampleColor on SOSampleColor.SOID=SalesOrders.id
// 								left join processcontrol on processcontrolJO.pcid = processcontrol.id
// 								left join processcontrolbatches on processcontrolbatches.pcid = processcontrol.id
// 								left join productmaster on productmaster.id= processcontrol.productid
// 								left join productpartner on productpartner.productid= processcontrol.productid
// 								where processcontrolbatches.documentno='" . $rcek['nokk'] . "'");
// 	$ssr = sqlsrv_fetch_array($sqls);
// 	$lgn1 = sqlsrv_query($conn, "select partnername from partners where id='" . $ssr['customerid'] . "'");
// 	$ssr1 = sqlsrv_fetch_array($lgn1);
// 	$lgn2 = sqlsrv_query($conn, "select partnername from partners where id='" . $ssr['buyerid'] . "'");
// 	$ssr2 = sqlsrv_fetch_array($lgn2);
// 	$itm = sqlsrv_query($conn, "select colorcode,color,productcode from productpartner where productid='" . $ssr['productid'] . "' and partnerid='" . $ssr['customerid'] . "'");
// 	$itm2 = sqlsrv_fetch_array($itm);
// 	$row = sqlsrv_fetch_array($qryc);
// 	//
// 	$sql = sqlsrv_query($conn, "select stockmovement.dono,stockmovement.documentno as no_doku,processcontrolbatches.documentno,lotno,customerid,
// 								processcontrol.productid ,processcontrol.id as pcid, 
// 							sum(stockmovementdetails.weight) as berat,
// 							count(stockmovementdetails.weight) as roll,processcontrolbatches.dated as tgllot
// 							from stockmovement 
// 							LEFT join stockmovementdetails on StockMovement.id=stockmovementdetails.StockmovementID
// 							left join processcontrolbatches on processcontrolbatches.id=stockmovement.pcbid
// 							left join processcontrol on processcontrol.id=processcontrolbatches.pcid
// 							where wid='12' and processcontrolbatches.documentno='" . $rcek['nokk'] . "' and (transactiontype='7' or transactiontype='4')
// 							group by stockmovement.DocumentNo,processcontrolbatches.DocumentNo,processcontrolbatches.LotNo,stockmovement.dono,
// 							processcontrol.CustomerID,processcontrol.ProductID,processcontrol.ID,processcontrolbatches.Dated") or die("gagal");
// 	$c = 0;
// 	$r = sqlsrv_fetch_array($sql);
// 	if ($r['documentno'] != '') {
// 		$dated = $r['tgllot']->format('Y-m-d H:i:s');
// 	}
// 	$sqlkko = sqlsrv_query($conn, "select SODID from knittingorders  
// 	where knittingorders.Kono='" . $r['dono'] . "'") or die("gagal");
// 	$rkko = sqlsrv_fetch_array($sqlkko);
// 	$sqlkko1 = sqlsrv_query($conn, "select joid,productid from processcontroljo  
// 	where sodid='" . $rkko['SODID'] . "'") or die("gagal");
// 	$rkko1 = sqlsrv_fetch_array($sqlkko1);
// 	if ($r['productid'] != '') {
// 		$kno1 = $r['productid'];
// 	} else {
// 		$kno1 = $rkko1['productid'];
// 	}
// 	$sql1 = sqlsrv_query($conn, "select hangerno,color from  productmaster
// 	where id='$kno1'") or die("gagal");
// 	$r1 = sqlsrv_fetch_array($sql1);
// 	$sql2 = sqlsrv_query($conn, "select partnername from Partners
// 	where id='" . $r['customerid'] . "'") or die("gagal");
// 	$r2 = sqlsrv_fetch_array($sql2);
// 	$sql3 = sqlsrv_query($conn, "select Kono,joid from processcontroljo 
// 	where pcid='" . $r['pcid'] . "'") or die("gagal");
// 	$r3 = sqlsrv_fetch_array($sql3);
// 	if ($r3['Kono'] != '') {
// 		$kno = $r3['Kono'];
// 	} else {
// 		$kno = $r['dono'];
// 	}
// 	$sql4 = sqlsrv_query($conn, "select CAST(TM.dbo.knittingorders.[Note] AS VARCHAR(8000))as note,id,supplierid from knittingorders 
// 	where kono='$kno'") or die("gagal");
// 	$r4 = sqlsrv_fetch_array($sql4);
// 	$sql5 = sqlsrv_query($conn, "select partnername from partners 
// 	where id='" . $r4['supplierid'] . "'") or die("gagal");
// 	$r5 = sqlsrv_fetch_array($sql5);
// 	if ($r3['joid'] != '') {
// 		$jno = $r3['joid'];
// 	} else {
// 		$jno = $rkko1['joid'];
// 	}
// 	$sql6 = sqlsrv_query($conn, "select documentno,soid from joborders 
// 	where id='$jno'") or die("gagal");
// 	$r6 = sqlsrv_fetch_array($sql6);
// 	$sql8 = sqlsrv_query($conn, "select customerid from salesorders where id='" . $r6['soid'] . "'") or die("gagal");
// 	$r8 = sqlsrv_fetch_array($sql8);
// 	$sql9 = sqlsrv_query($conn, "select partnername from partners where id='" . $r8['customerid'] . "'") or die("gagal");
// 	$r9 = sqlsrv_fetch_array($sql9);
// 	$sql10 = sqlsrv_query($conn, "select id,productid from kodetails where koid='" . $r4['id'] . "'") or die("gagal");
// 	$r10 = sqlsrv_fetch_array($sql10);
// 	$sql11 = sqlsrv_query($conn, "select productnumber from productmaster where id='" . $r10['productid'] . "'") or die("gagal");
// 	$r11 = sqlsrv_fetch_array($sql11);


// 	$s4 = sqlsrv_query($conn, "select KOdetails.id as KODID,productmaster.id as BOMID ,KnittingOrders.SupplierID,TM.dbo.Partners.PartnerName,ProductNumber,CustomerID,SODID,KnittingOrders.ID as KOID,SalesOrders.ID as SOID from 
// 							(TM.dbo.KnittingOrders 
// 							left join TM.dbo.SODetails on TM.dbo.SODetails.ID= TM.dbo.KnittingOrders.SODID
// 							left join TM.dbo.KODetails on TM.dbo.KODetails.KOid= TM.dbo.KnittingOrders.ID
// 							left join TM.dbo.Partners on TM.dbo.Partners.ID= TM.dbo.KnittingOrders.SupplierID)
// 							left join TM.dbo.ProductMaster on TM.dbo.ProductMaster.ID= TM.dbo.KODetails.ProductID
// 							left join TM.dbo.SalesOrders on TM.dbo.SalesOrders.ID= TM.dbo.SODetails.SOID
// 						where KONO='$kno'");
// 	$as7 = sqlsrv_fetch_array($s4);
// 	$sql12 = sqlsrv_query($conn, "select SODetailsBom.ProductID from SODetailsBom where SODID='" . $as7['SODID'] . "' and KODID='" . $as7['KODID'] . "' and Parentproductid='" . $as7['BOMID'] . "' order by ID", array(), array("Scrollable" => "static"));
// 	$sql14 = sqlsrv_query($conn, "select count(lotno)as jmllot from processcontrolbatches where pcid='" . $r['pcid'] . "' and dated='$dated'");
// 	$lt = sqlsrv_fetch_array($sql14);
// 	$ai = sqlsrv_num_rows($sql12);
// 	$sql15 = sqlsrv_query($conn, "select Partnername from TM.dbo.Partners where TM.dbo.Partners.ID='" . $as7['CustomerID'] . "'");
// 	$as8 = sqlsrv_fetch_array($sql15);
// 	$i = 0;
// 	do {
// 		$as5 = sqlsrv_fetch_array($sql12);
// 		$sql13 = sqlsrv_query($conn, "select ShortDescription from  ProductMaster where ID='" . $as5['ProductID'] . "'");
// 		$as6 = sqlsrv_fetch_array($sql13);
// 		$ar[$i] = $as6['ShortDescription'];

// 		$i++;
// 	} while ($ai >= $i);
// 	$jb1 = $ar[0];
// 	$jb2 = $ar[1];
// 	$jb3 = $ar[2];
// 	$jb4 = $ar[3];
// 	if ($ai < 2) {
// 		$jb1 = $ar[0];
// 		$jb2 = '';
// 		$jb3 = '';
// 	}
// 	$bng = $jb1 . "," . $jb2 . "," . $jb3 . "," . $jb4;
// }

// NOW
$groupline = substr($rcek['no_resep'], 9);
$db_viewreservation = db2_exec($conn2, "SELECT * FROM VIEWPRODUCTIONRESERVATION WHERE PRODUCTIONORDERCODE = '$nokk' AND GROUPLINE = '$groupline'");
$r_viewreservation = db2_fetch_assoc($db_viewreservation);

$groupline2 = substr($rcek['no_resep2'], 9);
$db_viewreservation2 = db2_exec($conn2, "SELECT * FROM VIEWPRODUCTIONRESERVATION WHERE PRODUCTIONORDERCODE = '$nokk' AND GROUPLINE = '$groupline2'");
$r_viewreservation2 = db2_fetch_assoc($db_viewreservation2);


list($production_order, $groupline) = explode("-", $rcek['no_resep']);
$grupline   = substr($dt_schedule['no_resep'], 9);
$query_br1  = db2_exec($conn2, "SELECT
                                    TRIM(SUBCODE01) AS SUBCODE01,
                                    TRIM(SUFFIXCODE) AS SUFFIXCODE
                                FROM
                                    PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                WHERE
                                    TRIM(PRODUCTIONRESERVATION.PRODUCTIONORDERCODE) = '$production_order'
									AND TRIM(PRODUCTIONRESERVATION.GROUPLINE) = '$groupline'");
$row_br1    = db2_fetch_assoc($query_br1);

$query_carryover    = db2_exec($conn2, "SELECT floor(a.VALUEDECIMAL) AS CARRYOVER
                                        FROM 
                                            RECIPE r 
                                        LEFT JOIN ADSTORAGE a ON a.UNIQUEID = r.ABSUNIQUEID AND a.NAMENAME = 'CarryOver'
                                        WHERE r.SUBCODE01 = '$row_br1[SUBCODE01]' AND r.SUFFIXCODE = '$row_br1[SUFFIXCODE]'");
$row_carryover      = db2_fetch_assoc($query_carryover);
if (!empty($row_carryover['CARRYOVER'])) {
	$carry_over     = $row_carryover['CARRYOVER'];
} else {
	$carry_over     = 0;
}

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
												TRIM(DSUBCODE05) AS NO_WARNA,
												TRIM(DSUBCODE02) || '-' || TRIM(DSUBCODE03)  AS NO_HANGER,
												TRIM(ITEMDESCRIPTION) AS ITEMDESCRIPTION,
												DELIVERYDATE
											FROM 
												ITXVIEWKK 
											WHERE 
												PRODUCTIONORDERCODE = '$nokk'");
$dt_ITXVIEWKK	= db2_fetch_assoc($sql_ITXVIEWKK);

$db_stdcckwarna = db2_exec($conn2, "SELECT 
                                                CASE
                                                    WHEN ic.VALUESTRING = '1' THEN 'Labdip' || ' - ' || ic2.VALUESTRING 
                                                    WHEN ic.VALUESTRING = '2' THEN 'First Lot' || ' - ' || ic2.VALUESTRING 
                                                    WHEN ic.VALUESTRING = '3' THEN 'Original' || ' - ' || ic2.VALUESTRING 
                                                    WHEN ic.VALUESTRING = '4' THEN 'Previous Order' || ' - ' || ic2.VALUESTRING 
                                                    WHEN ic.VALUESTRING = '5' THEN 'Master Color' || ' - ' || ic2.VALUESTRING 
                                                    WHEN ic.VALUESTRING = '6' THEN 'Lampiran Buyer' || ' - ' || ic2.VALUESTRING 
                                                    WHEN ic.VALUESTRING = '7' THEN 'Body' || ' - ' || ic2.VALUESTRING 
                                                END AS STANDART_COCOK_WARNA
                                            FROM 
                                                SALESORDERLINE s 
                                            LEFT JOIN ITXVIEW_COLORSTANDARD ic ON ic.UNIQUEID = s.ABSUNIQUEID 
                                            LEFT JOIN ITXVIEW_COLORREMARKS ic2 ON ic2.UNIQUEID = s.ABSUNIQUEID 
                                            WHERE 
                                                s.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'");
$r_stdcckwarna  = db2_fetch_assoc($db_stdcckwarna);
if (!empty($r_stdcckwarna['STANDART_COCOK_WARNA'])) {
	$std_cck_warna  =   $r_stdcckwarna['STANDART_COCOK_WARNA'];
} else {
	$std_cck_warna  = '';
}

// NOW
?>
<?php
$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
$Item		= isset($_POST['item']) ? $_POST['item'] : '';
$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
?>
<!--alerts CSS -->
<link href="bower_components/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
<!-- Sweet Alert -->
<script type="text/javascript" src="bower_components/sweetalert/sweetalert2.min.js"></script>
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
					<label for="no_po" class="col-sm-3 control-label">No KK</label>
					<div class="col-sm-3">
						<input name="nokk" type="text" class="form-control" id="nokk" onchange="window.location='?p=Form-Monitoring&nokk='+this.value" value="<?php echo $_GET['nokk']; ?>" placeholder="No KK" required>
						<input name="id" type="hidden" class="form-control" id="id" value="<?php echo $rcek['id']; ?>" placeholder="ID">
					</div>
					<label for="jammasukkain" class="col-sm-2 control-label">Jam Masuk Kain</label>
					<div class="col-sm-2">
						<?php
						// Mengatur zona waktu
						date_default_timezone_set('Asia/Jakarta');

						// Mendapatkan tanggal hari ini
						$tanggal_hari_ini = date('Y-m-d');

						// Mendapatkan tanggal kemarin
						$tanggal_kemarin = date('Y-m-d', strtotime('-1 day'));
						?>
						<input name="jammasukkain" type="date" class="form-control col-sm-2" required min="<?php echo $tanggal_kemarin; ?>" max="<?php echo $tanggal_hari_ini; ?>">
					</div>
					<div class="col-sm-2">
						<input name="tglmasukkain" type="text" class="form-control col-sm-2" id="tglmasukkain" required placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25" onkeyup="
																				var time = this.value;
																				if (time.match(/^\d{2}$/) !== null) {
																					this.value = time + ':';
																				} else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
																					this.value = time + '';
																				}" value="<?php echo $rw['jam_in'] ?>" size="5" maxlength="5">
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Demand</label>
					<div class="col-sm-8">
						<input name="demand" type="text" class="form-control" id="demand" value="<?= $rcek['nodemand']; ?>" placeholder="demand">
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Langganan</label>
					<div class="col-sm-8">
						<input name="langganan" type="text" class="form-control" id="langganan" value="<?php if ($cek > 0) {
																											echo $rcek['langganan'];
																										} else {
																											echo $pelanggan;
																										} ?>" placeholder="Langganan">
					</div>
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-8">
						<input name="buyer" type="text" class="form-control" id="buyer" value="<?php if ($cek > 0) {
																									echo $rcek['buyer'];
																								} else {
																									echo $buyer;
																								} ?>" placeholder="Buyer">
					</div>
				</div>
				<div class="form-group">
					<label for="no_order" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="no_order" type="text" class="form-control" id="no_order" value="<?php if ($cek > 0) {
																											echo $rcek['no_order'];
																										} else {
																											if ($r['NoOrder'] != "") {
																												echo $r['NoOrder'];
																											} else if ($nokk != "") {
																												echo $cekM['no_order'];
																											}
																										} ?>" placeholder="No Order" required>
					</div>
				</div>
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">PO</label>
					<div class="col-sm-5">
						<input name="no_po" type="text" class="form-control" id="no_po" value="<?php if ($cek > 0) {
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
						<input name="no_hanger" type="text" class="form-control" id="no_hanger" value="<?php if ($cek > 0) {
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
						<input name="no_item" type="text" class="form-control" id="no_item" value="<?php if ($rcek['no_item'] != "") {
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
						<textarea name="jns_kain" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if ($cek > 0) {
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
							<input name="tgl_delivery" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if ($cek > 0) {
																																						echo formatDateTime($rcek['tgl_delivery'],'Y-m-d');
																																					} else {
																																						if ($r['RequiredDate'] != "") {
																																							echo date('Y-m-d', strtotime($r['RequiredDate']));
																																						}
																																					} ?>" required />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="l_g" class="col-sm-3 control-label">L X Grm Permintaan</label>
					<div class="col-sm-2">
						<input name="lebar" type="text" class="form-control" id="lebar" value="<?php if ($cek > 0) {
																									echo $rcek['lebar'];
																								} else {
																									echo round($r['Lebar']);
																								} ?>" placeholder="0" required>
					</div>
					<div class="col-sm-2">
						<input name="grms" type="text" class="form-control" id="grms" value="<?php if ($cek > 0) {
																									echo $rcek['gramasi'];
																								} else {
																									echo round($r['Gramasi']);
																								} ?>" placeholder="0" onChange="hitungp();" required>
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-8">
						<input name="warna" type="text" class="form-control" id="warna" value="<?php if ($cek > 0) {
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
						<input name="no_warna" type="text" class="form-control" id="no_warna" value="<?php if ($cek > 0) {
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
							<input name="qty1" type="text" class="form-control" id="qty1" value="<?php if ($cek > 0) {
																										echo $rcek['qty_order'];
																									} else {
																										echo round($r['BatchQuantity'], 2);
																									} ?>" placeholder="0.00" required>
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group">
							<input name="qty2" type="text" class="form-control" id="qty2" value="<?php if ($cek > 0) {
																										echo $rcek['pjng_order'];
																									} else {
																										echo round($r['Quantity'], 2);
																									} ?>" placeholder="0.00" style="text-align: right;" required>
							<span class="input-group-addon">
								<select name="satuan1" style="font-size: 12px;">
									<option value="Yard" <?php if ($rcek['satuan_order'] == "Yard") {
																echo "SELECTED";
															} ?>>Yard</option>
									<option value="Meter" <?php if ($rcek['satuan_order'] == "Meter") {
																echo "SELECTED";
															} ?>>Meter</option>
									<option value="PCS" <?php if ($rcek['satuan_order'] == "PCS") {
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
						<input name="lot" type="text" class="form-control" id="lot" value="<?php if ($cek > 0) {
																								echo $rcek['lot'];
																							} else {
																								if ($nomorLot != "") {
																									echo $lotno;
																								} else if ($nokk != "") {
																									echo $cekM['lot'];
																								}
																							} ?>" placeholder="Lot">
					</div>
				</div>
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
					<div class="col-sm-2">
						<input name="qty3" type="text" class="form-control" id="qty3" value="<?php if ($cek2 > 0) {
																									echo $rcek2['rol'] . $rcek2['kk'];
																								} ?>" placeholder="0.00" required>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty4" type="text" class="form-control" id="qty4" value="<?php if ($cek2 > 0) {
																										echo $rcek2['bruto'];
																									} ?>" placeholder="0.00" style="text-align: right;" required>
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="pjng_kain" class="col-sm-3 control-label">Panjang Kain</label>
					<div class="col-sm-3">
						<input name="pjng_kain" type="text" class="form-control" id="pjng_kain" value="<?php if ($cek > 0) {
																											echo $rcek2['pnjg_kain'];
																										} ?>" placeholder="0.00" style="text-align: right;" readonly>
					</div>
					<div class="col-sm-3">
						<input name="pjng_kain_perlubang" type="text" class="form-control" id="pjng_kain_perlubang" value="<?php if ($cek > 0) {
																																echo $rcek2['pjng_kain_perlubang'];
																															} ?>" placeholder="0.00" style="text-align: right;" readonly>
					</div>
				</div>
				<?php if ($cek > 0 and $_GET['kap'] != "") {
					$loading = round($rcek2['bruto'] / $_GET['kap'], 4) * 100;
				} else {
					if ($r['Weight'] != "" and $_GET['kap'] != "") {
						$loading = round($r['Weight'] / $_GET['kap'], 4) * 100;
					} else if ($nokk != "" and $_GET['kap'] != "") {
						$loading = round($cekM['bruto'] / $_GET['kap'], 4) * 100;
					}
				} ?>
				<div class="form-group">
					<label for="kapasitas" class="col-sm-3 control-label">Kapasitas Mesin</label>
					<div class="col-sm-3">
						<select name="kapasitas" class="form-control">
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT kapasitas FROM db_dying.tbl_mesin GROUP BY kapasitas ORDER BY kapasitas DESC");
							while ($rK = sqlsrv_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['kapasitas']; ?>" <?php if ($rcek['kapasitas'] == $rK['kapasitas']) {
																					echo "SELECTED";
																				} ?>><?php echo $rK['kapasitas']; ?> KGs</option>
							<?php } ?>
						</select>
					</div>

				</div>
				<?php if ($cek > 0 and $rcek['kapasitas'] != "" and $rcek['kapasitas'] != "0") {
					if ($rcek['kapasitas'] == 0) {
						$loading = 0;
					}
					$loading = round($rcek2['bruto'] / $rcek['kapasitas'], 4) * 100;
				} else {
					if ($r['Weight'] != "" and $rcek['kapasitas'] != "") {
						$loading = round($r['Weight'] / $rcek['kapasitas'], 4) * 100;
					} else if ($nokk != "" and $rcek['kapasitas'] != "") {
						$loading = round($cekM['bruto'] / $rcek['kapasitas'], 4) * 100;
					}
				} ?>
				<div class="form-group">
					<label for="no_mc" class="col-sm-3 control-label">No MC</label>
					<div cltbl_jenis_prosesass="col-sm-2"></div>
					<div class="col-sm-3"> <?php if ($rCekMc['kode'] != "") {
												echo $rCekMc['kode'] . "&nbsp; (Std Tunggu: " . $rCekMc['wt_des'] . " Jam)";
											} ?>
					  <select name="no_mc" class="form-control">
					    <option value="">Pilih</option>
					    <?php
							$sqlKap = sqlsrv_query($con, "SELECT no_mesin FROM db_dying.tbl_mesin WHERE kapasitas='$rcek[kapasitas]' ORDER BY no_mesin ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap)) {
							?>
					    <option value="<?php echo $rK['no_mesin']; ?>" <?php if ($rcek['no_mesin'] == $rK['no_mesin']) {
																					echo "SELECTED";
																				} ?>><?php echo $rK['no_mesin']; ?></option>
					    <?php } ?>
				      </select>
					</div>

				</div>
				<div class="form-group">
					<label for="loading" class="col-sm-3 control-label">Loading</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="loading" type="text" style="text-align: right;" class="form-control" id="loading" value="<?php if ($_GET['nokk'] != "" and $rcek['kapasitas'] != "") {
																																		echo $loading;
																																	} ?>" placeholder="0.00">
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="wkt" class="col-sm-3 control-label">Waktu</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="wkt" type="text" style="text-align: right;" class="form-control" id="wkt" value="<?php if ($_GET['nokk'] != "" and $rcek['kapasitas'] != "") {
																																echo $tjamP;
																															} ?>" placeholder="0.00" readonly>
							<span class="input-group-addon">jam</span>
						</div>
					</div>
					<label for="oper_shift" class="col-sm-1 control-label">OperShift</label>
					<div class="col-sm-3">
						<input name="oper_shift" type="text" class="form-control" id="oper_shift" value="<?php if ($_GET['nokk'] != "" and $rcek['kapasitas'] != "") {
																												echo $rcekW['operator_keluar'];
																											} ?>" placeholder="Nama Operator" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="nokk_legacy" class="col-sm-3 control-label">KK Legacy</label>
					<div class="col-sm-4">
						<input name="nokk_legacy" type="text" class="form-control" id="nokk_legacy" value="<?= $rcek['nokk_legacy']; ?>" placeholder="KK Legacy">
					</div>
				</div>
				<?php if ($tjamP > $rCekMc['wt_des'] and $rCekMc['wt_des'] != "") { ?>
					<div class="form-group">
						<label for="ket" class="col-sm-3 control-label">Analisa Waktu Tunggu</label>
						<div class="col-sm-8">
							<div class="input-group">
								<select class="form-control select2" multiple="multiple" data-placeholder="Analisa" name="note_wt[]" id="note_wt" required>
									<option value="">Pilih</option>
									<?php
									$dtArr = $rcek1['analisa'];
									$data = explode(",", $dtArr);
									$qCek1 = sqlsrv_query($con, "SELECT analisa FROM db_dying.tbl_analisa_mesin_tunggu ORDER BY analisa ASC");
									$i = 0;
									while ($dCek1 = sqlsrv_fetch_array($qCek1)) { ?>
										<option value="<?php echo $dCek1['analisa']; ?>" <?php if ($dCek1['analisa'] == $data[0] or $dCek1['analisa'] == $data[1] or $dCek1['analisa'] == $data[2] or $dCek1['analisa'] == $data[3] or $dCek1['analisa'] == $data[4] or $dCek1['analisa'] == $data[5]) {
																								echo "SELECTED";
																							} ?>><?php echo $dCek1['analisa']; ?></option>
									<?php $i++;
									} ?>
								</select>
								<span class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#DataAnalisa"> ...</button></span>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<!-- col -->
			<div class="col-md-6">
				<div class="form-group">
					<label for="no_resep" class="col-sm-3 control-label">No Bon Resep 1</label>
					<div class="col-sm-3">
						<input name="no_resep" type="text" class="form-control" id="no_resep" value="<?php if ($cek > 0) {
																											echo $rcek['no_resep'];
																										} ?>" placeholder="No Bon Resep 1">
					</div>
					<div class="col-sm-3">
						<input name="suffix" type="text" class="form-control" id="suffix" value="<?= $rcek['suffix']; ?>" placeholder="Suffix 1">
					</div>
				</div>
				<div class="form-group">
					<label for="no_resep2" class="col-sm-3 control-label">No Bon Resep 2</label>
					<div class="col-sm-3">
						<input name="no_resep2" type="text" class="form-control" id="no_resep2" value="<?php if ($cek > 0) {
																											echo $rcek['no_resep2'];
																										} ?>" placeholder="No Bon Resep 2">
					</div>
					<div class="col-sm-3">
						<input name="suffix2" type="text" class="form-control" id="suffix" value="<?= $rcek['suffix2']; ?>" placeholder="Suffix 1">
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Pemakaian Air</label>
					<div class="col-sm-3">
						<div class="input-group">
							<?php
							if ($r_viewreservation['PICKUPQUANTITY'] == 0) {
								$LR = $r_viewreservation2['PICKUPQUANTITY'];
							} else {
								$LR = $r_viewreservation['PICKUPQUANTITY'];
							}
							?>
							<input name="pakai_air" type="text" class="form-control" id="pakai_air" value="<?= round($LR * $rcek['qty_order'], 2); ?>" placeholder="0.00" style="text-align: right;">
							<span class="input-group-addon">L</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="carry_over" class="col-sm-3 control-label">Carry Over</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="carry_over" type="text" style="text-align: right;" class="form-control" id="carry_over" value="<?= $carry_over; ?><?php echo str_replace("%", "", trim($row['USER25'])); ?>" placeholder="0.00">
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="benang" class="col-sm-3 control-label">Benang</label>
					<div class="col-sm-8">
						<input name="benang" type="text" class="form-control" id="benang" value="<?php echo $bng; ?>" placeholder="Benang">
					</div>
				</div>
				<div class="form-group">
					<label for="std_cok_wrn" class="col-sm-3 control-label">Standar Cocok Warna</label>
					<div class="col-sm-6">
						<input name="std_cok_wrn" type="text" class="form-control" id="std_cok_wrn" value="<?= $std_cck_warna; ?><?php if ($ssr['Flag'] == " 1") {
																																		echo "Original Color";
																																	} elseif ($ssr['Flag'] == "2") {
																																		echo "Color LD";
																																	} else {
																																		echo $ssr['OtherDesc'];
																																	} ?>" placeholder="Standar Cocok Warna">
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
					<label for="operator" class="col-sm-3 control-label">Operator </label>
					<div class="col-sm-3">
						<select name="operator" class="form-control" required>
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT nama FROM db_dying.tbl_staff WHERE jabatan='Operator' ORDER BY nama ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label class="col-sm-2 control-label">Kategori Resep </label>
					<div class="col-sm-3">
						<select name="kategori_resep" class="form-control">
							<option value="">Pilih</option>
							<option value="Setting Resep">Setting Resep</option>
							<option value="Resep Matching">Resep Matching</option>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="colorist" class="col-sm-3 control-label">Colorist </label>
					<div class="col-sm-3">
						<select name="colorist" class="form-control" required>
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT nama FROM db_dying.tbl_staff WHERE jabatan='Colorist' or jabatan='SPV' ORDER BY nama ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label for="colorist" class="col-sm-2 control-label">Kasih Resep </label>
					<div class="col-sm-3">
						<select name="kasih_resep" class="form-control">
							<option value="">Pilih</option>
							<?php
							$q_kasihresep = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_nama_colorist ORDER BY id ASC");
							while ($row_kasihresep = sqlsrv_fetch_array($q_kasihresep)) {
							?>
								<option value="<?= $row_kasihresep['nama_colorist']; ?>"><?= $row_kasihresep['nama_colorist']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="leader" class="col-sm-3 control-label">Leader </label>
					<div class="col-sm-3">
						<select name="leader" class="form-control" required>
							<option value="">Pilih</option>
							<?php
							$sqlKap = sqlsrv_query($con, "SELECT nama FROM db_dying.tbl_staff WHERE jabatan='Leader' ORDER BY nama ASC");
							while ($rK = sqlsrv_fetch_array($sqlKap)) {
							?>
								<option value="<?php echo $rK['nama']; ?>"><?php echo $rK['nama']; ?></option>
							<?php } ?>
						</select>
					</div>
					<label for="colorist" class="col-sm-2 control-label">ACC Resep </label>
					<div class="col-sm-3">
						<select name="acc_resep" class="form-control">
							<option value="">Pilih</option>
							<?php
							$q_accresep = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_nama_colorist ORDER BY id ASC");
							while ($row_accresep = sqlsrv_fetch_array($q_accresep)) {
							?>
								<option value="<?= $row_accresep['nama_colorist']; ?>"><?= $row_accresep['nama_colorist']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">No. Program</label>
					<div class="col-sm-3">
						<input name="no_program" type="text" class="form-control" id="no_program" value="" placeholder="No. Program">

					</div>
				</div>
				<div class="form-group">
					<label for="l_g" class="col-sm-3 control-label">L X Grm Aktual Dye</label>
					<div class="col-sm-2">
						<input name="lebar_a" type="text" class="form-control" id="lebar_a" value="" placeholder="0" required maxlength="2">
					</div>
					<div class="col-sm-2">
						<input name="grms_a" type="text" class="form-control" id="grms_a" value="" placeholder="0" required onChange="hitung();" maxlength="3">
					</div>
				</div>
				<div class="form-group">
					<label for="grm_fin" class="col-sm-3 control-label">L X Grm Aktual Fin</label>
					<div class="col-sm-2">
						<input name="lebar_fin" type="text" class="form-control" id="lebar_fin" value="" placeholder="0" maxlength="2">
					</div>
					<div class="col-sm-2">
						<input name="grm_fin" type="text" class="form-control" id="grm_fin" value="" placeholder="0" maxlength="3">
					</div>
				</div>
				<!-- <div class="form-group">
					<label for="grm_dye" class="col-sm-3 control-label">L X Grm Aktual Dye</label>
					<div class="col-sm-2">
						<input name="grm_dye" type="text" class="form-control" id="grm_dye" value="" placeholder="0">
					</div>
				</div> -->
				<!--  
					<div class="form-group">
							<label for="tgl_buat" class="col-sm-3 control-label">Jam Masuk Kain</label>
							<div class="col-sm-3">
							<div class="input-group">
								<input type="text" class="form-control timepicker" name="waktu_buat" id="waktu_buat" placeholder="00:00" required>				  
								<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
							</div>
						</div>	  
							<div class="col-sm-4">					  
									<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input name="tgl_buat" type="text" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="" required/>
					</div>
							</div>
								
					</div>
				-->
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">L:R</label>
					<div class="col-sm-2">
						<input name="l_r" type="text" class="form-control" id="l_r" value="<?php if ($nokk != "") {
																								echo "1:" . round($r_viewreservation['PICKUPQUANTITY'], 2);
																							} ?>" placeholder="L:R 1">
					</div>
					<div class="col-sm-2">
						<input name="l_r2" type="text" class="form-control" id="l_r2" value="<?php if ($nokk != "") {
																									echo "1:" . round($r_viewreservation2['PICKUPQUANTITY'], 2);
																								} ?>" placeholder="L:R 2">
					</div>
					<label for="gabung" class="col-sm-2 control-label">Gabung Celup</label>
					<div class="col-sm-2">
						<select name="gabung" class="form-control">
							<option value="">Pilih</option>
							<option value="ngekor">ngekor</option>
							<option value="beda lubang">beda lubang</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Cycle Time</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="cycle_time" type="text" class="form-control" id="cycle_time" value="" placeholder="0" style="text-align: right;">
							<span class="input-group-addon">dtk</span>
						</div>
					</div>
					<label for="masukkain" class="col-sm-2 control-label">Masuk Kain</label>
					<div class="col-sm-2">
						<select name="masukkain" class="form-control" required>
							<option value="">Pilih</option>
							<option value="satu kepala">Satu Kepala</option>
							<option value="dua kepala">Dua Kepala</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="rpm" class="col-sm-3 control-label">RPM</label>
					<div class="col-sm-2">
						<input name="rpm" type="text" class="form-control" id="rpm" value="" placeholder="0" style="text-align: right;">
					</div>
					<div class="col-sm-2">
						<input name="lb1" type="text" class="form-control" id="lb1" value="" placeholder="LB1" required onChange="hitung();">
					</div>
					<div class="col-sm-2">
						<input name="lb2" type="text" class="form-control" id="lb2" value="" placeholder="LB2" onChange="hitung();">
					</div>
					<div class="col-sm-2">
						<input name="lb3" type="text" class="form-control" id="lb3" value="" placeholder="LB3" onChange="hitung();">
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Tekanan</label>
					<div class="col-sm-2">
						<input name="tekanan" type="text" class="form-control" id="tekanan" value="" placeholder="0" style="text-align: right;">
					</div>
					<div class="col-sm-2">
						<input name="lb4" type="text" class="form-control" id="lb4" value="" placeholder="LB4" onChange="hitung();">
					</div>
					<div class="col-sm-2">
						<input name="lb5" type="text" class="form-control" id="lb5" value="" placeholder="LB5" onChange="hitung();">
					</div>
					<div class="col-sm-2">
						<input name="lb6" type="text" class="form-control" id="lb6" value="" placeholder="LB6" onChange="hitung();">
					</div>
				</div>
				<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">&empty; Nozzle</label>
					<div class="col-sm-3">
						<select name="nozzle" class="form-control" required>
							<option value="">Pilih</option>
							<?php
							$sqlNoz = sqlsrv_query($con, "SELECT nilai,satuan FROM db_dying.tbl_nozzle ORDER BY nilai ASC");
							while ($rN = sqlsrv_fetch_array($sqlNoz)) {
							?>
								<option value="<?php echo $rN['nilai']; ?>"><?php echo $rN['nilai']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-2">
						<input name="lb7" type="text" class="form-control" id="lb7" value="" placeholder="LB7" onChange="hitung();">
					</div>
					<div class="col-sm-2">
						<input name="lb8" type="text" class="form-control" id="lb8" value="" placeholder="LB8" onChange="hitung();">
					</div>
				</div>
				<div class="form-group">
					<label for="blower" class="col-sm-3 control-label">Blower</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="blower" type="text" class="form-control" id="blower" value="" placeholder="0" style="text-align: right;" required>
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="plaiter" class="col-sm-3 control-label">Plaiter</label>
					<div class="col-sm-3">
						<select name="plaiter" class="form-control" required>
							<option value="">Pilih</option>
							<option value="-">-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select>
					</div>
					<div class="col-sm-3">
						<input name="air_awal" type="text" class="form-control" id="air_awal" value="<?php if ($rCekMc['kode'] == "THEN") {
																											echo "0";
																										} ?>" placeholder="Air Awal" <?php if ($rCekMc['kode'] == "THEN") {
																																			echo "readonly";
																																		} else {
																																			echo "required";
																																		} ?> pattern=".*\S.*" style="text-align: right;" maxlength="12">
					</div>
				</div>
				<!--  
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH Cuci Bulu</label>
					<div class="col-sm-2">
								<input name="ph_cb" type="text" class="form-control" id="ph_cb" 
								value="" placeholder="0" style="text-align: right;">
							</div>				   
					</div>  
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Suhu Tes pH Cuci Bulu</label>
					<div class="col-sm-2">
								<div class="input-group">  
								<input name="suhu_cb" type="text" class="form-control" id="suhu_cb" 
								value="" placeholder="0" style="text-align: right;">
								<span class="input-group-addon">&deg;</span></div>  
							</div>				   
					</div>
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH Poly</label>
					<div class="col-sm-2">
								<input name="ph_poly" type="text" class="form-control" id="ph_poly" 
								value="" placeholder="0" style="text-align: right;">
							</div>				   
					</div>  
					<div class="form-group">
							<label for="a_dingin" class="col-sm-3 control-label">Suhu Tes pH Poly</label>
					<div class="col-sm-2">
								<div class="input-group">  
								<input name="suhu_poly" type="text" class="form-control" id="suhu_poly" 
								value="" placeholder="0" style="text-align: right">
								<span class="input-group-addon">&deg;</span></div>  
							</div>				   
					</div>
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH Cotton</label>
					<div class="col-sm-2">
								<input name="ph_cott" type="text" class="form-control" id="ph_cott" 
								value="" placeholder="0" style="text-align: right;">
							</div>				   
					</div>
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Suhu Tes pH Cotton</label>
					<div class="col-sm-2">
								<div class="input-group">  
								<input name="suhu_cott" type="text" class="form-control" id="suhu_cott" 
								value="" placeholder="0" style="text-align: right">
								<span class="input-group-addon">&deg;</span></div> 
							</div>				   
					</div>
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">Berat Jenis</label>
					<div class="col-sm-2">
								<input name="berat_jns" type="text" class="form-control" id="berat_jns" 
								value="" placeholder="0" style="text-align: right;">
							</div>				   
					</div>
					<div class="form-group">
					<label for="a_dingin" class="col-sm-3 control-label">pH Na<sub>2</sub>CO<sub>3</sub></label>
					<div class="col-sm-2">
								<input name="ph_naco" type="text" class="form-control" id="ph_naco" 
								value="" placeholder="0" style="text-align: right;">
							</div>				   
					</div>
				-->
				<div class="form-group">
					<label for="ket" class="col-sm-3 control-label">Catatan</label>
					<div class="col-sm-8">
						<textarea name="ket" class="form-control"><?php echo $ketsts; ?> <?php ?></textarea>
					</div>

				</div>
			</div>


			<input type="hidden" value="<?php if ($cek > 0) {
											echo $rcek['no_ko'];
										} else {
											echo $rKO['KONo'];
										} ?>" name="no_ko">
			<input type="hidden" value="<?php if ($cek > 0) {
											echo cekDesimal($rcek['target']);
										} else {
											echo cekDesimal($rKO['target']);
										} ?>" name="target">

		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-default pull-left" name="back" value="kembali" onClick="window.location='?p=Monitoring-Tempelan'">Kembali <i class="fa fa-arrow-circle-o-left"></i></button>
			<?php
			if ($_GET['nokk']) {
				if ($rcek['target'] == '0.00' or empty($rcek['target'])) {
					echo "<script>swal({
								title: 'Standart target harus di isi terlebih dahulu ! ',
								text: 'Klik Ok untuk input kembali',
								type: 'warning',
								allowOutsideClick: false, 
            					allowEscapeKey: false,    
								}).then((result) => {
									if (result.value) {
										window.location='index1.php?p=Schedule';
									}
								});
							</script>";
				}
			}
			?>
			<?php if ($cek1 > 0) {
				echo "<script>swal({
								title: 'No Kartu Sudah diinput dan belum selesai proses',
								text: 'Klik Ok untuk input kembali',
								type: 'warning',
								allowOutsideClick: false, 
            					allowEscapeKey: false,
								}).then((result) => {
								if (result.value) {
									window.location='index1.php?p=Form-Monitoring';
								}
								});</script>";
			} else if ($rcek['no_urut'] != "1" and $nokk != "") {
				echo "<script>swal({
							title: 'Harus No Urut `1` ',
							text: 'Klik Ok untuk input kembali',
							type: 'warning',
							allowOutsideClick: false, 
            				allowEscapeKey: false,
							}).then((result) => {
								if (result.value) {
									window.location='index1.php?p=Form-Monitoring';
								}
							});
						</script>";
			?>
			<?php } else { ?>
				<button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
			<?php } ?>

		</div>
		<!-- /.box-footer -->
	</div>
</form>
<div class="modal fade" id="DataAnalisa">
	<div class="modal-dialog ">
		<div class="modal-content">
			<form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Analisa Data Mesin Idle</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<div class="form-group">
						<label for="analisa1" class="col-md-3 control-label">Analisa</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="analisa1" name="analisa1" required>
							<span class="help-block with-errors"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<input type="submit" value="Simpan" name="simpan_analisa" id="simpan_analisa" class="btn btn-primary pull-right">
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php
if ($_POST['simpan_analisa'] == "Simpan") {
	$ket = isset($_POST['analisa1']) ? strtoupper(trim($_POST['analisa1'])) : null;
	$sql = "INSERT INTO db_dying.tbl_analisa_mesin_tunggu (analisa) VALUES (?)";
	$params = [$ket];
	$sqlData1 = sqlsrv_query($con, $sql, $params);
	if ($sqlData1) {
		echo "<script>swal({
					title: 'Data Telah Tersimpan',   
					text: 'Klik Ok untuk input data kembali',
					type: 'success',
					allowOutsideClick: false, 
            		allowEscapeKey: false,
					}).then((result) => {
					if (result.value) {
							window.location.href='?p=Form-Monitoring&nokk=" . $_GET['nokk'] . "';
						
					}
					});</script>";
	}

	if ($sqlData1 === false) {
		$errors = sqlsrv_errors();

		$msg = "";
		if ($errors !== null) {
			foreach ($errors as $err) {
				$msg .= "SQLSTATE: " . $err['SQLSTATE'] . "\n";
				$msg .= "Kode: " . $err['code'] . "\n";
				$msg .= "Pesan: " . $err['message'] . "\n\n";
			}
		}

		echo "
		<script>
			swal({
				title: 'Error SQL Server!',
				text: `" . addslashes($msg) . "`,
				icon: 'error',
			});
		</script>";

		exit; // stop proses agar tidak lanjut
	}
}
?>
<?php
if ($_POST['save'] == "save") {
	$warna = str_replace("'", "''", $_POST['warna']);
	$nowarna = str_replace("'", "''", $_POST['no_warna']);
	$jns = str_replace("'", "''", $_POST['jns_kain']);
	$po = str_replace("'", "''", $_POST['no_po']);
	$benang = str_replace("'", "''", $_POST['benang']);
	$lot = trim($_POST['lot']);
	$tglbuat = $_POST['tgl_buat'] . " " . $_POST['waktu_buat'];
	$note1 = str_replace("'", "''", $_POST['note_wt']);
	if (isset($_POST['note_wt'])) {
		// Retrieving each selected option 
		foreach ($note1 as $index => $subject1) {
			if ($index > 0) {
				$jk1 = $jk1 . "," . $subject1;
			} else {
				$jk1 = $subject1;
			}
		}
	}

	$sqlCekWaktu1 = sqlsrv_query($con, "SELECT TOP 1 
												th.tgl_buat as jam_stop,
												GETDATE() as jam_start
											FROM db_dying.tbl_hasilcelup th 
											INNER JOIN db_dying.tbl_montemp tm on th.id_montemp =tm.id
											INNER JOIN db_dying.tbl_schedule ts on tm.id_schedule =ts.id
											WHERE 
												ts.no_mesin ='" . $_POST['no_mc'] . "'
											ORDER BY 
												th.id DESC");
	$rcekW1 				= sqlsrv_fetch_array($sqlCekWaktu1);
	$awalP1  				= strtotime(formatDateTime($rcekW1['jam_stop'], 'H:i'));
	$akhirP1 				= strtotime(formatDateTime($rcekW1['jam_start'], 'H:i'));
	$diffP1  				= ($akhirP1 - $awalP1);
	$tjamP1  				= round($diffP1 / (60 * 60), 2);
	$tgljam 				= $_POST['jammasukkain'] . ' ' . $_POST['tglmasukkain'];
	list($t_jam, $t_menit) 	= explode(":", $_POST['target']);
    $total_menit 			= ($t_jam * 60) + $t_menit;
	$cycle_time 			= num($_POST['cycle_time']);
	// echo $cycle_time;
	// sqlsrv_query($con, "SELECT DATEADD(MINUTE, $total_menit, $tgljam) AS TGL");
	$sql = "SELECT DATEADD(MINUTE, ?, ?) AS TGL";
	$params = [$total_menit, $tgljam];

	$stmt = sqlsrv_query($con, $sql, $params);
	$tanggal_hitung = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$tgl_trgt 	= formatDateTime($tanggal_hitung['TGL'], "Y-m-d H:i:s");
	// $rpm 		= toNumericOrNull($_POST['rpm']);
	// $tekanan	= toNumericOrNull($_POST['tekanan']);
	// $tekanan	= ($_POST['tekanan']?''?NULL);
	$tekanan 	= is_numeric($_POST['tekanan']) ? $_POST['tekanan'] : null;
	$rpm     	= is_numeric($_POST['rpm'] ) ? $_POST['rpm'] : null;
	$tgl_masuk 	=  $_POST['jammasukkain']. " " . $_POST['tglmasukkain'];
	$pakai_air 	= is_numeric($_POST['pakai_air']) ? ceil($_POST['pakai_air']) : null;

	$sql = "INSERT INTO db_dying.tbl_montemp (
            id_schedule, nodemand, nokk, operator, colorist, leader, pakai_air,
            carry_over, shift, gramasi_a, lebar_a, pjng_kain, pjng_kain_perlubang,
            rol, bruto, nokk_legacy, g_shift, no_program, l_r, l_r_2,
            gabung_celup, cycle_time, lb1, lb2, lb3, lb4, lb5, lb6, lb7, lb8,
            rpm, tekanan, nozzle, benang, std_cok_wrn, ket, tgl_buat,
            tgl_target, blower, plaiter, air_awal, waktu_tunggu, note_wt,
            oper_shift, lebar_fin, grm_fin, masukkain, kategori_resep,
            kasih_resep, acc_resep, jammasukkain, tgl_update
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE()
        )";
	$params = [
				$_POST['id'], $_POST['demand'], $_POST['nokk'], $_POST['operator'], $_POST['colorist'], $_POST['leader'], $pakai_air,
				$_POST['carry_over'], $_POST['shift'], $_POST['grms_a'], $_POST['lebar_a'], $_POST['pjng_kain'], $_POST['pjng_kain_perlubang'],
				$_POST['qty3'], $_POST['qty4'], $_POST['nokk_legacy'], $_POST['g_shift'], $_POST['no_program'], $_POST['l_r'], $_POST['l_r2'],
				$_POST['gabung'], $_POST['cycle_time'], $_POST['lb1'], $_POST['lb2'], $_POST['lb3'], $_POST['lb4'], $_POST['lb5'], $_POST['lb6'], $_POST['lb7'], $_POST['lb8'],
				$rpm, 
				$tekanan,
				$_POST['nozzle'], $benang, $_POST['std_cok_wrn'], $_POST['ket'], $tgl_masuk,
				$tgl_trgt, $_POST['blower'], $_POST['plaiter'], $_POST['air_awal'], $tjamP1, $jk1,
				$_POST['oper_shift'], $_POST['lebar_fin'], $_POST['grm_fin'], $_POST['masukkain'], $_POST['kategori_resep'],
				$_POST['kasih_resep'], $_POST['acc_resep'], $tgl_masuk
			];
	// print_r($params);
    $sqlData = sqlsrv_query($con, $sql, $params);
	if ($sqlData) {
		$sqlD = sqlsrv_query($con, "UPDATE db_dying.tbl_schedule SET 
										status ='sedang jalan',
										tgl_update=GETDATE()
									WHERE 
										status='antri mesin' 
										and no_mesin='" . $rcek['no_mesin'] . "' 
										and no_urut='1' ");
		echo "<script>swal({
					title: 'Data Tersimpan',   
					text: 'Klik Ok untuk input data kembali',
					type: 'success',
					allowOutsideClick: false, 
            		allowEscapeKey: false,
					}).then((result) => {
					if (result.value) {
						
						window.location.href='?p=Monitoring-Tempelan'; 
					}
					});</script>";
	}
	if ($sqlData === false) {
		$errors = sqlsrv_errors();

		$msg = "";
		if ($errors !== null) {
			foreach ($errors as $err) {
				$msg .= "SQLSTATE: " . $err['SQLSTATE'] . "\n";
				$msg .= "Kode: " . $err['code'] . "\n";
				$msg .= "Pesan: " . $err['message'] . "\n\n";
			}
		}

		echo "
		<script>
			swal({
				title: 'Error SQL Server!',
				text: `" . addslashes($msg) . "`,
				icon: 'error',
			});
		</script>";

		exit; // stop proses agar tidak lanjut
	}
}
// echo 'sudah disini';
?>
<script>
	function roundToTwo(num) {
		return +(Math.round(num + "e+2") + "e-2");
	}

	function hitung() {
		if (document.forms['form1']['lebar_a'].value != "" && document.forms['form1']['grms_a'].value != "") {
			var brtKain = document.forms['form1']['qty4'].value;
			var lebar = document.forms['form1']['lebar_a'].value;
			var grms = document.forms['form1']['grms_a'].value;
			var lb1 = document.forms['form1']['lb1'].value;
			var lb2 = document.forms['form1']['lb2'].value;
			var lb3 = document.forms['form1']['lb3'].value;
			var lb4 = document.forms['form1']['lb4'].value;
			var lb5 = document.forms['form1']['lb5'].value;
			var lb6 = document.forms['form1']['lb6'].value;
			var lb7 = document.forms['form1']['lb7'].value;
			var lb8 = document.forms['form1']['lb8'].value;
			var m;
			if (lb1 > 0) {
				var _lb1 = 1;
			} else {
				var _lb1 = 0;
			}
			if (lb2 > 0) {
				var _lb2 = 1;
			} else {
				var _lb2 = 0;
			}
			if (lb3 > 0) {
				var _lb3 = 1;
			} else {
				var _lb3 = 0;
			}
			if (lb4 > 0) {
				var _lb4 = 1;
			} else {
				var _lb4 = 0;
			}
			if (lb5 > 0) {
				var _lb5 = 1;
			} else {
				var _lb5 = 0;
			}
			if (lb6 > 0) {
				var _lb6 = 1;
			} else {
				var _lb6 = 0;
			}
			if (lb7 > 0) {
				var _lb7 = 1;
			} else {
				var _lb7 = 0;
			}
			if (lb8 > 0) {
				var _lb8 = 1;
			} else {
				var _lb8 = 0;
			}
			m = roundToTwo((brtKain * 39.37 * 1000) / (lebar * grms));
			lb = (_lb1 + _lb2 + _lb3 + _lb4 + _lb5 + _lb6 + _lb7 + _lb8);
			m_lubang = roundToTwo((brtKain * 39.37 * 1000) / (lebar * grms) / lb);
			document.forms['form1']['pjng_kain'].value = m;
			document.forms['form1']['pjng_kain_perlubang'].value = m_lubang;
		}
	}

	function hitungp() {
		if (document.forms['form1']['lebar'].value != "" && document.forms['form1']['grms'].value != "") {
			var brtKain = document.forms['form1']['qty4'].value;
			var lebar = document.forms['form1']['lebar'].value;
			var grms = document.forms['form1']['grms'].value;
			var m;
			m = roundToTwo((brtKain * 39.37 * 1000) / (lebar * grms));
			document.forms['form1']['pjng_kain'].value = m;
		}
	}
</script>