<?php
$con=mysql_connect("10.0.0.10","dit","4dm1n");
$db=mysql_select_db("dbknitt",$con)or die("Gagal Koneksi");
//--
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
//-
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Formulir Pemeriksaan Mesin Knitting</title>
</head>

<body>
<?php 
$qry=mysql_query("SELECT *,now() as tgl FROM tbl_jadwal WHERE id='$_GET[id]'");
$r=mysql_fetch_array($qry);	
?>	
<table width="100%" >
  <tbody>
    <tr>
      <td colspan="7" align="right" valign="top"><table width="200" border="0" >
        <tbody>
          <tr>
            <td style="font-size: 9px;">No. Form</td>
            <td style="font-size: 9px;">:</td>
            <td style="font-size: 9px;">FW-14-KNT-26</td>
          </tr > 
          <tr>
            <td style="font-size: 9px;">No. Revisi</td>
            <td style="font-size: 9px;">:</td>
            <td style="font-size: 9px;">01</td>
          </tr>
          <tr>
            <td style="font-size: 9px;">Tgl. Terbit</td>
            <td style="font-size: 9px;">:</td>
            <td style="font-size: 9px;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="7" align="center"><h2><u>FORMULIR PEMERIKSAAN MESIN KNITTING</u></h2></td>
    </tr>
    <tr>
      <td width="12%">Tgl Cetak Form</td>
      <td width="24%">: <?php echo $r[tgl]; ?></td>
      <td width="17%">Tgl Mulai Service</td>
      <td width="1%">:</td>
      <td width="33%">&nbsp;</td>
      <td width="3%">Jam</td>
      <td width="10%">:</td>
    </tr>
    <tr>
      <td>No Mesin</td>
      <td>: <?php echo $r[no_mesin]; ?></td>
      <td>Tgl Selesai Service</td>
      <td>:</td>
      <td>&nbsp;</td>
      <td>Jam</td>
      <td>:</td>
    </tr>
    <tr>
      <td valign="top">Produksi (KG)</td>
      <td valign="top">: <?php echo $r[kg_awal]; ?></td>
      <td valign="top">Kategori</td>
      <td valign="top">:</td>
      <td colspan="3" valign="top"><label for="checkbox4">
        <input type="checkbox" name="checkbox4" id="checkbox4" <?php if($r[kategori]=="Over Houl") echo "checked"; ?>/>
Over Houl <br />
		  </label>		  
<label for="checkbox5">		  
<input type="checkbox" name="checkbox5" id="checkbox5" readonly <?php if($r[kategori]=="Ringan") echo "checked"; ?> />
Ringan <br />
      </label></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">Jenis Service</td>
      <td valign="top">:</td>
      <td colspan="3" valign="top"><label for="checkbox"><input type="checkbox" name="checkbox" id="checkbox" readonly="readonly" <?php if($r[sts]=="Berkala"){ echo "checked"; } ?> />
        Berkala <br />
		  </label>
		  <label for="checkbox2">
          <input type="checkbox" name="checkbox2" id="checkbox2" readonly="readonly"  <?php if($r[sts]=="Trouble") {echo "checked";} ?>/>
          Trouble <br />
		  </label>	
		<label for="checkbox3">	
  <input type="checkbox" name="checkbox3" id="checkbox3" readonly="readonly" <?php if($r[sts]=="Ganti Konstruksi") {echo "checked"; }?>/>
      Ganti Konstuksi </label></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" border="1" class="table-list1" >
  <tbody>
    <tr align="center">
      <td width="3%" rowspan="2">No.</td>
      <td width="24%" rowspan="2">Bagian Mesin</td>
      <td width="7%" rowspan="2">Jumlah</td>
      <td colspan="2">Kondisi</td>
      <td colspan="2">Tindak Lanjut</td>
      <td width="33%" rowspan="2">Keterangan</td>
    </tr>
    <tr>
      <td width="8%" align="center">Baik</td>
      <td width="8%" align="center">Tidak</td>
      <td width="8%" align="center">Perbaikan</td>
      <td width="9%" align="center">Ganti</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>Jarum</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">2.</td>
      <td>Sinker</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3.</td>
      <td>Cylinder</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">4.</td>
      <td>Fan (Kipas)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">5.</td>
      <td>Yarn Guide (Ekor Babi)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">6.</td>
      <td>Positif Feeder (MPF)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">7.</td>
      <td>Pully</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">8.</td>
      <td>Tooth Belt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">9.</td>
      <td>Tension Tape</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">10.</td>
      <td>Feeder</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">11.</td>
      <td>Baut Cam Box</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">12.</td>
      <td>Lengkok / CAM</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">13.</td>
      <td>Lampu</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">14.</td>
      <td>Take Down Units</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">15.</td>
      <td>Sensor Pintu</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">16.</td>
      <td>Sensor Jarum</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">17.</td>
      <td>Display Monitor</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">18.</td>
      <td>Lubrication Units</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">19.</td>
      <td>Creel / Rak Benang</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">20.</td>
      <td>Motor Dinamo</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">21.</td>
      <td>Vanbelt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">22.</td>
      <td>Air Pressure</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">23.</td>
      <td>MER</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr style="height: 1.5in">
      <td colspan="8" valign="top">Catatan: <?php echo $r[ket]; ?></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" border="1" class="table-list1">
  <tbody>
    <tr valign="top">
      <td>Mekanik Service<br />
        1. <?php echo $r[mekanik]; ?><br />
        2. <?php echo $r[mekanik2]; ?><br />
        3. <?php echo $r[mekanik3]; ?><br />
        4.</td>
      <td>Mekanik Stell Mesin</td>
      <td>Leader Produksi</td>
      <td>Kepala Bagian</td>
    </tr>
    <tr>
      <td>Tgl :</td>
      <td>Tgl :</td>
      <td>Tgl : </td>
      <td>Tgl :</td>
    </tr>
    <tr valign="top" style="height: 0.7in">
      <td>Tanda tangan :</td>
      <td>Tanda tangan :</td>
      <td>Tanda tangan :</td>
      <td>Tanda tangan :</td>
    </tr>
  </tbody>
</table>
</body>
</html>