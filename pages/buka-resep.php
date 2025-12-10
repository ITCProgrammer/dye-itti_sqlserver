<?PHP
	ini_set("error_reporting", 1);
	session_start();
	include "koneksi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Buka Resep</title>
</head>

<body>
	<div class="row">
        <!-- <div class="col-xs-12">
			<div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"> Filter Data Buka Resep</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                    <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                    <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <select name="gshift" class="form-control pull-right">
                                    <option disabled selected value="-">Pilih Group Shift</option>
                                    <option value="ALL">ALL</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="cek_resep" class="form-control pull-right">
                                    <option disabled selected value="-">Status Cek Resep</option>
                                    <option value="ALL">ALL</option>
                                    <option value="Resep Ok">Resep Ok</option>
                                    <option value="Resep Tidak Ok">Resep Tidak Ok</option>
                                </select>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-block btn-social btn-linkedin btn-sm" name="submit" style="width: 60%">Search <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
			</div>
		</div> -->
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
                    <div class="row" style="padding: 10px;">
                        <div class="col-md-12">
                            <form method="post" enctype="multipart/form-data" name="form1" class="form-inline">
                                <div class="form-group" style="margin-right: 15px;">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" 
                                        value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>">
                                </div>
                                <div class="form-group" style="margin-right: 15px;">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" class="form-control" 
                                        value="<?= isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>">
                                </div>
                                <button type="submit" class="btn btn-info" name="submit" style="margin-top: -5px;"><i class="fa fa-search"></i> Cari</button>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <a href="?p=Form-Buka-Resep" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                    </div>
                </div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-hover table-striped" width="100%">
						<thead class="bg-blue">
							<tr>
								<th width="26"><div align="center">No.</div></th>
								<th width="26"><div align="center">No. Kartu Kerja</div></th>
								<th width="26"><div align="center">No. Demand</div></th>
								<th width="165"><div align="center">Pelanggan</div></th>
								<th width="165"><div align="center">Buyer</div></th>
                                <th width="121"><div align="center">No. Order</div></th>
								<th width="125"><div align="center">Jenis Kain</div></th>
								<th width="88"><div align="center">Warna</div></th>
								<th width="85"><div align="center">Bon Resep 1 <br> Suffix</div></th>
								<th width="85"><div align="center">Bon Resep 2 <br> Suffix 2</div></th>
								<th width="71"><div align="center">Operator Buka Resep</div></th>
								<th width="90"><div align="center">Ket Resep</div></th>
								<th width="98"><div align="center">Action</div></th>
							</tr>
						</thead>
						<tbody>
                            <?php
                                if(!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
                                    $start_date = $_POST['start_date'];
                                    $end_date = $_POST['end_date'];
                                    $sql_bukaresep = "SELECT * FROM db_dying.tbl_bukaresep 
                                                      WHERE cek_resep IS NULL 
                                                        AND CONVERT(date, createdatetime) BETWEEN ? AND ?";
                                    $params_bukaresep = array($start_date, $end_date);
                                    $q_bukaresep = sqlsrv_query($con, $sql_bukaresep, $params_bukaresep);
                                } else {
                                    $start_date = date('Y-m-d');
                                    $sql_bukaresep = "SELECT * FROM db_dying.tbl_bukaresep 
                                                      WHERE cek_resep IS NULL 
                                                        AND CONVERT(date, createdatetime) = ?";
                                    $params_bukaresep = array($start_date);
                                    $q_bukaresep = sqlsrv_query($con, $sql_bukaresep, $params_bukaresep);
                                }
                                $no = 1;
                            ?>
                            <?php while ($row_bukaresep = sqlsrv_fetch_array($q_bukaresep, SQLSRV_FETCH_ASSOC)) { ?>
                                <tr bgcolor="antiquewhite">
                                    <td align="center"><?= $no++; ?></td>
                                    <td align="center"><?= $row_bukaresep['nokk'] ?></td>
                                    <td align="center"><?= $row_bukaresep['nodemand'] ?></td>
                                    <td align="center"><?= $row_bukaresep['langganan'] ?></td>
                                    <td align="center"><?= $row_bukaresep['buyer']; ?></td>
                                    <td align="center"><?= $row_bukaresep['no_order'] ?></td>
                                    <td align="center"><?= $row_bukaresep['jenis_kain'] ?></td>
                                    <td align="center"><?= $row_bukaresep['warna'] ?></td>
                                    <td align="center"><?= $row_bukaresep['noresep1'].'<br>'.$row_bukaresep['suffix1'] ?></td>
                                    <td align="center"><?= $row_bukaresep['noresep2'].'<br>'.$row_bukaresep['suffix2'] ?></td>
                                    <td align="center"><?= $row_bukaresep['personil']; ?></td>
                                    <td align="center"><?= $row_bukaresep['ket_resep']; ?></td>
                                    <td>
										<div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#cekresep<?= $row_bukaresep['id'] ?>">
                                                <i class="fa fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="Cek Resep"></i> Cek Resep
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="cekresep<?= $row_bukaresep['id'] ?>"  role="dialog" aria-labelledby="cekresep" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">CEK RESEP</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="hidden" value="<?= $row_bukaresep['id'] ?>" name="id">
                                                            <label for="nokk" class="col-sm-4 control-label">Cek Resep</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control" name="cek_resep">
                                                                    <option disabled selected value="">Dipilih</option>
                                                                    <option value="Bon Resep Sesuai">Bon Resep Sesuai</option>
                                                                    <option value="Bon Resep Tidak Sesuai">Bon Resep Tidak Sesuai</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="form-group">
                                                            <label for="nokk" class="col-sm-4 control-label">Keterangan</label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" name="ket_resep"></textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <div class="form-group">
                                                            <label for="nokk" class="col-sm-4 control-label">Diperiksa oleh</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control" name="diperiksa_oleh">
                                                                    <option selected disabled value="-">Dipilih</option>
                                                                    <option value="TAS">TAS</option>
                                                                    <?php
                                                                        $sql_staff = "SELECT * FROM db_dying.tbl_staff 
                                                                                      WHERE NOT jabatan = 'Operator' 
                                                                                        AND NOT jabatan = 'Staff' 
                                                                                        AND NOT jabatan = 'Leader' 
                                                                                        AND NOT jabatan = 'Colorist' 
                                                                                        AND NOT jabatan = 'Asst. SPV'";
                                                                        $q_staff = sqlsrv_query($con, $sql_staff);
                                                                    ?>
                                                                    <?php while ($row_staff = sqlsrv_fetch_array($q_staff, SQLSRV_FETCH_ASSOC)) { ?>
                                                                        <option value="<?= $row_staff['nama']; ?>"><?= $row_staff['nama']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary pull-right" name="save" value="save">Simpan <i class="fa fa-save"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            <?php } ?>
						</tbody>
						<tfoot class="bg-red">
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
	if (isset($_POST['save']) && $_POST['save'] == "save") {
        $sql_simpan = "UPDATE db_dying.tbl_bukaresep SET 
                            cek_resep = ?,
                            ket_resep = ?,
                            diperiksa_oleh = ?
                        WHERE id = ?";
        $params_simpan = array(
            $_POST['cek_resep'],
            $_POST['ket_resep'],
            $_POST['diperiksa_oleh'],
            $_POST['id']
        );
        $q_simpan = sqlsrv_query($con, $sql_simpan, $params_simpan);
        if($q_simpan){
            echo "<script>swal({
                    title: 'Data Tersimpan',   
                    text: 'Klik Ok untuk input data kembali',
                    type: 'success',
                    }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=buka-resep'; 
                    }
                });</script>";
        }
    }
?>
