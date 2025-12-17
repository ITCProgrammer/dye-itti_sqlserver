<?php
    ini_set("error_reporting", 1);
    session_start();
    include("../koneksi.php");
    $modal_id = $_GET['id'];
    $modal = sqlsrv_query($con, "SELECT
                                    *,
                                    FORMAT(tgl_stop, 'yyyy-MM-dd') AS tglS,
                                    FORMAT( tgl_stop, 'HH:mm' ) AS jamS,
                                    FORMAT( tgl_mulai, 'yyyy-MM-dd' ) AS tglM,
                                    FORMAT( tgl_mulai, 'HH:mm' ) AS jamM,
                                    FORMAT( tgl_stop2, 'yyyy-MM-dd' ) AS tglS2,
                                    FORMAT( tgl_stop2, 'HH:mm' ) AS jamS2,
                                    FORMAT( tgl_mulai2, 'yyyy-MM-dd' ) AS tglM2,
                                    FORMAT( tgl_mulai2, 'HH:mm' ) AS jamM2,
                                    FORMAT( tgl_stop3, 'yyyy-MM-dd' ) AS tglS3,
                                    FORMAT( tgl_stop3, 'HH:mm' ) AS jamS3,
                                    FORMAT( tgl_mulai3, 'yyyy-MM-dd' ) AS tglM3,
                                    FORMAT( tgl_mulai3, 'HH:mm' ) AS jamM3,
                                    FORMAT( tgl_stop4, 'yyyy-MM-dd' ) AS tglS4,
                                    FORMAT( tgl_stop4, 'HH:mm' ) AS jamS4,
                                    FORMAT( tgl_mulai4, 'yyyy-MM-dd' ) AS tglM4,
                                    FORMAT( tgl_mulai4, 'HH:mm' ) AS jamM4
                                FROM
                                    db_dying.tbl_montemp
                                WHERE
                                    id = '$modal_id'");
    while ($r = sqlsrv_fetch_array($modal)) {
        $query_lama = "SELECT
                            b.tgl_target,
                            CASE 
                                WHEN b.tgl_target < GETDATE() THEN
                                    '-' +
                                    RIGHT('0' + CAST(ABS(DATEDIFF(SECOND, b.tgl_target, GETDATE())) / 3600 AS VARCHAR(2)), 2)
                                    + ':' +
                                    RIGHT('0' + CAST((ABS(DATEDIFF(SECOND, b.tgl_target, GETDATE())) % 3600) / 60 AS VARCHAR(2)), 2)
                                ELSE
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, b.tgl_target, GETDATE()) / 3600 AS VARCHAR(2)), 2)
                                    + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, b.tgl_target, GETDATE()) % 3600) / 60 AS VARCHAR(2)), 2)
                            END AS lama,
                            b.id 
                        FROM
                            db_dying.tbl_schedule a
                            LEFT JOIN db_dying.tbl_montemp b ON a.id = b.id_schedule 
                        WHERE
                            b.id = '$modal_id' 
                            AND b.STATUS = 'sedang jalan' 
                        ORDER BY
                            a.no_urut ASC";
        $qLama = sqlsrv_query($con, $query_lama);
        $dLama = sqlsrv_fetch_array($qLama);
