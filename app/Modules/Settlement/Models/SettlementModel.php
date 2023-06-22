<?php

namespace App\Modules\Settlement\Models;

use App\Core\BaseModel;

class SettlementModel extends BaseModel {

    public function loadBatchSttlBCA($data, $user_id) {
        $result = [];
        foreach($data as $key => $val) {
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

                    $jumlah = explode(" ", $val[3]);

                    $existingData = $this->db->query("SELECT * 
                                                        FROM sttl_bca_paid
                                                        WHERE date_trx = " . "'" . date_format($dateTrx, "Y-m-d") . "'" . "
                                                        AND sttl_num = " . "'" . $sttlNum . "'" . "
                                                        AND no_reff = " . "'" . $description[7] . "'" . "")->getNumRows();

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
                            "amount" => doubleval(str_replace(",", "", $jumlah[0])),
                            "type_trx" => $jumlah[1],
                            "last_balance" => str_replace(",", "", $val[4]),
                            "created_by" => $user_id
                        ];
                    }
                }
            }
        }

        return $result;
    }

    public function loadBatchSttlBNI($data, $user_id) {
        $result = [];

        foreach($data as $key => $val) {
            if($val[0] != "") {
                $datePaid = date_format(date_create($val[1]), "Y-m-d H:i:s");

                if(strlen($val[4]) == 110) {
                    $dateTrx = date_format(date_create(substr($val[4], 84, 4) . substr($val[4], 82, 2) . substr($val[4], 80, 2)), "Y-m-d");
                } else if(strlen($val[4]) >= 110 && $val[6] == "D") {
                    $dateTrx = null;
                } else {
                    $dateTrx = null;
                }

                if(strpos($val[5], ',')) {
                    $amount = intval(doubleval(str_replace(",", "", $val[5])));
                } else {
                    $amount = intval(doubleval($val[5]));
                }

                $existingData = $this->db->query("SELECT *
                                                    FROM sttl_bni_paid
                                                    WHERE date_paid = " . "'" . $datePaid . "'" . "
                                                    AND no_journal = " . "'" . $val[3] . "'" . "
                                                ")->getNumRows();

                if($existingData == 0) {
                    $result[] = (object) [
                        "date_paid" => $datePaid,
                        "branch" => $val[2],
                        "no_journal" => $val[3],
                        "description" => $val[4],
                        "date_trx" => $dateTrx,
                        "amount" => $amount,
                        "dc" => $val[6],
                        "balance" => $val[7],
                        "created_by" => $user_id
                    ];
                }
            }
        }

        return $result;
    }

    public function loadBatchSttlBRI($data, $user_id) {
        $result = [];

        foreach($data as $key => $val) {
            if(strlen($val[1]) == 40) {
                $datePaid = dateFormatYYSlash($val[0]);
                $dateSttl = dateFormatYY(substr($val[1], 25, 6));

                $existingData = $this->db->query("SELECT *
                                                    FROM sttl_bri_paid
                                                    WHERE date_sttl = " . "'" . $dateSttl . "'" . "
                                                    AND ref_trx = " . "'" . $val[1] . "'" . "
                                                ")->getNumRows();

                if($existingData == 0) {
                    $result[] = (object) [
                        "date_paid" => $datePaid,
                        "date_sttl" => $dateSttl,
                        "ref_trx" => $val[1],
                        "file_1" => substr($val[1], 0, 15),
                        "body" => substr($val[1], 16, 8),
                        "file_2" => substr($val[1], 25, 6),
                        "shift" => substr($val[1], 32, 2),
                        "count" => intval(substr($val[1], 36, 4)),
                        "kredit" => substr(str_replace(".", "", $val[3]), 0, -2),
                        "created_by" => $user_id
                    ];
                }
            }
        }

        return $result;
    }

    public function loadBatchSttlMandiri($data, $user_id) {
        $result = [];

        foreach($data as $key => $val) {

            $description = trim($val[4]) . " " . trim($val[5]);

            if(strlen($val[0]) == 13 && strlen($description) >= 79) {
                $dateTrx = dateFormat00(substr($val[4], 18, 12));

                if(strlen($val[1]) == 19) {
                    $datePaidCol = dateFormatSlashAndDot($val[1]);
                } else {
                    $datePaidCol = dateFormat00SlashAndDot($val[1]);
                }

                if(strpos(strtolower($description), strtolower("MANDIRIA")) || strpos(strtolower($description), strtolower("MANDIRIR"))) {
                    $noReff = substr($description, 49, 30);
                    $datePaid = dateFormatNonSpaceyyyymmddhhmmss(substr($description, 21, 14));
                };

                if(strpos(strtolower($description), strtolower("BTNA"))) {
                    $noReff = substr($description, 45, 30);
                    $datePaid = null;
                };

                if(strpos(strtolower($description), strtolower("MTS-Trf-Kredit"))) {
                    $noReff = substr($description, 56, 37);
                    $datePaid = $datePaidCol;
                };

                if(strpos(strtolower($description), strtolower("MANDIRI Trans Jogya"))) {
                    $noReff = substr($description, strpos($description, "MANDIRI Trans Jogya ") + 20);
                    $datePaid = $datePaidCol;
                };

                if(strpos(strtolower($description), strtolower("MANDIRI Transjogja - Bus"))) {
                    $noReff = substr($description, strpos($description, "MANDIRI Transjogja - Bus") + 24);
                    $datePaid = $datePaidCol;
                };

                if(strpos(strtolower($description), strtolower("MANDIRI Trans JogjaA"))) {
                    $noReff = substr($description, strpos($description, "MANDIRI Trans JogjaA") + strlen("20"));
                    $datePaid = $datePaidCol;
                };

                $existingData = $this->db->query("SELECT *
                                                    FROM sttl_mandiri_paid
                                                    WHERE sttl_file_name = " . "'" . $val[4] . "'" . "
                                                    AND no_ref = " . "'" . $noReff . "'" . "
                                                ")->getNumRows();

                if($existingData == 0) {
                    $result[] = (object) [
                        "date_trx" => $dateTrx,
                        "description" => $description,
                        "date_paid_col" => $datePaidCol,
                        "sttl_file_name" => $val[0],
                        "no_ref" => $noReff,
                        "date_paid" => $datePaid,
                        "amount" => intval(doubleval(str_replace(",", "", $val[8]))),
                        "brance_code" => "99105"
                    ];
                }
            }
        }

        return $result;
    }

    public function insertLogSttl($bank, $nameFile, $data, $user_id) {
        if(count($data) > 0) {
            $dateSttl = $data[0]->date_paid . ' s/d ' . $data[count($data) - 1]->date_paid;
        } else {
            $dateSttl = "trx fail";
        }

        $result = [
            "filename" => $nameFile,
            "bank" => $bank,
            "ttl_sttl" => count($data),
            "date_sttl" => $dateSttl,
            "created_by" => $user_id
        ];

        parent::base_insert($result, 'log_import_sttl');
    }
    
}