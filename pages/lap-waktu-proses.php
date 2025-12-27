<?PHP
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";

function formatTanggal($value, $format = 'd-m-Y H:i')
{
  if ($value instanceof DateTimeInterface) {
    return $value->format($format);
  }

  if (is_string($value)) {
    $value = trim($value);
    if ($value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
      return '';
    }

    $time = strtotime($value);
    if ($time !== false) {
      return date($format, $time);
    }

    return $value;
  }

  return '';
}

function toDateTimeOrNull($value)
{
  if ($value instanceof DateTimeInterface) {
    return $value;
  }

  if (is_string($value)) {
    $value = trim($value);
    if ($value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
      return null;
    }

    try {
      return new DateTime($value);
    } catch (Exception $e) {
      return null;
    }
  }

  return null;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan Harian Produksi</title>

</head>

<body>
  <?php
  $Awal  = isset($_POST['awal']) ? $_POST['awal'] : '';
  $Akhir  = isset($_POST['akhir']) ? $_POST['akhir'] : '';
  $GShift  = isset($_POST['gshift']) ? $_POST['gshift'] : '';
  $Fs    = isset($_POST['fasilitas']) ? $_POST['fasilitas'] : '';

  if ($_POST['gshift'] == "ALL") {
    $shft = " ";
  } else {
    $shft = " AND b.g_shift = '$GShift' ";
  }
  ?>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"> Filter Laporan Waktu Proses</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
      <div class="box-body">
        <div class="form-group">
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
              <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off" />
            </div>
          </div>
          <!-- /.input group -->
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
              <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off" />
            </div>
          </div>
          <!-- /.input group -->
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <select name="gshift" class="form-control pull-right">
              <option value="ALL">ALL</option>
              <option value="A" <?php if ($GShift == "A") {
                                  echo "SELECTED";
                                } ?>>A</option>
              <option value="B" <?php if ($GShift == "B") {
                                  echo "SELECTED";
                                } ?>>B</option>
              <option value="C" <?php if ($GShift == "C") {
                                  echo "SELECTED";
                                } ?>>C</option>
            </select>
          </div>
          <!-- /.input group -->
        </div>
        <div class="form-group">
          <div class="col-sm-3"></div>
          <!-- /.input group -->
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="col-sm-2">
          <button type="submit" class="btn btn-block btn-social btn-linkedin btn-sm" name="save" style="width: 60%">Search <i class="fa fa-search"></i></button>
        </div>
      </div>
      <!-- /.box-footer -->
    </form>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box table-responsive">
        <div class="box-header with-border">
          <h3 class="box-title">Data Produksi Waktu Proses</h3><br>
          <?php if ($_POST['awal'] != "") { ?><b>Periode: <?php echo $_POST['awal'] . " to " . $_POST['akhir']; ?></b>
            <div class="pull-right">
              <a href="pages/cetak/reports-waktu-proses-print.php?&awal=<?php echo $Awal; ?>&akhir=<?php echo $Akhir; ?>&shft=<?php echo $GShift; ?>" class="btn btn-primary " target="_blank" data-toggle="tooltip" data-html="true" title="Produksi Waktu Proses Excel"><i class="fa fa-file-excel-o"></i> Print</a>
              <a href="pages/cetak/reports-waktu-proses-excel.php?&awal=<?php echo $Awal; ?>&akhir=<?php echo $Akhir; ?>&shft=<?php echo $GShift; ?>" class="btn btn-success " target="_blank" data-toggle="tooltip" data-html="true" title="Produksi Waktu Proses Excel"><i class="fa fa-file-excel-o"></i> Cetak</a>
            </div>
          <?php } ?>

        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover table-striped" id="example3">
            <thead class="bg-blue">
              <tr>
                <th>
                  <div align="center">No</div>
                </th>
                <th>
                  <div align="center">Kap</div>
                </th>
                <th>
                  <div align="center">No MC</div>
                </th>
                <th>
                  <div align="center">Shift</div>
                </th>
                <th>
                  <div align="center">Operator</div>
                </th>
                <th>
                  <div align="center">Jenis Kain</div>
                </th>
                <th>
                  <div align="center">Desc</div>
                </th>
                <th>
                  <div align="center">Proses</div>
                </th>
                <th>
                  <div align="center">Kategori Warna</div>
                </th>
                <th>
                  <div align="center">Target</div>
                </th>
                <th>
                  <div align="center">Tgl In</div>
                </th>
                <th>
                  <div>
                    <div align="center">Tgl Out</div>
                  </div>
                </th>
                <th>
                  <div align="center">Lama Proses</div>
                </th>
                <th>
                  <div align="center">Tgl Mulai Stop</div>
                </th>
                <th>
                  <div>
                    <div align="center">Tgl Selesai Stop</div>
                  </div>
                </th>
                <th>
                  <div align="center">Lama Proses Stop</div>
                </th>
                <th>
                  <div align="center">Ket Stop Mesin</div>
                </th>
                <th>
                  <div align="center">K.R</div>
                </th>
                <th>
                  <div align="center">Point</div>
                </th>
                <th>
                  <div align="center">Ket</div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $qry1 = sqlsrv_query($con,
                "SELECT
                  a.no_mesin,
                  a.kapasitas,
                  b.g_shift,
                  b.operator_keluar AS operator,
                  a.jenis_kain,
                  a.langganan,
                  a.buyer,
                  a.no_order,
                  a.warna,
                  a.no_warna,
                  a.lot,
                  a.proses,
                  a.kategori_warna,
                  CASE
                      WHEN calc.proc_min IS NULL OR calc.stop_min IS NULL
                          THEN calc.base_hhmm
                      ELSE
                          CONCAT(
                              RIGHT('00' + CAST((calc.proc_min - calc.stop_min) / 60 AS varchar(2)), 2),
                              ':',
                              RIGHT('00' + CAST(ABS((calc.proc_min - calc.stop_min) % 60) AS varchar(2)), 2)
                          )
                  END AS lama,
                  b.point,
                  b.k_resep,
                  CASE
                      WHEN a.target < (
                          CASE
                              WHEN calc.proc_min IS NULL THEN NULL
                              WHEN calc.stop_min IS NULL THEN ROUND(calc.proc_min / 60.0, 2)
                              ELSE ROUND((calc.proc_min - calc.stop_min) / 60.0, 2)
                          END
                        )
                      THEN 'Over'
                      ELSE 'OK'
                  END AS ket,
                  a.target,
                  c.tgl_buat AS tgl_in,
                  b.tgl_buat AS tgl_out,
                  c.tgl_stop  AS tgl_mulai_mesin,
                  c.tgl_mulai AS tgl_stop_mesin,
                  c.ket_stopmesin
              FROM db_dying.tbl_schedule AS a
              INNER JOIN  db_dying.tbl_montemp AS c
                  ON a.id = c.id_schedule
              INNER JOIN  db_dying.tbl_hasilcelup AS b
                  ON c.id = b.id_montemp
	              CROSS APPLY (
	                SELECT
	                  -- total menit lama_proses (b.lama_proses)
	                  proc_min = CASE
	                    WHEN TRY_CONVERT(time(0), b.lama_proses) IS NOT NULL THEN
	                      DATEDIFF(
	                        MINUTE,
	                        CAST('00:00:00' AS time(0)),
	                        TRY_CONVERT(time(0), b.lama_proses)
	                      )
	                    ELSE NULL
	                  END,
	                  -- total menit stop mesin (TIMEDIFF(c.tgl_mulai, c.tgl_stop))
	                  stop_min = CASE
	                    WHEN c.tgl_mulai IS NULL OR c.tgl_stop IS NULL THEN NULL
	                    ELSE DATEDIFF(MINUTE, c.tgl_stop, c.tgl_mulai)
	                  END,
	                  -- HH:MM dasar dari lama_proses
	                  base_hhmm = CASE
	                    WHEN TRY_CONVERT(time(0), b.lama_proses) IS NOT NULL THEN
	                      LEFT(CONVERT(varchar(8), TRY_CONVERT(time(0), b.lama_proses), 108), 5)
	                    ELSE CAST(b.lama_proses AS varchar(10))
	                  END
	              ) AS calc
	              WHERE
	                  a.[status] = 'selesai'
	              AND TRY_CONVERT(date, b.tgl_buat) IS NOT NULL
	              AND TRY_CONVERT(date, b.tgl_buat) BETWEEN '$Awal' AND '$Akhir'
	              $shft
	              ORDER BY
                  a.kapasitas DESC,
                  a.no_mesin ASC;

              ");
              if ($qry1 === false) {
                die(print_r(sqlsrv_errors(), true));
              }
              while ($row1 = sqlsrv_fetch_array($qry1, SQLSRV_FETCH_ASSOC)) {
              ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center">
                    <font size="-1"><?php echo $no; ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php echo $row1['kapasitas']; ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php echo $row1['no_mesin']; ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['g_shift'];
                                    } else {
                                      echo $row1['g_shift'];
                                    } ?>
                  </td>
                  <td align="center" bgcolor="<?php if ($row1['ket'] == "Over" and $dt['g_shift'] == "") {
                                                echo "#FD5B5B";
                                              } else if ($row1['ket'] == "OK" and $dt['g_shift'] == "") {
                                                echo "#14EF78";
                                              } ?>">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['operator'];
                                    } else {
                                      echo $row1['operator'];
                                    } ?>
                  </td>
                  <td>
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['jenis_kain'];
                                    } else {
                                      echo $row1['jenis_kain'];
                                    } ?></font>
                  </td>
                  <td><?php echo "<label class='label bg-red'>" . $row1['langganan'] . "</label><br><label class='label bg-yellow'>" . $row1['buyer'] . "</label><br><label class='label bg-green'>" . $row1['no_order'] . "</label><br><label class='label bg-blue'>" . $row1['warna'] . "</label><br><label class='label label-default'>" . $row1['no_warna'] . "</label><br><label class='label bg-black'>" . $row1['lot'] . "</label>"; ?></td>
                  <td align="center">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['proses'];
                                    } else {
                                      echo $row1['proses'];
                                    } ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['kategori_warna'];
                                    } else {
                                      echo $row1['kategori_warna'];
                                    } ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['target'];
                                    } else {
                                      echo $row1['target'];
                                    } ?>
                  </td>
                  <td align="center" bgcolor="<?php if ($row1['ket'] == "Over" and $dt['g_shift'] == "") {
                                                echo "#FD5B5B";
                                              } else if ($row1['ket'] == "OK" and $dt['g_shift'] == "") {
                                                echo "#14EF78";
                                              } ?>">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['target'];
                                    } else {
                                      echo formatTanggal($row1['tgl_in'], 'Y-m-d H:i:s');
                                    } ?>
                  </td>
                  <td align="center" bgcolor="<?php if ($row1['ket'] == "Over" and $dt['g_shift'] == "") {
                                                echo "#FD5B5B";
                                              } else if ($row1['ket'] == "OK" and $dt['g_shift'] == "") {
                                                echo "#14EF78";
                                              } ?>">
                    <font size="-1"><?php if ($dt['g_shift'] != "") {
                                      echo $dt['target'];
                                    } else {
                                      echo formatTanggal($row1['tgl_out'], 'Y-m-d H:i:s');
                                    } ?>
                  </td>
                  <td align="center" bgcolor="<?php if ($row1['ket'] == "Over" and $dt['g_shift'] == "") {
                                                echo "#FD5B5B";
                                              } else if ($row1['ket'] == "OK" and $dt['g_shift'] == "") {
                                                echo "#14EF78";
                                              } ?>">
                    <font size="-1">
                      <?php
                        if ($dt['g_shift'] != "") {
                          $lamaVal = isset($dt['lama']) ? $dt['lama'] : '';
                        } else {
                          $lamaVal = isset($row1['lama']) ? $row1['lama'] : '';
                        }

                        $lamaTrim = is_string($lamaVal) ? trim($lamaVal) : $lamaVal;
                        $isZeroTime =
                          $lamaTrim === '' ||
                          $lamaTrim === null ||
                          (is_numeric($lamaTrim) && floatval($lamaTrim) == 0.0) ||
                          (is_string($lamaTrim) && preg_match('/^0+\s*(?::\s*0+){0,2}$/', $lamaTrim));

                        echo $isZeroTime ? '00:00' : $lamaTrim;
                      ?>
                  </td>
                  <td align="center"><?= formatTanggal($row1['tgl_mulai_mesin'], 'Y-m-d H:i:s'); ?></td>
                  <td align="center"><?= formatTanggal($row1['tgl_stop_mesin'], 'Y-m-d H:i:s'); ?></td>
                  <td align="center">
                    <?php
                      $waktuawal_stopmesin  = toDateTimeOrNull($row1['tgl_mulai_mesin']);
                      $waktuakhir_stopmesin = toDateTimeOrNull($row1['tgl_stop_mesin']);

                      if ($waktuawal_stopmesin && $waktuakhir_stopmesin) {
                        $diff_stopmesin = date_diff($waktuawal_stopmesin, $waktuakhir_stopmesin);
                        echo $diff_stopmesin->d . ' hari, ' . $diff_stopmesin->h . ' jam, ' . $diff_stopmesin->i . ' menit ';
                      } else {
                        echo '-';
                      }
                    ?>
                  </td>
                  <td align="center"><?= $row1['ket_stopmesin']; ?></td>
                  <td align="center">
                    <font size="-1"><?php if ($dt['g_shift'] == "") {
                                      echo $row1['k_resep'];
                                    } ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php if ($dt['g_shift'] == "") {
                                      echo $row1['point'];
                                    } ?>
                  </td>
                  <td align="center">
                    <font size="-1"><?php if ($row1['ket'] == "Over" and $dt['g_shift'] == "") {
                                      echo "Tidak Tercapai";
                                    } else if ($row1['ket'] == "OK" and $dt['g_shift'] == "") {
                                      echo "Tercapai";
                                    } ?>
                  </td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
</body>

</html>