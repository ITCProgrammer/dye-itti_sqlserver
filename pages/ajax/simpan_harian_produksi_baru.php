<?PHP
  ini_set("error_reporting", 1);
  session_start();
  include "../../koneksi.php";
  include('Response.php');

  $username = $_SESSION['user_id10'];
  $allowed_users = ['andri', 'luqman', 'aris.miyanta', 'rohman','dit'];
  if (isset($_SESSION['user_id10']) && in_array(strtolower($_SESSION['user_id10']), $allowed_users)) {
    $response = new Response();
    $ip=$response->get_client_ip();
    $response->setHTTPStatusCode(201);
    if (isset($_POST['status'])) {
        $id = intval($_POST['id_dt']);
        if($_POST['status']=="insert_log" && $id != 0){
            $proses_lama=$_POST['proses_lama'];
            $proses_baru=$_POST['proses_baru'];
            if($proses_lama==$proses_baru){
                $response->setSuccess(false);
                $response->addMessage("Tidak ada perubahan");
                $response->send();
            }
            $sqlUpdate = "INSERT INTO db_dying.tbl_log_proses 
                            (username, user_ip, id_table_hasil_celup, proses_lama, proses_baru)
                          VALUES (?, ?, ?, ?, ?)";
            $paramsUpdate = array($username, $ip, $id, $proses_lama, $proses_baru);
            $prepare = sqlsrv_query($con, $sqlUpdate, $paramsUpdate);
            if($prepare !== false){    
                $response->setSuccess(true);
                $response->addMessage("Berhasil");
                $response->send();
            }
            else {
                $response->setSuccess(false);
                $err = sqlsrv_errors();
                $response->addMessage($err ? $err[0]['message'] : 'Gagal insert log proses');
                $response->send();
            }
        }
        else if($_POST['status']=="get_log" && $id != 0){
            $log=array();
            $prepare = sqlsrv_query(
                $con,
                "SELECT * FROM db_dying.tbl_log_proses WHERE id_table_hasil_celup = ?",
                array($id)
            );
            if ($prepare === false) {
                $response->setSuccess(false);
                $err = sqlsrv_errors();
                $response->addMessage($err ? $err[0]['message'] : 'Gagal mengambil log proses');
                $response->send();
            }
            while ($rowLog = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $log[]=$rowLog;
            }
            $response->setSuccess(true);
            $response->setData($log);
            $response->send();
        }
        else if($_POST['status']=="update_laporan" && $id != 0){
            $updateHslClp = "UPDATE db_dying.tbl_hasilcelup 
                 SET g_shift = ?   ,
                 proses = ?,
                 k_resep =? ,
                 status = ? ,
                 air_akhir =? 
                 WHERE id = ?";
            $paramsHslclp = array(
                $_POST['shift'],
                $_POST['proses'],
                $_POST['k_resep'],
                $_POST['sts'],
                $_POST['air_akhir'],
                $id
            );
            $hslclp = sqlsrv_query($con, $updateHslClp, $paramsHslclp);
            if($hslclp !== false){
                $response->addMessage("Berhasil Update Hasil Celup");
            }
            else {
                $err = sqlsrv_errors();
                $response->addMessage("Gagal Update Hasil Celup : ".($err ? $err[0]['message'] : 'Error'));
            }
            $updateScdl = "UPDATE db_dying.tbl_schedule
                 SET buyer = ? ,
                 kategori_warna = ?,
                 resep =? 
                 WHERE id = ?";
            $paramsScdl = array(
                $_POST['buyer'],
                $_POST['kategori_warna'],
                $_POST['resep'],
                $_POST['idshedule']
            );
            $schdl = sqlsrv_query($con, $updateScdl, $paramsScdl);
            if($schdl !== false){
                $response->addMessage("Berhasil Update Schedule");
            }
            else {
                $err = sqlsrv_errors();
                $response->addMessage("Gagal Update Schedule : ".($err ? $err[0]['message'] : 'Error'));
            }
            $updateMontemp = "UPDATE db_dying.tbl_montemp 
                 SET air_awal = ?   
                 WHERE id = ?";
            $paramsMontemp = array(
                $_POST['air_awal'],
                $_POST['idmontemp']
            );
            $montemp = sqlsrv_query($con, $updateMontemp, $paramsMontemp);
            if($montemp !== false){
                $response->addMessage("Berhasil Update Monitoring Tempelan");
            }
            else {
                $err = sqlsrv_errors();
                $response->addMessage("Gagal Update Monitoring Tempelan : ".($err ? $err[0]['message'] : 'Error'));
            }

            $response->setSuccess(true);
            $response->send();
        }
        else{
            $response->setSuccess(false);
            $response->addMessage("Error Status");
            $response->send();
        }
    }
  }
  

