<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$modal_id = $_GET['id'];

$tbl_montemp        = mysqli_query($con, "SELECT * FROM `tbl_montemp` WHERE id='$modal_id' ");
$row_tblmontemp     = mysqli_fetch_assoc($tbl_montemp);

$sqlCek = mysqli_query($con, "SELECT * FROM tbl_schedule WHERE id = '$row_tblmontemp[id_schedule]' ORDER BY id DESC LIMIT 1");
$rcek = mysqli_fetch_array($sqlCek);

function cekDesimal($angka){
    $bulat = round($angka);
    if ($bulat > $angka) {
        $jam = $bulat - 1;
        $waktu = $jam . ":30";
    } else {
        $jam = $bulat;
        $waktu = $jam . ":00";
    }
    return $waktu;
}

$modal = mysqli_query($con, "SELECT * FROM `tbl_montemp` WHERE id='$modal_id' ");
while ($r = mysqli_fetch_array($modal)) {
?>
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_jammasukkain" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Jam Masuk Kain</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" value="<?php echo $r['id']; ?>">
                    <div class="form-group">
                        <label for="mulaism" class="col-sm-3 control-label">Jam Masuk Kain</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                <input name="jammasukkain" value="<?= substr($r['jammasukkain'], 0, 10); ?>" type="text" class="form-control col-sm-2" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input name="tglmasukkain" type="text" class="form-control col-sm-2" id="tglmasukkain" required placeholder="00:00" pattern="[0-9]{2}:[0-9]{2}$" title=" e.g 14:25" onkeyup="
                                                                                                                                var time = this.value;
                                                                                                                                if (time.match(/^\d{2}$/) !== null) {
                                                                                                                                    this.value = time + ':';
                                                                                                                                } else if (time.match(/^\d{2}\:\d{2}$/) !== null) {
                                                                                                                                    this.value = time + '';
                                                                                                                                }" value="<?= substr($r['jammasukkain'], 11, 5); ?>" size="5" maxlength="5">
                                <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo cekDesimal($rcek['target']); ?>" name="target">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" name="ubah" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
