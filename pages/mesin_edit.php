<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$modal_id = $_GET['id'];
$modal = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_mesin WHERE id='$modal_id' ");
while ($r = sqlsrv_fetch_array($modal)) {
?>
  <div class="modal-dialog ">
    <div class="modal-content">
      <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_mesin" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Mesin</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id" name="id" value="<?php echo $r['id']; ?>">
          <div class="form-group">
            <label for="kode" class="col-md-3 control-label">Nama Mesin</label>
            <div class="col-md-3">
              <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $r['kode']; ?>" required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="kode" class="col-md-3 control-label">No Mesin</label>
            <div class="col-md-3">
              <input type="text" class="form-control" id="no_mesin" name="no_mesin" value="<?php echo $r['no_mesin']; ?>" required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="kap" class="col-md-3 control-label">Kapasitas</label>
            <div class="col-md-3">
              <input type="text" class="form-control" id="kap" name="kap" value="<?php echo $r['kapasitas']; ?>" required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="l_r" class="col-md-3 control-label">L:R</label>
            <div class="col-md-3">
              <input type="text" class="form-control" id="l_r" name="l_r" value="<?php echo $r['l_r']; ?>" required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="note" class="col-md-3 control-label">Note</label>
            <div class="col-md-6">
              <textarea name="note" class="form-control" id="note"><?php echo $r['ket']; ?></textarea>
              <span class="help-block with-errors"></span>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
<?php } ?>