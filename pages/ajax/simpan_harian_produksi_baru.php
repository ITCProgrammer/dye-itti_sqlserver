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
            $sqlUpdate = "INSERT INTO tbl_log_proses 
                 SET username = ?   ,
                 user_ip = ?,
                 id_table_hasil_celup =? ,
                 proses_lama = ? ,
                 proses_baru =? ";
            $prepare=mysqli_prepare( $con, $sqlUpdate );
            mysqli_stmt_bind_param($prepare, "sssss", $username,$ip,$id,$proses_lama,$proses_baru );
            if(mysqli_stmt_execute($prepare)){    
                $prepareR = mysqli_stmt_get_result($prepare);
                $response->setSuccess(true);
                $response->addMessage("Berhasil");
                $response->send();
            }
            else {
                $response->setSuccess(false);
                $response->addMessage(mysqli_error($con));
                $response->send();
            }
        }
        else if($_POST['status']=="get_log" && $id != 0){
            $log=array();
            $prepare=mysqli_prepare( $con, "SELECT * from tbl_log_proses where id_table_hasil_celup = ? " );
            mysqli_stmt_bind_param($prepare, "s", $id );
            mysqli_stmt_execute($prepare);
            $logData = mysqli_stmt_get_result($prepare);
            while ($rowLog = mysqli_fetch_assoc($logData)) {
                $log[]=$rowLog;
            }
            $response->setSuccess(true);
            $response->setData($log);
            $response->send();
        }
        else if($_POST['status']=="update_laporan" && $id != 0){
            $updateHslClp = "UPDATE tbl_hasilcelup 
                 SET g_shift = ?   ,
                 proses = ?,
                 k_resep =? ,
                 status = ? ,
                 air_akhir =? 
                 WHERE id = ? LIMIT 1";
            $hslclp=mysqli_prepare( $con, $updateHslClp );
            mysqli_stmt_bind_param($hslclp, "ssssss", $_POST['shift'],$_POST['proses'],$_POST['k_resep'],$_POST['sts'],$_POST['air_akhir'],$id );
            if(mysqli_stmt_execute($hslclp)){
                $hslclpR = mysqli_stmt_get_result($hslclp);
                $response->addMessage("Berhasil Update Hasil Celup");
            }
            else {
                $response->addMessage("Gagal Update Hasil Celup : ".mysqli_error($con));
            }
            $updateScdl = "UPDATE tbl_schedule
                 SET buyer = ? ,
                 kategori_warna = ?,
                 resep =? 
                 WHERE id = ? LIMIT 1";
            $schdl=mysqli_prepare( $con, $updateScdl );
            mysqli_stmt_bind_param($schdl, "ssss", $_POST['buyer'],$_POST['kategori_warna'],$_POST['resep'],$_POST['idshedule'] );
            if(mysqli_stmt_execute($schdl)){
                $schdR = mysqli_stmt_get_result($schdl);
                $response->addMessage("Berhasil Update Schedule");
            }
            else {
                $response->addMessage("Gagal Update Schedule : ".mysqli_error($con));
            }
            $updateMontemp = "UPDATE tbl_montemp 
                 SET air_awal = ?   
                 WHERE id = ? LIMIT 1";
            $montemp=mysqli_prepare ( $con, $updateMontemp );
            mysqli_stmt_bind_param($montemp, "ss", $_POST['air_awal'],$_POST['idmontemp'] );
            if(mysqli_stmt_execute($montemp)){
                $montempR = mysqli_stmt_get_result($montemp);
                $response->addMessage("Berhasil Update Monitoring Tempelan");
            }
            else {
                $response->addMessage("Gagal Update Monitoring Tempelan : ".mysqli_error($con));
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
  

