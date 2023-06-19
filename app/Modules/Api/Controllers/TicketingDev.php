<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class TicketingDev extends BaseController
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

    public function setLambung(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        $req_data = json_decode($this->request->getBody(),true);
        $app_version = $req_data['app_version'];

        if($this->db->query("update ref_haltebis set app_version = '$app_version' where device_id ='$device_id'")){
            $midtid = $this->db->query("SELECT
                                        a.bri_mid,
                                        a.bri_tid,
                                        a.bri_pro_code,
                                        a.bni_mid,
                                        a.bni_tid,
                                        a.bni_marry_code,
                                        a.bca_mid,
                                        a.bca_tid,
                                        a.mdr_mid,
                                        a.mdr_tid,
                                        a.mdr_sam_operator,
                                        a.mdr_sam_uid,
                                        a.mdr_pin_code,
                                        b.kode_haltebis as kode_lambung,
                                        b.jalur_id
                                    FROM ref_midtid a 
                                    LEFT JOIN ref_haltebis b
                                        ON a.device_id = b.device_id
                                    WHERE a.device_id = '$device_id'
                                    AND a.is_deleted = 0
                                    AND b.is_deleted = 0")->getRow();

            // echo $this->db->getLastQuery();

            $tarif = $this->db->query("SELECT jenis, tarif, is_active FROM ref_tarif where is_deleted = 0")->getResult();

            $data['config'] = $midtid;
            $data['tarif'] = $tarif;
            $data['device_id'] = $device_id;

            if($midtid){
                $res['success'] = true;
                $res['status'] = 100;
                $res['message'] = "Sukses";
                $res['data'] = $data;
            } else {
                $res['success'] = false;
                $res['status'] = 101;
                $res['message'] = "Device ID tidak terdaftar";
                $res['data'] = null;
            }
        }else{
            $res['success'] = false;
            $res['status'] = 102;
            $res['message'] = "Gagal update versi aplikasi";
            $res['data'] = null;
        }

        return $this->response->setJSON($res);
    }

    public function updateMerryCode(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        
        $req_data = json_decode($this->request->getBody(),true);
        $bni_marry_code = $req_data['bni_marry_code'];

        $midtid = $this->db->query("SELECT *
                                    FROM ref_midtid a 
                                    WHERE a.device_id = '$device_id'
                                    AND a.is_deleted = 0")->getRow();

        if($midtid){
            if($this->db->query("UPDATE ref_midtid SET bni_marry_code = '$bni_marry_code' WHERE device_id ='$device_id'")){
                $data['bni_marry_code'] = $bni_marry_code;
                $data['device_id'] = $device_id;
                

                $res['success'] = true;
                $res['status'] = 100;
                $res['message'] = "Sukses";
                $res['data'] = $data;
            }else{
                $res['success'] = false;
                $res['status'] = 101;
                $res['message'] = "Gagal update marry code BNI";
                $res['data'] = null;
            }
        } else {
            $res['success'] = false;
            $res['status'] = 102;
            $res['message'] = "Device ID tidak terdaftar";
            $res['data'] = null;
        }

        return $this->response->setJSON($res);
    }

    public function failedTransaction(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        
        $req_data = json_decode($this->request->getBody(),true);
        $transaksi = $req_data['transaksi'];
        $kode_lambung = $req_data['kode_lambung'];
        $pesan_error = $req_data['pesan_error'];
        $prioritas = $req_data['prioritas'];

        $logError = [
            'device_id' => $device_id,
            'kode_bis' => $kode_lambung,
            'trx_type' => $transaksi,
            'msg'=> $pesan_error,
            'prority' => $prioritas
        ];

        if($this->apiModel->base_insert($logError,'log_failed_trx')){
            $res['success'] = true;
            $res['status'] = 100;
            $res['message'] = "Sukses";
            $res['data'] = $logError;
        }else{
            $res['success'] = false;
            $res['status'] = 101;
            $res['message'] = "Gagal update marry code BNI";
            $res['data'] = null;
        }

        return $this->response->setJSON($res);
    }

    public function logPower(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        
        $req_data = json_decode($this->request->getBody(),true);
        $kode_lambung = $req_data['kode_lambung'];
        $status_power = $req_data['status_power'];

        $logError = [
            'device_id' => $device_id,
            'kode_bis' => $kode_lambung,
            'status' => $status_power
        ];

        if($this->apiModel->base_insert($logError,'log_power')){
            $res['success'] = true;
            $res['status'] = 100;
            $res['message'] = "Sukses";
            $res['data'] = $logError;
        }else{
            $res['success'] = false;
            $res['status'] = 108;
            $res['message'] = "Gagal update marry code BNI";
            $res['data'] = null;
        }

        return $this->response->setJSON($res);
    }

    public function transaction(){
        $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
        $arrDataTrx = json_decode($this->request->getBody());
        $arrNoTrx = array();
        // print_r($arrDataTrx);
        foreach ($arrDataTrx as $data) {
            $this->db->transStart();
            $nomor_kartu = $data->nomor_kartu;
            $nomor_transaksi = $data->nomor_transaksi;
            $tanggal = $data->tanggal;
            $jam = $data->jam;
            $nominal_transaksi = $data->nominal_transaksi;
            $sisa_saldo = $data->sisa_saldo;
            $jenis_transaksi = $data->jenis_transaksi;
            $device_id = $data->device_id;
            $kode_lambung = $data->kode_lambung;
            $kode_jalur = $data->kode_jalur;
            $bank = $data->bank;
            $mid = $data->mid;
            $tid = $data->tid;
            $deduct_response = $data->deduct_response;

            $trx['no_kartu'] = $nomor_kartu;
            $trx['no_trx'] = $nomor_transaksi;
            $trx['tanggal'] = $tanggal;
            $trx['jam'] = $jam;
            $trx['kredit'] = $nominal_transaksi;
            $trx['saldo'] = $sisa_saldo;
            $trx['kode_bis'] = $kode_lambung;
            $trx['jalur'] = $kode_jalur;
            $trx['device_id'] = $device_id;
            $trx['jenis'] = $jenis_transaksi;

            try{
                $this->apiModel->base_insert($trx,'transaksi_bis');
            } catch (\Exception $e){}

            switch ($bank){
                case "E-Money":
                    $emoney['no_trx'] = $nomor_transaksi;
                    $emoney['kode_bis'] = $kode_lambung;
                    $emoney['body'] = $kode_lambung;
                    $emoney['device_id'] = $device_id;
                    $emoney['mid'] = $mid;
                    $emoney['tid'] = $tid;
                    $emoney['body'] = $deduct_response;
                    
                    try{
                        $this->apiModel->base_insert($emoney,'sttl_emoney');
                    } catch (\Exception $e){}

                break;

                case "FLAZZ":
                    $flazz['no_trx'] = $nomor_transaksi;
                    $flazz['kode_bis'] = $kode_lambung;
                    $flazz['device_id'] = $device_id;
                    $flazz['mid'] = $mid;
                    $flazz['tid'] = $tid;
                    $flazz['deductres'] = $deduct_response;

                    try{
                        $this->apiModel->base_insert($flazz,'sttl_flazz');
                    } catch (\Exception $e){}
                break;

                case "TapCash":
                    $tapcash['no_trx'] = $nomor_transaksi;
                    $tapcash['kode_bis'] = $kode_lambung;
                    $tapcash['body'] = $kode_lambung;
                    $tapcash['device_id'] = $device_id;
                    $tapcash['mid'] = $mid;
                    $tapcash['tid'] = $tid;
                    $tapcash['body'] = $deduct_response;

                    try{
                        $this->apiModel->base_insert($tapcash,'sttl_tapcash');
                    } catch (\Exception $e){}
                break;

                case "BRIZZI":
                    $brizzi['no_trx'] = $nomor_transaksi;
                    $brizzi['kode_bis'] = $kode_lambung;
                    $brizzi['body'] = $kode_lambung;
                    $brizzi['device_id'] = $device_id;
                    $brizzi['mid'] = $mid;
                    $brizzi['tid'] = $tid;
                    $brizzi['body'] = $deduct_response;

                    try{
                        $this->apiModel->base_insert($brizzi,'sttl_brizzi');
                    } catch (\Exception $e){}
                break;

                default:

                break;
            }

            $this->db->transComplete();
            if($this->db->transStatus() === true){
                // array_push($arrNoTrx,$nomor_transaksi);
            }

            array_push($arrNoTrx,$nomor_transaksi);
        }

        $notrx['nomor_transaksi'] = $arrNoTrx;
        $res['status'] = 1;
        $res['message'] = "Sukses";
        $res['data'] = $notrx;

        return $this->response->setJSON($res);
    }

    public function signatureService($payload,$client_secret,$timestamp){
        $minify = json_encode(json_decode($payload));
        $sha256 = hash('sha256', $minify);
        $lowercase = strtolower($sha256);
        $encriptsi = $lowercase;
        $data = $encriptsi.':'.$timestamp;
        $encSHA512 = $this->sha512($data,$client_secret);

        $encBase64 = base64_encode($encSHA512);

        return $encBase64;
    }

    function sha512($payload,$secret_key){
        $algo = 'sha512';
        $signed_payload = hash_hmac(
             $algo,
             $payload,
             $secret_key,
             true,
        );
        return $signed_payload;
    }
}
