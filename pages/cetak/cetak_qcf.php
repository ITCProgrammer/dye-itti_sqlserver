<?php
//$lReg_username=$_SESSION['labReg_username'];
//session_start();
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
//--
$idkk = $_REQUEST['idkk'];
$act = $_GET['g'];
$sqlbg = mysqli_query($con, "select * from tbl_schedule where id='$_GET[ids]'");
$rowbg = mysqli_fetch_array($sqlbg);
//-
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- <link href="styles_cetak.css" rel="stylesheet" type="text/css"> -->
	<title>Cetak Form Tempelan Sample Celup</title>
	<script>
		// set portrait orientation

		jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);

		// set top margins in millimeters
		jsPrintSetup.setOption('marginTop', 0);
		jsPrintSetup.setOption('marginBottom', 0);
		jsPrintSetup.setOption('marginLeft', 0);
		jsPrintSetup.setOption('marginRight', 0);

		// set page header
		jsPrintSetup.setOption('headerStrLeft', '');
		jsPrintSetup.setOption('headerStrCenter', '');
		jsPrintSetup.setOption('headerStrRight', '');

		// set empty page footer
		jsPrintSetup.setOption('footerStrLeft', '');
		jsPrintSetup.setOption('footerStrCenter', '');
		jsPrintSetup.setOption('footerStrRight', '');

		// clears user preferences always silent print value
		// to enable using 'printSilent' option
		jsPrintSetup.clearSilentPrint();

		// Suppress print dialog (for this context only)
		jsPrintSetup.setOption('printSilent', 1);

		// Do Print 
		// When print is submitted it is executed asynchronous and
		// script flow continues after print independently of completetion of print process! 
		jsPrintSetup.print();

		window.addEventListener('load', function() {
			var rotates = document.getElementsByClassName('rotate');
			for (var i = 0; i < rotates.length; i++) {
				rotates[i].style.height = rotates[i].offsetWidth + 'px';
			}
		});
		// next commands
	</script>
	<style>
		body,
		td,
		th {
			/*font-family: Courier New, Courier, monospace; */
			font-family: sans-serif, Roman, serif;
		}

		pre {
			font-family: sans-serif, Roman, serif;
			clear: both;
			margin: 0px auto 0px;
			padding: 0px;
			white-space: pre-wrap;
			/* Since CSS 2.1 */
			white-space: -moz-pre-wrap;
			/* Mozilla, since 1999 */
			white-space: -pre-wrap;
			/* Opera 4-6 */
			white-space: -o-pre-wrap;
			/* Opera 7 */
			word-wrap: break-word;

		}

		body:before {
			<?php
			if ($rowbg['kk_kestabilan'] == '1') {
			?>content: 'KK KESTABILAN';
			<?php } else { ?>content: '';
			<?php } ?>position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			z-index: -1;

			color: #d0d0d0;
			font-size: 100px;
			font-weight: 500px;
			display: grid;
			justify-content: center;
			align-content: center;
			opacity: 0.3;
			transform: rotate(-45deg);
		}

		body {
			margin: 0px auto 0px;
			padding: 2px;
			font-size: 8px;
			color: #000;
			width: 98%;
			background-position: top;
			background-color: #fff;
		}

		.table-list1 {
			clear: both;
			text-align: left;
			border-collapse: collapse;
			margin: 0px 0px 5px 0px;
		}

		.table-list1 td {
			color: #333;
			font-size: 11px;
			border-color: #fff;
			border-collapse: collapse;
			vertical-align: center;
			padding: 1px 3px;
			border-bottom: 1px #000000 solid;
			border-top: 1px #000000 solid;
			border-left: 1px #000000 solid;
			border-right: 1px #000000 solid;
		}
	</style>
</head>

<body>
	<?php
	if ($_GET['no'] != '') {
		$ket .= " AND ID_NO='$_GET[no]' ";
	} else {
		$ket .= "";
	}
	//$sqlc="select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25 from ticket_title where YARN='$idkk' ".$ket." order by createtime Desc";
	//--lot
	//$qryc=sqlsrv_query($conn1,$sqlc, array(), array("Scrollable"=>"static"));

	//$countdata=sqlsrv_num_rows($qryc);

	//if ($countdata > 0)
	//{
	date_default_timezone_set('Asia/Jakarta');

