<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$modal_id = $_GET['id'];
$modal = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_staff WHERE id='$modal_id' ");
while ($r = sqlsrv_fetch_array($modal)) {
?>
  <div class="modal-dialog ">
    <div class="modal-content">
      <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_staff" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Data Staff</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id" name="id" value="<?php echo $r['id']; ?>">
          <div class="form-group">
            <label for="nama" class="col-md-3 control-label">Nama</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $r['nama']; ?>" required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="jabatan" class="col-md-3 control-label">Jabatan</label>
            <div class="col-md-4">
              <select name="jabatan" id="jabatan" class="form-control">
                <option value="Operator" <?php if ($r['jabatan'] == "Operator") {
                                            echo "SELECTED";
                                          } ?>>Operator</option>
                <option value="Staff" <?php if ($r['jabatan'] == "Staff") {
                                        echo "SELECTED";
                                      } ?>>Staff</option>
                <option value="Colorist" <?php if ($r['jabatan'] == "Colorist") {
                                            echo "SELECTED";
                                          } ?>>Colorist</option>
                <option value="Leader" <?php if ($r['jabatan'] == "Leader") {
                                          echo "SELECTED";
                                        } ?>>Leader</option>
                <option value="Asst. SPV" <?php if ($r['jabatan'] == "Asst. SPV") {
                                            echo "SELECTED";
                                          } ?>>Asst. SPV</option>
                <option value="SPV" <?php if ($r['jabatan'] == "SPV") {
                                      echo "SELECTED";
                                    } ?>>SPV</option>
                <option value="Asst. Manager" <?php if ($r['jabatan'] == "Asst. Manager") {
                                                echo "SELECTED";
                                              } ?>>Asst. Manager</option>
                <option value="Manager" <?php if ($r['jabatan'] == "Manager") {
                                          echo "SELECTED";
                                        } ?>>Manager</option>
                <option value="Senior Manager" <?php if ($r['jabatan'] == "Senior Manager") {
                                                  echo "SELECTED";
                                                } ?>>Senior Manager</option>
                <option value="DMF">DMF</option>
              </select>
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