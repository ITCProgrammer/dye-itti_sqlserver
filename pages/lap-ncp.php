<?PHP
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$cond=mysqli_connect("10.0.0.10","dit","4dm1n","db_qc");
include "tgl_indo.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan NCP</title>

</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$Cancel	= isset($_POST['chkcancel']) ? $_POST['chkcancel'] : '';	
	
if($_POST['gshift']=="ALL"){$shft=" ";}else{$shft=" AND b.g_shift = '$GShift' ";}	
if($_GET['awal']!="" and $_GET['akhir']!=""){ 
	$Awal1=$_GET['awal'];$Akhir1=$_GET['akhir'];
}else{
	$Awal1=$Awal;$Akhir1=$Akhir; 
}	
?>
	
<div class="box box-success collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Filter Laporan NCP</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1" action="?p=Lap-NCP">
    <div class="box-body">
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal1; ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir1;  ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
	   	               
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <div class="col-sm-2">
        <button type="submit" class="btn btn-social btn-linkedin btn-sm" name="save">Search <i class="fa fa-search"></i></button>
      </div>
    </div>
    <!-- /.box-footer -->
  </form>
</div>
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
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Data NCP DYE</h3>
		<?php if($Awal1!="") { ?> 
		<div class="pull-right">
		  <a href="pages/cetak/cetak_harianncp.php?&awal=<?php echo $Awal1; ?>&akhir=<?php echo $Akhir1; ?>&dept=DYE&cancel=<?php echo $Cancel; ?>" class="btn btn-danger " target="_blank" data-toggle="tooltip" data-html="true" title="Laporan NCP"><i class="fa fa-print"></i> Cetak</a>
		  <a href="pages/cetak/cetak_harianncp_excel.php?&awal=<?php echo $Awal1; ?>&akhir=<?php echo $Akhir1; ?>&dept=DYE&cancel=<?php echo $Cancel; ?>" class="btn btn-primary " target="_blank" data-toggle="tooltip" data-html="true" title="Cetak ke Excel"><i class="fa fa-file-excel-o"></i> Cetak ke EXCEL</a>	
		</div>  
		<?php } ?>
		<?php if($Awal1!="") { ?><br><b>Periode: <?php echo tanggal_indo($Awal1)." - ".tanggal_indo($Akhir1); ?></b>
		<h4>Total Lot: <span class="label label-info"><?php echo $rSUM['Lot']; ?></span></h4>
		<h4>Total Rol: <span class="label label-warning"><?php echo number_format($rSUM['Rol']); ?></span></h4>
		<h4>Total Qty : <span class="label label-danger"><?php echo number_format($rSUM['Berat'],"2")." Kg"; ?></span></h4> 
		<?php } ?>
		  
      
	  </div>
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-green">
          <tr>
            <th><div align="center">No</div></th>
            <th><div align="center">Tgl</div></th>
            <th><div align="center">Status</div></th>
            <th><div align="center">Langganan</div></th>
			<th><div align="center">PO</div></th>
            <th><div align="center">No NCP</div></th>
            <th><div align="center">Order</div></th>
            <th><div align="center">Hanger</div></th>
            <th><div align="center">Jenis Kain</div></th>
            <th><div align="center">Lebar &amp; Gramasi</div></th>
            <th><div align="center">Lot</div></th>
            <th><div align="center">Warna</div></th>
            <th><div align="center">No Warna</div></th>
            <th><div align="center">Rol</div></th>
            <th><div align="center">Berat</div></th>
            <th><div align="center">Dept</div></th>
            <th><div align="center">Masalah</div></th>
            <th><div align="center">Masalah Utama</div></th>
            <th><div align="center">Ket</div></th>
            <th align="center" class="table-list1"><div align="center">Tindakan Penyelesaian</div></th>
            <th align="center" class="table-list1"><div align="center">Penyebab</div></th>
            <th align="center" class="table-list1"><div align="center">Colorist DYE</div></th>
            <th align="center" class="table-list1"><div align="center">Analisa Penyebab</div></th>
            <th align="center" class="table-list1"><div align="center">Perbaikan</div></th>
            <th align="center" class="table-list1"><div align="center">Catatan Verifikator</div></th>
            <th align="center" class="table-list1"><div align="center">Peninjau Akhir</div></th>
            <th align="center" class="table-list1"><div align="center">NSP</div></th>
            <th align="center" class="table-list1"><div align="center">Rencana</div></th>
            <th align="center" class="table-list1"><div align="center">Aktual</div></th>
            <th align="center" class="table-list1"><div align="center">Nokk</div></th>
            <th align="center" class="table-list1"><div align="center">Tempat Kain</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
	$no=1;	
	while($row1=mysqli_fetch_array($qry1)){
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $row1['tgl_buat'];?><br><div class="btn-group"><a href="#" class="btn btn-xs btn-primary tambah_analisa " id="<?php echo $row1['id'].".".$_POST['awal'].",".$_POST['akhir'];?>"><i class="fa fa-edit"></i></a><a href="pages/cetak/cetak_ncp.php?id=<?php echo $row1['id'];?>" class="btn btn-xs btn-danger" target="_blank"><i class="fa fa-print"></i></a><a href="pages/cetak/cetak_ncp_pdf.php?id=<?php echo $row1['id'];?>" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-file-pdf-o"></i></a></div></td>
            <td><span class="label <?php if($row1['status']=="OK"){echo "label-success";}else if($row1['status']=="Cancel"){echo "label-danger";}else{echo "label-warning";} ?> "><?php echo $row1['status'];?></span></td>
            <td><?php echo $row1['langganan'];?></td>
			<td align="center"><?php echo $row1['po'];?></td>
            <td align="center"><span class="label label-danger"><?php echo $row1['no_ncp'];?></span></td>
            <td align="center"><?php echo $row1['no_order'];?></td>
            <td align="center"><?php echo $row1['no_hanger'];?></td>
            <td><?php echo $row1['jenis_kain'];?></td>
            <td align="center"><?php echo $row1['lebar']."x".$row1['gramasi'];?></td>
            <td align="center"><?php echo $row1['lot'];?></td>
            <td align="center"><?php echo $row1['warna'];?></td>
            <td align="center"><?php echo $row1['no_warna'];?></td>
            <td align="right"><?php echo $row1['rol'];?></td>
            <td align="right"><?php echo $row1['berat'];?></td>
            <td align="center"><?php echo $row1['dept'];?></td>
            <td><?php echo $row1['masalah'];?></td>
            <td><?php echo $row1['masalah_dominan'];?></td>
            <td><?php echo $row1['ket'];?></td>
            <td><?php echo $row1['penyelesaian'];?></td>
            <td><?php echo $row1['penyebab'];?></td>
            <td><?php echo $row1['acc'];?></td>
            <td><?php echo $row1['analisa_penyebab'];?></td>
            <td><?php echo $row1['perbaikan'];?></td>
            <td><?php echo $row1['catat_verify'];?></td>
            <td><?php echo $row1['peninjau_akhir'];?></td>
            <td><?php echo $row1['nsp'];?></td>
            <td align="center"><?php if($row1['tgl_rencana']!=""){echo date("d/m/y", strtotime($row1['tgl_rencana']));}?></td>
            <td align="center"><?php if($row1['tgl_selesai']!=""){echo date("d/m/y", strtotime($row1['tgl_selesai']));}?></td>
            <td align="center">'<?php echo $row1['nokk'];?></td>
            <td><?php echo $row1['tempat'];?></td>
            </tr>
          <?php	$no++;  } ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="StsEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>	
<div id="TambahAnalisa" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>	
<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</body>
</html>