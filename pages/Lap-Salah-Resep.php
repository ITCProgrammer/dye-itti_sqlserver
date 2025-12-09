<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Salah Resep</title>

</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
	
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Laporan Salah Resep</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
    <div class="box-body">
      <div class="form-group">
        <div class="col-sm-2">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
      <div class="form-group">
        <div class="col-sm-2">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off"/>
          </div>
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
        <h3 class="box-title">Data Salah Resep</h3><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $_POST['awal']." to ".$_POST['akhir']; ?></b>
		<?php } ?>
        <div class="pull-right">
            <a href="pages/cetak/cetak_lapsalahresep.php?awal=<?php echo $_POST['awal']; ?>&akhir=<?php echo $_POST['akhir']; ?>" class="btn btn-danger <?php if($_POST['awal']=="") { echo "disabled"; }?>" target="_blank">Cetak Lap Salah Resep</a> 
        </div>
        </div>
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-blue">
          <tr>
            <th><div align="center">No</div></th>
            <th><div align="center">&nbsp;&nbsp;&nbsp; Aksi &nbsp;&nbsp;&nbsp;</div></th>
            <th><div align="center">Tgl</div></th>
            <th><div align="center">Nokk</div></th>
            <th><div align="center">Langganan</div></th>
            <th><div align="center">Buyer</div></th>
            <th><div align="center">PO</div></th>
            <th><div align="center">Order</div></th>
            <th><div align="center">Jenis Kain</div></th>
            <th><div align="center">No Warna</div></th>
            <th><div align="center">Warna</div></th>
            <th><div align="center">Lot</div></th>
            <th><div align="center">Roll</div></th>
            <th><div align="center">Qty</div></th>
            <th><div align="center">Jenis Kesalahan</div></th>
            <th><div align="center">Penanggung Jawab 1</div></th>
            <th><div align="center">Penanggung Jawab 2</div></th>
            <th><div align="center">Ket</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
            $no=1;
            if($Awal!=""){
            $qry1=mysqli_query($con,"SELECT a.*, a.id as id_a, d.* 
            FROM tbl_salahresep a 
            LEFT JOIN tbl_hasilcelup b ON a.id_celup=b.id
            LEFT JOIN tbl_montemp c ON b.id_montemp=c.id 
            LEFT JOIN tbl_schedule d ON c.id_schedule=d.id 
            WHERE DATE_FORMAT( a.tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' ORDER BY a.id ASC");
            }else{
                $qry1=mysqli_query($con,"SELECT a.*, d.* 
                FROM tbl_salahresep a 
                LEFT JOIN tbl_hasilcelup b ON a.id_celup=b.id
                LEFT JOIN tbl_montemp c ON b.id_montemp=c.id 
                LEFT JOIN tbl_schedule d ON c.id_schedule=d.id 
                WHERE DATE_FORMAT( a.tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' ORDER BY a.id ASC");
            }
			while($row1=mysqli_fetch_array($qry1)){
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><div class="btn-group">
            <a href="#" class="btn btn-danger btn-xs <?php if($_SESSION['akses']=='biasa'){ echo "disabled"; } ?>" onclick="confirm_delete('index1.php?p=hapusdatasalahresep&id=<?php echo $row1['id_a']; ?>');"><i class="fa fa-trash"></i> </a></div></td>
            <td align="center"><?php echo $row1['tgl_buat'];?></td>
            <td><?php echo $row1['nokk'];?></td>
            <td><?php echo $row1['langganan'];?></td>
            <td><?php echo $row1['buyer'];?></td>
            <td align="center"><?php echo $row1['po'];?></td>
            <td align="center"><?php echo $row1['no_order'];?></td>
            <td><?php echo $row1['jenis_kain'];?></td>
            <td align="center"><?php echo $row1['no_warna'];?></td>
            <td align="center"><?php echo $row1['warna'];?></td>
            <td align="center"><?php echo $row1['lot'];?></td>
            <td align="right"><?php echo $row1['rol'];?></td>
            <td align="right"><?php echo $row1['bruto'];?></td>
            <td align="right"><?php echo $row1['jenis_kesalahan'];?></td>
            <td align="center"><?php echo $row1['t_jawab1'];?></td>
            <td align="center"><?php echo $row1['t_jawab2'];?></td>
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