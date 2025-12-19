<?PHP
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";
$Awal   = isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir  = isset($_POST['akhir']) ? $_POST['akhir'] : '';
$jamA   = isset($_POST['jam_awal']) ? $_POST['jam_awal'] : '';
$jamAr  = isset($_POST['jam_akhir']) ? $_POST['jam_akhir'] : '';
$GShift = isset($_POST['gshift']) ? $_POST['gshift'] : '';
if (strlen($jamA) == 5) {
    $start_date = $Awal . ' ' . $jamA;
} else {
    $start_date = $Awal . ' 0' . $jamA;
}
if (strlen($jamAr) == 5) {
    $stop_date  = $Akhir . ' ' . $jamAr;
} else {
    $stop_date  = $Akhir . ' 0' . $jamAr;
}
if ($jamA & $jamAr) {
    $where_jam  = "createdatetime BETWEEN '$start_date' AND '$stop_date'";
} else {
    $where_jam  = "CONVERT(date, createdatetime) BETWEEN '$Awal' AND '$Akhir'";
}

if ($GShift == 'ALL') {
    $where_gshift = "";
} else {
    $where_gshift = "AND gshift = '$GShift'";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>laporan Harian Buka Resep</title>
</head>

<body>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"> Filter Laporan Harian Buka Resep</h3>
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
                                    <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker" name="jam_awal" placeholder="00:00" value="<?php echo $jamA; ?>" autocomplete="off">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                                    <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker" name="jam_akhir" placeholder="00:00" value="<?php echo $jamAr; ?>" autocomplete="off">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <select name="gshift" class="form-control pull-right">
                                    <option value="ALL">ALL</option>
                                    <option value="A" <?php if ($GShift == "A") { echo "SELECTED"; } ?>>A</option>
                                    <option value="B" <?php if ($GShift == "B") { echo "SELECTED"; } ?>>B</option>
                                    <option value="C" <?php if ($GShift == "C") { echo "SELECTED"; } ?>>C</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-block btn-social btn-linkedin btn-sm" name="submit" style="width: 60%">Search <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <?php if (isset($_POST['submit'])) : ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Data Laporan Buka Resep</h3><br><br>
                                    <div class="pull-right">
                                        <a href="pages/cetak/reports-buka-resep-print.php?&awal=<?= $Awal; ?>&akhir=<?= $Akhir; ?>&jam_awal=<?= $jamA; ?>&jam_akhir=<?= $jamAr; ?>&gshift=<?= $GShift; ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-html="true" title="Form Laporan Harian Buka Bon Resep">
                                            <i class="fa fa-print"></i> print
                                        </a>
                                        <a href="pages/cetak/reports-buka-resep-excel.php?&awal=<?= $Awal; ?>&akhir=<?= $Akhir; ?>&jam_awal=<?= $jamA; ?>&jam_akhir=<?= $jamAr; ?>&gshift=<?= $GShift; ?>" class="btn btn-success" target="_blank" data-toggle="tooltip" data-html="true" title="Form Laporan Harian Buka Bon Resep">
                                            <i class="fa fa-file-excel-o"></i> Cetak
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-hover table-striped" width="100%">
                                        <thead class="bg-blue">
                                            <tr>
                                                <th width="26"><div align="center">No.</div></th>
                                                <th width="26"><div align="center">TGL</div></th>
                                                <th width="26"><div align="center">Buka Resep</div></th>
                                                <th width="26"><div align="center">Ok</div></th>
                                                <th width="26"><div align="center">Tidak Ok</div></th>
                                                <th width="26"><div align="center">Belum Diperiksa</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            function format_tanggal_sqlsrv($value)
                                                {
                                                    if ($value instanceof DateTime) {
                                                        return $value->format('Y-m-d');
                                                    }
                                                    return $value;
                                                }
                                            $q_bukaresep    = sqlsrv_query($con, "SELECT
                                                                                        CONVERT(date, createdatetime) AS TGL,
                                                                                        COUNT(nokk) AS buka_resep
                                                                                    FROM
                                                                                        db_dying.tbl_bukaresep 
                                                                                    WHERE 
                                                                                        $where_jam $where_gshift
                                                                                    GROUP BY 
                                                                                        CONVERT(date, createdatetime)");
                                            $no = 1;
                                            ?>
                                            <?php while ($row_bukaresep = sqlsrv_fetch_array($q_bukaresep, SQLSRV_FETCH_ASSOC)) { ?>
                                                <?php
                                                $q_bukaresep_ok     = sqlsrv_query($con, "SELECT
                                                                                                CONVERT(date, createdatetime) AS TGL,
                                                                                                COUNT(nokk) AS ok
                                                                                            FROM
                                                                                                db_dying.tbl_bukaresep 
                                                                                            WHERE 
                                                                                                cek_resep = 'Resep Ok' AND $where_jam $where_gshift
                                                                                            GROUP BY 
                                                                                                CONVERT(date, createdatetime)");
                                                $row_bukaresep_ok   = sqlsrv_fetch_array($q_bukaresep_ok, SQLSRV_FETCH_ASSOC);

                                                $q_bukaresep_tidakok     = sqlsrv_query($con, "SELECT
                                                                                                CONVERT(date, createdatetime) AS TGL,
                                                                                                COUNT(nokk) AS tidak_ok
                                                                                            FROM
                                                                                                db_dying.tbl_bukaresep 
                                                                                            WHERE 
                                                                                                cek_resep = 'Resep Tidak Ok' AND $where_jam $where_gshift
                                                                                            GROUP BY 
                                                                                                CONVERT(date, createdatetime)");
                                                $row_bukaresep_tidakok   = sqlsrv_fetch_array($q_bukaresep_tidakok, SQLSRV_FETCH_ASSOC);

                                                $q_bukaresep_blmdiperiksa     = sqlsrv_query($con, "SELECT
                                                                                                            CONVERT(date, createdatetime) AS TGL,
                                                                                                            COUNT(nokk) AS belum_diperiksa
                                                                                                        FROM
                                                                                                            db_dying.tbl_bukaresep
                                                                                                        WHERE 
                                                                                                            cek_resep is null AND $where_jam $where_gshift
                                                                                                        GROUP BY 
                                                                                                            CONVERT(date, createdatetime)");
                                                $row_bukaresep_blmdiperiksa   = sqlsrv_fetch_array($q_bukaresep_blmdiperiksa, SQLSRV_FETCH_ASSOC);

                                             
                                                $row_bukaresep['TGL'] = format_tanggal_sqlsrv($row_bukaresep['TGL']);
                                                ?>
                                                <tr bgcolor="antiquewhite">
                                                    <td align="center"><?= $no++; ?></td>
                                                    <td align="center"><?= format_tanggal_sqlsrv($row_bukaresep['TGL']); ?></td>
                                                    <td align="center"><?= $row_bukaresep['buka_resep']; ?></td>
                                                    <td align="center"><?= $row_bukaresep_ok['ok']; ?></td>
                                                    <td align="center"><?= $row_bukaresep_tidakok['tidak_ok']; ?></td>
                                                    <td align="center"><?= $row_bukaresep_blmdiperiksa['belum_diperiksa']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot class="bg-red">
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>