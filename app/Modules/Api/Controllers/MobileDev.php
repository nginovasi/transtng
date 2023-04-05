<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class MobileDev extends BaseController
{
    private $apiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}

    function utf8ize($mixed)
	{
		if (is_array($mixed)) {
			foreach ($mixed as $key => $value) {
				$mixed[$key] = $this->utf8ize($value);
			}
		} elseif (is_string($mixed)) {
			return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
		}

		return $mixed;
	}


    private function genNamefile()
	{

		$micro_date = microtime();
		$date_array = explode(" ", $micro_date);
		$date = date("YmdHis", $date_array[1]);
		$datetime = str_replace(".", "", $date . $date_array[0]);
		$namafix = md5(strtolower($datetime) . mt_rand(1000, 9999));

		return $namafix;
	}

    public function getOTP()
	{
		$otp = $this->db->query("SELECT otp_status FROM s_config_otp")->getRow();

		$is_otp = $otp->otp_status;

		return $is_otp;
	}

    public function configAbsen($id_petugas){
        $config = $this->db->query("SELECT absensi_status from s_config_absensi")->getRow();
        $is_absen = $config->absensi_status;

        if($is_absen == 1){
            $jadwalData = $this->db->query("SELECT * from m_jadwal_posko a where user_id='".$id_petugas."'")->getRow();

            if(empty($jadwalData->id)){
                $is_absen = 0;
            }

        }

        return $is_absen;
    }

    public function authMobileUser(){
        $data = $this->request->getPost();
        $res_where = [];

        $mobile_email = !isset($data['mobile_email']) ?: $res_where['user_mobile_email'] = addslashes($data['mobile_email']);
        $mobile_name = !isset($data['mobile_name']) ?: $res_where['user_mobile_name'] = addslashes($data['mobile_name']);
        $mobile_photo = !isset($data['mobile_photo']) ?: $res_where['user_mobile_photo'] = addslashes($data['mobile_photo']);
        $mobile_type = !isset($data['mobile_type']) ?: $res_where['user_mobile_type'] = addslashes($data['mobile_type']);
        $mobile_fcm = !isset($data['mobile_fcm']) ?: $res_where['user_mobile_fcm'] = addslashes($data['mobile_fcm']);
        $mobile_jitsi = !isset($data['mobile_jitsi']) ?: $res_where['user_mobile_jitsi'] = addslashes($data['mobile_jitsi']);
        $mobile_uid = !isset($data['mobile_uid']) ?: $res_where['user_mobile_uid'] = addslashes($data['mobile_uid']);
        $mobile_version = !isset($data['mobile_version']) ?: $res_where['user_mobile_version'] = addslashes($data['mobile_version']);
        $is_otp = intval($this->getOTP());
       




        $query = $this->db->query("SELECT * from m_user_mobile where ((user_mobile_email = '".$mobile_email."' or user_mobile_uid = '".$mobile_uid."' ) and user_mobile_type = 'Android' and is_deleted=0) or ((user_mobile_email = '".$mobile_email."' or user_mobile_uid = '".$mobile_uid."' ) and user_mobile_type = 'iOS' and is_deleted=0)
        order by id desc")->getRow();
        
  

        if(empty($query)){

            
            $data = [
                "user_mobile_email" => $mobile_email,
                "user_mobile_name" => $mobile_name,
                "user_mobile_photo" => $mobile_photo,
                "user_mobile_type" => $mobile_type,
                "user_mobile_fcm" => $mobile_fcm,
                "user_mobile_jitsi" => $mobile_jitsi,
                "user_mobile_uid" => $mobile_uid,
                "user_mobile_version" => $mobile_version,
                "user_mobile_role" => '1'
            ];

           
            if ($this->apiModel->base_insert($data,'m_user_mobile')){
                $insertId = $this->db->insertID();

                $dataUser = $this->db->query("SELECT * from m_user_mobile where id='".$insertId."' ")->getRow();
                $tipeUser = $this->db->query("SELECT * from s_user_mobile_role where id='".$dataUser->user_mobile_role."'")->getRow();
                return $this->response->setJSON(res_success_custom3(1, 'Success', $dataUser,'user_role_code',$tipeUser->user_mobile_role_code,'user_role_name',$tipeUser->user_mobile_role_name,'is_otp',$is_otp));
            }else{
                return $this->response->setJSON(res_notfound(0, 'Failed Insert'));
            }
    
          
            
        }else{
            if($query->user_mobile_is_dev == 1){
                $is_otp = 0;
            }else{
                $is_otp;
            }

            $data = [
                "user_mobile_email" => $mobile_email,
                "user_mobile_name" => $mobile_name,
                "user_mobile_photo" => $mobile_photo,
                "user_mobile_type" => $mobile_type,
                "user_mobile_fcm" => $mobile_fcm,
                "user_mobile_jitsi" => $mobile_jitsi,
                "user_mobile_uid" => $mobile_uid,
                "user_mobile_version" => $mobile_version
            ];
           

      
            $tipeUser = $this->db->query("SELECT * from s_user_mobile_role where id='".$query->user_mobile_role."'")->getRow();
            if($query->user_mobile_role == '2'){
               

                $this->apiModel->base_update($data, "m_user_mobile", ["id" => $query->id]);
                $userPetugas = $this->db->query("SELECT a.id as id_petugas,b.id,a.`user_web_name` as user_mobile_name,b.user_mobile_email,
                b.user_mobile_phone,b.user_mobile_type,if(a.user_web_photo is null , b.user_mobile_photo,a.user_web_photo) as user_mobile_photo,b.user_mobile_uid,
                b.user_mobile_fcm,user_mobile_jitsi,b.user_mobile_rating,b.user_mobile_version,b.user_mobile_role,a.user_web_nik
                from m_user_web a
                left join m_user_mobile b on a.`user_mobile_id`=b.id where a.user_mobile_id ='".$query->id."'")->getRow();
                $is_absen = intval($this->configAbsen($userPetugas->id_petugas));

                $response = [
                    'status'  => 1,
                    'message' => 'Success',
                    'data' => $userPetugas,
                    'user_role_code'  => $tipeUser->user_mobile_role_code,
                    'user_role_name'  => $tipeUser->user_mobile_role_name,
                    'is_otp'    => $is_otp,
                    'is_absen'  => $is_absen

                ];
                return $this->response->setJSON($response);
            }else if($query->user_mobile_role == '3'){
                
                $this->apiModel->base_update($data, "m_user_mobile", ["id" => $query->id]);
                $response = [
                    'status'  => 1,
                    'message' => 'Success',
                    'data' => $query,
                    'user_role_code'  => $tipeUser->user_mobile_role_code,
                    'user_role_name'  => $tipeUser->user_mobile_role_name,
                    'is_otp'    => $is_otp

                ];
                return $this->response->setJSON($response);
            }
            else{

                $this->apiModel->base_update($data, "m_user_mobile", ["id" => $query->id]);
                $response = [
                    'status'  => 1,
                    'message' => 'Success',
                    'data' => $query,
                    'user_role_code'  => $tipeUser->user_mobile_role_code,
                    'user_role_name'  => $tipeUser->user_mobile_role_name,
                    'is_otp'    => $is_otp,
                    'is_absen'  => 0

                ];
                return $this->response->setJSON($response);
            }

           
        }

    }

    public function getNipHubdat($nip){
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

    public function updateFcm(){
        $data = $this->request->getPost();
        $res_where = [];

        $mobile_fcm = !isset($data['mobile_fcm']) ?: $res_where['user_mobile_fcm'] = addslashes($data['mobile_fcm']);
        $mobile_id = !isset($data['user_mobile_id']) ?: $res_where['user_mobile_id'] = addslashes($data['user_mobile_id']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(0, "Wrong Parameter"));
        }else{
            $update = array("user_mobile_fcm" => $mobile_fcm);

            $this->apiModel->base_update($update, "m_user_mobile", ["id" => $mobile_id]);
            return $this->response->setJSON(res_success(1, 'Success',NULL));
        }
    }

    public function updateJitsi(){
        $data = $this->request->getPost();
        $res_where = [];

        $mobile_fcm = !isset($data['mobile_jitsi']) ?: $res_where['user_mobile_jitsi'] = addslashes($data['mobile_jitsi']);
        $mobile_id = !isset($data['user_mobile_id']) ?: $res_where['user_mobile_id'] = addslashes($data['user_mobile_id']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(0, "Wrong Parameter"));
        }else{
            $update = array("user_mobile_jitsi" => $mobile_fcm);

            $this->apiModel->base_update($update, "m_user_mobile", ["id" => $mobile_id]);
            return $this->response->setJSON(res_success(1, 'Success',NULL));
        }

    }

    public function deleteUser(){
        $data = $this->request->getPost();
        $res_where = [];
    
        $mobile_id = !isset($data['user_mobile_id']) ?: $res_where['user_mobile_id'] = addslashes($data['user_mobile_id']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(0, "Wrong Parameter"));
        }else{
            $update = array("is_deleted" => 1);

            $this->apiModel->base_update($update, "m_user_mobile", ["id" => $mobile_id]);
            return $this->response->setJSON(res_success(1, 'Success',NULL));
        }
    }

    public function generateOTP_qiscus(){
        $kode = mt_rand(1000, 9999);
        // $statusOtp = $this->getOTP();
        $statusOtp = 1;
        $data = $this->request->getPost();

        $idMobile = $data['user_mobile_id'];
        $phone = $data['user_mobile_phone'];

        $dataUser = $this->db->query("SELECT user_mobile_phone,(NOW() + INTERVAL 5 MINUTE)as expired_otp from m_user_mobile where id='" . $idMobile . "'")->getRow();
		$number = $dataUser->user_mobile_phone !== NULL ?  $dataUser->user_mobile_phone : $phone;

        if($statusOtp == 1){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://multichannel.qiscus.com/whatsapp/v1/ldetf-98jloxrdfwh3iac/3553/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "to": "'.$number.'",
                "type": "template",
                "template": {
                    "namespace": "3c8b5792_6460_45b1_94dd_769bf13b5863",
                    "name": "otp_mitra_darat",
                    "language": {
                        "policy": "deterministic",
                        "code": "id"
                    },
                    "components": [
                        {
                            "type" : "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$kode.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Qiscus-App-Id: ldetf-98jloxrdfwh3iac',
                'Qiscus-Secret-Key: bfd74b044b1e5f904175d2ab172adf28',
                'Content-Type: application/json'
            ),
            ));

            // $response = curl_exec($curl);
            $results = json_decode(curl_exec($curl), true);
            curl_close($curl);

            $datalog['log_otp_ip'] = $this->request->getIPAddress();
            $datalog['log_otp_number'] = $number;
            $datalog['log_otp_resp'] = $kode;
            $datalog['log_otp_result'] = json_encode($results);
            $datalog['log_otp_source'] = 'Qiscus';
            $this->db->table('s_log_otp')->insert($datalog);
           
            if ($this->db->query("UPDATE m_user_mobile set user_mobile_otp='" . $kode . "',user_mobile_otp_expired='" . $dataUser->expired_otp . "', user_mobile_phone='" . $number . "' where id='" . $idMobile . "'")) {

                $response = [
                    'status'  => 1,
                    'otp_code' => $kode,
                    'message' => 'Success',
                    'result'  => $results,
                    'is_otp'  => $statusOtp
                ];
                return $this->response->setJSON($response);
            } else {

                $response = [
                    'status' => 0,
                    'message' => 'Failed'
                ];
                return $this->response->setJSON($response);
            }
           

        }else{
            $response = [
                'status' => 1,
                'otp_code' => $kode,
                'message' => 'Success',
                'result'	=> NULL
            ];

            return $this->response->setJSON($response);
        }
    }

    public function generateOTP(){
        $kode = mt_rand(1000, 9999);
        $statusOtp = 1;
        // $statusOtp = $this->getOTP();
        $data = $this->request->getPost();

        $idMobile = $data['user_mobile_id'];
        $phone = $data['user_mobile_phone'];
        $is_new = isset($data['is_new']) ? $data['is_new'] : 0;

        $dataUser = $this->db->query("SELECT user_mobile_phone,(NOW() + INTERVAL 5 MINUTE)as expired_otp from m_user_mobile where id='" . $idMobile . "'")->getRow();
		$number = $dataUser->user_mobile_phone !== NULL ?  $dataUser->user_mobile_phone : $phone;

        if($statusOtp == 1){
            $userkey = '408cdfc4202d';
            $passkey = '48846c1d6fd82bded53065dc';
            $telepon = 	'"' . $number . '"';
            $message = 'Kode OTP untuk MITRADARAT, masukan kode : *' . $kode . '* untuk melanjutkan proses verifikasi nomor anda,hanya berlaku 5 Menit. terima kasih';
            // $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
            $url = 'http://devel.nginovasi.id:4000/wa';
            $data = '{
                "number" : "'.$number.'",
                "message" : "'.$message.'"
            }';

            $header = array(
                'Authorization: Basic bmdpOndhOTk4Nzc=',
                'Content-Type: application/json'
            );

            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $url);
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
            // curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
            curl_setopt($curlHandle, CURLOPT_POST, 1);
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

            $results = json_decode(curl_exec($curlHandle), true);
            
            curl_close($curlHandle);



            if (!$results['success']) {
                $userkey = '408cdfc4202d';
				$passkey = '48846c1d6fd82bded53065dc';
				$telepon = 	'"' . $number . '"';
				$message = 'Kode OTP untuk MITRADARAT System, masukan kode : *' . $kode . '* untuk melanjutkan proses verifikasi nomor anda,hanya berlaku 5 Menit. Terima Kasih';
				$url = 'https://console.zenziva.net/wareguler/api/sendWA/';
				$curlHandle = curl_init();
				curl_setopt($curlHandle, CURLOPT_URL, $url);
				curl_setopt($curlHandle, CURLOPT_HEADER, 0);
				curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
				curl_setopt($curlHandle, CURLOPT_POST, 1);
				curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
					'userkey' => $userkey,
					'passkey' => $passkey,
					'to' => $telepon,
					'message' => $message
				));

				$results = json_decode($this->utf8ize(curl_exec($curlHandle)), true);
				curl_close($curlHandle);

                $datalog['log_otp_ip'] = $this->request->getIPAddress();
                $datalog['log_otp_number'] = $number;
                $datalog['log_otp_resp'] = $kode;
                $datalog['log_otp_result'] = json_encode($results);
                $datalog['log_otp_source'] = 'Zenziva';
                $this->db->table('s_log_otp')->insert($datalog);
            } else {
                $datalog['log_otp_ip'] = $this->request->getIPAddress();
                $datalog['log_otp_number'] = $number;
                $datalog['log_otp_resp'] = $kode;
                $datalog['log_otp_result'] = json_encode($results);
                $datalog['log_otp_source'] = 'NGI';
                $this->db->table('s_log_otp')->insert($datalog);
            }

            if($is_new == 1){
                if ($this->db->query("UPDATE m_user_mobile set user_mobile_otp='" . $kode . "',user_mobile_otp_expired='" . $dataUser->expired_otp . "' where id='" . $idMobile . "'")) {

                    $response = [
                        'status'  => 1,
                        'otp_code' => $kode,
                        'message' => 'Success',
                        'result'  => $results,
                        'is_otp'  => $statusOtp
                    ];
                    return $this->response->setJSON($response);
                } else {
    
                    $response = [
                        'status' => 0,
                        'message' => 'Failed'
                    ];
                    return $this->response->setJSON($response);
                }
            }else{
                
                if ($this->db->query("UPDATE m_user_mobile set user_mobile_otp='" . $kode . "',user_mobile_otp_expired='" . $dataUser->expired_otp . "', user_mobile_phone='" . $number . "' where id='" . $idMobile . "'")) {

                    $response = [
                        'status'  => 1,
                        'otp_code' => $kode,
                        'message' => 'Success',
                        'result'  => $results,
                        'is_otp'  => $statusOtp
                    ];
                    return $this->response->setJSON($response);
                } else {
    
                    $response = [
                        'status' => 0,
                        'message' => 'Failed'
                    ];
                    return $this->response->setJSON($response);
                }
            }
           

        }else{
            $response = [
                'status' => 1,
                'otp_code' => $kode,
                'message' => 'Success',
                'result'	=> NULL
            ];

            return $this->response->setJSON($response);
        }

    }

    public function authOTP(){
        $data = $this->request->getPost();
        $codeOtp = $data['otp_code'];
        $idMobile = $data['user_mobile_id'];
        $phone = isset($data['user_mobile_phone']) ? $data['user_mobile_phone'] : NULL;

        $rs = $this->db->query("SELECT user_mobile_otp,user_mobile_otp_expired from m_user_mobile where id='" . $idMobile . "' ")->getRow();

        if ($codeOtp == $rs->user_mobile_otp) {
            if ($rs->user_mobile_otp_expired >= date('Y-m-d H:i:s')) {
                if($phone != NULL){
                    if($this->db->query("UPDATE m_user_mobile set user_mobile_phone='" . $phone . "' where id='" . $idMobile . "'")){
                        return $this->response->setJSON(res_notfound(1, 'Success', NULL));
                    }else{
                        return $this->response->setJSON(res_notfound(0, 'Gagal update Nomor Whatsapp', NULL));
                    }
                  
                }else{
                    return $this->response->setJSON(res_notfound(1, 'Success', NULL));
                }
                

            } else {
                return $this->response->setJSON(res_notfound(2, 'OTP Expired', NULL));
            }
        } else {
            return $this->response->setJSON(res_notfound(0, "OTP Invalid"));
        }
    }

    public function menuMobile(){
        $data = $this->request->getPost();
        $user_role_code = $data['user_role_code'];

        $query = $this->db->query("SELECT 
        a.id as menu_id,a.menu_name,a.menu_order,a.menu_sort,a.menu_type_user,b.user_mobile_role_code,CONCAT('".base_url()."/',a.menu_icon) as menu_icon,
        a.menu_description,a.menu_active
        from m_menu_mobile a
            left join s_user_mobile_role b on FIND_IN_SET(b.id,a.menu_type_user)
        where a.is_deleted=0 and b.user_mobile_role_code='".addslashes($user_role_code)."' and a.menu_active=1
        order by a.menu_order asc")->getResult();

        // $query->menu_icon = base_url() . $query->menu_icon;
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function menuMobileDev(){
        $data = $this->request->getPost();
        $user_role_code = $data['user_role_code'];

        $query = $this->db->query("SELECT 
        a.id as menu_id,a.menu_name,a.menu_order,a.menu_sort,a.menu_type_user,b.user_mobile_role_code,CONCAT_WS('','".base_url()."/',a.menu_icon) as menu_icon,
        a.menu_description,a.menu_active
        from m_menu_mobile a
            left join s_user_mobile_role b on FIND_IN_SET(b.id,a.menu_type_user)
        where a.is_deleted=0 and b.user_mobile_role_code='".addslashes($user_role_code)."' and a.menu_is_devel=1
        order by a.menu_order asc")->getResult();

        // $query->menu_icon = base_url() . $query->menu_icon;
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function bannerMobile(){
        $query = $this->db->query("SELECT id as banner_id,banner_name,banner_order,CONCAT('".base_url()."/',banner_link) as banner_link from m_banner where is_deleted=0 and is_active=1 order by created_at desc")->getResult();
       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        } 
    }

    public function newsMobileLimit()
    {

        $query = $this->db->query("SELECT a.id,a.news_title as title,a.news_description as description,a.news_banner as banner_path,b.user_web_name as created_by,a.created_at as create_at from t_news a 
								   LEFT JOIN m_user_web b on a.`created_by`=b.id where a.is_deleted=0 order by a.created_at desc limit 5 ")->getResult();

        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        } 
    }

    public function newsMobileAll(){
        $data = $this->request->getPost();

        $page = $data["page"];
        $count_per_page = 20;
        $next_offset = ($page - 1) * $count_per_page;

        $query = "SELECT a.id,a.news_title as title,a.news_description as description,a.news_banner as banner_path,b.user_web_name as created_by,a.created_at as create_at from t_news a 
								   LEFT JOIN m_user_web b on a.`created_by`=b.id where a.is_deleted=0 order by a.created_at desc";

        $rows = $this->db->query($query)->getNumRows();
        $pages = ceil($rows / $count_per_page);

        if ($page <= $pages) {
            $resultrs = $this->db->query($query . " LIMIT " . $next_offset . "," . $count_per_page)->getResult();
            $response = [
                'status' => 1,
                'message' => count($resultrs) > 0 ? 'Success' : 'Tidak Ada Data',
                'data' => $resultrs,
                "pageInfo" => count($resultrs) > 0 ? [
                    "count" => $rows,
                    "pages" => $pages,
                    "next" => $page < $pages ? ($page + 1) : null,
                    "prev" => $page > 1 ? ($page - 1) : null
                ] : null
            ];

            return $this->response->setJSON($response);
        } else {
            $response = [
                'status' => 1,
                'message' => 'Tidak Ada Data',
                'data' => null,
                "pageInfo" => null
            ];

            return $this->response->setJSON($response);
        }
    }

    public function blue() {
        $data = $this->request->getPost();

        $res_where = [];
        !isset($data['no_registrasi_kendaraan']) ?: $res_where['no_registrasi_kendaraan'] = addslashes($data['no_registrasi_kendaraan']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(1, "please select data no_registrasi_kendaraan"));
        }

        $id = res_where($res_where);

        $query = $this->db->query("
            select a.id, a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.tgl_srut, a.no_registrasi_kendaraan, a.no_rangka, a.no_mesin, a.jenis_kendaraan, a.merk, a.tipe, a.tahun_rakit, a.bahan_bakar, a.isi_silinder, a.daya_motor, a.berat_kosong, a.panjang_kendaraan, a.lebar_kendaraan, a.tinggi_kendaraan, a.julur_depan, a.julur_belakang, a.jbb, a.jbkb, a.jbi, a.jbki, a.daya_angkut_orang, a.daya_angkut_kg, a.kelas_jalan, a.keterangan_hasil_uji, a.masa_berlaku, a.petugas_penguji, a.nrp_petugas_penguji, a.kepala_dinas, a.pangkat_kepala_dinas, a.nip_kepala_dinas, a.unit_pelaksana_teknis, a.direktur, a.pangkat_direktur, a.nip_direktur,concat('export/pdf/exportBlue/', a.no_registrasi_kendaraan) as link_pdf,a.is_deleted, a.created_at, a.created_by, a.updated_at, a.updated_by,a.no_uji_kendaraan
            from m_blue a
                where a.is_deleted = 0
                and a." . $id . "
            UNION ALL
            select b.id, b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.tgl_srut, b.no_registrasi_kendaraan, b.no_rangka, b.no_mesin, b.jenis_kendaraan, b.merk, b.tipe, b.tahun_rakit, b.bahan_bakar, b.isi_silinder, b.daya_motor, b.berat_kosong, b.panjang_kendaraan, b.lebar_kendaraan, b.tinggi_kendaraan, b.julur_depan, b.julur_belakang, b.jbb, b.jbkb, b.jbi, b.jbki, b.daya_angkut_orang, b.daya_angkut_kg, b.kelas_jalan, b.keterangan_hasil_uji, b.masa_berlaku, b.petugas_penguji, b.nrp_petugas_penguji, b.kepala_dinas, b.pangkat_kepala_dinas, b.nip_kepala_dinas, b.unit_pelaksana_teknis, b.direktur, b.pangkat_direktur, b.nip_direktur,concat('export/pdf/exportBlue/', b.no_registrasi_kendaraan) as link_pdf, b.is_deleted, b.created_at, b.created_by, b.updated_at, b.updated_by,concat('no_uji_kendaraan',null)
            from m_bluerfid b
                where b.is_deleted = 0
                and b." . $id . " order by date desc". "
            ");

        $resData = $query->getRow();

        if ($resData) {
            $resData->link_pdf = base_url() .'/'. $resData->link_pdf;
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Tidak Ada Data'));
        }
    }

    public function spionam() {
        $data = $this->request->getPost();

        $res_where = [];
        $noken = !isset($data['noken']) ?: $res_where['noken'] = addslashes($data['noken']);
        $no_kps = !isset($data['no_kps']) ?: $res_where['no_kps'] = addslashes($data['no_kps']);

        if(empty($noken) && empty($no_kps)){
            return $this->response->setJSON(res_notfound(1, "Mohon input nomor kendaraan atau nomor KPS"));
        }

        $query = $this->db->query("select a.id,a.perusahaan_id,b.nama_perusahaan,a.jenis_pelayanan,a.kode_kendaraan,a.noken,a.no_uji,
        a.tgl_exp_uji,a.no_kps,a.tgl_exp_kps,a.no_srut,
        CONCAT( LEFT( a.no_rangka, LENGTH( a.no_rangka ) -3 ) ,  'xxx' ) as no_rangka,
        CONCAT( LEFT( a.no_mesin, LENGTH( a.no_mesin ) -3 ) ,  'xxx' ) as no_mesin,
        a.merek,a.tahun,a.seat,a.barang,a.kode_trayek,a.nama_trayek,a.rute,a.etl_date,a.link_pdf
        from m_spionam a
        left join m_perusahaan_spionam b on a.perusahaan_id = b.perusahaan_id
        where (a.noken='".$noken."' or a.no_kps='".$no_kps."') and a.is_deleted = 0 order by a.tgl_exp_kps desc");

        $resData = $query->getRow();

        if ($resData) {
            $resData->link_pdf = base_url() . '/'. $resData->link_pdf;
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Data Not Found'));
        }
    }

    public function etilang() {
        $data = $this->request->getPost();

        $res_where = [];
        !isset($data['no_polisi']) ?: $res_where['no_polisi'] = addslashes($data['no_polisi']);
        !isset($data['belangko']) ?: $res_where['belangko'] = addslashes($data['belangko']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(1, "please select data no polisi atau belangko"));
        }

        $id = res_where($res_where, 'where');

        $query = $this->db->query("select * from m_etilang " . $id . " order by tanggal_penindakan desc");

        $resData = $query->getRow();

        if ($resData) {
            $resData->link_pdf = base_url() . '/'. $resData->link_pdf;
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Data Not Found'));
        }
    }

    public function notificationUser(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $orderStatus = $data['status_id'];

        if($userId == 0){
            $response = [
                'status' => 2,
                'message' => 'Silahkan Login'
            ];

            return $this->response->setJSON($response);
        }else{
            switch ($orderStatus){
                case "1":
                    $query = $this->db->query("SELECT * from t_notifikasi_user
                    where user_id='".$userId."' and created_at >= now()-interval 6 month order by id desc")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'status_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);
                
                break;

                case "2":
                    $query = $this->db->query("SELECT * from t_notifikasi
                    where is_deleted=0 and created_at >= now()-interval 3 month order by id desc")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'status_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);

                break;
                default:
                $res['status'] = 1;
                $res['message'] = "Data Not Found";
                $res['data'] = null;
                $res['order_status_id'] = $orderStatus;
    
                return $this->response->setJSON($res);
            }

        }

    }

    public function readNotification(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $notifId = $data['notif_id'];

        if($this->db->query("update t_notifikasi_user set is_read = 1 where user_id='".$userId."' and id='".$notifId."'")){
            return $this->response->setJSON(res_success(1, 'Success',NULL));
        }else{
            return $this->response->setJSON(res_success(0, 'Failed',NULL));
        }
    }

    public function jembatan() {
        $data = $this->request->getPost();

        $res_where = [];
        !isset($data['id']) ?: $res_where['id'] = addslashes($data['id']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(1, "please select data id"));
        }

        $id = res_where($res_where, 'where');

        $query = $this->db->query("select * from m_jto " . $id . " order by etl_date desc");

        $resData = $query->getRow();
        
        if ($resData) {
            $resData->link_pdf = base_url() . '/'. $resData->link_pdf;
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Data Not Found'));
        }
    }

    public function jembatanPenindakan() {
        $data = $this->request->getPost();

        $res_where = [];
        !isset($data['no_kend']) ?: $res_where['no_kend'] = addslashes($data['no_kend']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(1, "please select data id"));
        }

        $id = res_where($res_where, 'where');

        $splitId = explode(' ', $id);
        $finalId = $splitId[0] . ' ' . 'b.' . $splitId[1] . $splitId[2] . $splitId[3];

        $query = $this->db->query("select a.id, a.nama_jembatan, max(b.tanggal) as tanggal, a.toleransi, b.no_kend, b.pelanggaran, b.link_pdf
                                    from m_jto a
                                    left join s_jto_penindakan b
                                    on a.id = b.idjt
                                    " . $finalId . "
                                    group by a.id");

        $resData = $query->getRow();

        if ($resData) {
            $resData->link_pdf = base_url() . '/'. $resData->link_pdf;
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Data Not Found'));
        }
    }

    public function rampcheckResult(){
        $data = $this->request->getPost();

        $res_where = [];
        $rampcheck_no =!isset($data['rampcheck_no']) ?: $res_where['rampcheck_no'] = addslashes($data['rampcheck_no']);
        $rampcheck_noken =!isset($data['rampcheck_noken']) ?: $res_where['rampcheck_noken'] = addslashes($data['rampcheck_noken']);
        
        if(empty($rampcheck_noken) && empty($rampcheck_no)){
            return $this->response->setJSON(res_notfound(1,"please input field"));
        }
        
      
        $statusRampcheck = $this->db->query("SELECT a.rampcheck_id,b.rampcheck_link_pdf,b.rampcheck_no,b.rampcheck_noken,if(a.rampcheck_kesimpulan_status=0 or a.rampcheck_kesimpulan_status=1,1,0 )as rampcheck_status_code,
                            CASE
                                WHEN a.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
                                WHEN a.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
                                WHEN a.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
                            ELSE 'Dilarang Operasional'
                            END as rampcheck_status
                            from t_rampcheck_kesimpulan a
                            left join t_rampcheck b on a.rampcheck_id=b.id
                            where (b.rampcheck_no='".$rampcheck_no."' or b.rampcheck_noken='".$rampcheck_noken."') and b.is_deleted=0 order by a.id desc limit 1");

        $resData = $statusRampcheck->getRow();
   
        if($resData){
            $resData->rampcheck_link_pdf = base_url() . '/'. $resData->rampcheck_link_pdf;

            $datarampcheck = $this->db->query("SELECT a.id as rampcheck_id,a.rampcheck_nama_lokasi,a.rampcheck_no,a.rampcheck_date,a.rampcheck_umur_pengemudi,b.jenis_lokasi_name as rampcheck_location,a.`rampcheck_pengemudi`,a.`rampcheck_po_name`,a.`rampcheck_noken`,
            a.`rampcheck_stuk`,c.`jenis_angkutan_name`,a.rampcheck_trayek as trayek_name,a.rampcheck_sticker_no,a.rampcheck_no_kp,a.rampcheck_expired_kp_date,a.rampcheck_expired_blue_date
                from t_rampcheck a 
                left join m_jenis_lokasi b on a.`rampcheck_jenis_lokasi_id`=b.id
                left join m_jenis_angkutan c on a.`rampcheck_jenis_angkutan_id`=c.id
              
           where (a.rampcheck_no='".$rampcheck_no."' or a.rampcheck_noken='".$rampcheck_noken."') and a.is_deleted=0 order by a.id desc limit 1")->getRow();

            $admRampcheck = $this->db->query("SELECT 
            CASE
                WHEN a.rampcheck_adm_ku = 0 THEN 'Ada, Berlaku'
                WHEN a.rampcheck_adm_ku = 1 THEN 'Tidak Berlaku'
                WHEN a.rampcheck_adm_ku = 2 THEN 'Tidak Ada'
                ELSE 'Tidak Sesuai Fisik'
            END as rampcheck_status,
            CASE
                WHEN a.rampcheck_adm_kpr = 0 THEN 'Ada, Berlaku'
                WHEN a.rampcheck_adm_kpr = 1 THEN 'Tidak Berlaku'
                WHEN a.rampcheck_adm_kpr = 2 THEN 'Tidak Ada'
                ELSE 'Tidak Sesuai Fisik'
            END as rampcheck_adm_kpr,
            CASE
                WHEN a.rampcheck_adm_kpc = 0 THEN 'Ada, Berlaku'
                WHEN a.rampcheck_adm_kpc = 1 THEN 'Tidak Berlaku'
                WHEN a.rampcheck_adm_kpc = 2 THEN 'Tidak Ada'
                ELSE 'Tidak Sesuai Fisik'
            END as rampcheck_adm_kpc,
            CASE
                WHEN a.rampcheck_adm_sim = 0 THEN 'A Umum'
                WHEN a.rampcheck_adm_sim = 1 THEN 'B1 Umum'
                WHEN a.rampcheck_adm_sim = 2 THEN 'B2 Umum'
                ELSE 'SIM Tidak Sesuai'
            END as rampcheck_adm_sim,a.rampcheck_adm_no_kpc,a.rampcheck_adm_exp_date_kpc
            from t_rampcheck_adm a
            inner join t_rampcheck b on a.`rampcheck_id`=b.id
            where (b.rampcheck_no='".$rampcheck_no."' or b.rampcheck_noken='".$rampcheck_noken."')  and a.is_deleted=0 order by b.id desc limit 1")->getRow();

            $sistemUtama = $this->db->query("SELECT 
            CASE
                WHEN a.rampcheck_utu_lukd = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lukd = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_dekat,
            CASE
                WHEN a.rampcheck_utu_lukj = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lukj = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_jauh,
            CASE
                WHEN a.rampcheck_utu_lpad = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lpad = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_penunjuk_dekat,
                CASE
                WHEN a.rampcheck_utu_lpaj = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lpaj = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_penunjuk_jauh,
                CASE
                WHEN a.rampcheck_utu_lr = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lr = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_rem,
                CASE
                WHEN a.rampcheck_utu_lm = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lm = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_mundur,
            IF(a.rampcheck_utu_kru = 0 ,'Berfungsi','Tidak Berfungsi') as rem_utama,
            IF(a.rampcheck_utu_krp = 0 ,'Berfungsi','Tidak Berfungsi') as rem_parkir,
            CASE
                WHEN a.rampcheck_utu_kbd = 0 THEN 'Semua Laik'
                WHEN a.rampcheck_utu_kbd = 1 THEN 'Tidak Laik Kanan'
                ELSE 'Tidak Laik Kiri'
            END as ban_depan,
            CASE
                WHEN a.rampcheck_utu_kbb = 0 THEN 'Semua Laik'
                WHEN a.rampcheck_utu_kbb = 1 THEN 'Tidak Laik Kanan'
                ELSE 'Tidak Laik Kiri'
            END as ban_belakang,
            CASE
                WHEN a.rampcheck_utu_skp = 0 THEN 'Ada dan Fungsi'
                WHEN a.rampcheck_utu_skp = 1 THEN 'Tidak Fungsi'
                ELSE 'Tidak Ada'
            END as sabuk_pengaman,
            CASE
                WHEN a.rampcheck_utu_pk = 0 THEN 'Ada dan Berfungsi'
                WHEN a.rampcheck_utu_pk = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as pengukur_kecepatan,
            CASE
                WHEN a.rampcheck_utu_pkw = 0 THEN 'Ada dan Berfungsi'
                WHEN a.rampcheck_utu_pkw = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as penghapus_kaca,
            IF(a.rampcheck_utu_pd = 0 ,'Ada','Tidak Ada') as pintu_darurat,
            IF(a.rampcheck_utu_jd = 0 ,'Ada','Tidak Ada') as jendela_darurat,
            IF(a.rampcheck_utu_apk = 0 ,'Ada','Tidak Ada') as pemecah_kaca,
            CASE
                WHEN a.rampcheck_utu_apar = 0 THEN 'Ada'
                WHEN a.rampcheck_utu_apar = 1 THEN 'Kadaluarsa'
                ELSE 'Tidak Ada'
            END as apar
            from t_rampcheck_utu a
            inner join t_rampcheck b on a.`rampcheck_id`=b.id
            where (b.rampcheck_no='".$rampcheck_no."' or b.rampcheck_noken='".$rampcheck_noken."')  and a.is_deleted=0 order by b.id desc limit 1")->getRow();

            $sistemPenunjang = $this->db->query("SELECT 
            CASE
                WHEN a.rampcheck_utp_sp_dpn = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utp_sp_dpn = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_depan,
            CASE
                WHEN a.rampcheck_utp_sp_blk = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utp_sp_blk = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_belakang,
            IF(a.rampcheck_utp_bk_kcd = 0 ,'Baik','Kurang Baik') as kaca_depan,
            IF(a.rampcheck_utp_bk_pu = 0 ,'Baik','Kurang Baik') as pintu_utama,
            IF(a.rampcheck_utp_bk_kru = 0 ,'Sesuai','Tidak Sesuai') as rem_utama,
            CASE
                WHEN a.rampcheck_utp_bk_krp = 0 THEN 'Ada'
                WHEN a.rampcheck_utp_bk_krp = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as rem_parkir,
            IF(a.rampcheck_utp_bk_ldt = 0 ,'Baik','Keropos/Berlubang') as lantai_tangga,
            IF(a.rampcheck_utp_ktd_jtd = 0 ,'Sesuai','Tidak Sesuai') as tempat_duduk,
            CASE
                WHEN a.rampcheck_utp_pk_bc = 0 THEN 'Ada dan Laik'
                WHEN a.rampcheck_utp_pk_bc = 1 THEN 'Tidak Laik'
                ELSE 'Tidak Ada'
            END as ban_cadangan,
            IF(a.rampcheck_utp_pk_sp = 0 ,'Ada','Tidak Ada') as segitiga_pengaman,
            IF(a.rampcheck_utp_pk_dkr = 0 ,'Ada','Tidak Ada') as dongkrak,
            IF(a.rampcheck_utp_pk_pbr = 0 ,'Ada','Tidak Ada') as pembuka_roda,
            CASE
                WHEN a.rampcheck_utp_pk_ls = 0 THEN 'Ada'
                WHEN a.rampcheck_utp_pk_ls = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as lampu_senter,
            IF(a.rampcheck_utp_pk_pgr = 0 ,'Ada','Tidak Ada') as pengganjal_roda,
            IF(a.rampcheck_utp_pk_skp = 0 ,'Ada','Tidak Ada') as sabuk_penumpang,
            IF(a.rampcheck_utp_pk_ptk = 0 ,'Ada','Tidak Ada') as kotak_p3k
            from t_rampcheck_utp a
            inner join t_rampcheck b on a.`rampcheck_id`=b.id
            where (b.rampcheck_no='".$rampcheck_no."' or b.rampcheck_noken='".$rampcheck_noken."')  and a.is_deleted=0 order by b.id desc limit 1")->getRow();

            $kesimpulan = $this->db->query("SELECT a.rampcheck_id,b.rampcheck_no,b.rampcheck_noken,json_arrayagg(CONCAT('".base_url()."/',c.document_filename)) as foto_pendukung,
            CASE
                WHEN a.rampcheck_kesimpulan_status = 0 THEN 'DIIJINKAN OPERASIONAL'
                WHEN a.rampcheck_kesimpulan_status = 1 THEN 'PERINGATAN / PERBAIKI'
                WHEN a.rampcheck_kesimpulan_status = 2 THEN 'TILANG DAN DILARANG OPERASIONAL'
            ELSE 'DILARANG OPERASIONAL'
            END as rampcheck_status,a.rampcheck_kesimpulan_catatan as kesimpulan_catatan,b.rampcheck_sticker_no,
            b.rampcheck_pengemudi as kesimpulan_nama_pengemudi,CONCAT('".base_url()."/',a.rampcheck_kesimpulan_ttd_pengemudi) as kesimpulan_ttd_pengemudi,a.rampcheck_kesimpulan_nama_penguji as kesimpulan_nama_penguji,a.rampcheck_kesimpulan_no_penguji as kesimpulan_no_penguji,CONCAT('".base_url()."/',a.rampcheck_kesimpulan_ttd_penguji) as kesimpulan_ttd_penguji,a.rampcheck_kesimpulan_nama_penyidik as kesimpulan_nama_penyidik,a.rampcheck_kesimpulan_no_penyidik as kesimpulan_no_penyidik,CONCAT('".base_url()."/',a.rampcheck_kesimpulan_ttd_penyidik) as kesimpulan_ttd_penyidik
            from t_rampcheck_kesimpulan a
            left join t_rampcheck b on a.rampcheck_id=b.id
            left join m_document_rampcheck c on b.id=c.rampcheck_id
            where (b.rampcheck_no='".$rampcheck_no."' or b.rampcheck_noken='".$rampcheck_noken."')  order by b.id desc limit 1")->getRow();

            // echo $this->db->getLastQuery();
           
            
               
            $objdata = json_decode($kesimpulan->foto_pendukung);
            
            if(!empty($objdata[0])){
                $kesimpulan->foto_pendukung = $objdata; 
                
            }else{
                $kesimpulan->foto_pendukung = NULL;
            }   
                
            
                    

            $resArr = [
                "data_rampcheck" => $datarampcheck,
                "data_administrasi" => $admRampcheck,
                "sistem_utama" => $sistemUtama,
                "sistem_penunjang" => $sistemPenunjang,
                "kesimpulan" => $kesimpulan
            ];

            $res['status'] = 1;
            $res['message'] = "Success";
            $res['header_rampcheck'] = $resData;
            $res['data'] = $resArr;

            return $this->response->setJSON($res);
        }else{
            return $this->response->setJSON(res_notfound(1, 'Data Not Found')); 
        }       
    }

    public function getLokasi() {
        $query = $this->db->query("SELECT id,jenis_lokasi_name from m_jenis_lokasi where is_deleted=0 ")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function getLokasiTerminal() {
        $query = $this->db->query("SELECT * from m_terminal where is_deleted=0 ")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function getJenisAngkutan() {
        $query = $this->db->query("SELECT id,jenis_angkutan_name  from m_jenis_angkutan where is_deleted=0 ")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function getTrayek() {
        $query = $this->db->query("SELECT id,trayek_code,trayek_name  from m_trayek where is_deleted=0 ")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function getDataKendaraan(){
        $data = $this->request->getPost();
        $noken = $data['noken'];

        $datablue = $this->db->query("SELECT a.no_uji_kendaraan as rampcheck_stuk,a.date,
        CASE
            WHEN  NOW() < a.masa_berlaku  THEN '0'
            WHEN NOW() > a.masa_berlaku THEN '1'
            ELSE '2' 
        END as rampcheck_adm_ku,DATE(a.masa_berlaku) as rampcheck_expired_blue_date
        from m_blue a where a.no_registrasi_kendaraan='".$noken."' and a.is_deleted=0
        
        UNION ALL
            select concat('no_uji_kendaraan',null) as rampcheck_stuk,b.date,
                CASE
                    WHEN  NOW() < b.masa_berlaku  THEN '0'
                    WHEN NOW() > b.masa_berlaku THEN '1'
                    ELSE '2' 
                END as rampcheck_adm_ku, DATE(b.masa_berlaku) as rampcheck_expired_blue_date from m_bluerfid b
                where b.no_registrasi_kendaraan='".$noken."' and b.is_deleted=0
        order by date desc")->getRow();

        $dataSpionam = $this->db->query("select 
        b.nama_perusahaan as rampcheck_po_name,
        c.id as rampcheck_jenis_angkutan_id, 
        c.jenis_angkutan_name as rampcheck_jenis_angkutan_name,
        a.rute as rampcheck_trayek,
        CASE
            WHEN  NOW() < tgl_exp_kps  THEN '0'
            WHEN NOW() > tgl_exp_kps THEN '1'
            ELSE '2' 
        END as rampcheck_adm_kpr,a.no_kps as rampcheck_no_kp,DATE(a.tgl_exp_kps) as rampcheck_expired_kp_date
        from m_spionam a 
        left join m_perusahaan_spionam b on a.perusahaan_id=b.perusahaan_id
        left join m_jenis_angkutan c on a.jenis_pelayanan=c.jenis_angkutan_name 
        where noken='".$noken."' order by tgl_exp_kps desc")->getRow();

        $datablue = [
           
            'rampcheck_stuk' => isset($datablue->rampcheck_stuk)  ? $datablue->rampcheck_stuk : NULL,
            'rampcheck_adm_ku' => isset($datablue->rampcheck_adm_ku)  ? $datablue->rampcheck_adm_ku : '2',
            'rampcheck_expired_blue_date' => isset($datablue->rampcheck_expired_blue_date)  ? $datablue->rampcheck_expired_blue_date : NULL,
        ];

        $dataspionam = [
            'rampcheck_po_name' => isset($dataSpionam->rampcheck_po_name)  ? $dataSpionam->rampcheck_po_name : NULL,
            'rampcheck_jenis_angkutan_id' => isset($dataSpionam->rampcheck_jenis_angkutan_id)  ? $dataSpionam->rampcheck_jenis_angkutan_id : NULL,
            'rampcheck_jenis_angkutan_name' => isset($dataSpionam->rampcheck_jenis_angkutan_name)  ? $dataSpionam->rampcheck_jenis_angkutan_name : NULL,
            'rampcheck_trayek' => isset($dataSpionam->rampcheck_trayek)  ? $dataSpionam->rampcheck_trayek : NULL,
            'rampcheck_adm_kpr' => isset($dataSpionam->rampcheck_adm_kpr)  ? $dataSpionam->rampcheck_adm_kpr : '2',
            'rampcheck_no_kp' => isset($dataSpionam->rampcheck_no_kp)  ? $dataSpionam->rampcheck_no_kp : NULL,
            'rampcheck_expired_kp_date' => isset($dataSpionam->rampcheck_expired_kp_date)  ? $dataSpionam->rampcheck_expired_kp_date : NULL,
            

        ];

    

        $response = [
            'status' => 1,
            'message' => 'Success',
            'data_blue' => $datablue,
            'data_spionam' => $dataSpionam
        ];
        return $this->response->setJSON($response);

    }

    public function inputRampcheck() {
        $this->db->transStart();
        header('Content-Type: application/json');
        $dataTrx = file_get_contents('php://input');
        $arrDataRampcheck = json_decode($dataTrx);

        // print_r($dataTrx);
        
        $insertDataRampcheck = $arrDataRampcheck->data->data_rampcheck;
        $dataAdm = $arrDataRampcheck->data->data_administrasi;
        $sistemUtama = $arrDataRampcheck->data->sistem_utama;
        $sistemPenunjang = $arrDataRampcheck->data->sistem_penunjang;
        $kesimpulan = $arrDataRampcheck->data->kesimpulan;
        $userPetugas = $arrDataRampcheck->data->user_petugas->id_petugas;

        $isInsert = false;

        $insertRamp = [
            'rampcheck_date' => $insertDataRampcheck->rampcheck_date,
            'rampcheck_jenis_lokasi_id' => $insertDataRampcheck->rampcheck_jenis_lokasi_id,
            'rampcheck_nama_lokasi' => $insertDataRampcheck->rampcheck_nama_lokasi,
            'rampcheck_pengemudi' => $insertDataRampcheck->rampcheck_pengemudi,
            'rampcheck_umur_pengemudi' => $insertDataRampcheck->rampcheck_umur_pengemudi,
            'rampcheck_po_name' => $insertDataRampcheck->rampcheck_po_name,
            'rampcheck_noken' => $insertDataRampcheck->rampcheck_noken,
            'rampcheck_stuk' => $insertDataRampcheck->rampcheck_stuk,
            'rampcheck_jenis_angkutan_id' => $insertDataRampcheck->rampcheck_jenis_angkutan_id,
            'rampcheck_trayek' => $insertDataRampcheck->rampcheck_trayek,
            'rampcheck_sticker_no' => $kesimpulan->rampcheck_sticker_no,
            'created_by' => $userPetugas,
            'rampcheck_no_kp' => $insertDataRampcheck->rampcheck_no_kp,
            'rampcheck_expired_kp_date' => $insertDataRampcheck->rampcheck_expired_kp_date,
            'rampcheck_expired_blue_date' => $insertDataRampcheck->rampcheck_expired_blue_date
        ];

        $this->apiModel->base_insert($insertRamp,'t_rampcheck');
        
        $insertId = $this->db->insertID();

        $insertAdm = [
            'rampcheck_id' => $insertId,
            'rampcheck_adm_ku' => $dataAdm->rampcheck_adm_ku,
            'rampcheck_adm_kpr' => $dataAdm->rampcheck_adm_kpr,
            'rampcheck_adm_kpc'=> $dataAdm->rampcheck_adm_kpc,
            'rampcheck_adm_sim' => $dataAdm->rampcheck_adm_kpc,
            'created_by' => $userPetugas,
            'rampcheck_adm_no_kpc' => $dataAdm->rampcheck_adm_no_kpc,
            'rampcheck_adm_exp_date_kpc' => $dataAdm->rampcheck_adm_exp_date_kpc
        ];
        $this->apiModel->base_insert($insertAdm,'t_rampcheck_adm');

        $insertSistemUtama = [
            'rampcheck_id' => $insertId,
            'rampcheck_utu_lukd' => $sistemUtama->rampcheck_utu_lukd,
            'rampcheck_utu_lukj' => $sistemUtama->rampcheck_utu_lukj,
            'rampcheck_utu_lpad' => $sistemUtama->rampcheck_utu_lpad,
            'rampcheck_utu_lpaj' => $sistemUtama->rampcheck_utu_lpaj,
            'rampcheck_utu_lr' => $sistemUtama->rampcheck_utu_lr,
            'rampcheck_utu_lm' => $sistemUtama->rampcheck_utu_lm,
            'rampcheck_utu_kru' => $sistemUtama->rampcheck_utu_kru,
            'rampcheck_utu_krp' => $sistemUtama->rampcheck_utu_krp,
            'rampcheck_utu_kbd' => $sistemUtama->rampcheck_utu_kbd,
            'rampcheck_utu_kbb' => $sistemUtama->rampcheck_utu_kbb,
            'rampcheck_utu_skp' => $sistemUtama->rampcheck_utu_skp,
            'rampcheck_utu_pk' => $sistemUtama->rampcheck_utu_pk,
            'rampcheck_utu_pkw' => $sistemUtama->rampcheck_utu_pkw,
            'rampcheck_utu_pd' => $sistemUtama->rampcheck_utu_pd,
            'rampcheck_utu_jd' => $sistemUtama->rampcheck_utu_jd,
            'rampcheck_utu_apk' => $sistemUtama->rampcheck_utu_apk,
            'rampcheck_utu_apar' => $sistemUtama->rampcheck_utu_apar,
            'created_by' => $userPetugas
        ];
        $this->apiModel->base_insert($insertSistemUtama,'t_rampcheck_utu');

        $insertSistemPenunjang = [
            'rampcheck_id' => $insertId,
            'rampcheck_utp_sp_dpn' => $sistemPenunjang->rampcheck_utp_sp_dpn,
            'rampcheck_utp_sp_blk' => $sistemPenunjang->rampcheck_utp_sp_blk,
            'rampcheck_utp_bk_kcd' => $sistemPenunjang->rampcheck_utp_bk_kcd,
            'rampcheck_utp_bk_pu' => $sistemPenunjang->rampcheck_utp_bk_pu,
            'rampcheck_utp_bk_kru' => $sistemPenunjang->rampcheck_utp_bk_kru,
            'rampcheck_utp_bk_krp' => $sistemPenunjang->rampcheck_utp_bk_krp,
            'rampcheck_utp_bk_ldt' => $sistemPenunjang->rampcheck_utp_bk_ldt,
            'rampcheck_utp_ktd_jtd' => $sistemPenunjang->rampcheck_utp_ktd_jtd,
            'rampcheck_utp_pk_bc' => $sistemPenunjang->rampcheck_utp_pk_bc,
            'rampcheck_utp_pk_sp' => $sistemPenunjang->rampcheck_utp_pk_sp,
            'rampcheck_utp_pk_dkr' => $sistemPenunjang->rampcheck_utp_pk_dkr,
            'rampcheck_utp_pk_pbr' => $sistemPenunjang->rampcheck_utp_pk_pbr,
            'rampcheck_utp_pk_ls' => $sistemPenunjang->rampcheck_utp_pk_ls,
            'rampcheck_utp_pk_pgr' => $sistemPenunjang->rampcheck_utp_pk_pgr,
            'rampcheck_utp_pk_skp' => $sistemPenunjang->rampcheck_utp_pk_skp,
            'rampcheck_utp_pk_ptk' => $sistemPenunjang->rampcheck_utp_pk_ptk,
            'created_by' => $userPetugas
        ];
        $this->apiModel->base_insert($insertSistemPenunjang,'t_rampcheck_utp');

        $filename1 = $this->genNamefile();
        $file1 = '/home/ngi/php/php74/transhubdat/public/uploads/ttd/'.$filename1.'_pengemudi.png';
		$file2 = '/home/ngi/php/php74/transhubdat/public/uploads/ttd/'.$filename1.'_penguji.png';
        $file3 = '/home/ngi/php/php74/transhubdat/public/uploads/ttd/'.$filename1.'_penyidik.png';

        //local
		// $file1 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/ttd/'.$filename1.'_pengemudi.png';
		// $file2 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/ttd/'.$filename1.'_penguji.png';
        // $file3 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/ttd/'.$filename1.'_penyidik.png';

		$data1 = base64_decode($kesimpulan->rampcheck_kesimpulan_ttd_pengemudi);
		$data2 = base64_decode($kesimpulan->rampcheck_kesimpulan_ttd_penguji);
        $data3 = base64_decode($kesimpulan->rampcheck_kesimpulan_ttd_penyidik);


		file_put_contents($file1, $data1);
		file_put_contents($file2, $data2);
        file_put_contents($file3, $data3);
		
		$ttdPengemudi = 'public/uploads/ttd/'.$filename1.'_pengemudi.png';
		$ttdPenguji = 'public/uploads/ttd/'.$filename1.'_penguji.png';
        $ttdPenyidik = 'public/uploads/ttd/'.$filename1.'_penyidik.png';

        $insertKesimpulan = [
            'rampcheck_id' => $insertId,
            'rampcheck_kesimpulan_status' => $kesimpulan->rampcheck_kesimpulan_status,
            'rampcheck_kesimpulan_catatan' => $kesimpulan->rampcheck_kesimpulan_catatan,
            'rampcheck_kesimpulan_ttd_pengemudi' => $ttdPengemudi,
            'rampcheck_kesimpulan_nama_penguji' => $kesimpulan->rampcheck_kesimpulan_nama_penguji,
            'rampcheck_kesimpulan_no_penguji' => $kesimpulan->rampcheck_kesimpulan_no_penguji,
            'rampcheck_kesimpulan_ttd_penguji' => $ttdPenguji,
            'rampcheck_kesimpulan_nama_penyidik' => $kesimpulan->rampcheck_kesimpulan_nama_penyidik,
            'rampcheck_kesimpulan_no_penyidik' => $kesimpulan->rampcheck_kesimpulan_no_penyidik,
            'rampcheck_kesimpulan_ttd_penyidik' =>  empty($kesimpulan->rampcheck_kesimpulan_ttd_penyidik) ? NULL : $ttdPenyidik ,
            'created_by' => $userPetugas

        ];
        $this->apiModel->base_insert($insertKesimpulan,'t_rampcheck_kesimpulan');

    
        $i = 1;
        $fotopendukung = $kesimpulan->rampchek_foto_pendukung;
       
        if($fotopendukung != null){
            foreach ($fotopendukung as $imageData) {
            
                $filename = $this->genNamefile()."_".$i;
                $file =  '/home/ngi/php/php74/transhubdat/public/uploads/rampcheck/'.$filename.'.jpg';
                // $file = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/ttd/'.$filename.'.jpg';
                $datapendukung = base64_decode($imageData);
                file_put_contents($file, $datapendukung);
                
                $gallery = [
                    'rampcheck_id' => $insertId,
                    'document_name' 	=> $filename.'.jpg',
                    'document_filename' => 'public/uploads/rampcheck/'.$filename.'.jpg',
                    'created_by' => $userPetugas
                ];
                // array_push($arr, $gallery);
                $i = $i+1;
                $this->apiModel->base_insert($gallery,'m_document_rampcheck');
            }
        }

        if ($this->db->transStatus() === FALSE) {
            $iscommit = false;
            $this->db->transRollback();
        } else {
            $iscommit = true;
            $this->db->transCommit();
        }

        if ($iscommit === true) {
            $statusRampcheck = $this->db->query("SELECT a.rampcheck_id,b.rampcheck_no,b.rampcheck_noken,if(a.rampcheck_kesimpulan_status=0 or a.rampcheck_kesimpulan_status=1,1,0 )as rampcheck_status_code,
                            CASE
                                WHEN a.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
                                WHEN a.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
                                WHEN a.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
                            ELSE 'Dilarang Operasional'
                            END as rampcheck_status
                            from t_rampcheck_kesimpulan a
                            left join t_rampcheck b on a.rampcheck_id=b.id
                            where b.id='".$insertId."' and b.is_deleted=0");
    
            $datarampcheck = $this->db->query("SELECT a.id as rampcheck_id,a.rampcheck_nama_lokasi,a.rampcheck_no,a.rampcheck_date,b.jenis_lokasi_name as rampcheck_location,a.`rampcheck_pengemudi`,a.`rampcheck_po_name`,a.`rampcheck_noken`,
            a.`rampcheck_stuk`,c.`jenis_angkutan_name`,a.rampcheck_trayek as `trayek_name`,a.rampcheck_no_kp,a.rampcheck_expired_kp_date,a.rampcheck_expired_blue_date
                from t_rampcheck a 
                left join m_jenis_lokasi b on a.`rampcheck_jenis_lokasi_id`=b.id
                left join m_jenis_angkutan c on a.`rampcheck_jenis_angkutan_id`=c.id
             where a.id = '".$insertId."' and a.is_deleted=0")->getRow();

            $admRampcheck = $this->db->query("SELECT 
            CASE
                WHEN a.rampcheck_adm_ku = 0 THEN 'Ada, Berlaku'
                WHEN a.rampcheck_adm_ku = 1 THEN 'Tidak Berlaku'
                WHEN a.rampcheck_adm_ku = 2 THEN 'Tidak Ada'
                ELSE 'Tidak Sesuai Fisik'
            END as rampcheck_status,
            CASE
                WHEN a.rampcheck_adm_kpr = 0 THEN 'Ada, Berlaku'
                WHEN a.rampcheck_adm_kpr = 1 THEN 'Tidak Berlaku'
                WHEN a.rampcheck_adm_kpr = 2 THEN 'Tidak Ada'
                ELSE 'Tidak Sesuai Fisik'
            END as rampcheck_adm_kpr,
            CASE
                WHEN a.rampcheck_adm_kpc = 0 THEN 'Ada, Berlaku'
                WHEN a.rampcheck_adm_kpc = 1 THEN 'Tidak Berlaku'
                WHEN a.rampcheck_adm_kpc = 2 THEN 'Tidak Ada'
                ELSE 'Tidak Sesuai Fisik'
            END as rampcheck_adm_kpc,
            CASE
                WHEN a.rampcheck_adm_sim = 0 THEN 'A Umum'
                WHEN a.rampcheck_adm_sim = 1 THEN 'B1 Umum'
                WHEN a.rampcheck_adm_sim = 2 THEN 'B2 Umum'
                ELSE 'SIM Tidak Sesuai'
            END as rampcheck_adm_sim,a.rampcheck_adm_no_kpc,a.rampcheck_adm_exp_date_kpc
            from t_rampcheck_adm a
            inner join t_rampcheck b on a.`rampcheck_id`=b.id
            where b.id='".$insertId."'and a.is_deleted=0")->getRow();

            $sistemUtama = $this->db->query("SELECT 
            CASE
                WHEN a.rampcheck_utu_lukd = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lukd = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_dekat,
            CASE
                WHEN a.rampcheck_utu_lukj = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lukj = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_jauh,
            CASE
                WHEN a.rampcheck_utu_lpad = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lpad = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_penunjuk_dekat,
                CASE
                WHEN a.rampcheck_utu_lpaj = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lpaj = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_penunjuk_jauh,
                CASE
                WHEN a.rampcheck_utu_lr = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lr = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_rem,
                CASE
                WHEN a.rampcheck_utu_lm = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utu_lm = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_mundur,
            IF(a.rampcheck_utu_kru = 0 ,'Berfungsi','Tidak Berfungsi') as rem_utama,
            IF(a.rampcheck_utu_krp = 0 ,'Berfungsi','Tidak Berfungsi') as rem_parkir,
            CASE
                WHEN a.rampcheck_utu_kbd = 0 THEN 'Semua Laik'
                WHEN a.rampcheck_utu_kbd = 1 THEN 'Tidak Laik Kanan'
                ELSE 'Tidak Laik Kiri'
            END as ban_depan,
            CASE
                WHEN a.rampcheck_utu_kbb = 0 THEN 'Semua Laik'
                WHEN a.rampcheck_utu_kbb = 1 THEN 'Tidak Laik Kanan'
                ELSE 'Tidak Laik Kiri'
            END as ban_belakang,
            CASE
                WHEN a.rampcheck_utu_skp = 0 THEN 'Ada dan Fungsi'
                WHEN a.rampcheck_utu_skp = 1 THEN 'Tidak Fungsi'
                ELSE 'Tidak Ada'
            END as sabuk_pengaman,
            CASE
                WHEN a.rampcheck_utu_pk = 0 THEN 'Ada dan Berfungsi'
                WHEN a.rampcheck_utu_pk = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as pengukur_kecepatan,
            CASE
                WHEN a.rampcheck_utu_pkw = 0 THEN 'Ada dan Berfungsi'
                WHEN a.rampcheck_utu_pkw = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as penghapus_kaca,
            IF(a.rampcheck_utu_pd = 0 ,'Ada','Tidak Ada') as pintu_darurat,
            IF(a.rampcheck_utu_jd = 0 ,'Ada','Tidak Ada') as jendela_darurat,
            IF(a.rampcheck_utu_apk = 0 ,'Ada','Tidak Ada') as pemecah_kaca,
            CASE
                WHEN a.rampcheck_utu_apar = 0 THEN 'Ada'
                WHEN a.rampcheck_utu_apar = 1 THEN 'Kadaluarsa'
                ELSE 'Tidak Ada'
            END as apar
            from t_rampcheck_utu a
            inner join t_rampcheck b on a.`rampcheck_id`=b.id
            where b.id='".$insertId."' and a.is_deleted=0")->getRow();

            $sistemPenunjang = $this->db->query("SELECT 
            CASE
                WHEN a.rampcheck_utp_sp_dpn = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utp_sp_dpn = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_depan,
            CASE
                WHEN a.rampcheck_utp_sp_blk = 0 THEN 'Semua Menyala'
                WHEN a.rampcheck_utp_sp_blk = 1 THEN 'Tidak Menyala Kanan'
                ELSE 'Tidak Menyala Kiri'
            END as lampu_belakang,
            IF(a.rampcheck_utp_bk_kcd = 0 ,'Baik','Kurang Baik') as kaca_depan,
            IF(a.rampcheck_utp_bk_pu = 0 ,'Baik','Kurang Baik') as pintu_utama,
            IF(a.rampcheck_utp_bk_kru = 0 ,'Sesuai','Tidak Sesuai') as rem_utama,
            CASE
                WHEN a.rampcheck_utp_bk_krp = 0 THEN 'Ada'
                WHEN a.rampcheck_utp_bk_krp = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as rem_parkir,
            IF(a.rampcheck_utp_bk_ldt = 0 ,'Baik','Keropos/Berlubang') as lantai_tangga,
            IF(a.rampcheck_utp_ktd_jtd = 0 ,'Sesuai','Tidak Sesuai') as tempat_duduk,
            CASE
                WHEN a.rampcheck_utp_pk_bc = 0 THEN 'Ada dan Laik'
                WHEN a.rampcheck_utp_pk_bc = 1 THEN 'Tidak Laik'
                ELSE 'Tidak Ada'
            END as ban_cadangan,
            IF(a.rampcheck_utp_pk_sp = 0 ,'Ada','Tidak Ada') as segitiga_pengaman,
            IF(a.rampcheck_utp_pk_dkr = 0 ,'Ada','Tidak Ada') as dongkrak,
            IF(a.rampcheck_utp_pk_pbr = 0 ,'Ada','Tidak Ada') as pembuka_roda,
            CASE
                WHEN a.rampcheck_utp_pk_ls = 0 THEN 'Ada'
                WHEN a.rampcheck_utp_pk_ls = 1 THEN 'Tidak Berfungsi'
                ELSE 'Tidak Ada'
            END as lampu_senter,
            IF(a.rampcheck_utp_pk_pgr = 0 ,'Ada','Tidak Ada') as pengganjal_roda,
            IF(a.rampcheck_utp_pk_skp = 0 ,'Ada','Tidak Ada') as sabuk_penumpang,
            IF(a.rampcheck_utp_pk_ptk = 0 ,'Ada','Tidak Ada') as kotak_p3k
            from t_rampcheck_utp a
            inner join t_rampcheck b on a.`rampcheck_id`=b.id
            where b.id='".$insertId."' and a.is_deleted=0")->getRow();

            $kesimpulan = $this->db->query("SELECT a.rampcheck_id,b.rampcheck_no,b.rampcheck_noken,json_arrayagg(CONCAT('".base_url()."/',c.document_filename)) as foto_pendukung,
            CASE
                WHEN a.rampcheck_kesimpulan_status = 0 THEN 'DIIJINKAN OPERASIONAL'
                WHEN a.rampcheck_kesimpulan_status = 1 THEN 'PERINGATAN / PERBAIKI'
                WHEN a.rampcheck_kesimpulan_status = 2 THEN 'TILANG DAN DILARANG OPERASIONAL'
            ELSE 'DILARANG OPERASIONAL'
            END as rampcheck_status,a.rampcheck_kesimpulan_catatan as kesimpulan_catatan,b.rampcheck_sticker_no,
            b.rampcheck_pengemudi as kesimpulan_nama_pengemudi,CONCAT('".base_url()."/',a.rampcheck_kesimpulan_ttd_pengemudi) as kesimpulan_ttd_pengemudi,a.rampcheck_kesimpulan_nama_penguji as kesimpulan_nama_penguji,a.rampcheck_kesimpulan_no_penguji as kesimpulan_no_penguji,CONCAT('".base_url()."/',a.rampcheck_kesimpulan_ttd_penguji) as kesimpulan_ttd_penguji,a.rampcheck_kesimpulan_nama_penyidik as kesimpulan_nama_penyidik,a.rampcheck_kesimpulan_no_penyidik as kesimpulan_no_penyidik,CONCAT('".base_url()."/',a.rampcheck_kesimpulan_ttd_penyidik) as kesimpulan_ttd_penyidik
            from t_rampcheck_kesimpulan a
            left join t_rampcheck b on a.rampcheck_id=b.id
            left join m_document_rampcheck c on b.id=c.rampcheck_id
            where b.id='".$insertId."' and a.is_deleted=0")->getRow();

            $objdata = json_decode($kesimpulan->foto_pendukung);
                        
            if(!empty($objdata[0])){
                $kesimpulan->foto_pendukung = $objdata; 
                
            }else{
                $kesimpulan->foto_pendukung = NULL;
            }   

            $resArr = [
                "data_rampcheck" => $datarampcheck,
                "data_administrasi" => $admRampcheck,
                "sistem_utama" => $sistemUtama,
                "sistem_penunjang" => $sistemPenunjang,
                "kesimpulan" => $kesimpulan
            ];

            $res['status'] = 1;
            $res['message'] = "Success";
            $res['header_rampcheck'] = $statusRampcheck->getRow();
            $res['data'] = $resArr;

            return $this->response->setJSON($res);
        } else {
            return $this->response->setJSON(res_notfound(1, 'Data Not Found'));
        }

    }

    public function historyRampcheck() {
        $data = $this->request->getPost();
        $petugasId = $data['id_petugas'];

        $query = $this->db->query("SELECT a.id as rampcheck_id,a.`created_at` as rampcheck_create,a.`rampcheck_no`,a.`rampcheck_noken`,a.rampcheck_nama_lokasi,
                                    if(b.rampcheck_kesimpulan_status=0 or b.rampcheck_kesimpulan_status=1,1,0 )as rampcheck_status_code,
                                    CASE
                                        WHEN b.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
                                        WHEN b.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
                                        WHEN b.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
                                    ELSE 'Dilarang Operasional'
                                    END as rampcheck_status
                                    from `t_rampcheck` a
                                        LEFT JOIN t_rampcheck_kesimpulan b on a.id=b.`rampcheck_id` 
                                        LEFT JOIN `m_terminal` c on a.`rampcheck_nama_lokasi`=c.id
                                    where a.is_deleted=0 and a.`created_by`='".addslashes($petugasId)."' order by a.id desc")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }

    }

    public function historyRampcheckLimit() {
        $data = $this->request->getPost();
        $petugasId = $data['id_petugas'];
        $page = $data["page"];

        //post page
        $count_per_page = 20;
        $next_offset = ($page - 1) * $count_per_page;

        $query ="SELECT a.id as rampcheck_id,a.`created_at` as rampcheck_create,a.`rampcheck_no`,a.`rampcheck_noken`,a.rampcheck_nama_lokasi,
                                    if(b.rampcheck_kesimpulan_status=0 or b.rampcheck_kesimpulan_status=1,1,0 )as rampcheck_status_code,
                                    CASE
                                        WHEN b.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
                                        WHEN b.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
                                        WHEN b.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
                                    ELSE 'Dilarang Operasional'
                                    END as rampcheck_status
                                    from `t_rampcheck` a
                                        LEFT JOIN t_rampcheck_kesimpulan b on a.id=b.`rampcheck_id` 
                                    where a.is_deleted=0 and a.`created_by`='".addslashes($petugasId)."' order by a.id desc ";


        $rows = $this->db->query($query)->getNumRows();
        $pages = ceil($rows / $count_per_page);

        
        if ($page <= $pages) {
            $resultrs = $this->db->query($query . " LIMIT " . $next_offset . "," . $count_per_page)->getResult();

            $response = [
                'status' => 1,
                'message' => count($resultrs) > 0 ? 'Success' : 'Tidak Ada Data',
                'data' => $resultrs,
                "pageInfo" => count($resultrs) > 0 ? [
                    "count" => $rows,
                    "pages" => $pages,
                    "next" => $page < $pages ? ($page + 1) : null,
                    "prev" => $page > 1 ? ($page - 1) : null
                ] : null
            ];

            return $this->response->setJSON($response);
        } else {
            $response = [
                'status' => 1,
                'message' => 'Tidak Ada Data',
                'data' => null,
                "pageInfo" => null
            ];

            return $this->response->setJSON($response);
        }

    }

    public function tos() {
        $data = $this->request->getPost();

        $res_where = [];
        !isset($data['terminal_code']) ?: $res_where['terminal_code'] = addslashes($data['terminal_code']);

        if(empty($res_where)) {
            return $this->response->setJSON(res_notfound(1, "please select data terminal_code"));
        }

        $dataToken = parent::_initTokenHubdat();
        $bearerToken = 'Bearer ' . $dataToken["access_token"];

        // filter
        $start = 0;
        $length = 20;
        $tgl_start = "&tgl_start=" . date("Y-m-d");
        $tgl_end = "&tgl_end=" .date("Y-m-d");

        $searching = "";
        foreach($res_where as $key => $value) {
            $searching .= "&" . $key . "=" . $value;
        }

        $response =  $this->APICURLGET('tos-kendaraan-tiba', $bearerToken, $start, $length, [$tgl_start, $tgl_end], $searching, true);

        $data = json_decode($response, true);

        foreach($data["data"] as $key => $value) {
            $query = $this->db->query("SELECT * from m_terminal where is_deleted=0 and terminal_code=" . "'" . $value["terminal_tujuan"] . "'")->getRow();

            $data["data"][$key]['terminal_tujuan'] = $query ? $query->terminal_name : '-';
        }

        if ($data) {
            return $this->response->setJSON(res_success(1, 'Success', $data["data"]));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Tidak Ada Data'));
        }
    }
    
    private function APICURLGET($service, $bearerToken, $start, $length, $filter = [], $search, $mergeFilter = false) {
        $url = "";
        if($mergeFilter != false) {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&short=ASC' . $filter[0] . '' . $filter[1] . $search;
        } elseif(!$filter) {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&short=ASC' . $search;
        } else {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&short=ASC' . $filter[0] . '' . $filter[1];
        }

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
            'Authorization: ' . $bearerToken
        ),
        ));

        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;
    }

    public function arterminal() {
        $data = $this->request->getPost();

        $res_where = [];
        !isset($data['terminal_code']) ?: $res_where['terminal_code'] = addslashes($data['terminal_code']);

        if(empty($res_where)) {
            $query = $this->db->query("select * from m_terminal where terminal_type = 'A' and terminal_lat IS NOT NULL and terminal_lng IS NOT NULL order by id desc");

            $resData = $query->getResult();
        } else {
            $id = res_where($res_where, 'where');
            
            $query = $this->db->query("select * from m_terminal " . $id . " and terminal_type = 'A' and terminal_lat IS NOT NULL and terminal_lng IS NOT NULL order by id desc");

            $resData = $query->getRow();
        }
        
        if ($resData) {
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Data Not Found'));
        }
    }

    public function aduan(){
        $data = $this->request->getPost();
        $aduan_email = $data['aduan_email'];
        $aduan_user_id = $data['aduan_user_id'];
        $aduan_judul = $data['aduan_judul'];
        $aduan_detail = $data['aduan_detail'];
        $aduan_lampiran = $data['aduan_lampiran'];
        $aduan_ip = $this->request->getIPAddress();

        if(!empty($aduan_lampiran) ){
            $filename1 = $this->genNamefile();
            $file1 = '/home/ngi/php/php74/transhubdat/public/uploads/aduan/'.$filename1.'.png';

            //local
            //$file1 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/ttd/'.$filename1.'.png';

            $data1 = base64_decode($aduan_lampiran);

            file_put_contents($file1, $data1);


            $fileAduan = 'public/uploads/aduan/'.$filename1.'.png';
			

		}else{
			$fileAduan = NULL;
		}

        $insertAduan = [
            'aduan_email' => $aduan_email,
            'aduan_user_id' => $aduan_user_id,
            'aduan_judul' => $aduan_judul,
            'aduan_detail' => $aduan_detail,
            'aduan_lampiran' => $fileAduan,
            'aduan_ip' => $aduan_ip
        ];

        if($this->apiModel->base_insert($insertAduan,'t_aduan')){
            return $this->response->setJSON(res_success(1, 'Success', null));
        }else{
            return $this->response->setJSON(res_notfound(0, 'Failed Insert'));
        }

    }

    public function historyAduan(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];

        $query = $this->db->query("SELECT *,CONCAT('".base_url()."/',aduan_lampiran) as aduan_image,CONCAT('".base_url()."/',aduan_reply_lampiran) as aduan_reply_image from t_aduan where aduan_user_id = '".addslashes($userId)."' ")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }

    public function atms() {
        $data = parent::_curlGETKemenhub('/api/atms?query=%22SELECT%20DISTINCT%20a.kode_tc,%20a.jenis_tc,%20a.nama,%20a.lokasi,%20a.kabupaten_kota,%20a.provinsi,%20a.lat,%20a.long,%20max(b.motor)%20AS%20motor,%20max(b.mobil)%20AS%20mobil,%20max(b.bus_kecil)%20AS%20bus_kecil,%20max(b.truck_kecil)%20AS%20truck_kecil,%20max(b.sedang)%20AS%20sedang,%20max(b.bus_besar)%20AS%20bus_besar,%20max(b.truck_besar)%20AS%20truck_besar,%20max(b.besar)%20AS%20besar,%20max(b.speed)%20AS%20speed,%20max(b.kinerja)%20AS%20kinerja,%20max(b.timestamp)%20AS%20timestamp%20FROM%20tc%20a%20LEFT%20JOIN%20messages_log_tc_jam%20b%20ON%20a.kode_tc%20=%20b.kode_tc%20WHERE%20date(timestamp)%20=%20CURRENT_DATE%20GROUP%20BY%20a.kode_tc,%20a.jenis_tc,%20a.nama,%20a.lokasi,%20a.kabupaten_kota,%20a.provinsi,%20a.lat,%20a.long%20ORDER%20BY%20b.jam%20DESC%22');

        if($data) {
            return $this->response->setJSON(res_success(1, 'Success', $data['query']));
        } else {
            return $this->response->setJSON(res_notfound(1, 'Tidak Ada Data'));
        }
    }

    public function cekLaik() {
        $data = $this->request->getPost();
        $no_ken = $data['no_registrasi_kendaraan'];

        $statusRampcheck = $this->db->query("SELECT a.rampcheck_id,b.rampcheck_link_pdf,b.rampcheck_date,b.rampcheck_no,b.rampcheck_noken,if(a.rampcheck_kesimpulan_status=0 or a.rampcheck_kesimpulan_status=1,1,0 )as rampcheck_status_code,
        CASE
            WHEN a.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
            WHEN a.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
            WHEN a.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
        ELSE 'Dilarang Operasional'
        END as rampcheck_status
        from t_rampcheck_kesimpulan a
        left join t_rampcheck b on a.rampcheck_id=b.id
        where b.rampcheck_noken='".$no_ken."' and b.is_deleted=0")->getRow();

        $statusSpionam = $this->db->query("select a.id as spionam_id,a.noken,a.no_uji,a.tgl_exp_uji,a.no_kps,a.tgl_exp_kps,a.no_srut,b.nama_perusahaan
        from m_spionam a
        left join m_perusahaan_spionam b on a.perusahaan_id = b.perusahaan_id
        where a.noken='".$no_ken."' 
        order by a.tgl_exp_kps desc limit 1")->getRow();
        
        $statusBlue = $this->db->query("
        select a.id as blue_id,a.date ,a.no_srut, a.tgl_srut, a.no_registrasi_kendaraan, a.keterangan_hasil_uji, a.masa_berlaku
        from m_blue a
            where a.is_deleted = 0
            and a.no_registrasi_kendaraan='".$no_ken."'
        UNION ALL
        select b.id as blue_id,b.date, b.no_srut, b.tgl_srut, b.no_registrasi_kendaraan, b.keterangan_hasil_uji, b.masa_berlaku
        from m_bluerfid b
            where b.is_deleted = 0
            and b.no_registrasi_kendaraan='".$no_ken."' order by date desc limit 1
        ")->getRow();


        $dataarr = [
            "data_rampcheck" => isset($statusRampcheck) ? $statusRampcheck : null,
            "data_spionam" => isset($statusSpionam) ? $statusSpionam : null,
            "data_blue" => isset($statusBlue) ? $statusBlue : null
        ];

        if(empty($dataarr)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            if($statusRampcheck == null & $statusSpionam == null && $statusBlue == null){
                return $this->response->setJSON(res_success(1, 'Data Not Found', null));
            }else{
                return $this->response->setJSON(res_success(1, 'Success', $dataarr));
            }
           
        }
        

    }


    public function popupBanner(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $event = $data['event'];

        $qBanner = $this->db->query('SELECT 
											*
										from t_popup_banner 
										where 
											popup_active=1 and 
											popup_expired > curdate() and
											popup_event = "' . $event . '"');


            $dataBanner = $qBanner->getResult();

			if (count($dataBanner) > 0) {

				$resBanner = null;

				foreach ($dataBanner as $bnr) {
					$idBanner = $bnr->id;
					$countBanner = $bnr->popup_count;

					$qBannerUser = $this->db->query("SELECT *, COUNT(*) as cn FROM t_popup_banner_user WHERE banner_user_id = " . $userId . " and banner_popup_id = " . $idBanner)->getRow();
					$jmlBannerUser = $qBannerUser->cn;

					if ($jmlBannerUser < $countBanner) {
						$resBanner = $bnr;
					}
				}

				if ($resBanner == null) {
					$ret['status'] = 1;
					$ret['message'] = 'No Banner';
					$ret['data'] = null;
					$ret['time_banner'] = null;
                    
                    
				} else {
					$insert['banner_user_id'] = $userId;
					$insert['banner_popup_id'] = $resBanner->id;

                    $this->apiModel->base_insert($insert,'t_popup_banner_user');

					$ret['status'] = 1;
					$ret['message'] = 'Success';
					$ret['data'] = $resBanner;
				}
			} else {
				$ret['status'] = 1;
				$ret['message'] = 'No Active Banner';
				$ret['data'] = null;
				$ret['time_banner'] = null;
			}
            return $this->response->setJSON($ret);
    }



    public function bannerTicket(){
        $query = $this->db->query("SELECT * from t_banner_ticket where is_deleted=0 order by created_at desc limit 1")->getRow();
       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        } 
    }

    public function faqTicket(){
        $query = $this->db->query("SELECT * from m_faq_ticket where is_deleted=0  and faq_active=1 order by id asc")->getResult();
       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        } 
    }

    public function searchLocation(){
        $data = $this->request->getPost();
        $search = $data['search'];

        $query = $this->db->query("SELECT b.id as id_kabkota,b.kabkota,
        json_arrayagg((json_object('id_terminal',a.id,'terminal_name',a.terminal_name,'id_kabkota',b.id,'terminal_address',a.terminal_address))) as data_terminal from m_terminal a
        left join m_lokabkota b on a.idkabkota=b.id
        where b.kabkota like '%".$search."%' or a.terminal_name like '%".$search."%' group by b.id");

        $resData = $query->getResult();

       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            foreach ($resData as $obj) {

                $objcat = json_decode($obj->data_terminal);
    
                if ($objcat[0]->id_terminal == '') {
                    $obj->data_terminal = null;
                } else {
                    $obj->data_terminal = $objcat;
                }
            }
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } 

    }

    public function ehubdatMenu(){
        $data = $this->request->getPost();

        $query = $this->db->query("SELECT a.id as menu_id,a.menu_name,a.menu_order,a.menu_active,
        json_arrayagg((json_object('id_menu',a.id,'id_sub_menu',b.id,'sub_menu_name',b.sub_menu_name,'sub_menu_url',b.sub_menu_url,'sub_menu_order',b.sub_menu_order,'sub_menu_active',b.sub_menu_active))) as data_submenu
        from m_ehubdat_menu a
        left join m_ehubdat_sub_menu b on a.id=b.id_menu
        group by a.id order by a.menu_order,b.sub_menu_order asc
        ");

        $resData = $query->getResult();

       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            foreach ($resData as $obj) {

                $objcat = json_decode($obj->data_submenu);
    
                if ($objcat[0]->id_sub_menu == '') {
                    $obj->data_submenu = null;
                } else {
                    $obj->data_submenu = $objcat;
                }
            }
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } 

    }

    public function listTicket(){
        $data = $this->request->getPost();
        $location = $data['location'];

        $query = $this->db->query("");
        
    }

    //mudik

    public function bannerTicketMudik(){
        $query = $this->db->query("SELECT * from t_banner_ticket_mudik where is_deleted=0 order by created_at desc limit 1")->getRow();
       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        } 
    }

    public function faqTicketMudik(){
        $query = $this->db->query("SELECT * from m_faq_ticket_mudik where is_deleted=0  and faq_active=1 order by id asc")->getResult();
       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        } 
    }


    public function searchLocationMudik(){
        $data = $this->request->getPost();
        $search = $data['search'];

        $query = $this->db->query("SELECT * from (SELECT b.id as route_id,a.id as jadwal_id,b.terminal_from_id as terminal_id,c.terminal_name,c.id as id_kabkota,d.kabkota,c.terminal_address from t_jadwal_mudik a
        LEFT JOIN m_route b on a.jadwal_route_id=b.id
        LEFT JOIN m_terminal c on b.terminal_from_id = c.id
        LEFT JOIN m_lokabkota d on c.`idkabkota`=d.id
        where b.terminal_from_id is not null and b.kategori_angkutan_id=5 and a.is_deleted=0 and b.is_deleted=0 and open=1 GROUP BY c.id
        UNION ALL
        SELECT b.id as route_id,a.id as jadwal_id,b.terminal_to_id as terminal_id,c.terminal_name,c.id as id_kabkota,d.kabkota,c.terminal_address from t_jadwal_mudik a
        LEFT JOIN m_route b on a.jadwal_route_id=b.id
        LEFT JOIN m_terminal c on b.terminal_to_id = c.id
        LEFT JOIN m_lokabkota d on c.`idkabkota`=d.id
        where b.terminal_to_id is not null and b.kategori_angkutan_id=5 and a.is_deleted=0 and b.is_deleted=0 and a.open=1 GROUP BY c.id) a
        where a.kabkota like  '%$search%'  or a.terminal_name  like  '%$search%'  group by a.id_kabkota order by a.id_kabkota asc");
        // $query = $this->db->query("SELECT * from (SELECT b.terminal_from_id as terminal_id,c.terminal_name,c.id as id_kabkota,d.kabkota,c.terminal_address from t_jadwal_mudik a
        // LEFT JOIN m_route b on a.jadwal_route_id=b.id
        // LEFT JOIN m_terminal c on b.terminal_from_id = c.id
        // LEFT JOIN m_lokabkota d on c.`idkabkota`=d.id
        // where b.terminal_from_id is not null and b.kategori_angkutan_id=5 GROUP BY b.terminal_from_id
        // UNION ALL
        // SELECT b.terminal_to_id as terminal_id,c.terminal_name,c.id as id_kabkota,d.kabkota,c.terminal_address from t_jadwal_mudik a
        // LEFT JOIN m_route b on a.jadwal_route_id=b.id
        // LEFT JOIN m_terminal c on b.terminal_to_id = c.id
        // LEFT JOIN m_lokabkota d on c.`idkabkota`=d.id
        // where b.terminal_to_id is not null and b.kategori_angkutan_id=5 GROUP BY b.terminal_to_id) a
        // where a.kabkota like '%$search%' or a.terminal_name  like '%$search%' group by a.id_kabkota order by a.terminal_name asc ");


        $resData = $query->getResult();

       
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Jadwal Tidak Tersedia"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } 

    }

    public function listTicketMudik(){
        $data = $this->request->getPost();
        // $dateDeparture = $data['departure_date'];
        $terminalDepart = $data['terminal_depart'];
        $terminalArrived = $data['terminal_arrived'];
        $sortBy = $data['sort_by'];

        $order = "";
        if($sortBy == '1'){ 
            // Keberangkatan Paling Awal 
            $order .= "order by a.jadwal_date_depart asc , a.jadwal_time_depart asc";
        }elseif($sortBy == '2'){ //Keberangkatan Paling Akhir
            $order .= "order by a.jadwal_date_depart desc , a.jadwal_time_depart desc";
        }elseif($sortBy == '3'){//Kedatangan Paling Awal
            $order .= "order by a.jadwal_date_arrived asc , a.jadwal_time_arrived asc";
        }else{
            $order .= "order by a.jadwal_date_arrived desc , a.jadwal_time_arrived desc";
        }

        $query = $this->db->query("SELECT a.id as jadwal_id,
                    c.id as po_id,
                    c.po_name,
                    CONCAT('".base_url()."/',c.po_logo) as po_logo,
                    b.id as armada_id,
                    b.armada_name,
                    b.armada_label,
                    b.armada_code,
                    d.class_name,
                    a.jadwal_date_depart,
                    a.jadwal_time_depart,
                    a.jadwal_date_arrived,
                    a.jadwal_time_arrived,
                    ROUND(TIME_TO_SEC(timediff(CONCAT(a.jadwal_date_arrived,' ',a.jadwal_time_arrived),CONCAT(a.jadwal_date_depart,' ',a.jadwal_time_depart)))/60) as route_time_minutes,
                    REPLACE(e.route_distance,' Km','') as route_distance_km,
                    i.kabkota as kota_arrived,
                    f.`terminal_name` as terminal_depart,
                    g.terminal_name as terminal_arrived,
                    h.`kabkota` as kota_depart,
                    j.seat_map_capacity,
                    IFNULL(count(k.jadwal_id),0) as seat_use,
                    j.seat_map_capacity-IFNULL(count(k.jadwal_id),0) as seat_existing,
                    a.jadwal_type as jadwal_type_mudik
        from t_jadwal_mudik a
            left join m_armada_mudik b on a.jadwal_armada_id=b.id
            left join m_po c on b.po_id=c.id
            left join m_class d on b.po_class_id=d.id
            left join m_route e on a.jadwal_route_id=e.id
            left join m_terminal f on e.terminal_from_id=f.id
            left join m_terminal g on e.terminal_to_id=g.id
            left join m_lokabkota h on f.idkabkota=h.id
            left join m_lokabkota i on g.idkabkota=i.id
            left join m_seat_map j on b.`armada_sheet_id`=j.id
            left join (SELECT jadwal_id  from t_jadwal_seat_mudik where seat_map_use=1) k on k.jadwal_id=a.id
        where (a.is_deleted=0 and e.`terminal_from_id`=?  and e.`terminal_to_id`=? and a.open='1' and a.open_at is not null and a.open_at<=NOW()) 
        group by a.id  " . $order . "",array($terminalDepart,$terminalArrived));
        // echo $this->db->getLastQuery();
        $resData = $query->getResult();
        $datarow = $query->getRow();
            
        if(empty($datarow->jadwal_id)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $resData));
        } 
        

    }

    public function dataPenumpangMudik(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];

        $query  = $this->db->query("SELECT a.billing_user_id,b.billing_id, json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang from t_billing_mudik a 
        left join t_transaction_mudik b on a.id=b.billing_id
        where a.billing_user_id='".$userId."' and a.billing_status_payment=1  and b.is_verified != 2 group by a.billing_code");

        $resData = $query->getRow();

        if(empty($resData->billing_id)){
            return $this->response->setJSON(res_notfound(2, "Anda belum melakukan transaksi untuk arus mudik"));
        }else{

    
            $objcat = json_decode($resData->data_penumpang);

            usort($objcat, fn($a, $b) => strcmp($a->transaction_id, $b->transaction_id));

            if ($objcat[0]->transaction_id == '') {
                $resData->data_penumpang = null;
            } else {
                $resData->data_penumpang = $objcat;
            }

            $jml = count($objcat);

            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' => $resData,
                'config_quota' => $jml
            ];
            return $this->response->setJSON($response);

        } 

    }

    public function detailTicket(){
        $data = $this->request->getPost();
        $jadwalID = $data['jadwal_id'];

        $query = $this->db->query("SELECT *, json_array(CONCAT('Kapasitas kursi ',a.seat_map_capacity) ,CONCAT('Format kursi ',a.seat_format),a.armada_merk) as bus_spesifikasi from (
            SELECT a.id as jadwal_id,b.armada_name,b.armada_merk,b.armada_label,CONCAT('".base_url()."/',d.po_logo) as po_logo,d.po_name,d.po_description,
                concat_ws('','".base_url()."/',b.armada_image) as armada_image,b.armada_plat_number,b.armada_code,e.class_name,f.seat_map_capacity,
                CONCAT(f.seat_map_left,'-',f.seat_map_right) as seat_format,a.jadwal_date_depart,a.jadwal_time_depart,
                a.jadwal_date_arrived,a.jadwal_time_arrived,
                ROUND(TIME_TO_SEC(timediff(CONCAT(a.jadwal_date_arrived,' ',a.jadwal_time_arrived),CONCAT(a.jadwal_date_depart,' ',a.jadwal_time_depart)))/60) as route_time_minutes,
                REPLACE(c.route_distance,' Km','') as route_distance_km,
                g.terminal_name as terminal_depart,h.terminal_name as terminal_arrived,k.kabkota as kota_depart,l.kabkota as kota_arrived,
                CONCAT(g.terminal_lat,', ',g.terminal_lng) as terminal_depart_point,CONCAT(h.terminal_lat,', ',h.terminal_lng) as terminal_arrived_point,
                g.terminal_address as terminal_address_depart,h.terminal_address as terminal_address_arrived,
                json_arrayagg((json_object('fasilitas_name',j.name,'fasilitas_icon',j.icon))) as fasilitas,
                0 as is_laik
                from t_jadwal_mudik a
                LEFT JOIN m_armada_mudik b on a.jadwal_armada_id=b.id
                LEFT JOIN m_route c on a.jadwal_route_id=c.id
                LEFT JOIN m_po d on b.po_id=d.id
                LEFT JOIN m_class e on b.po_class_id=e.id
                LEFT JOIN m_seat_map f on b.armada_sheet_id=f.id
                LEFT JOIN m_terminal g on c.terminal_from_id=g.id
                LEFT JOIN m_terminal h on c.terminal_to_id=h.id
                LEFT JOIN m_armada_mudik_fasilities i on a.jadwal_armada_id=i.armada_mudik_id
                LEFT JOIN m_facilities j on i.facilities_id=j.id and j.is_deleted=0 
                LEFT join m_lokabkota k on g.idkabkota=k.id
                LEFT join m_lokabkota l on h.idkabkota=l.id
                where a.id='".$jadwalID."' ) a ");

                

        $resData = $query->getRow();

      

        if(empty($resData->jadwal_id)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{

            $objBus = json_decode($resData->bus_spesifikasi);
            $objcat = json_decode($resData->fasilitas);

            if ($objcat[0]->fasilitas_name == null) {
                $resData->fasilitas = null;
            } else {
                $resData->fasilitas = $objcat;
            }

            $resData->bus_spesifikasi = $objBus; 
            
            return $this->response->setJSON(res_success(1, 'Success', $resData));

        } 
    }

    public function seatmapMudik(){
        $data = $this->request->getPost();
        $jadwalID = $data['jadwal_id'];
        
        $quota = $this->db->query("SELECT config_quota from s_config_quota_mudik where config_active=1")->getRow();

        $query = $this->db->query("SELECT json_arrayagg((json_object('jadwal_id',a.jadwal_id,'id_seat',a.id,'seat_map_id',a.seat_map_id,'seat_map_detail_name',a.seat_map_detail_name,'seat_map_use',a.seat_map_use))) as data_seat from t_jadwal_seat_mudik a
        where a.jadwal_id = '".$jadwalID."' group by a.seat_group_baris order by a.id");

        $dataseat = $this->db->query("SELECT b.seat_map_left,b.seat_map_right,b.seat_map_row,b.seat_map_last,b.seat_map_capacity from t_jadwal_seat_mudik a
        inner join m_seat_map b on a.seat_map_id=b.id where a.jadwal_id = '".$jadwalID."'  group by a.seat_map_id")->getRow();

         $resData = $query->getResult();

            
         if(empty($query)){
             return $this->response->setJSON(res_notfound(1, "Data Not Found"));
         }else{
            foreach ($resData as $obj) {

                $objcat = json_decode($obj->data_seat);

                usort($objcat, fn($a, $b) => strcmp($a->seat_map_detail_name, $b->seat_map_detail_name));
        
                if ($objcat[0]->id_seat == '') {
                    $obj->data_seat = null;
                } else {
                    $obj->data_seat = $objcat;
                }
            }
            
            return $this->response->setJSON(res_success_custom1(1, 'Success','config_quota',$quota->config_quota,'master_seat',$dataseat,$resData));
         } 
          
    }


    public function transactionMudik(){
        $this->db->transStart();
        header('Content-Type: application/json');
        $dataTrx = file_get_contents('php://input');
        $arrDataTrx = json_decode($dataTrx);
        $currentDate = $this->db->query("SELECT (NOW() + INTERVAL 10 MINUTE) as expired_trx")->getRow();
    
        $isInsert = false;
    
        $insertBilling['biliing_amount']  = 0;
        $insertBilling['billing_user_id'] = $arrDataTrx->user_mobile_id;
        $insertBilling['billing_expired_date'] = $currentDate->expired_trx;   
        $insertBilling['billing_jadwal_id'] = $arrDataTrx->jadwal_id;
        $insertBilling['billing_qty'] = count($arrDataTrx->ticket_detail);

        //cek tipe arus balik / arus mudik
        $jadwalMudik = $this->db->query("SELECT id,jadwal_type,open as jadwal_open from t_jadwal_mudik where id='".$arrDataTrx->jadwal_id."'")->getRow();
        
        //cek data pemudik sudah melakukan pembayaran atau transaksinya masih aktif belum terbayarkan
        $dataBuyer = $this->db->query("SELECT a.*,json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang FROM t_billing_mudik a 
        LEFT JOIN t_transaction_mudik b on a.id=b.billing_id
        where a.billing_user_id = '".$arrDataTrx->user_mobile_id."'  and (a.billing_status_payment=1 or now() < a.billing_expired_date ) ")->getRow();

        //flow untuk arus mudik
        if($jadwalMudik->jadwal_type == 1){

            if(empty($dataBuyer->id)){ //ketika belum melakukan sama sekali transaksi
               
            try{
                
                $this->db->table('t_billing_mudik')->insert($insertBilling);
                $billingId = $this->db->insertID();
                $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
        
                foreach ($arrDataTrx->ticket_detail as $key => $value) {
        
                    $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                    left join t_billing_mudik b on a.`billing_id`=b.id
                    where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
        
                    $cekNik = $this->db->query("SELECT a.transaction_nik from t_transaction_mudik a
                    left join t_billing_mudik b on a.billing_id=b.id
                    where a.transaction_nik='".$value->transaction_nik."' and b.billing_status_payment='1'")->getRow();
                    //pengecekan jika NIK sudah dipakai oleh pemudik lain
                    if(empty($cekNik->transaction_nik)){
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
                            // $inserttrx['billing_verif_expired_date'] = $maxdateverif;
                        
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
        
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                            
                        }
        
                    }else{
                        $response = [
                            'status' => 0,
                            'message' => 'NIK '.$cekNik->transaction_nik.' sudah terdaftar penumpang arus mudik'
                        ];
                        return $this->response->setJSON($response);
        
        
                    }
                    
                }

            } catch (\Exception $e) {
                if ($e->getCode() === 500) {
                
                }
                $response = [
                    'status' => 0,
                    'message' => 'NIK yang anda masukan sama,mohon cek kembali'
                ];
                return $this->response->setJSON($response);

                exit($e->getMessage());
            }


           
            }else{
                //jika sudah pernah melakukan transaksi
                if($dataBuyer->billing_status_payment == '1' || $dataBuyer->billing_expired_date  >= date('Y-m-d H:i:s')){ //|| $dataBuyer->billing_expired_date  >= date('Y-m-d H:i:s')
                        
                    $response = [
                        'status' => 3,
                        'message' => 'Akun anda sudah pernah melakukan transaksi pemesanan'
                    ];
                    return $this->response->setJSON($response);
                }else{
                try{
                    $this->db->table('t_billing_mudik')->insert($insertBilling);
                    $billingId = $this->db->insertID();
                    $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
        
                    foreach ($arrDataTrx->ticket_detail as $key => $value) {
                        
                    $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                    left join t_billing_mudik b on a.`billing_id`=b.id
                    where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
    
                    $cekNik = $this->db->query("SELECT a.transaction_nik from t_transaction_mudik a
                    left join t_billing_mudik b on a.billing_id=b.id
                    where a.transaction_nik='".$value->transaction_nik."' and b.billing_status_payment='1'")->getRow();
    
                    if(empty($cekNik->transaction_nik)){
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
            
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
            
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                        
                        }
    
                    }else{
    
                        $response = [
                            'status' => 0,
                            'message' => 'NIK '.$cekNik->transaction_nik.' sudah terdaftar penumpang arus mudik'
                        ];
                        return $this->response->setJSON($response);
        
    
                    }
     
                    }

                } catch (\Exception $e) {
                    if ($e->getCode() === 500) {
                    
                    }
                    $response = [
                        'status' => 0,
                        'message' => 'NIK yang anda masukan sama,mohon cek kembali'
                    ];
                    return $this->response->setJSON($response);

                    exit($e->getMessage());
                }
        
                }
            }
        //end of arus mudik
        }else{
            //flow untuk arus balik
            $cekdataMudik  = $this->db->query("SELECT a.billing_user_id,b.billing_id, json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang from t_billing_mudik a 
            left join t_transaction_mudik b on a.id=b.billing_id
            where a.billing_user_id='".$arrDataTrx->user_mobile_id."' and a.billing_status_payment=1 ")->getRow();
    
        
    
            if(empty($cekdataMudik->billing_id)){
                return $this->response->setJSON(res_notfound(2, "Anda belum melakukan transaksi untuk arus mudik"));
            }else{
                if(empty($dataBuyer->id)){
                    
                    $this->db->table('t_billing_mudik')->insert($insertBilling);
                    $billingId = $this->db->insertID();
                    $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
            
                    foreach ($arrDataTrx->ticket_detail as $key => $value) {
            
                        $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                        left join t_billing_mudik b on a.`billing_id`=b.id
                        where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
            
        
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
                            // $inserttrx['billing_verif_expired_date'] = $maxdateverif;
                        
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
        
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                            
                        }
            
                        
                    }
                    
                }else{
                    $cekTrxBalik  = $this->db->query("SELECT a.billing_user_id,b.billing_id,a.billing_status_payment,a.billing_expired_date, json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang from t_billing_mudik a 
                    left join t_transaction_mudik b on a.id=b.billing_id
                    left join t_jadwal_mudik c on a.billing_jadwal_id=c.id
                    where a.billing_user_id='".$arrDataTrx->user_mobile_id."' and a.billing_status_payment=1 and c.jadwal_type=2")->getRow();
                
                    if($cekTrxBalik->billing_status_payment == '1' || $cekTrxBalik->billing_expired_date  >= date('Y-m-d H:i:s')){ //|| $dataBuyer->billing_expired_date  >= date('Y-m-d H:i:s')
                            
                        $response = [
                            'status' => 3,
                            'message' => 'Akun anda sudah pernah melakukan pesanan'
                        ];
                        return $this->response->setJSON($response);
                    }else{
                        $this->db->table('t_billing_mudik')->insert($insertBilling);
                        $billingId = $this->db->insertID();
                        $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
            
                        foreach ($arrDataTrx->ticket_detail as $key => $value) {
                            
                        $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                        left join t_billing_mudik b on a.`billing_id`=b.id
                        where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
        
                      
        
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
            
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
            
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                        
                        }
        
    
         
                        }
            
                    }
                }
            }

           
        }
                
       
            
    
        if ($this->db->transStatus() === FALSE) {
            $iscommit = false;
            $this->db->transRollback();
        } else {
            $iscommit = true;
            $this->db->transCommit();
        }
    
        if ($iscommit === true) {
            $resdata = $this->db->query("SELECT billing_code,billing_expired_date,NOW() as date_server from t_billing_mudik where id='".$billingId."' ")->getRow();
    
            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' => $resdata
            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'Terjadi Kesalahan Server'
            ];
        }
    
        return $this->response->setJSON($response);
    
        
    }

    public function errorhandler()
	{
		$error = $this->db->error();
		return $error['message'];
	}

    public function transactionMudik_dev(){
        $this->db->transStart();
        header('Content-Type: application/json');
        $dataTrx = file_get_contents('php://input');
        $arrDataTrx = json_decode($dataTrx);
        $currentDate = $this->db->query("SELECT (NOW() + INTERVAL 10 MINUTE) as expired_trx")->getRow();
    
        $isInsert = false;
    
        $insertBilling['biliing_amount']  = 0;
        $insertBilling['billing_user_id'] = $arrDataTrx->user_mobile_id;
        $insertBilling['billing_expired_date'] = $currentDate->expired_trx;   
        $insertBilling['billing_jadwal_id'] = $arrDataTrx->jadwal_id;
        $insertBilling['billing_qty'] = count($arrDataTrx->ticket_detail);
    
        $dataBuyer = $this->db->query("SELECT a.*,json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang FROM t_billing_mudik a 
        LEFT JOIN t_transaction_mudik b on a.id=b.billing_id
        where a.billing_user_id = '".$arrDataTrx->user_mobile_id."'  and (a.billing_status_payment=1 or now() < a.billing_expired_date ) ")->getRow();

        $jadwalMudik = $this->db->query("SELECT id,jadwal_type,open as jadwal_open from t_jadwal_mudik where id='".$arrDataTrx->jadwal_id."'")->getRow();

        if($jadwalMudik->jadwal_type == 1){

            if(empty($dataBuyer->id)){
                try{
                $this->db->table('t_billing_mudik')->insert($insertBilling);
                $billingId = $this->db->insertID();
                $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
        
                foreach ($arrDataTrx->ticket_detail as $key => $value) {
        
                    $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                    left join t_billing_mudik b on a.`billing_id`=b.id
                    where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
        
                    $cekNik = $this->db->query("SELECT a.transaction_nik from t_transaction_mudik a
                    left join t_billing_mudik b on a.billing_id=b.id
                    where a.transaction_nik='".$value->transaction_nik."' and b.billing_status_payment='1'")->getRow();
                    
                    if(empty($cekNik->transaction_nik)){
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
                            // $inserttrx['billing_verif_expired_date'] = $maxdateverif;
                        
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
        
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                            
                        }
        
                    }else{
                        $response = [
                            'status' => 0,
                            'message' => 'NIK '.$cekNik->transaction_nik.' sudah terdaftar penumpang arus mudik'
                        ];
                        return $this->response->setJSON($response);
        
        
                    }
                    
                }

                } catch (\Exception $e) {
                    if ($e->getCode() === 500) {
                    
                    }
                    $response = [
                        'status' => 0,
                        'message' => 'NIK tidak boleh sama'
                    ];
                    return $this->response->setJSON($response);

                    exit($e->getMessage());
                }


                
            }else{
            
                if($dataBuyer->billing_status_payment == '1' || $dataBuyer->billing_expired_date  >= date('Y-m-d H:i:s')){ //|| $dataBuyer->billing_expired_date  >= date('Y-m-d H:i:s')
                        
                    $response = [
                        'status' => 2,
                        'message' => 'Akun anda sudah melakukan transaksi'
                    ];
                    return $this->response->setJSON($response);
                }else{
                try{
                    $this->db->table('t_billing_mudik')->insert($insertBilling);
                    $billingId = $this->db->insertID();
                    $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
        
                    foreach ($arrDataTrx->ticket_detail as $key => $value) {
                        
                    $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                    left join t_billing_mudik b on a.`billing_id`=b.id
                    where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
    
                    $cekNik = $this->db->query("SELECT a.transaction_nik from t_transaction_mudik a
                    left join t_billing_mudik b on a.billing_id=b.id
                    where a.transaction_nik='".$value->transaction_nik."' and b.billing_status_payment='1'")->getRow();
    
                    if(empty($cekNik->transaction_nik)){
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
            
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
            
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                        
                        }
    
                    }else{
    
                        $response = [
                            'status' => 0,
                            'message' => 'NIK '.$cekNik->transaction_nik.' sudah terdaftar penumpang arus mudik'
                        ];
                        return $this->response->setJSON($response);
        
    
                    }
     
                    }

                } catch (\Exception $e) {
                    if ($e->getCode() === 500) {
                    
                    }
                    $response = [
                        'status' => 0,
                        'message' => 'NIK tidak boleh sama'
                    ];
                    return $this->response->setJSON($response);

                    exit($e->getMessage());
                }
        
                }
            }

        }else{
            $cekdataMudik  = $this->db->query("SELECT a.billing_user_id,b.billing_id, json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang from t_billing_mudik a 
            left join t_transaction_mudik b on a.id=b.billing_id
            where a.billing_user_id='".$arrDataTrx->user_mobile_id."' and a.billing_status_payment=1 ")->getRow();
    
        
    
            if(empty($cekdataMudik->billing_id)){
                return $this->response->setJSON(res_notfound(2, "Anda belum melakukan transaksi untuk arus mudik"));
            }else{
                if(empty($dataBuyer->id)){
                    
                    $this->db->table('t_billing_mudik')->insert($insertBilling);
                    $billingId = $this->db->insertID();
                    $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
            
                    foreach ($arrDataTrx->ticket_detail as $key => $value) {
            
                        $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                        left join t_billing_mudik b on a.`billing_id`=b.id
                        where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
            
        
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
                            // $inserttrx['billing_verif_expired_date'] = $maxdateverif;
                        
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
        
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                            
                        }
            
                        
                    }
                    
                }else{
                    $cekTrxBalik  = $this->db->query("SELECT a.billing_user_id,b.billing_id,a.billing_status_payment,a.billing_expired_date, json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name))) as data_penumpang from t_billing_mudik a 
                    left join t_transaction_mudik b on a.id=b.billing_id
                    left join t_jadwal_mudik c on a.billing_jadwal_id=c.id
                    where a.billing_user_id='".$arrDataTrx->user_mobile_id."' and a.billing_status_payment=1 and c.jadwal_type=2")->getRow();
                
                    if($cekTrxBalik->billing_status_payment == '1' || $cekTrxBalik->billing_expired_date  >= date('Y-m-d H:i:s')){ //|| $dataBuyer->billing_expired_date  >= date('Y-m-d H:i:s')
                            
                        $response = [
                            'status' => 2,
                            'message' => 'Akun anda sudah melakukan transaksi'
                        ];
                        return $this->response->setJSON($response);
                    }else{
                        $this->db->table('t_billing_mudik')->insert($insertBilling);
                        $billingId = $this->db->insertID();
                        $dataBilling = $this->db->query("SELECT * FROM t_billing_mudik where id = '".$billingId."' ")->getRow();
            
                        foreach ($arrDataTrx->ticket_detail as $key => $value) {
                            
                        $cekTransaction = $this->db->query("SELECT transaction_seat_id,billing_id,billing_status_payment,billing_expired_date from t_transaction_mudik a 
                        left join t_billing_mudik b on a.`billing_id`=b.id
                        where transaction_seat_id='". $value->transaction_seat_id."' and (billing_status_payment=1 or billing_expired_date > NOW()) group by billing_id")->getRow();
        
                      
        
                        if(empty($cekTransaction)){
                            $inserttrx['billing_id']        = $billingId;
                            $inserttrx['billing_code']      = $dataBilling->billing_code;
                            $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                            $inserttrx['transaction_nik']  = $value->transaction_nik;
                            $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                            $inserttrx['transaction_amount'] = 0;
            
                            $this->db->table('t_transaction_mudik')->insert($inserttrx);
            
                        }else{
                            if($cekTransaction->billing_status_payment == 1 || $cekTransaction->billing_expired_date >= date('Y-m-d H:i:s')){
                                $response = [
                                    'status' => 2,
                                    'message' => 'Kursi telah terisi'
                                ];
                                return $this->response->setJSON($response);
                                
                            }else{
                                $inserttrx['billing_id']        = $billingId;
                                $inserttrx['billing_code']      = $dataBilling->billing_code;
                                $inserttrx['transaction_seat_id']  = $value->transaction_seat_id;
                                $inserttrx['transaction_nik']  = $value->transaction_nik;
                                $inserttrx['transaction_booking_name']  = $value->transaction_booking_name;
                                $inserttrx['transaction_amount'] = 0;
                            
                                $this->db->table('t_transaction_mudik')->insert($inserttrx);
                            }
                        
                        }
        
    
         
                        }
            
                    }
                }
            }

           
        }
                
       
            
    
        if ($this->db->transStatus() === FALSE) {
            $iscommit = false;
            $this->db->transRollback();
        } else {
            $iscommit = true;
            $this->db->transCommit();
        }
    
        if ($iscommit === true) {
            $resdata = $this->db->query("SELECT billing_code,billing_expired_date,NOW() as date_server from t_billing_mudik where id='".$billingId."' ")->getRow();
    
            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' => $resdata
            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'Terjadi Kesalahan Server'
            ];
        }
    
        return $this->response->setJSON($response);
    
        
    }

    public function formPaymentMudik(){
        $data = $this->request->getPost();
        $billingCode = $data['billing_code'];

        $query = $this->db->query("SELECT a.id as id_billing,a.billing_code,a.billing_qty,
        JSON_OBJECT('expired_date', DATE_FORMAT(a.billing_expired_date,'%Y-%m-%d %H:%i:%s'), 'server_date', DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s')) as date_master,
        f.id as po_id,f.po_name, CONCAT('".base_url()."/',f.po_logo) as po_logo,e.id as armada_id,e.armada_name,e.armada_code,e.armada_label,g.class_name,d.jadwal_date_depart,d.jadwal_date_arrived,
        d.jadwal_time_depart,d.jadwal_time_arrived,
        ROUND(TIME_TO_SEC(timediff(CONCAT(d.jadwal_date_arrived,' ',d.jadwal_time_arrived),CONCAT(d.jadwal_date_depart,' ',d.jadwal_time_depart)))/60) as route_time_minutes,
        REPLACE(h.route_distance,' Km','') as route_distance_km,k.kabkota as kota_depart,l.kabkota as kota_arrived,
        i.terminal_name as terminal_depart,j.terminal_name as terminal_arrived,c.user_mobile_name,c.user_mobile_email,c.user_mobile_phone,
        json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name,'seat_map_name',m.seat_map_detail_name))) as data_penumpang
         from t_billing_mudik a
        LEFT JOIN t_transaction_mudik b on a.id=b.billing_id
        LEFT JOIN m_user_mobile c on a.billing_user_id=c.id
        LEFT JOIN t_jadwal_mudik d on a.billing_jadwal_id=d.id
        LEFT JOIN m_armada_mudik e on d.jadwal_armada_id=e.id
        LEFT JOIN m_po f on e.po_id=f.id
        LEFT JOIN m_class g on e.po_class_id=g.id
        LEFT JOIN m_route h on d.jadwal_route_id=h.id
        LEFT JOIN m_terminal i on h.terminal_from_id=i.id
        LEFT JOIN m_terminal j on h.terminal_to_id=j.id
        LEFT JOIN m_lokabkota k on i.idkabkota=k.id
        LEFT JOIN m_lokabkota l on j.idkabkota=l.id
        LEFT JOIN t_jadwal_seat_mudik m on b.transaction_seat_id=m.id
        WHERE a.billing_code='".$billingCode."'");

        $voucher = $this->db->query("SELECT promo_code from m_promo_mudik where promo_active=1")->getRow();

         $resData = $query->getRow();

        if(empty($resData->id_billing)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{

            $objdate = json_decode($resData->date_master);
            $objcat = json_decode($resData->data_penumpang);

            usort($objcat, fn($a, $b) => strcmp($a->transaction_id, $b->transaction_id));
        
            if ($objcat[0]->transaction_id == '') {
                $resData->data_penumpang = null;
            } else {
                $resData->data_penumpang = $objcat;
            }
            
           
            $resData->date_master = $objdate;
            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' => $resData,
                'voucher_code' => $voucher->promo_code
            ];

            return $this->response->setJSON($response);
        
        } 

    }

    public function cancelTransactionMudik(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $billing_code = $data['billing_code'];
        $jadwal_id = $data['jadwal_id'];

        $query = $this->db->query("SELECT billing_code,billing_user_id,billing_status_payment,billing_expired_date,NOW() as date_now from t_billing_mudik where billing_code = '".$billing_code."'  and billing_user_id='".$userId."'  and billing_jadwal_id='".$jadwal_id."' ")->getRow();

        if(empty($query->billing_code)){

            return $this->response->setJSON(res_notfound(2, "Data Billing Tidak Ada"));

        }else{
            if($query->billing_user_id == $userId){
                if($query->billing_status_payment == 1){
                    return $this->response->setJSON(res_notfound(2, "Tidak dapat dibatalkan karena tiket sudah dibayarkan"));
                }else{
                    if($query->date_now >= $query->billing_expired_date){
                        return $this->response->setJSON(res_notfound(2, "Tiket Anda Sudah Expired"));
                    }else{
                        $update = $this->db->query("update t_billing_mudik set billing_cancel = 1,billing_expired_date=NULL where billing_code='".$billing_code."'");

                        return $this->response->setJSON(res_success(1, 'Success',NULL));
                    }
                }

            }else{
                return $this->response->setJSON(res_notfound(2, "Data Billing & User Not Match"));
            }
           
        }


    }

    public function paymentTransactionMudik(){
        $data = $this->request->getPost();
        $jadwal_id = $data['jadwal_id'];
        $voucher = $data['voucher'];
        $billing_code = $data['billing_code'];
        $userId = $data['user_mobile_id'];


        $cekVoucher = $this->db->query("SELECT * from m_promo_mudik ")->getRow();
        $cekBilling = $this->db->query(" SELECT a.billing_code,a.billing_expired_date,b.jadwal_type from t_billing_mudik a 
        LEFT JOIN t_jadwal_mudik b on a.billing_jadwal_id=b.id
        where a.billing_code = '".$billing_code."'")->getRow();
        

        $maxVerifikasi = $this->db->query("SELECT date(max_date_expired) as max_date_expired,arus,keterangan,date(now()) as date_now,DATEDIFF(date(max_date_expired),date(now())) as date_diff,DATE_ADD(DATE(NOW()), INTERVAL 7 Day) as expired_verif_normal from s_config_verifikasi_mudik where arus='".$cekBilling->jadwal_type."'")->getRow();
        $maxdateverif = $maxVerifikasi->max_date_expired;
        $datenow = $maxVerifikasi->date_now;
        $datediff = $maxVerifikasi->date_diff;
        $dateverifnormal = $maxVerifikasi->expired_verif_normal;


        if($cekBilling->jadwal_type == 1){
            if($datediff <= 7){

                $dateExpiredVerif = $maxdateverif;
            
            }else{
                $dateExpiredVerif = $dateverifnormal;
            }    
        }else{

            $dateExpiredVerif = $maxdateverif;

        }
       
        if($cekVoucher->promo_active == 1){
            if($cekBilling->billing_code == $billing_code){
                if($cekVoucher->promo_code == $voucher){
                    $pemesan = $this->db->query("SELECT * from t_billing_mudik where billing_user_id = '".$userId."' and billing_status_payment=1 and billing_cancel=0 and billing_jadwal_id='".$jadwal_id."'")->getRow();

                    if(empty($pemesan)){

                        if ($cekBilling->billing_expired_date >= date('Y-m-d H:i:s')) {

                            $this->db->query("UPDATE t_billing_mudik set billing_status_payment = 1,billing_payment_date = NOW(),billing_verif_expired_date = '".$dateExpiredVerif."',billing_promo_code='".$voucher."' where billing_code='".$billing_code."'");
                            return $this->response->setJSON(res_notfound(1, 'Success'));
            
                        } else {
                            return $this->response->setJSON(res_notfound(2, 'Billing sudah Expired'));
                        }

                    }else{

                        return $this->response->setJSON(res_notfound(2, "Anda Sudah Mempunyai Tiket"));

                    }
                    
                }else{

                    return $this->response->setJSON(res_notfound(2, "Voucher tidak valid"));

                }

            }else{

                return $this->response->setJSON(res_notfound(2, "Billing Code tidak valid"));

            }
        
        }else{
            return $this->response->setJSON(res_notfound(2, "Tidak ada voucher yang tersedia"));
        }
        

    }

    public function updateSeatExpired(){
 
        $dataBilling = $this->db->query("SELECT id as billing_id,billing_code,billing_status_payment,billing_expired_date,NOW() as date_now from t_billing_mudik where billing_expired_date < NOW() and billing_status_payment=0")->getResult();
        
        foreach($dataBilling as $key => $value){
            if($value->date_now >= $value->billing_expired_date){

                $this->db->query("update t_transaction_mudik set transaction_seat_id=NULL where billing_id='".$value->billing_id."'");


            }
            
        }
      
    
    }

    public function listTransactionMudik(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $orderStatus = $data['order_status_id'];

        if($userId == 0){
            $response = [
                'status' => 2,
                'message' => 'Silahkan Login'
            ];

            return $this->response->setJSON($response);
        }else{
            switch ($orderStatus){
                case "1":
                    $query = $this->db->query("SELECT a.id as billing_id,a.billing_code,c.id as jadwal_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,j.class_name,COUNT(b.billing_id) as penumpang_qty,c.jadwal_date_depart,c.jadwal_time_depart,
                    CASE 
                       WHEN a.billing_status_payment = 0 THEN CONCAT('Selesaikan Pesanan sebelum ',DATE_FORMAT(a.billing_expired_date, '%H:%i '),'• ',DATE_FORMAT(a.billing_expired_date,'%d %b %Y'))  
                       WHEN a.billing_status_payment = 1 AND a.billing_status_verif=0 AND a.billing_status_boarding = 0 THEN CONCAT('Verifikasi Penumpang sebelum ',DATE_FORMAT(a.billing_verif_expired_date,'%d %b %Y'))
                       WHEN a.billing_status_payment = 1 AND a.billing_status_verif=1 AND a.billing_status_boarding = 0 THEN  CONCAT('Verifikasi Keberangkatan sebelum ',DATE_FORMAT(c.jadwal_time_depart, '%H:%i '),'• ',DATE_FORMAT(c.jadwal_date_depart,'%d %b %Y'))
                       WHEN a.billing_status_payment=1 AND a.billing_status_verif=1 AND a.billing_status_boarding = 1 THEN 'eTicket sudah tersedia'
                   END as billing_status_message,
                      CASE
                          WHEN a.`billing_status_payment` = 1 THEN '1'
                          WHEN a.billing_status_payment = 0 THEN '0'
                          ELSE '2'
                      END as billing_status_code,a.billing_status_verif,a.billing_status_boarding
                      from t_billing_mudik a
                      LEFT JOIN t_transaction_mudik b on a.id=b.billing_id and b.is_verified != 2
                      LEFT JOIN t_jadwal_mudik c on a.billing_jadwal_id=c.id
                      LEFT JOIN m_route d on c.jadwal_route_id=d.id
                      LEFT JOIN m_terminal e on d.`terminal_from_id`=e.id
                      LEFT JOIN m_terminal f on d.terminal_to_id=f.id
                      LEFT JOIN m_lokabkota g on e.idkabkota=g.id
                      LEFT JOIN m_lokabkota h on f.idkabkota=h.id
                      LEFT JOIN m_armada_mudik i on c.jadwal_armada_id=i.id
                      LEFT JOIN m_class j on i.po_class_id=j.id
                      where c.is_deleted=0 and a.`billing_user_id`='".$userId."' and (a.billing_status_payment=1 or (a.billing_expired_date > NOW()) ) and (DATE(c.jadwal_date_arrived) > DATE(NOW())) and a.billing_cancel=0 and a.billing_status_verif!=2
                     GROUP BY a.billing_code")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'order_status_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);
                
                break;

                case "2":
                    $query = $this->db->query("SELECT a.id as billing_id,a.billing_code,c.id as jadwal_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,j.class_name,
                    COUNT(b.billing_id) as penumpang_qty,c.jadwal_date_depart,c.jadwal_time_depart,
                    CASE
                        WHEN  a.billing_status_verif = 1 THEN '1'
                        ELSE '2'
                    END as billing_status_code,
                    CASE 
                    WHEN a.billing_status_verif = 1 THEN 'Pesanan Selesai'
                    WHEN a.billing_status_verif = 2 THEN 'Pesanan Dibatalkan'
                    END as billing_status_message,a.billing_status_verif,a.billing_status_boarding
                    from t_billing_mudik a
                    LEFT JOIN t_transaction_mudik b on a.id=b.billing_id and b.is_verified 
                    LEFT JOIN t_jadwal_mudik c on a.billing_jadwal_id=c.id
                    LEFT JOIN m_route d on c.jadwal_route_id=d.id
                    LEFT JOIN m_terminal e on d.`terminal_from_id`=e.id
                    LEFT JOIN m_terminal f on d.terminal_to_id=f.id
                    LEFT JOIN m_lokabkota g on e.idkabkota=g.id
                    LEFT JOIN m_lokabkota h on f.idkabkota=h.id
                    LEFT JOIN m_armada_mudik i on c.jadwal_armada_id=i.id
                    LEFT JOIN m_class j on i.po_class_id=j.id
                    where  c.is_deleted=0 and ((a.billing_status_payment=1 and a.billing_cancel=0) and (a.billing_status_verif=1 and a.billing_status_boarding=1) AND (DATE(NOW()) > DATE(c.jadwal_date_arrived)) and a.`billing_user_id`='".$userId."')
                    or ((a.billing_status_payment=1 and a.billing_cancel=1) and (a.billing_status_verif=2 ) and  a.`billing_user_id`='".$userId."')
                    GROUP BY a.billing_code")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'order_status_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);

                break;
                default:
                $res['status'] = 1;
                $res['message'] = "Data Not Found";
                $res['data'] = null;
                $res['order_status_id'] = $orderStatus;
    
                return $this->response->setJSON($res);
            }

        }

    }


    public function detailTransaction(){
        $data = $this->request->getPost();
        $billing_code = $data['billing_code'];
        $userId = $data['user_mobile_id'];

        $query = $this->db->query("SELECT 
        a.id as billing_id, 
        a.billing_code, 
        c.id as jadwal_id, 
        g.kabkota as kota_depart, 
        h.kabkota as kota_arrived, 
        j.class_name, 
        a.billing_qty as penumpang_qty, 
        k.po_name,CONCAT('".base_url()."/',k.po_logo) as po_logo, 
        i.armada_label,i.armada_name,
        c.jadwal_date_depart,c.jadwal_date_arrived,
        c.jadwal_time_depart,c.jadwal_time_arrived,
        ROUND(TIME_TO_SEC(timediff(CONCAT(c.jadwal_date_arrived,' ',c.jadwal_time_arrived),CONCAT(c.jadwal_date_depart,' ',c.jadwal_time_depart)))/60) as route_time_minutes,
        e.terminal_name as terminal_depart,f.terminal_name as terminal_arrived,
      json_arrayagg((json_object('transaction_id',b.id,'transaction_nik',b.transaction_nik,'transaction_booking_name',b.transaction_booking_name,'seat_map_name',l.seat_map_detail_name,'data_qr',sha1(sha1(transaction_number)),'is_verified',b.is_verified))) as data_penumpang,CONCAT(e.terminal_lat,', ',e.terminal_lng) as terminal_depart_point,CONCAT(f.terminal_lat,', ',f.terminal_lng) as terminal_arrived_point,
        
        REPLACE(d.route_distance,' Km','') as route_distance_km,
        CASE 
                WHEN a.billing_status_payment = 1 AND a.billing_status_verif=0 AND a.billing_status_boarding = 0 THEN CONCAT('Verifikasi Penumpang sebelum ',DATE_FORMAT(a.billing_verif_expired_date,'%d %b %Y'))
                WHEN a.billing_status_payment = 1 AND a.billing_status_verif=1 AND a.billing_status_boarding = 0 THEN  CONCAT('Verifikasi Keberangkatan sebelum ',DATE_FORMAT(c.jadwal_time_depart, '%H:%i '),'• ',DATE_FORMAT(c.jadwal_date_depart,'%d %b %Y'))
                WHEN (a.billing_status_payment=1 AND a.billing_status_verif=1 AND a.billing_status_boarding = 1) AND (DATE(NOW()) > DATE(c.jadwal_date_arrived)) THEN 'Pesanan Selesai' 
                WHEN a.billing_status_payment=1 AND a.billing_status_verif=1 AND a.billing_status_boarding = 1 THEN 'eTicket sudah tersedia'
            WHEN a.billing_cancel = 1 THEN 'Pesanan dibatalkan oleh panitia mudik gratis'  
            END as billing_status_message, 
        CASE
            WHEN  a.billing_status_verif = 1 THEN '1'
            WHEN a.billing_status_verif = 0 THEN '1'
            ELSE '2'
        END as billing_status_code,
                      
        a.created_at as date_trx,
        concat('Voucher ',a.billing_promo_code) as payment_method,
        concat('Gratis') as payment_label,a.`billing_status_verif`,a.billing_status_boarding,i.armada_code,
        i.armada_tracking_status,i.armada_tracking_url,a.billing_date_verif,a.billing_date_boarding,CONCAT('".base_url()."/',a.billing_ticket_pdf) as billing_ticket_pdf
      from 
        t_billing_mudik a 
        LEFT JOIN t_transaction_mudik b on a.id = b.billing_id 
        LEFT JOIN t_jadwal_mudik c on a.billing_jadwal_id = c.id 
        LEFT JOIN m_route d on c.jadwal_route_id = d.id 
        LEFT JOIN m_terminal e on d.`terminal_from_id` = e.id 
        LEFT JOIN m_terminal f on d.terminal_to_id = f.id 
        LEFT JOIN m_lokabkota g on e.idkabkota = g.id 
        LEFT JOIN m_lokabkota h on f.idkabkota = h.id 
        LEFT JOIN m_armada_mudik i on c.jadwal_armada_id = i.id 
        LEFT JOIN m_class j on i.po_class_id = j.id 
        LEFT JOIN m_po k on i.`po_id` = k.id 
        LEFT JOIN t_jadwal_seat_mudik l on b.transaction_seat_id=l.id
      where 
        a.billing_code = '".$billing_code."'");

        $resData = $query->getRow();
        // $infoverifpenumpang = $this->db->query("SELECT * from t_info_verifikasi_mudik")->getResult();
        // $infoverifkeberangkatan = $this->db->query("SELECT * from t_info_keberangkatan_mudik")->getResult();
        // $infolokasipenumpang = $this->db->query("SELECT * from t_info_lokasi_verifikasi_mudik where type='penumpang'")->getResult();
        // $infolokasikeberangkatan = $this->db->query("SELECT * from  t_info_lokasi_verifikasi_mudik where type='keberangkatan'")->getResult();

        if(empty($resData->billing_id)){
            $response = [
                'status' => 1,
                'message' => 'Data Not Found',
                'data' =>  NULL ,
                'data_contact' => 'https://wa.me/6281320008151',
                'data_verifikasi_penumpang_url' => base_url().'/api/public/infoVerifPenumpang',
                // 'data_lokasi_penumpang' => $infolokasipenumpang,
                'data_verifikasi_keberangkatan_url' => base_url().'/api/public/infoVerifKeberangkatan',
                // 'data_lokasi_keberangkatan' => $infolokasikeberangkatan
            ];

            return $this->response->setJSON($response);
        }else{

          
            $objcat = json_decode($resData->data_penumpang);

            usort($objcat, fn($a, $b) => strcmp($a->transaction_id, $b->transaction_id));
        
            if ($objcat[0]->transaction_id == '') {
                $resData->data_penumpang = null;
            } else {
                $resData->data_penumpang = $objcat;
            }

            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' =>  $resData ,
                'data_contact' => 'https://wa.me/6281320008151',
                'data_verifikasi_penumpang_url' => base_url().'/api/public/infoVerifPenumpang',
                    // 'data_lokasi_penumpang' => $infolokasipenumpang,
                'data_verifikasi_keberangkatan_url' => base_url().'/api/public/infoVerifKeberangkatan',
                // 'data_lokasi_keberangkatan' => $infolokasikeberangkatan
            ];

            return $this->response->setJSON($response);
        
        } 
        


    }


    public function detailMotisMudik(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];

        // $query = $this->db->query("SELECT d.id as jadwal_motis_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,e.terminal_name as terminal_depart,f.terminal_name as terminal_arrived ,i.motis_status_payment, 
        // d.jadwal_date_depart,d.jadwal_time_depart,d.jadwal_date_arrived,d.jadwal_time_arrived, IFNULL(count(i.motis_jadwal_id),0) as quota_use,d.quota_public,d.quota_public-IFNULL(count(i.motis_jadwal_id),0) as quota_existing,
        // d.jadwal_type as jadwal_type_mudik
        // from t_billing_mudik a 
        // left join t_jadwal_mudik b on a.billing_jadwal_id=b.`id` 
        // left join m_route c on b.`jadwal_route_id`=c.id
        // left join t_jadwal_motis_mudik d on d.jadwal_route_id=c.id 
        // left join m_terminal e on c.terminal_from_id=e.id
        // left join m_terminal f on c.terminal_to_id=f.id
        // left join m_lokabkota g on e.idkabkota=g.id
        // left join m_lokabkota h on f.idkabkota=h.id
        // left join (SELECT motis_jadwal_id,motis_status_payment  from t_billing_motis_mudik where motis_status_payment=1 and motis_is_paguyuban = 0 and motis_cancel=0 and motis_status_verif != 2) i on i.motis_jadwal_id=d.id
        // where b.is_deleted = 0 and billing_user_id='".$userId."' and billing_status_payment=1 and d.open=1 and a.billing_status_verif != 2 group by d.id order by d.jadwal_type asc")->getResult();

        $query = $this->db->query("SELECT d.id as jadwal_motis_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,e.terminal_name as terminal_depart,f.terminal_name as terminal_arrived ,i.motis_status_payment, 
        d.jadwal_date_depart,d.jadwal_time_depart,d.jadwal_date_arrived,d.jadwal_time_arrived, IFNULL(count(i.motis_jadwal_id),0) as quota_use,d.quota_public,d.quota_public-IFNULL(count(i.motis_jadwal_id),0) as quota_existing,
        d.jadwal_type as jadwal_type_mudik
        from t_billing_mudik a 
        left join t_jadwal_mudik b on a.billing_jadwal_id=b.`id` 
        left join m_route c on c.id=b.`jadwal_route_motis_id`
        left join t_jadwal_motis_mudik d on d.jadwal_route_id=c.id
        left join m_terminal e on c.terminal_from_id=e.id
        left join m_terminal f on c.terminal_to_id=f.id
        left join m_lokabkota g on e.idkabkota=g.id
        left join m_lokabkota h on f.idkabkota=h.id
        left join (SELECT motis_jadwal_id,motis_status_payment  from t_billing_motis_mudik where motis_status_payment=1 and motis_is_paguyuban = 0 and motis_cancel=0 and motis_status_verif != 2) i on i.motis_jadwal_id=d.id
        where b.is_deleted = 0 and billing_user_id='".$userId."' 
        and billing_status_payment=1 and d.open=1 and a.billing_status_verif != 2 group by d.id order by d.jadwal_type asc")->getResult();

        $statusTrx = $this->db->query("SELECT * from t_billing_motis_mudik where motis_user_id='".$userId."' and motis_status_payment=1 and motis_cancel=0")->getRow();
        $infoMotis = $this->db->query("SELECT * from t_info_motis_mudik")->getResult();

        $label_detail = 'Harap lakukan verifikasi sebelum tenggat waktu yang sudah ditentukan & antar kendaraan H-1 sebelum keberangkatan.';

        if(empty($statusTrx->id)){
            $labelTicket = 'Kamu bisa mendapatkan kuota gratis untuk berangkatin motormu karena sudah memesan tiket mudik dan arus balik';
            $is_transaction = 0;

        }else{
            $labelTicket = 'Kamu sudah mempunyai tiket untuk memberangkatkan motormu, lihat detail pada Riwayat';
            $is_transaction = 1;
        }


        if(empty($query)){
            
            $response = [
                'status' => 1,
                'message' => 'Data Not Found',
                'label_ticket' => $labelTicket,
                'label_detail' => $label_detail,
                'is_transaction'=> $is_transaction,
                'data' =>  NULL ,
                'data_sk_motis' => $infoMotis

            ];

            return $this->response->setJSON($response);
        }else{

        

            if(count($query) > 1){
                $ind1 = $query['0']->quota_existing;
                $ind2 = $query['1']->quota_existing;

                $quotanya = $ind1 <= $ind2 ? $ind1 : $ind2;
                // echo $quotanya;
                foreach ($query as $value) {
                    $value->quota_existing = $quotanya;

                }
            }
            
            $response = [
                'status' => 1,
                'message' => count($query) > 1 ? 'Success': 'Belum mempunyai tiket mudik & arus balik',
                'label_ticket' => $labelTicket,
                'label_detail' => $label_detail,
                'is_transaction'=> $is_transaction,
                'data' => count($query) > 1 ? $query : NULL ,
                'data_sk_motis' => $infoMotis,

            ];

            return $this->response->setJSON($response);
       
        }

    }

    public function transactionMotis(){
        $this->db->transStart();
        header('Content-Type: application/json');
        $dataTrx = file_get_contents('php://input');
        $arrDataTrx = json_decode($dataTrx);

        $user_mobile_id = $arrDataTrx->user_mobile_id;
        $jadwal_arr = $arrDataTrx->jadwal_motis_id;
        $kendaraan_no = $arrDataTrx->data_kendaraan->no_kendaraan;
        $kendaraan_jenis = $arrDataTrx->data_kendaraan->jenis_kendaraan;
        $kendaraan_no_stnk = $arrDataTrx->data_kendaraan->no_stnk_kendaraan;
        $kendaraan_nik = $arrDataTrx->data_kendaraan->nik_pendaftar_kendaraan;
        $kendaraan_img = $arrDataTrx->data_kendaraan->foto_kendaraan;
        $kendaraan_stnk_img = $arrDataTrx->data_kendaraan->foto_stnk_kendaraan;
        $kendaraan_ktp_img = $arrDataTrx->data_kendaraan->foto_ktp;       
        
        $cekTrx = $this->db->query("SELECT * from t_billing_motis_mudik where motis_user_id='".$user_mobile_id."' and motis_status_payment=1 and motis_cancel=0")->getRow();
        $jadwalMudik = $this->db->query("SELECT a.billing_verif_expired_date from t_billing_mudik a 
                                        LEFT JOIN t_jadwal_mudik b on a.`billing_jadwal_id`=b.id
                                        where a.billing_user_id='".$user_mobile_id."' and a.billing_status_payment=1 
                                        and a.billing_cancel=0 and b.jadwal_type=1")->getRow();
                                    

        if(empty($cekTrx->id)){

            $filename1 = $this->genNamefile();
            $file1 = '/home/ngi/php/php74/transhubdat/public/uploads/motis/'.$filename1.'_kendaraan.png';
            $file2 = '/home/ngi/php/php74/transhubdat/public/uploads/motis/'.$filename1.'_stnk.png';
            $file3 = '/home/ngi/php/php74/transhubdat/public/uploads/motis/'.$filename1.'_ktp.png';

            // $file1 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/motis/'.$filename1.'_kendaraan.png';
            // $file2 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/motis/'.$filename1.'_stnk.png';
            // $file3 = '/Users/ngibookpro/Documents/project/php/transhubdat/public/uploads/motis/'.$filename1.'_ktp.png';


            $data1 = base64_decode($kendaraan_img);
            $data2 = base64_decode($kendaraan_stnk_img);
            $data3 = base64_decode($kendaraan_ktp_img);

            file_put_contents($file1, $data1);
            file_put_contents($file2, $data2);
            file_put_contents($file3, $data3);

            $foto_kendaraan = 'public/uploads/motis/'.$filename1.'_kendaraan.png';
            $foto_stnk = 'public/uploads/motis/'.$filename1.'_stnk.png';
            $foto_nik = 'public/uploads/motis/'.$filename1.'_ktp.png';


            foreach ($jadwal_arr as $value) {
                $cekKouta = $this->db->query("SELECT count(b.id) as tot_use,a.quota_public,a.quota_public-count(b.id) as sisakuota,a.jadwal_date_depart,a.jadwal_date_arrived,a.jadwal_date_depart-INTERVAL 2 DAY as h_2balik,a.jadwal_type from t_jadwal_motis_mudik a
                left join (SELECT * from t_billing_motis_mudik where motis_status_payment=1 and motis_cancel=0) b
                on a.id=b.motis_jadwal_id 
                where a.id='".$value."'")->getRow();
                 
                    if($cekKouta->jadwal_type == 1){
                        $jadwalVerif = $jadwalMudik->billing_verif_expired_date;

                    }else{
                        $jadwalVerif = $cekKouta->h_2balik;
                    }

                    
                
                  if($cekKouta->sisakuota < 0){
                    $response = [
                        'status' => 2,
                        'message' => 'Maaf,Kouta sudah habis '
                      
                    ];
        
                    return $this->response->setJSON($response);

                  }else{
                        if($cekKouta->sisakuota < 0){
                            $response = [
                                'status' => 2,
                                'message' => 'Maaf,Kouta sudah habis '
                              
                            ];
                
                            return $this->response->setJSON($response);

                        }else{
                            $insertBilling['motis_amount']  = 0;
                            $insertBilling['motis_user_id'] = $user_mobile_id;
                            $insertBilling['motis_jadwal_id'] = $value;
                            $insertBilling['motis_status_payment'] = 1;
                            $insertBilling['motis_verif_expired_date'] = $jadwalVerif;

                            $this->db->table('t_billing_motis_mudik')->insert($insertBilling);
                            $billingId = $this->db->insertID();
                            $dataBilling = $this->db->query("SELECT * FROM t_billing_motis_mudik where id = '".$billingId."' ")->getRow();

                            $datakendaraan['motis_billing_id'] = $billingId;
                            $datakendaraan['motis_billing_code'] = $dataBilling->motis_code;
                            $datakendaraan['no_kendaraan'] = $kendaraan_no;
                            $datakendaraan['jenis_kendaraan'] = $kendaraan_jenis;
                            $datakendaraan['no_stnk_kendaraan'] = $kendaraan_no_stnk;
                            $datakendaraan['nik_pendaftar_kendaraan'] = $kendaraan_nik;
                            $datakendaraan['foto_kendaraan']  = empty($kendaraan_img) ? NULL : $foto_kendaraan;
                            $datakendaraan['foto_stnk']  =  empty($kendaraan_stnk_img) ? NULL : $foto_stnk;
                            $datakendaraan['foto_ktp']  =  empty($kendaraan_ktp_img) ? NULL :$foto_nik;


                            $this->db->table('t_motis_manifest_mudik')->insert($datakendaraan);
                        }

                        
                  }
                

            }

        
        }else{
            $response = [
                'status' => 2,
                'message' => 'Anda sudah melakukan transaksi'
              
            ];

            return $this->response->setJSON($response);
        }


        if ($this->db->transStatus() === FALSE) {
            $iscommit = false;
            $this->db->transRollback();
        } else {
            $iscommit = true;
            $this->db->transCommit();
        }
    
        if ($iscommit === true) {

            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' => 'NULL'
            ];
        } else {
            $response = [
                'status' => 2,
                'message' => 'Maaf,Kouta sudah habis'
            ];
        }
    
        return $this->response->setJSON($response);


        
    }

    public function cancelMotis(){

        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];

        $query = $this->db->query("SELECT motis_code,motis_user_id,motis_status_payment,motis_status_verif,motis_verif_expired_date,NOW() as date_now from t_billing_motis_mudik where motis_user_id='".$userId."' ")->getRow();

    
        if($query->motis_user_id == $userId){

            if($query->motis_status_verif == 1){
                return $this->response->setJSON(res_notfound(2, "Tidak dapat dibatalkan karena sudah diverifikasi"));
            }else{
            
                $update = $this->db->query("update t_billing_motis_mudik set motis_cancel = 1 where motis_user_id='".$userId."'");

                return $this->response->setJSON(res_success(1, 'Success',NULL));
            
            }

        }else{
            return $this->response->setJSON(res_notfound(2, "Data Billing & User Not Match"));
        }
            
        

    }

    public function historyTransactionMotis(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $orderStatus = $data['order_status_id'];

        if($userId == 0){
            $response = [
                'status' => 2,
                'message' => 'Silahkan Login'
            ];

            return $this->response->setJSON($response);
        }else{
            switch ($orderStatus){
                case "1":
                    $query = $this->db->query("SELECT a.id as billing_id,a.motis_code as motis_billing_code,b.jenis_kendaraan,b.no_kendaraan,d.id as jadwal_motis_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,e.terminal_name as terminal_depart,f.terminal_name as terminal_arrived, d.jadwal_date_depart,d.jadwal_time_depart,d.jadwal_date_arrived,d.jadwal_time_arrived, d.jadwal_type as jadwal_type_mudik,
                    CASE
                        WHEN motis_status_verif = 0 THEN  CONCAT('Verifikasi Kendaraan sebelum ',DATE_FORMAT(a.motis_verif_expired_date,'%d %b %Y'))  
                        WHEN motis_status_verif = 1 AND motis_status_boarding=0 THEN CONCAT('Menunggu penyerahan')  
                        WHEN motis_status_verif = 1 AND motis_status_boarding=1 AND NOW() >= d.jadwal_date_arrived + INTERVAL 1 DAY THEN CONCAT('Lakukan pengambilan Kendaraan')
                        WHEN motis_status_verif = 1 AND motis_status_boarding=1 THEN CONCAT('Kendaraan sudah diserahkan')
                    END as billing_status_message,
                    CASE
                        WHEN motis_status_verif = 0  THEN '0'
                    ELSE '1'
                    END as billing_status_code,motis_status_verif,motis_status_boarding,motis_status_take
                    from t_billing_motis_mudik a
                    left join t_motis_manifest_mudik b on a.motis_code=b.motis_billing_code
                    left join t_jadwal_motis_mudik d on a.motis_jadwal_id=d.id 
                    left join m_route c on d.`jadwal_route_id`=c.id
                    left join m_terminal e on c.terminal_from_id=e.id
                    left join m_terminal f on c.terminal_to_id=f.id
                    left join m_lokabkota g on e.idkabkota=g.id
                    left join m_lokabkota h on f.idkabkota=h.id
                    where a.motis_user_id='".$userId."'  and motis_status_payment=1 and motis_status_take=0 and motis_cancel = 0 ")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'order_status_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);
                
                break;

                case "2":
                    $query = $this->db->query("SELECT a.id as billing_id,a.motis_code as motis_billing_code,b.jenis_kendaraan,b.no_kendaraan,d.id as jadwal_motis_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,e.terminal_name as terminal_depart,f.terminal_name as terminal_arrived, d.jadwal_date_depart,d.jadwal_time_depart,d.jadwal_date_arrived,d.jadwal_time_arrived, d.jadwal_type as jadwal_type_mudik,
                    CASE
                        WHEN motis_status_take = 1 AND motis_cancel = 0 THEN CONCAT('Pesanan Selesai')  
                        WHEN  motis_cancel=1 THEN CONCAT('Pesanan Dibatalkan')    
                    END as billing_status_message,
                    CASE
                        WHEN motis_cancel = 1  THEN '2'
                    ELSE '1'
                    END as billing_status_code,motis_status_verif,motis_status_boarding,motis_status_take
                        from t_billing_motis_mudik a
                    left join t_motis_manifest_mudik b on a.motis_code=b.motis_billing_code
                    left join t_jadwal_motis_mudik d on a.motis_jadwal_id=d.id 
                    left join m_route c on d.`jadwal_route_id`=c.id
                    left join m_terminal e on c.terminal_from_id=e.id
                    left join m_terminal f on c.terminal_to_id=f.id
                    left join m_lokabkota g on e.idkabkota=g.id
                    left join m_lokabkota h on f.idkabkota=h.id
                    where a.motis_user_id='".$userId."'  and ((motis_status_payment=1 and motis_status_take=1) or motis_cancel = 1)")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'order_status_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);

                break;
                default:
                $res['status'] = 1;
                $res['message'] = "Data Not Found";
                $res['data'] = null;
                $res['order_status_id'] = $orderStatus;
    
                return $this->response->setJSON($res);
            }

        }


    }

    public function detailTransactionMotis(){
        $data = $this->request->getPost();
        $userId = $data['user_mobile_id'];
        $billing_code  = $data['motis_billing_code'];
        $query = $this->db->query("SELECT a.id as billing_id,a.motis_code as motis_billing_code,b.jenis_kendaraan,b.no_kendaraan,b.no_stnk_kendaraan,b.nik_pendaftar_kendaraan,b.date_created,d.id as jadwal_motis_id,g.kabkota as kota_depart,h.kabkota as kota_arrived,e.terminal_name as terminal_depart,f.terminal_name as terminal_arrived, d.jadwal_date_depart,d.jadwal_time_depart,d.jadwal_date_arrived,d.jadwal_time_arrived, d.jadwal_type as jadwal_type_mudik,
        CASE
            WHEN  motis_cancel=1 THEN CONCAT('Pesanan Dibatalkan') 
            WHEN motis_status_verif = 0 THEN  CONCAT('Verifikasi Kendaraan sebelum ',DATE_FORMAT(a.motis_verif_expired_date,'%d %b %Y'))
            WHEN motis_status_take = 1 AND motis_cancel = 0 THEN CONCAT('Pesanan Selesai')  
            WHEN motis_status_verif = 1 AND motis_status_boarding=0 THEN CONCAT('Lakukan penyerahan kendaraan tanggal ',DATE_FORMAT(d.jadwal_date_depart-INTERVAL 1 DAY,'%d %b %Y'))  
            WHEN motis_status_verif = 1 AND motis_status_boarding=1 AND NOW() >= d.jadwal_date_arrived + INTERVAL 1 DAY THEN CONCAT('Lakukan pengambilan Kendaraan')
            WHEN motis_status_verif = 1 AND motis_status_boarding=1 THEN CONCAT('Kendaraan sudah diserahkan')            
            END as billing_status_message,
        CASE
            WHEN  motis_cancel=1 THEN '2'
            WHEN motis_status_verif = 0 THEN '0'                    
            ELSE '1'          
        END as billing_status_code,motis_status_verif,motis_status_boarding,motis_status_take,
        sha1(sha1(a.motis_code)) as data_qr,a.motis_date_verif,i.armada_tracking_url,i.armada_tracking_status,CONCAT('".base_url()."/',a.motis_ticket_pdf) as motis_ticket_pdf
        from t_billing_motis_mudik a
        left join t_motis_manifest_mudik b on a.motis_code=b.motis_billing_code
        left join t_jadwal_motis_mudik d on a.motis_jadwal_id=d.id 
        left join m_route c on d.`jadwal_route_id`=c.id
        left join m_terminal e on c.terminal_from_id=e.id
        left join m_terminal f on c.terminal_to_id=f.id
        left join m_lokabkota g on e.idkabkota=g.id
        left join m_lokabkota h on f.idkabkota=h.id
        left join m_armada_motis_mudik i on a.motis_armada_id=i.id
        where a.motis_code='".$billing_code."' and a.motis_user_id='".$userId."'");

        $resData = $query->getRow();
      
        // $infoverifmotis = $this->db->query("SELECT * from t_info_motis_verifikasi_mudik")->getResult();
     
        if(empty($resData->billing_id)){
            $response = [
                'status' => 1,
                'message' => 'Data Not Found',
                'data' =>  NULL ,
                'data_contact' => 'https://wa.me/6281320008151',
                // 'data_verifikasi_motis' => $infoverifmotis,
                'data_verifikasi_motis_url' => base_url().'/api/public/infoVerifKendaraan',
          
            ];

            return $this->response->setJSON($response);
        }else{

            $response = [
                'status' => 1,
                'message' => 'Success',
                'data' =>  $resData ,
                'data_contact' => 'https://wa.me/6281320008151',
                // 'data_verifikasi_motis' => $infoverifmotis,
                'data_verifikasi_motis_url' => base_url().'/api/public/infoVerifKendaraan',
            ];

            return $this->response->setJSON($response);

        } 
    }

    function sendNotifUser(){
        $data = $this->request->getPost();
        $header = $data['header'];
        $deskripsi = $data['deskripsi'];
        $fcmArray = [];
        
        $query = $this->db->query("SELECT id as user_mobile_id,user_mobile_email,user_mobile_fcm from m_user_mobile where is_deleted = 0 and user_mobile_is_dev=1 and user_mobile_role=1 and user_mobile_fcm is not null and user_mobile_fcm != ''")->getResult();
       
        
        foreach ($query as $r) {
            array_push($fcmArray, $r->user_mobile_fcm);
            $datapost['title'] = $header;
            $datapost['body'] = $deskripsi;
            $datapost['user_id'] = $r->user_mobile_id;
        
            $this->db->table('t_notifikasi_user')->insert($datapost);
            
        }

        
        $this->sendBroadcastNotification($fcmArray,$header,$deskripsi);
    }

    function sendNotifAll(){
        $data = $this->request->getPost();
        $fcmArray = [];
        $header = $data['header'];
        $deskripsi = $data['deskripsi'];
        $query = $this->db->query("SELECT id as user_mobile_id,user_mobile_email,user_mobile_fcm from m_user_mobile where is_deleted = 0 and user_mobile_fcm is not null and user_mobile_fcm != ''")->getResult();
       
        $datapost['title'] = $header;
        $datapost['body'] = $deskripsi;
        
        $this->db->table('t_notifikasi')->insert($datapost);
        
        foreach ($query as $r) {
            array_push($fcmArray, $r->user_mobile_fcm);
            
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

    //end of mudik

    //absensi
    public function cekAbsen(){
        $data = $this->request->getPost();
        $userId = $data['id_petugas'];
       

        $is_absen = intval($this->configAbsen($userId));

        if ($is_absen == 1) {
            $cekJadwal = $this->db->query("SELECT * from m_jadwal_posko where user_id='".$userId."' and tgl_tugas=date(NOW())")->getRow();
            if(empty($cekJadwal->id)){
                $response = [
                    'status' => 1,
                    'message' => 'Data Not Found',
                    'last_absen' => NULL,
                    'status_absen' => 0,
                    'is_absen' => $is_absen,
              
                ];
    
                return $this->response->setJSON($response);
            }else{
                $absenToday = $this->db->query("SELECT *,DATE(created_at) as date_absen,DATE(NOW()) as date_now from t_absensi_internal where user_id='".$userId."' order by id desc")->getRow();

                if(!empty($absenToday->id)){
                    if($absenToday->date_absen == $absenToday->date_now){
                        $response = [
                            'status' => 1,
                            'message' => 'Success',
                            'last_absen' => $absenToday->created_at,
                            'status_absen' => 0,
                            'is_absen' => $is_absen,
                      
                        ];    
                        return $this->response->setJSON($response);
                    }else{
        
                        $response = [
                            'status' => 1,
                            'message' => 'Success',
                            'last_absen' => $absenToday->created_at,
                            'status_absen' => 1,
                            'is_absen' => $is_absen,
                      
                        ];
            
                        return $this->response->setJSON($response);
                    }
    
                }else{
                    $response = [
                        'status' => 1,
                        'message' => 'Success',
                        'last_absen' => NULL,
                        'status_absen' => 1,
                        'is_absen' => $is_absen,
                  
                    ];
        
                    return $this->response->setJSON($response);
                }
              
            }
          
           
        } else {
            $response = [
                'status' => 1,
                'message' => 'Data Not Found',
                'last_absen' => NULL,
                'status_absen' => 0,
                'is_absen' => $is_absen,
          
            ];

            return $this->response->setJSON($response);
        }

    }

    public function saveAbsensi(){
        $data = $this->request->getPost();
        $userId = $data['id_petugas'];
        $lat = $data['lat'];
        $lng = $data['lng'];
        $absensiimg = $data['absensi_img'];

        $cekJadwal = $this->db->query("SELECT * from m_jadwal_posko  where user_id='".$userId."' and tgl_tugas=date(NOW())")->getRow();

        if(empty($cekJadwal->id)){
            $response = [
                'status' => 0,
                'message' => 'Anda tidak memiliki jadwal',
                'last_absen' => NULL
          
            ];

            return $this->response->setJSON($response);


        }else{
            $absenToday = $this->db->query("SELECT *,DATE(created_at) as date_absen,DATE(NOW()) as date_now from t_absensi_internal where user_id='".$userId."' and date(created_at)=date(NOW()) order by id desc")->getRow();

            if(!empty($absenToday->id)){
                $response = [
                    'status' => 0,
                    'message' => 'Anda Sudah Absen',
                    'last_absen' => $absenToday->created_at
            
                ];

                return $this->response->setJSON($response);

            }else{

            
                $filename1 = $this->genNamefile();
                $file1 = '/home/ngi/php/php74/transhubdat/public/uploads/absensi/'.$filename1.'_absensi.png';
                $data1 = base64_decode($absensiimg);
            
        
                file_put_contents($file1, $data1);
        
                $fileAbsensi = 'public/uploads/absensi/'.$filename1.'_absensi.png';


        
        
                $insertAbsen = [
                    'user_id' => $userId,
                    'absensi_img' => empty($fileAbsensi) ? NULL : $fileAbsensi,
                    'absensi_lat' => $lat,
                    'absensi_lng' => $lng,
                    'jadwal_posko_id' => $cekJadwal->id
        
                ];
                if($this->apiModel->base_insert($insertAbsen,'t_absensi_internal')){
                    $insertId = $this->db->insertID();
                    $statusAbsen = $this->db->query("SELECT created_at as date_absen,DATE(NOW()) as date_now from t_absensi_internal where id='".$insertId."'")->getRow();
                    $response = [
                        'status' => 1,
                        'message' => 'Success',
                        'last_absen' => $statusAbsen->date_absen
                    ];
        
                    return $this->response->setJSON($response);
        
                }else{
                    $response = [
                        'status' => 0,
                        'message' => 'Failed Insert',
                        'last_absen' => NULL
                
                    ];
        
                    return $this->response->setJSON($response);
                }
            
            }

        }


        

      
        
    }

    //end of absensi

    //info mudik

    public function listRuteMudik(){
        $query = $this->db->query("SELECT id,route_name,kategori_angkutan_id,route_from,route_to,route_from_latlng,route_to_latlng,route_time,route_distance,route_polyline from m_route where kategori_angkutan_id=5 and is_deleted=0")->getResult();


        $response = [
            'status' => 1,
            'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }

    public function searchRuteMudik(){
        $query = $this->db->query("SELECT id as route_id,route_name,kategori_angkutan_id,route_from,route_to,route_from_latlng,route_to_latlng,route_time,route_distance from m_route where kategori_angkutan_id=5 and is_deleted=0")->getResult();


        $response = [
            'status' => 1,
            'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }

    public function polylineRuteMudik(){
        $data = $this->request->getPost();
        $route_id = $data['route_id'];
        $query = $this->db->query("SELECT id,route_name,kategori_angkutan_id,route_from,route_to,route_from_latlng,route_to_latlng,route_time,route_distance,route_polyline from m_route where id='".$route_id."'")->getRow();


        $response = [
            'status' => 1,
            'message' =>  (!empty($query->id)) ? 'Success' : 'Tidak Ada Data',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }



    public function listInfoMudik(){
        $data = $this->request->getPost();
        $orderStatus = $data['tipe_id'];

       
            switch ($orderStatus){
                case "1":
                    $query = $this->db->query("SELECT id as id_place,posko_mudik_name as place_name,posko_mudik_about as place_about,posko_mudik_address as place_address,posko_mudik_latlong as place_latlng,posko_mudik_img as place_img,concat(1) as jenis_id,concat('posko') as jenis_name from m_posko_mudik where is_deleted=0")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'tipe_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);
                
                break;

                case "2":
                    $query = $this->db->query(" SELECT id as id_place,resto_mudik_name as place_name,resto_mudik_about as place_about,resto_mudik_address as place_address,resto_mudik_latlong as place_latlng,resto_mudik_img as place_img,concat(2) as jenis_id,concat('resto') as jenis_name from m_resto_mudik where is_deleted=0 ")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'tipe_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);

                break;

                case "3":
                     $query = $this->db->query("select id as id_place,rest_area_lokasi as place_area_name,rest_area_name as place_name,CONCAT('".base_url()."/',rest_area_img) as place_img,
                     rest_area_latlong_nominatim as place_latlng,rest_area_address as place_address,concat(3) as jenis_id,
                     json_array(
                     IF(rest_area_spbu = 1 ,'SPBU',NULL),
                     IF(rest_area_spklu = 1,'SPKLU',NULL),
                     IF(rest_area_parkir = 1,'Parkir',NULL),
                     IF(rest_area_praying_facilities = 1,'Tempat Ibadah',NULL),
                     IF(rest_area_men_toilet = 1,'Toilet Pria',NULL),
                     IF(rest_area_women_toilet = 1,'Toilet Wanita',NULL),
                     IF(rest_area_urinoir = 1,'Tempat Buang Air Kecil',NULL),
                     concat('Jumlah Toilet Disabilitas ',rest_area_disabilitas_toilet),
                     IF(rest_area_food_court = 1,'Food Court',NULL),
                     concat('Jumlah Minimarket ',rest_area_mini_market),
                     IF(rest_area_atm = 1,'ATM',NULL),
                     IF(rest_area_bengkel = 1,'Bengkel',NULL),
                     IF(rest_area_topup_etol = 1,'Topup E-Toll',NULL)
                     ) as place_facilities
                      from m_rest_area where is_deleted=0 group by id")->getResult();
                    
                    foreach($query as $value){
                        $objdata = json_decode($value->place_facilities);
        
                     
                        $value->place_facilities = $objdata; 
                
                            
                    }
                   
                    
                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'tipe_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);
                break;
                case "4":
                    $query = $this->db->query(" SELECT id as id_place,wisata_mudik_name as place_name,wisata_mudik_about as place_about,wisata_mudik_address as place_address,wisata_mudik_latlong as place_latlng,CONCAT('".base_url()."/',wisata_mudik_img) as place_img,concat(4) as jenis_id,concat('wisata') as jenis_name from m_wisata_mudik where is_deleted=0 ")->getResult();

                    $response = [
                        'status' => 1,
                        'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
                        'data' => $query,
                        'tipe_id' => $orderStatus
                    ];
        
                    return $this->response->setJSON($response);

                break;

                default:
                $res['status'] = 1;
                $res['message'] = "Data Not Found";
                $res['data'] = null;
                $res['tipe_id'] = $orderStatus;
    
                return $this->response->setJSON($res);
            }

    
    }

    public function detailPosko(){
        $data = $this->request->getPost();
        $idPlace = $data['id_place'];

        $query = $this->db->query("SELECT a.id as id_place,posko_mudik_name as place_name,posko_mudik_about as place_about,posko_mudik_address as place_address,posko_mudik_latlong as place_latlng,posko_mudik_img as place_img,concat(1) as jenis_id,concat('posko') as jenis_name, json_arrayagg((json_object('petugas_nama',b.user_web_name,'petugas_photo',if(b.user_web_photo is null ,'https://mitradarat.dephub.go.id/public/uploads/default_user.png',b.user_web_photo)))) as petugas_posko from m_posko_mudik a 
            left join m_user_web b ON FIND_IN_SET(b.id,a.petugas_id)
            where a.is_deleted=0 and a.id='".$idPlace."'");
        $resData = $query->getRow();

        if(empty($resData->id_place)){
            $response = [
                'status' => 1,
                'message' =>  "Data Not Found",
                'data' => NULL,
                'data_contact' => 'https://wa.me/6281320008151'
            ];

            return $this->response->setJSON($response);
        }else{

            $objcat = json_decode($resData->petugas_posko);

          
            if ($objcat[0]->petugas_nama == '') {
                $resData->petugas_posko = null;
            } else {
                $resData->petugas_posko = $objcat;
            }


            $response = [
                'status' => 1,
                'message' => "Success",
                'data' => $resData,
                'data_contact' => 'https://wa.me/6281320008151'
            ];

            return $this->response->setJSON($response);
        } 
    }

    //end of info mudik


    //peta mudik
    public function jalurPetaMudik(){
        $query = $this->db->query("
        SELECT a.id as jalur_id,a.klas_posko,b.id as route_id,route_name,kategori_angkutan_id,route_from,route_to,route_from_latlng,route_to_latlng,route_time,route_distance,route_polyline from m_klas_posko a
        inner join m_route b on a.route_id=b.id
        where a.is_deleted=0
        ")->getResult();


        $response = [
            'status' => 1,
            'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }

    public function kategoriSinggahMudik(){
        $query = $this->db->query("select id,kategori_tempat_name,CONCAT('".base_url()."/',marker) as marker,urut from m_kategori_tempat where is_deleted=0 order by urut asc")->getResult();


        $response = [
            'status' => 1,
            'message' => count($query) > 0 ? 'Success' : 'Tidak Ada Data',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }

    // public function detailJalurMudik(){
    //     $data = $this->request->getPost();
    //     $jalurId = $data['jalur_id'];
    //     $query = $this->db->query("SELECT b.id as route_id,route_name,kategori_angkutan_id,route_from,route_to,route_from_latlng,route_to_latlng,route_time,route_distance,route_polyline from m_klas_posko a
    //     inner join m_route b on a.route_id=b.id
    //     where a.id='".$jalurId."'")->getRow();


    //     $response = [
    //         'status' => 1,
    //         'message' =>  (!empty($query->route_id)) ? 'Success' : 'Tidak Ada Data',
    //         'data' => $query
    //     ];

    //     return $this->response->setJSON($response);
    // }
    //end of peta mudik

}
