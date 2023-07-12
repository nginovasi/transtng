<?php namespace App\Modules\Api\Controllers\Settlement;

use App\Core\BaseController;
use App\Modules\Api\Models\ApiModel;

class Flazz extends BaseController
{
    private $apiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function test()
    {
        echo "test";
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

    public function generate()
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
   
}