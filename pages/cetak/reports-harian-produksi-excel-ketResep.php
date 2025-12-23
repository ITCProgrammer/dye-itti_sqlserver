<?php
  ini_set("error_reporting", 0);
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=report-produksi-" . substr($_GET['awal'], 0, 10) . ".xls"); //ganti nama sesuai keperluan
  header("Pragma: no-cache");
  header("Expires: 0");
  //disini script laporan anda
?>
<?php
  ini_set("error_reporting", 1);
  include "../../koneksi.php";
  include "../../koneksiLAB.php";
  include "../../tgl_indo.php";
  function formatDurationHM($start, $end = null) {
    if (empty($start)) {
      return '';
    }
    if ($start instanceof DateTimeInterface) {
      $startDt = $start;
    } else {
      try {
        $startDt = new DateTime($start);
      } catch (Exception $e) {
        return '';
      }
    }
    if ($end === null) {
      $endDt = new DateTime();
    } elseif ($end instanceof DateTimeInterface) {
      $endDt = $end;
    } else {
      try {
        $endDt = new DateTime($end);
      } catch (Exception $e) {
        return '';
      }
    }
    $interval = $startDt->diff($endDt);
    $minutes  = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
    $hours    = floor($minutes / 60);
    $mins     = $minutes % 60;
    return sprintf('%02d:%02d', $hours, $mins);
  }
  //--
  $idkk = $_REQUEST['idkk'];
  $act = $_GET['g'];
  $Awal = $_GET['awal'];
  $Akhir = $_GET['akhir'];
  if ($Awal == $Akhir) {
    $TglPAl = substr($Awal, 0, 10);
    $TglPAr = substr($Akhir, 0, 10);
  } else {
    $TglPAl = $Awal;
    $TglPAr = $Akhir;
  }
  $shft = $_GET['shft'];
?>

