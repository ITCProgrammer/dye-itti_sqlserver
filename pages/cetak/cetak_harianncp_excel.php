<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=cetak-NCP-harian-".substr($_GET['awal'],0,10).".xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
ini_set("error_reporting", 1);
include "../../koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan NCP</title>

</head>
<body>
<?php
if($_GET['awal']!="" and $_GET['akhir']!=""){ 
	$Awal1=$_GET['awal'];$Akhir1=$_GET['akhir'];
}else{
	$Awal1=$Awal;$Akhir1=$Akhir; 
}	
?>
<?php
	$Wdept=" dept='DYE' AND ";
	if($Cancel !="1"){
		$sts=" AND NOT status='Cancel' ";
	}else{
		$sts="  ";
  }
	$qry1=mysqli_query($cond,"SELECT * FROM tbl_ncp_qcf WHERE $Wdept DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal1' AND '$Akhir1' $sts ORDER BY id ASC");
	$qrySUM=mysqli_query($cond,"SELECT COUNT(*) as Lot, SUM(rol) as Rol,SUM(berat) as Berat FROM tbl_ncp_qcf WHERE $Wdept DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal1' AND '$Akhir1' $sts ");
	$rSUM=mysqli_fetch_array($qrySUM);
	?>
<table border="1" class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-green">
          <tr>
            <th><div align="center">No</div></th>
            <th><div align="center">Tgl</div></th>
            <th><div align="center">No NCP</div></th>
            <th><div align="center">Langganan</div></th>
			<th><div align="center">PO</div></th>
            <th><div align="center">Order</div></th>
            <th><div align="center">Hanger</div></th>
            <th><div align="center">Jenis Kain</div></th>
            <th><div align="center">No Warna</div></th>
            <th><div align="center">Warna</div></th>
            <th><div align="center">Lot</div></th>
            <th><div align="center">Rol</div></th>
            <th><div align="center">Quantity</div></th>
            <th><div align="center">Disposisi</div></th>
            <th><div align="center">Masalah</div></th>
            <th><div align="center">Masalah Utama</div></th>
            <th><div align="center">No Mesin</div></th>
            <th><div align="center">Shift</div></th>
            <th><div align="center">Penanggung Jawab</div></th>
            <th><div align="center">Perbaikan</div></th>
            <th><div align="center">Tanggal Rencana</div></th>
            <th><div align="center">Analisa Penyebab</div></th>
            <th><div align="center">Keterangan</div></th>
            <th><div align="center">Status</div></th>
            <th><div align="center">Nokk</div></th>
            <th><div align="center">Tempat Kain</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
	$no=1;	
	while($row1=mysqli_fetch_array($qry1)){
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $row1['tgl_buat'];?></td>
            <td align="center"><span class="label label-danger"><?php echo $row1['no_ncp'];?></span></td>
            <td><?php echo $row1['langganan'];?></td>
			<td align="center"><?php echo $row1['po'];?></td>
            <td align="center"><?php echo $row1['no_order'];?></td>
            <td align="center"><?php echo $row1['no_hanger'];?></td>
            <td><?php echo $row1['jenis_kain'];?></td>
            <td align="center"><?php echo $row1['no_warna'];?></td>
            <td align="center"><?php echo $row1['warna'];?></td>
            <td align="center">'<?php echo $row1['lot'];?></td>
            <td align="right"><?php echo $row1['rol'];?></td>
            <td align="right"><?php echo $row1['berat'];?></td>
            <td>&nbsp;</td>
            <td><?php echo $row1['masalah'];?></td>
            <td><?php echo $row1['masalah_dominan'];?></td>
            <td><?php echo $row1['mesin'];?></td>
            <td><?php echo $row1['shift'];?></td>
            <td><?php echo $row1['penanggung_jawab'];?></td>
            <td><?php echo $row1['perbaikan'];?></td>
            <td align="center"><?php if($row1['tgl_rencana']!=""){echo date("d/m/y", strtotime($row1['tgl_rencana']));}?></td>
            <td><?php echo $row1['analisa_penyebab'];?></td>
            <td><?php echo $row1['ket'];?></td>
            <td><span class="label <?php if($row1['status']=="OK"){echo "label-success";}else if($row1['status']=="Cancel"){echo "label-danger";}else{echo "label-warning";} ?> "><?php echo $row1['status'];?></span></td>
            <td align="center">'<?php echo $row1['nokk'];?></td>
            <td><?php echo $row1['tempat'];?></td>
            </tr>
          <?php	$no++;  } ?>
        </tbody>
      </table>

<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</body>
</html>