// 	$tglsvr = sqlsrv_query($conn1, "select CONVERT(VARCHAR(10),GETDATE(),105) AS  tgk");
// 	$sr = sqlsrv_fetch_array($tglsvr);
// 	$sqls = sqlsrv_query($conn, "select processcontrolJO.SODID,salesorders.ponumber,processcontrol.productid,salesorders.customerid,joborders.documentno,
// salesorders.buyerid,processcontrolbatches.lotno,productcode,productmaster.hangerno,productmaster.color,colorno,description,weight,cuttablewidth from Joborders 
// left join processcontrolJO on processcontrolJO.joid = Joborders.id
// left join salesorders on soid= salesorders.id
// left join processcontrol on processcontrolJO.pcid = processcontrol.id
// left join processcontrolbatches on processcontrolbatches.pcid = processcontrol.id
// left join productmaster on productmaster.id= processcontrol.productid
// left join productpartner on productpartner.productid= processcontrol.productid
// where processcontrolbatches.documentno='$idkk'");
// 	$ssr = sqlsrv_fetch_array($sqls);
// 	$lgn1 = sqlsrv_query($conn, "select partnername from partners where id='$ssr[customerid]'");
// 	$ssr1 = sqlsrv_fetch_array($lgn1);
// 	$lgn2 = sqlsrv_query($conn, "select partnername from partners where id='$ssr[buyerid]'");
// 	$ssr2 = sqlsrv_fetch_array($lgn2);
// 	$itm = sqlsrv_query($conn, "select colorcode,color,productcode from productpartner where productid='$ssr[productid]' and partnerid='$ssr[customerid]'");
// 	$itm2 = sqlsrv_fetch_array($itm);
	//$row=sqlsrv_fetch_array($qryc);
	//
// 	$sql = sqlsrv_query($conn, "select stockmovement.dono,stockmovement.documentno as no_doku,processcontrolbatches.documentno,lotno,customerid,
// 	processcontrol.productid ,processcontrol.id as pcid, 
//   sum(stockmovementdetails.weight) as berat,
//   count(stockmovementdetails.weight) as roll,processcontrolbatches.dated as tgllot
//    from stockmovement 
// LEFT join stockmovementdetails on StockMovement.id=stockmovementdetails.StockmovementID
// left join processcontrolbatches on processcontrolbatches.id=stockmovement.pcbid
// left join processcontrol on processcontrol.id=processcontrolbatches.pcid



// where wid='12' and processcontrolbatches.documentno='$idkk' and (transactiontype='7' or transactiontype='4')
// group by stockmovement.DocumentNo,processcontrolbatches.DocumentNo,processcontrolbatches.LotNo,stockmovement.dono,
// processcontrol.CustomerID,processcontrol.ProductID,processcontrol.ID,processcontrolbatches.Dated") or die("gagal");
// 	$c = 0;
// 	$r = sqlsrv_fetch_array($sql);
// 	if ($r['documentno'] != '') {
// 		$dated = $r['tgllot']->format('Y-m-d H:i:s');
// 	}
// 	$sqlkko = sqlsrv_query($conn, "select SODID from knittingorders  
// 	where knittingorders.Kono='$r[dono]'") or die("gagal");
// 	$rkko = sqlsrv_fetch_array($sqlkko);
// 	$sqlkko1 = sqlsrv_query($conn, "select joid,productid from processcontroljo  
// 	where sodid='$rkko[SODID]'") or die("gagal");
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
// 	where id='$r[customerid]'") or die("gagal");
// 	$r2 = sqlsrv_fetch_array($sql2);
// 	$sql3 = sqlsrv_query($conn, "select Kono,joid from processcontroljo 
// 	where pcid='$r[pcid]'") or die("gagal");
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
// 	where id='$r4[supplierid]'") or die("gagal");
// 	$r5 = sqlsrv_fetch_array($sql5);
// 	if ($r3['joid'] != '') {
// 		$jno = $r3['joid'];
// 	} else {
// 		$jno = $rkko1['joid'];
// 	}
// 	$sql6 = sqlsrv_query($conn, "select documentno,soid from joborders 
// 	where id='$jno'") or die("gagal");
// 	$r6 = sqlsrv_fetch_array($sql6);
// 	$sql8 = sqlsrv_query($conn, "select customerid from salesorders where id='$r6[soid]'") or die("gagal");
// 	$r8 = sqlsrv_fetch_array($sql8);
// 	$sql9 = sqlsrv_query($conn, "select partnername from partners where id='$r8[customerid]'") or die("gagal");
// 	$r9 = sqlsrv_fetch_array($sql9);
// 	$sql10 = sqlsrv_query($conn, "select id,productid from kodetails where koid='$r4[id]'") or die("gagal");
// 	$r10 = sqlsrv_fetch_array($sql10);
// 	$sql11 = sqlsrv_query($conn, "select productnumber from productmaster where id='$r10[productid]'") or die("gagal");
// 	$r11 = sqlsrv_fetch_array($sql11);


