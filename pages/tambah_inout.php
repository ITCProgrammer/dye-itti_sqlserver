<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysqli_query($con,"SELECT * FROM `tbl_dokumen` WHERE id='$modal_id' ");
while($r=mysqli_fetch_array($modal)){
	$modal1=mysqli_query($con,"SELECT * FROM `tbl_dokumen_detail` WHERE id_dokumen='$modal_id' ORDER BY id DESC ");
	$r1=mysqli_fetch_array($modal1)
?>
          <div class="modal-dialog">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=tambah_inout_simpan" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah In-Out</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <div class="form-group">
                  <label for="sts" class="col-md-3 control-label">Status</label>
                  <div class="col-md-4">
                  <select name="sts" class="form-control" id="sts">
							  	<option value="">Pilih</option>	
					  			<option value="Masuk" <?php if($r1['sts']=="Masuk"){ echo "hidden";} ?>>Masuk</option>
					  			<option value="Keluar" <?php if($r1['sts']=="Keluar"){ echo "hidden";} ?>>Keluar</option>
				  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
				  <div class="form-group">
                  <label for="tgl" class="col-sm-3 control-label">Tanggal</label>
				  <div class="col-sm-4">					  
				  <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value=""/>
          </div>
				  </div>
					  
		</div>
                  <div class="form-group">
                  <label for="catatan" class="col-md-3 control-label">Catatan</label>
                  <div class="col-md-8">
                  <textarea name="catatan" class="form-control" id="catatan"></textarea>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
			  	  <div class="form-group">
				  <div class="col-md-8"><i>Status Terakhir: <?php echo "<span class='label label-warning'>".$r1['sts']."</span>, ".$r1['tgl_status'].", ".$r1['catatan'];?></i></div>
			      </div>  
              </div>
			  	  
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Save</button>
              </div>
            </form>
				
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
          <?php } ?>
<script>
		//Date picker
        $('#datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
        });		
</script>