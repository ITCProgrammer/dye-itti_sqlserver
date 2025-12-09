<?PHP
ini_set("error_reporting", 1);
session_start();
include "koneksi.php";

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
  ?>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"> Filter Laporan Hasil Celup</h3>
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
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Data Hasil Celup</h3><br><br>
          <?php if ($_POST['awal'] != "") { ?><b>Periode: <?php echo $_POST['awal'] . " to " . $_POST['akhir']; ?></b>
            <!-- <a href="pages/cetak/reports-panjang-kain.php?&awal=<?php echo $Awal; ?>&akhir=<?php echo $Akhir; ?>&shft=<?php echo $GShift; ?>" class="btn btn-primary pull-right" target="_blank"><i class="fa fa-print"></i> Cetak Panjang Kain</a> -->
            <a href="pages/cetak/reports-hasil-celup.php?&awal=<?php echo $Awal; ?>&akhir=<?php echo $Akhir; ?>&shft=<?php echo $GShift; ?>" class="btn btn-danger pull-right" target="_blank"><i class="fa fa-print"></i> Cetak</a>
          <?php } ?>

        </div>
        <div class="box-body">


          <table id="example2" class="table table-bordered table-hover" width="100%">
            <thead class="btn-primary">
              <tr>
                <th width="38">Shift</th>
                <th width="38">
                  <div align="center">Mesin</div>
                </th>
                <th width="224">
                  <div align="center">Buyer</div>
                </th>
                <th width="314">
                  <div align="center">Order</div>
                </th>
                <th width="404">
                  <div align="center">Warna</div>
                </th>
                <th width="215">
                  <div align="center">Proses</div>
                </th>
                <th width="215">
                  <div align="center">Lama Proses</div>
                </th>
                <th width="215">
                  <div align="center">Point</div>
                </th>
                <th width="215">
                  <div align="center">Keterangan</div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $c = 0;
              $no = 0;
              if ($GShift == "ALL") {
                $shft = " ";
              } else {
                $shft = " a.g_shift='$GShift' AND ";
              }
              $sql = mysqli_query($con, "SELECT
                                          a.*,
                                          b.buyer,
                                          b.no_order,
                                          b.no_mesin,
                                          b.warna,
                                          b.proses 
                                        FROM
                                          tbl_hasilcelup a
                                          LEFT JOIN tbl_montemp c ON a.id_montemp=c.id
                                          LEFT JOIN tbl_schedule b ON c.id_schedule = b.id
                                        WHERE
                                          $shft 
                                          DATE_FORMAT( a.tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir'
                                          AND a.`status`='OK' AND (b.proses='Celup Greige' OR b.proses='Cuci Misty' OR b.proses='Cuci Yarn Dye (Y/D)') 
                                        ORDER BY
                                          b.no_mesin ASC");
              while ($rowd = mysqli_fetch_array($sql)) {
                $no++;
                $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
              ?>
                <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
                  <td align="center"><?php echo $rowd['g_shift']; ?></td>
                  <td align="center"><?php echo $rowd['no_mesin']; ?></td>
                  <td align="center"><?php echo $rowd['buyer']; ?></td>
                  <td align="center"><?php echo $rowd['no_order']; ?></td>
                  <td><?php echo $rowd['warna']; ?></td>
                  <td align="left"><?php echo $rowd['proses']; ?><br />
                    <i class="label bg-hijau"><?php echo $rowd['operator_keluar']; ?></i>
                  </td>
                  <td align="center"><?php echo $rowd['lama_proses']; ?></td>
                  <td align="center"><?php echo $rowd['point']; ?></td>
                  <td><i class="label bg-abu"><?php echo $rowd['nokk']; ?></i><br />
                    <i class="label <?php if ($rowd['status'] == "OK") {
                                      echo "bg-green";
                                    } else {
                                      echo "bg-red";
                                    } ?>"><?php echo $rowd['status']; ?></i><br /><?php echo $rowd['ket']; ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>

          </table>
          </form>

        </div>
      </div>
    </div>
  </div>

</body>

</html>