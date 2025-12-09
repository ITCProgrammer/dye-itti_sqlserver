<?php
//$lReg_username=$_SESSION['labReg_username'];
ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
$data=mysqli_query($con,"SELECT a.*,b.k_resep,b.acc_keluar,
   b.operator_keluar,b.shift as shift_keluar,
   b.g_shift as g_shift_keluar,c.comment_warna,c.acc,c.ket,c.id as idb from tbl_schedule a
     INNER JOIN tbl_montemp d ON a.id=d.id_schedule
	 INNER JOIN tbl_hasilcelup b ON d.id=b.id_montemp
	 INNER JOIN tbl_potongcelup c ON b.id=c.id_hasilcelup
	 WHERE c.id='$_GET[id]'
	 ORDER BY a.no_mesin ASC");
$r=mysqli_fetch_array($data);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Celup</title>

</head>


<body>
<table width="100%" border="0" style="width: 7in;">
  <tbody>
	 <tr >
      <td colspan="3" style="height: 0.5in;">&nbsp;</td>
    </tr> 
    <tr>
       <td><table width="100%" border="0" class="table-list1">
         <tr>
           <td width="11%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Custumer</td>
           <td width="3%" valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo substr($r['langganan'],0,10)."/".substr($r['buyer'],0,10);?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">PO</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['po'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Order</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_order'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Item</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_item'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Qtt</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['rol']."x".$r['bruto'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Mc</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_mesin']."/".$r['k_resep'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Lot</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td width="34%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['lot'];?></td>
           <td width="7%" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">L&amp;G:</td>
           <td width="45%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Coment</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
           <td colspan="3" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size: 8px;"><?php echo $r['nokk'];?></div></td>
         </tr>
       </table></td>
       <td><table width="100%" border="0" class="table-list1">
         <tr>
           <td width="11%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Custumer</td>
           <td width="3%" valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo substr($r['langganan'],0,10)."/".substr($r['buyer'],0,10);?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">PO</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['po'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Order</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_order'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Item</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_item'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Qtt</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['rol']."x".$r['bruto'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Mc</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_mesin']."/".$r['k_resep'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Lot</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td width="34%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['lot'];?></td>
           <td width="7%" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">L&amp;G:</td>
           <td width="45%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Coment</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
           <td colspan="3" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size: 8px;"><?php echo $r['nokk'];?></div></td>
         </tr>
       </table></td>
       <td><table width="100%" border="0" class="table-list1">
         <tr>
           <td width="11%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Custumer</td>
           <td width="3%" valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo substr($r['langganan'],0,10)."/".substr($r['buyer'],0,10);?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">PO</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['po'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Order</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_order'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Item</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_item'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Qtt</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['rol']."x".$r['bruto'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Mc</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['no_mesin']."/".$r['k_resep'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Lot</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td width="34%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['lot'];?></td>
           <td width="7%" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">L&amp;G:</td>
           <td width="45%" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Coment</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">:</td>
           <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
         </tr>
         <tr>
           <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
           <td valign="middle" align="center" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
           <td colspan="3" align="right" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><div style="font-size: 8px;"><?php echo $r['nokk'];?></div></td>
         </tr>
       </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>