// 	$s4 = sqlsrv_query($conn, "select KOdetails.id as KODID,productmaster.id as BOMID ,KnittingOrders.SupplierID,TM.dbo.Partners.PartnerName,ProductNumber,CustomerID,SODID,KnittingOrders.ID as KOID,SalesOrders.ID as SOID from 
// (TM.dbo.KnittingOrders 
// left join TM.dbo.SODetails on TM.dbo.SODetails.ID= TM.dbo.KnittingOrders.SODID
// left join TM.dbo.KODetails on TM.dbo.KODetails.KOid= TM.dbo.KnittingOrders.ID
// left join TM.dbo.Partners on TM.dbo.Partners.ID= TM.dbo.KnittingOrders.SupplierID)
// left join TM.dbo.ProductMaster on TM.dbo.ProductMaster.ID= TM.dbo.KODetails.ProductID
// left join TM.dbo.SalesOrders on TM.dbo.SalesOrders.ID= TM.dbo.SODetails.SOID
// 		where KONO='$kno'");
// 	$as7 = sqlsrv_fetch_array($s4);
// 	$sql12 = sqlsrv_query($conn, "select SODetailsBom.ProductID from SODetailsBom where SODID='$as7[SODID]' and KODID='$as7[KODID]' and Parentproductid='$as7[BOMID]' order by ID", array(), array("Scrollable" => "static"));
// 	$sql14 = sqlsrv_query($conn, "select  count(lotno)as jmllot from processcontrolbatches where pcid='$r[pcid]' and dated='$dated'");
// 	$lt = sqlsrv_fetch_array($sql14);
// 	$ai = sqlsrv_num_rows($sql12);
// 	$sql15 = sqlsrv_query($conn, "select Partnername from TM.dbo.Partners where TM.dbo.Partners.ID='$as7[CustomerID]'");
// 	$as8 = sqlsrv_fetch_array($sql15);
// 	$i = 0;



	/*do{
	$as5=sqlsrv_fetch_array($sql12);
	$sql13=sqlsrv_query("select Description from  ProductMaster where ID='$as5[ProductID]'");
	$as6=sqlsrv_fetch_array($sql13);
	$ar[$i]=$as6['Description'];

$i++;
}while($ai>=$i);
$jb1=$ar[0];
$jb2=$ar[1];
$jb3=$ar[2];
$jb4=$ar[3];
if($ai<2){$jb1=$ar[0];
$jb2='';
$jb3='';
}*/
// 	$bng11 = sqlsrv_query($conn, "SELECT CAST(SODetailsAdditional.Note AS NVARCHAR(255)) as note from Joborders left join processcontrolJO on processcontrolJO.joid = Joborders.id
// left join SODetailsAdditional on processcontrolJO.sodid=SODetailsAdditional.sodid
// WHERE  JobOrders.documentno='$ssr[documentno]' and processcontrolJO.pcid='$r[pcid]'");
// 	$r3 = sqlsrv_fetch_array($bng11);
	//
	$sqlsmp = mysqli_query($con, "select * from tbl_schedule where id='$_GET[ids]'");
	$rowsmp = mysqli_fetch_array($sqlsmp);
	$sqlsmp1 = mysqli_query($con, "select * from tbl_montemp where id='$_GET[idm]'");
	$rowsmp1 = mysqli_fetch_array($sqlsmp1);
	if ($rowsmp['kapasitas'] > 0) {
		$loading = round($rowsmp1['bruto'] / $rowsmp['kapasitas'], 4) * 100;
	}
	?>
	<?php
	$demandno = $rowsmp1['demanderp'];
	// $sqlDB2="SELECT TRIM(PRODUCTIONDEMAND.SUBCODE03) AS SUBCODE03, TRIM(PRODUCTIONDEMAND.SUBCODE05) AS SUBCODE05 FROM PRODUCTIONDEMAND PRODUCTIONDEMAND WHERE PRODUCTIONDEMAND.CODE='$rowsmp1[demanderp]'";
	$stmt = db2_exec($conn2, "SELECT TRIM(PRODUCTIONDEMAND.SUBCODE03) AS SUBCODE03, TRIM(PRODUCTIONDEMAND.SUBCODE05) AS SUBCODE05 FROM PRODUCTIONDEMAND PRODUCTIONDEMAND WHERE PRODUCTIONDEMAND.CODE='$demandno'");
	$rowdb2 = db2_fetch_assoc($stmt);
	$q_lot		= db2_exec($conn2, "SELECT * FROM ITXVIEWKK WHERE PRODUCTIONDEMANDCODE = '$rowsmp1[nodemand]'");
	$d_lot		= db2_fetch_assoc($q_lot);
	?>

	<table width="100%" border="1" class="table-list1">
		<tr>
			<td width="15%" rowspan="3" align="center"><img src="logo.jpg" width="50" height="50" /></td>
			<td width="56%" rowspan="3" valign="middle" align="center"><strong>
					<font size="+1">FORM TEMPELAN SAMPLE CELUP</font>
				</strong></td>
			<td width="29%">
				<pre>No. Form		: FW - 12 - DYE - 01</pre>
			</td>
		</tr>
		<tr>
			<td>
				<pre>No. Revisi	: 10</pre>
			</td>
		</tr>
		<tr>
			<td>
				<pre>Tgl. Terbit	: 02 Agustus 2022</pre>
			</td>
		</tr>
	</table>
	<table width="100%" border="" class="table-list1">
		<tr height="10 cm">
			<td colspan="4">
				<pre>Nomor KK	: <?php echo $_GET['idkk']; ?></pre>
			</td>
			<td colspan="2">
				<pre>Tanggal	: <?php if ($rowsmp['tgl_buat'] == '') {
										echo date("d-m-Y", strtotime($rowsmp['tgl_update']));
									} else {
										echo date("d-m-Y", strtotime($rowsmp['tgl_buat']));
									} ?></pre>
			</td>
			<td colspan="2">
				<pre>No Mesin	: <?php echo $rowsmp['no_mesin']; ?></pre>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<pre>Pelanggan	: <?php if ($ssr1['partnername'] != "") {
										echo strtoupper($ssr1['partnername'] . "/" . $ssr2['partnername']);
									} else {
										echo $rowsmp['langganan'];
									} ?></pre>
			</td>
			<td>
				<pre>Lot		: <?php echo $rowsmp['lot']; ?> | LOT di ERP :<?= $d_lot['LOT']; ?></pre>
			</td>
			<td>Fin : <?php echo $rowsmp1['grm_fin']; ?></td>
			<td colspan="2">
				<pre>No. Program : <?php echo $rowsmp1['no_program']; ?><?php
																		// $potb = sqlsrv_query($conn, "select PONumber from sodetailsadditional where sodid='$ssr[SODID]'") or die("gagal");
																		// $rpotb = sqlsrv_fetch_array($potb); 
																		?></pre>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<pre>No. PO		: <?php if ($rpotb['PONumber'] != "") {
											echo strtoupper($rpotb['PONumber']);
										} else {
											echo $rowsmp['po'];
										} ?></pre>
			</td>
			<td>
				<pre>Lebar	: <?php echo number_format($ssr['cuttablewidth']); ?></pre>
			</td>
			<td>Dye: <?php echo $rowsmp1['grm_dye']; ?></td>
			<td colspan="2">
				<pre>Masuk Kain Jam 	: <?php if ($rowsmp1['tgl_buat'] != "") {
												echo date('H:i', strtotime($rowsmp1['tgl_buat']));
											} ?></pre>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<pre>No. Order	: <?php if ($ssr['documentno'] != "") {
										echo strtoupper($ssr['documentno']);
									} else {
										echo $rowsmp['no_order'];
									} ?></pre>
			</td>
			<td>
				<pre>Gramasi	: <?php echo number_format($ssr['weight']); ?></pre>
			</td>
			<td align="right"><?php if ($rowsmp1['grm_fin'] > 0 and $rowsmp1['grm_dye'] > 0) {
									echo round($rowsmp1['grm_dye'] / $rowsmp1['grm_fin'], 2);
								} ?> %</td>
			<td colspan="2">
				<pre>Benang			: <font size="-7"><?php echo strtoupper(substr(htmlentities($r3['note'], ENT_QUOTES), 0, 30)); ?></font></pre>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<pre>No. Warna	: <?php if ($ssr['colorno'] != "") {
										echo strtoupper($ssr['colorno']);
									} else {
										echo $rowsmp['no_warna'];
									} ?> <?php if ($rowsmp1['demanderp'] != '') {
																																			echo " ( " . $rowdb2['SUBCODE03'] . "/" . $rowdb2['SUBCODE05'] . " ) ";
																																		} ?></pre>
			</td>
			<td colspan="2">
				<pre>Roll		: <?php echo $rowsmp1['rol']; ?></pre>
			</td>
			<td colspan="2" rowspan="2" valign="top">
				<font size="-7"><?php echo strtoupper(substr(htmlentities($r3['note'], ENT_QUOTES), 30, 300)); ?></font>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<pre>Warna		: <?php if ($ssr['color'] != "") {
										echo strtoupper($ssr['color']);
									} else {
										echo $rowsmp['warna'];
									} ?></pre>
			</td>
			<td colspan="2">
				<pre>Quantity	: <?php echo $rowsmp1['bruto']; ?></pre>
			</td>
		</tr>
		<tr>
			<td colspan="6" align="left" valign="top">
				<pre>Jenis Kain	: <?php if ($ssr['productcode'] != "" and $ssr['buyerid'] == "109") {
											echo strtoupper($ssr['productcode'] . "(" . $ssr['hangerno'] . ") / " . $ssr['description']);
										} else if ($ssr['productcode'] != "" and $ssr['buyerid'] != "109") {
											echo strtoupper($ssr['productcode'] . " / " . $ssr['description']);
										} else {
											echo $rowsmp['no_item'] . "/" . $rowsmp['jenis_kain'];
										} ?></pre>
			</td>
			<td colspan="2" align="left" valign="top">Standar Cocok Warna :<br /> <?php echo strtoupper($rowsmp1['std_cok_wrn']); ?><br /> Prod. Order: <?php echo $rowsmp1['nokk']; ?><br />Prod. Demand: <?php echo $rowsmp1['nodemand']; ?></td>
		</tr>
		<tr>
			<td width="9%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td width="9%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td width="17%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td width="8%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td width="12%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td width="10%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
			<td width="10%" align="left" valign="top" style="border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
		</tr>
	</table>
	
	<?php
		echo date("d-m-Y H:i:s", strtotime($rowsmp1['tgl_buat']));
	//} 
	?>
	<script>
		alert('cetak');
		window.print();
	</script>
		<img alt="testing" src="barcode.php?text=<?= $rowsmp1['nokk']; ?>" />

</body>

</html>