<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Harian Ganti Kain</title>

</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$Order	= isset($_POST['order']) ? $_POST['order'] : '';
$Hanger	= isset($_POST['hanger']) ? $_POST['hanger'] : '';
$Masalah= isset($_POST['masalah']) ? $_POST['masalah'] : '';
$Dept	= isset($_POST['dept']) ? $_POST['dept'] : '';	
	
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Laporan Ganti Kain</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
    <div class="box-body">
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
      <div class="form-group">
        <div class="col-sm-3">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
	  <div class="form-group">
        <div class="col-sm-3">
            <input name="order" type="text" class="form-control pull-right" id="order" placeholder="No Order" value="<?php echo $Order;  ?>" autocomplete="off"/>
          </div>
        <!-- /.input group -->
      </div>
	  <div class="form-group">
        <div class="col-sm-3">
            <input name="hanger" type="text" class="form-control pull-right" id="hanger" placeholder="No Hanger" value="<?php echo $Hanger;  ?>" autocomplete="off"/>
          </div>
        <!-- /.input group -->
      </div>
	  <div class="form-group">
        <div class="col-sm-3">
            <select class="form-control select2" name="dept">
							<option value="" disabled selected>Pilih Departemen</option>
							<option value="QCF" <?php if ($Dept == "QCF") {
													echo "SELECTED";
												} ?>>QCF</option>
							<option value="PPC" <?php if ($Dept == "PPC") {
													echo "SELECTED";
												} ?>>PPC</option>
							<option value="FIN" <?php if ($Dept == "FIN") {
													echo "SELECTED";
												} ?>>FIN</option>
							<option value="BRS" <?php if ($Dept == "BRS") {
													echo "SELECTED";
												} ?>>BRS</option>
							<option value="DYE" <?php if ($Dept == "DYE") {
													echo "SELECTED";
												} ?>>DYE</option>
							<option value="KNT" <?php if ($Dept == "KNT") {
													echo "SELECTED";
												} ?>>KNT</option>
							<option value="GKG" <?php if ($Dept == "GKG") {
													echo "SELECTED";
												} ?>>GKG</option>
							<option value="TAS" <?php if ($Dept == "TAS") {
													echo "SELECTED";
												} ?>>TAS</option>
						</select>			
          </div>
        <!-- /.input group -->
      </div>	
	  <div class="form-group">
        <div class="col-sm-3">
            <input name="masalah" type="text" class="form-control pull-right" id="masalah" placeholder="Masalah" value="<?php echo $Masalah;  ?>" autocomplete="off"/>
          </div>
        <!-- /.input group -->
      </div>	
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <div class="col-sm-2">
        <button type="submit" class="btn btn-block btn-social btn-linkedin btn-sm" name="save" style="width: 60%">Search <i class="fa fa-search"></i></button>
      </div>
    </div>
    <!-- /.box-footer -->
  </form>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Data Ganti Kain</h3><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $_POST['awal']." to ".$_POST['akhir']; ?></b>
		<?php } ?>
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-blue">
          <tr>
            <th><div align="center">No</div></th>
            <th><div align="center">&nbsp;&nbsp;&nbsp; Aksi &nbsp;&nbsp;&nbsp;</div></th>
            <th><div align="center">Tgl</div></th>
            <th><div align="center">Langganan</div></th>
            <th><div align="center">PO</div></th>
            <th><div align="center">Order</div></th>
            <th><div align="center">Hanger</div></th>
            <th><div align="center">Jenis Kain</div></th>
            <th><div align="center">Lebar &amp; Gramasi</div></th>
            <th><div align="center">Lot</div></th>
            <th><div align="center">Warna</div></th>
            <th><div align="center">Qty Order</div></th>
            <th><div align="center">Qty Kirim</div></th>
            <th><div align="center">Qty Claim</div></th>
            <th><div>
              <div align="center">T Jawab</div>
            </div></th>
            <th><div align="center">Masalah</div></th>
            <th><div align="center">Ket</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
	$no=1;
			if($Awal!=""){ $Where =" WHERE DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' "; }
			if($Order!=""){ $Where =" WHERE no_order= '$Order' "; }
			if($Hanger!=""){ $Where =" WHERE no_hanger= '$Hanger' "; }
			if($Masalah!=""){ $Where =" WHERE masalah LIKE '%$Masalah%' "; }
			if($Dept!=""){ $Where =" WHERE dept= '$Dept' "; }
			if($Awal=="" and $Order=="" and $Hanger=="" and $Masalah=="" and $Dept==""){ $Where =" WHERE DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' "; }
			$qry1=mysqli_query($con,"SELECT * FROM tbl_gantikain $Where ORDER BY id ASC");
			while($row1=mysqli_fetch_array($qry1)){
			$sqlgk=mysqli_query($con," SELECT * FROM tbl_bonkain WHERE id_nsp='$row1[id]' ORDER BY no_bon ASC");
  			$rgk=mysqli_num_rows($sqlgk);
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><div class="btn-group"><a href="index1.php?p=input-bon-kain&id=<?php echo $row1['id']; ?>" class="btn btn-warning btn-xs <?php if($_SESSION['akses']=='biasa'){ echo "disabled"; } ?>" target="_blank"><i class="fa fa-plus"></i> </a>
     <a href="EditKPE-<?php echo $row1['id']; ?>" class="btn btn-info btn-xs <?php if($_SESSION['akses']=='biasa'){ echo "disabled"; } ?>" target="_blank"><i class="fa fa-edit"></i> </a>
     <a href="#" class="btn btn-danger btn-xs <?php if($_SESSION['akses']=='biasa' or $rgk>0){ echo "disabled"; } ?>" onclick="confirm_delete('index1.php?p=hapusdatagantikain&id=<?php echo $row1['id']; ?>');"><i class="fa fa-trash"></i> </a></div></td>
            <td align="center"><?php echo $row1['tgl_buat'];?></td>
            <td><?php echo $row1['langganan'];?></td>
            <td align="center"><?php echo $row1['po'];?></td>
            <td align="center"><?php echo $row1['no_order'];?></td>
            <td align="center" valign="top"><?php echo $row1['no_hanger'];?></td>
            <td><?php echo $row1['jenis_kain'];?></td>
            <td align="center"><?php echo $row1['lebar']."x".$row1['gramasi'];?></td>
            <td align="center"><?php echo $row1['lot'];?></td>
            <td align="center"><?php echo $row1['warna'];?></td>
            <td align="right"><?php echo $row1['qty_order'];?></td>
            <td align="right"><?php echo $row1['qty_kirim'];?></td>
            <td align="right"><?php echo $row1['qty_claim'];?></td>
            <td align="center"><?php echo $row1['t_jawab'];?></td>
            <td><?php echo $row1['masalah'];?></td>
            <td><?php echo $row1['ket'];?></td>
            </tr>
          <?php	$no++;  } ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_del" tabindex="-1" >
  <div class="modal-dialog modal-sm" >
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Are you sure to delete all data ?</h4>
      </div>

      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>	
<script type="text/javascript">
    function confirm_delete(delete_url)
    {
      $('#modal_del').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>	
<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
</body>
</html>