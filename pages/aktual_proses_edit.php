<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
  $modal_id=$_GET['id'];
	$modal=sqlsrv_query($con,"SELECT * FROM db_dying.tbl_hasilcelup WHERE id='$modal_id'");
while($r=sqlsrv_fetch_array($modal, SQLSRV_FETCH_ASSOC)){
?>
          <div class="modal-dialog">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_aktual_proses" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Aktual Proses</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <div class="form-group">
                  <label for="a_proses" class="col-md-3 control-label">Aktual Proses</label>
                  <div class="col-md-8">
                  <select name="a_proses" class="form-control" id="a_proses">
							  	<option value="">Pilih</option>
					  			<?php
								$sqlKap = sqlsrv_query($con, "SELECT proses FROM db_dying.tbl_proses ORDER BY proses ASC");
								while ($rK = sqlsrv_fetch_array($sqlKap, SQLSRV_FETCH_ASSOC)) {
								?>
									<option value="<?php echo $rK['proses']; ?>" <?php if($r['proses'] == $rK['proses']) { echo "SELECTED"; } ?>><?php echo $rK['proses']; ?></option>
								<?php } ?>
				  </select>
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
