<?php
    mysql_connect("10.0.0.10", "dit", "4dm1n");
    mysql_select_db("dbknitt")or die("Gagal Koneksi");
?>

<html>

  <head>
    <title>:: Cetak Jadwal Preventif Mesin</title>
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
    <?php $qrytgl=mysql_query("SELECT DATE_FORMAT(now(),'%d %M %Y %H:%i') as tgl"); $r2=mysql_fetch_array($qrytgl); ?>
    <table width="100%" border="0" class="table-list1">
      <thead>
        <tr valign="top">
          <td colspan="11">
            <table width="100%" border="0" class="table-list1">
              <thead>
                <tr>
                  <td width="6%" rowspan="4"><img src="../../dist/img/Indo.jpg" alt="" width="60" height="60"></td>
                  <td width="75%" rowspan="4">
                    <div align="center">
                      <h2>JADWAL PREVENTIF MESIN</h2>
                    </div>
                  </td>
                  <td width="8%">No. Formulir</td>
                  <td width="11%">: FW-14-KNT-25</td>
                </tr>
                <tr>
                  <td>No. Revisi</td>
                  <td>: 01</td>
                </tr>
                <tr>
                  <td>Tgl. Terbit</td>
                  <td>: </td>
                </tr>
                <tr>
                  <td>Halaman</td>
                  <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /</td>
                </tr>
                <thead>
            </table>
          </td>
        </tr>
        <tr valign="top">
          <td colspan="11" style="border-left: 0px #000000 solid; border-right: 0px #000000 solid;">Tanggal :
            <?php echo $r2[tgl];?>
          </td>
        </tr>
        <tr>
          <td width="2%" rowspan="2" align="center">No.</td>
          <td width="5%" rowspan="2" align="center">No Mesin</td>
          <td width="6%" rowspan="2" align="center">Produksi (KG)</td>
          <td width="11%" rowspan="2" align="center">Status</td>
          <td colspan="3" align="center">Preventive *)</td>
          <td width="28%" rowspan="2" align="center">Keterangan</td>
          <td width="9%" rowspan="2" align="center">Tgl Selesai Service</td>
          <td width="11%" rowspan="2" align="center">Mekanik</td>
          <td width="7%" rowspan="2" align="center">Tanda Terima Form</td>
        </tr>
        <tr>
          <td width="7%" align="center">Over Houl</td>
          <td width="7%" align="center">Ringan</td>
          <td width="7%" align="center">Hold</td>
        </tr>
      </thead>
      <tbody>
        <?php
  $sql=mysql_query(" SELECT
	a.no_mesin,a.batas_produksi,sum(b.berat_awal) as `KGS`
FROM
	tbl_mesin a
INNER JOIN tbl_inspeksi_detail b ON a.no_mesin=b.no_mc
GROUP BY
	a.no_mesin
ORDER BY
	a.no_mesin ASC ");
  while ($r=mysql_fetch_array($sql)) {
      $sql1=mysql_query(" SELECT sum(kg_awal) as kg_awal,sts FROM tbl_jadwal  WHERE no_mesin='$r[no_mesin]' ORDER BY id DESC LIMIT 1 ");
      $r1=mysql_fetch_array($sql1);
      $total=$r['KGS']-$r1['kg_awal'];
      if ($total > $r[batas_produksi] or $r1[sts]=="Hold") {
          $no++; ?>
        <tr valign="top">
          <td align="center">
            <?php echo $no."."; ?>
          </td>
          <td align="center">
            <?php echo $r[no_mesin]; ?>
          </td>
          <td align="right">
            <?php echo $total; ?>
          </td>
          <td align="center">
            <?php if ($r1[sts]=="Hold") {
              echo Hold;
          } else {
              echo "Berkala";
          } ?>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <?php
      } ?>
        <?php
  } ?>
        <tr valign="top">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>

      </tbody>
    </table>
    <pre>Keterangan : *) Beri tanda tickmark (&#10004;) sesuai dengan aktual
                           Apabila preventive dihold, maka keterangan harus diisi</pre>
    <table width="100%" border="0" class="table-list1">
      <tr>
        <td width="15%">&nbsp;</td>
        <td width="31%">
          <div align="center">Dibuat Oleh</div>
        </td>
        <td width="27%">
          <div align="center">Disetujui Oleh</div>
        </td>
        <td width="27%">
          <div align="center">Diketahui Oleh</div>
        </td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="60" valign="top">Tanda Tangan</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

  </body>

</html>
