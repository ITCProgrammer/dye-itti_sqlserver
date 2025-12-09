<?PHP
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");
$cond = mysqli_connect("10.0.0.10", "dit", "4dm1n", "db_qc");
include "tgl_indo.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan NCP</title>

</head>

<body>
  <?php
  $Awal    = isset($_POST['awal']) ? $_POST['awal'] : '';
  $Akhir    = isset($_POST['akhir']) ? $_POST['akhir'] : '';
  $Kategori  = isset($_POST['kategori']) ? $_POST['kategori'] : '';
  $Cancel    = isset($_POST['chkcancel']) ? $_POST['chkcancel'] : '';

  if ($_POST['gshift'] == "ALL") {
    $shft = " ";
  } else {
    $shft = " AND b.g_shift = '$GShift' ";
  }
  if ($_GET['awal'] != "" and $_GET['akhir'] != "") {
    $Awal1 = $_GET['awal'];
    $Akhir1 = $_GET['akhir'];
  } else {
    $Awal1 = $Awal;
    $Akhir1 = $Akhir;
  }
  ?>
  <div class="col-xs-2">
    <div class="box box-success ">
      <div class="box-header with-border">
        <h3 class="box-title">Filter Laporan NCPMemo</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1" action="?p=Lap-NCPMemo">
        <div class="box-body">
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal1; ?>" autocomplete="off" />
              </div>
            </div>
            <!-- /.input group -->
          </div>
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir1;  ?>" autocomplete="off" />
              </div>
            </div>
            <!-- /.input group -->
          </div>
          <div class="form-group">
            <div class="col-sm-10">
              <select class="form-control select2" name="kategori" id="kategori" required>
                <option value="">Pilih</option>
                <option value="ALL" <?php if ($Kategori == "ALL") {
                                      echo "SELECTED";
                                    } ?>>ALL</option>
                <option value="hitung" <?php if ($Kategori == "hitung") {
                                          echo "SELECTED";
                                        } ?>>Hitung NCP</option>
                <option value="tidakhitung" <?php if ($Kategori == "tidakhitung") {
                                              echo "SELECTED";
                                            } ?>>Tidak Hitung NCP</option>
                <option value="gerobak" <?php if ($Kategori == "gerobak") {
                                          echo "SELECTED";
                                        } ?>>Kain diGerobak</option>
              </select>
            </div>
            <!-- /.input group -->
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="col-sm-2">
            <button type="submit" class="btn btn-social btn-linkedin btn-sm" name="save">Search <i class="fa fa-search"></i></button>
          </div>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
  </div>
  <div class="col-xs-5">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"> TOP 5 NCP Berdasarkan Masalah</h3>
        <?php if ($Awal != "") { ?><br><b>Periode: <?php echo tanggal_indo($Awal) . " - " . tanggal_indo($Akhir);
                                              } ?> Ket: <?php if ($Kategori == "ALL") {
                                                                                                                      echo "ALL";
                                                                                                                    } elseif ($Kategori == "hitung") {
                                                                                                                      echo "NCP dihitung";
                                                                                                                    } elseif ($Kategori == "tidakhitung") {
                                                                                                                      echo "NCP tidak dihitung";
                                                                                                                    } elseif ($Kategori == "gerobak") {
                                                                                                                      echo "diGerobak";
                                                                                                                    } ?></b>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped" style="width: 100%;">
          <thead class="bg-blue">
            <tr>
              <th width="15%">
                <div align="center">Masalah DYE</div>
              </th>
              <th width="10%">
                <div align="center">KG</div>
              </th>
              <th width="5%">
                <div align="center">%</div>
              </th>
              <th width="10%">
                <div align="center">Disposisi</div>
              </th>
              <th width="5%">
                <div align="center">% Disp.</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($Kategori == "ALL") {
              $WKategori = " ";
            } else if ($Kategori == "hitung") {
              $WKategori = " ncp_hitung='ya' AND ";
            } else if ($Kategori == "tidakhitung") {
              $WKategori = " ncp_hitung='tidak' AND ";
            }



            $totald = 0;
            $totaldll = 0;
            $totaldDis = 0;
            $totaldllDis = 0;
            $qryAll = mysqli_query($cond, "SELECT COUNT(*) AS jml_all, if(SUM(berat) is null,0,SUM(berat)) AS berat_all FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND (masalah_dominan!='' OR masalah_dominan!=NULL) AND NOT status='Cancel'");
            $rAll = mysqli_fetch_array($qryAll);
            $qryAllDis = mysqli_query($cond, "SELECT COUNT(*) AS jml_all, if(SUM(berat) is null,0,SUM(berat)) AS berat_all FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND (masalah_dominan!='' OR masalah_dominan!=NULL) AND `status`='Disposisi' AND NOT status='Cancel' ");
            $rAllDis = mysqli_fetch_array($qryAllDis);
            $qrydef = mysqli_query($cond, "SELECT SUM(berat) AS berat, ROUND(COUNT(masalah_dominan)/(SELECT COUNT(*) FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND NOT status='Cancel'
            AND (masalah_dominan!='' OR masalah_dominan!=NULL))*100,1) AS persen, masalah_dominan
            FROM `tbl_ncp_qcf_now`
            WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND (masalah_dominan!='' OR masalah_dominan!=NULL) AND NOT status='Cancel' 
            GROUP BY masalah_dominan
            ORDER BY berat DESC LIMIT 5");
            while ($rd = mysqli_fetch_array($qrydef)) {
              $qrydefDis = mysqli_query($cond, "SELECT SUM(berat) AS berat, ROUND(COUNT(masalah_dominan)/(SELECT COUNT(*) FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND `status`='Disposisi' AND masalah_dominan='$rd[masalah_dominan]' AND NOT status='Cancel'
              AND (masalah_dominan!='' OR masalah_dominan!=NULL))*100,1) AS persen,
              masalah_dominan
              FROM
              `tbl_ncp_qcf_now`
              WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND `status`='Disposisi' AND masalah_dominan='$rd[masalah_dominan]' AND (masalah_dominan!='' OR masalah_dominan!=NULL) AND NOT status='Cancel'");
              $rdDis = mysqli_fetch_array($qrydefDis);
            ?>
              <tr valign="top">
                <td align="center"><?php echo $rd['masalah_dominan']; ?></td>
                <td align="right"><?php echo number_format(round($rd['berat'], 2), 2); ?></td>
                <td align="right"><?php echo number_format(($rd['berat'] / $rAll['berat_all']) * 100, 2) . " %"; ?></td>
                <td align="right"><?php echo number_format(round($rdDis['berat'], 2), 2); ?></td>
                <td align="right"><?php echo number_format(($rdDis['berat'] / $rAll['berat_all']) * 100, 2) . " %"; ?></td>
              </tr>
            <?php
              $totald = $totald + $rd['berat'];
              $totaldDis = $totaldDis + $rdDis['berat'];
            }
            $totaldll = $rAll['berat_all'] - $totald;
            $totaldllDis = $rAllDis['berat_all'] - $totaldDis; ?>
          </tbody>
          <tfoot>
            <tr valign="top">
              <td align="center"><strong>DLL</strong></td>
              <td align="right"><strong><?php echo number_format($totaldll, 2); ?></strong></td>
              <td align="right"><strong><?php if ($rAll['berat_all'] > 0) {
                                          echo number_format(($totaldll / $rAll['berat_all']) * 100, 2) . " %";
                                        } else {
                                          echo "0";
                                        } ?></strong></td>
              <td align="right"><strong><?php echo number_format($totaldllDis, 2); ?></strong></td>
              <td align="right"><strong><?php if ($rAllDis['berat_all'] > 0) {
                                          echo number_format(($totaldllDis / $rAll['berat_all']) * 100, 2) . " %";
                                        } else {
                                          echo "0";
                                        } ?></strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <div class="col-xs-5">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"> TOP 5 NCP Berdasarkan Mesin</h3>
        <?php if ($Awal != "") { ?><br><b>Periode: <?php echo tanggal_indo($Awal) . " - " . tanggal_indo($Akhir);
                                              } ?> Ket: <?php if ($Kategori == "ALL") {
                                                                                                                      echo "ALL";
                                                                                                                    } elseif ($Kategori == "hitung") {
                                                                                                                      echo "NCP dihitung";
                                                                                                                    } elseif ($Kategori == "tidakhitung") {
                                                                                                                      echo "NCP tidak dihitung";
                                                                                                                    } elseif ($Kategori == "gerobak") {
                                                                                                                      echo "diGerobak";
                                                                                                                    } ?></b>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped" style="width: 100%;">
          <thead class="bg-blue">
            <tr>
              <th width="15%">
                <div align="center">Mesin</div>
              </th>
              <th width="10%">
                <div align="center">KG</div>
              </th>
              <th width="5%">
                <div align="center">%</div>
              </th>
              <th width="10%">
                <div align="center">Disposisi</div>
              </th>
              <th width="5%">
                <div align="center">% Disp.</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            $totaldpt = 0;
            $totaldlldpt = 0;
            $totaldptDis = 0;
            $totaldlldptDis = 0;
            $qryAllDpt = mysqli_query($cond, "SELECT COUNT(*) AS jml_all, if(SUM(berat) is null,0,SUM(berat)) AS berat_all FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND (nama_mesin!='' OR nama_mesin!=NULL) AND NOT status='Cancel' AND dept='DYE' ");
            $rAllDpt = mysqli_fetch_array($qryAllDpt);
            $qryAllDptDis = mysqli_query($cond, "SELECT COUNT(*) AS jml_all, if(SUM(berat) is null,0,SUM(berat)) AS berat_all FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND (nama_mesin!='' OR nama_mesin!=NULL) AND `status`='Disposisi' AND NOT status='Cancel'  AND dept='DYE'");
            $rAllDptDis = mysqli_fetch_array($qryAllDptDis);
            $qrydpt = mysqli_query($cond, "SELECT SUM(berat) AS berat, ROUND(COUNT(nama_mesin)/(SELECT COUNT(*) FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND NOT status='Cancel' AND dept='DYE'
            AND (nama_mesin!='' OR nama_mesin!=NULL))*100,1) AS persen,
            nama_mesin
            FROM
            `tbl_ncp_qcf_now`
            WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND (nama_mesin!='' OR nama_mesin!=NULL) AND NOT status='Cancel' AND dept='DYE'
			GROUP BY nama_mesin
            ORDER BY berat DESC LIMIT 5");
            while ($rdpt = mysqli_fetch_array($qrydpt)) {
              $qrydptDis = mysqli_query($cond, "SELECT SUM(berat) AS berat, ROUND(COUNT(nama_mesin)/(SELECT COUNT(*) FROM tbl_ncp_qcf_now WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND `status`='Disposisi' AND dept='DYE' AND NOT status='Cancel'
              AND (nama_mesin!='' OR nama_mesin!=NULL))*100,1) AS persen,
              nama_mesin
              FROM
              `tbl_ncp_qcf_now`
              WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal' AND '$Akhir' AND `status`='Disposisi' AND dept='DYE' AND 
			  (nama_mesin!='' OR nama_mesin!=NULL) AND NOT status='Cancel' AND nama_mesin='$rdpt[nama_mesin]' ");
              $rdptDis = mysqli_fetch_array($qrydptDis);
            ?>
              <tr valign="top">
                <td align="center"><?php echo $rdpt['nama_mesin']; ?></td>
                <td align="right"><?php echo number_format(round($rdpt['berat'], 2), 2); ?></td>
                <td align="right"><?php echo number_format(($rdpt['berat'] / $rAllDpt['berat_all']) * 100, 2) . " %"; ?></td>
                <td align="right"><?php echo number_format(round($rdptDis['berat'], 2), 2); ?></td>
                <td align="right"><?php echo number_format(($rdptDis['berat'] / $rAllDpt['berat_all']) * 100, 2) . " %"; ?></td>
              </tr>
            <?php
              $totaldpt = $totaldpt + $rdpt['berat'];
              $totaldptDis = $totaldptDis + $rdptDis['berat'];
            }
            $totaldlldpt = $rAllDpt['berat_all'] - $totaldpt;
            $totaldlldptDis = $rAllDptDis['berat_all'] - $totaldptDis; ?>
          </tbody>
          <tfoot>
            <tr valign="top">
              <td align="center"><strong>DLL</strong></td>
              <td align="right"><strong><?php echo number_format($totaldlldpt, 2); ?></strong></td>
              <td align="right"><strong><?php if ($rAllDpt['berat_all'] > 0) {
                                          echo number_format(($totaldlldpt / $rAllDpt['berat_all']) * 100, 2) . " %";
                                        } else {
                                          echo "0";
                                        } ?></strong></td>
              <td align="right"><strong><?php echo number_format($totaldlldptDis, 2); ?></strong></td>
              <td align="right"><strong><?php if ($rAllDptDis['berat_all'] > 0) {
                                          echo number_format(($totaldlldptDis / $rAllDpt['berat_all']) * 100, 2) . " %";
                                        } else {
                                          echo "0";
                                        } ?></strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <?php
  $qry1 = mysqli_query($con, "SELECT * FROM tbl_ncp_memo WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal1' AND '$Akhir1' ORDER BY id ASC");
  $qrySUM = mysqli_query($con, "SELECT COUNT(*) as Lot, SUM(rol_ncp) as Rol,SUM(qty_ncp) as Berat FROM tbl_ncp_memo WHERE $WKategori DATE_FORMAT( tgl_buat, '%Y-%m-%d' ) BETWEEN '$Awal1' AND '$Akhir1' ");
  $rSUM = mysqli_fetch_array($qrySUM);
  ?>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Data NCP-Memo</h3>
          <?php if ($Awal1 != "") { ?>
            <div class="pull-right">
              <a href="pages/cetak/cetak_harianncpmemo.php?&kategori=<?php echo $Kategori; ?>&awal=<?php echo $Awal1; ?>&akhir=<?php echo $Akhir1; ?>" class="btn btn-danger " target="_blank" data-toggle="tooltip" data-html="true" title="Laporan NCP Memo"><i class="fa fa-print"></i> Cetak</a>
              <a href="pages/cetak/cetak_harianncpmemo_excel.php?&kategori=<?php echo $Kategori; ?>&awal=<?php echo $Awal1; ?>&akhir=<?php echo $Akhir1; ?>" class="btn btn-primary " target="_blank" data-toggle="tooltip" data-html="true" title="Cetak ke Excel"><i class="fa fa-file-excel-o"></i> Cetak ke EXCEL</a>
              <a href="pages/cetak/cetak_ncplaporan_excel.php?&kategori=<?php echo $Kategori; ?>&awal=<?php echo $Awal1; ?>&akhir=<?php echo $Akhir1; ?>" class="btn btn-success " target="_blank" data-toggle="tooltip" data-html="true" title="Cetak Laporan NCP"><i class="fa fa-file-excel-o"></i> Cetak Excel Lap NCP</a>
            </div>
          <?php } ?>
          <?php if ($Awal1 != "") { ?><br><b>Periode: <?php echo tanggal_indo($Awal1) . " - " . tanggal_indo($Akhir1); ?></b>
            <h4>Total Lot: <span class="label label-info"><?php echo $rSUM['Lot']; ?></span></h4>
            <h4>Total Rol: <span class="label label-warning"><?php echo number_format($rSUM['Rol']); ?></span></h4>
            <h4>Total Qty : <span class="label label-danger"><?php echo number_format($rSUM['Berat'], "2") . " Kg"; ?></span></h4>
          <?php } ?>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover table-striped nowrap" id="example3" style="width:100%">
            <thead class="bg-green">
              <tr>
                <th>
                  <div align="center">Status NCP</div>
                </th>
                <th>
                  <div align="center">No NCP</div>
                </th>
                <th>
                  <div align="center">KK NCP</div>
                </th>
                <th>
                  <div align="center">Langganan</div>
                </th>
                <th>
                  <div align="center">Buyer</div>
                </th>
                <th>
                  <div align="center">Order</div>
                </th>
                <th>
                  <div align="center">Jenis Kain</div>
                </th>
                <th>
                  <div align="center">Warna</div>
                </th>
                <th>
                  <div align="center">No Warna</div>
                </th>
                <th>
                  <div align="center">Lot</div>
                </th>
                <th>
                  <div align="center">KK Induk</div>
                </th>
                <th>
                  <div align="center">Rol Induk</div>
                </th>
                <th>
                  <div align="center">Rol NCP</div>
                </th>
                <th>
                  <div align="center">Qty NCP</div>
                </th>
                <th>
                  <div align="center">Tolak QCF</div>
                </th>
                <th>
                  <div align="center">Tgl CLP</div>
                </th>
                <th>
                  <div align="center">Mesin CLP</div>
                </th>
                <th>
                  <div align="center">Nama Mesin</div>
                </th>
                <th>
                  <div align="center">ACC Keluar Kain</div>
                </th>
                <th align="center" class="table-list1">
                  <div align="center">Operator</div>
                </th>
                <th align="center" class="table-list1">
                  <div align="center">Keterangan Masalah</div>
                </th>
                <th align="center" class="table-list1">
                  <div align="center">Tempat Kain</div>
                </th>
                <th align="center" class="table-list1">
                  <div align="center">Tgl Penyelesaian</div>
                </th>
                <th align="center" class="table-list1">
                  <div align="center">Acc Perbaikan</div>
                </th>
                <th align="center" class="table-list1">
                  <div align="center">Penyelesaian</div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($row1 = mysqli_fetch_array($qry1)) {
                $qCekNCP = mysqli_query($cond, "SELECT * FROM tbl_ncp_qcf_now WHERE nokk='$row1[nokk_ncp]' and no_ncp_gabungan='$row1[no_ncp]' and dept='DYE' ORDER BY id DESC");
                $dNCP = mysqli_fetch_array($qCekNCP);
                $sqlMc = mysqli_query($con, "SELECT kode FROM tbl_mesin WHERE no_mesin='" . $row1['mc_celup'] . "'");
                $rMC = mysqli_fetch_array($sqlMc);
              ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $row1['jnsdata']; ?><br>
                    <div class="btn-group"><a href="#" class="btn btn-xs btn-primary tambah_analisa_new " id="<?php echo $row1['id'] . "." . $_POST['awal'] . "," . $_POST['akhir']; ?>"><i class="fa fa-edit"></i></a><a href="pages/cetak/cetak_ncp_new.php?id=<?php echo $row1['id_ncp']; ?>" class="btn btn-xs btn-danger" target="_blank"><i class="fa fa-print"></i></a><a href="pages/cetak/cetak_ncp_new_pdf.php?id=<?php echo $row1['id_ncp']; ?>" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-file-pdf-o"></i></a></div>
                  </td>
                  <td align="center"><a href="?p=penyelesaian-new&id=<?php echo $row1['id_ncp']; ?>&awal=<?php echo $Awal1; ?>&akhir=<?php echo $Akhir1; ?>" class="btn btn-xs btn-danger"><?php echo $row1['no_ncp']; ?></a></td>
                  <td><?php echo $row1['nokk_ncp']; ?></td>
                  <td><?php echo $dNCP['langganan']; ?></td>
                  <td align="center"><?php echo $dNCP['buyer']; ?></td>
                  <td align="center"><?php echo $dNCP['no_order']; ?></td>
                  <td><?php echo $dNCP['jenis_kain']; ?></td>
                  <td align="center"><?php echo $dNCP['warna']; ?></td>
                  <td align="center"><?php echo $dNCP['no_warna']; ?></td>
                  <td align="center"><?php echo $dNCP['lot']; ?></td>
                  <td><?php echo $row1['nokk']; ?></td>
                  <td align="right"><?php echo $row1['rol_induk']; ?></td>
                  <td align="right"><?php echo $row1['rol_ncp']; ?></td>
                  <td align="right"><?php echo $row1['qty_ncp']; ?></td>
                  <td align="center"><?php echo $row1['tolak_qcf']; ?></td>
                  <td><?php echo $row1['tgl_celup']; ?></td>
                  <td><?php echo $row1['mc_celup']; ?></td>
                  <td><?php echo $rMC['kode']; ?></td>
                  <td><?php echo $row1['acc_keluar']; ?></td>
                  <td><?php echo $row1['operator']; ?></td>
                  <td><?php echo $row1['masalah']; ?></td>
                  <td><?php echo $row1['tempat_kain']; ?></td>
                  <td><?php echo $row1['tgl_penyelesaian']; ?></td>
                  <td><?php echo $row1['acc_perbaikan']; ?></td>
                  <td><?php echo $row1['penyelesaian']; ?></td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div id="StsEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
  <div id="TambahAnalisaNew" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  </div>
  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
</body>

</html>