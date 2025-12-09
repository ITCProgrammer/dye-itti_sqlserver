<?PHP
  ini_set("error_reporting", 1);
  session_start();
  include "koneksi.php";
  $username = $_SESSION['user_id10'];

?>

<?php
  include "koneksi.php";
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  if (isset($_POST['update_proses'])) {
    $nokk = $_POST['nokk'];
    $proses = $_POST['proses'];
  
    try {
      $query = "UPDATE tbl_schedule SET proses = ?, tgl_update = NOW() WHERE nokk = ?";
      $stmt = $con->prepare($query);
      $stmt->bind_param("si", $proses, $nokk);
      $stmt->execute();
  
      echo "OK";
    } catch (mysqli_sql_exception $e) {
      echo "Gagal: " . $e->getMessage();
    }
    exit();
  }

  if (isset($_POST['update_kresep'])) {
    $nokk = $_POST['nokk'];
    $kresep = $_POST['kresep'];
  
    try {
      $query = "UPDATE tbl_hasilcelup SET k_resep = ?, tgl_update = NOW() WHERE nokk = ?";
      $stmt = $con->prepare($query);
      $stmt->bind_param("si", $kresep, $nokk);
      $stmt->execute();
  
      echo "OK";
    } catch (mysqli_sql_exception $e) {
      echo "Gagal: " . $e->getMessage();
    }
    exit();
  }

  if (isset($_POST['update_resep'])) {
    $nokk = $_POST['nokk'];
    $resep = $_POST['resep'];
  
    try {
      $query = "UPDATE tbl_schedule SET resep = ?, tgl_update = NOW() WHERE nokk = ?";
      $stmt = $con->prepare($query);
      $stmt->bind_param("si", $resep, $nokk);
      $stmt->execute();
  
      echo "OK";
    } catch (mysqli_sql_exception $e) {
      echo "Gagal: " . $e->getMessage();
    }
    exit();
  }
  
  if (isset($_POST['update_StatusResep'])) {
    $nokk         = $_POST['nokk'];
    $statusresep  = $_POST['statusResep'];

    try {
      $query = "UPDATE tbl_hasilcelup SET status_resep = ? WHERE nokk = ?";
      $stmt = $con->prepare($query);
      $stmt->bind_param("si", $statusresep, $nokk);
      $stmt->execute();
  
      echo "OK";
    } catch (mysqli_sql_exception $e) {
      echo "Gagal: " . $e->getMessage();
    }
    exit();
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
    $jamA  = isset($_POST['jam_awal']) ? $_POST['jam_awal'] : '';
    $jamAr  = isset($_POST['jam_akhir']) ? $_POST['jam_akhir'] : '';
    $Rcode  = isset($_POST['rcode']) ? $_POST['rcode'] : '';
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
    //$stop_date  = date('Y-m-d', strtotime($Awal . ' +1 day')).' 07:00:00';	

    $daftarProses = [];
    $queryProses = mysqli_query($con, "SELECT DISTINCT proses FROM tbl_proses ORDER BY proses ASC");
    while ($rowProses = mysqli_fetch_assoc($queryProses)) {
      $daftarProses[] = $rowProses['proses'];
    }

  ?>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"> Filter Laporan Harian Produksi</h3>
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
          <div class="col-sm-2">
            <div class="input-group">
              <input type="text" class="form-control timepicker" name="jam_awal" placeholder="00:00" value="<?php echo $jamA; ?>" autocomplete="off">

              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
            </div>
            <div>
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
        
          <div class="col-sm-2">
            <input type="text" class="form-control" name="rcode" value="<?= $Rcode; ?>" placeholder="Rcode">
          </div>
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="col-sm-2">
          <button type="submit" class="btn btn-block btn-social btn-linkedin btn-sm" name="save" style="width: 60%">Search <i class="fa fa-search"></i></button>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-block btn-default btn-sm" onclick="redirect_new()" name="laporan_new" id="laporan_new">Laporan Baru <i class="fa fa-external-link" aria-hidden="true"></i></button>
        </div>
        
      </div>
      <!-- /.box-footer -->
    </form>
    <!-- Start Form Upload laporan produksi ke format baru -->
    <!-- <div class="row">
      <div class="col-xs-12">
        <div>
          </br>
          </br>
          <form class="form-horizontal" action="pages/cetak/konversi_lap_harian_to_new_format.php" method="post" enctype="multipart/form-data" name="formUploadExcel">
            <div class="form-group"> 
              <label for="excelFile" class="col-sm-3 control-label"> Pilih Excel Untuk di Upload:</label>
              <div class="col-sm-4">
				        <input type="hidden" name="uploadExcel" value="true" readonly>
                <input type="file" class="form-control" name="excelFile" id="excelFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
		          </div>
              <div class="col-sm-4">
                <input type="submit" value="Upload Excel" class="btn btn-primary" name="submit">
              </div>
		        </div>
          </form>
        </div>
      </div>
    </div> -->
    <!-- End Form -->
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Data Produksi Celup</h3><br><br>
          <?php if ($_POST['awal'] != "") { ?><b>Periode: <?php echo $start_date . " to " . $stop_date; ?></b>
            <div class="btn-group pull-right">
              <a href="pages/cetak/reports-harian-produksi-excel-bakarBulu.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-success " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel Bakar Bulu"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/NewCetakReportDyeing.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn bg-maroon" target="_blank" data-toggle="tooltip" data-html="true" title="New Format Harian Produksi Excel"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/reports-harian-produksi.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-danger " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi"><i class="fa fa-print"></i> </a>
              <a href="pages/cetak/reports-panjang-kain.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-warning" target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel Panjang Kain"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/reports-harian-produksi-excel-whiteness.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel With Whiteness Yellowness Tint"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/reports-harian-produksi-excel-ketResep.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-info" target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel 2"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/reports-harian-produksi-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-success " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/reports-harian-produksi-opt-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-primary " target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Waktu Tunggu Excel"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/rincian-cetak.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-warning " target="_blank" data-toggle="tooltip" data-html="true" title="Rincian Produksi"><i class="fa fa-print"></i> </a>
              <a href="pages/cetak/rincian-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn btn-info " target="_blank" data-toggle="tooltip" data-html="true" title="Rincian Produksi Excel"><i class="fa fa-file-excel-o"></i> </a>
              <a href="pages/cetak/schedule-excel.php?&awal=<?php echo $start_date; ?>&akhir=<?php echo $stop_date; ?>&shft=<?php echo $GShift; ?>" class="btn bg-maroon " target="_blank" data-toggle="tooltip" data-html="true" title="Schedule Produksi Excel"><i class="fa fa-file-excel-o"></i> </a>
            </div>
          <?php }elseif($Rcode != ""){ ?>
            <div class="btn-group pull-right">              
              <a href="pages/cetak/reports-harian-produksi-excel-ketResep.php?&rcode=<?= $Rcode; ?>" class="btn btn-info" target="_blank" data-toggle="tooltip" data-html="true" title="Harian Produksi Excel With Keterangan Analisa Resep Rcode"><i class="fa fa-file-excel-o"></i> </a>
            </div>
          <?php } ?>
        </div>
        <div class="box-body">
          <table id="example1" class="table table-bordered table-hover" width="100%">
            <thead class="btn-danger">
              <tr>
                <th width="38">
                  <div align="center">Mesin</div>
                </th>
                <th width="38">Shift</th>
                <th width="224">
                  <div align="center">Buyer</div>
                </th>
                <th width="215">
                  <div align="center">Tgl Celup</div>
                </th>
                <th width="314">
                  <div align="center">Order<br>No Demand</div>
                </th>
                <th width="404">
                  <div align="center">Jenis Kain</div>
                </th>
                <th width="404">
                  <div align="center">Lot</div>
                </th>
                <th width="404">
                  <div align="center">Warna</div>
                </th>
                <th width="404">
                  <div align="center">QTY</div>
                </th>
                <th width="215">
                  <div align="center">Proses</div>
                </th>
                <th width="215">
                  <div align="center">Aktual Proses</div>
                </th>
                <th width="215">
                  <div align="center">Lama Proses</div>
                </th>
                <th width="215">
                  <div align="center">Std Target</div>
                </th>
                <th width="215">
                  <div align="center">K.R</div>
                  <div align="center">R.B/R.L/R.S</div>
                </th>
                <th width="215">
                  <div align="center">Status</div>
                </th>
                <th width="215">
                  <div align="center">Item</div>
                </th>
                <th width="215">
                  <div align="center">Rcode</div>
                </th>
                <th width="237">
									<font size="-1">Status Resep</font>
								</th>
								<th width="237">
									<font size="-1">Analisa Resep</font>
								</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $c = 0;
                $no = 0;
                if($Rcode){
                  $sql = mysqli_query($con, "SELECT x.*,a.no_mesin as mc,a.no_mc_lama as mc_lama FROM tbl_mesin a
                                              RIGHT JOIN
                                              (SELECT
                                                a.rcode,
                                                c.tgl_update,
                                                b.nokk,
                                                b.nodemand,
                                                b.buyer,
                                                b.langganan,
                                                b.no_order,
                                                b.jenis_kain,
                                                b.lot,
                                                b.no_mesin,
                                                b.warna,
                                                b.proses,
                                                b.target,
                                                a.k_resep,
                                                b.resep,
                                                a.status,
                                                if(ISNULL(a.g_shift),c.g_shift,a.g_shift) as shft,
                                                c.operator,	if(c.status='selesai',if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),TIME_FORMAT(timediff(now(),c.tgl_buat),'%H:%i')) as lama,
                                                b.`status` as sts,
                                                a.`status` as stscelup,
                                                a.proses as proses_aktual,
                                                a.id as idclp,
                                                a.analisa_resep,
                                                a.status_resep,
                                                b.no_hanger,
                                                b.qty_order
                                              FROM
                                                tbl_schedule b
                                                LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
                                                LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
                                              WHERE
                                                  a.rcode LIKE '%$Rcode%'
                                                  ) x ON (a.no_mesin=x.no_mesin or a.no_mc_lama=x.no_mesin)
                                            WHERE 
                                              NOT x.nokk IS NULL
                                            ORDER BY tgl_update DESC");
                }else{
                  if ($GShift == "ALL") {
                    $shft = " ";
                  } else {
                    $shft = " if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$GShift' AND ";
                  }
              
                  $Where = " DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$start_date' AND '$stop_date' ";
                  if ($Awal != "" and $Akhir != "") {
                    $Where1 = "WHERE NOT x.nokk IS NULL";
                  } else {
                    $Where1 = " WHERE a.id='' AND NOT x.nokk IS NULL";
                  }
                  $sql = mysqli_query($con, "SELECT x.*,a.no_mesin as mc,a.no_mc_lama as mc_lama FROM tbl_mesin a
                                              LEFT JOIN
                                              (SELECT
                                                a.rcode,
                                                b.nokk,
                                                b.nodemand,
                                                c.tgl_update,
                                                b.buyer,
                                                b.langganan,
                                                b.no_order,
                                                b.jenis_kain,
                                                b.lot,
                                                b.no_mesin,
                                                b.warna,
                                                b.proses,
                                                b.target,
                                                a.k_resep,
                                                b.resep,
                                                if(ISNULL(a.g_shift),c.g_shift,a.g_shift) as shft,
                                                c.operator,	if(c.status='selesai',if(ISNULL(TIMEDIFF(c.tgl_mulai,c.tgl_stop)),a.lama_proses,CONCAT(LPAD(FLOOR((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))/60),2,0),':',LPAD(((((HOUR(a.lama_proses)*60)+MINUTE(a.lama_proses))-((HOUR(TIMEDIFF(c.tgl_mulai,c.tgl_stop))*60)+MINUTE(TIMEDIFF(c.tgl_mulai,c.tgl_stop))))%60),2,0))),TIME_FORMAT(timediff(now(),c.tgl_buat),'%H:%i')) as lama,
                                                b.`status` as sts,
                                                a.`status` as stscelup,
                                                a.proses as proses_aktual,
                                                a.id as idclp,
                                                a.analisa_resep,
                                                a.status_resep,
                                                b.no_hanger,
                                                b.qty_order,
                                                a.tambah_dyestuff
                                              FROM
                                                tbl_schedule b
                                                LEFT JOIN  tbl_montemp c ON c.id_schedule = b.id
                                                LEFT JOIN tbl_hasilcelup a ON a.id_montemp=c.id
                                              WHERE
                                                  $shft
                                                  $Where
                                                  ) x ON (a.no_mesin=x.no_mesin or a.no_mc_lama=x.no_mesin) 
                                              $Where1 
                                              ORDER BY tgl_update DESC");
                }
                while ($rowd = mysqli_fetch_array($sql)) {
                  if ($GShift == "ALL") {
                    $shftSM = " ";
                  } else {
                    $shftSM = " g_shift='$GShift' AND ";
                  }
                  $sqlSM = mysqli_query($con, "SELECT *, g_shift as shiftSM, TIME_FORMAT(timediff(selesai,mulai),'%H:%i') as lamaSM FROM tbl_stopmesin
                                                WHERE $shftSM tgl_update BETWEEN '$start_date' AND '$stop_date' AND (no_mesin='$rowd[mc]' or no_mesin='$rowd[mc_lama]') ORDER BY id DESC LIMIT 1");
                  $rowSM = mysqli_fetch_array($sqlSM);
                  $no++;
                  $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                  $qCek = mysqli_query($con, "SELECT id as idb FROM tbl_potongcelup WHERE nokk='$rowd[nokk]' LIMIT 1");
                  $rCEk = mysqli_fetch_array($qCek);
              ?>
                <tr bgcolor="<?php echo $bgcolor; ?>" class="table table-bordered table-hover table-striped">
                  <td align="center"><?php echo $rowd['mc']; ?><br>
                    <div class="btn-group <?php if ($rCEk['idb'] == "") {
                                            echo "hidden";
                                          } ?>"><a href="pages/cetak/cetak_celup.php?id=<?php echo $rCEk['idb'] ?>" class="btn btn-xs btn-warning" target="_blank"><i class="fa fa-print"></i> </a><a href="#" id='<?php echo $rowd['idclp']; ?>' class="btn btn-xs btn-info edit_stscelup"><i class="fa fa-edit"></i> </a></div>
                  </td>
                  <td align="center"><?php if ($rowd['no_order'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
                                        echo $rowSM['shiftSM'];
                                      } else {
                                        echo $rowd['shft'];
                                      } ?></td>
                  <td align="center"><?php echo $rowd['buyer']; ?><br><?= $rowd['langganan']; ?></td>
                  <td><?= $rowd['tgl_update'] ?></td>
                  <td align="center"><?php echo $rowd['no_order']; ?><br><?= $rowd['nodemand'] ?></td>
                  <td><?php echo $rowd['jenis_kain']; ?></td>
                  <td align="center"><?php echo $rowd['lot']; ?></td>
                  <td><?php echo $rowd['warna']; ?></td>
                  <td><?php echo $rowd['qty_order']; ?></td>
                  <td align="left">
                    <?php
                    $prosesSekarang = ($rowd['no_order'] == "" && substr($rowd['proses'], 0, 10) != "Cuci Mesin") ? $rowSM['proses'] : $rowd['proses'];

                    if (in_array(strtolower($username), ['dit', 'andri', 'lukman'])) {
                    ?>
                        <select name="proses_update[]" onchange="updateProses(this, '<?php echo $rowd['nokk']; ?>')">
                          <?php
                          foreach ($daftarProses as $proses) {
                            $selected = ($proses == $prosesSekarang) ? 'selected' : '';
                            echo "<option value=\"$proses\" $selected>$proses</option>";
                          }
                          ?>
                          <option value="Tolak Basah">Tolak Basah</option>
                          <option value="Gagal Proses">Gagal Proses</option>
                          <option value="Tolak Basah Luntur">Tolak Basah Luntur</option>
                        </select>
                    <?php
                    } else {
                      echo $prosesSekarang;
                    }
                    ?>

                    <br />
                    <i class="label bg-hijau">
                      <?php echo $rowd['operator_keluar'] != "" ? $rowd['operator_keluar'] : $rowd['operator']; ?>
                    </i>
                    <br />
                    <i class="label bg-abu">
                      <?php
                      if ($rowd['no_order'] == "" && substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
                        echo $rowSM['no_stop'] . "<br>" . $rowSM['keterangan'];
                      } else {
                        echo $rowd['nokk'];
                      }
                      ?>
                    </i>
                    <br />
                    <i class="label <?php echo ($rowd['stscelup'] == "OK") ? "bg-green" : (($rowd['stscelup'] == "Gagal Proses") ? "bg-red" : ""); ?>">
                      <?php echo $rowd['stscelup']; ?>
                    </i>
                    <br />
                    <?php echo $rowd['ket']; ?>
                  </td>
                  <td align="center"><?php echo $rowd['proses_aktual']; ?></td>
                  <td align="center"><?php if ($rowd['no_order'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
                                        echo $rowSM['lamaSM'];
                                      } else {
                                        echo $rowd['lama'];
                                      } ?></td>
                  <td align="center"><?php echo $rowd['target']; ?></td>
                  <td>
                    <?php
                      $kResepSekarang = $rowd['k_resep'];
                      if (in_array(strtolower($username), ['dit', 'andri', 'lukman', 'rica'])) {
                      ?>
                      <select name="kresep_update[]" onchange="updateKresep(this, '<?php echo $rowd['nokk']; ?>')">
                        <option value="-" <?php if($kResepSekarang == '-') echo 'selected'; ?>>-</option>
                        <option value="0x" <?php if($kResepSekarang == '0x') echo 'selected'; ?>>0x</option>
                        <option value="1x" <?php if($kResepSekarang == '1x') echo 'selected'; ?>>1x</option>
                        <option value="2x" <?php if($kResepSekarang == '2x') echo 'selected'; ?>>2x</option>
                        <option value="3x" <?php if($kResepSekarang == '3x') echo 'selected'; ?>>3x</option>
                        <option value="4x" <?php if($kResepSekarang == '4x') echo 'selected'; ?>>4x</option>
                        <option value="5x" <?php if($kResepSekarang == '5x') echo 'selected'; ?>>5x</option>
                        <option value="6x" <?php if($kResepSekarang == '6x') echo 'selected'; ?>>6x</option>
                        <option value="7x" <?php if($kResepSekarang == '7x') echo 'selected'; ?>>7x</option>
                        <option value="8x" <?php if($kResepSekarang == '8x') echo 'selected'; ?>>8x</option>
                        <option value="9x" <?php if($kResepSekarang == '9x') echo 'selected'; ?>>9x</option>
                        <option value="10x" <?php if($kResepSekarang == '10x') echo 'selected'; ?>>10x</option>
                        <option value=">10x" <?php if($kResepSekarang == '>10x') echo 'selected'; ?>>>10x</option>
                      </select>
                    <?php
                      } else {
                      ?>
                        <span style="user-select: text;"><?= $kResepSekarang ?></span>
                      <?php
                      }
                    ?>
                    <?php
                      $ResepSekarang = $rowd['resep'];
                      if (in_array(strtolower($username), ['dit', 'andri', 'lukman', 'rica'])) {
                      ?>
                      <select name="resep_update[]" onchange="updateResep(this, '<?php echo $rowd['nokk']; ?>')">
                        <option value="-" <?php if($ResepSekarang == '-') echo 'selected'; ?>>-</option>
                        <option value="Baru" <?php if($ResepSekarang == 'Baru') echo 'selected'; ?>>Baru</option>
                        <option value="Lama" <?php if($ResepSekarang == 'Lama') echo 'selected'; ?>>Lama</option>
                        <option value="Setting" <?php if($ResepSekarang == 'Setting') echo 'selected'; ?>>Setting</option>
                      </select>
                    <?php
                      } else {
                      ?>
                        <span style="user-select: text;"><?= $ResepSekarang ?></span>
                      <?php
                      }
                    ?>
                  </td>
                  <td><?= $rowd['stscelup'] ?></td>
                  <td><?= $rowd['no_hanger'] ?></td>
                  <td>
                    <?= $rowd['rcode'] ?>
                  </td>
                  <td>
                    <select name="status_resep[]" onchange="updateStatusResep(this, '<?php echo $rowd['nokk']; ?>')">
                      <option value="Belum Analisa" <?php if($rowd['status_resep'] == 'Belum Analisa'){ echo "SELECTED"; } ?>>Belum Analisa</option>
                      <option value="Follow" <?php if($rowd['status_resep'] == 'Follow'){ echo "SELECTED"; } ?>>Follow</option>
                      <option value="Test LAB" <?php if($rowd['status_resep'] == 'Test LAB'){ echo "SELECTED"; } ?>>Test LAB</option>
                      <option value="Oke" <?php if($rowd['status_resep'] == 'Oke'){ echo "SELECTED"; } ?>>Oke</option>
                      <option value="Tidak Oke" <?php if($rowd['status_resep'] == 'Tidak Oke'){ echo "SELECTED"; } ?>>Tidak Oke </option>
                      <option value="Review" <?php if($rowd['status_resep'] == 'Review'){ echo "SELECTED"; } ?>>Review </option>
                      <option value="Test Celup" <?php if($rowd['status_resep'] == 'Test Celup'){ echo "SELECTED"; } ?>>Test Celup</option>
                      <option value="Tidak Analisa" <?php if($rowd['status_resep'] == 'Tidak Analisa'){ echo "SELECTED"; } ?>>Tidak Analisa</option>
                    </select>
                  </td>
									<td><?= $rowd['analisa_resep'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="EditStsCelup" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="dist/js/jquery.redirect.js"></script>

  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  <script>
    function updateProses(selectEl, nokk) {
      const proses = selectEl.value;
    
      Swal.fire({
        title: 'Konfirmasi Perubahan',
        text: `Apakah Anda yakin ingin mengubah proses menjadi "${proses}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Perbarui!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(window.location.href, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `update_proses=1&nokk=${nokk}&proses=${encodeURIComponent(proses)}`
          })
          .then(response => response.text())
          .then(data => {
            console.log("Respon:", data);
            Swal.fire('Sukses!', 'Proses berhasil diperbarui.', 'success');
          })
          .catch(err => {
            console.error("Error:", err);
            Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui proses.', 'error');
          });
        }
      });
    }
    function updateKresep(selectEl, nokk) {
      const kresep = selectEl.value;
    
      Swal.fire({
        title: 'Konfirmasi Perubahan',
        text: `Apakah Anda yakin ingin mengubah kestabilan resep menjadi "${kresep}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Perbarui!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(window.location.href, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `update_kresep=1&nokk=${nokk}&kresep=${encodeURIComponent(kresep)}`
          })
          .then(response => response.text())
          .then(data => {
            console.log("Respon:", data);
            Swal.fire('Sukses!', 'Kestabilan resep berhasil diperbarui.', 'success');
          })
          .catch(err => {
            console.error("Error:", err);
            Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui kestabilan resep.', 'error');
          });
        }
      });
    }
    function updateResep(selectEl, nokk) {
      const resep = selectEl.value;
    
      Swal.fire({
        title: 'Konfirmasi Perubahan',
        text: `Apakah Anda yakin ingin mengubah Resep menjadi "${resep}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Perbarui!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(window.location.href, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `update_resep=1&nokk=${nokk}&resep=${encodeURIComponent(resep)}`
          })
          .then(response => response.text())
          .then(data => {
            console.log("Respon:", data);
            Swal.fire('Sukses!', 'Resep berhasil diperbarui.', 'success');
          })
          .catch(err => {
            console.error("Error:", err);
            Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui resep.', 'error');
          });
        }
      });
    }
    
    function updateStatusResep(selectEl, nokk) {
      const statusResep = selectEl.value;
    
      Swal.fire({
        title: 'Konfirmasi Perubahan',
        text: `Apakah Anda yakin ingin mengubah Status Resep menjadi "${statusResep}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Perbarui!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(window.location.href, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `update_StatusResep=1&nokk=${nokk}&statusResep=${encodeURIComponent(statusResep)}`
          })
          .then(response => response.text())
          .then(data => {
            console.log("Respon:", data);
            Swal.fire('Sukses!', 'Status Resep berhasil diperbarui.', 'success');
          })
          .catch(err => {
            console.error("Error:", err);
            Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui status resep.', 'error');
          });
        }
      });
    }

    function redirect_new(){
      let dataPost={
        awal : $('[name="awal"]').val(),
        akhir : $('[name="akhir"]').val(),
        gshift : $('[name="gshift"]').val(),
        fasilitas : $('[name="fasilitas"]').val(),
        jam_awal : $('[name="jam_awal"]').val(),
        jam_akhir : $('[name="jam_akhir"]').val(),
        rcode : $('[name="rcode"]').val(),
      }

      const uri = "<?=$_SERVER['REQUEST_URI'];?>";
      const uriSplit = uri.split("?");
      const scheme = "<?=$_SERVER['REQUEST_SCHEME'];?>";
      const host = "<?=$_SERVER['HTTP_HOST'];?>";
      const basePath = uriSplit[0];
      let baseUrl = ""

      if(scheme == ""){
        baseUrl = scheme + basePath;
      }else{
        baseUrl = host + basePath;
      }
      $.redirect("?p=lap-harian-produksi-baru", dataPost, "POST", "_blank");
    }
  </script>

</body>

</html>