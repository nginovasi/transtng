<?php namespace App\Modules\Pomudik\Controllers;

use App\Modules\Pomudik\Models\PomudikModel;
use App\Core\BaseController;

class PomudikAjax extends BaseController
{
    private $pomudikModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pomudikModel = new PomudikModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    function po_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.po_name as 'text' FROM m_po a where a.is_deleted='0'";
        $where = ["a.po_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    function po_class_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.class_name as 'text' FROM m_class a where a.is_deleted='0'";
        $where = ["a.class_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    function po_seatmap_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.seat_map_name as 'text' FROM m_seat_map a where a.is_deleted='0'";
        $where = ["a.seat_map_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function idarmadamudik_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.armada_name as 'text' FROM m_armada_mudik a where a.is_deleted='0'";
        $where = ["a.armada_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function idrute_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.route_name as 'text' 
                    FROM m_route a 
                    where a.is_deleted='0'
                    and a.kategori_angkutan_id = 5";
        $where = ["a.route_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    // get paguyuban seats
    public function bus_seats_get()
    {
        $id = $this->request->getPost('id');
        
        $busSeats = $this->db->query("SELECT a.open, b.*, c.transaction_booking_name, c.transaction_nik, d.billing_is_paguyuban, e.paguyuban_mudik_id, f.paguyuban_mudik_name, e.paguyuban_name, e.paguyuban_email, e.paguyuban_no_wa, e.paguyuban_no_ktp, e.paguyuban_no_kk, d.billing_user_id, g.user_mobile_email as 'billing_user_nama'
                                        FROM t_jadwal_mudik a
                                        JOIN t_jadwal_seat_mudik b
                                            ON a.id = b.jadwal_id
                                        LEFT JOIN t_transaction_mudik c
                                            ON b.transaction_id = c.id
                                        LEFT JOIN t_billing_mudik d
                                            ON c.billing_id = d.id
                                        LEFT JOIN t_paguyuban_mudik_detail e
                                            ON b.id = e.jadwal_seat_mudik_id
                                        LEFT JOIN t_paguyuban_mudik f
                                            ON e.paguyuban_mudik_id = f.id
                                        LEFT JOIN m_user_mobile g
                                            ON d.billing_user_id = g.id
                                        WHERE a.is_deleted = 0
                                        AND a.id = " . $id . "")->getResult();

        echo json_encode($busSeats);
    } 

    // get seat from truck by jadwal
    public function truck_seats_get()
    {
        $id = $this->request->getPost('id');
        
        $truckSeats = $this->db->query("SELECT id, quota_paguyuban
                                        FROM t_jadwal_motis_mudik
                                        WHERE id = " . $id . "
                                        ")->getRow();

        $truckFully = $this->db->query("SELECT c.*, a.id as jadwal_motis_id, b.motis_user_id, d.user_mobile_email as motis_user_name, b.motis_armada_id, e.armada_name as motis_armada_name
                                        FROM t_jadwal_motis_mudik a
                                        join t_billing_motis_mudik b
                                        on a.id = b.motis_jadwal_id
                                        join t_motis_manifest_mudik c
                                        on b.id = c.motis_billing_id
                                        join m_user_mobile d
                                        on b.motis_user_id = d.id
                                        join m_armada_motis_mudik e
                                        on b.motis_armada_id = e.id
                                        WHERE a.id = " . $id . "
                                        AND b.motis_is_paguyuban = 1
                                        AND b.motis_cancel = 0
                                        AND b.motis_status_payment = 1
                                        AND b.motis_status_verif = 1
                                    ")->getResult();

        $data = [];
        for($i = 0; $i < $truckSeats->quota_paguyuban; $i++) {
            if(@$truckFully[$i]) {
                $terminalToFrom = $this->db->query("SELECT a.motis_armada_id AS motis_armada_to_id, b.armada_name AS motis_armada_to_name
                                                    FROM t_billing_motis_mudik a
                                                    JOIN m_armada_motis_mudik b
                                                        ON a.motis_armada_id = b.id
                                                    WHERE a.motis_user_id = " . @$truckFully[$i]->motis_user_id . "
                                                    AND NOT a.motis_jadwal_id = " . @$truckFully[$i]->jadwal_motis_id . "
                                                    AND a.motis_is_paguyuban = 1
                                                    AND a.motis_cancel = 0
                                                    AND a.motis_status_payment = 1
                                                    AND a.motis_status_verif = 1
                                                    ")->getRow();

                if($terminalToFrom) {
                    @$truckFully[$i]->motis_armada_to_id = $terminalToFrom->motis_armada_to_id;
                    @$truckFully[$i]->motis_armada_to_name = $terminalToFrom->motis_armada_to_name;
                }
            }

            array_push($data, @$truckFully[$i]);
        }

        echo json_encode($data);
    }     
    
    // get jadwal mudik by eo
    // where :
    // open = 0
    // is_deleted = 0
    public function idjadwalmudikrute_select_get()
    {
        $data = $this->request->getGet();

        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        $cekChildUsers = $this->db->query("SELECT d.* 
                                            FROM m_user_web a
                                            JOIN m_instansi_detail b
                                            ON a.instansi_detail_id = b.id
                                            JOIN m_instansi_detail c
                                            ON b.id = c.instansi_detail_id
                                            JOIN m_user_web d
                                            ON c.id = d.instansi_detail_id
                                            WHERE a.id = " . $iduser . "")->getResult();

        foreach($cekChildUsers as $cekChildUser) {
            array_push($idArrUser, $cekChildUser->id);
        }

        $query = "SELECT a.id, CONCAT(case when a.open = '0' then '*Paguyuban' else '*Umum' end, ' - ' , b.armada_name, ' - ', c.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )') as text
                    from t_jadwal_mudik a
                    join m_armada_mudik b
                    on a.jadwal_armada_id = b.id
                    JOIN m_route c
                    ON a.jadwal_route_id = c.id
                    where c.kategori_angkutan_id = 5
                    
                    and a.is_deleted = 0
					
                    ";

        $where = ["CONCAT(b.armada_name, ' - ', c.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )')"];

        parent::_loadSelect2($data, $query, $where);
    }   

    // get jadwal mudik motis (rute name <> jadwal date depart <> jadwal time depart <> jadwal date arrived <> jadwal time arrive)
    // where :
    // open = 0
    // jadwal is_deleted = 0
    public function idjadwalmotisrute_select_get()
    {
        $data = $this->request->getGet();

        $query = "SELECT a.id, CONCAT(b.route_name, ' ~ ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )') as text
                    from t_jadwal_motis_mudik a
                    join m_route b
                    on a.jadwal_route_id = b.id
                    where a.is_deleted = 0
                    -- and open = 0
                    ";

        $where = ["CONCAT(b.route_name, ' ~ ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )')"];

        parent::_loadSelect2($data, $query, $where);
    }   

    // get paguyuban by eo
    public function idpaguyubanmudik_select_get()
    {
        $data = $this->request->getGet();

        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        $cekChildUsers = $this->db->query("SELECT d.* 
                                            FROM m_user_web a
                                            JOIN m_instansi_detail b
                                            ON a.instansi_detail_id = b.id
                                            JOIN m_instansi_detail c
                                            ON b.id = c.instansi_detail_id
                                            JOIN m_user_web d
                                            ON c.id = d.instansi_detail_id
                                            WHERE a.id = " . $iduser . "")->getResult();

        foreach($cekChildUsers as $cekChildUser) {
            array_push($idArrUser, $cekChildUser->id);
        }

        $query = "SELECT a.id, a.paguyuban_mudik_name as text
                    FROM t_paguyuban_mudik a
                    WHERE a.is_deleted = 0
                    AND a.created_by IN (" . implode(',', $idArrUser) . ")
                    ";
        $where = ["a.paguyuban_mudik_name"];

        parent::_loadSelect2($data, $query, $where);
    }
    
    public function jadwal_bus_seat_id_select_get() {
        $data = $this->request->getGet();

        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        $cekChildUsers = $this->db->query("SELECT d.* 
                                            FROM m_user_web a
                                            JOIN m_instansi_detail b
                                            ON a.instansi_detail_id = b.id
                                            JOIN m_instansi_detail c
                                            ON b.id = c.instansi_detail_id
                                            JOIN m_user_web d
                                            ON c.id = d.instansi_detail_id
                                            WHERE a.id = " . $iduser . "")->getResult();

        foreach($cekChildUsers as $cekChildUser) {
            array_push($idArrUser, $cekChildUser->id);
        }
        
        $query = "SELECT a.id, CONCAT(b.armada_name, ' - ', c.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )') as text
                    FROM t_jadwal_mudik a
                    JOIN m_armada_mudik b
                    ON a.jadwal_armada_id = b.id
                    JOIN m_route c
                    ON a.jadwal_route_id = c.id
                    WHERE a.is_deleted = 0
                    AND a.open = 0
                    AND c.kategori_angkutan_id = 5
                    AND a.created_by IN (" . implode(',', $idArrUser) . ")
                    ";


        $where = ["CONCAT(b.armada_name, ' - ', c.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )')"];

        parent::_loadSelect2($data, $query, $where);
    }
    
    public function jadwal_bus_seat_map_id_select_get() {
        $id = $this->request->getPost('id');

        $query = $this->db->query("SELECT c.seat_map_name, c.seat_map_left, c.seat_map_right, c.seat_map_row, c.seat_map_last, c.seat_map_capacity,
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'id', d.id,
                            'jadwal_id', d.jadwal_id,
                            'seat_map_id', d.seat_map_id,
                            'seat_map_detail_name', d.seat_map_detail_name,
                            'seat_map_use', d.seat_map_use,
                            'seat_group_baris', d.seat_group_baris, 
                            'transaction_id', d.transaction_id,
                            'transaction_nik', e.transaction_nik,
                            'transaction_booking_name', e.transaction_booking_name
                        )
                    ) as seat
                    FROM t_jadwal_mudik a
                    LEFT JOIN m_armada_mudik b
                    ON a.jadwal_armada_id = b.id
                    LEFT JOIN m_seat_map c
                    ON b.armada_sheet_id = c.id
                    JOIN t_jadwal_seat_mudik d
                    ON c.id = d.seat_map_id
                    LEFT JOIN t_transaction_mudik e
                    ON d.transaction_id = e.id
                    WHERE a.open = 0
                    AND a.id = " . $id . "
                    AND a.is_deleted = 0
                    AND d.jadwal_id = " . $id . "
                    group by d.jadwal_id")->getRow();

        echo json_encode($query);
    }

    public function detail_seats_get()
    {
        $id = $this->request->getPost('id');

        $busSeats = $this->db->query("select b.*
                                        from t_jadwal_seat_mudik a
                                        join t_transaction_mudik b
                                        on a.transaction_id = b.id
                                        where a.id = " . $id . "
                                        ")->getRow();

        echo json_encode($busSeats);
    }

    public function email_select_get()
    {
        $data = $this->request->getGet();

        $query = "SELECT b.billing_user_id as 'id', b.user_mobile_email as 'text'
                    FROM t_jadwal_mudik a
                    JOIN (
                        SELECT a.id, a.billing_code, a.billing_qty, a.billing_user_id, a.billing_jadwal_id, b.user_mobile_email
                        FROM t_billing_mudik a	
                        JOIN m_user_mobile b
                            ON a.billing_user_id = b.id
                        WHERE a.billing_status_payment = 1
                        AND a.billing_cancel = 0
                        AND a.billing_status_verif != 2
                        GROUP BY a.billing_jadwal_id, billing_user_id
                        ORDER BY a.billing_user_id ASC
                    ) b
                    ON a.id = b.billing_jadwal_id
                    GROUP BY billing_user_id
                    HAVING COUNT(billing_user_id) > 1";
                    
        $where = ["b.user_mobile_email"];

        parent::_loadSelect2($data, $query, $where);
    }

    // get email mobile role publuc
    public function email_mobile_public_select_get()
    {
        $data = $this->request->getGet();
    
        $query = "SELECT id, user_mobile_email as 'text'
                    FROM m_user_mobile
                    WHERE user_mobile_role = 1
                    AND is_deleted = 0
                    AND id NOT IN (
                        select billing_user_id
                        from t_billing_mudik
                        where billing_is_paguyuban = 0
                        group by billing_user_id
                    )
                    ";
                    
        $where = ["user_mobile_email"];

        parent::_loadSelect2($data, $query, $where);
    }

    // public function armada_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     // print_r('<pre>');
    //     // print_r($data);
    //     // print_r('</pre>');
    //     $query = "SELECT a.id, concat('(' , count(b.motis_armada_id) , '  Terisi)', ' || ', a.armada_code, ' || ', a.armada_name, ' || ' , a.armada_label ) AS 'text' , a.jadwal_motis_mudik_id
    //     FROM m_armada_motis_mudik a 
    //     LEFT JOIN t_billing_motis_mudik b ON b.motis_armada_id = a.id
    //     WHERE a.is_deleted = '0' AND a.jadwal_motis_mudik_id != 'null' 
    //     GROUP BY b.motis_armada_id, a.id";
    //     $where = ["a.armada_name", "a.jadwal_motis_mudik_id"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    public function armada_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, concat('(' , count(b.motis_armada_id) , '  Terisi)', ' || ', a.armada_code, ' || ', a.armada_name, ' || ' , a.armada_label ) AS 'text' , a.jadwal_motis_mudik_id
        FROM m_armada_motis_mudik a 
        LEFT JOIN t_billing_motis_mudik b ON b.motis_armada_id = a.id
        WHERE a.is_deleted = '0' AND a.jadwal_motis_mudik_id != 'null' AND a.jadwal_motis_mudik_id = " . $data['id_jadwal'] . "
        GROUP BY b.motis_armada_id, a.id, a.jadwal_motis_mudik_id  ";
        $where = ["a.jadwal_motis_mudik_id"];

        parent::_loadSelect2($data, $query, $where);
    }
    
    function jadwal_motis_mudik_id_select_get()
    {
        $data = $this->request->getGet();
        
        $query = "SELECT a.id, CONCAT(b.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )') as text
                    FROM t_jadwal_motis_mudik a
                    JOIN m_route b
                    ON a.jadwal_route_id = b.id
                    WHERE a.is_deleted = 0
                    ";

        $where = ["CONCAT(b.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )')"];

        parent::_loadSelect2($data, $query, $where);
    }

     public function armada_mudik_select_get()
    {
        $data = $this->request->getGet();

        $query = "SELECT a.id, a.text
                    FROM (
                        SELECT a.id, a.armada_name as 'text', a.is_deleted
                        FROM m_armada_motis_mudik a
                        LEFT JOIN t_billing_motis_mudik b
                            ON a.id = b.motis_armada_id
                        WHERE a.is_deleted = 0
                        AND a.jadwal_motis_mudik_id = ".$data['id_jadwal']."
                        GROUP BY a.id
                    ) a
                    where a.is_deleted = 0";
        
        $where = ["a.text"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function armada_balik_select_get()
    {
        $data = $this->request->getGet();

        $jadwalMotis = $this->db->query("SELECT b.*
                                            FROM t_jadwal_motis_mudik a
                                            JOIN m_route b
                                            ON a.jadwal_route_id = b.id
                                            WHERE a.id = 37
                                            AND b.is_deleted = 0;
                                            ")->getRow();

        $jadwalMotisBalik = $this->db->query("SELECT b.* 
                                                FROM m_route a
                                                JOIN t_jadwal_motis_mudik b
                                                    ON a.id = b.jadwal_route_id
                                                WHERE a.terminal_from_id = ".$jadwalMotis->terminal_to_id."
                                                AND a.terminal_to_id = ".$jadwalMotis->terminal_from_id."
                                                AND a.is_deleted = 0")->getRow();

        $query = "SELECT a.id, a.text
                    FROM (
                        SELECT a.id, a.armada_name as 'text', a.is_deleted
                        FROM m_armada_motis_mudik a
                        LEFT JOIN t_billing_motis_mudik b
                            ON a.id = b.motis_armada_id
                        WHERE a.is_deleted = 0
                        AND a.jadwal_motis_mudik_id = ".$jadwalMotisBalik->id."
                        GROUP BY a.id
                    ) a
                    where a.is_deleted = 0";
        
        $where = ["a.text"];

        parent::_loadSelect2($data, $query, $where);
    }
}
