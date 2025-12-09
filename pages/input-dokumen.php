<?PHP
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dokumen</title>
</head>

<body>
<?php 

	
	?>	
<?php
   $data=mysqli_query($con,"SELECT * FROM tbl_dokumen ORDER BY id DESC");
	$no=1;
	$n=1;
	$c=0;
	 ?>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
  <a href="#" data-toggle="modal" data-target="#InputDokumen" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
</div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
          <thead class="bg-blue">
            <tr>
			  <th width="24"><div align="center">No.</div></th>
			  <th width="107"><div align="center">Tgl Buat</div></th>
			  <th width="193"><div align="center">Nama Dokumen</div></th>
			  <th width="117"><div align="center">No. Dokumen</div></th>
			  <th width="83"><div align="center">Posisi</div></th>
              <th width="83"><div align="center">Status</div></th>
              <th width="207"><div align="center">Catatan</div></th>
              <th width="95"><div align="center">Action</div></th>
            </tr>
          </thead>
          <tbody>
            <?php
	  $col=0;
	   			  
  while($rowd=mysqli_fetch_array($data)){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	  		$qDetail=mysqli_query($con,"SELECT * FROM tbl_dokumen_detail WHERE id_dokumen='$rowd[id]' ORDER BY id DESC");
	  	    $rDetail=mysqli_fetch_array($qDetail);
	  		$rJDetail=mysqli_num_rows($qDetail);	
		 ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td align="center"><?php echo $no;?></td>
              <td align="center"><?php echo date('d F Y', strtotime($rowd['tgl_buat']));?></td>
              <td align="left"><?php echo $rowd['nama_dokumen'];?></td>
              <td align="left"><?php echo $rowd['no_dokumen'];?></td>
              <td align="left"><a href="#" id='<?php echo $rowd['id']; ?>' class="detail_inout"><span class="label <?php if($rDetail['sts']=="Masuk"){ echo "label-success"; }else if($rDetail['sts']=="Keluar"){ echo "label-danger";}  ?> "><?php if($rJDetail>0){echo $rDetail['sts'];}?></span></a><br><font size="-1"><i><?php if($rJDetail>0){echo date('d F Y', strtotime($rDetail['tgl_status']));}?></i></font></td>
              <td align="center"><a href="#" id='<?php echo $rowd['id']; ?>' class="edit_sts_dok label <?php if($rowd['sts']=="Pending"){ echo "label-warning";}else if($rowd['sts']=="Cancel"){ echo "label-danger";}else if($rowd['sts']=="OK"){ echo "label-success";}else if($rowd['sts']=="Review"){ echo "label-info";}?>"><?php echo $rowd['sts'];?></a></td>
              <td align="left"><?php if($rJDetail>0){echo $rDetail['catatan'];}else{echo $rowd['catatan'];};?><br></td>
              <td align="center"><div class="btn-group"><a href="#" id='<?php echo $rowd['id']; ?>' class="btn btn-xs btn-warning tambah_inout"><i class="fa fa-plus"></i> </a><a href="#" id='<?php echo $rowd['id']; ?>' class="btn btn-xs btn-info dokumen_edit"><i class="fa fa-edit"></i> </a><a href="#" onclick="confirm_del('?p=dok_hapus&id=<?php echo $rowd['id'] ?>');" class="btn btn-xs btn-danger <?php if($rJDetail>0){echo "disabled"; } ?>"><i class="fa fa-trash"></i> </a></div></td>
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
<div class="modal fade modal-super-scaled" id="InputDokumen">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=simpan_dokumen" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Dokumen</h4>
              </div>
              <div class="modal-body">
				  <div class="form-group">
                  <label for="dok" class="col-md-3 control-label">Nama Dokumen</label>
                  <div class="col-md-8">
                  <input type="text" class="form-control" id="dok" name="dok" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="nodok" class="col-md-3 control-label">No Dokumen</label>
                  <div class="col-md-4">
                  <input type="text" class="form-control" id="nodok" name="nodok" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="catatan" class="col-md-3 control-label">Catatan</label>
                  <div class="col-md-8">
                  <textarea name="catatan" class="form-control" id="catatan"></textarea>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>	
<!-- Modal Popup untuk delete-->
	<div class="modal fade" id="delDok" tabindex="-1">
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
	<div id="TambahInOut" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
	<div id="DetailInOut" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
	<div id="EditStsDok" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
	<div id="EditDok" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>
</body>
</html>
<script type="text/javascript">
              function confirm_del(delete_url) {
                $('#delDok').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('del_link').setAttribute('href', delete_url);
              }

            </script>