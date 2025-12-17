<?php
ini_set("error_reporting", 1);
session_start();
include ("../koneksi.php");
include "../helpers.php";
$modal_id = $_GET['id'];

$tbl_montemp        = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_montemp WHERE id='$modal_id' ");
$row_tblmontemp     = sqlsrv_fetch_array($tbl_montemp, SQLSRV_FETCH_ASSOC);

$sqlCek = sqlsrv_query($con, "SELECT TOP 1 * FROM db_dying.tbl_schedule WHERE id = '$row_tblmontemp[id_schedule]' ORDER BY id DESC");
$rcek = sqlsrv_fetch_array($sqlCek);

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

$modal = sqlsrv_query($con, "SELECT * FROM db_dying.tbl_montemp WHERE id='$modal_id' ");
while ($r = sqlsrv_fetch_array($modal)) {
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
                                <input name="jammasukkain" value="<?= formatDateTime($r['jammasukkain'], 'Y-m-d'); ?>" type="text" class="form-control col-sm-2" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input name="tglmasukkain" type="text" class="form-control col-sm-2" id="tglmasukkain" required placeholder="00:00"maxlength="5"oninput="formatTime(this)"onblur="validateTime(this)"value="<?= formatDateTime($r['jammasukkain'], 'H:i'); ?>">
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

<script>
// Auto-format waktu (HH:MM)
function formatTime(input) {
    input.value = input.value.replace(/[^0-9:]/g, '');
    let val = input.value;
    if (val.length === 2 && !val.includes(":")) {
        input.value = val + ":";
    }

    if (val.length > 5) {
        input.value = val.substring(0, 5);
    }
}

// Validasi ketika input kehilangan fokus
function validateTime(input) {

    const time = input.value;
    if (time === "") return;
    const regex = /^([0-9]{2}):([0-9]{2})$/;

    if (!regex.test(time)) {
        return showError(input, "Format waktu tidak valid!\nGunakan HH:MM (contoh 14:25)");
    }
    const [hh, mm] = time.split(":").map(Number);

    if (hh < 0 || hh > 23) {
        return showError(input, "Jam harus antara 00 sampai 23!");
    }
    if (mm < 0 || mm > 59) {
        return showError(input, "Menit harus antara 00 sampai 59!");
    }
}

// Function tampil swal error
function showError(input, message) {
    swal({
        title: "Input Waktu Salah",
        text: message,
        icon: "error",
    }).then(() => {
        input.value = "";
        input.focus();
    });
}
</script>
