<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Potong-Celup</title>
</head>

<body>
<?php
   $data=mysqli_query($con,"SELECT a.*,b.k_resep,b.acc_keluar,
   b.operator_keluar,b.shift as shift_keluar,
   b.g_shift as g_shift_keluar,c.comment_warna,c.acc,c.ket,c.id as idb,c.disposisi from tbl_schedule a
     INNER JOIN tbl_montemp d ON a.id=d.id_schedule
	 INNER JOIN tbl_hasilcelup b ON d.id=b.id_montemp
	 INNER JOIN tbl_potongcelup c ON b.id=c.id_hasilcelup
	 ORDER BY c.id DESC LIMIT 100");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
  <a href="?p=Form-Potong" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
      </div>
      <div class="box-body">
        <table id="example2" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th><div align="center">No</div></th>
              <th width="168"><div align="center">NOKK</div></th>
              <th width="151" align="left"><div align="center">MC</div></th>
              <th width="144"><div align="center">Langganan</div></th>
              <th width="141"><div align="center">Order</div></th>
              <th width="158"><div align="center">Jenis Kain</div></th>
              <th width="158"><div align="center">Warna</div></th>
              <th width="125"><div align="center">Proses</div></th>
              <th width="81"><div align="center">Ket</div></th>
              <th width="117"><div align="center">Acc Ket</div></th>
              <th width="81"><div align="center">Disposisi</div></th>
              <th width="81"><div align="center">Action</div></th>
            </tr>
          </thead>
          <tbody>
            <?php
	  $col=0;
  while($rowd=mysqli_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td align="center"><?php echo $no; ?></td>
              <td align="center"><?php echo $rowd['nokk'];?></td>
              <td align="center"><?php echo $rowd['no_mesin'];?></td>
              <td align="center" style="font-size: 11px;"><?php echo $rowd['langganan'];?></td>
              <td align="center"><?php echo $rowd['no_order'];?></td>
              <td align="left" style="font-size: 10px;"><?php echo $rowd['jenis_kain'];?></td>
              <td align="center" style="font-size: 11px;"><?php echo $rowd['warna'];?></td>
              <td align="left"><?php echo $rowd['proses'];?><br><i class="btn btn-xs bg-hijau"><?php echo $rowd['operator'];?></i></td>
              <td><span class="label <?php if($rowd['ket']=="Tolak Basah BW"){echo "label-warning";}else if($rowd['ket']=="Tolak Basah Luntur"){ echo "label-danger";}?>"><?php echo $rowd['ket'];?></span></td>
              <td align="center"><?php echo $rowd['acc'];?></td>
              <td align="center"><?php echo $rowd['disposisi'];?></td>
			  <td align="center"><div class="btn-group"><a href="pages/cetak/cetak_celup.php?id=<?php echo $rowd['idb'] ?>" class="btn btn-xs btn-warning" target="_blank"><i class="fa fa-print"></i> </a><a href="#" id='<?php echo $rowd['idb']; ?>' class="btn btn-xs btn-info potong_edit"><i class="fa fa-edit"></i> </a><a href="#" onclick="confirm_del('?p=ptg_hapus&id=<?php echo $rowd['idb'] ?>');" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </a></div></td>
            </tr>
            <?php
						$no++;
  } ?>
          </tbody>
          <tfoot class="bg-red">
          </tfoot>
        </table>
      </div>
</div>
</div>
</div>
<!-- Modal Popup untuk delete-->
	<div class="modal fade" id="delSchedule" tabindex="-1">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
		  </div>

		  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
			<a href="#" class="btn btn-danger" id="del_link">Delete</a>
			<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div> 
<div id="PotongEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>	
</body>
</html>
<script type="text/javascript">
              function confirm_del(delete_url) {
                $('#delSchedule').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('del_link').setAttribute('href', delete_url);
              }

            </script>