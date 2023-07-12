<?php namespace App\Modules\Api\Controllers\Settlement;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class Brizzi extends BaseController
{
    private $apiModel;
    var $secretKey;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
        $this->secretKey = '2W87k4rL6nYopDgXb3F95uJvEc1HdRwZ';
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



    private function encrypted($data){
        $v = $data;
		if(strlen($this->secretKey) != 32){
			echo json_encode("SecretKey length is not 32 chars");
		}else{
			$iv = substr($this->secretKey, 0, 16);
			$key = [$this->secretKey, $iv];
			$encrypted = openssl_encrypt($v, 'aes-256-cbc', $key[0], 0, $key[1]);
			// echo "Encrypted: $encrypted\n";
			// return [$secretKey, $iv];
            return $encrypted;
			
		}
    }

    private function decrypted($data){
		if(strlen($this->secretKey) != 32){
			echo json_encode("SecretKey length is not 32 chars");
		}else{
			$iv = substr($this->secretKey, 0, 16);
			$key = [$this->secretKey, $iv];
			$decrypted = openssl_decrypt($data, 'aes-256-cbc', $key[0], 0, $key[1]);

			// echo "Decrypted: $decrypted\n";
            return $decrypted;
			// return [$secretKey, $iv];
			
		}
    }

    public function checkDec(){
        $secretKey = $this->secretKey;
        $encrypted = file_get_contents('php://input');
		
		if(strlen($secretKey) != 32){
			echo "SecretKey length is not 32 chars";
		}else{
			$iv = substr($secretKey, 0, 16);

			$key = [$secretKey, $iv];

			$decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key[0], 0, $key[1]);
	
			echo $decrypted;

			
		}
    }

    public function cekEnkrip_form(){
		$secretKey = $this->secretKey;
        $datapost = http_build_query($_POST);
        // $datapostnya = json_encode($datapost);
    
	
		if(strlen($secretKey) != 32){
			echo "SecretKey length is not 32 chars";
		}else{
			$iv = substr($secretKey, 0, 16);
			
			$key = [$secretKey, $iv];
			$encrypted = openssl_encrypt($datapost, 'aes-256-cbc', $key[0], 0, $key[1]);
			echo $encrypted;

			
		}

	}
    public function cekEnkrip_json(){
		$secretKey = $this->secretKey;
        $datapost = file_get_contents('php://input');
		// echo $datapost;
		if(strlen($secretKey) != 32){
			echo "SecretKey length is not 32 chars";
		}else{
			$iv = substr($secretKey, 0, 16);
			
			$key = [$secretKey, $iv];
			$encrypted = openssl_encrypt($datapost, 'aes-256-cbc', $key[0], 0, $key[1]);
			echo $encrypted;

			
		}

	}


    public function test(){
        echo 'test';
    }

    public function authMobileUser(){
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $data = $queryArray;

        $res_where = [];

        $mobile_email = !isset($data['mobile_email']) ?: $res_where['user_mobile_email'] = addslashes($data['mobile_email']);
        $mobile_name = !isset($data['mobile_name']) ?: $res_where['user_mobile_name'] = addslashes($data['mobile_name']);
        $mobile_photo = !isset($data['mobile_photo']) ?: $res_where['user_mobile_photo'] = addslashes($data['mobile_photo']);
        $mobile_type = !isset($data['mobile_type']) ?: $res_where['user_mobile_type'] = addslashes($data['mobile_type']);
        $mobile_fcm = !isset($data['mobile_fcm']) ?: $res_where['user_mobile_fcm'] = addslashes($data['mobile_fcm']);
        $mobile_uid = !isset($data['mobile_uid']) ?: $res_where['user_mobile_uid'] = addslashes($data['mobile_uid']);
        $mobile_version = !isset($data['mobile_version']) ?: $res_where['user_mobile_version'] = addslashes($data['mobile_version']);
    

        $query = $this->db->query("SELECT * from m_user_mobile where ((user_mobile_email = '".$mobile_email."' or user_mobile_uid = '".$mobile_uid."' ) and user_mobile_type = 'Android' and is_deleted=0) or ((user_mobile_email = '".$mobile_email."' or user_mobile_uid = '".$mobile_uid."' ) and user_mobile_type = 'iOS' and is_deleted=0)
        order by id desc")->getRow();
        
    

        if(empty($query)){

            
            $datapost = [
                "user_mobile_email" => $mobile_email,
                "user_mobile_name" => $mobile_name,
                "user_mobile_photo" => $mobile_photo,
                "user_mobile_type" => $mobile_type,
                "user_mobile_fcm" => $mobile_fcm,
                "user_mobile_uid" => $mobile_uid,
                "user_mobile_version" => $mobile_version
            ];

           
            if ($this->apiModel->base_insert($datapost,'m_user_mobile')){
                $insertId = $this->db->insertID();

                $dataUser = $this->db->query("SELECT * from m_user_mobile where id='".$insertId."' ")->getRow();
                $res = array(
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $dataUser
                );
                $response = json_encode($res);
                return $this->encrypted($response);
            }else{
                $res = array(
                    'status' => 0,
                    'message' => 'Failed Insert'
                   
                );
                $response = json_encode($res);
                return $this->encrypted($response);
            }
    
          
            
        }else{
          
            $datapost = [
                "user_mobile_email" => $mobile_email,
                "user_mobile_name" => $mobile_name,
                "user_mobile_photo" => $mobile_photo,
                "user_mobile_type" => $mobile_type,
                "user_mobile_fcm" => $mobile_fcm,
                "user_mobile_uid" => $mobile_uid,
                "user_mobile_version" => $mobile_version
            ];
           
            

            $this->apiModel->base_update($datapost, "m_user_mobile", ["id" => $query->id]);
            $res = array(
                'status' => 1,
                'message' => 'Success',
                'data' => $query
            );

            $response = json_encode($res);
            return $this->encrypted($response);
        

           
        }

    }

    public function frontBanner(){
        $configbanner = $this->db->query("SELECT * from m_pis_banner_config where is_active = 1")->getRow();

        if(empty($configbanner->id)){
            $res = array(
                'status' => 1,
                'message' => 'No Active Banner'
            );

            return $this->response->setJSON($res);
        }else{
            $banner = $this->db->query("SELECT id as banner_id,banner_name,banner_order,created_at,CONCAT('".base_url()."/',banner_link) as banner_link,link_redirect,is_webview from t_pis_banner where is_deleted=0 and is_active=1 order by created_at desc")->getResult();
            $place = $this->db->query("SELECT * from m_pis_lokasi where is_active=1")->getResult();
            if(empty($banner)){
                return $this->response->setJSON(res_notfound(1, "Data Not Found"));
            }else{
                $temp = array(
                    'banner'=> $banner,
                    'text'=> $place
                );
                $res = array(
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $temp,
                    'time_banner' => $configbanner->banner_time
                );
    
                return $this->response->setJSON($res);
            } 

        }
    }

    public function popupBanner(){
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $data = $queryArray;

        $userId = $data['user_mobile_id'];
        $event = $data['event'];

        $qBanner = $this->db->query('SELECT 
											*
										from t_pis_popup_banner 
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

					$qBannerUser = $this->db->query("SELECT *, COUNT(*) as cn FROM t_pis_popup_banner_user WHERE banner_user_id = " . $userId . " and banner_popup_id = " . $idBanner)->getRow();
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

                    $this->apiModel->base_insert($insert,'t_pis_popup_banner_user');

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

    public function information(){
        $query = $this->db->query('SELECT * from t_pis_information where is_active=1 and DATE(NOW()) < date(date_insert) +interval 1 MONTH limit 5')->getResult();
        
        if (count($query) > 0) {
            $ret['status'] = 1;
            $ret['message'] = 'Success';
            $ret['data'] = $query;
            return $this->response->setJSON($ret);
        }else{
            $ret['status'] = 1;
            $ret['message'] = 'Data Not Found';
            return $this->response->setJSON($ret);

        }
    }

    public function updateFcm(){
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $data = $queryArray;
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

    public function ratingApps(){
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $postdata = $queryArray;
        $idUser = addslashes($postdata['user_mobile_id']);
        $email = addslashes($postdata['mobile_email']);
        $rating = addslashes($postdata['rating']);
        $review = addslashes($postdata['review']);
        $type = addslashes($postdata['type']);
        $versi = addslashes($postdata['versi']);
        $data = [
            'user_id' => $idUser,
            'user_email' => $email,
            'user_rating' => $rating,
            'user_review' => $review,
            'type' => $type,
            'versi' => $versi,
            'ip' => $this->request->getIPAddress()
        ];
        if ( $this->apiModel->base_insert($data,'t_pis_user_rating')) {
            $this->db->query("UPDATE m_user_mobile set user_mobile_rating='1' where id=? ",array($idUser));
            $ret['status'] = 1;
            $ret['message'] = 'Success';
            
            return $this->response->setJSON($ret);
        } else {
            $ret['status'] = 0;
            $ret['message'] = 'Failed Insert';
            
            return $this->response->setJSON($ret);
        }
    }

    public function deleteUser(){
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $data = $queryArray;
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

    public function addressPoint()
	{
        $data = $this->request->getPost();
        $lat = addslashes($data['lat']);
        $long = addslashes($data['long']);

        $dataPoint = $this->curlpoint($lat,$long);
        $deco = json_decode($dataPoint);

        if($deco->status == 1){
            return $this->response->setJSON($dataPoint);
        }else{
            $response = [
                        'status' => 1,
                        'message' => 'Data Not Found'
                    ];
            return $this->response->setJSON($response);
        }

	}


	public function addressPlace()
	{
        $data = $this->request->getPost();
        $search = addslashes($data['search']);

        $fixstring = str_replace(' ', '%20', $search);
        $dataPoint = $this->curlgeo($fixstring);
        $deco = json_decode($dataPoint);

        if($deco->status == 1){
            return $this->response->setJSON($dataPoint);
        }else{
            $response = [
                        'status' => 1,
                        'message' => 'Data Not Found'
                    ];
            return $this->response->setJSON($response);
        }
	}

    public function aduan(){
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $data = $queryArray;
        $aduan_email = addslashes($data['aduan_email']);
        $aduan_user_id = addslashes($data['aduan_user_id']);
        $aduan_judul = addslashes($data['aduan_judul']);
        $aduan_detail = addslashes($data['aduan_detail']);
        $aduan_lampiran = addslashes($data['aduan_lampiran']);
        $aduan_ip = $this->request->getIPAddress();

        if(!empty($aduan_lampiran) ){
            $filename1 = $this->genNamefile();
            $file1 = '/home/ngi/php/php74/trans_tangerang/public/uploads/aduan/'.$filename1.'.png';

            //local
            // $file1 = '/Users/ngibookpro/Documents/project/php/transtng/public/uploads/aduan/'.$filename1.'.png';

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
        $datapost = file_get_contents('php://input');

        $datadec = $this->decrypted($datapost);
        parse_str($datadec, $queryArray);

        $data = $queryArray;
        $userId = $data['user_mobile_id'];

        $query = $this->db->query("SELECT id,aduan_judul,aduan_detail,aduan_reply,aduan_email,
        CONCAT('".base_url()."/',aduan_lampiran) as aduan_image,CONCAT('".base_url()."/',aduan_reply_lampiran) as aduan_reply_image from t_aduan where aduan_user_id = '".addslashes($userId)."' order by id desc")->getResult();
        
        if(empty($query)){
            return $this->response->setJSON(res_notfound(1, "Data Not Found"));
        }else{
            return $this->response->setJSON(res_success(1, 'Success', $query));
        }
    }


    public function curlpoint($lat,$long)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://trans.my.id/tjog/pis/api_v2/addressPoint',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('lat' => $lat,'long' => $long),
		CURLOPT_HTTPHEADER => array(
			'Authorization: Basic dGpvZ2phOjFzdGltM3c0',
			'Cookie: ci_session=AWYCbgc3UD5UdVN2BTtUZAM3DThRIgd3V2UCIQRwBWwCalw9DVsNaFc1BXFVa1N0VjYDZg85BT5XcQA9UDdSZQRiVDBUNQFnADIMNQ43CWEBZAJkBzBQN1Q3UzwFY1Q2Az8NMFE2B2FXMQIwBDoFYQJgXDINPQ04V2kFcVVrU3RWNgNkDzsFPldxAGZQcVIOBDJUYFQ3AXMAYgxwDnQJJwE8AicHOFA1VDxTPwUjVGEDMg0sUTEHNlc2AnwEMgU9AjJcfQ09DSNXagUgVWpTNlY8A28PKQVxVyAAalBzUg4EMlRjVDYBbwBzDCEOPAl2AT0CZgczUD5ULFNVBW5UJgNzDW9RYQdqV1ICJwRtBXECbFw%2BDWENLldmBX1VYlM%2BViIDZw8pBT9XIAA1UDBSYgRpVCZUPwFgAHQMdw5YCWQBZAIgB2tQclRnU3EFeFR3AzwNa1E6BzVXNgJkBDYFNgI9XGQNMw04V2kFaFUjUz1WNQNvDykFcVcgAGpQc1IOBDdUZVQnAWAAJQw4DnQJPwE3Am4HIFAmVDVTeA%3D%3D'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;

	}

	public function curlgeo($search)
	{
		header('Content-Type: application/json');

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://trans.my.id/tjog/pis/api_v2/addressPlace',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('search' => $search),
		CURLOPT_HTTPHEADER => array(
			'Authorization: Basic dGpvZ2phOjFzdGltM3c0',
			'Cookie: ci_session=AWYCbgc3UD5UdVN2BTtUZAM3DThRIgd3V2UCIQRwBWwCalw9DVsNaFc1BXFVa1N0VjYDZg85BT5XcQA9UDdSZQRiVDBUNQFnADIMNQ43CWEBZAJkBzBQN1Q3UzwFY1Q2Az8NMFE2B2FXMQIwBDoFYQJgXDINPQ04V2kFcVVrU3RWNgNkDzsFPldxAGZQcVIOBDJUYFQ3AXMAYgxwDnQJJwE8AicHOFA1VDxTPwUjVGEDMg0sUTEHNlc2AnwEMgU9AjJcfQ09DSNXagUgVWpTNlY8A28PKQVxVyAAalBzUg4EMlRjVDYBbwBzDCEOPAl2AT0CZgczUD5ULFNVBW5UJgNzDW9RYQdqV1ICJwRtBXECbFw%2BDWENLldmBX1VYlM%2BViIDZw8pBT9XIAA1UDBSYgRpVCZUPwFgAHQMdw5YCWQBZAIgB2tQclRnU3EFeFR3AzwNa1E6BzVXNgJkBDYFNgI9XGQNMw04V2kFaFUjUz1WNQNvDykFcVcgAGpQc1IOBDdUZVQnAWAAJQw4DnQJPwE3Am4HIFAmVDVTeA%3D%3D'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}

    






}
