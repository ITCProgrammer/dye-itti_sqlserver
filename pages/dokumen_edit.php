<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysqli_query($con,"SELECT * FROM `tbl_dokumen` WHERE id='$modal_id' ");
while($r=mysqli_fetch_array($modal)){
?>
          <div class="modal-dialog">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_dokumen_simpan" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Data Document</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
                  <div class="form-group">
                  <label for="dok" class="col-md-3 control-label">Nama Dokumen</label>
                  <div class="col-md-8">
                  <input type="text" class="form-control" id="dok" name="dok" value="<?php echo $r['nama_dokumen'];?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="nodok" class="col-md-3 control-label">No Dokumen</label>
                  <div class="col-md-4">
                  <input type="text" class="form-control" id="nodok" name="nodok" value="<?php echo $r['no_dokumen'];?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
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