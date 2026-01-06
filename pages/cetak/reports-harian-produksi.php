<?php
  //$lReg_username=$_SESSION['labReg_username'];

  ini_set("error_reporting", 1);
  include "../../koneksi.php";
  include "../../koneksiLAB.php";
  include "../../tgl_indo.php";
  //--
  $idkk = $_REQUEST['idkk'];
  $act = $_GET['g'];
  //-
  $qTgl = sqlsrv_query(
    $con,
    "SELECT 
       CONVERT(varchar(10), GETDATE(), 23) AS tgl_skrg,
       CONVERT(varchar(10), DATEADD(DAY, 1, GETDATE()), 23) AS tgl_besok"
  );
  if ($qTgl !== false) {
    $rTgl = sqlsrv_fetch_array($qTgl, SQLSRV_FETCH_ASSOC);
  } else {
    $rTgl = null;
  }

  if (!function_exists('format_time_sqlsrv')) {
    function format_time_sqlsrv($value)
    {
      if ($value instanceof DateTimeInterface) {
        return $value->format('H:i');
      }
      if ($value === null || $value === '') {
        return '';
      }
      $ts = strtotime($value);
      if ($ts === false) {
        return '';
      }
      return date('H:i', $ts);
    }
  }
?>
<html>

<head>
  <title>:: Cetak Reports Produksi Dyeing</title>
  <link href="styles_cetak.css" rel="stylesheet" type="text/css">
  <style>
    input {
      text-align: center;
      border: hidden;
    }

    @media print {
      ::-webkit-input-placeholder {
        /* WebKit browsers */
        color: transparent;
      }

      :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        color: transparent;
      }

      ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        color: transparent;
      }

      :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        color: transparent;
      }

      .pagebreak {
        page-break-before: always;
      }

      .header {
        display: block
      }

      table thead {
        display: table-header-group;
      }
    }
  </style>
</head>

