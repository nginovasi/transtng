<?php

namespace App\Modules\Settlement\Models;

use App\Core\BaseModel;

class SettlementModel extends BaseModel {

    public function insertBatchSttlBCA($tableName, $data, callable $callback = NULL)
    {
        $this->db->transBegin();

        $result = [];
        foreach($data as $i => $val) {
            if(strlen($val[0]) == 5) {
                if(strlen($val[1]) >= 80) {
                    $description = explode(" ", $val[1]);

                    $datePaid = date_create(implode("-", array_reverse(explode("/", $description[2]))));
                    $dateTimeSttl = date_create(implode("-", array_reverse(explode("/", $description[2]))) . " " . $description[3]);
                    $dateTrx = date_create(substr($description[7], 0, 8));

                    if(count($description) >= 9) {
                        $sttlNum = $description[8];
                    } else {
                        $sttlNum = 0;
                    }

                    $existingData = $this->db->query("SELECT * 
                                                        FROM sttl_bca_paid
                                                        WHERE date_trx = " . "'" . date_format($dateTrx, "Y-m-d") . "'" . "
                                                        AND sttl_num = " . "'" . $sttlNum . "'" . "
                                                        AND no_reff = " . "'" . $description[7] . "'" . "
                                                    ")->getNumRows();

                    if($existingData == 0) {
                        $result[] = (object) [
                            "description" => $val[1],
                            "date_paid" => date_format($datePaid, "Y-m-d"),
                            "date_sttl" => date_format($dateTimeSttl, "Y-m-d H:i:s"),
                            "mid" => substr($description[5], 3, 12),
                            "merchant" => $description[6],
                            "date_trx" => date_format($dateTrx, "Y-m-d"),
                            "tid" => substr($description[7], 8, 18),
                            "sttl_num" => $sttlNum,
                            "no_reff" => $description[7],
                            "branch" => $val[2],
                            "amount" => doubleval(str_replace(",", "", explode(" ", $val[3])[0])),
                            "type_trx" => explode(" ", $val[3])[1],
                            "last_balance" => str_replace(",", "", $val[4]),
                            "created_by" => $this->session->get('id')
                        ];
                    }
                } else {
                    echo json_encode(array('success' => false, 'message' => 'format keterangan salah !'));
                    return;
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'format tanggal transaksi salah !'));
                return;
            }
        }

        if(count($result) < 1) {
            $this->db->transRollback();
		    $this->db->transComplete();

            return false;
        }

        parent::base_insertUpdateBatch($result, $tableName);

        // var_dump($result);

        // $log = [
        //     "filename" => "",
        //     "bank" => 4,
        //     "ttl_sttl" => count($result),
        //     "date_sttl" => $result[0]->date_paid . ' - ' . $result[count($result) - 1]->date_paid
        // ];

        // var_dump($log);
        // die;

        if ($this->db->transStatus() === FALSE) {
		    $this->db->transRollback();
		    $this->db->transComplete();

            return false;
		} else {
		    $this->db->transCommit();
		    $this->db->transComplete();

            return true;
		}

        // if ($this->baseModel->base_insertBatch($result, $tableName)) {
        //     echo json_encode(array('success' => true, 'message' => 'success'));
        // } else {
        //     echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
        // }
    }
    
}