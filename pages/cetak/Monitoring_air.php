<?php

ini_set("error_reporting", 1);
include "../../koneksi.php";
include "../../koneksiLAB.php";
include "../../tgl_indo.php";
// Monitoring_air.php - Form cetak ukuran F4 (210mm x 330mm)

function q(string $key, string $default = ''): string {
  return htmlspecialchars($_GET[$key] ?? $default, ENT_QUOTES, 'UTF-8');
}

// Kolom kiri
$no_mesin  = q('idm');
$no_demand = q('nodemand');
$no_prod   = q('idkk');


$data = mysqli_query($con, "SELECT
                                        *,
                                         b.buyer,
                                        b.no_order,
                                        b.warna,
                                        b.nokk,
	                                    b.nodemand,
                                        a.tgl_update,
                                        a.id AS idm,
                                        b.id AS ids,
                                        c.id AS idstm,
                                        a.g_shift AS sft, 
                                        a.l_r ,
                                        a.l_r_2,
                                        b.rol,
                                        b.bruto,
                                        a.waktu_tunggu,
                                        a.tgl_buat, 
                                        b.loading,
                                        b.no_mesin,
                                        b.no_hanger,
                                        c.no_item,
                                        b.jenis_kain,
                                        b.lot,
                                        b.kapasitas
                                    FROM
                                        db_dying.tbl_montemp a
                                        LEFT JOIN db_dying.tbl_schedule b ON a.id_schedule = b.id
                                        LEFT JOIN db_dying.tbl_setting_mesin c ON b.nokk = c.nokk
                                        LEFT JOIN db_dying.tbl_bakbul d ON c.nokk = d.no_kk
                                    WHERE
                                        ( a.`status` = 'antri mesin' OR a.`status` = 'sedang jalan' ) 
                                        AND ( b.`status` = 'antri mesin' OR b.`status` = 'sedang jalan' ) 
                                        and a.nokk = '$no_prod' and a.nodemand ='$no_demand' and a.id = '$no_mesin'
                                    ORDER BY
                                        a.id ASC");
$rowd = mysqli_fetch_array($data)

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FORM PENGISIAN AIR PROSES DYEING</title>
  <style>
    /* =========================
       SETTING UKURAN KERTAS F4
       F4/Folio umum: 210mm x 330mm
       ========================= */
    @page {
      size: 210mm 330mm;
      margin: 10mm;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica, sans-serif;
      color: #000;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* Tampilan layar (preview) */
    body {
      background: #f2f2f2;
    }

   .toolbar{
      position: fixed;
      top: 10px;
      right: 10px;  
      left: auto;   
      z-index: 999;
    }

    .btn {
      appearance: none;
      border: 0;
      background: #111;
      color: #fff;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
    }

    .page {
      width: 210mm;
      min-height: 330mm;
      margin: 12px auto;
      background: #fff;
      box-shadow: 0 2px 14px rgba(0,0,0,.12);
      box-sizing: border-box;
      padding: 10mm;
    }

    h1 {
      font-size: 16px;
      letter-spacing: .4px;
      text-align: center;
      margin: 0 0 10mm 0;
      font-weight: 700;
    }

    .top-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10mm;
      margin-bottom: 8mm;
    }

    .field-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }

   .field-table{
  table-layout: fixed;
  }

  .field-table td{
    padding: 2px 0;
    vertical-align: top; 
  }

  .field-label{
    width: 38mm;
    font-weight: 600;
    white-space: nowrap;
  }

  .field-value{
    border-bottom: 1px solid #000;
    padding: 0 0 2px 6px;
    font-weight: 400;
    line-height: 1.2;
    min-height: 16px;

    white-space: normal;
    word-break: break-word;
    overflow-wrap: anywhere;
  }
      .field-colon {
      width: 4mm;
      text-align: center;
    }


    .main-table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      font-size: 12px;
      margin-top: 2mm;
    }

    .main-table th, .main-table td {
      border: 1px solid #000;
      padding: 2px 3px;
    }

    .main-table th {
      text-align: center;
      font-weight: 700;
    }

    .main-table{
      width: 100%;
      max-width: 100%;
      table-layout: fixed;
    }

    .col-no     { width: 6%;  text-align:center; }
    .col-proses { width: 22%; }
    .col-air    { width: 22%; }

    .rowline td { height: 18px; }

    .footer {
      margin-top: 10mm;
      font-size: 12px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15mm;
      margin-bottom: 6mm;
    }

    .foot-field {
      display: grid;
      grid-template-columns: 32mm 4mm 1fr;
      align-items: end;
      column-gap: 2mm;
    }

    .foot-label { font-weight: 600; white-space: nowrap; }
    .foot-colon { text-align: center; }
    .foot-line {
      border-bottom: 1px solid #000;
      height: 16px;
    }

    .keterangan {
      display: grid;
      grid-template-columns: 32mm 1fr;
      column-gap: 2mm;
      align-items: start;
    }

    .keterangan .keterangan-label {
      font-weight: 600;
    }

    .keterangan .keterangan-line {
      border-bottom: 1px solid #000;
      height: 18px;
      margin-top: 10px;
    }

    /* Saat print: hilangkan background, shadow, tombol; pakai area @page */
    @media print {
      body { background: #fff; }
      .toolbar { display: none !important; }
      .page {
        width: auto;
        min-height: auto;
        margin: 0;
        box-shadow: none;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="toolbar">
    <button class="btn" onclick="window.print()">Print</button>
  </div>

  <div class="page">
    <h1>FORM PENGISIAN AIR PROSES DYEING</h1>

    <div class="top-grid">
      <table class="field-table">
        <tr>
          <td class="field-label">No Mesin / Kapasitas</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['idm']; ?> / <?php echo $rowd['kapasitas']; ?></td>
        </tr>
        <tr>
          <td class="field-label">No. Demand</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['nodemand']; ?></td>
        </tr>
        <tr>
          <td class="field-label">No. Prod. Order</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['nokk'] ?></td>
        </tr>
         <tr>
            <td class="field-label">Item / Jenis kain</td>
            <td class="field-colon">:</td>
            <td class="field-value"><?php echo $rowd['no_item']; ?> / <?php echo $rowd['jenis_kain']; ?></td>
        </tr>
        <tr>
          <td class="field-label">Warna</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['warna']; ?></td>
        </tr>
        <tr>
          <td class="field-label">Lot</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo  $rowd['lot']; ?></td>
        </tr>
      </table>

      <table class="field-table">
        <tr>
          <td class="field-label">Tanggal Proses</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['tgl_buat']; ?></td>
        </tr>
        <tr>
          <td class="field-label">Roll × Qty</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['rol']; ?> x <?php echo $rowd['bruto']; ?></td>
        </tr>
        <tr>
          <td class="field-label">Loading</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['loading']; ?></td>
        </tr>
        <tr>
          <td class="field-label">LR Poly</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['l_r']; ?></td>
        </tr>
        <tr>
          <td class="field-label">LR Cotton</td>
          <td class="field-colon">:</td>
          <td class="field-value"><?php echo $rowd['l_r_2']; ; ?></td>
        </tr>
      </table>
    </div>

    <table class="main-table">
      <tr>
        <th class="col-no">No.</th>
        <th class="col-proses">Proses</th>
        <th class="col-air">Pemakaian Air (liter)</th>
        <th class="col-no">No.</th>
        <th class="col-proses">Proses</th>
        <th class="col-air">Pemakaian Air (liter)</th>
      </tr>
      <?php
        for ($i = 1; $i <= 15; $i++) {
          $j = $i + 15;
          echo "<tr class='rowline'>";
          echo "<td class='col-no'>".$i."</td>";
          echo "<td class='col-proses'></td>";
          echo "<td class='col-air'></td>";
          echo "<td class='col-no'>".$j."</td>";
          echo "<td class='col-proses'></td>";
          echo "<td class='col-air'></td>";
          echo "</tr>";
        }
      ?>
    </table>

    <div class="footer">
      <div class="footer-grid">
        <div class="foot-field">
          <div class="foot-label">Flowmeter Awal</div>
          <div class="foot-colon">:</div>
          <div class="foot-line"></div>
        </div>

        <div class="foot-field">
          <div class="foot-label">Flowmeter Akhir</div>
          <div class="foot-colon">:</div>
          <div class="foot-line"></div>
        </div>
      </div>

      <div class="keterangan">
        <div class="keterangan-label">Keterangan:</div>
        <div class="keterangan-line"></div>
      </div>
    </div>

  </div>
</body>
</html>
