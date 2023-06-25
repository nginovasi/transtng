<?php

namespace App\Modules\Settlement\Models;

use App\Core\BaseModel;

class SettlementModel extends BaseModel 
{
    public function loadBatchSttlBCA($data, $user_id) {
        $result = [];
        foreach($data as $key => $val) {
            if(strlen($val[0]) == 5) {
                if(strlen($val[1]) >= 80) {
                    $description = explode(" ", $val[1]);

                    $datePaid = dateFormatSlashReverseFromddmmyyyyToyyyymmdd($description[2]);
                    $dateTimeSttl = dateFormatSlashReverseFromddmmyyyyToyyyymmddhis($description[2], $description[3]);
                    $dateTrx = dateFormatStringNoSpaceFromyyyymmddToyyymmdd(substr($description[7], 0, 8));

                    if(count($description) >= 9) {
                        $sttlNum = $description[8];
                    } else {
                        $sttlNum = null;
                    }

                    $jumlah = explode(" ", $val[3]);

                    $existingData = $this->db->query("SELECT * 
                                                        FROM sttl_bca_paid
                                                        WHERE date_trx = " . "'" . $dateTrx . "'" . "
                                                        AND sttl_num = " . "'" . $sttlNum . "'" . "
                                                        AND no_reff = " . "'" . $description[7] . "'" . "")->getNumRows();

                    if($existingData == 0) {
                        $result[] = (object) [
                            "description" => $val[1],
                            "date_paid" => $datePaid,
                            "date_sttl" => $dateTimeSttl,
                            "mid" => substr($description[5], 3, 9),
                            "merchant" => $description[6],
                            "date_trx" => $dateTrx,
                            "tid" => substr($description[7], 8, 10),
                            "sttl_num" => $sttlNum,
                            "no_reff" => $description[7],
                            "branch" => $val[2],
                            "kredit" => doubleval(str_replace(",", "", $jumlah[0])),
                            "type_trx" => $jumlah[1],
                            "last_balance" => doubleval(str_replace(",", "", $val[4])),
                            "created_by" => $user_id
                        ];
                    }
                } else {
                    echo json_encode(array("success" => false, "message" => "Format keterangan salah", "data" => $result));
                    return;
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Format tanggal transaksi salah", "data" => $result));
                return;
            }
        }

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function loadBatchSttlBNI($data, $user_id) {
        $result = [];

        foreach($data as $key => $val) {
            if($val[0] != "") {
                $datePaid = dateFormatSlashFromyyyymmddhisToyyymmdd($val[1]); 

                if(strlen($val[4]) == 110) {
                    $dateTrx = dateFormatStringNoSpaceFromddmmyyyToyyymmdd(substr($val[4], 80, 8));
                } else if(strlen($val[4]) >= 110 && $val[6] == "D") {
                    $dateTrx = null;
                } else {
                    $dateTrx = null;
                }

                if(strpos($val[5], ',')) {
                    $kredit = intval(doubleval(str_replace(",", "", $val[5])));
                } else {
                    $kredit = intval(doubleval($val[5]));
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
                        "kredit" => $kredit,
                        "dc" => $val[6],
                        "balance" => $val[7],
                        "created_by" => $user_id
                    ];
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Format no salah", "data" => $result));
                return;
            }
        }

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function loadBatchSttlBRI($data, $user_id) {
        $result = [];

        foreach($data as $key => $val) {
            if(strlen($val[1]) == 40) {
                $datePaid = dateFormatSlashFromddmmyyyyToyyyymmdd($val[0]);
                $dateSttl = dateFormatStringNoSpaceFromddmmyyyyToyyyymmdd(substr($val[1], 25, 6));

                $existingData = $this->db->query("SELECT *
                                                    FROM sttl_bri_paid
                                                    WHERE date_trx = " . "'" . $dateSttl . "'" . "
                                                    AND ref_trx = " . "'" . $val[1] . "'" . "
                                                ")->getNumRows();

                if($existingData == 0) {
                    $result[] = (object) [
                        "date_paid" => $datePaid,
                        "date_trx" => $dateSttl,
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
            } else {
                echo json_encode(array("success" => false, "message" => "Format transaksi salah", "data" => $result));
                return;
            }
        }

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function loadBatchSttlMandiri($data, $user_id) {
        $result = [];

        foreach($data as $key => $val) {
            $description = trim($val[4]) . " " . trim($val[5]);

            if(strlen($val[0]) == 13 && strlen($description) >= 79) {
                $dateTrx = dateFormatStringNoSpaceFromddmmyyyyToyyyymmddFull(substr($val[4], 18, 8));

                if(strlen($val[1]) == 19) {
                    $datePaidCol = dateFormatSlashAndDotFromddmmyyyyhisToyyyymmdd($val[1]);
                } else {
                    $datePaidCol = dateFormatSlashAndDotFromddmmyyhiToyyyymmdd($val[1]);
                }

                if(strpos(strtolower($description), strtolower("MANDIRIA")) || strpos(strtolower($description), strtolower("MANDIRIR"))) {
                    $noReff = substr($description, 49, 30);
                    $datePaid = dateFormatStringNoSpaceFromyyyymmddhisToyyymmddhis(substr($description, 21, 14));
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
                        "kredit" => intval(doubleval(str_replace(",", "", $val[8]))),
                        "brance_code" => "99105",
                        "created_by" => $user_id
                    ];
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Format account no & description salah pada baris " . ($key + 1), "data" => $result));
                return;          
            }
        }

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
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

    public function loadLapRekonBCA($date) {
        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                        c.date_paid AS date_paid, 
                                        c.ttl_trx,
                                        SUM(b.kredit) AS jml_trx,
                                        c.jml_trx_paid,
                                        c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                FROM (
                                    SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                    FROM (
                                        SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                        FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $date . "'))
                                    ) a
                                LEFT JOIN transaksi_bis b
                                ON a.tanggal = b.tanggal
                                LEFT JOIN (
                                    SELECT tanggal AS date_trx,
                                            date_paid,
                                            count(b.id) AS ttl_trx,
                                            sum(CASE WHEN b.kredit IS NOT NULL THEN b.kredit ELSE 0 END) as jml_trx_paid
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                            (SELECT 0 UNION ALL SELECT 1) AS b1,
                                            (SELECT 0 UNION ALL SELECT 1) AS b2,
                                            (SELECT 0 UNION ALL SELECT 1) AS b3,
                                            (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                    WHERE n > 0 
                                    AND n <= day(last_day('" . $date . "'))
                                    ) a
                                    LEFT JOIN sttl_bca_paid b
                                    ON a.tanggal = b.date_trx
                                    GROUP BY a.tanggal
                                ) c
                                ON b.tanggal = c.date_trx
                                WHERE b.is_dev = 0
                                AND jenis LIKE 'Flazz%'
                                GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        return $result;
    }

    public function loadLapRekonBRI($date) {
        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                            c.date_paid AS date_paid, 
                                            c.ttl_trx,
                                            SUM(b.kredit) AS jml_trx,
                                            c.jml_trx_paid,
                                            c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $date . "'))
                                    ) a
                                    LEFT JOIN transaksi_bis b
                                        ON a.tanggal = b.tanggal
                                    LEFT JOIN (
                                        SELECT tanggal AS date_trx,
                                                date_paid,
                                                COUNT(b.id) AS ttl_trx,
                                                sum(CASE WHEN b.kredit IS NOT NULL THEN b.kredit ELSE 0 END) as jml_trx_paid
                                        FROM (
                                            SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                            FROM (
                                                SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                                FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $date . "'))
                                        ) a
                                        LEFT JOIN sttl_bri_paid b
                                        ON a.tanggal = b.date_trx
                                        GROUP BY a.tanggal
                                    ) c
                                    ON b.tanggal = c.date_trx
                                    WHERE b.is_dev = 0
                                    AND jenis like 'BRIZZI%'
                                    GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        return $result;
    }

    public function loadLapRekonBNI($date) {
        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                            c.date_paid AS date_paid, 
                                            c.ttl_trx,
                                            SUM(b.kredit) AS jml_trx,
                                            c.jml_trx_paid,
                                            c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $date . "'))
                                    ) a
                                    LEFT JOIN transaksi_bis b
                                        ON a.tanggal = b.tanggal
                                    LEFT JOIN (
                                        SELECT tanggal AS date_trx,
                                                date_paid,
                                                COUNT(b.id) AS ttl_trx,
                                                sum(CASE WHEN b.kredit IS NOT NULL THEN b.kredit ELSE 0 END) as jml_trx_paid
                                        FROM (
                                            SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                            FROM (
                                                SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                                FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $date . "'))
                                        ) a
                                        LEFT JOIN sttl_bni_paid b
                                        ON a.tanggal = b.date_trx
                                        GROUP BY a.tanggal
                                    ) c
                                    ON b.tanggal = c.date_trx
                                    WHERE b.is_dev = 0
                                    AND jenis like 'Tapcash%'
                                    GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        return $result;
    }

    public function loadLapRekonMandiri($date) {
        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                            c.date_paid AS date_paid, 
                                            c.ttl_trx,
                                            SUM(b.kredit) AS jml_trx,
                                            c.jml_trx_paid,
                                            c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                        WHERE n > 0 
                                        AND n <= day(lASt_day('" . $date . "'))
                                    ) a
                                    LEFT JOIN transaksi_bis b
                                        ON a.tanggal = b.tanggal
                                    LEFT JOIN (
                                        SELECT tanggal AS date_trx,
                                                date_paid,
                                                count(b.id) AS ttl_trx,
                                                sum(CASE WHEN b.kredit IS NOT NULL THEN b.kredit ELSE 0 END) as jml_trx_paid
                                        FROM (
                                            SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $date . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                            FROM (
                                                SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                                FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $date . "'))
                                        ) a
                                        LEFT JOIN sttl_mandiri_paid b
                                        ON a.tanggal = b.date_trx
                                        GROUP BY a.tanggal
                                    ) c
                                    ON b.tanggal = c.date_trx
                                    WHERE b.is_dev = 0
                                    AND jenis LIKE 'E-Money%'
                                    GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        return $result;
    }
    
}