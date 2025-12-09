<?php
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
$tgl1    = $_POST['tgl1'];
$tgl2    = $_POST['tgl2'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Matching Dyeing</title>
</head>

<body>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-sm-2">
                        <a href="?p=Form-Matching-Dyeing" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambaha</a>
                    </div>
                    <div class="col-sm-4">
                        <form action="" method="POST">
                            <input type="date" name="tgl1" class="input-sm" value="<?= $tgl1; ?>"> S/D
                            <input type="date" name="tgl2" class="input-sm" value="<?= $tgl2; ?>">
                            <button type="submit" class="btn btn-primary btn-sm" name="sort"><i class="fa fa-search"></i> Sort</button>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
                        <thead class="bg-blue">
                            <tr>
                                <th width="26">
                                    <div align="center">No.</div>
                                </th>
                                <th width="26">
                                    <div align="center">No. Kartu Kerja</div>
                                </th>
                                <th width="26">
                                    <div align="center">No. Demand</div>
                                </th>
                                <th width="26">
                                    <div align="center">Pelanggan</div>
                                </th>
                                <th width="26">
                                    <div align="center">Buyer</div>
                                </th>
                                <th width="26">
                                    <div align="center">No. Order</div>
                                </th>
                                <th width="26">
                                    <div align="center">Jenis Kain</div>
                                </th>
                                <th width="26">
                                    <div align="center">Warna</div>
                                </th>
                                <th width="26">
                                    <div align="center">Jam Terima</div>
                                </th>
                                <th width="26">
                                    <div align="center">Operator Penerima</div>
                                </th>
                                <th width="26">
                                    <div align="center">Jam Proses</div>
                                </th>
                                <th width="26">
                                    <div align="center">Operator Matcher</div>
                                </th>
                                <th width="98">
                                    <div align="center">Action</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($tgl1 && $tgl2) {
                                $_sortTgl = "DATE_FORMAT( SUBSTR(createdatetime, 1,10), '%Y-%m-%d' ) BETWEEN '$tgl1' AND '$tgl2'";
                            } else {
                                $_sortTgl = "SUBSTR(createdatetime, 1,10) BETWEEN DATE_SUB(SUBSTR(NOW(), 1,10), INTERVAL 1 DAY) AND SUBSTR(NOW(), 1,10)";
                            }
                            $q_matching_dye    = mysqli_query($con, "SELECT * FROM tbl_matching_dyeing WHERE $_sortTgl ORDER BY id DESC");
                            $no = 1;
                            ?>
                            <?php while ($row_matching_dye = mysqli_fetch_array($q_matching_dye)) { ?>
                                <tr bgcolor="antiquewhite">
                                    <td align="center"><?= $no++; ?></td>
                                    <td align="center"><?= $row_matching_dye['nokk'] ?></td>
                                    <td align="center"><?= $row_matching_dye['nodemand'] ?></td>
                                    <td align="center"><?= $row_matching_dye['langganan'] ?></td>
                                    <td align="center"><?= $row_matching_dye['buyer'] ?></td>
                                    <td align="center"><?= $row_matching_dye['no_order'] ?></td>
                                    <td align="center"><?= $row_matching_dye['jenis_kain'] ?></td>
                                    <td align="center"><?= $row_matching_dye['warna'] ?></td>
                                    <td align="center"><?= $row_matching_dye['jam_terima'] ?></td>
                                    <td align="center"><?= $row_matching_dye['operator_penerima'] ?></td>
                                    <?php
                                    $q_history_terakhir     = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]' ORDER BY id DESC LIMIT 1");
                                    $row_history_terakhir   = mysqli_fetch_assoc($q_history_terakhir);
                                    ?>
                                    <td align="center"><?= $row_history_terakhir['creationdatetime'] ?></td>
                                    <td align="center"><?= $row_history_terakhir['operator_matcher'] ?></td>
                                    <td>
                                        <div class="btn-group">

                                            <p>
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#tahapan_matching<?= $row_matching_dye['id'] ?>">
                                                    <i class="fa fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="Tahapan Matching"></i> Tahapan Matching
                                                </button>
                                            </p>

                                            <p>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#matching_dyeing<?= $row_matching_dye['id'] ?>">
                                                    <i class="fa fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="Matching Dyeing"></i> Matching Dyeing
                                                </button>
                                            </p>

                                            <p>
                                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#acc_matching_dyeing<?= $row_matching_dye['id'] ?>">
                                                    <i class="fa fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="Matching Dyeing"></i> Acc Matching Dyeing
                                                </button>
                                            </p>

                                            <p>
                                                <a href="pages/cetak/reports-form-matching-print.php?&id=<?= $row_matching_dye['id']; ?>" class="btn btn-warning btn-xs" target="_blank" data-toggle="tooltip" data-html="true" title="Print Form Matching">
                                                    <i class="fa fa-print"></i> Print Form Matching
                                                </a>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal ACC MATCHING-->
                                <div class="modal fade" id="acc_matching_dyeing<?= $row_matching_dye['id'] ?>" role="dialog" aria-labelledby="cekresep" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">ACC MATCHING DYEING</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <?php
                                                $q_history_matching     = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]' ORDER BY id DESC LIMIT 1");
                                                $row_history_matching   = mysqli_fetch_assoc($q_history_matching);
                                                // cek sudah acc resep atau blm
                                                $acc_or_no    = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]' AND acc_resep != '' AND acc_resep IS NOT NULL ORDER BY id DESC LIMIT 1");
                                                $cek_acc = mysqli_num_rows($acc_or_no);
                                                ?>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?= $row_matching_dye['id'] ?>" name="id_matching">
                                                                <label class="col-sm-3 control-label">Acc Resep</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control select2" style="width: 100%" name="acc_resep">
                                                                        <option selected disabled value="-">Dipilih</option>
                                                                        <?php
                                                                        $q_staff = mysqli_query($con, "SELECT * FROM tbl_staff ");
                                                                        ?>
                                                                        <?php while ($row_staff     = mysqli_fetch_array($q_staff)) { ?>
                                                                            <option value="<?= $row_staff['nama']; ?>" <?php if ($row_staff['nama'] == $row_matching_dye['acc_resep']) {
                                                                                                                            echo "SELECTED";
                                                                                                                        } ?>><?= $row_staff['nama']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="nokk" class="col-sm-3 control-label">Percobaan Resep Ke</label>
                                                                <div class="col-sm-9">
                                                                    <select name="percobaan_ke" class="form-control select2" style="width: 100%">
                                                                        <option value="" disabled selected>Pilih percobaan ke</option>
                                                                        <?php
                                                                        $q_percobaanke  = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]'");
                                                                        ?>
                                                                        <?php while ($row_percobaanke     = mysqli_fetch_array($q_percobaanke)) { ?>
                                                                            <option value="<?= $row_percobaanke['ok_ke']; ?>" <?php if ($_POST['ok_ke'] == $row_percobaanke['id']) {
                                                                                                                                    echo "SELECTED";
                                                                                                                                } ?>>
                                                                                percobaan ke -<?= $row_percobaanke['ok_ke']; ?>
                                                                                Pemberi Resep : (<?= $row_percobaanke['pemberi_resep']; ?>),
                                                                                Operator Matcher : (<?= $row_percobaanke['operator_matcher']; ?>),
                                                                                Note : (<?= $row_percobaanke['note']; ?>)
                                                                                Time : (<?= $row_percobaanke['creationdatetime']; ?>)
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <!-- cek sudah acc resep atau blm -->
                                                    <?php if ($cek_acc < 1) { ?>
                                                        <button type="submit" class="btn btn-primary pull-right" name="update_acc" value="save">Simpan <i class="fa fa-save"></i></button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal MATCHING DYEING-->
                                <div class="modal fade" id="matching_dyeing<?= $row_matching_dye['id'] ?>" role="dialog" aria-labelledby="cekresep" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">MATCHING DYEING</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <?php
                                                $q_history_matching     = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]' ORDER BY id DESC LIMIT 1");
                                                $row_history_matching   = mysqli_fetch_assoc($q_history_matching);
                                                ?>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?= $row_matching_dye['id'] ?>" name="id_matching">
                                                                <label class="col-sm-4 control-label">Pemberi Resep</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control select2" style="width: 100%" name="pemberi_resep">
                                                                        <option selected disabled value="-">Dipilih</option>
                                                                        <?php
                                                                        $q_staff = mysqli_query($con, "SELECT * FROM tbl_staff ");
                                                                        ?>
                                                                        <?php while ($row_staff     = mysqli_fetch_array($q_staff)) { ?>
                                                                            <option value="<?= $row_staff['nama']; ?>" <?php if ($row_staff['nama'] == $row_history_matching['pemberi_resep']) {
                                                                                                                            echo "SELECTED";
                                                                                                                        } ?>><?= $row_staff['nama']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <!-- <div class="form-group">
                                                                <input type="hidden" value="<?= $row_matching_dye['id'] ?>" name="id">
                                                                <label class="col-sm-4 control-label">Acc Resep</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control select2" style="width: 100%" name="acc_resep">
                                                                        <option selected disabled value="-">Dipilih</option>
                                                                        <?php
                                                                        $q_staff = mysqli_query($con, "SELECT * FROM tbl_staff ");
                                                                        ?>
                                                                        <?php while ($row_staff     = mysqli_fetch_array($q_staff)) { ?>
                                                                            <option value="<?= $row_staff['nama']; ?>" <?php if ($row_staff['nama'] == $row_matching_dye['acc_resep']) {
                                                                                                                            echo "SELECTED";
                                                                                                                        } ?>><?= $row_staff['nama']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br> -->
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label">Percobaan sebelumnya </label>
                                                                <div class="col-sm-8">
                                                                    <?php
                                                                    $ke   = $row_history_matching['ok_ke'];
                                                                    if ($ke) {
                                                                        $where_ke   = $row_history_matching['ok_ke'];
                                                                    } else {
                                                                        $where_ke   = '0';
                                                                    }
                                                                    ?>
                                                                    <input class="form-control" type="text" value="<?= $where_ke; ?>" disabled readonly>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="nokk" class="col-sm-4 control-label">Percobaan selanjutnya ke</label>
                                                                <div class="col-sm-8">
                                                                    <select name="ok_ke" class="form-control select2" style="width: 100%">
                                                                        <?php
                                                                        $q_percobaanke  = mysqli_query($con, "SELECT * FROM tbl_percobaanke WHERE ke > $where_ke");
                                                                        ?>
                                                                        <?php while ($row_percobaanke     = mysqli_fetch_array($q_percobaanke)) { ?>
                                                                            <option value="<?= $row_percobaanke['ke']; ?>" <?php if ($_POST['ok_ke'] == $row_percobaanke['ke']) {
                                                                                                                                echo "SELECTED";
                                                                                                                            } ?>><?= $row_percobaanke['ke']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?= $row_history_matching['id'] ?>" name="id">
                                                                <label class="col-sm-4 control-label">Operator Matcher</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control select2" style="width: 100%" name="operator_matcher">
                                                                        <option selected disabled value="-">Dipilih</option>
                                                                        <?php
                                                                        $q_staff = mysqli_query($con, "SELECT * FROM tbl_staff ");
                                                                        ?>
                                                                        <?php while ($row_staff     = mysqli_fetch_array($q_staff)) { ?>
                                                                            <option value="<?= $row_staff['nama']; ?>" <?php if ($row_staff['nama'] == $row_history_matching['operator_matcher']) {
                                                                                                                            echo "SELECTED";
                                                                                                                        } ?>><?= $row_staff['nama']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="nokk" class="col-sm-4 control-label">Note</label>
                                                                <div class="col-sm-8">
                                                                    <textarea class="form-control" name="note"><?= $row_history_matching['note']; ?></textarea>
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
                                <!-- Modal TAHAPAN MATCHING -->
                                <div class="modal fade" id="tahapan_matching<?= $row_matching_dye['id'] ?>" role="dialog" aria-labelledby="tahapan" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">TAHAPAN MATCHING</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <?php
                                                $q_history_matching     = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]' ORDER BY id DESC LIMIT 1");
                                                $row_history_matching   = mysqli_fetch_assoc($q_history_matching);
                                                $q_tahapan_history_matching     = mysqli_query($con, "SELECT * FROM tbl_tahapan_matching_history WHERE id_matching = '$row_matching_dye[id]' ORDER BY id DESC LIMIT 1");
                                                $datalengthtahapan  = mysqli_num_rows($q_tahapan_history_matching);
                                                $datatahapan  = mysqli_fetch_assoc($q_tahapan_history_matching);

                                                ?>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?= $row_matching_dye['id'] ?>" name="id_matching">
                                                                <label class="col-sm-4 control-label">Operator Matcher</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control select2" style="width: 100%" name="operator_matcher">
                                                                        <option selected disabled value="-">Dipilih</option>
                                                                        <?php
                                                                        $q_staff = mysqli_query($con, "SELECT * FROM tbl_staff ");
                                                                        ?>
                                                                        <?php while ($row_staff     = mysqli_fetch_array($q_staff)) { ?>
                                                                            <option value="<?= $row_staff['nama']; ?>" <?php if ($row_staff['nama'] == $row_history_matching['operator_matcher']) {
                                                                                                                            echo "SELECTED";
                                                                                                                        } ?>><?= $row_staff['nama']; ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label">Tahapan</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control select2" style="width: 100%" name="tahapan">
                                                                        <option selected disabled value="-">-- Pilih Tahapan --</option>
                                                                        <?php
                                                                        $q_tahapan = mysqli_query($con, "SELECT * FROM tbl_tahapan_matching");
                                                                        while ($row_tahapan = mysqli_fetch_array($q_tahapan)) {
                                                                        ?>
                                                                            <option value="<?= $row_tahapan['id'] . '|' . $row_tahapan['name']; ?>">
                                                                                <?= $row_tahapan['name']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="nokk" class="col-sm-4 control-label">Percobaan Resep Ke</label>
                                                                <div class="col-sm-8">
                                                                    <select name="percobaan_ke" class="form-control select2" style="width: 100%">
                                                                        <?php
                                                                        $q_percobaan = mysqli_query($con, "SELECT * FROM tbl_percobaanke WHERE ke >= $where_ke ORDER BY id ASC");
                                                                        $q_percobaanke  = mysqli_query($con, "SELECT * FROM tbl_matching_history WHERE id_matching = '$row_matching_dye[id]' order by 'ok_ke' DESC limit 1");
                                                                        $percobaan_terakhir = mysqli_fetch_assoc($q_percobaanke);
                                                                        ?>
                                                                        <?php while ($row_percobaan     = mysqli_fetch_array($q_percobaan)) { ?>
                                                                            <option value="<?= $row_percobaan['ke']; ?>" <?php if ($row_percobaan['ke'] == $row_history_matching['operator_matcher']) {
                                                                                                                                echo "SELECTED";
                                                                                                                            } ?>><?= $row_percobaan['ke']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary pull-right" name="simpan_tahapan" value="simpan_tahapan">Simpan <i class="fa fa-save"></i></button>
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
<!-- SAVE TAHAPAN -->
<?php
if (isset($_POST['simpan_tahapan'])) {
    // Mendapatkan nilai tahapan dari formulir
    $tahapan_value = $_POST['tahapan'];

    // Memisahkan ID dan nama tahapan
    list($tahapan_id, $tahapan_name) = explode('|', $tahapan_value);


    $queryinserthistory     = "INSERT INTO tbl_tahapan_matching_history SET
                                            id_matching = '$_POST[id_matching]',
                                            operator_matcher = '$_POST[operator_matcher]',
                                            tahapan = ' $tahapan_name',
                                            id_tahapan = '$tahapan_id',
                                            percobaan_ke = '$_POST[percobaan_ke]',
                                            created_at = now()";

    $q_simpan   = mysqli_query($con, $queryinserthistory);
    if ($q_simpan) {
        echo "<script>swal({
                    title: 'Percobaan Berhasil di simpan',   
                    text: 'Klik Ok untuk input data kembali',
                    type: 'success',
                    }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=Matching-Dyeing'; 
                    }
                });</script>";
    } else {
        echo "<script>swal({
                title: 'Percobaan Gagal di simpan',   
                text: 'Klik Ok untuk input data kembali',
                type: 'warning',
                }).then((result) => {
                if (result.value) {
                    window.location.href='?p=Matching-Dyeing'; 
                }
            });</script>";
    }
}
?>
<!-- UPDATE ACC WARNA -->
<?php
if (isset($_POST['update_acc'])) {
    $acc_resep =    $_POST['acc_resep'];
    $id_matching = $_POST['id_matching'];
    $percobaan_ke = $_POST['percobaan_ke'];

    $queryupdateacc_resep = "UPDATE tbl_matching_history SET `acc_resep` = '$acc_resep', acc_creationdatetime = now() WHERE id_matching = '$id_matching' AND ok_ke = '$percobaan_ke'";


    $q_update  = mysqli_query($con, $queryupdateacc_resep);
    if ($q_update) {
        echo "<script>swal({
                    title: 'Berhasil Acc',   
                    text: 'Klik Ok untuk input data kembali',
                    type: 'success',
                    }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=Matching-Dyeing'; 
                    }
                });</script>";
    } else {
        echo "<script>swal({
                title: 'Gagal Acc',   
                text: 'Klik Ok untuk input data kembali',
                type: 'warning',
                }).then((result) => {
                if (result.value) {
                    window.location.href='?p=Matching-Dyeing'; 
                }
            });</script>";
    }
}
?>
<?php
if (isset($_POST['save'])) {
    $queryinserthistory     = "INSERT INTO tbl_matching_history SET
                                            id_matching = '$_POST[id_matching]',
                                            pemberi_resep = '$_POST[pemberi_resep]',
                                            acc_resep = '$_POST[acc_resep]',
                                            ok_ke = '$_POST[ok_ke]',
                                            operator_matcher = '$_POST[operator_matcher]',
                                            note = '$_POST[note]',
                                            creationdatetime = now()";
    $q_simpan   = mysqli_query($con, $queryinserthistory);
    if ($q_simpan) {
        echo "<script>swal({
                    title: 'Percobaan Berhasil di simpan',   
                    text: 'Klik Ok untuk input data kembali',
                    type: 'success',
                    }).then((result) => {
                    if (result.value) {
                        window.location.href='?p=Matching-Dyeing'; 
                    }
                });</script>";
    } else {
        echo "<script>swal({
                title: 'Percobaan Gagal di simpan',   
                text: 'Klik Ok untuk input data kembali',
                type: 'warning',
                }).then((result) => {
                if (result.value) {
                    window.location.href='?p=Matching-Dyeing'; 
                }
            });</script>";
    }
}
?>