?>
    <style>
        /* Gaya untuk judul */
        .title {
            text-align: center;
            /* Pusatkan teks */
            margin-bottom: 20px;
            /* Ruang di bawah judul */
        }

        /* Gaya untuk garis horizontal */
        .hr-style {
            display: flex;
            /* Menggunakan flexbox */
            align-items: center;
            /* Pusatkan vertikal */
        }

        /* Gaya untuk garis horizontal dalam baris */
        .hr-line {
            flex-grow: 1;
            /* Biarkan garis horizontal memperluas seluruh lebar */
            border-top: 1px solid black;
            /* Garis horizontal */
        }

        /* Gaya untuk teks di tengah garis horizontal */
        .hr-text {
            padding: 0 10px;
            /* Ruang di sekitar teks */
        }
    </style>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_stop" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <center>Edit Stop - Start Mesin</center>
                    </h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" value="<?php echo $r['id']; ?>">
                    <input type="hidden" id="sisa_waktu" name="sisa_waktu" value="<?php echo $dLama['lama']; ?>">

                    <!-- KODE STOP MESIN 1 -->
                    <div class="hr-style">
                        <div class="hr-line"></div>
                        <div class="hr-text">Kode Stop Mesin 1</div>
                        <div class="hr-line"></div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_stop" placeholder="00:00" value="<?= $r['jamS']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <!-- <input name="tgl_stop" type="text" class="form-control pull-right" id="datepicker3" max="2023-11-21" placeholder="0000-00-00" value="<?php echo $r['tglS']; ?>" /> -->
                                <input name="tgl_stop" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglS']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_mulai" placeholder="00:00" value="<?php echo $r['jamM']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <!-- <input name="tgl_mulai" type="text" class="form-control pull-right" id="datepicker"  placeholder="0000-00-00" value="<?php echo $r['tglM']; ?>" /> -->
                                <input name="tgl_mulai" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglM']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multi" class="col-sm-3 control-label">Keterangan Stop Mesin</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="ket_stopmesin" id="ket_stopmesin">
                                  <option value="" disabled <?= empty($r['ket_stopmesin']) ? 'selected' : '' ?>>-</option>
                                  <?php
                                    $query_stop = "SELECT 
                                                    * 
                                                  FROM 
                                                    db_dying.tbl_ket_stopmesin 
                                                  ORDER BY 
                                                    id ASC";
                                    $q_ket_stopmesin = sqlsrv_query($con, $query_stop);
                                    while ($row_ket_stopmesin = sqlsrv_fetch_array($q_ket_stopmesin)) {
                                      $val = htmlspecialchars($row_ket_stopmesin['ket_stopmesin'], ENT_QUOTES, 'UTF-8');
                                      $sel = (!empty($r['ket_stopmesin']) && $r['ket_stopmesin'] == $row_ket_stopmesin['ket_stopmesin']) ? 'selected' : '';
                                      echo "<option value=\"$val\" $sel>$val</option>";
                                    }
                                  ?>
                                </select>
                                <span class="input-group-btn"><a target="_blank" href="?p=tambah_ketstopmesin" class="btn btn-default">...</a></span>
                            </div>
                        </div>
                    </div>

                    <!-- KODE STOP MESIN 2 -->
                    <div class="hr-style">
                        <div class="hr-line"></div>
                        <div class="hr-text">Kode Stop Mesin 2</div>
                        <div class="hr-line"></div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_stop2" placeholder="00:00" value="<?php echo $r['jamS2']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="tgl_stop2" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglS2']; ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_mulai2" placeholder="00:00" value="<?php echo $r['jamM2']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="tgl_mulai2" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglM2']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multi" class="col-sm-3 control-label">Keterangan Stop Mesin</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="ket_stopmesin2" id="ket_stopmesin2">
                                  <option value="" disabled <?= empty($r['ket_stopmesin2']) ? 'selected' : '' ?>>-</option>
                                  <?php
                                    $query_stop = "SELECT 
                                                    * 
                                                  FROM 
                                                    db_dying.tbl_ket_stopmesin 
                                                  ORDER BY 
                                                    id ASC";
                                    $q_ket_stopmesin = sqlsrv_query($con, $query_stop);
                                    while ($row_ket_stopmesin = sqlsrv_fetch_array($q_ket_stopmesin)) {
                                      $val = htmlspecialchars($row_ket_stopmesin['ket_stopmesin'], ENT_QUOTES, 'UTF-8');
                                      $sel = (!empty($r['ket_stopmesin2']) && $r['ket_stopmesin2'] == $row_ket_stopmesin['ket_stopmesin']) ? 'selected' : '';
                                      echo "<option value=\"$val\" $sel>$val</option>";
                                    }
                                  ?>
                                </select>
                                <span class="input-group-btn"><a target="_blank" href="?p=tambah_ketstopmesin" class="btn btn-default">...</a></span>
                            </div>
                        </div>
                    </div>

                    <!-- KODE STOP MESIN 3 -->
                    <div class="hr-style">
                        <div class="hr-line"></div>
                        <div class="hr-text">Kode Stop Mesin 3</div>
                        <div class="hr-line"></div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_stop3" placeholder="00:00" value="<?php echo $r['jamS3']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="tgl_stop3" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglS3']; ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_mulai3" placeholder="00:00" value="<?php echo $r['jamM3']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="tgl_mulai3" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglM3']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multi" class="col-sm-3 control-label">Keterangan Stop Mesin</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="ket_stopmesin3">
                                    <option value="" disabled selected>-</option>
                                    <?php
                                        $query_stop = "SELECT 
                                                        * 
                                                    FROM 
                                                        db_dying.tbl_ket_stopmesin 
                                                    ORDER BY 
                                                        id ASC";
                                        $q_ket_stopmesin = sqlsrv_query($con, $query_stop);
                                        while ($row_ket_stopmesin = sqlsrv_fetch_array($q_ket_stopmesin)) {
                                        $val = htmlspecialchars($row_ket_stopmesin['ket_stopmesin'], ENT_QUOTES, 'UTF-8');
                                        $sel = (!empty($r['ket_stopmesin3']) && $r['ket_stopmesin3'] == $row_ket_stopmesin['ket_stopmesin']) ? 'selected' : '';
                                        echo "<option value=\"$val\" $sel>$val</option>";
                                        }
                                    ?>
                                </select>
                                <span class="input-group-btn"><a target="_blank" href="?p=tambah_ketstopmesin" class="btn btn-default">...</a></span>
                            </div>
                        </div>
                    </div>

                    <!-- KODE STOP MESIN 4 -->
                    <div class="hr-style">
                        <div class="hr-line"></div>
                        <div class="hr-text">Kode Stop Mesin 4</div>
                        <div class="hr-line"></div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="mulaism" class="col-sm-3 control-label">Mulai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_stop4" placeholder="00:00" value="<?php echo $r['jamS4']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="tgl_stop4" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglS4']; ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="selesaism" class="col-sm-3 control-label">Selesai Stop Mesin</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="jam_mulai4" placeholder="00:00" value="<?php echo $r['jamM4']; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="tgl_mulai4" type="date" class="form-control pull-right" max="<?= Date('Y-m-d'); ?>" placeholder="0000-00-00" value="<?php echo $r['tglM4']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multi" class="col-sm-3 control-label">Keterangan Stop Mesin</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="ket_stopmesin4">
                                    <option value="" disabled selected>-</option>
                                    <?php
                                        $query_stop = "SELECT 
                                                        * 
                                                    FROM 
                                                        db_dying.tbl_ket_stopmesin 
                                                    ORDER BY 
                                                        id ASC";
                                        $q_ket_stopmesin = sqlsrv_query($con, $query_stop);
                                        while ($row_ket_stopmesin = sqlsrv_fetch_array($q_ket_stopmesin)) {
                                        $val = htmlspecialchars($row_ket_stopmesin['ket_stopmesin'], ENT_QUOTES, 'UTF-8');
                                        $sel = (!empty($r['ket_stopmesin4']) && $r['ket_stopmesin4'] == $row_ket_stopmesin['ket_stopmesin']) ? 'selected' : '';
                                        echo "<option value=\"$val\" $sel>$val</option>";
                                        }
                                    ?>
                                </select>
                                <span class="input-group-btn"><a target="_blank" href="?p=tambah_ketstopmesin" class="btn btn-default">...</a></span>
                            </div>
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
<script>
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
    //Date picker
    $('#datepicker3').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
    //Timepicker
    $('#timepicker').timepicker({
        showInputs: false,
    });

    $(function() {
        //Timepicker
        $('.timepicker').timepicker({
            minuteStep: 1,
            showInputs: true,
            showMeridian: false,
            defaultTime: false

        })
    })
</script>