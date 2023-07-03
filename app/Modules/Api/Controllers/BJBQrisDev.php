<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class BJBQrisDev extends BaseController
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

    private function orderId(){
		$uniqid_ = uniqid('QRIS');
		$micro_date = microtime();
		$date_array = explode(" ",$micro_date);
		$date = date("Y-m-d H:i:s",$date_array[1]);
		return $uniqid_.$this->randChar();
	}

    private function randChar(){
		$seed = str_split('abcdefghijklmnopqrstuvwxyz'
		     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		     .'0123456789');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 2) as $k) $rand .= $seed[$k];
		return $rand;
	}

    public function generate(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        $req_data = json_decode($this->request->getBody(),true);

        $orderId = $this->orderId();
        $nomor_transaksi = $req_data['nomor_transaksi'];
        $tanggal = $req_data['tanggal'];
        $jam = $req_data['jam'];
        $nominal_transaksi = $req_data['nominal_transaksi'];
        $jenis_transaksi = $req_data['jenis_transaksi'];
        $device_id = $req_data['device_id'];
        $kode_lambung = $req_data['kode_lambung'];
        $kode_jalur = $req_data['kode_jalur'];
        $bank = $req_data['bank'];
        $qris = $orderId.".".$nominal_transaksi.".".$tanggal.".".$jam.".".$device_id;

        $req_trx['order_id']= $orderId;
        $req_trx['no_trx']= $nomor_transaksi;
        $req_trx['tanggal']= $tanggal;
        $req_trx['jam']= $jam;
        $req_trx['amount']= $nominal_transaksi;
        $req_trx['kode_bis']= $kode_lambung;
        $req_trx['jalur']= $kode_jalur;
        $req_trx['jenis']= $jenis_transaksi;
        $req_trx['device_id']= $device_id;
        $req_trx['qris']= $qris;

        if($this->apiModel->base_insert($req_trx,'t_qris_bjb')){
            $data['order_id'] = $orderId;
            $data['nomor_transaksi'] = $nomor_transaksi;
            $data['nominal_transaksi'] = $nominal_transaksi;
            $data['jenis_transaksi'] = $jenis_transaksi;
            $data['qris'] = $qris;

            $res['success'] = true;
            $res['status'] = 100;
            $res['message'] = "Sukses";
            $res['data'] = $data;
        } else {
            $res['success'] = false;
            $res['status'] = 102;
            $res['message'] = "Gagal gagal";
            $res['data'] = null;
        }

        return $this->response->setJSON($res);
    }

    public function status(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        $req_data = json_decode($this->request->getBody(),true);

        $orderId = $req_data['order_id'];

        $trxData = $this->db->query("SELECT *
                                    FROM t_qris_bjb 
                                    WHERE order_id ='$orderId'")->getRow();

        if($trxData){
            if($trxData->status == 1){
                $status = 'Paid';
            } else {
                // $this->db->query("UPDATE t_qris_bjb SET status = 1 WHERE order_id ='$orderId'");
                $status = 'Pending';
            }

            $resData['order_id'] = $trxData->order_id;
            $resData['nomor_transaksi'] = $trxData->no_trx;
            $resData['tanggal'] = $trxData->tanggal;
            $resData['jam'] = $trxData->jam;
            $resData['nominal_transaksi'] = $trxData->amount;
            $resData['jenis_transaksi'] = $trxData->jenis;
            $resData['status'] = $status;

            $res['success'] = true;
            $res['status'] = 100;
            $res['message'] = "Sukses";
            $res['data'] = $resData;
        } else {
            $res['success'] = false;
            $res['status'] = 103;
            $res['message'] = "Transaksi tidak ditemukan";
            $res['data'] = null;
        }

        return $this->response->setJSON($res);
    }

    public function scanQR(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        $req_data = json_decode($this->request->getBody(),true);

        $qr_code = $req_data['qr_code'];

        $encrypter = $this->initEncrypter();
        
        try{
            $log_petugas = json_decode($encrypter->decrypt(hex2bin($qr_code)));
            $action = (isset($log_petugas->status)?$log_petugas->status:'');

            if($action == 'login'){
                $userData = $this->db->query("SELECT * FROM m_user_web WHERE user_qr_login ='$qr_code' AND is_deleted = 0")->getRow();
                if ($userData) {
                    $userId = $userData->id;
                    $userName = $userData->user_web_username;
                    $email = $userData->user_web_email;
                    
                    $deviceData = $this->db->query("SELECT * FROM ref_haltebis WHERE device_id ='$device_id' AND is_deleted = 0")->getRow();
                    
                    if($deviceData){
                        $kodeBis = $deviceData->kode_haltebis;
                        $jalurId = $deviceData->jalur_id;
                    }else{
                        $kodeBis = '';
                        $jalurId = '';
                    }

                    $log['petugas_id'] = $userId;
                    $log['aktivitas'] = 'Login';
                    $log['kode_bis'] = $kodeBis;
                    $log['jalur'] = $jalurId;
                    $log['device_id'] = $device_id;

                    $this->apiModel->base_insert($log,'log_petugas');
                    $this->db->query("UPDATE m_user_web SET last_login_tob_at = NOW() WHERE id ='$userId'");

                    $user['user_id'] = $userId;
                    $user['user_name'] = $userName;
                    $user['user_email'] = $email;

                    $res['success'] = true;
                    $res['status'] = 100;
                    $res['message'] = "Login Sukses";
                    $res['type'] = "Login";
                    $res['data'] = $user;
                } else {
                    $res['success'] = false;
                    $res['status'] = 102;
                    $res['type'] = "Login";
                    $res['message'] = "Login QR tidak ditemukan";
                    $res['data'] = null;
                }
            }elseif($action == 'logout'){
                $userData = $this->db->query("SELECT * FROM m_user_web WHERE user_qr_logout ='$qr_code' AND is_deleted = 0")->getRow();
                if ($userData) {
                    $userId = $userData->id;
                    $userName = $userData->user_web_username;
                    $email = $userData->user_web_email;
                    
                    $deviceData = $this->db->query("SELECT * FROM ref_haltebis WHERE device_id ='$device_id' AND is_deleted = 0")->getRow();
                    
                    if($deviceData){
                        $kodeBis = $deviceData->kode_haltebis;
                        $jalurId = $deviceData->jalur_id;
                    }else{
                        $kodeBis = '';
                        $jalurId = '';
                    }

                    $log['petugas_id'] = $userId;
                    $log['aktivitas'] = 'Logout';
                    $log['kode_bis'] = $kodeBis;
                    $log['jalur'] = $jalurId;
                    $log['device_id'] = $device_id;

                    $this->apiModel->base_insert($log,'log_petugas');
                    $this->db->query("UPDATE m_user_web SET last_logout_tob_at = NOW() WHERE id ='$userId'");

                    $user['user_id'] = $userId;
                    $user['user_name'] = $userName;
                    $user['user_email'] = $email;

                    $res['success'] = true;
                    $res['status'] = 100;
                    $res['message'] = "Logout Sukses";
                    $res['type'] = "Logout";
                    $res['data'] = $user;
                } else {
                    $res['success'] = false;
                    $res['status'] = 102;
                    $res['message'] = "Logout QR tidak ditemukan";
                    $res['type'] = "Logout";
                    $res['data'] = null;
                }
            } else {
                $res['success'] = false;
                $res['status'] = 104;
                $res['message'] = "Login / Logout Gagal";
                $res['type'] = "Login";
                $res['data'] = null;
            }
        } catch (\Exception $e){
            $trxData = $this->db->query("SELECT * FROM t_qris_bjb WHERE qris ='$qr_code'")->getRow();

            if($trxData){
                
                if($trxData->status == 0){
                    $this->db->query("UPDATE t_qris_bjb SET status = 1 WHERE qris ='$qr_code'");
                }

                $status = 'Paid';
    
                $resData['order_id'] = $trxData->order_id;
                $resData['nomor_transaksi'] = $trxData->no_trx;
                $resData['tanggal'] = $trxData->tanggal;
                $resData['jam'] = $trxData->jam;
                $resData['nominal_transaksi'] = $trxData->amount;
                $resData['jenis_transaksi'] = $trxData->jenis;
                $resData['status'] = $status;
    
                $res['success'] = true;
                $res['status'] = 100;
                $res['type'] = "QRIS BJB";
                $res['message'] = "Sukses";
                $res['data'] = $resData;
            } else {
                $res['success'] = false;
                $res['status'] = 103;
                $res['type'] = "QRIS BJB";
                $res['message'] = "Transaksi tidak ditemukan";
                $res['data'] = null;
            }
        }

        return $this->response->setJSON($res);
    }

    function initEncrypter(){
		$config         = new \Config\Encryption();
		$config->key    = getenv('app.encrypt.key');
		$config->driver = 'OpenSSL';

		return \Config\Services::encrypter($config);
	}

}
