<?PHP
ini_set("error_reporting", 1);
session_start();
$conLab=mysqli_connect("10.0.0.10","dit","4dm1n","db_laborat");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Setting Resep Dye</title>

</head>
<body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$RCode	= isset($_POST['rcode']) ? $_POST['rcode'] : '';
	
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"> Filter Setting Resep Dye</h3>
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
            <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Aprrove Awal" value="<?php echo $Awal; ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
      <div class="form-group">
        <div class="col-sm-2">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Aprrove Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off"/>
          </div>
        </div>
        <!-- /.input group -->
      </div>
      <div class="form-group">
        <div class="col-sm-2">
          <input name="rcode" type="text" class="form-control pull-right" id="rcode" placeholder="RCode" value="<?php echo $RCode;  ?>" />
        </div>
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
        <h3 class="box-title">Data Setting Resep Dye</h3><br>
        <?php if($_POST['awal']!="") { ?><b>Periode: <?php echo $_POST['awal']." to ".$_POST['akhir']; ?></b>
		<?php } ?>
        <!-- <div class="pull-right">
            <a href="pages/cetak/cetak_lapsalahresep.php?awal=<?php echo $_POST['awal']; ?>&akhir=<?php echo $_POST['akhir']; ?>" class="btn btn-danger <?php if($_POST['awal']=="") { echo "disabled"; }?>" target="_blank">Cetak Lap Salah Resep</a> 
        </div> -->
        </div>
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
        <thead class="bg-blue">
          <tr>
            <th><div align="center">No</div></th>
            <th><div align="center">&nbsp;&nbsp;&nbsp; Aksi &nbsp;&nbsp;&nbsp;</div></th>
            <th><div align="center">RCode</div></th>
            <th><div align="center">No. Order</div></th>
            <th><div align="center">Langganan</div></th>
            <th><div align="center">Warna</div></th>
            <th><div align="center">No. Warna</div></th>
            <th><div align="center">No. Item</div></th>
            <th><div align="center">PO Greige</div></th>
            <th><div align="center">Cocok Warna</div></th>
            <th><div align="center">Tgl Approve</div></th>
            </tr>
        </thead>
        <tbody>
          <?php
            $no=1;
            if($RCode!=""){$idm=" AND a.idm='$RCode' ";}else{$idm=" ";}
            if($Awal!=""){$tgl=" AND DATE_FORMAT( a.approve_at, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' ";}else{$tgl=" ";}
            if($Awal!="" OR $RCode!=""){
                $qry1=mysqli_query($conLab,"SELECT a.id as id_status, a.created_at as tgl_buat_status, a.created_by as status_created_by, b.id as id_matching,
                a.grp, a.matcher, a.idm, b.no_order, b.langganan, b.no_warna, b.warna, b.no_item, b.no_po, b.cocok_warna, a.approve_at, a.status
                FROM tbl_status_matching a
                JOIN tbl_matching b ON a.idm = b.no_resep
                where (a.status = 'arsip' OR a.status= 'selesai') $tgl $idm");
            }else{
                $qry1=mysqli_query($conLab,"SELECT a.id as id_status, a.created_at as tgl_buat_status, a.created_by as status_created_by, b.id as id_matching,
                a.grp, a.matcher, a.idm, b.no_order, b.langganan, b.no_warna, b.warna, b.no_item, b.no_po, b.cocok_warna, a.approve_at, a.status
                FROM tbl_status_matching a
                JOIN tbl_matching b ON a.idm = b.no_resep
                where DATE_FORMAT( a.approve_at, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir'");
            }
			while($row1=mysqli_fetch_array($qry1)){
		 ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><div class="btn-group">
            <a style="color: black;" target="_blank" href="pages/cetak/setting-resep.php?idkk=<?php echo $row1['idm'] ?>" class="btn btn-xs btn-warning">Print ! &nbsp;<i class="fa fa-print"></i></a></div></td>
            <td align="center"><?php echo $row1['idm'];?></td>
            <td><?php echo $row1['no_order'];?></td>
            <td><?php echo $row1['langganan'];?></td>
            <td><?php echo $row1['warna'];?></td>
            <td><?php echo $row1['no_warna'];?></td>
            <td><?php echo $row1['no_item'];?></td>
            <td><?php echo $row1['no_po'];?></td>
            <td><?php echo $row1['cocok_warna'];?></td>
            <td><?php echo substr($row1["approve_at"], 0, 10);?></td>
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