<?php
ini_set("error_reporting", 1);
session_start();
set_time_limit(600);
include("../koneksi.php");

function resep_escape($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rCek = null;

if ($id > 0) {
    $qcek = sqlsrv_query(
        $con,
        "SELECT TOP 1 * FROM db_dying.tbl_schedule WHERE id = ?",
        array($id)
    );
    if ($qcek !== false) {
        $rCek = sqlsrv_fetch_array($qcek, SQLSRV_FETCH_ASSOC);
        @sqlsrv_free_stmt($qcek);
    }
}
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Data Resep TEST</h4>
		</div>
		<div class="modal-body">
			<?php
			if (!$rCek) {
				echo "<div class='alert alert-warning'>Data schedule tidak ditemukan.</div>";
			} else {
				$nokk = isset($rCek['nokk']) ? trim((string)$rCek['nokk']) : '';
				$noResep = isset($rCek['no_resep']) ? trim((string)$rCek['no_resep']) : '';

				$sqlc = "SELECT
							CONVERT(char(10), CreateTime, 103) AS TglBonResep,
							CONVERT(char(10), CreateTime, 108) AS JamBonResep,
							ID_NO,
							COLOR_NAME,
							PROGRAM_NAME,
							PRODUCT_LOT,
							VOLUME,
							PROGRAM_CODE,
							YARN AS NoKK,
							TOTAL_WT,
							USER25
						FROM db_dying.ticket_title
						WHERE YARN = ?";
				$paramsC = array($nokk);

				if ($noResep !== '') {
					$sqlc .= " AND ID_NO = ?";
					$paramsC[] = $noResep;
				}

				$sqlc .= " ORDER BY CreateTime DESC";
				$qryc = sqlsrv_query($con, $sqlc, $paramsC, array("Scrollable" => "static"));

				if ($qryc === false) {
					echo "<div class='alert alert-danger'>Gagal mengambil data resep (ticket_title).</div>";
				} else {
					$countdata = sqlsrv_num_rows($qryc);
					$row = ($countdata > 0) ? sqlsrv_fetch_array($qryc, SQLSRV_FETCH_ASSOC) : null;
					@sqlsrv_free_stmt($qryc);

					if ($countdata > 0 && is_array($row)) {
						echo "<table width='100%'>";
						echo "<tr><td colspan='2' align='left'>Printout : " . resep_escape($row['TglBonResep']) . " " . resep_escape($row['JamBonResep']) . "</td><td colspan='2' align='right'>Type : " . resep_escape($row['ID_NO']) . "</td></tr></table>";
						echo "<hr>";
						echo "<table>";
						echo "<tr><td width='150'>Color Name </td><td width='250'>: " . resep_escape($row['COLOR_NAME']) . "</td><td width='150'>Program Code </td><td>: " . resep_escape($row['PROGRAM_CODE']) . " </td></tr>";
						echo "<tr><td>Program Name </td><td>: " . resep_escape($row['PROGRAM_NAME']) . "</td><td width='150'>Nomor KK</td><td>: " . resep_escape($nokk) . "</td></tr>";
						echo "<tr><td>Lots </td><td>: " . resep_escape($row['PRODUCT_LOT']) . "</td><td>Total Wt (Kg)</td><td>: " . resep_escape($row['TOTAL_WT']) . "</td></tr>";
						echo "<tr><td>Volume (Litres) </td><td>: " . resep_escape($row['VOLUME']) . "</td><td>Carry Over </td><td>: " . resep_escape($row['USER25']) . " </td></tr>";
						echo "</table>";
						echo "<hr>";

						$sqlstep = "SELECT DISTINCT STEP_NO, RECIPE_CODE
									FROM db_dying.Ticket_detail
									WHERE ID_No = ?
									ORDER BY STEP_NO ASC";
						$qrystep = sqlsrv_query($con, $sqlstep, array($row['ID_NO']));

						if ($qrystep !== false) {
							while ($rowst = sqlsrv_fetch_array($qrystep, SQLSRV_FETCH_ASSOC)) {
								echo "Step " . resep_escape($rowst['STEP_NO']) . " Recipe Code: " . resep_escape($rowst['RECIPE_CODE']) . "<br>";

								$sqlisi = "SELECT ID_NO, STEP_NO, RECIPE_CODE, PRODUCT_CODE, CONC, CONCUNIT, TARGET_WT, REMARK
											FROM db_dying.Ticket_detail
											WHERE ID_No = ? AND STEP_NO = ?
											ORDER BY STEP_NO DESC";
								$qryisi = sqlsrv_query($con, $sqlisi, array($row['ID_NO'], $rowst['STEP_NO']));

								echo "<table width='80%' border='0'>";
								if ($qryisi !== false) {
									while ($rowisi = sqlsrv_fetch_array($qryisi, SQLSRV_FETCH_ASSOC)) {
										$sqlp = sqlsrv_query(
											$con,
											"SELECT TOP 1 ProductName FROM db_dying.Product WHERE ProductCode = ?",
											array($rowisi['PRODUCT_CODE'])
										);
										$qryp = ($sqlp !== false) ? sqlsrv_fetch_array($sqlp, SQLSRV_FETCH_ASSOC) : null;
										if ($sqlp !== false) {
											@sqlsrv_free_stmt($sqlp);
										}

										if ((int)$rowisi['CONCUNIT'] === 0) {
											$unit1 = "%";
											$unit2 = "g";
											$berat = $rowisi['TARGET_WT'];
										} else {
											$unit1 = "g/L";
											$unit2 = "Kg";
											$berat = number_format(((float)$rowisi['TARGET_WT']) / 1000, 3);
										}

										echo "<tr>";
										echo "<td class='normal333' width='60'><div align='left'>" . resep_escape($rowisi['PRODUCT_CODE']) . "</div></td>";
										echo "<td class='normal333' width='300'><div align='left'>" . resep_escape($qryp['ProductName'] ?? '') . "</div></td>";
										echo "<td class='normal333' width='100'><div align='right'>" . resep_escape($rowisi['CONC']) . " " . resep_escape($unit1) . "</div></td>";
										echo "<td class='normal333' width='100'><div align='right'>" . resep_escape($berat) . " " . resep_escape($unit2) . "</div></td>";
										echo "<td class='normal333' width='100'><div align='left'>" . resep_escape($rowisi['REMARK']) . "</div></td>";
										echo "</tr>";
									}
									@sqlsrv_free_stmt($qryisi);
								}
								echo "</table>";
								echo "<hr>";
							}
							@sqlsrv_free_stmt($qrystep);
						}
					} else {
						echo "<div class='alert alert-info'>Data resep tidak ditemukan untuk KK ini.</div>";
					}
				}
			}
			?>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		</div>

	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
