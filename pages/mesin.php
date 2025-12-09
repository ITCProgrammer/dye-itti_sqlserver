<?php
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";

if (isset($_POST['delete'])) {
        $id = $_POST['delete_id'];

        // Mengamankan input terhadap SQL Injection
        $id = mysqli_real_escape_string($con, $id);

        // Query untuk menghapus item
        $sql = "DELETE FROM tbl_mesin WHERE id='$id'";

        if (mysqli_query($con, $sql)) {
          $_SESSION['message'] = "Data mesin berhasil dihapus.";
        } else {
          $_SESSION['message'] = "Error deleting record: " . mysqli_error($con);
        }

        // Set a flag to indicate that the deletion process is complete
        echo '<script type="text/javascript">
          sessionStorage.setItem("deleteMessage", "' . $_SESSION['message'] . '");
          window.location = "https://online.indotaichen.com/dye-itti/index1.php?p=Mesin";
        </script>';
  exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mesin</title>
</head>

<body>
  <?php
  if (isset($_SESSION['message'])) {
    echo '
      <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="messageModalLabel">Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ' . $_SESSION['message'] . '
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
            <script>
              $(document).ready(function(){
                $("#messageModal").modal("show");
              });
            </script>
            ';
    unset($_SESSION['message']);
  }

  $data = mysqli_query($con, "SELECT * FROM tbl_mesin ORDER BY no_mesin ASC");
  $no = 1;
  $col = 0;
  ?>
  <div class="container mt-4">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <a href="#" data-toggle="modal" data-target="#DataMesin" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add</a>
          </div>
          <div class="box-body">
            <table width="100%" class="table table-bordered table-hover display" id="example2">
              <thead class="bg-blue">
                <tr align="center">
                  <td width="3%"><strong>No</strong></td>
                  <td width="12%"><strong>Nama Mesin</strong></td>
                  <td width="12%"><strong>No. Mesin</strong></td>
                  <td width="11%"><strong>L:R</strong></td>
                  <td width="15%"><strong>Kapasitas</strong></td>
                  <td width="37%"><strong>Note</strong></td>
                  <td width="10%"><strong>Action</strong></td>
                </tr>
              </thead>
              <tbody>
                <?php
                $col = 0;
                while ($rowd = mysqli_fetch_array($data)) {
                  $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                ?>
                  <tr align="center" bgcolor="<?php echo $bgcolor; ?>">
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $rowd['kode']; ?></td>
                    <td align="center"><?php echo $rowd['no_mesin']; ?></td>
                    <td align="center"><?php echo $rowd['l_r']; ?></td>
                    <td align="center"><?php echo $rowd['kapasitas']; ?></td>
                    <td align="center"><?php echo $rowd['ket']; ?></td>
                    <td align="center">
                      <a href="#" id='<?php echo $rowd['id'] ?>' class="btn btn-info mesin_edit"><i class="fa fa-edit"></i> </a>
                      <?php
                                            // Hanya tampilkan tombol delete untuk pengguna Lukman dan Andri
                                            if ($_SESSION['user_id10'] == 'lukman' || $_SESSION['user_id10'] == 'andri'|| $_SESSION['user_id10'] == 'dit') {
                                            ?>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $rowd['id']; ?>"><i class="fa fa-trash"></i></button>
                                            <?php
                                            }
                                            ?>
                      
                    </td>
                  </tr>
                  <?php
                  $no++;
                  ?>
                  <!-- Modal Delete -->
                  <div class="modal fade" id="deleteModal<?php echo $rowd['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $rowd['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel<?php echo $rowd['id']; ?>">Confirm Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this item?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          <form method="post" action="">
                            <input type="hidden" name="delete_id" value="<?php echo $rowd['id']; ?>">
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </tbody>
            </table>
            <div class="modal fade modal-super-scaled" id="DataMesin">
              <div class="modal-dialog ">
                <div class="modal-content">
                  <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=simpan_mesin" enctype="multipart/form-data">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Data Mesin</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="kode" class="col-md-3 control-label">Nama Mesin</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" id="kode" name="kode" required>
                          <span class="help-block with-errors"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="no_mesin" class="col-md-3 control-label">No Mesin</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" id="no_mesin" name="no_mesin" required>
                          <span class="help-block with-errors"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="l_r" class="col-md-3 control-label">L:R</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" id="l_r" name="l_r" required>
                          <span class="help-block with-errors"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="kap" class="col-md-3 control-label">Kapasitas</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" id="kap" name="kap" required>
                          <span class="help-block with-errors"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="sts" class="col-md-3 control-label">Note</label>
                        <div class="col-md-6">
                          <textarea name="note" class="form-control" id="note"></textarea>
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
            </div>
            <!-- Modal Popup untuk Edit-->
            <div id="MesinEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>