<?php
    include_once "koneksi.php";
    $_noprod    = $_GET['noprod'];
    $sql_schedule = "SELECT
                            *
                        FROM 
                            tbl_schedule 
                        WHERE 
                            nokk = '$_noprod'";
    $query_schedule  = mysqli_query($con, $sql_schedule);
    $dt_schedule     = mysqli_fetch_array($query_schedule);

    $db_productiondemand = db2_exec($conn1, "SELECT * FROM PRODUCTIONDEMAND WHERE CODE = '$dt_schedule[nodemand]'");
    $r_productiondemand = db2_fetch_assoc($db_productiondemand);

    $groupline = substr($dt_schedule['no_resep'], 9);
    $_noprod_   = sprintf("%08d", $_noprod);

    $db_viewreservation = db2_exec($conn1, "SELECT * FROM VIEWPRODUCTIONRESERVATION WHERE PRODUCTIONORDERCODE = '$_noprod_' AND GROUPLINE = '$groupline'");
    $r_viewreservation = db2_fetch_assoc($db_viewreservation);
    
    $pemakaian_air  = $r_viewreservation['PICKUPQUANTITY'] * $dt_schedule['qty_order'];

    $sqlCekWaktu = mysqli_query($con, "SELECT th.operator_keluar, th.tgl_buat as jam_stop ,now() as jam_start
											FROM tbl_hasilcelup th 
											INNER JOIN tbl_montemp tm on th.id_montemp =tm.id
											INNER JOIN tbl_schedule ts on tm.id_schedule =ts.id
											WHERE ts.no_mesin ='" . $dt_schedule['no_mesin'] . "'
											ORDER BY th.id DESC LIMIT 1");
	$rcekW = mysqli_fetch_array($sqlCekWaktu);

	$awalP  = strtotime($rcekW['jam_stop']);
	$akhirP = strtotime($rcekW['jam_start']);
    
	$diffP  = ($akhirP - $awalP);
	$tjamP  = round($diffP / (60 * 60), 2);

    $sqlCekMc = mysqli_query($con, "SELECT no_mesin, kode, waktu_tunggu,wt_des, ket FROM db_dying.tbl_mesin WHERE no_mesin='" . $dt_schedule['no_mesin'] . "'");
	$rCekMc = mysqli_fetch_array($sqlCekMc);

    $sqlcek2 = mysqli_query($con, "SELECT
										id,
										if(COUNT(lot)>1,'Gabung Kartu','') as ket_kartu,
										if(COUNT(lot)>1,CONCAT('(',COUNT(lot),'kk',')'),'') as kk,
										GROUP_CONCAT(nodemand SEPARATOR ', ') as g_kk,
										no_mesin,
										no_urut,	
										sum(rol) as rol,
										sum(bruto) as bruto
									FROM
										tbl_schedule 
									WHERE
										NOT `status` = 'selesai' and no_mesin='" . $dt_schedule['no_mesin'] . "' and no_urut='" . $dt_schedule['no_urut'] . "'
									GROUP BY
										no_mesin,
										no_urut 
									ORDER BY
										id ASC");
	$cek2 = mysqli_num_rows($sqlcek2);
	$rcek2 = mysqli_fetch_array($sqlcek2);
	if ($rcek2['ket_kartu'] != "") {
		$ketsts = $rcek2['ket_kartu'] . "\n(" . $rcek2['g_kk'] . ")";
	} else {
		$ketsts = "";
	}

    // BENANG
        $sql_jbenang = db2_exec($conn1, "SELECT 
                                        CASE
                                            WHEN RESERVATIONLINE = '1' THEN 
                                                CASE
                                                    WHEN COMMENTTEXT ISNULL THEN 
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2) 
                                                        || ' (suplayer not found), '
                                                    ELSE
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2) || ')'
                                                END	
                                            WHEN RESERVATIONLINE = '1,2' THEN 
                                                CASE
                                                    WHEN COMMENTTEXT ISNULL THEN 
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                        || ' (suplayer not found), ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2) 
                                                        || ' (suplayer not found) '
                                                    ELSE
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2, LOCATE('2:', COMMENTTEXT)-4) || '), ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('2:', COMMENTTEXT)+2) || ')'
                                                END				
                                            WHEN RESERVATIONLINE = '1,2,3' THEN 
                                                CASE
                                                    WHEN COMMENTTEXT ISNULL THEN 
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                        || '  (suplayer not found),  ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2, LOCATE('3:', SUMMARIZEDDESCRIPTION)-LOCATE('2:', SUMMARIZEDDESCRIPTION)-3) 
                                                        || '  (suplayer not found),  ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('3:', SUMMARIZEDDESCRIPTION)+2)
                                                        || '  (suplayer not found) '
                                                    ELSE
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2, LOCATE('2:', COMMENTTEXT)-4) || '), ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2, LOCATE('3:', SUMMARIZEDDESCRIPTION)-LOCATE('2:', SUMMARIZEDDESCRIPTION)-3) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('2:', COMMENTTEXT)+2, LOCATE('3:', COMMENTTEXT)-LOCATE('2:', COMMENTTEXT)-3) || '), ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('3:', SUMMARIZEDDESCRIPTION)+2)
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('3:', COMMENTTEXT)+2) || ')'
                                                END
                                            WHEN RESERVATIONLINE = '1,2,3,4' THEN 
                                                CASE
                                                    WHEN COMMENTTEXT ISNULL THEN 
                                                        ''
                                                    ELSE
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2, LOCATE('2:', COMMENTTEXT)-4) || '), ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2, LOCATE('3:', SUMMARIZEDDESCRIPTION)-LOCATE('2:', SUMMARIZEDDESCRIPTION)-3) 
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('2:', COMMENTTEXT)+2, LOCATE('3:', COMMENTTEXT)-LOCATE('2:', COMMENTTEXT)-3) || '), ' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('3:', SUMMARIZEDDESCRIPTION)+2, LOCATE('4:', SUMMARIZEDDESCRIPTION)-LOCATE('3:', SUMMARIZEDDESCRIPTION)-3)
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('3:', COMMENTTEXT)+2,  LOCATE('4:', COMMENTTEXT)-LOCATE('3:', COMMENTTEXT)-3) || ')' ||
                                                        SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('4:', SUMMARIZEDDESCRIPTION)+2)
                                                        || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('4:', COMMENTTEXT)+2) || ')'
                                                END
                                        END AS JENIS_BENANG
                                        FROM ITXVIEWJENISBENANGRMP WHERE ORIGDLVSALORDLINESALORDERCODE = '$r_productiondemand[ORIGDLVSALORDLINESALORDERCODE]' 
                                                                AND SUBCODE01 = '$r_productiondemand[SUBCODE01]'
                                                                AND SUBCODE02 = '$r_productiondemand[SUBCODE02]'
                                                                AND SUBCODE03 = '$r_productiondemand[SUBCODE03]'
                                                                AND SUBCODE04 = '$r_productiondemand[SUBCODE04]'");
        $r_jbenang = db2_fetch_assoc($sql_jbenang);

        if(!empty($r_jbenang['JENIS_BENANG'])){
            $d_benang = $r_jbenang['JENIS_BENANG'];
        }else{
            $sql_jbenang2 = db2_exec($conn1, "SELECT 
                                                CASE
                                                    WHEN RESERVATIONLINE = '1' THEN 
                                                        CASE
                                                            WHEN COMMENTTEXT ISNULL THEN 
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2) 
                                                                || ' (suplayer not found), '
                                                            ELSE
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2) || ')'
                                                        END	
                                                    WHEN RESERVATIONLINE = '1,2' THEN 
                                                        CASE
                                                            WHEN COMMENTTEXT ISNULL THEN 
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                                || ' (suplayer not found), ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2) 
                                                                || ' (suplayer not found) '
                                                            ELSE
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2, LOCATE('2:', COMMENTTEXT)-4) || '), ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('2:', COMMENTTEXT)+2) || ')'
                                                        END				
                                                    WHEN RESERVATIONLINE = '1,2,3' THEN 
                                                        CASE
                                                            WHEN COMMENTTEXT ISNULL THEN 
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                                || '  (suplayer not found),  ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2, LOCATE('3:', SUMMARIZEDDESCRIPTION)-LOCATE('2:', SUMMARIZEDDESCRIPTION)-3) 
                                                                || '  (suplayer not found),  ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('3:', SUMMARIZEDDESCRIPTION)+2)
                                                                || '  (suplayer not found) '
                                                            ELSE
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2, LOCATE('2:', COMMENTTEXT)-4) || '), ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2, LOCATE('3:', SUMMARIZEDDESCRIPTION)-LOCATE('2:', SUMMARIZEDDESCRIPTION)-3) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('2:', COMMENTTEXT)+2, LOCATE('3:', COMMENTTEXT)-LOCATE('2:', COMMENTTEXT)-3) || '), ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('3:', SUMMARIZEDDESCRIPTION)+2)
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('3:', COMMENTTEXT)+2) || ')'
                                                        END
                                                    WHEN RESERVATIONLINE = '1,2,3,4' THEN 
                                                        CASE
                                                            WHEN COMMENTTEXT ISNULL THEN 
                                                                ''
                                                            ELSE
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('1:', SUMMARIZEDDESCRIPTION)+2, LOCATE('2:', SUMMARIZEDDESCRIPTION)-4) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('1:', COMMENTTEXT)+2, LOCATE('2:', COMMENTTEXT)-4) || '), ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('2:', SUMMARIZEDDESCRIPTION)+2, LOCATE('3:', SUMMARIZEDDESCRIPTION)-LOCATE('2:', SUMMARIZEDDESCRIPTION)-3) 
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('2:', COMMENTTEXT)+2, LOCATE('3:', COMMENTTEXT)-LOCATE('2:', COMMENTTEXT)-3) || '), ' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('3:', SUMMARIZEDDESCRIPTION)+2, LOCATE('4:', SUMMARIZEDDESCRIPTION)-LOCATE('3:', SUMMARIZEDDESCRIPTION)-3)
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('3:', COMMENTTEXT)+2,  LOCATE('4:', COMMENTTEXT)-LOCATE('3:', COMMENTTEXT)-3) || ')' ||
                                                                SUBSTR(SUMMARIZEDDESCRIPTION, LOCATE('4:', SUMMARIZEDDESCRIPTION)+2)
                                                                || ' (' || 	SUBSTR(COMMENTTEXT, LOCATE('4:', COMMENTTEXT)+2) || ')'
                                                        END
                                                END AS JENIS_BENANG
                                                FROM ITXVIEWJENISBENANGRMP 
                                                WHERE ORIGDLVSALORDLINESALORDERCODE = '$r_productiondemand[INTERNALREFERENCE]' 
                                                                                AND SUBCODE01 = '$r_productiondemand[SUBCODE01]'
                                                                                AND SUBCODE02 = '$r_productiondemand[SUBCODE02]'
                                                                                AND SUBCODE03 = '$r_productiondemand[SUBCODE03]'
                                                                                AND SUBCODE04 = '$r_productiondemand[SUBCODE04]'");
            $r_jbenang2 = db2_fetch_assoc($sql_jbenang2);

            if(!empty($r_jbenang2['JENIS_BENANG'])){
                $d_benang = $r_jbenang2['JENIS_BENANG'];
            }else{
                $d_benang = '';
            }
        }
    // BENANG

    // STANDART COCOK WARNA
        $db_stdcckwarna = db2_exec($conn1, "SELECT 
                                                CASE
                                                    WHEN ic.VALUESTRING = '1' THEN 'Labdip - ' || ic2.VALUESTRING
                                                    WHEN ic.VALUESTRING = '2' THEN 'First Lot - ' || ic2.VALUESTRING
                                                    WHEN ic.VALUESTRING = '3' THEN 'Original - ' || ic2.VALUESTRING
                                                    WHEN ic.VALUESTRING = '4' THEN 'Previous Order - ' || ic2.VALUESTRING
                                                    WHEN ic.VALUESTRING = '5' THEN 'Master Color - ' || ic2.VALUESTRING
                                                    WHEN ic.VALUESTRING = '6' THEN 'Lampiran Buyer - ' || ic2.VALUESTRING
                                                    WHEN ic.VALUESTRING = '7' THEN 'Body - ' || ic2.VALUESTRING
                                                END AS STANDART_COCOK_WARNA
                                            FROM 
                                                SALESORDERLINE s 
                                            LEFT JOIN ITXVIEW_COLORSTANDARD ic ON ic.UNIQUEID = s.ABSUNIQUEID 
                                            LEFT JOIN ITXVIEW_COLORREMARKS ic2 ON ic2.UNIQUEID = s.ABSUNIQUEID 
                                            WHERE 
                                                s.SALESORDERCODE = '$r_productiondemand[ORIGDLVSALORDLINESALORDERCODE]' AND ORDERLINE = '$r_productiondemand[ORIGDLVSALORDERLINEORDERLINE]'");
        $r_stdcckwarna  = db2_fetch_assoc($db_stdcckwarna);
    // STANDART COCOK WARNA

    // CARRY OVER
        $query_br1       = db2_exec($conn1, "SELECT
                                                TRIM(SUBCODE01) AS SUBCODE01,
                                                TRIM(SUFFIXCODE) AS SUFFIXCODE
                                            FROM
                                                PRODUCTIONRESERVATION PRODUCTIONRESERVATION 
                                            WHERE
                                                PRODUCTIONRESERVATION.ITEMTYPEAFICODE = 'RFD' 
                                                AND PRODUCTIONRESERVATION.PRODUCTIONORDERCODE = '$_noprod_' 
                                            ORDER BY
                                                PRODUCTIONRESERVATION.GROUPLINE ASC 
                                                LIMIT 1");
        $row_br1        = db2_fetch_assoc($query_br1);

        $query_carryover    = db2_exec($conn1, "SELECT 
                                                    a.VALUEDECIMAL AS carryover
                                                FROM 
                                                    RECIPE r 
                                                LEFT JOIN ADSTORAGE a ON a.UNIQUEID = r.ABSUNIQUEID AND a.NAMENAME = 'CarryOver'
                                                WHERE r.SUBCODE01 = '$row_br1[SUBCODE01]' AND r.SUFFIXCODE = '$row_br1[SUFFIXCODE]'");
        $row_carryover      = db2_fetch_assoc($query_carryover);
    // CARRY OVER


    //Menampung data yang dihasilkan
    $json = array(
        'ID'                    => $dt_schedule['id'],
        'PRODUCTIONORDERCODE'   => $dt_schedule['nokk'],
        'DEAMAND'               => $dt_schedule['nodemand'],
        'LANGGANAN'             => $dt_schedule['langganan'],
        'BUYER'                 => $dt_schedule['buyer'],
        'ORDER'                 => $dt_schedule['no_order'],
        'PO'                    => $dt_schedule['po'],
        'HANGER'                => $dt_schedule['no_hanger'],
        'ITEM'                  => $dt_schedule['no_item'],
        'JENIS_KAIN'            => $dt_schedule['jenis_kain'],
        'TGL_DELIVERY'          => $dt_schedule['tgl_delivery'],
        'LEBAR_PERMINTAAN'      => $dt_schedule['lebar'],
        'GRAMASI_PERMINTAAN'    => $dt_schedule['gramasi'],
        'WARNA'                 => $dt_schedule['warna'],
        'NO_WARNA'              => $dt_schedule['no_warna'],
        'QTY_ORDER'             => $dt_schedule['qty_order'],
        'PANJANG_ORDER'         => $dt_schedule['pjng_order'],
        'SATUAN_ORDER'          => $dt_schedule['satuan_order'],
        'LOT'                   => $dt_schedule['lot'],
        'LOT_LEGACY'            => $dt_schedule['lotlgcy'],
        'ROL'                   => $dt_schedule['rol'],
        'BRUTO'                 => $dt_schedule['bruto'],
        'KAPASITAS'             => $dt_schedule['kapasitas'],
        'NO_MESIN'              => $dt_schedule['no_mesin'],
        'LOADING'               => $dt_schedule['loading'],
        'NO_RESEP'              => $dt_schedule['no_resep'],
        'SUFFIX'                => $dt_schedule['suffix'],
        'NO_RESEP2'             => $dt_schedule['no_resep2'],
        'BENANG'                => $d_benang,
        'STANDART_COCOK_WARNA'  => $r_stdcckwarna['STANDART_COCOK_WARNA'],
        'WKT'                   => $tjamP,
        'OPER_SHIFT'            => $rcekW['operator_keluar'],
        'WT_DES'                => $rCekMc['wt_des'],
        'PEMAKAIAN_AIR'         => $pemakaian_air,
        'CARRY_OVER'            => $row_carryover['carryover'],
    );
    
    //Merubah data kedalam bentuk JSON
    header('Content-Type: application/json');
    echo json_encode($json);
?>