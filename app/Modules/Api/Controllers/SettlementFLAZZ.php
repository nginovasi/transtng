<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class SettlementFlazz extends BaseController
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

    private function addSequence($seq, $max) 
    {
        $trailing = "";
        $length = $seq;
        for($i = $length; $i < $max; $i++) {
            $trailing .= "0";
        }
        $trailing .= $seq;
        
        return $trailing;
    }

    public function flazz() 
    {
        $settlementBca = $this->db->query("SELECT * 
                                            FROM sttl_flazz 
                                            WHERE filename = 0")->getResult();

        $groupBySettlementBCA = groupby($settlementBca, "date_trx");

        foreach($groupBySettlementBCA as $key => $val) {
            $date = str_replace("-", "", $key);

            $dirSttl = 'public/settlement';
            $dirSttl1 = 'public/settlement/flazz';
            $dirSttl2 = 'public/settlement/flazz/' . $date;

            if (!is_dir($dirSttl)) mkdir($dirSttl, 0777, true);
            
            if (!is_dir($dirSttl1)) mkdir($dirSttl1, 0777, true);

            if (!is_dir($dirSttl2)) mkdir($dirSttl2, 0777, true);

            $count = count(glob($dirSttl2 . "/*"));
            $time = ($count + 1) . "-" . date('His');
            $timex = Date('His');
            $dirSttl4 = 'public/settlement/flazz/' . $date . '/' . $time;

            if (!is_dir($dirSttl4)) mkdir($dirSttl4, 0777, true);

            $groupBySettlementBCATID = groupby($val, 'tid');

            $indexgroupBySettlementBCATID = 0;

            foreach($groupBySettlementBCATID as $key1 => $val1) {
                $fileTid = $key1;
                $arrayBca = $val1;

                $body = $val1[0] ? $val1[0]->header : "FAILED";

                $lastBatchNumber = $this->db->query("SELECT * 
                                                        FROM sttl_flazz 
                                                        WHERE tid = '" . $fileTid ."'
                                                        GROUP BY batch_number
                                                        ORDER BY batch_number desc
                                                        LIMIT 0,2")->getRow();

                $filename = $date . $fileTid . $this->addSequence($lastBatchNumber->batch_number + $indexgroupBySettlementBCATID + 1, 2) . $timex;
                $path = 'public/settlement/flazz/' . $date . '/' . $time . '/' . $filename . '.txn';
                $path2 = 'public/settlement/flazz/' . $date . '/' . $time . '/' . $filename . '.ok';

                if (!file_exists($path2) && !file_exists($path)) {
                    $createFile = fopen($path, "w");
                    $createFile2 = fopen($path2, "w");
                }

                $getDeductresTotal = array_map(function ($data) {
                    return substr($data->deductres, 46, 10) . "00";
                }, $arrayBca);

                $joinDeductresTotal = function($first, $second) {
                    return $first + $second;
                };

                $total = array_reduce($getDeductresTotal, $joinDeductresTotal);

                foreach ($arrayBca as $key2 => $val2) {
                    $recordType = "0220";
                    $cardNo = substr($val2->deductres, 0, 16);
                    $expiryDate = substr($val2->deductres, 161, 4);
                    $amount = substr($val2->deductres, 46, 10);
                    $sysTraceNo = $this->addSequence($indexgroupBySettlementBCATID + 1, 5);
                    $trxTime = substr($val2->deductres, 30, 6);
                    $trxDate = substr($val2->deductres, 26, 4);
                    $posEntry = "021";
                    $nii = "006";
                    $posCond = "00";
                    $tid = substr($val2->deductres, 135, 8);
                    $mid = str_pad(substr($val2->deductres, 123, 12), 15, "0", STR_PAD_LEFT);
                    $invoiceNo = $this->addSequence($indexgroupBySettlementBCATID + 1, 5);
                    $updateStatus = substr($val2->deductres, 58, 1);

                    $productId = substr($cardNo, 6, 2);
                    $pursueExpiryDate = substr($val2->deductres, 16, 6);
                    $pursuePan = $cardNo;
                    $balance = substr($val2->deductres, 36, 10) . "00";
                    $pursueId = substr($cardNo, 6, 10);
                    $rTerm = substr($val2->deductres, 73, 16);
                    $ctc = substr($val2->deductres, 113, 6);
                    $cCard = substr($val2->deductres, 105, 8);
                    $cTerm = substr($val2->deductres, 89, 16);
                    $ttc = substr($val2->deductres, 65, 8);
                    $cdc = substr($val2->deductres, 119, 4);
                    $trn = substr($val2->deductres, 143, 16);
                    $year = substr($val2->deductres, 22, 4);
                    $psamId = substr($val2->deductres, 57, 8);
                    $flazzVersion = substr($val2->deductres, 159, 2);
                    $flazzOther = substr($val2->deductres, 165, 20);

                    $paymentInfo = $productId . $pursueExpiryDate . $pursuePan . $balance . $pursueId . $rTerm . $ctc . $cCard . $cTerm . $ttc . $cdc . $trn . $year . $psamId . $flazzVersion . $flazzOther;
                    $bodies = $recordType . $cardNo . $expiryDate . $amount . $sysTraceNo . $trxTime . $trxDate . $posEntry . $nii . $posCond . $tid . $mid . $invoiceNo . $updateStatus . $paymentInfo;

                    $body .= $bodies;

                    if($indexgroupBySettlementBCATID == count($groupBySettlementBCATID) - 1) {
                        $firstHalf = "0500" . $tid . $mid . $this->addSequence($lastBatchNumber->batch_number + $indexgroupBySettlementBCATID + 1, 5) . $this->addSequence(count($arrayBca), 2) . $this->addSequence($total, 11);
                        $secondHalf = $date . substr($date, 4, 4) . substr($date, 0, 4);
                        $blank = "";
                        for($blankI = 0; $blankI < 182; $blankI++) {
                            $blank .= " ";
                        }
                        $body .= $firstHalf . $secondHalf . $blank;

                        fwrite($createFile, $body);
                    }
                }

                $indexgroupBySettlementBCATID++;
            }

            $notes = "REKAPITULASI FILE SETTLEMENT BCA TRANSAKSI TANGGAL " . $key . "\r\n\r\n";
            $recordTransaction = 0;
            $allRecordError = 0;

            $scandir = array_diff(scandir($dirSttl4), array('.', '..'));
            $scandirArray = (array) $scandir;

            foreach($scandirArray as $keySA => $valSA) {
                if(explode(".", $valSA)[1] == "txn") {
                    $notes .= "File " . explode(".", $valSA)[0];

                    $recordTransactionPerFile = 0;
                }

                return $this->response->setJSON(explode(".", $valSA)[1]);

                dd(explode(".", $valSA)[1]);
            }

            return $this->response->setJSON($scandirArray);
            
        }

        return $this->response->setJSON($groupBySettlementBCA);
    }

    // private function orderId(){
	// 	$uniqid_ = uniqid('QRIS');
	// 	$micro_date = microtime();
	// 	$date_array = explode(" ",$micro_date);
	// 	$date = date("Y-m-d H:i:s",$date_array[1]);
	// 	return $uniqid_.$this->randChar();
	// }

    // private function randChar(){
	// 	$seed = str_split('abcdefghijklmnopqrstuvwxyz'
	// 	     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
	// 	     .'0123456789');
	// 	shuffle($seed);
	// 	$rand = '';
	// 	foreach (array_rand($seed, 2) as $k) $rand .= $seed[$k];
	// 	return $rand;
	// }

    // public function generate(){
    //     $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
    //     $req_data = json_decode($this->request->getBody(),true);

    //     $orderId = $this->orderId();
    //     $nomor_transaksi = $req_data['nomor_transaksi'];
    //     $tanggal = $req_data['tanggal'];
    //     $jam = $req_data['jam'];
    //     $nominal_transaksi = $req_data['nominal_transaksi'];
    //     $jenis_transaksi = $req_data['jenis_transaksi'];
    //     $device_id = $req_data['device_id'];
    //     $kode_lambung = $req_data['kode_lambung'];
    //     $kode_jalur = $req_data['kode_jalur'];
    //     $bank = $req_data['bank'];
    //     $qris = $orderId.".".$nominal_transaksi.".".$tanggal.".".$jam.".".$device_id;

    //     $req_trx['order_id']= $orderId;
    //     $req_trx['no_trx']= $nomor_transaksi;
    //     $req_trx['tanggal']= $tanggal;
    //     $req_trx['jam']= $jam;
    //     $req_trx['amount']= $nominal_transaksi;
    //     $req_trx['kode_bis']= $kode_lambung;
    //     $req_trx['jalur']= $kode_jalur;
    //     $req_trx['jenis']= $jenis_transaksi;
    //     $req_trx['device_id']= $device_id;
    //     $req_trx['qris']= $qris;

    //     if($this->apiModel->base_insert($req_trx,'t_qris_bjb')){
    //         $data['order_id'] = $orderId;
    //         $data['nomor_transaksi'] = $nomor_transaksi;
    //         $data['nominal_transaksi'] = $nominal_transaksi;
    //         $data['jenis_transaksi'] = $jenis_transaksi;
    //         $data['qris'] = $qris;

    //         $res['success'] = true;
    //         $res['status'] = 100;
    //         $res['message'] = "Sukses";
    //         $res['data'] = $data;
    //     } else {
    //         $res['success'] = false;
    //         $res['status'] = 102;
    //         $res['message'] = "Gagal gagal";
    //         $res['data'] = null;
    //     }

    //     return $this->response->setJSON($res);
    // }

    // public function status(){
    //     $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
    //     $req_data = json_decode($this->request->getBody(),true);

    //     $orderId = $req_data['order_id'];

    //     $trxData = $this->db->query("SELECT *
    //                                 FROM t_qris_bjb 
    //                                 WHERE order_id ='$orderId'")->getRow();

    //     if($trxData){
    //         if($trxData->status == 1){
    //             $status = 'Paid';
    //         } else {
    //             // $this->db->query("UPDATE t_qris_bjb SET status = 1 WHERE order_id ='$orderId'");
    //             $status = 'Pending';
    //         }

    //         $resData['order_id'] = $trxData->order_id;
    //         $resData['nomor_transaksi'] = $trxData->no_trx;
    //         $resData['tanggal'] = $trxData->tanggal;
    //         $resData['jam'] = $trxData->jam;
    //         $resData['nominal_transaksi'] = $trxData->amount;
    //         $resData['jenis_transaksi'] = $trxData->jenis;
    //         $resData['status'] = $status;

    //         $res['success'] = true;
    //         $res['status'] = 100;
    //         $res['message'] = "Sukses";
    //         $res['data'] = $resData;
    //     } else {
    //         $res['success'] = false;
    //         $res['status'] = 103;
    //         $res['message'] = "Transaksi tidak ditemukan";
    //         $res['data'] = null;
    //     }

    //     return $this->response->setJSON($res);
    // }

    // public function scanQR(){
    //     $device_id = $this->request->getHeader("X-DEVICE-ID")->getValue();
    //     $req_data = json_decode($this->request->getBody(),true);

    //     $qr_code = $req_data['qr_code'];

    //     $encrypter = $this->initEncrypter();
        
    //     try{
    //         $log_petugas = json_decode($encrypter->decrypt(hex2bin($qr_code)));
    //         $action = (isset($log_petugas->status)?$log_petugas->status:'');

    //         if($action == 'login'){
    //             $userData = $this->db->query("SELECT * FROM m_user_web WHERE user_qr_login ='$qr_code' AND is_deleted = 0")->getRow();
    //             if ($userData) {
    //                 $userId = $userData->id;
    //                 $userName = $userData->user_web_username;
    //                 $email = $userData->user_web_email;
                    
    //                 $deviceData = $this->db->query("SELECT * FROM ref_haltebis WHERE device_id ='$device_id' AND is_deleted = 0")->getRow();
                    
    //                 if($deviceData){
    //                     $kodeBis = $deviceData->kode_haltebis;
    //                     $jalurId = $deviceData->jalur_id;
    //                 }else{
    //                     $kodeBis = '';
    //                     $jalurId = '';
    //                 }

    //                 $log['petugas_id'] = $userId;
    //                 $log['aktivitas'] = 'Login';
    //                 $log['kode_bis'] = $kodeBis;
    //                 $log['jalur'] = $jalurId;
    //                 $log['device_id'] = $device_id;

    //                 $this->apiModel->base_insert($log,'log_petugas');
    //                 $this->db->query("UPDATE m_user_web SET last_login_tob_at = NOW() WHERE id ='$userId'");

    //                 $user['user_id'] = $userId;
    //                 $user['user_name'] = $userName;
    //                 $user['user_email'] = $email;

    //                 $res['success'] = true;
    //                 $res['status'] = 100;
    //                 $res['message'] = "Login Sukses";
    //                 $res['type'] = "Login";
    //                 $res['data'] = $user;
    //             } else {
    //                 $res['success'] = false;
    //                 $res['status'] = 102;
    //                 $res['type'] = "Login";
    //                 $res['message'] = "Login QR tidak ditemukan";
    //                 $res['data'] = null;
    //             }
    //         }elseif($action == 'logout'){
    //             $userData = $this->db->query("SELECT * FROM m_user_web WHERE user_qr_logout ='$qr_code' AND is_deleted = 0")->getRow();
    //             if ($userData) {
    //                 $userId = $userData->id;
    //                 $userName = $userData->user_web_username;
    //                 $email = $userData->user_web_email;
                    
    //                 $deviceData = $this->db->query("SELECT * FROM ref_haltebis WHERE device_id ='$device_id' AND is_deleted = 0")->getRow();
                    
    //                 if($deviceData){
    //                     $kodeBis = $deviceData->kode_haltebis;
    //                     $jalurId = $deviceData->jalur_id;
    //                 }else{
    //                     $kodeBis = '';
    //                     $jalurId = '';
    //                 }

    //                 $log['petugas_id'] = $userId;
    //                 $log['aktivitas'] = 'Logout';
    //                 $log['kode_bis'] = $kodeBis;
    //                 $log['jalur'] = $jalurId;
    //                 $log['device_id'] = $device_id;

    //                 $this->apiModel->base_insert($log,'log_petugas');
    //                 $this->db->query("UPDATE m_user_web SET last_logout_tob_at = NOW() WHERE id ='$userId'");

    //                 $user['user_id'] = $userId;
    //                 $user['user_name'] = $userName;
    //                 $user['user_email'] = $email;

    //                 $res['success'] = true;
    //                 $res['status'] = 100;
    //                 $res['message'] = "Logout Sukses";
    //                 $res['type'] = "Logout";
    //                 $res['data'] = $user;
    //             } else {
    //                 $res['success'] = false;
    //                 $res['status'] = 102;
    //                 $res['message'] = "Logout QR tidak ditemukan";
    //                 $res['type'] = "Logout";
    //                 $res['data'] = null;
    //             }
    //         } else {
    //             $res['success'] = false;
    //             $res['status'] = 104;
    //             $res['message'] = "Login / Logout Gagal";
    //             $res['type'] = "Login";
    //             $res['data'] = null;
    //         }
    //     } catch (\Exception $e){
    //         $trxData = $this->db->query("SELECT * FROM t_qris_bjb WHERE qris ='$qr_code'")->getRow();

    //         if($trxData){
                
    //             if($trxData->status == 0){
    //                 $this->db->query("UPDATE t_qris_bjb SET status = 1 WHERE qris ='$qr_code'");
    //             }

    //             $status = 'Paid';
    
    //             $resData['order_id'] = $trxData->order_id;
    //             $resData['nomor_transaksi'] = $trxData->no_trx;
    //             $resData['tanggal'] = $trxData->tanggal;
    //             $resData['jam'] = $trxData->jam;
    //             $resData['nominal_transaksi'] = $trxData->amount;
    //             $resData['jenis_transaksi'] = $trxData->jenis;
    //             $resData['status'] = $status;
    
    //             $res['success'] = true;
    //             $res['status'] = 100;
    //             $res['type'] = "QRIS BJB";
    //             $res['message'] = "Sukses";
    //             $res['data'] = $resData;
    //         } else {
    //             $res['success'] = false;
    //             $res['status'] = 103;
    //             $res['type'] = "QRIS BJB";
    //             $res['message'] = "Transaksi tidak ditemukan";
    //             $res['data'] = null;
    //         }
    //     }

    //     return $this->response->setJSON($res);
    // }

    // function initEncrypter(){
	// 	$config         = new \Config\Encryption();
	// 	$config->key    = getenv('app.encrypt.key');
	// 	$config->driver = 'OpenSSL';

	// 	return \Config\Services::encrypter($config);
	// }

}