<body>
  <strong>Periode: <?php echo $TglPAl; ?> s/d <?php echo $TglPAr; ?></strong><br>
  <strong>Shift: <?php echo $shft; ?></strong><br />
  <table width="100%" border="1">
    <tr>
      <th rowspan="2" bgcolor="#99FF99">NO.</th>
      <th rowspan="2" bgcolor="#99FF99">SHIFT</th>
      <th rowspan="2" bgcolor="#99FF99">NO MC</th>
      <th rowspan="2" bgcolor="#99FF99">KAPASITAS</th>
      <th rowspan="2" bgcolor="#99FF99">LANGGANAN</th>
      <th rowspan="2" bgcolor="#99FF99">BUYER</th>
      <th rowspan="2" bgcolor="#99FF99">NO ORDER</th>
      <th rowspan="2" bgcolor="#99FF99">JENIS KAIN</th>
      <th rowspan="2" bgcolor="#99FF99">WARNA</th>
      <th rowspan="2" bgcolor="#99FF99">K.W</th>
      <th rowspan="2" bgcolor="#99FF99">LOT</th>
      <th rowspan="2" bgcolor="#99FF99">ROLL</th>
      <th rowspan="2" bgcolor="#99FF99">QTY</th>
      <th rowspan="2" bgcolor="#99FF99">PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">% LOADING</th>
      <th rowspan="2" bgcolor="#99FF99">L:R</th>
      <th rowspan="2" bgcolor="#99FF99">PEMAKAIAN AIR</th>
      <th rowspan="2" bgcolor="#99FF99">KETERANGAN</th>
      <th rowspan="2" bgcolor="#99FF99">K.R</th>
      <th rowspan="2" bgcolor="#99FF99">R.B/R.L/R.S</th>
      <th rowspan="2" bgcolor="#99FF99">STATUS</th>
      <th rowspan="2" bgcolor="#99FF99">DYESTUFF</th>
      <th rowspan="2" bgcolor="#99FF99">ENERGY</th>
      <th colspan="4" bgcolor="#99FF99">JAM PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">LAMA PROSES</th>
      <th rowspan="2" bgcolor="#99FF99">POINT</th>
      <th colspan="4" bgcolor="#99FF99">STOP MESIN</th>
      <th rowspan="2" bgcolor="#99FF99">LAMA STOP</th>
      <th rowspan="2" bgcolor="#99FF99">KODE STOP</th>
      <th rowspan="2" bgcolor="#99FF99">Acc Keluar Kain</th>
      <th rowspan="2" bgcolor="#99FF99">Operator</th>
      <th rowspan="2" bgcolor="#99FF99">NoKK</th>
      <th rowspan="2" bgcolor="#99FF99">No Warna</th>
      <th rowspan="2" bgcolor="#99FF99">Lebar</th>
      <th rowspan="2" bgcolor="#99FF99">Gramasi</th>
      <th rowspan="2" bgcolor="#99FF99">Carry Over</th>
      <th rowspan="2" bgcolor="#99FF99">ACUAN QUALITY</th>
      <th rowspan="2" bgcolor="#99FF99">ITEM</th>
      <th rowspan="2" bgcolor="#99FF99">NO PO</th>
      <th rowspan="2" bgcolor="#99FF99">TGL DELIVERY</th>
      <th rowspan="2" bgcolor="#99FF99">Point Proses</th>
      <th rowspan="2" bgcolor="#99FF99">Penanggung Jawab</th>
      <th rowspan="2" bgcolor="#99FF99">Analisa Penyebab</th>
      <th rowspan="2" bgcolor="#99FF99">No program</th>
      <th rowspan="2" bgcolor="#99FF99">Panjang kain</th>
      <th rowspan="2" bgcolor="#99FF99">Cycle time</th>
      <th rowspan="2" bgcolor="#99FF99">RPM</th>
      <th rowspan="2" bgcolor="#99FF99">Tekanan/press</th>
      <th rowspan="2" bgcolor="#99FF99">Nozzle</th>
      <th rowspan="2" bgcolor="#99FF99">Plaiter</th>
      <th rowspan="2" bgcolor="#99FF99">Blower</th>
      <th rowspan="2" bgcolor="#99FF99">Air Awal</th>
      <th rowspan="2" bgcolor="#99FF99">Air Akhir</th>
      <th rowspan="2" bgcolor="#99FF99">Total Pemakaian Air</th>
      <th rowspan="2" bgcolor="#99FF99">Std Target</th>
      <th rowspan="2" bgcolor="#99FF99">Jml Gerobak</th>
      <th rowspan="2" bgcolor="#99FF99">Jns Gerobak</th>
      <th rowspan="2" bgcolor="#99FF99">Nokk Legacy</th>
      <th rowspan="2" bgcolor="#99FF99">Prod. Demand</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat Terakhir</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat 1x</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat 2x</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat 3x</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat 4x</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat 5x</th>
      <th rowspan="2" bgcolor="#99FF99">Tambah Obat 6x</th>
      <th rowspan="2" bgcolor="#99FF99">Leader</th>
      <th rowspan="2" bgcolor="#99FF99">Suffix</th>
      <th rowspan="2" bgcolor="#99FF99">Suffix 2</th>
      <th rowspan="2" bgcolor="#99FF99">LR 2</th>
      <th rowspan="2" bgcolor="#99FF99">Lebar Aktual FIN</th>
      <th rowspan="2" bgcolor="#99FF99">Gramasi Aktual FIN</th>
      <th rowspan="2" bgcolor="#99FF99">Lebar Aktual DYE</th>
      <th rowspan="2" bgcolor="#99FF99">Gramasi Aktual DYE</th>
      <th rowspan="2" bgcolor="#99FF99">Operator</th>
      <th rowspan="2" bgcolor="#99FF99">LOT di NOW</th>
      <th rowspan="2" bgcolor="#99FF99">Status Resep</th>
      <th rowspan="2" bgcolor="#99FF99">Keterangan Analisa Resep</th>
    </tr>
    <tr>
      <th bgcolor="#99FF99">TGL</th>
      <th bgcolor="#99FF99">IN</th>
      <th bgcolor="#99FF99">TGL</th>
      <th bgcolor="#99FF99">OUT</th>
      <th bgcolor="#99FF99">TGL</th>
      <th bgcolor="#99FF99">JAM</th>
      <th bgcolor="#99FF99">TGL</th>
      <th bgcolor="#99FF99">S/D</th>
    </tr>
    <?php
        ini_set("error_reporting", 0);
        $Awal  = $_GET['awal'];
        $Akhir = $_GET['akhir'];
        $Tgl   = substr($Awal, 0, 10);
        // Alias yang dipakai di subquery: mt (tbl_montemp)
        if ($Awal != $Akhir) {
          $Where = " mt.tgl_update BETWEEN '$Awal' AND '$Akhir' ";
        } else {
          $Where = " CONVERT(date, mt.tgl_update) = CONVERT(date, '$Tgl') ";
        }
        if ($_GET['shft'] == "ALL") {
          $shft = " ";
        } else {
          $shft = " ISNULL(hc.g_shift, mt.g_shift)='".$_GET['shft']."' AND ";
        }
        if($_GET['rcode']){
          $left_right = 'RIGHT';
          $where_new = "hc.rcode LIKE '%$_GET[rcode]%'";
        }else{
          $left_right = 'LEFT';
          $where_new = $shft.' '.$Where;
        }
        $sql = sqlsrv_query(
          $con,
          "SELECT x.*, m.no_mesin as mc, m.no_mc_lama as mc_lama
           FROM db_dying.tbl_mesin m
           $left_right JOIN
           (
             SELECT
               hc.kd_stop,
               hc.mulai_stop,
               hc.selesai_stop,
               hc.ket,
               hc.lama_proses,
               hc.status as sts,
               hc.point,
               hc.acc_keluar,
               CASE
                 WHEN (hc.proses = '' OR hc.proses IS NULL) THEN sch.proses
                 ELSE hc.proses
               END as proses,
               sch.buyer,
               sch.langganan,
               sch.no_order,
               sch.jenis_kain,
               sch.no_mesin,
               sch.warna,
               sch.lot,
               sch.energi,
               sch.dyestuff,
               sch.ket_status,
               sch.kapasitas,
               sch.loading,
               sch.resep,
               sch.kategori_warna,
               sch.target,
               mt.l_r,
               mt.rol,
               mt.bruto,
               mt.pakai_air,
               mt.no_program,
               mt.pjng_kain,
               mt.cycle_time,
               mt.rpm,
               mt.tekanan,
               mt.nozzle,
               mt.plaiter,
               mt.blower,
               mt.tgl_buat as tgl_in,
               hc.tgl_buat as tgl_out,
               FORMAT(mt.tgl_buat, 'HH:mm') as jam_in,
               FORMAT(hc.tgl_buat, 'HH:mm') as jam_out,
               ISNULL(hc.g_shift, mt.g_shift) as shft,
               mt.status as status_montemp,
               mt.tgl_mulai,
               mt.tgl_stop,
               hc.operator_keluar,
               hc.k_resep,
               hc.status,
               hc.proses_point,
               hc.analisa,
               sch.nokk,
               sch.no_warna,
               sch.lebar,
               sch.gramasi,
               mt.carry_over,
               sch.no_hanger,
               sch.no_item,
               sch.po,
               sch.tgl_delivery,
               sch.kk_kestabilan,
               sch.kk_normal,
               mt.air_awal,
               hc.air_akhir,
               mt.nokk_legacy,
               mt.loterp,
               mt.nodemand,
               hc.tambah_obat,
               hc.tambah_obat1,
               hc.tambah_obat2,
               hc.tambah_obat3,
               hc.tambah_obat4,
               hc.tambah_obat5,
               hc.tambah_obat6,
               mt.leader,
               sch.suffix,
               sch.suffix2,
               mt.l_r_2,
               mt.lebar_fin,
               mt.grm_fin,
               mt.lebar_a,
               mt.gramasi_a,
               mt.operator,
               hc.status_resep,
               hc.analisa_resep,
               hc.penanggungjawabbuyer AS penanggung_jawab
             FROM db_dying.tbl_schedule sch
             LEFT JOIN db_dying.tbl_montemp mt ON mt.id_schedule = sch.id
             LEFT JOIN db_dying.tbl_hasilcelup hc ON hc.id_montemp = mt.id
             WHERE $where_new
           ) x ON (m.no_mesin = x.no_mesin OR m.no_mc_lama = x.no_mesin)
           ORDER BY m.no_mesin"
        );
        function FormatDate($dateValue) {
          if ($dateValue instanceof DateTimeInterface) {
            return $dateValue->format('Y-m-d');
          }
          return '';
        }
        $no = 1;

        $c = 0;
        $totrol = 0;
        $totberat = 0;

        if ($sql === false) {
          $err = sqlsrv_errors();
          $msg = $err ? $err[0]['message'] : 'Gagal mengambil data produksi.';
          echo '<tr><td colspan="10">Error SQL: ' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</td></tr>';
        } else {
        while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
          // Hitung lama proses (HH:MM)
          $lamaProses = '';
          if (!empty($rowd['status_montemp']) && $rowd['status_montemp'] === 'selesai') {
            if (!empty($rowd['tgl_mulai']) && !empty($rowd['tgl_stop'])) {
              $lamaProses = formatDurationHM($rowd['tgl_mulai'], $rowd['tgl_stop']);
            } elseif (!empty($rowd['lama_proses'])) {
              $lamaProses = $rowd['lama_proses'];
            }
          } elseif (!empty($rowd['tgl_in'])) {
            $lamaProses = formatDurationHM($rowd['tgl_in']);
          }
          $rowd['lama_proses_display'] = $lamaProses;

          // Hitung lama stop (HH:MM) dari hasilcelup
          $lamaStopDisplay = '';
          if (!empty($rowd['mulai_stop']) && !empty($rowd['selesai_stop'])) {
            $lamaStopDisplay = formatDurationHM($rowd['mulai_stop'], $rowd['selesai_stop']);
          }
          $rowd['lama_stop_display'] = $lamaStopDisplay;
          if ($_GET['shft'] == "ALL") {
            $shftSM = " ";
          } else {
            $shftSM = " g_shift='".$_GET['shft']."' AND ";
          }
          $sqlSM = sqlsrv_query(
            $con,
            "SELECT TOP 1 *, kapasitas as kapSM, g_shift as shiftSM
             FROM db_dying.tbl_stopmesin
             WHERE $shftSM tgl_update BETWEEN '".$_GET['awal']."' AND '".$_GET['akhir']."'
               AND no_mesin='".$rowd['mc']."'
             ORDER BY id DESC"
          );
          $rowSM = sqlsrv_fetch_array($sqlSM, SQLSRV_FETCH_ASSOC);
          if ($rowSM) {
            $rowSM['tgl_masuk']   = isset($rowSM['mulai']) ? (($rowSM['mulai'] instanceof DateTimeInterface) ? $rowSM['mulai']->format('Y-m-d') : substr((string)$rowSM['mulai'], 0, 10)) : '';
            $rowSM['tgl_selesai'] = isset($rowSM['selesai']) ? (($rowSM['selesai'] instanceof DateTimeInterface) ? $rowSM['selesai']->format('Y-m-d') : substr((string)$rowSM['selesai'], 0, 10)) : '';
            $rowSM['jam_masuk']   = isset($rowSM['mulai']) ? (($rowSM['mulai'] instanceof DateTimeInterface) ? $rowSM['mulai']->format('H:i') : substr((string)$rowSM['mulai'], 11, 5)) : '';
            $rowSM['jam_selesai'] = isset($rowSM['selesai']) ? (($rowSM['selesai'] instanceof DateTimeInterface) ? $rowSM['selesai']->format('H:i') : substr((string)$rowSM['selesai'], 11, 5)) : '';
            $rowSM['menitSM']     = (!empty($rowSM['mulai']) && !empty($rowSM['selesai'])) ? formatDurationHM($rowSM['mulai'], $rowSM['selesai']) : '';
          } else {
            $rowSM = array(
              'shiftSM'    => '',
              'kapSM'      => '',
              'proses'     => '',
              'tgl_masuk'  => '',
              'tgl_selesai'=> '',
              'jam_masuk'  => '',
              'jam_selesai'=> '',
              'menitSM'    => '',
              'kd_stopmc'  => '',
              'keterangan' => '',
              'no_stop'    => ''
            );
          }
          if (strlen($rowd['rol']) > 5) {
            $jk = strlen($rowd['rol']) - 5;
            $rl = substr($rowd['rol'], 0, $jk);
          } else {
            $rl = $rowd['rol'];
          }
    ?>
      <tr valign="top">
        <td><?php echo $no; ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['shiftSM'];
            } else {
              echo $rowd['shft'];
            } ?></td>
        <td>'<?php echo $rowd['mc']; ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['kapSM'];
            } else {
              echo $rowd['kapasitas'];
            } ?></td>
        <td><?php echo $rowd['langganan']; ?></td>
        <td><?php echo $rowd['buyer']; ?></td>
        <td><?php echo $rowd['no_order']; ?></td>
        <td><?php echo $rowd['jenis_kain']; ?></td>
        <td><?php echo $rowd['warna']; ?></td>
        <td><?php echo $rowd['kategori_warna']; ?></td>
        <td>'<?php echo $rowd['lot']; ?></td>
        <td><?php if ($rowd['tgl_out'] != "") {
              $rol = $rowd['rol'];
            } else {
              $rol = 0;
            }
            echo $rol; ?></td>
        <td><?php if ($rowd['tgl_out'] != "") {
              $brt = $rowd['bruto'];
            } else {
              $brt = 0;
            }
            echo $brt; ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['proses'];
            } else {
              echo $rowd['proses'];
            } ?></td>
        <td><?php echo $rowd['loading']; ?></td>
        <td>'<?php echo $rowd['l_r']; ?></td>
        <td><?php echo $rowd['pakai_air']; ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['keterangan'] . "" . $rowSM['no_stop'];
            } else {
              echo $rowd['ket'] . "" . $rowd['status'];
            } ?><?php if ($rowd['kk_kestabilan'] == "1" and $rowd['kk_normal'] == "0") {
                                                                                                                                                                                              echo "<br>Test Kestabilan";
                                                                                                                                                                                            } ?></td>
        <td><?php echo $rowd['k_resep']; ?></td>
        <td><?php if ($rowd['ket_status'] == "") {
              echo "";
            } else if ($rowd['ket_status'] != "MC Stop") {
              if ($rowd['resep'] == "Baru") {
                echo "R.B";
              }elseif($rowd['resep'] == "Lama") {
                echo "R.L";
              }elseif($rowd['resep'] == "Setting") {
                echo "R.S";
              }
            } ?></td>
        <td><?php echo $rowd['sts']; ?></td>
        <td><?php echo $rowd['dyestuff']; ?></td>
        <td><?php echo $rowd['energi']; ?></td>
        <td><?php echo FormatDate($rowd['tgl_in']); ?></td>
        <td><?php echo $rowd['jam_in']; ?></td>
        <td><?php echo Formatdate($rowd['tgl_out']); ?></td>
        <td><?php echo $rowd['jam_out']; ?></td>
        <td><?php if ($rowd['lama_proses_display'] != "") {
              echo $rowd['lama_proses_display'];
            } ?></td>
        <td><?php echo $rowd['point']; ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['tgl_masuk'];
            } else {
              if (!empty($rowd['mulai_stop'])) {
                if ($rowd['mulai_stop'] instanceof DateTimeInterface) {
                  echo $rowd['mulai_stop']->format('Y-m-d');
                } else {
                  echo substr((string)$rowd['mulai_stop'], 0, 10);
                }
              }
            } ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['jam_masuk'];
            } else {
              if (!empty($rowd['mulai_stop'])) {
                if ($rowd['mulai_stop'] instanceof DateTimeInterface) {
                  echo $rowd['mulai_stop']->format('H:i');
                } else {
                  echo substr((string)$rowd['mulai_stop'], 11, 5);
                }
              }
            } ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['tgl_selesai'];
            } else {
              if (!empty($rowd['selesai_stop'])) {
                if ($rowd['selesai_stop'] instanceof DateTimeInterface) {
                  echo $rowd['selesai_stop']->format('Y-m-d');
                } else {
                  echo substr((string)$rowd['selesai_stop'], 0, 10);
                }
              }
            } ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['jam_selesai'];
            } else {
              if (!empty($rowd['selesai_stop'])) {
                if ($rowd['selesai_stop'] instanceof DateTimeInterface) {
                  echo $rowd['selesai_stop']->format('H:i');
                } else {
                  echo substr((string)$rowd['selesai_stop'], 11, 5);
                }
              }
            } ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['menitSM'];
            } else if ($rowd['lama_stop_display'] != "") {
              echo $rowd['lama_stop_display'];
            } ?></td>
        <td><?php if ($rowd['langganan'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
              echo $rowSM['kd_stopmc'];
            } else {
              echo $rowd['kd_stop'];
            } ?></td>
        <td><?php echo $rowd['acc_keluar']; ?></td>
        <td><?php echo $rowd['operator_keluar']; ?></td>
        <td>'<?php echo $rowd['nokk']; ?></td>
        <td><?php echo $rowd['no_warna']; ?></td>
        <td><?php echo $rowd['lebar']; ?></td>
        <td><?php echo $rowd['gramasi']; ?></td>
        <td><?php echo $rowd['carry_over']; ?></td>
        <td><?php echo $rowd['no_hanger']; ?></td>
        <td><?php echo $rowd['no_item']; ?></td>
        <td><?php echo $rowd['po']; ?></td>
        <td><?php echo FormatDate($rowd['tgl_delivery']); ?></td>
        <td><?php echo $rowd['proses_point']; ?></td>
        <td><?php echo $rowd['penanggung_jawab']; ?></td>
        <td><?php echo $rowd['analisa']; ?></td>
        <td><?php echo $rowd['no_program']; ?></td>
        <td><?php echo $rowd['pjng_kain']; ?></td>
        <td><?php echo $rowd['cycle_time']; ?></td>
        <td><?php echo $rowd['rpm']; ?></td>
        <td><?php echo $rowd['tekanan']; ?></td>
        <td><?php echo $rowd['nozzle']; ?></td>
        <td><?php echo $rowd['plaiter']; ?></td>
        <td><?php echo $rowd['blower']; ?></td>
        <td><?php echo $rowd['air_awal']; ?></td>
        <td><?php echo $rowd['air_akhir']; ?></td>
        <td>
          <?php 
            if ($rowd['air_akhir']) {
              echo $rowd['air_akhir'] - $rowd['air_awal'];
            } 
          ?>
        </td>
        <td><?php echo $rowd['target']; ?></td>
        <td><?php echo $rowd['gerobak']; ?></td>
        <td><?php echo $rowd['jns_gerobak']; ?></td>
        <td>'<?php echo $rowd['nokk_legacy']; ?></td>
        <td>'<?php echo $rowd['nodemand']; ?></td>
        <td><?php echo $rowd['tambah_obat']; ?></td>
        <td><?php echo $rowd['tambah_obat1']; ?></td>
        <td><?php echo $rowd['tambah_obat2']; ?></td>
        <td><?php echo $rowd['tambah_obat3']; ?></td>
        <td><?php echo $rowd['tambah_obat4']; ?></td>
        <td><?php echo $rowd['tambah_obat5']; ?></td>
        <td><?php echo $rowd['tambah_obat6']; ?></td>
        <td><?= $rowd['leader']; ?></td>
        <td><?= $rowd['suffix']; ?></td>
        <td><?= $rowd['suffix2']; ?></td>
        <td><?= $rowd['l_r_2']; ?></td>
        <td><?= $rowd['lebar_fin']; ?></td>
        <td><?= $rowd['grm_fin']; ?></td>
        <td><?= $rowd['lebar_a']; ?></td>
        <td><?= $rowd['gramasi_a']; ?></td>
        <td><?= $rowd['operator']; ?></td>
        <td>'
          <?php
            $q_lot		= db2_exec($conn2, "SELECT * FROM ITXVIEWKK WHERE PRODUCTIONDEMANDCODE = '$rowd[nodemand]'");
            $d_lot		= db2_fetch_assoc($q_lot);
            echo $d_lot['LOT'];
          ?>
        </td>
        <td><?= $rowd['status_resep'] ?></td>
        <td><?= $rowd['analisa_resep'] ?></td>
      </tr>
    <?php
      $totrol += $rol;
      $totberat += $brt;
      $no++;
    } } ?>
    <tr>
      <td colspan="8" bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">Total</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99"><?php echo $totrol; ?></th>
      <th bgcolor="#99FF99"><?php echo $totberat; ?></th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <th bgcolor="#99FF99">&nbsp;</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <th bgcolor="#99FF99">&nbsp;</th>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th colspan="3">&nbsp;</th>
      <th colspan="9">DIBUAT OLEH:</th>
      <th colspan="11">DIPERIKSA OLEH:</th>
      <th colspan="13">DIKETAHUI OLEH:</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <td colspan="3">NAMA</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="13">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">JABATAN</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="13">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">TANGGAL</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="13">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="60" colspan="3" valign="top">TANDA TANGAN</td>
      <td colspan="9">&nbsp;</td>
      <td colspan="11">&nbsp;</td>
      <td colspan="13">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</body>
