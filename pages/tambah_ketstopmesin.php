<?php
    ini_set("error_reporting", 1);
    session_start();
    include("../koneksi.php");
?>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Input Data Keterangan Buka Resep</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nokk" class="col-sm-3 control-label">Keterangan Stop Mesin</label>
					<div class="col-sm-8">
						<input name="ket_stopmesin" type="text" class="form-control">
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
		</div>
	</div>
</form>
<div class="col-xs-12">
    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
                <thead class="bg-blue">
                    <tr>
                        <th width="26"><div align="center">Keterangan Stop Mesin</div></th>
                        <th width="26"><div align="center">Action</div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $q_ket_stopmesin    = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_ket_stopmesin ORDER BY id ASC");
                        $no = 1;
                    ?>
                    <?php while ($row_ket_stopmesin = sqlsrv_fetch_array($q_ket_stopmesin)) { ?>
                        <tr bgcolor="antiquewhite">
                            <td align="center"><?= $row_ket_stopmesin['ket_stopmesin'] ?></td>
                            <td align="center">
                                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
                                    <input type="hidden" name="id" value="<?= $row_ket_stopmesin['id']; ?>">
                                    <button type="submit" class="btn btn-xs btn-danger" name="delete" value="delete">Hapus <i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
	if ($_POST['save'] == "save") {
        $sql = "INSERT INTO db_dying.tbl_ket_stopmesin (ket_stopmesin) VALUES (?)";
        $params = [$_POST['ket_stopmesin']];
        $q_simpan = sqlsrv_query($con, $sql, $params);
    if ($q_simpan) {
        echo "<script>
                swal({
                    title: 'Data Tersimpan',   
                    text: 'Klik Ok untuk input data kembali',
                    type: 'success',
                }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=tambah_ketstopmesin'; 
                    }
                });
              </script>";
    } else {
        echo "<pre>INSERT ERROR:\n";
        print_r(sqlsrv_errors());
        echo "</pre>";
    }
    } else if($_POST['delete'] == 'delete'){
        $sql = "DELETE FROM db_dying.tbl_ket_stopmesin WHERE id = ?";
        $params = [$_POST['id']];
        $q_hapus = sqlsrv_query($con, $sql, $params);

        if ($q_hapus) {
            echo "<script>
                    swal({
                        title: 'Data telah terhapus',   
                        text: 'Klik Ok untuk input data kembali',
                        type: 'success',
                    }).then((result) => {
                        if (result.value) {
                            window.location.href='?p=tambah_ketstopmesin'; 
                        }
                    });
                </script>";
        } else {
            echo "<pre>DELETE ERROR:\n";
            print_r(sqlsrv_errors());
            echo "</pre>";
        }
    }
?>