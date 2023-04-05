<?php namespace App\Modules\Api\Controllers;

use App\Core\BaseController;
use App\Modules\Api\Models\ApiModel;
use App\Core\BaseModel;

class ApiPublic extends BaseController
{
    private $publikModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function privacy()
    {
        return view('App\Modules\Api\Views\principles');
    }

    public function terms()
    {
        return view('App\Modules\Api\Views\privacy');
    }

    public function about()
    {
        return view('App\Modules\Api\Views\about');
    }

    public function infoVerifPenumpang(){
        return view('App\Modules\Api\Views\verifPenumpang');
    }
    public function infoVerifKeberangkatan(){
        return view('App\Modules\Api\Views\verifKeberangkatan');
    }
    public function infoVerifKendaraan(){
        return view('App\Modules\Api\Views\verifKendaraan');
    }

    public function getNipHubdat(){
        $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hubdat.dephub.go.id/ehubdat/v1/sik-pegawai?nip=198605142009121005',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTAsInVzZXJfbmFtZSI6ImRpdGplbmxhdXQiLCJleHAiOjE2ODc4NzgzOTh9.j1-4obhSgpcbUI9BsD9_5OR13K-jLTMM5Mn43I9tHWw'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

    }

    public function getTrafficCountAPI()
    {
        $url = 'http://x1.kemenhub.id/api/atms?query=%22SELECT%20DISTINCT%20a.kode_tc,%20a.jenis_tc,%20a.nama,%20a.lokasi,%20a.kabupaten_kota,%20a.provinsi,%20a.lat,%20a.long,%20max(b.motor)%20AS%20motor,%20max(b.mobil)%20AS%20mobil,%20max(b.bus_kecil)%20AS%20bus_kecil,%20max(b.truck_kecil)%20AS%20truck_kecil,%20max(b.sedang)%20AS%20sedang,%20max(b.bus_besar)%20AS%20bus_besar,%20max(b.truck_besar)%20AS%20truck_besar,%20max(b.besar)%20AS%20besar,%20max(b.speed)%20AS%20speed,%20max(b.kinerja)%20AS%20kinerja,%20max(b.timestamp)%20AS%20timestamp%20FROM%20tc%20a%20LEFT%20JOIN%20messages_log_tc_jam%20b%20ON%20a.kode_tc%20=%20b.kode_tc%20WHERE%20date(timestamp)%20=%20CURRENT_DATE%20GROUP%20BY%20a.kode_tc,%20a.jenis_tc,%20a.nama,%20a.lokasi,%20a.kabupaten_kota,%20a.provinsi,%20a.lat,%20a.long%20ORDER%20BY%20b.jam%20DESC%22';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
                'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=kg1gcejtgeljatcqgt82htl3i3',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data['log_url'] = uri_segment(0) . '/' . uri_segment(1) . '/' . uri_segment(2);
        $data['log_method'] = 'GET';
        $data['log_header'] = json_encode(array(
            'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
            'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=kg1gcejtgeljatcqgt82htl3i3',
        ));
        $data['log_param'] = $url;
        $data['log_result'] = $response;
        $data['log_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['log_user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        $this->apiModel->insertLog($data);

    }

    public function deleteTrafficCountAPI()
    {
        $this->apiModel->deleteLog();
    }

    public function getAnprLogAPI()
    {
      $url = 'http://x1.kemenhub.id/api/atms?query=%22SELECT%20kode_anpr,%20kode_gateway,%20jam,plate,%20quality,%20tipe,%20jenis_kendaraan,%20messages,%20timestamp%20FROM%20messages_log_anpr%20where%20jenis_kendaraan%20=%20\'mobil\'%20and%20plate%20!=%20\'\'%20order%20by%20id_messages%20desc%20limit%20100%22';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://x1.kemenhub.id/api/atms?query=%22SELECT%20kode_anpr,%20kode_gateway,%20jam,plate,%20quality,%20tipe,%20jenis_kendaraan,%20messages,%20timestamp%20FROM%20messages_log_anpr%20where%20jenis_kendaraan%20=%20\'mobil\'%20and%20plate%20!=%20\'\'%20order%20by%20id_messages%20desc%20limit%20100%22',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
                'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=hf6tigff09ivvk55ae30sgbidu',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $object = json_decode($response);
        

        foreach ($object->query as $key) {
            $data['kode_anpr'] = $key->kode_anpr;
            $data['kode_gateway'] = $key->kode_gateway;
            $data['jam'] = $key->jam;
            $data['plate'] = $key->plate;
            $data['quality'] = $key->quality;
            $data['tipe'] = $key->tipe;
            $data['jenis_kendaraan'] = $key->jenis_kendaraan;
            $data['timestamp'] = $key->timestamp;
            $data['log_url'] = uri_segment(0) . '/' . uri_segment(1) . '/' . uri_segment(2);
            $data['log_result'] = $response;
            $data['log_method'] = 'GET';
            $data['log_header'] = json_encode(array(
                'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
                'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=hf6tigff09ivvk55ae30sgbidu',
            ));
            $data['log_param'] = $url;
            $data['log_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['log_user_agent'] = $_SERVER['HTTP_USER_AGENT'];

            $this->apiModel->insertAnprLog($data);
        }

    }


    public function updateSeatExpired(){
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $dataBilling = $this->db->query("SELECT id as billing_id,billing_code,billing_status_payment,billing_expired_date,NOW() as date_now from t_billing_mudik where billing_expired_date < NOW() and billing_status_payment=0")->getResult();
        
        foreach($dataBilling as $key => $value){
            if($value->date_now >= $value->billing_expired_date){

                $this->db->query("update t_transaction_mudik set transaction_seat_id=NULL where billing_id='".$value->billing_id."'");


            }
            
        }

        // $datalog['status'] = "update";
        
        // $this->db->table('s_log_cron')->insert($datalog);
      
    
    }

    public function updateVerifExpired(){
        $dataBilling = $this->db->query(" SELECT id as billing_id,billing_code,billing_status_payment,DATE(billing_verif_expired_date) as date_expired,DATE(NOW()) as date_now from t_billing_mudik where DATE(billing_verif_expired_date) < DATE(NOW()) and billing_status_verif=0")->getResult();
        
        foreach($dataBilling as $key => $value){
            if($value->date_now >= $value->date_expired){

                $this->db->query("update t_transaction_mudik set 
                transaction_seat_id=NULL,
                is_verified=2,
                reject_verified_reason='Rejected by System',
                verified_by=2,
                verified_at=NOW()
                where billing_id='".$value->billing_id."'");
              

            }
            
        }
    }

    public function sendReminderNotification(){
        $datalog['status'] = "crone remainder verification mudik";
        $this->db->table('s_log_cron')->insert($datalog);

        $dataBilling = $this->db->query("SELECT a.billing_code,DATEDIFF(date(a.billing_verif_expired_date),date(now())) as count_down_date_verif,b.id as user_mobile_id,b.user_mobile_email,b.user_mobile_fcm,DATE_FORMAT(a.billing_verif_expired_date,'%d-%b-%Y') as max_verif from t_billing_mudik a
        LEFT JOIN m_user_mobile b on a.billing_user_id=b.id
        where a.billing_cancel=0 and a.billing_status_payment=1 and a.billing_status_verif=0 and b.user_mobile_is_dev=0 and date(a.billing_verif_expired_date) >= date(NOW()) and DATEDIFF(date(a.billing_verif_expired_date), date(now())) <= 5")->getResult();
        $fcmArray = [];
        $header = '⚠️ Lakukan Verifikasi Data Pemudik';
        $deskripsi = 'Silahkan lakukan verifikasi pendaftaran sebelum tanggal verifikasi berakhir';

        foreach($dataBilling as $value){
            if($value->count_down_date_verif <= 5 && $value->count_down_date_verif >= 1 ){

                array_push($fcmArray, $value->user_mobile_fcm);
                $datapost['title'] = 'H -'.$value->count_down_date_verif.' Verifikasi data diri anda';
                $datapost['body'] = 'Silahkan lakukan verifikasi pendaftaran sebelum tanggal '.$value->max_verif;
                $datapost['user_id'] = $value->user_mobile_id;
            
                $this->db->table('t_notifikasi_user')->insert($datapost);
            }
            
            if($value->count_down_date_verif == 0){
                array_push($fcmArray, $value->user_mobile_fcm);
                $datapost['title'] = 'Hari Terakhir Verifikasi data diri anda';
                $datapost['body'] = 'Silahkan lakukan verifikasi pendaftaran hari terakhir atau tiket anda akan hangus dan anda tidak bisa memesan tiket mudik gratis kembali';
                $datapost['user_id'] = $value->user_mobile_id;
            
                $this->db->table('t_notifikasi_user')->insert($datapost);
            }
        }
        
        if(!empty($dataBilling)){
            $datalog['status'] = "send notif remainder verification mudik";
            
            $this->db->table('s_log_cron')->insert($datalog);
            $this->sendBroadcastNotification($fcmArray,$header,$deskripsi);
        }

    }

    function sendNotifUser(){
        $fcmArray = [];
        
        $query = $this->db->query("SELECT id as user_mobile_id,user_mobile_email,user_mobile_fcm from m_user_mobile where is_deleted = 0 and user_mobile_is_dev=1 and user_mobile_role=1 and user_mobile_fcm is not null and user_mobile_fcm != ''")->getResult();
       
        $header = '*DEMO* H-5 Verifikasi data diri anda';
        $deskripsi = 'Silahkan lakukan verifikasi pendaftaran sebelum tanggal 16-03-2023';
        
        foreach ($query as $r) {
            array_push($fcmArray, $r->user_mobile_fcm);
            $datapost['title'] = $header;
            $datapost['body'] = $deskripsi;
            $datapost['user_id'] = $r->user_mobile_id;
        
            $this->db->table('t_notifikasi_user')->insert($datapost);
            
        }

        
        $this->sendBroadcastNotification($fcmArray,$header,$deskripsi);
    }

    function sendBroadcastNotification($fcmArray, $header, $deskripsi){
		$title = $header;
		$body = "" . $deskripsi . "";

		$datanya = array(
			'header'		=> $header,
			'deskripsi'		=> $deskripsi
		);
        $json_data = [
                        "registration_ids" => $fcmArray,
                        "notification" => [
                            "title" => $title,
                            "body" => $body,
							"sound" => "default"
                        ],
                        "data" => $datanya
                    ];

        $dataSend = json_encode($json_data);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAAzdnMDpk:APA91bHGqr46b8DXtkEnV1D_quks7zEImJwlSkDBXpt1NjMmgZgnc0K987tBlX3b8HgAppbCwkZ0RSK2HLEUVJMMcw5PozRy-rFCwuV8pwsrQg-XfCi6OlFxVt27Jr3aHB-23teNYRgl';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );

        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend);
        $responsenya = curl_exec($ch);
		//Close request
		if ($responsenya === FALSE) {
		
			die('FCM Send Error: ' . curl_error($ch));
		}
		if (!curl_errno($ch)) {
			$info = curl_getinfo($ch);
		
		}
		curl_close($ch);
    }

    public function deleteAnprLogAPI()
    {
        $this->apiModel->deleteAnprLog();
    }

    public function checkNikManifiest(){
        $data = $this->request->getPost();
        $nik = $data['nik'];

        $query = $this->db->query("SELECT a.transaction_nik as data_nik,a.transaction_booking_name as data_pemesan,d.route_name as rute_perjalanan,e.terminal_name as keberangkatan_terminal,f.terminal_name as tujuan_terminal,g.kabkota as kota_keberangkatan,h.kabkota as kota_tujuan,
        IF(c.jadwal_type = 1,'Arus Mudik','Arus Balik') as tipe_keberangkatan,CONCAT(DATE_FORMAT(b.created_at, '%d %b %Y %H:%i:%s'),' WIB') as tanggal_pendaftaran,
        CASE 
                               WHEN b.billing_status_payment = 0 THEN CONCAT('Menunggu penyelesaian Pesanan sebelum ',DATE_FORMAT(b.billing_expired_date, '%H:%i '),'• ',DATE_FORMAT(b.billing_expired_date,'%d %b %Y'))  
                               WHEN b.billing_status_payment = 1 AND b.billing_status_verif=0 AND b.billing_status_boarding = 0 THEN CONCAT('Menunggu Verifikasi Penumpang sebelum ',DATE_FORMAT(b.billing_verif_expired_date,'%d %b %Y'))
                               WHEN b.billing_status_payment = 1 AND b.billing_status_verif=1 AND b.billing_status_boarding = 0 THEN  CONCAT('Menunggu Verifikasi Keberangkatan sebelum ',DATE_FORMAT(c.jadwal_time_depart, '%H:%i '),'• ',DATE_FORMAT(c.jadwal_date_depart,'%d %b %Y'))
                               WHEN b.billing_status_payment=1 AND b.billing_status_verif=1 AND b.billing_status_boarding = 1 THEN 'Penumpang diberangkatkan'
                           END as status_pemesanan
        from t_transaction_mudik a
        left join t_billing_mudik b on a.billing_id=b.id
        left join t_jadwal_mudik c on b.billing_jadwal_id=c.id
        left join m_route d on c.jadwal_route_id=d.id
        left join m_terminal e on d.terminal_from_id=e.id
        left join m_terminal f on d.terminal_to_id=f.id
        left join m_lokabkota g on e.`idkabkota`=g.id
        left join m_lokabkota h on f.idkabkota=h.id
        where a.transaction_nik='".addslashes($nik)."' and b.billing_status_payment=1")->getResult();

        $response = [
            'status_code' => 1,
            'status_message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
            'data' => $query
        ];

        return $this->response->setJSON($response);


    }

    public function blueRFIDDailyImport() {
        date_default_timezone_set('Asia/Jakarta');

        $yesterday = date("Y-m-d", strtotime("-1 day"));

        $response =  $this->APIListBlue('ekir-pengujian', getenv('service.hubdat.blue'), 0, 5000, ["&date_start=".$yesterday."T00:00:00", "&date_end=".$yesterday."T00:00:00"]);

        $data = json_decode($response, true);

        $baseModel = new BaseModel();

        $ceilLoop = ceil($data['total'] / 5000);

        for($y = 0; $y < $ceilLoop; $y++) {
            $response1 =  $this->APIListBlue('ekir-pengujian', getenv('service.hubdat.blue'), $y * 5000, 5000, ["&date_start=".$yesterday."T00:00:00", "&date_end=".$yesterday."T00:00:00"]);
                    
            $data1 = json_decode($response1, true);

            // log
            $log_param = json_encode((object)array(
                'skip' => $y * 5000,
                'limit' => 5000,
                'sort' => 'ASC',
                'masa_berlaku_start' => $yesterday,
                'masa_berlaku_end' => $yesterday
            ));

            $this->APIBlueLog($baseModel, getenv('service.hubdat.blue'), $log_param, $response1);

            $baseModel->base_insertbatch($data1["data"], 'm_bluerfid_dev_cek');
        }
    }
    
    private function APIListBlue($service, $bearerToken, $start, $length, $filter = [], $search = "") {
        $url = "";
        if(!$filter) {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . $search;
        } else {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . $filter[0] . '' . $filter[1];
        }

        var_dump($url);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $bearerToken
            ),
         ));

        $response = curl_exec($curl);
          
        curl_close($curl);

        $curl = curl_init();

        return $response;
    }

    private function APIBlueLog($baseModel, $bearerToken, $log_param, $response) {
        $log_api = [
            "log_method" => 'get',
            "log_url" => get_current_request_url(),
            "log_token" => $bearerToken,
            "log_header" => json_encode((object)array(
                'Authorization' => $bearerToken,
            )),
            "log_param" => $log_param,
            "log_result" => $response,
            "log_ip" => get_client_ip(),
            "log_user_agent" => get_client_user_agent()
        ];

        $baseModel->log_api($log_api, $response);
    }
}
