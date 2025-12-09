<?php
    ini_set("error_reporting", 1);
    session_start();
    include("../koneksi.php");
?>
<?php $no_mc = $_GET['id']; ?>
<div class="modal-dialog modal-lg" style="width: 95%">
    <div class="modal-content">
        <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=status_mesin_edit" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">No Mesin :
                    <?php echo $_GET['id']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <table id="tbl3" class="table table-bordered table-hover display" width="100%">
                    <thead class="btn-primary">
                        <tr>
                            <th width="10%">No Urut</th>
                            <th width="10%">Std Target</th>
                            <th width="5%">No KK</th>
                            <th width="7%">Buyer</th>
                            <th width="7%">Costumer</th>
                            <th width="7%">PO</th>
                            <th width="7%">Order</th>
                            <th width="7%">Hanger</th>
                            <th width="7%">Lot</th>
                            <th width="7%">Warna</th>
                            <th width="7%">Proses</th>
                            <th width="7%">Tgl Delivery</th>
                            <th width="11%">Ket</th>
                            <th width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($no_mc == "WS" or $no_mc == "CB" or $no_mc == "WS11" or $no_mc == "CB11" or $no_mc == "BB11") {
                            $where = " ";
                            $where1 = " ";
                        } else {
                            // $where = "AND NOT a.no_urut='1'";
                            $where = " ";
                            $where1 = " ";
                        }

                        $qry = mysqli_query($con, "SELECT
                                                        *,
                                                        IF(DATEDIFF( now(), tgl_delivery ) > 0, 'Urgent',
                                                        IF(DATEDIFF( now(), tgl_delivery ) > - 4, 'Potensi Delay', '' )) AS `sts` 
                                                    FROM
                                                        tbl_schedule a
                                                    WHERE a.no_mesin='" . $_GET['id'] . "' AND NOT `status` = 'selesai' $where 
                                                    ORDER BY a.no_urut ASC");
                        $no = 1;

                        $c = 0;
                        while ($rowd = mysqli_fetch_array($qry)) {
                            $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    $allowed_users = ['dit', 'bayu', 'haryadi', 'jubay', 'ketut', 'lukman', 'husni.juniar'];
                                    $current_user = strtolower($_SESSION['user_id10']);
                                    $is_allowed_user = in_array($current_user, $allowed_users);
                                    $is_operator_for_bb11 = ($current_user === 'operator' && $_GET['id'] === 'BB11');
                                    $is_editable = $is_allowed_user || $is_operator_for_bb11;
                                    ?>

                                    <?php if ($is_editable) : ?>
                                        <select name="no_urut[<?php echo $rowd['id']; ?>]" class="form-control">
                                            <option value="">Pilih</option>
                                            <?php
                                            $sqlKap = mysqli_query($con, "SELECT no_urut FROM tbl_urut $where1 ORDER BY no_urut ASC");
                                            while ($rK = mysqli_fetch_array($sqlKap)) {
                                                $selected = ($rK['no_urut'] == $rowd['no_urut']) ? 'SELECTED' : '';
                                                echo "<option value='{$rK['no_urut']}' $selected>{$rK['no_urut']}</option>";
                                            }
                                            ?>
                                        </select>
                                    <?php else : ?>
                                        <?= $rowd['no_urut']; ?>
                                        <input type="hidden" name="no_urut[<?php echo $rowd['id']; ?>]" value="<?= $rowd['no_urut']; ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                        <?php if ($_SESSION['lvl_id10'] == "5") : ?>
                                            <?php $typetext = ""; ?>
                                        <?php else : ?>
                                            <?php $typetext = "readonly"; ?>
                                        <?php endif; ?>
                                            <input name="target[<?php echo $rowd['id']; ?>]" type="Texxt" <?= $typetext; ?> class="form-control" value="<?= $rowd['target']; ?>" placeholder="0" style="text-align: right;">
                                            <span class="input-group-addon">Jam</span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $rowd['nokk']; ?>
                                    <br><input type="hidden" id="personil" name="personil[<?php echo $rowd['id']; ?>]" value="<?php echo $_SESSION['nama10']; ?>" readonly>
                                </td>
                                <td><?= $rowd['buyer']; ?></td>
                                <td><?= $rowd['langganan']; ?></td>
                                <td><?= $rowd['po']; ?></td>
                                <td><?= $rowd['no_order']; ?></td>
                                <td><?= $rowd['no_hanger']; ?></td>
                                <td><?= $rowd['lot']; ?></td>
                                <td><?= $rowd['warna']; ?></td>
                                <td><?= $rowd['proses']; ?></td>
                                <td>
                                    <?php echo $rowd['tgl_delivery']; ?>
                                </td>
                                <td bgcolor="<?= $bg; ?>">
                                    <?php echo $rowd['ket_status']; ?>
                                    <br>
                                    <span class="label <?php if ($rowd['status'] == "sedang jalan") {
                                                                                    echo "label-success";
                                                                                } else {
                                                                                    echo "label-warning";
                                                                                } ?>"><?php echo $rowd['status']; ?></span>
                                </td>
                                <td bgcolor="<?php if ($rowd['sts'] == "Potensi Delay") {
                                                    echo " orange";
                                                } else if ($rowd['sts'] == "Urgent") {
                                                    echo " red";
                                                } ?>">
                                    <?php if ($rowd['sts'] != "") {
                                        echo "<font color=white>" . $rowd['sts'] . "</font>";
                                    } ?>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <?php if ($_SESSION['lvl_id10'] == "5") : ?>
                    <button class="btn btn-danger" name="ubah_stdtarget" type="submit">Update Std Target</button>
                <?php else : ?>
                    <button class="btn btn-danger" name="ubah" type="submit">Update</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function() {
        $("#tbl3").dataTable({
            'paging': false,
            'ordering': false,
            'info': false,
            'searching': false
        });
    });
</script>