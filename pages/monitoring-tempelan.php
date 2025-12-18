<?PHP
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
include "helpers.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Monitoring-Tempelan</title>
</head>

<body>
    <?php
    $query_main = "SELECT
                        *,
                        b.buyer,
                        b.no_order,
                        b.warna,
                        b.nokk,
                        b.nodemand,
                        a.tgl_update,
                        a.id AS idm,
                        b.id AS ids,
                        c.id AS idstm,
                        a.g_shift AS sft
                    FROM
                        db_dying.tbl_montemp a
                    LEFT JOIN db_dying.tbl_schedule b ON
                        a.id_schedule = b.id
                    LEFT JOIN db_dying.tbl_setting_mesin c ON
                        b.nokk = c.nokk
                    LEFT JOIN db_dying.tbl_bakbul d ON
                        c.nokk = d.no_kk
                    WHERE
                        ( a.status = 'antri mesin'
                            OR a.status = 'sedang jalan' )
                        AND ( b.status = 'antri mesin'
                            OR b.status = 'sedang jalan' )
                    ORDER BY
                        a.id ASC";
    $data = sqlsrv_query($con, $query_main);
    $no = 1;
    $n = 1;
    $c = 0;
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="?p=Form-Monitoring" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah Celup</a>
                    <a href="?p=Form-Monitoring-Washing" class="btn btn-warning"><i class="fa fa-plus-circle"></i> Tambah Washing</a>
                    <a href="?p=Form-Monitoring-CB" class="btn btn-info"><i class="fa fa-plus-circle"></i> Tambah CB</a>
                    <a href="?p=Form-Monitoring-BakBul" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Bakar Bulu</a>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
                        <thead class="bg-blue">
                            <tr>
                                <th width="45">
                                    <div align="center">Mesin</div>
                                </th>
                                <th width="55">
                                    <div align="center">Shift</div>
                                </th>
                                <th width="564">
                                    <div align="center">Cetak</div>
                                </th>
                                <th width="96">
                                    <div align="center">Buyer</div>
                                </th>
                                <th width="83">
                                    <div align="center">Order</div>
                                </th>
                                <th width="92">
                                    <div align="center">Warna</div>
                                </th>
                                <th width="92">
                                    <div align="center">Jam Masuk Kain<br>Jam Aktual Input</div>
                                </th>
                                <th width="89">
                                    <div align="center">Proses</div>
                                </th>
                                <th width="89">
                                    <div align="center">Keterangan</div>
                                </th>
                                <th width="64">
                                    <div align="center">Action</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $col = 0;
                            while ($rowd = sqlsrv_fetch_array($data)) {
                                $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                                $query_cek = "SELECT TOP 1 
                                                    id as idb 
                                                FROM 
                                                    db_dying.tbl_hasilcelup 
                                                WHERE 
                                                    id_montemp='$rowd[idm]'";
                                // echo $query_cek;
                                $qCek = sqlsrv_query($con, $query_cek);
                                $rCEk = sqlsrv_fetch_array($qCek);
                            ?>
                                <tr bgcolor="<?php echo $bgcolor; ?>">
                                    <td align="center"><?php echo $rowd['no_mesin']; ?></td>
                                    <td align="center">
                                        <a href="#" id='<?php echo $rowd['idm']; ?>' class="btn btn-xs bg-purple edit_shift <?php if ($_SESSION['lvl_id10'] == "3") { /*echo "disabled";*/ } ?>">
                                            <?php echo $rowd['sft']; ?>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <div class="btn-group">
                                            <?php if ($rowd['no_mesin'] == "WS") { ?> 
                                                <a href="pages/cetak/cetak_monitoring_new.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-warning">Monitoring</a> 
                                                <a href="pages/cetak/cetak.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-success">Tempelan</a> 
                                                <a href="pages/cetak/cetak_depan.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-warning">Relaxing</a> 
                                            <?php } else if ($rowd['no_mesin'] == "CB") { ?> 
                                                <a href="pages/cetak/cetak_monitoring_new.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-warning">Monitoring</a> 
                                                <a href="pages/cetak/cetak.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-success">Tempelan</a> <a href="pages/cetak/cetak_depan_cb.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-primary">C-Bleaching</a>
                                            <?php } else { ?> 
                                                <a href="pages/cetak/cetak_monitoring_new.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-warning">Monitoring</a> 
                                                <a href="pages/cetak/cetak.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-success">Tempelan</a> 
                                                <a href="pages/cetak/cetak_qcf.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-warning">Tempelan Cocok Warna QCF</a> 
                                            <?php } ?> 
                                            <a href="pages/cetak/simpan_cetak.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&id=" target="_blank" class="btn btn-xs btn-info">Resep 1</a>
                                            <?php if ($rowd['no_resep2'] != "" or $rowd['no_resep2'] != NULL) { ?>
                                                <a href="pages/cetak/simpan_cetak2.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep2']; ?>&id=" target="_blank" class="btn btn-xs btn-info">Resep 2</a>
                                            <?php } ?>
                                            <a href="pages/cetak/cetak_setting_mesin.php?idstm=<?php echo $rowd['idstm']; ?>&nokk=<?php echo $rowd['nokk']; ?>" target="_blank" class="btn btn-xs btn-danger">Setting Mesin</a>
                                            <a href="pages/cetak/aktivitas.php?idkk=<?php echo $rowd['nokk']; ?>&no=<?php echo $rowd['no_resep']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>" target="_blank" class="btn btn-xs btn-primary">Form Aktivitas</a>
                                            <a href="pages/cetak/Monitoring_air.php?idkk=<?php echo $rowd['nokk']; ?>&nodemand=<?php echo $rowd['nodemand']; ?>&idm=<?php echo $rowd['idm']; ?>&ids=<?php echo $rowd['ids']; ?>&ids=<?php echo $rowd['ids']; ?>"
                                                target="_blank" class="btn btn-xs btn-primary bg-purple">Form Monitoring AIR</a>
                                        </div>
                                    </td>
                                    <td align="center"><?php echo $rowd['buyer']; ?></td>
                                    <td align="center"><?php echo $rowd['no_order']; ?></td>
                                    <td align="left"><?php echo $rowd['warna']; ?></td>
                                    <td align="left">
                                        <?php if ($_SESSION['lvl_id10'] == "5") : ?>
                                            <a href="#" id='<?php echo $rowd['idm']; ?>' class="btn btn-xs bg-purple edit_jammasukkain">
                                                <?php echo formatDateTime($rowd['jammasukkain'], "Y-m-d H:i:s"); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo formatDateTime($rowd['jammasukkain'],"Y-m-d H:i:s"); ?>
                                        <?php endif; ?>
                                        <br><br>
                                        <span class="label bg-red">
                                            <?php echo formatDateTime($rowd['tgl_update'],"Y-m-d H:i:s"); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $rowd['proses']; ?><br><i><?php echo $rowd['tgl_buat']; ?></i><br><i class="btn btn-xs bg-hijau"><?php echo $rowd['operator']; ?></i></td>
                                    <td align="left"><span class="label bg-abu"><?php echo $rowd['nokk']; ?></span><br><?php echo $rowd['ket']; ?></td>
                                    <td align="center">
                                        <div class="btn-group">
                                            <a href="#<?php echo $rowd['idm']; ?>" id='<?php echo $rowd['idm']; ?>' class="btn btn-xs btn-info stop_edit <?php if ($_SESSION['lvl_id10'] == "3") { /*echo "disabled";*/
                                                                                                                                } ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="#" onclick="confirm_del2('?p=mtr_hapus&id=<?php echo $rowd['idm'] ?>');" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <?php if ($_SESSION['lvl_id10'] == "5") : ?>
                                                <a href="#" id='<?php echo $rowd['idm']; ?>' class="btn btn-xs btn-info stop_edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
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
    <!-- Modal Popup untuk delete-->
    <div class="modal fade" id="delSchedule" tabindex="-1">
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
    <div id="StopMesin" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <div id="EditShift" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <div id="EditJamMasukKain" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
</body>

</html>
<script type="text/javascript">
    function confirm_del(delete_url) {
        $('#delSchedule').modal('show', {
            backdrop: 'static'
        });
        document.getElementById('del_link').setAttribute('href', delete_url);
    }

    function confirm_del2(url) {
        if (confirm("Yakin ingin menghapus?\nData yang dihapus tidak dapat dikembalikan.")) {
            window.location.href = url;
        } else {
        }
    }

</script>