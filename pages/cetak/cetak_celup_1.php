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
    <tr>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
          </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
          </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
          </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
          </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
          </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
          </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
          </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
          </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
          </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
          </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
          </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
          </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
          </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
          </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
      <td><table width="100%" border="1" class="table-list1">
        <tr>
          <td width="11%">Custumer</td>
          <td width="3%" valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['buyer'];?></td>
        </tr>
        <tr>
          <td>PO</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['po'];?></td>
        </tr>
        <tr>
          <td>Order</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_order'];?></td>
        </tr>
        <tr>
          <td>Item</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_item'];?></td>
        </tr>
        <tr>
          <td>Qtt</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['bruto'];?></td>
        </tr>
        <tr>
          <td>Mc</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3"><?php echo $r['no_mesin'];?></td>
        </tr>
        <tr>
          <td>Lot</td>
          <td valign="middle" align="center">:</td>
          <td width="34%"><?php echo $r['lot'];?></td>
          <td width="7%" align="right">L&amp;G:</td>
          <td width="45%"><?php echo $r['lebar']." x ".$r['gramasi'];?></td>
        </tr>
        <tr>
          <td>Coment</td>
          <td valign="middle" align="center">:</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>