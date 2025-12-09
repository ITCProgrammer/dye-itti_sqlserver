<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=cetak-NCPMemo-harian-".substr($_GET['awal'],0,10).".xls");//ganti nama sesuai keperluan
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
$Kategori=$_GET['kategori'];	
if($Kategori=="ALL"){		
	$WKategori=" ";	
	}
	else if($Kategori=="hitung"){	
	$WKategori=" ncp_hitung='ya' AND ";	
	}else if($Kategori=="tidakhitung"){	
	$WKategori=" ncp_hitung='tidak' AND ";	
	}	
?>
<?php
	
	$qry1=mysqli_query($con,"SELECT * FROM tbl_ncp_memo WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal1' AND '$Akhir1' ORDER BY id ASC");
	$qrySUM=mysqli_query($con,"SELECT COUNT(*) as Lot, SUM(rol_ncp) as Rol,SUM(qty_ncp) as Berat FROM tbl_ncp_memo WHERE DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal1' AND '$Akhir1' ");
	$rSUM=mysqli_fetch_array($qrySUM);
	?>
<table border="1" class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-green">
          <tr>
            <th><div align="center">No KK</div></th>
            <th><div align="center">No</div></th>
            <th><div align="center">Tanggal</div></th>
            <th><div align="center">Nomor NCP</div></th>
            <th><div align="center">Langganan</div></th>
            <th><div align="center">Buyer</div></th>
			<th><div align="center">Order</div></th>
            <th><div align="center">Jenis Kain</div></th>
            <th><div align="center">No Warna</div></th>
            <th><div align="center">Warna</div></th>
            <th><div align="center">Lot</div></th>
            <th><div align="center">Roll</div></th>
            <th><div align="center">Quantity</div></th>
            <th><div align="center">Disposisi</div></th>
            <th><div align="center">Kategori NCP</div></th>
            <th><div align="center">Jenis NCP</div></th>
            <th><div align="center">Acc Celup</div></th>
            <th><div align="center">Tanggal Proses</div></th>
            <th><div align="center">No Mesin</div></th>
            <th><div align="center">Shift</div></th>
            <th><div align="center">Acc Perbaikan</div></th>
            <th><div align="center">Perbaikan</div></th>
            <th><div align="center">Tanggal Rencana</div></th>
            <th><div align="center">Akar Masalah</div></th>
            <th><div align="center">Solusi Jangka Panjang</div></th>
            <th><div align="center">Rincian</div></th>
            <th><div align="center">Keterangan</div></th>
            <th><div align="center">Status</div></th>
            <th><div align="center">Perbaikan Dye</div></th>
            <th><div align="center">L:R</div></th>
            <th><div align="center">Operator</div></th>
            <th><div align="center">Item</div></th>
            <th><div align="center">RB/RL</div></th>
            <th><div align="center">K.R</div></th>
            <th><div align="center">Loading</div></th>
            <th><div align="center">No Program</div></th>
            <th><div align="center">Cycle Time</div></th>
            <th><div align="center">RPM</div></th>
            <th><div align="center">Tekanan/Press</div></th>
            <th><div align="center">Nozzle</div></th>
            <th><div align="center">Plaiter</div></th>
            <th><div align="center">Blower</div></th>
            <th><div align="center">Merk Mesin</div></th>
            <th><div align="center">Kategori</div></th>
            <th><div align="center">Jml Perbaikan</div></th>
            <th><div align="center">NCP Sebelumnya</div></th>
            <th><div align="center">Acc Perbaikan Sebelumnya</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
	$no=1;	
	while($row1=mysqli_fetch_array($qry1)){
		$sqlCek1=mysqli_query($con,"SELECT
	a.*,b.id as idm 
FROM
	tbl_schedule a
LEFT JOIN tbl_montemp b ON a.id=b.id_schedule	
WHERE
	a.nokk = '$row1[nokk]' and a.no_mesin='$row1[mc_celup]' and not (a.no_mesin='CB11' or a.no_mesin='WS11')
ORDER BY
	a.id DESC 
	LIMIT 1");
$cek1=mysqli_num_rows($sqlCek1);
$rcek1=mysqli_fetch_array($sqlCek1);
		$sqlCek2=mysqli_query($con,"SELECT
	* FROM tbl_hasilcelup
	WHERE id_montemp ='$rcek1[idm]'
ORDER BY
	id DESC 
	LIMIT 1");
$cek2=mysqli_num_rows($sqlCek2);
$rcek2=mysqli_fetch_array($sqlCek2);
		$qryQCF=mysqli_query($cond,"SELECT * FROM tbl_ncp_qcf_new WHERE id='$row1[id_ncp]' ");
		$rQCF=mysqli_fetch_array($qryQCF);
		$sqlMc=mysqli_query($con,"SELECT kode FROM tbl_mesin WHERE no_mesin='".$row1['mc_celup']."'");
		$rMC=mysqli_fetch_array($sqlMc);
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td align="center">'<?php echo $row1['nokk'];?></td>
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $row1['tgl_buat'];?></td>
            <td align="center"><span class="label label-danger"><?php echo $row1['no_ncp'];?></span></td>
            <td><?php echo $row1['langganan'];?></td>
            <td align="center"><?php echo $row1['buyer'];?></td>
			<td align="center"><?php echo $row1['order'];?></td>
            <td><?php echo $row1['jenis_kain'];?></td>
            <td align="center"><?php echo $row1['no_warna'];?></td>
            <td align="center"><?php echo $row1['warna'];?></td>
            <td align="center">'<?php echo $row1['lot'];?></td>
            <td align="right"><?php echo $row1['rol_ncp'];?></td>
            <td align="right"><?php if($row1['perbaikan_dye']!="DISPOSISI"){ echo $row1['qty_ncp']; }?></td>
            <td><?php if($row1['perbaikan_dye']=="DISPOSISI"){ echo $row1['qty_ncp'];} ?></td>
            <td><?php echo $row1['kategori_masalah'];?></td>
            <td><?php echo $row1['masalah'];?></td>
            <td><?php echo $row1['acc_keluar'];?></td>
            <td><?php echo $row1['tgl_celup'];?></td>
            <td><?php echo $row1['mc_celup'];?></td>
            <td><?php echo $row1['shift'];?></td>
            <td><?php echo $row1['acc_perbaikan_dye'];?></td>
            <td><?php echo $rQCF['perbaikan']; ?></td>
            <td align="center"><?php if($row1['tgl_rencana']!=""){echo date("d/m/y", strtotime($row1['tgl_rencana']));}?></td>
            <td><?php echo $rQCF['akar_masalah']; ?></td>
            <td><?php echo $rQCF['solusi_panjang']; ?></td>
            <td><?php echo $rQCF['penyelesaian']; ?></td>
            <td><?php echo $row1['ket_penyelesaian'];?></td>
            <td><?php echo $rQCF['status'];?></td>
            <td><?php echo $row1['perbaikan_dye'];?></td>
            <td><?php echo $row1['l_r'];?></td>
            <td><?php echo $row1['operator'];?></td>
            <td><?php echo $rQCF['no_item'];?></td>
            <td><?php echo $rcek1['resep'];?></td>
            <td><?php echo $rcek2['k_resep'];?></td>
            <td><?php echo $row1['loading'];?></td>
            <td><?php echo $row1['no_program'];?></td>
            <td><?php echo $row1['cycle_time'];?></td>
            <td><?php echo $row1['rpm'];?></td>
            <td><?php echo $row1['press_pump'];?></td>
            <td><?php echo $row1['nozzle'];?></td>
            <td><?php echo $row1['plaiter'];?></td>
            <td><?php echo $row1['blower'];?></td>
            <td><?php if($rQCF['nama_mesin']!=""){echo $rQCF['nama_mesin'];}else{ echo $rMC['kode']; } ?></td>
            <td><?php echo $row1['kategori_penyelesaian'];?></td>
            <td><?php echo $row1['jml_perbaikan'];?></td>
            <td><?php echo $row1['no_ncp_sebelumnya'];?></td>
            <td><?php echo $row1['accperbaikan_sebelumnya'];?></td>
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