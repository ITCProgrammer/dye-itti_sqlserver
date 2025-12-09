<?php
//$lReg_username=$_SESSION['labReg_username'];
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
  <!--<link href="styles_monitor.css" rel="stylesheet" type="text/css">-->
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

    body {
      margin: 0px auto 0px;
      padding: 0.5px;
      font-size: 8px;
      color: #000;
      width: 98%;
      background-position: top;
      background-color: #fff;
    }

    .table-list {
      clear: both;
      text-align: left;
      border-collapse: collapse;
      margin: 0px 0px 5px 0px;
      background: #fff;
    }

    .table-list td {
      color: #333;
      font-size: 12px;
      border-color: #fff;
      border-collapse: collapse;
      vertical-align: center;
      padding: 0px 1px;
      border-bottom: 1px #000000 solid;
      border-left: 1px #000000 solid;
      border-right: 1px #000000 solid;


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

    .table-list1 {
      clear: both;
      text-align: left;
      border-collapse: collapse;
      margin: 0px 0px 3px 0px;

    }

    .table-list1 td {
      color: #333;
      font-size: 11px;
      border-color: #fff;
      border-collapse: collapse;
      vertical-align: center;
      padding: 0px 1px;
      border-bottom: 1px #000000 solid;
      border-top: 1px #000000 solid;
      border-left: 1px #000000 solid;
      border-right: 1px #000000 solid;


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
  </style>
</head>

<body>
  <?php
  // $sqlc="select convert(char(10),CreateTime,103) as TglBonResep,convert(char(10),CreateTime,108) as JamBonResep,ID_NO,COLOR_NAME,PROGRAM_NAME,PRODUCT_LOT,VOLUME,PROGRAM_CODE,YARN as NoKK,TOTAL_WT,USER25 from ticket_title where ID_NO='$_GET[no]' order by createtime Desc";
  // $qryc=sqlsrv_query($conn1,$sqlc, array(), array("Scrollable"=>"buffered"));

  // $countdata=sqlsrv_num_rows($qryc);

  // if ($countdata > 0)
  // {
  date_default_timezone_set('Asia/Jakarta');

  $tglsvr = sqlsrv_query($conn1, "select CONVERT(VARCHAR(10),GETDATE(),105) AS  tgk");
  $sr = sqlsrv_fetch_array($tglsvr);
  $sqls = sqlsrv_query($conn, "select processcontrolJO.SODID,salesorders.ponumber,processcontrol.productid,salesorders.customerid,joborders.documentno,
salesorders.buyerid,processcontrolbatches.lotno,productcode,productmaster.color,colorno,description,weight,cuttablewidth from Joborders 
left join processcontrolJO on processcontrolJO.joid = Joborders.id
left join salesorders on soid= salesorders.id
left join processcontrol on processcontrolJO.pcid = processcontrol.id
left join processcontrolbatches on processcontrolbatches.pcid = processcontrol.id
left join productmaster on productmaster.id= processcontrol.productid
left join productpartner on productpartner.productid= processcontrol.productid
where processcontrolbatches.documentno='$idkk'");
  $ssr = sqlsrv_fetch_array($sqls);
  $lgn1 = sqlsrv_query($conn, "select partnername from partners where id='$ssr[customerid]'");
  $ssr1 = sqlsrv_fetch_array($lgn1);
  $lgn2 = sqlsrv_query($conn, "select partnername from partners where id='$ssr[buyerid]'");
  $ssr2 = sqlsrv_fetch_array($lgn2);
  $itm = sqlsrv_query($conn, "select colorcode,color,productcode from productpartner where productid='$ssr[productid]' and partnerid='$ssr[customerid]'");
  $itm2 = sqlsrv_fetch_array($itm);
  //$row=sqlsrv_fetch_array($qryc);
  //
  $sql = sqlsrv_query($conn, "select stockmovement.dono,stockmovement.documentno as no_doku,processcontrolbatches.documentno,lotno,customerid,
	processcontrol.productid ,processcontrol.id as pcid, 
  sum(stockmovementdetails.weight) as berat,
  count(stockmovementdetails.weight) as roll,processcontrolbatches.dated as tgllot
   from stockmovement 
LEFT join stockmovementdetails on StockMovement.id=stockmovementdetails.StockmovementID
left join processcontrolbatches on processcontrolbatches.id=stockmovement.pcbid
left join processcontrol on processcontrol.id=processcontrolbatches.pcid



where wid='12' and processcontrolbatches.documentno='$idkk' and (transactiontype='7' or transactiontype='4')
group by stockmovement.DocumentNo,processcontrolbatches.DocumentNo,processcontrolbatches.LotNo,stockmovement.dono,
processcontrol.CustomerID,processcontrol.ProductID,processcontrol.ID,processcontrolbatches.Dated") or die("gagal");
  $c = 0;
  $r = sqlsrv_fetch_array($sql);
  if ($r['tgllot'] != "") {
    $dated = $r['tgllot']->format('Y-m-d H:i:s');
  } else {
    $dated = "";
  }
  $sqlkko = sqlsrv_query($conn, "select SODID from knittingorders  
	where knittingorders.Kono='$r[dono]'") or die("gagal");
  $rkko = sqlsrv_fetch_array($sqlkko);
  $sqlkko1 = sqlsrv_query($conn, "select joid,productid from processcontroljo  
	where sodid='$rkko[SODID]'") or die("gagal");
  $rkko1 = sqlsrv_fetch_array($sqlkko1);
  if ($r['productid'] != '') {
    $kno1 = $r['productid'];
  } else {
    $kno1 = $rkko1['productid'];
  }
  $sql1 = sqlsrv_query($conn, "select hangerno,color from  productmaster
	where id='$kno1'") or die("gagal");
  $r1 = sqlsrv_fetch_array($sql1);
  $sql2 = sqlsrv_query($conn, "select partnername from Partners
	where id='$r[customerid]'") or die("gagal");
  $r2 = sqlsrv_fetch_array($sql2);
  $sql3 = sqlsrv_query($conn, "select Kono,joid from processcontroljo 
	where pcid='$r[pcid]'") or die("gagal");
  $r3 = sqlsrv_fetch_array($sql3);
  if ($r3['Kono'] != '') {
    $kno = $r3['Kono'];
  } else {
    $kno = $r['dono'];
  }
  $sql4 = sqlsrv_query($conn, "select CAST(TM.dbo.knittingorders.[Note] AS VARCHAR(8000))as note,id,supplierid from knittingorders 
	where kono='$kno'") or die("gagal");
  $r4 = sqlsrv_fetch_array($sql4);
  $sql5 = sqlsrv_query($conn, "select partnername from partners 
	where id='$r4[supplierid]'") or die("gagal");
  $r5 = sqlsrv_fetch_array($sql5);
  if ($r3['joid'] != '') {
    $jno = $r3['joid'];
  } else {
    $jno = $rkko1['joid'];
  }
  $sql6 = sqlsrv_query($conn, "select documentno,soid from joborders 
	where id='$jno'") or die("gagal");
  $r6 = sqlsrv_fetch_array($sql6);
  $sql8 = sqlsrv_query($conn, "select customerid from salesorders where id='$r6[soid]'") or die("gagal");
  $r8 = sqlsrv_fetch_array($sql8);
  $sql9 = sqlsrv_query($conn, "select partnername from partners where id='$r8[customerid]'") or die("gagal");
  $r9 = sqlsrv_fetch_array($sql9);
  $sql10 = sqlsrv_query($conn, "select id,productid from kodetails where koid='$r4[id]'") or die("gagal");
  $r10 = sqlsrv_fetch_array($sql10);
  $sql11 = sqlsrv_query($conn, "select productnumber from productmaster where id='$r10[productid]'") or die("gagal");
  $r11 = sqlsrv_fetch_array($sql11);


  $s4 = sqlsrv_query($conn, "select KOdetails.id as KODID,productmaster.id as BOMID ,KnittingOrders.SupplierID,TM.dbo.Partners.PartnerName,ProductNumber,CustomerID,SODID,KnittingOrders.ID as KOID,SalesOrders.ID as SOID from 
(TM.dbo.KnittingOrders 
left join TM.dbo.SODetails on TM.dbo.SODetails.ID= TM.dbo.KnittingOrders.SODID
left join TM.dbo.KODetails on TM.dbo.KODetails.KOid= TM.dbo.KnittingOrders.ID
left join TM.dbo.Partners on TM.dbo.Partners.ID= TM.dbo.KnittingOrders.SupplierID)
left join TM.dbo.ProductMaster on TM.dbo.ProductMaster.ID= TM.dbo.KODetails.ProductID
left join TM.dbo.SalesOrders on TM.dbo.SalesOrders.ID= TM.dbo.SODetails.SOID
		where KONO='$kno'");
  $as7 = sqlsrv_fetch_array($s4);
  $sql12 = sqlsrv_query($conn, "select SODetailsBom.ProductID from SODetailsBom where SODID='$as7[SODID]' and KODID='$as7[KODID]' and Parentproductid='$as7[BOMID]' order by ID", array(), array("Scrollable" => "buffered"));
  $sql14 = sqlsrv_query($conn, "select count(lotno)as jmllot from processcontrolbatches where pcid='$r[pcid]' and dated='$dated'");
  $lt = sqlsrv_fetch_array($sql14);
  $ai = sqlsrv_num_rows($sql12);
  $sql15 = sqlsrv_query($conn, "select Partnername from TM.dbo.Partners where TM.dbo.Partners.ID='$as7[CustomerID]'");
  $as8 = sqlsrv_fetch_array($sql15);
  $i = 0;



  do {
    $as5 = sqlsrv_fetch_array($sql12);
    $sql13 = sqlsrv_query($conn, "select ShortDescription from  ProductMaster where ID='$as5[ProductID]'");
    $as6 = sqlsrv_fetch_array($sql13);
    $ar[$i] = $as6['ShortDescription'];

    $i++;
  } while ($ai >= $i);
  $jb1 = $ar[0];
  $jb2 = $ar[1];
  $jb3 = $ar[2];
  $jb4 = $ar[3];
  if ($ai < 2) {
    $jb1 = $ar[0];
    $jb2 = '';
    $jb3 = '';
  }

  //
  $sqlsmp1 = mysqli_query($con, "SELECT * FROM tbl_schedule where id='$_GET[ids]'");
  $rowmt = mysqli_fetch_array($sqlsmp1);
  $target = explode(".", $rowmt['target']);
  $jamtarget = $target[0];
  $menittarget = $target[1];
  if ($menittarget == '5') {
    $mintarget = 30;
  } else {
    $mintarget = 0;
  }
  $sqlsmp2 = mysqli_query($con, "SELECT * FROM tbl_montemp where id='$_GET[idm]'");
  $rowmt2 = mysqli_fetch_array($sqlsmp2);
  if ($rowmt['kapasitas'] > 0) {
    $loading = round($rowmt2['bruto'] / $rowmt['kapasitas'], 4) * 100;
  }
  $q_lot		= db2_exec($conn2, "SELECT * FROM ITXVIEWKK WHERE PRODUCTIONDEMANDCODE = '$rowmt[nodemand]'");
	$d_lot		= db2_fetch_assoc($q_lot);
  ?>
  <table width="100%" border="1" class="table-list1">
    <tr>
      <td width="11%" rowspan="3" align="center"><img src="logo.jpg" width="36" height="36" /></td>
      <td width="61%" rowspan="3" valign="middle" align="center"><strong>
          <font size="+1">FORM MONITORING PROSES CELUP</font>
        </strong></td>
      <td width="12%" style="border-right:0px #000000 solid;">
        <pre>No. Form</pre>
      </td>
      <td width="16%" style="border-left:0px #000000 solid;">
        <pre>: FW - 14 - DYE - 02</pre>
      </td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>No. Revisi</pre>
      </td>
      <td style="border-left:0px #000000 solid;">
        <pre>: 09</pre>
      </td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>Tgl. Terbit</pre>
      </td>
      <td style="border-left:0px #000000 solid;">
        <pre>: 02 Agustus 2022</pre>
      </td>
    </tr>
  </table>
  <table width="100%" border="" class="table-list1">
    <tr height="10 cm">
      <td style="border-right:0px #000000 solid;">
        <pre>Nomor Production Order</pre>
      </td>
      <td style="border-left:0px #000000 solid;">: <?= $rowmt['nokk']; ?></td>
      <td colspan="2" style="border-right:0px #000000 solid;">
        <pre>Nomor Production Demand</pre>
      </td>
      <td colspan="" style="border-left:0px #000000 solid;">: <?= $rowmt['nodemand']; ?></td>
      <td style="border-right:0px #000000 solid;">
        <pre>Langganan</pre>
      </td>
      <td colspan="2" style="border-left:0px #000000 solid;">: <?php if ($ssr1['partnername'] != "") {
                                                                  echo strtoupper($ssr1['partnername'] . "/" . $ssr2['partnername']);
                                                                } else {
                                                                  echo $rowmt['langganan']. "/". $rowmt['buyer'];
                                                                } ?></td>
      <td width="10%" style="border-right:0px #000000 solid;">
        <pre>Tanggal</pre>
      </td>
      <td colspan="2" style="border-left:0px #000000 solid;">: <?php if ($rowmt2['tgl_buat'] != "") {
                                                                  echo date("d-m-Y", strtotime($rowmt2['tgl_buat']));
                                                                } ?></td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>No. Order</pre>
      </td>
      <td colspan="4" style="border-left:0px #000000 solid;">: <?php if ($ssr['documentno'] != "") {
                                                                  echo strtoupper($ssr['documentno']);
                                                                } else {
                                                                  echo $rowmt['no_order'];
                                                                } ?></td>
      <td style="border-right:0px #000000 solid;">
        <pre>No. Item</pre>
      </td>
      <td colspan="2" style="border-left:0px #000000 solid;">: <?= $rowmt['no_hanger']; ?></td>
      <td style="border-right:0px #000000 solid;">
        <pre>No. Mesin</pre>
      </td>
      <td style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt['no_mesin']; ?></td>
      <td style="border-left:0px #000000 solid;">
        <pre>LB1 = <?php echo $rowmt2['lb1']; ?></pre>
      </td>
    </tr>
    <tr>
      <td rowspan="2" valign="top" style="border-right:0px #000000 solid;">
        <pre>Jenis Kain</pre>
      </td>
      <td colspan="7" rowspan="2" valign="top" style="border-left:0px #000000 solid;">: <font size="-3"><?php if ($ssr['productcode'] != "") {
                                                                                                          echo substr(strtoupper($ssr['productcode'] . " / " . $ssr['description']), 0, 91);
                                                                                                        } else {
                                                                                                          echo $rowmt['jenis_kain'];
                                                                                                        } ?></font>
      </td>
      <td style="border-right:0px #000000 solid;">
        <pre>Kapasitas</pre>
      </td>
      <td style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt['kapasitas']; ?></td>
      <td style="border-left:0px #000000 solid;">
        <pre>LB2 = <?php echo $rowmt2['lb2']; ?></pre>
      </td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>No. Program</pre>
      </td>
      <td style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt2['no_program']; ?></td>
      <td style="border-left:0px #000000 solid;">
        <pre>LB3 = <?php echo $rowmt2['lb3']; ?></pre>
      </td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>Warna</pre>
      </td>
      <td colspan="4" style="border-left:0px #000000 solid;">:
        <?php if ($ssr['color'] != "") {
          echo strtoupper($ssr['color']);
        } else {
          echo $rowmt['warna'];
        } ?></td>
      <td width="11%" colspan="2" valign="top" align="right" style="border-left:0px #000000 solid;">Setting</td>
      <td width="11%" valign="top" align="center" style="border-left:0px #000000 solid;">Aktual</td>
      <td valign="top" style="border-right:0px #000000 solid;">
        <pre>Loading</pre>
      </td>
      <td valign="top" style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $loading; ?> %</td>
      <td valign="top" style="border-left:0px #000000 solid;">
        <pre>LB4 = <?php echo $rowmt2['lb4']; ?></pre>
      </td>
    </tr>
    <tr>
      <td width="12%" style="border-right:0px #000000 solid;">
        <pre>LOT</pre>
      </td>
      <td colspan="4" style="border-left:0px #000000 solid;">: <?php echo $rowmt['lot']; ?> | LOT di ERP :<?= $d_lot['LOT']; ?></td>
      <td width="6%" valign="top" style="border-right:0px #000000 solid;">Cycle Time</td>
      <td width="5%" valign="top" align="center" style="border-left:0px #000000 solid;">: </td>
      <td width="9%" valign="top" align="center" style="border-left:0px #000000 solid;"><?php echo $rowmt2['cycle_time']; ?></td>
      <td valign="top" style="border-right:0px #000000 solid;">
        <pre>L : R</pre>
      </td>
      <td valign="top" style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt2['l_r']; ?> / <?php echo $rowmt2['l_r_2']; ?></td>
      <td valign="top" style="border-left:0px #000000 solid;">
        <pre>LB5 = <?php echo $rowmt2['lb5']; ?></pre>
      </td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>Roll x Quantity</pre>
      </td>
      <td colspan="4" style="border-left:0px #000000 solid;">: <?php echo $rowmt2['rol']; ?> X <?php echo $rowmt2['bruto']; ?></td>
      <td width="6%" valign="top" style="border-right:0px #000000 solid;">RPM</td>
      <td width="5%" valign="top" align="center" style="border-left:0px #000000 solid;">: </td>
      <td width="9%" valign="top" align="center" style="border-left:0px #000000 solid;"><?php echo $rowmt2['rpm']; ?></td>
      <td valign="top" style="border-right:0px #000000 solid;">
        <pre>Carry Over</pre>
      </td>
      <td valign="top" style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt2['carry_over']; ?></td>
      <td valign="top" style="border-left:0px #000000 solid;">
        <pre>LB6 = <?php echo $rowmt2['lb6']; ?></pre>
      </td>
    </tr>
    <tr>
      <td style="border-right:0px #000000 solid;">
        <pre>Lebar x Gramasi</pre>
      </td>
      <td width="7%" align="left" valign="top" style="border-left:0px #000000 solid;">:
        <?php if ($rowmt['lebar'] != "") {
          echo $rowmt['lebar'];
        } ?>
        &quot; x
        <?php if ($rowmt['gramasi'] != "") {
          echo $rowmt['gramasi'];
        } ?></td>
      <td width="7%" align="left" valign="top" style="border-left:0px #000000 solid;">Fin: <?php echo $rowmt2['lebar_fin'] . " x " . $rowmt2['grm_fin']; ?></td>
      <td width="7%" align="left" valign="top" style="border-left:0px #000000 solid;">Dye: <?php echo $rowmt2['lebar_a'] . " x " . $rowmt2['gramasi_a']; ?></td>
      <td width="9%" align="right" valign="top" style="border-left:0px #000000 solid;"><?php if ($rowmt2['grm_fin'] > 0 and $rowmt2['grm_dye'] > 0) {
                                                                                          echo round($rowmt2['grm_dye'] / $rowmt2['grm_fin'], 2);
                                                                                        } ?> %</td>
      <td width="6%" valign="top" style="border-right:0px #000000 solid;">Tekanan/press</td>
      <td width="5%" valign="top" align="center" style="border-left:0px #000000 solid;">: </td>
      <td width="9%" valign="top" align="center" style="border-left:0px #000000 solid;"><?php if ($rowmt2['tekanan'] > 0) {
                                                                                          echo $rowmt2['tekanan'];
                                                                                        } ?></td>
      <td style="border-right:0px #000000 solid;">
        <pre>Panjang Kain</pre>
      </td>
      <td style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt2['pjng_kain']; ?> m</td>
      <td style="border-left:0px #000000 solid;">
        <pre>LB7 = <?php echo $rowmt2['lb7']; ?></pre>
      </td>
    </tr>
    <tr>
      <td align="left" valign="top" style="border-right:0px #000000 solid;">Pemakaian Air</td>
      <td colspan="4" align="left" valign="top" style="border-left:0px #000000 solid;">: <?php echo $rowmt2['pakai_air']; ?></td>
      <td width="6%" valign="top" style="border-right:0px #000000 solid;">Nozzle</td>
      <td width="5%" align="center" valign="top" style="border-left:0px #000000 solid;">: </td>
      <td width="9%" align="center" valign="top" style="border-left:0px #000000 solid;"><?php echo $rowmt2['nozzle']; ?></td>
      <td style="border-right:0px #000000 solid;">
        <pre>Jam Masuk Kain</pre>
      </td>
      <td style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo substr($rowmt2['tgl_buat'], 11, 5); ?></td>
      <td style="border-left:0px #000000 solid;">
        <pre>LB8 = <?php echo $rowmt2['lb8']; ?></pre>
      </td>
    </tr>
    <tr>
      <td align="left" valign="top" style="border-right:0px #000000 solid;">Air Panas</td>
      <td colspan="4" align="left" valign="top" style="border-left:0px #000000 solid;">: <?php echo $rowmt['a_panas']; ?></td>
      <td width="6%" style="border-right:0px #000000 solid;">Blower</td>
      <td width="5%" align="center" style="border-left:0px #000000 solid;">: </td>
      <td width="9%" align="center" valign="top" style="border-left:0px #000000 solid;"><?php echo $rowmt2['blower']; ?></td>
      <td style="border-right:0px #000000 solid;">Jam Target Keluar</td>
      <td width="9%" style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo date('H:i', strtotime('+' . $jamtarget . ' hour +' . $mintarget . ' minutes', strtotime($rowmt2['tgl_buat']))); ?></td>
      <td width="9%" style="border-left:0px #000000 solid; font-size:7px">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" style="border-right:0px #000000 solid;">Air Dingin</td>
      <td colspan="4" align="left" valign="top" style="border-left:0px #000000 solid;">: <?php echo $rowmt['a_dingin']; ?></td>
      <td width="6%" style="border-right:0px #000000 solid;">Plaiter</td>
      <td width="5%" align="center" style="border-left:0px #000000 solid;">: </td>
      <td width="9%" align="center" valign="top" style="border-left:0px #000000 solid;"><?php echo $rowmt2['plaiter']; ?></td>
      <td style="border-right:0px #000000 solid;">Std Target Celup</td>
      <td width="9%" style="border-left:0px #000000 solid;border-right:0px #000000 solid;">: <?php echo $rowmt['target']; ?> jam</td>
      <td width="9%" style="border-left:0px #000000 solid; font-size:7px">TOTAL = <?php $tolb = $rowmt2['lb1'] + $rowmt2['lb2'] + $rowmt2['lb3'] + $rowmt2['lb4'] + $rowmt2['lb5'] + $rowmt2['lb6'] + $rowmt2['lb7'] + $rowmt2['lb8'];
                                                                                  echo $tolb; ?></td>
    </tr>
  </table>
  <table width="100%" border="1" class="table-list1">
    <tr align="center">
      <td width="2%" rowspan="2">No</td>
      <td width="12%" rowspan="2">Scouring / Polyester</td>
      <td colspan="2">Jam Proses</td>
      <td width="12%" rowspan="2">Cotton</td>
      <td colspan="2" valign="top">Jam Proses</td>
      <td width="12%" rowspan="2">Proses</td>
      <td colspan="2" valign="top">Jam Proses</td>
    </tr>
    <tr>
      <td width="10%" align="center">Mulai</td>
      <td width="10%" align="center">Selesai</td>
      <td width="10%" align="center" valign="top">Mulai</td>
      <td width="11%" align="center" valign="top">Selesai</td>
      <td width="10%" align="center" valign="top">Mulai</td>
      <td width="21%" align="center" valign="top">Selesai</td>
    </tr>
    <tr>
      <td align="center">1</td>
      <td>Masuk Kain</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Masuk Aux</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="11%" align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="21%" align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">2</td>
      <td>Masuk Aux</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Masuk Dyestuff</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="11%" align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="21%" align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3</td>
      <td>Masuk H<sub>2</sub>O<sub>2</sub></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Masuk Na<sub>2</sub>SO<sub>4</sub></td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="11%" align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="21%" align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">4</td>
      <td>Cuci Panas</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Masuk Alkali</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="11%" align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="21%" align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">5</td>
      <td>Penetralan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Sample</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="11%" align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td width="10%" align="center" valign="top">&nbsp;</td>
      <td width="21%" align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">6</td>
      <td>Sample</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">+ Obat 1</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">7</td>
      <td>Bilas</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Sample</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">8</td>
      <td>Cuci Bulu</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">+ Obat 2</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">9</td>
      <td>Cuci Panas</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="12%" valign="top">Sample</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">10</td>
      <td>Sample</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">+ Obat 3</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">11</td>
      <td width="12%" valign="top">Masuk Aux</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">Sample</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">12</td>
      <td width="12%" valign="top">Masuk Dyestuff</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">Cuci</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">13</td>
      <td width="12%" valign="top">Sample</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">Soaping</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">14</td>
      <td width="12%" valign="top">+ Obat 1</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="6" rowspan="7" valign="top" style="
	border-bottom:0px #000000 solid;
	border-top:1px #000000 solid;												
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">Catatan : <span style="border-left:0px #000000 solid;"><?php echo $rowmt2['ket']; ?><br />No KK Legacy : <?php echo $rowmt['lotlgcy']; ?><br /> Masuk Kain: <?php echo $rowmt2['masukkain']; ?>
          <br /><?php if ($rowmt2['gabung_celup'] != "") {
                  echo "Gabung Celup:" . $rowmt2['gabung_celup'];
                } ?>
        </span></td>
    </tr>
    <tr>
      <td align="center">15</td>
      <td width="12%" valign="top">Sample</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">16</td>
      <td valign="top">+ Obat 2</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">17</td>
      <td valign="top">Sample</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">18</td>
      <td valign="top">R/C</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">19</td>
      <td valign="top">Penetralan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">20</td>
      <td valign="top">Sample</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="100%" border="" class="table-list1">
    <tr align="center">
      <td width="20%">&nbsp;</td>
      <td colspan="3">Dibuat Oleh :</td>
      <td width="16%">Diketahui Oleh :</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td width="20%" align="center"><?php echo $rowmt2['operator']; ?></td>
      <td width="20%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
      <td width="20%" align="center"><?php echo $rowmt2['leader']; ?></td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td align="center">Operator</td>
      <td align="center">Operator</td>
      <td align="center">Operator</td>
      <td align="center">Leader</td>
    </tr>
    <tr>
      <td>Tanggal </td>
      <td align="center"><?php if ($rowmt2['tgl_buat'] != "") {
                            echo date("d-m-Y", strtotime($rowmt2['tgl_buat']));
                          } ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><?php if ($rowmt2['tgl_buat'] != "") {
                            echo date("d-m-Y", strtotime($rowmt2['tgl_buat']));
                          } ?></td>
    </tr>
    <tr>
      <td valign="top" height="30">Tanda Tangan</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
  </table>

  <?php
  //} 
  ?>
  <script>
    alert('cetak');
    window.print();
  </script>
</body>

</html>