<body>
  <table width="100%" border="0" class="table-list1">
    <thead>
      <tr valign="top">
        <td colspan="18">
          <table width="100%" border="0" class="table-list1">
            <thead>
              <tr>
                <td width="6%" rowspan="4"><img src="Indo.jpg" alt="" width="60" height="60"></td>
                <td width="75%" rowspan="4">
                  <div align="center">
                    <h2>FORM PRODUKSI HARIAN DYEING</h2>
                  </div>
                </td>
                <td width="8%">No. Form</td>
                <td width="11%">: FW-02-DYE-03</td>
              </tr>
              <tr>
                <td>No. Revisi</td>
                <td>: 06</td>
              </tr>
              <tr>
                <td>Tgl. Terbit</td>
                <td>: 01 Maret 2019</td>
              </tr>
              <thead>
          </table>
        </td>
      </tr>
      <?php $Awal = $_GET['awal'];
      $Akhir = $_GET['akhir'];
      if ($Awal == $Akhir) {
        $TglPAl = substr($Awal, 0, 10);
        $TglPAr = substr($Akhir, 0, 10);
      } else {
        $TglPAl = $Awal;
        $TglPAr = $Akhir;
      }
      ?>
      <tr valign="top">
        <td colspan="18"><strong>Periode: <?php echo $TglPAl; ?> s/d <?php echo $TglPAr; ?></strong><br />
          <strong>Shift: <?php echo $_GET['shft']; ?></strong>
        </td>
      </tr>
      <tr>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">NO MC</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">LANGGANAN / BUYER</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">NO ORDER</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">JENIS KAIN</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">WARNA</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">LOT</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">ROLL</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">QTY</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">PROSES</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">KETERANGAN</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">K.R</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">R.B/R.L</td>
        <td colspan="2" bgcolor="#99FF99">
          <div align="center">JAM PROSES</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">POINT</div>
        </td>
        <td colspan="2" bgcolor="#99FF99">
          <div align="center">STOP MESIN</div>
        </td>
        <td rowspan="2" bgcolor="#99FF99">
          <div align="center">KODE STOP</div>
        </td>
      </tr>
      <tr>
        <td bgcolor="#99FF99">
          <div align="center">IN</div>
        </td>
        <td bgcolor="#99FF99">
          <div align="center">OUT</div>
        </td>
        <td bgcolor="#99FF99">
          <div align="center">JAM</div>
        </td>
        <td bgcolor="#99FF99">
          <div align="center">S/D</div>
        </td>
      </tr>
    </thead>
    <tbody>
      <?php
      $Awal = $_GET['awal'];
      $Akhir = $_GET['akhir'];
      $Tgl = substr($Awal, 0, 10);
      if ($Awal != $Akhir) {
        // MySQL: DATE_FORMAT(c.tgl_update, '%Y-%m-%d %H:%i') BETWEEN '$Awal' AND '$Akhir'
        $Where = " CONVERT(char(16), c.tgl_update, 120) BETWEEN '$Awal' AND '$Akhir' ";
      } else {
        // MySQL: DATE_FORMAT(c.tgl_update, '%Y-%m-%d')='$Tgl'
        $Where = " CONVERT(date, c.tgl_update) = CONVERT(date, '$Tgl') ";
      }
      if ($_GET['shft'] == "ALL") {
        $shft = " ";
      } else {
        // MySQL: if(ISNULL(a.g_shift),c.g_shift,a.g_shift)='$_GET[shft]' AND
        $shft = " COALESCE(a.g_shift, c.g_shift) = '$_GET[shft]' AND ";
      }
      $sql = sqlsrv_query($con, "SELECT x.*, a.no_mesin AS mc FROM db_dying.tbl_mesin a
  LEFT JOIN
  (
    SELECT
  b.nokk,
	b.buyer,
	b.langganan,
	b.no_order,
	b.jenis_kain,
	b.no_mesin,
	b.warna,
	b.lot,
	c.rol,
	c.bruto,
      COALESCE(a.point, b.target) AS point,
	b.ket_status,
	b.resep,
      c.tgl_buat AS tgl_in,
      a.tgl_buat AS tgl_out,
	a.kd_stop,
	a.mulai_stop,
	a.selesai_stop,
	a.ket,
	a.status,
	a.k_resep,
      CASE 
        WHEN a.proses = '' OR a.proses IS NULL THEN b.proses
        ELSE a.proses
      END AS proses,
      COALESCE(a.g_shift, c.g_shift) AS shft
FROM
      db_dying.tbl_schedule b
      LEFT JOIN db_dying.tbl_montemp c ON c.id_schedule = b.id
      LEFT JOIN db_dying.tbl_hasilcelup a ON a.id_montemp = c.id
WHERE
	$shft 
	$Where 
  ) x ON (a.no_mesin = x.no_mesin OR a.no_mc_lama = x.no_mesin)
  ORDER BY a.no_mesin");
  
      $no = 1;

      $c = 0;
      $totrol = 0;
      $totberat = 0;

      if ($sql === false) {
        $err = sqlsrv_errors();
        $msg = $err ? $err[0]['message'] : 'Gagal mengambil data produksi.';
        echo '<tr><td colspan=\"18\">Error SQL: ' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</td></tr>';
      } else {
      while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        if ($_GET['shft'] == "ALL") {
          $shftSM = " ";
        } else {
          $shftSM = " g_shift='$_GET[shft]' AND ";
        }
        $sqlSM = sqlsrv_query($con, "SELECT TOP 1 * FROM db_dying.tbl_stopmesin
      WHERE $shftSM tgl_update BETWEEN '$_GET[awal]' AND '$_GET[akhir]' AND no_mesin = '" . $rowd['mc'] . "' ORDER BY id DESC");




      
        $rowSM = $sqlSM !== false ? sqlsrv_fetch_array($sqlSM, SQLSRV_FETCH_ASSOC) : null;
      ?>
        <tr valign="top">
          <td>
            <div align="center"> <?php echo $rowd['mc']; ?></div>
          </td>
          <td><?php echo $rowd['langganan'] . "/" . $rowd['buyer']; ?></td>
          <td><?php echo $rowd['no_order']; ?></td>
          <td><?php echo $rowd['jenis_kain']; ?></td>
          <td><?php echo $rowd['warna']; ?></td>
          <td>
            <div align="center"><?php echo $rowd['lot']; ?></div>
          </td>
          <td>
            <div align="center"><?php if ($rowd['tgl_out'] != "") {
                                  $rol = $rowd['rol'];
                                } else {
                                  $rol = 0;
                                }
                                echo $rol; ?></div>
          </td>
          <td>
            <div align="right"><?php if ($rowd['tgl_out'] != "") {
                                  $brt = $rowd['bruto'];
                                } else {
                                  $brt = 0;
                                }
                                echo $brt; ?></div>
          </td>
          <td><?php if ($rowd['nokk'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
                echo $rowSM['proses'];
              } else {
                echo $rowd['proses'];
              } ?></td>
          <td><?php if ($rowd['nokk'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
                echo $rowSM['keterangan'] . "<br>" . $rowSM['no_stop'];
              } else {
                echo $rowd['ket'] . "<br>" . $rowd['status'];
              } ?></td>
          <td><?php echo $rowd['k_resep']; ?></td>
          <td>
            <div align="center"><?php if ($rowd['ket_status'] == "") {
                                  echo "";
                                } else if ($rowd['ket_status'] != "MC Stop") {
                                  if ($rowd['resep'] == "Baru") {
                                    echo "R.B";
                                  } else {
                                    echo "R.L";
                                  }
                                } ?></div>
          </td>
          <td>
            <div align="right"><?php echo format_time_sqlsrv($rowd['tgl_in']); ?> </div>
          </td>
          <td>
            <div align="right"><?php echo format_time_sqlsrv($rowd['tgl_out']); ?> </div>
          </td>
          <td>
            <div align="center"><?php echo ($rowd['point'] !== null && $rowd['point'] !== '') ? number_format($rowd['point'], 2, '.', '') : ''; ?></div>
          </td>
          <td>
            <div align="right"><?php
              if ($rowd['nokk'] == "" && substr($rowd['proses'], 0, 10) != "Cuci Mesin" && $rowSM && $rowSM['proses'] == "Stop") {
                echo format_time_sqlsrv($rowSM['mulai']);
                                } else {
                                  echo "";
                                } ?></div>
          </td>
          <td>
            <div align="right"><?php
              if ($rowd['nokk'] == "" && substr($rowd['proses'], 0, 10) != "Cuci Mesin" && $rowSM && $rowSM['proses'] == "Stop") {
                echo format_time_sqlsrv($rowSM['selesai']);
                                } else {
                                  echo "";
                                } ?></div>
          </td>
          <td>
            <div align="center"><?php if ($rowd['nokk'] == "" and substr($rowd['proses'], 0, 10) != "Cuci Mesin") {
                                  echo $rowSM['kd_stopmc'];
                                } else {
                                  echo $rowd['kd_stop'];
                                } ?> <?php ?></div>
          </td>
        </tr>
      <?php
        $totrol += $rol;
        $totberat += $brt;
        $no++;
      }
      } ?>
    </tbody>
    <tr>
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
      <td bgcolor="#99FF99">Total</td>
      <td bgcolor="#99FF99">&nbsp;</td>
      <td bgcolor="#99FF99">
        <div align="right"><?php echo $totrol; ?></div>
      </td>
      <td bgcolor="#99FF99">
        <div align="right"><?php echo $totberat; ?></div>
      </td>
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
  </table>
  <table width="100%" border="0" class="table-list1">
    <tr>
      <td width="15%">&nbsp;</td>
      <td width="31%">
        <div align="center">DIBUAT OLEH:</div>
      </td>
      <td width="27%">
        <div align="center">DIPERIKSA OLEH:</div>
      </td>
      <td width="27%">
        <div align="center">DIKETAHUI OLEH:</div>
      </td>
    </tr>
    <tr>
      <td>NAMA</td>
      <td>
        <div align="center">
          <input name=nama type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
      <td>
        <div align="center">
          <input name=nama3 type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
      <td>
        <div align="center">
          <input name=nama5 type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
    </tr>
    <tr>
      <td>JABATAN</td>
      <td>
        <div align="center">
          <input name=nama2 type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
      <td>
        <div align="center">
          <input name=nama4 type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
      <td>
        <div align="center">
          <input name=nama6 type=text placeholder="Ketik disini" size="33" maxlength="30">
        </div>
      </td>
    </tr>
    <tr>
      <td>TANGGAL</td>
      <td>
        <div align="center">
          <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
        </div>
      </td>
      <td>
        <div align="center">
          <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
        </div>
      </td>
      <td>
        <div align="center">
          <input type="text" name="date" placeholder="dd-mm-yyyy" onKeyUp="
  var date = this.value;
  if (date.match(/^\d{2}$/) !== null) {
     this.value = date + '-';
  } else if (date.match(/^\d{2}\-\d{2}$/) !== null) {
     this.value = date + '-';
  }" maxlength="10">
        </div>
      </td>
    </tr>
    <tr>
      <td height="60" valign="top">TANDA TANGAN</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

</body>

</html>