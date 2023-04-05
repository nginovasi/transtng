<?php namespace App\Modules\Main\Models;

use App\Core\BaseModel;

class MainModel extends BaseModel
{
    public function getUsers()
    {
        return [
            UserEntity::of('PL0001', 'Mufid Jamaluddin'),
            UserEntity::of('PL0002', 'Andre Jhonson'),
            UserEntity::of('PL0003', 'Indira Wright'),
        ];
    }

     public function rampcheck_recode(){
        $rs = $this->db->query("select id,rampcheck_no,rampcheck_link_pdf from t_rampcheck where rampcheck_date=DATE_ADD(current_date(),INTERVAL -7 DAY) order by rampcheck_no,id");
        $n = 0;
        $ng = 0;
        $groupby[$ng] = '';
        foreach($rs->getResult() as $item){
            $n++;
            $ng++;
            $groupby[$n] = substr($item->rampcheck_no,0,strrpos($item->rampcheck_no, "/"));
            
            if($groupby[$n-1]!=$groupby[$n]){
                $ng=1;
            }
            $newrampcheck_no = substr($item->rampcheck_no, 0, strrpos($item->rampcheck_no, "/"))."/".str_pad($ng,4,"0",0);
            echo $newrampcheck_no." ".$item->rampcheck_no;
            if($item->rampcheck_no!==$newrampcheck_no){
                $query = "UPDATE t_rampcheck set rampcheck_no='".$newrampcheck_no."' WHERE id='".$item->id."' and rampcheck_no='".$item->rampcheck_no."'";
                $this->db->query($query);
                echo $query;
                echo "<br/>";
            }
            
        }
    }

    public function getTerminalCount()
    {
        return $this->db->query("select count(id) as ttl_terminal from m_terminal where terminal_type = 'A' and is_deleted = 0")->getResult();
    }

    public function getRampcheckCount()
    {
        // return $this->db->query("select count(id) as ttl_rampcheck from t_rampcheck where is_deleted = 0")->getResult();
        return $this->db->query("select count(id) as ttl_rampcheck from t_rampcheck where is_deleted = 0 and rampcheck_date = CURRENT_DATE")->getResult();
    }

    public function getTrayekCount()
    {
        return $this->db->query("select count(id) as ttl_trayek from m_trayek where is_deleted = 0")->getResult();
    }

    public function getDataTraffic()
    {
        $response = $this->db->query('select log_result from s_log_api_traffic_count order by created_at desc limit 1')->getResult();
        return $response;
    }

    public function getDataTerminal()
    {
        $response = $this->db->query('select * from m_terminal where terminal_type = "A" and is_deleted = 0 and terminal_lat != ""')->getResult();
        return $response;
    }

    public function getDataCctv()
    {
        $response = $this->db->query('select * from m_cctv where is_deleted = 0')->getResult();
        return $response;
    }

    public function getDataJto()
    {
        $response = $this->db->query('select * from m_jto where is_deleted = 0')->getResult();
        return $response;
    }

    public function getRuteMudik()
    {
        $response = $this->db->query("select a.*,b.kategori_angkutan_name from m_route a
                                      JOIN m_kategori_angkutan b on b.id = a.kategori_angkutan_id
                                      where a.is_deleted='0' and b.kategori_angkutan_name like '%mudik%'")->getResult();
        return $response;
    }

    public function getPoskoMudik()
    {
        $response = $this->db->query('select * from m_posko_mudik where is_deleted = 0')->getResult();
        return $response;
    }

    public function getPetugasLapangan()
    {
        $response = $this->db->query('select * from m_petugas_lapangan where is_deleted = 0')->getResult();
        return $response;
    }

    public function getRampcheckHistory()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');  
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT date_format(a.rampcheck_date, '%d-%m-%Y') AS rampcheck_date, count(a.id) AS ttl_rampcheck, 
            CASE WHEN b.rampcheck_kesimpulan_status = '0' THEN 'Diijinkan Operasional'
            WHEN b.rampcheck_kesimpulan_status = '1' THEN 'Peringatan/Perbaiki'
            WHEN b.rampcheck_kesimpulan_status = '2' THEN 'Tilang dan Dilarang Operasional'
            ELSE 'Dilarang Operasional'
            END AS rampcheck_kesimpulan_status
            , count(b.kesimpulan_id) AS ttl_kesimpulan
                    FROM t_rampcheck a
                    JOIN (
                        SELECT DISTINCT rampcheck_id, rampcheck_kesimpulan_status, id AS kesimpulan_id FROM t_rampcheck_kesimpulan
                    ) b ON b.rampcheck_id = a.id
                    INNER JOIN m_user_web c ON a.created_by=c.id
                    INNER JOIN m_instansi_detail d ON d.id = c.instansi_detail_id
                    WHERE a.is_deleted = '0' AND a.rampcheck_date >= DATE(NOW() - INTERVAL 7 DAY)
                    AND (a.created_by=? OR 
                        IF( POSITION(? IN d.kode)>0
                            , d.kode LIKE CONCAT_WS( 
                                '', 
                                LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1)
                                ,'%'
                                ) 
                            ,d.kode LIKE '000%'
                        ) 
                    )
                    GROUP BY a.rampcheck_date,b.rampcheck_kesimpulan_status
                    ORDER BY a.rampcheck_date asc, b.rampcheck_kesimpulan_status ASC", array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();
        }else{
            $response = $this->db->query("SELECT date_format(a.rampcheck_date, '%d-%m-%Y') AS rampcheck_date, count(a.id) AS ttl_rampcheck, 
            CASE WHEN b.rampcheck_kesimpulan_status = '0' THEN 'Diijinkan Operasional'
            WHEN b.rampcheck_kesimpulan_status = '1' THEN 'Peringatan/Perbaiki'
            WHEN b.rampcheck_kesimpulan_status = '2' THEN 'Tilang dan Dilarang Operasional'
            ELSE 'Dilarang Operasional'
            END AS rampcheck_kesimpulan_status
            , count(b.kesimpulan_id) AS ttl_kesimpulan
                    FROM t_rampcheck a
                    JOIN (
                        SELECT DISTINCT rampcheck_id, rampcheck_kesimpulan_status, id AS kesimpulan_id FROM t_rampcheck_kesimpulan
                    ) b ON b.rampcheck_id = a.id
                    WHERE a.is_deleted = '0' AND a.rampcheck_date >= DATE(NOW() - INTERVAL 7 DAY)
                    GROUP BY a.rampcheck_date,b.rampcheck_kesimpulan_status
                    ORDER BY a.rampcheck_date asc, b.rampcheck_kesimpulan_status asc")->getResultArray();
        }
        return $response;
    }

    public function getCountRampcheckToday()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');  
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT count(a.rampcheck_no) AS ttl_rampcheck
            FROM
            t_rampcheck a 
            inner join m_user_web b on a.created_by=b.id
            inner join m_instansi_detail c on c.id = b.instansi_detail_id
            WHERE a.is_deleted = '0' 
            AND a.rampcheck_date = CURRENT_DATE()
            AND (a.created_by=? OR 
                IF( POSITION(? IN c.kode)>0
                    , c.kode like CONCAT_WS( 
                        '', 
                        LEFT(c.kode,POSITION(? IN c.kode)+LENGTH(?)-1)
                        ,'%'
                        ) 
                    ,c.kode like '000%'
                ) 
            )", array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();    
        }else{
            $response = $this->db->query("SELECT count(rampcheck_no) AS ttl_rampcheck FROM t_rampcheck WHERE rampcheck_date = CURRENT_DATE() AND is_deleted='0'")->getResultArray();
            
        }
        return $response;
    }

    public function getCountRampcheckPerStatus()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');  
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT DISTINCT date_format(b.rampcheck_date, '%Y') AS year_rampcheck, count(b.id) AS ttl_rampcheck, 
            (SELECT count(a.id) FROM t_rampcheck a 
                        INNER JOIN m_user_web b ON a.created_by=b.id
                        INNER JOIN m_instansi_detail c ON c.id=b.instansi_detail_id
            WHERE date_format(a.rampcheck_date, '%m-%Y') = date_format(CURRENT_DATE(), '%m-%Y') AND a.is_deleted = 0 
              AND (a.created_by=? OR 
                                IF( POSITION(? IN c.kode)>0
                                    , c.kode LIKE CONCAT_WS( 
                                        '', 
                                        LEFT(c.kode,POSITION(? IN c.kode)+LENGTH(?)-1)
                                        ,'%'
                                        ) 
                                    ,c.kode LIKE '000%'
                                ) 
                                )
            ) AS this_month,
                        SUM(
                        CASE WHEN a.rampcheck_kesimpulan_status = '0' OR a.rampcheck_kesimpulan_status = '1' THEN 1
                        ELSE 0
                        END
                        ) AS laik,
                        SUM(
                        CASE WHEN a.rampcheck_kesimpulan_status = '2' OR a.rampcheck_kesimpulan_status = '3' THEN 1
                        ELSE 0
                        END
                        ) AS tidak_laik
                        FROM t_rampcheck_kesimpulan a
                        JOIN t_rampcheck b ON b.id = a.rampcheck_id
                        INNER JOIN m_user_web c on b.created_by=c.id
                        INNER JOIN m_instansi_detail d ON d.id=c.instansi_detail_id
                        WHERE b.is_deleted = '0' AND date_format(b.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
                        AND (b.created_by=? OR 
                                IF( POSITION(? IN d.kode)>0
                                    , d.kode LIKE CONCAT_WS( 
                                        '', 
                                        LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1)
                                        ,'%'
                                        ) 
                                    ,d.kode LIKE '000%'
                                ) 
                                )",array($iduser,$instansiId,$instansiId,$instansiId, $iduser,$instansiId,$instansiId,$instansiId))->getResultArray();
        } else {
            $response = $this->db->query("SELECT DISTINCT date_format(b.rampcheck_date, '%Y') AS year_rampcheck, count(b.id) AS ttl_rampcheck, (SELECT count(id) FROM t_rampcheck WHERE date_format(rampcheck_date, '%m-%Y') = date_format(CURRENT_DATE(), '%m-%Y') AND is_deleted = 0) AS this_month,
            SUM(
            CASE WHEN a.rampcheck_kesimpulan_status = '0' OR a.rampcheck_kesimpulan_status = '1' THEN 1
            ELSE 0
            END
            ) AS laik,
            SUM(
            CASE WHEN a.rampcheck_kesimpulan_status = '2' OR a.rampcheck_kesimpulan_status = '3' THEN 1
            ELSE 0
            END
            ) AS tidak_laik
            FROM t_rampcheck_kesimpulan a
            JOIN t_rampcheck b ON b.id = a.rampcheck_id
            INNER JOIN m_user_web c on b.created_by=c.id
            WHERE b.is_deleted = '0' AND date_format(b.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')")->getResultArray();
        }

        return $response;
    }

    public function getCountRampcheckPerInstansi()
    {
        $response = $this->db->query("SELECT a.instansi_detail_name, IF(b.user IS NULL, 0, b.user) AS user_admin, IF(c.user IS NULL, 0, c.user) AS user_petugas, IF(d.rampcheck IS NULL, 0, d.rampcheck) AS rampcheck
        FROM m_instansi_detail a
        LEFT JOIN ( SELECT a.instansi_detail_id, count(*) AS USER, kode FROM m_user_web a  INNER JOIN m_instansi_detail b ON b.id=a.instansi_detail_id WHERE a.instansi_detail_id IS NOT NULL AND a.is_deleted=0 AND b.is_deleted=0 GROUP BY a.instansi_detail_id ORDER BY a.instansi_detail_id) b
        ON a.id = b.instansi_detail_id
        LEFT JOIN ( SELECT a.instansi_detail_id, count(*) AS USER, kode FROM m_user_web a  INNER JOIN m_instansi_detail b ON b.id=a.instansi_detail_id WHERE a.instansi_detail_id IS NOT NULL AND a.is_deleted=0 AND b.is_deleted=0 GROUP BY a.instansi_detail_id ORDER BY a.instansi_detail_id
        ) c ON c.kode LIKE concat(b.kode,'.%')
        LEFT JOIN ( SELECT a.id,  b.created_by,  sum(b.rampcheck) AS rampcheck, IF(ROUND((LENGTH(c.kode)-LENGTH( REPLACE (c.kode, '.', ''))) / LENGTH('.')) = 2,SUBSTRING_INDEX(c.kode, '.', LENGTH(c.kode) - LENGTH(REPLACE(c.kode, '.', ''))),c.kode) AS kode_p  FROM m_user_web a LEFT JOIN (     SELECT k.created_by, count(*) AS rampcheck FROM t_rampcheck k     WHERE k.is_deleted = 0     GROUP BY k.created_by) b
        ON a.id = b.created_by
        LEFT JOIN m_instansi_detail c ON c.id=a.instansi_detail_id
        WHERE a.is_deleted = 0 AND c.is_deleted = 0
        GROUP BY kode_p ) d ON d.kode_p = a.kode
        WHERE ROUND((LENGTH(a.kode)-LENGTH( REPLACE (a.kode, '.', ''))) / LENGTH('.')) = 1 AND a.is_deleted=0 AND b.user > 0 AND c.user > 0 ORDER BY rampcheck DESC");
        $data = $response->getResultArray();
        return $data;
    }

    public function getTopTenRampcheckLocationPerBptd()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT DISTINCT b.jenis_lokasi_name, a.rampcheck_nama_lokasi,
            count(a.id) AS ttl_rampcheck, d.`instansi_detail_name` FROM t_rampcheck a
            INNER JOIN m_jenis_lokasi b ON b.id = a.rampcheck_jenis_lokasi_id
            INNER JOIN m_user_web c ON a.created_by=c.id
            INNER JOIN m_instansi_detail d ON d.id = c.instansi_detail_id
            WHERE a.is_deleted = '0'
            AND (
                a.created_by=?
                OR 
                IF( 
                    POSITION(? IN d.kode)>0, 
                        d.kode LIKE CONCAT_WS( '', LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1) ,'%'),
                        d.kode LIKE '000%')
                )
            AND date_format(a.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
                GROUP BY b.jenis_lokasi_name, a.rampcheck_nama_lokasi, d.instansi_detail_name
                ORDER BY count(a.id) DESC",array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();
        } else {
            $response = $this->db->query("SELECT DISTINCT b.jenis_lokasi_name, a.rampcheck_nama_lokasi,
            count(a.id) AS ttl_rampcheck, d.`instansi_detail_name` FROM t_rampcheck a
            INNER JOIN m_jenis_lokasi b ON b.id = a.rampcheck_jenis_lokasi_id
            INNER JOIN m_user_web c ON a.created_by=c.id
            INNER JOIN m_instansi_detail d ON d.id = c.instansi_detail_id
            WHERE a.is_deleted = '0'
            AND date_format(a.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
                GROUP BY b.jenis_lokasi_name, a.rampcheck_nama_lokasi, d.instansi_detail_name
                ORDER BY count(a.id) DESC")->getResultArray();
        }
            
        return $response;
    }

    public function getTopFiveUserRampcheckPerBptd()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT DISTINCT c.user_web_name,
            count(a.id) AS ttl_rampcheck, d.`instansi_detail_name` FROM t_rampcheck a
            INNER JOIN m_user_web c ON a.created_by=c.id
            INNER JOIN m_instansi_detail d ON d.id = c.instansi_detail_id
            WHERE a.is_deleted = '0'
            AND date_format(a.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
            AND (
                a.created_by=?
                OR 
                IF( 
                    POSITION(? IN d.kode)>0, 
                        d.kode LIKE CONCAT_WS( '', LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1) ,'%'),
                        d.kode LIKE '000%')
                )
                GROUP BY c.user_web_name, d.instansi_detail_name
                ORDER BY count(a.id) DESC",array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();
        } else {
            $response = $this->db->query("SELECT DISTINCT c.user_web_name,
            count(a.id) AS ttl_rampcheck, d.`instansi_detail_name` FROM t_rampcheck a
            INNER JOIN m_user_web c ON a.created_by=c.id
            INNER JOIN m_instansi_detail d ON d.id = c.instansi_detail_id
            WHERE a.is_deleted = '0'
            AND date_format(a.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
                GROUP BY c.user_web_name, d.instansi_detail_name
                ORDER BY count(a.id) DESC")->getResultArray();
        }
            
        return $response;
    }

    public function getCountRampcheckPerJenisAngkutan()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');
        if($this->session->get('instansi_detail_id') != null){
            $response = $this->db->query("SELECT DISTINCT b.jenis_angkutan_name, a.rampcheck_jenis_angkutan_id as jenis_angkutan_id, count(a.id) AS ttl
            FROM t_rampcheck a
            INNER JOIN m_jenis_angkutan b ON b.id = a.rampcheck_jenis_angkutan_id
            INNER JOIN m_user_web c ON a.created_by=c.id
            INNER JOIN m_instansi_detail d ON d.id=c.instansi_detail_id
            WHERE a.is_deleted = '0' AND date_format(a.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
                    AND (a.created_by=? OR 
                            IF( POSITION(? IN d.kode)>0
                                , d.kode LIKE CONCAT_WS( 
                                    '', 
                                    LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1)
                                    ,'%'
                                    ) 
                                ,d.kode LIKE '000%'
                            ) 
                    )
                    GROUP BY b.jenis_angkutan_name, a.rampcheck_jenis_angkutan_id", array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();
        } else {
            $response = $this->db->query("SELECT DISTINCT b.jenis_angkutan_name, a.rampcheck_jenis_angkutan_id as jenis_angkutan_id, count(a.id) AS ttl
            FROM t_rampcheck a
            INNER JOIN m_jenis_angkutan b ON b.id = a.rampcheck_jenis_angkutan_id
            INNER JOIN m_user_web c ON a.created_by=c.id
            INNER JOIN m_instansi_detail d ON d.id=c.instansi_detail_id
            WHERE a.is_deleted = '0' AND date_format(a.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
            GROUP BY b.jenis_angkutan_name, a.rampcheck_jenis_angkutan_id")->getResultArray();
        }
        return $response;
    }

    // model count armada bis by eo
    public function getCountArmadaBisByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 229);
        }

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

        // return $this->db->query("SELECT count(id) AS count_armada_bis
        //                             FROM m_armada_mudik
        //                             WHERE is_deleted = 0
        //                             AND created_by IN (" . implode(',', $idArrUser) . ")")->getRow();

        return $this->db->query("SELECT count(a.id) as count_armada_bis
                                FROM m_armada_mudik a 
                                INNER JOIN m_po b ON b.id = a.po_id
                                INNER JOIN m_seat_map c ON c.id = a.armada_sheet_id
                                INNER JOIN t_jadwal_mudik d ON d.jadwal_armada_id = a.id
                                WHERE a.is_deleted = '0' AND d.is_deleted = '0'")->getRow();
    }

    // model count jadwal mudik bis by eo
    public function getCountJadwalMudikByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        return $this->db->query("SELECT count(id) as count_jadwal_mudik,
                                        SUM(CASE WHEN open = '1' THEN 1 ELSE 0 END) as open, 
                                        SUM(CASE WHEN open = '0' THEN 1 ELSE 0 END) as close
                                    FROM t_jadwal_mudik
                                    WHERE is_deleted = 0 
                                    AND created_by IN (" . implode(',', $idArrUser) . ")
                                    ")->getRow();
    }

     // model count armada truck by eo
    public function getCountArmadaTruckByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        return $this->db->query("SELECT count(id) AS count_armada_truck
                                    FROM m_armada_motis_mudik
                                    WHERE is_deleted = 0
                                    AND created_by IN (" . implode(',', $idArrUser) . ")
                                    ")->getRow();
    }

    // model count jadwal motis bis by eo
    public function getCountJadwalMotisByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        return $this->db->query("SELECT count(id) as count_jadwal_motis,
                                    SUM(CASE WHEN open = '1' THEN 1 ELSE 0 END) as open, 
                                    SUM(CASE WHEN open = '0' THEN 1 ELSE 0 END) as close
                                    FROM t_jadwal_motis_mudik
                                    WHERE is_deleted = 0 
                                    AND created_by IN (" . implode(',', $idArrUser) . ")
                                    ")->getRow();
    }

     // model count percentage armada bis by eo
    public function getCountPercentageArmadaBisByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        // return $this->db->query("SELECT cast((sum(case when d.billing_is_paguyuban = '0' && d.billing_cancel = '0' then 1 else 0 end) + sum(case when a.open = '0' then 1 else 0 end)) / count(a.id) * 100 as decimal(10,2)) as percentage_armada_bis
        //                             FROM t_jadwal_mudik a
        //                             JOIN t_jadwal_seat_mudik b
        //                                 ON a.id = b.jadwal_id
        //                             left join t_transaction_mudik c
        //                                 on b.id = c.transaction_seat_id
        //                             left join t_billing_mudik d
        //                                 on c.billing_id = d.id
        //                             WHERE a.is_deleted = 0
        //                             AND a.created_by IN (" . implode(',', $idArrUser) . ")
        //                             ")->getRow();
        return $this->db->query("SELECT sum(c.seat_map_capacity) AS count_all_kuota, sum(seat_filled) + sum(h.seat_map_capacity) AS count_all_mudik, sum(seat_filled) AS count_all_umum, sum(h.seat_map_capacity) AS count_all_paguyuban,
        sum(c.seat_map_capacity) - (sum(seat_filled) + sum(h.seat_map_capacity)) AS count_all_remainder_kuota, cast((sum(seat_filled) + sum(h.seat_map_capacity)) / sum(c.seat_map_capacity) * 100  as decimal(10,2)) as percentage_armada_bis
        FROM m_armada_mudik a 
        INNER JOIN m_po b ON b.id = a.po_id
        INNER JOIN m_seat_map c ON c.id = a.armada_sheet_id
        INNER JOIN t_jadwal_mudik d ON d.jadwal_armada_id = a.id
        LEFT JOIN (
            SELECT a.id,c.armada_name,c.armada_code,d.route_name,a.jadwal_date_depart,a.jadwal_time_depart,a.jadwal_date_arrived,a.jadwal_time_arrived,a.jadwal_type,a.open, count(b.id) AS 'seat_total', count(b.transaction_id) AS 'seat_filled'
        FROM t_jadwal_mudik a
        JOIN t_jadwal_seat_mudik b ON a.id = b.jadwal_id
        JOIN m_armada_mudik c ON a.jadwal_armada_id = c.id
        JOIN m_route d ON a.jadwal_route_id = d.id
        WHERE a.is_deleted = 0
        GROUP BY a.id 
        ) g ON g.id = d.id
        LEFT JOIN (
            SELECT a.jadwal_armada_id, c.seat_map_capacity FROM t_jadwal_mudik a
             LEFT JOIN m_armada_mudik b ON b.id = a.jadwal_armada_id
             LEFT JOIN m_seat_map c ON c.id = b.armada_sheet_id
             WHERE a.open = '0' AND a.is_deleted = '0' AND c.is_deleted = '0' AND b.is_deleted = '0'
        ) h ON h.jadwal_armada_id = a.id
        WHERE a.is_deleted = '0' AND b.is_deleted = '0' AND c.is_deleted = '0' AND d.is_deleted = '0';
                                    ")->getRow();
    }

    // model count percentage armada truck by eo
    public function getCountPercentageArmadaTruckByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        return $this->db->query("SELECT cast(c.count_motis / COALESCE(sum(a.quota_max), 0) * 100 as decimal(10,2)) as percentage_armada_truck
                                    FROM t_jadwal_motis_mudik a
                                    JOIN (
                                        SELECT count(c.id) as count_motis
                                        FROM t_jadwal_motis_mudik a
                                        JOIN t_billing_motis_mudik b
                                        ON a.id = b.motis_jadwal_id
                                        JOIN t_motis_manifest_mudik c
                                        ON b.id = c.motis_billing_id
                                        WHERE a.created_by IN (" . implode(',', $idArrUser) . ")
                                        AND a.is_deleted = 0
                                        AND NOT b.motis_status_verif = 2
                                        AND NOT b.motis_cancel = 1
                                    ) c
                                    WHERE a.created_by IN (" . implode(',', $idArrUser) . ")
                                    AND a.is_deleted = 0
                                    ")->getRow();
    }

    // model count all pemudik by eo
    public function getCountAllPemudikByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        //  return $this->db->query("SELECT count(a.id) as count_all_kuota,
        //                                     sum(case when b.transaction_id && d.billing_cancel = '0' then 1 else 0 end) AS count_all_mudik,
        //                                     sum(case when d.billing_is_paguyuban = '0' && d.billing_cancel = '0' then 1 else 0 end) as count_all_umum,
        //                                     sum(case when a.open = '0' then 1 else 0 end) as count_all_paguyuban,
        //                                     sum(case when b.transaction_id is null then 1 else 0 end) as count_all_remainder_kuota
        //                             FROM t_jadwal_mudik a
        //                             JOIN t_jadwal_seat_mudik b ON a.id = b.jadwal_id
        //                             left join t_transaction_mudik c on b.id = c.transaction_seat_id
        //                             left join t_billing_mudik d on c.billing_id = d.id
        //                             WHERE a.is_deleted = 0 AND a.created_by IN (" . implode(',', $idArrUser) . ")")->getRow();

        // return $this->db->query("SELECT sum(c.seat_map_capacity) AS count_all_kuota, sum(ttl_terisi) + sum(h.seat_map_capacity) AS count_all_mudik, sum(ttl_umum) AS count_all_umum, sum(h.seat_map_capacity) AS count_all_paguyuban,
        //                             sum(c.seat_map_capacity) - (sum(ttl_terisi) + sum(h.seat_map_capacity)) AS count_all_remainder_kuota
        //                             FROM m_armada_mudik a 
        //                             INNER JOIN m_po b ON b.id = a.po_id
        //                             INNER JOIN m_seat_map c ON c.id = a.armada_sheet_id
        //                             INNER JOIN t_jadwal_mudik d ON d.jadwal_armada_id = a.id
        //                             LEFT JOIN (
        //                                 SELECT DISTINCT billing_jadwal_id, sum(billing_qty) AS ttl_umum FROM t_billing_mudik WHERE billing_cancel = 0 AND billing_is_paguyuban = 0
        //                                 GROUP BY billing_jadwal_id
        //                             ) e ON e.billing_jadwal_id = d.id
        //                             LEFT JOIN (
        //                                 SELECT DISTINCT billing_jadwal_id, sum(billing_qty) AS ttl_terisi FROM t_billing_mudik WHERE billing_cancel = 0
        //                                 GROUP BY billing_jadwal_id
        //                             ) g ON g.billing_jadwal_id = d.id
        //                             LEFT JOIN (
        //                                 SELECT a.jadwal_armada_id, c.seat_map_capacity FROM t_jadwal_mudik a
        //                                 LEFT JOIN m_armada_mudik b ON b.id = a.jadwal_armada_id
        //                                 LEFT JOIN m_seat_map c ON c.id = b.armada_sheet_id
        //                                 WHERE a.open = '0' AND a.is_deleted = '0' AND c.is_deleted = '0' AND b.is_deleted = '0'
        //                             ) h ON h.jadwal_armada_id = a.id
        //                             WHERE a.is_deleted = '0' AND b.is_deleted = '0' AND c.is_deleted = '0' AND d.is_deleted = '0'")->getRow();

        // return $this->db->query("SELECT sum(c.seat_map_capacity) AS count_all_kuota, sum(seat_filled) + sum(h.seat_map_capacity) AS count_all_mudik, sum(seat_filled) AS count_all_umum, sum(h.seat_map_capacity) AS count_all_paguyuban,
        // sum(c.seat_map_capacity) - (sum(seat_filled) + sum(h.seat_map_capacity)) AS count_all_remainder_kuota
        // FROM m_armada_mudik a 
        // INNER JOIN m_po b ON b.id = a.po_id
        // INNER JOIN m_seat_map c ON c.id = a.armada_sheet_id
        // INNER JOIN t_jadwal_mudik d ON d.jadwal_armada_id = a.id
        // LEFT JOIN (
        //     SELECT a.id,c.armada_name,c.armada_code,d.route_name,a.jadwal_date_depart,a.jadwal_time_depart,a.jadwal_date_arrived,a.jadwal_time_arrived,a.jadwal_type,a.open, count(b.id) AS 'seat_total', count(b.transaction_id) AS 'seat_filled'
        // FROM t_jadwal_mudik a
        // JOIN t_jadwal_seat_mudik b ON a.id = b.jadwal_id
        // JOIN m_armada_mudik c ON a.jadwal_armada_id = c.id
        // JOIN m_route d ON a.jadwal_route_id = d.id
        // WHERE a.is_deleted = 0
        // GROUP BY a.id 
        // ) g ON g.id = d.id
        // LEFT JOIN (
        //     SELECT a.jadwal_armada_id, c.seat_map_capacity FROM t_jadwal_mudik a
        //      LEFT JOIN m_armada_mudik b ON b.id = a.jadwal_armada_id
        //      LEFT JOIN m_seat_map c ON c.id = b.armada_sheet_id
        //      WHERE a.open = '0' AND a.is_deleted = '0' AND c.is_deleted = '0' AND b.is_deleted = '0'
        // ) h ON h.jadwal_armada_id = a.id
        // WHERE a.is_deleted = '0' AND b.is_deleted = '0' AND c.is_deleted = '0' AND d.is_deleted = '0';
        // ")->getRow();

        // return $this->db->query("SELECT sum(a.seat_map_capacity) as kuota_all,
        //                                 sum(case when a.open = 1 THEN a.seat_map_capacity END) as kuota_umum,
        //                                 sum(case when a.open = 0 THEN a.seat_map_capacity END) as kuota_paguyuban,
        //                                 sum(a.count_filled) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban) as count_filled, 
        //                                 sum(a.count_filled_umum) as count_filled_umum,
        //                                 sum(a.count_filled_paguyuban) as count_filled_paguyuban,
        //                                 sum(a.count_pending_verif) as count_pending_verif,
        //                                 sum(a.count_success_verif) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban) as count_success_verif,
        //                                 sum(a.count_fail_cerif) as count_fail_verif,
        //                                 sum(a.count_expired) as count_expired,
        //                                 sum(a.seat_map_capacity) - (sum(a.count_filled) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban)) as count_all_remainder_kuota,
        //                                 cast(((sum(a.count_filled) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban)) / sum(a.seat_map_capacity)) * 100 as decimal(10,2)) as bis_fully_percentage
        //                         from (
        //                             select d.open,
        //                                 d.seat_map_capacity,
        //                                 count(c.id) as count_filled,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' THEN 1 END) as count_filled_umum,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' THEN 1 END) as count_filled_paguyuban,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL THEN 1 END) as count_pending_verif,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL THEN 1 END) as count_success_verif,
        //                                 count(case when b.is_verified = '2' THEN 1 END) as count_fail_cerif,
        //                                 count(case when a.billing_cancel = '1' THEN 1 END) as count_expired
        //                             from t_billing_mudik a
        //                             join t_transaction_mudik b
        //                                 on a.id = b.billing_id
        //                             left join t_jadwal_seat_mudik c
        //                                 on b.id = c.transaction_id
        //                             right join (
        //                                 select a.id, c.seat_map_capacity, a.open
        //                                 from t_jadwal_mudik a
        //                                 left join m_armada_mudik b
        //                                     on a.jadwal_armada_id = b.id
        //                                 left join m_seat_map c
        //                                     on b.armada_sheet_id = c.id
        //                                 where a.is_deleted = 0
        //                             ) d
        //                             on a.billing_jadwal_id = d.id
        //                             group by d.id
        //                             ) a
        //                         ;
        //                         ")->getRow();

        // return $this->db->query("SELECT sum(a.seat_map_capacity) as kuota_all,
        //                                 sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_all_mudik,
        //                                 sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_all_balik,
        //                                 sum(case when a.open = 1 THEN a.seat_map_capacity END) as kuota_umum,
        //                                 sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_umum_mudik,
        //                                 sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_umum_balik,
        //                                 sum(case when a.open = 0 THEN a.seat_map_capacity END) as kuota_paguyuban,
        //                                 sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_paguyuban_mudik,
        //                                 sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_paguyuban_balik,
        //                                 sum(a.count_filled) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban) as count_filled,
        //                                 sum(a.count_filled_umum_mudik) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as count_filled_mudik,
        //                                 sum(a.count_filled_umum_balik) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as count_filled_balik,
        //                                 sum(a.count_filled_umum) as count_filled_umum,
        //                                 sum(a.count_filled_umum_mudik) as count_filled_umum_mudik,
        //                                 sum(a.count_filled_umum_balik) as count_filled_umum_balik,
        //                                 sum(a.count_filled_paguyuban) as count_filled_paguyuban,
        //                                 sum(a.count_filled_paguyuban_mudik) as count_filled_paguyuban_mudik,
        //                                 sum(a.count_filled_paguyuban_balik) as count_filled_paguyuban_balik,
        //                                 sum(a.count_pending_verif)as count_pending_verif,
        //                                 sum(a.count_pending_verif_mudik)as count_pending_verif_mudik,
        //                                 sum(a.count_pending_verif_balik)as count_pending_verif_balik,
        //                                 sum(a.count_success_verif) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban)  as count_success_verif,
        //                                 sum(a.count_success_verif_mudik) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban_mudik) as count_success_verif_mudik,
        //                                 sum(a.count_success_verif_balik) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban_balik) as count_success_verif_balik,
        //                                 sum(a.count_fail_cerif) as count_fail_verif,
        //                                 sum(a.count_fail_cerif_mudik) as count_fail_verif_mudik,
        //                                 sum(a.count_fail_cerif_balik) as count_fail_verif_balik,
        //                                 sum(a.seat_map_capacity) - (sum(a.count_filled) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban)) as count_all_remainder_kuota,
        //                                 sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) - sum(a.count_filled_umum_mudik) as count_all_remainder_kuota_mudik,
        //                                 sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) - sum(a.count_filled_umum_balik) as count_all_remainder_kuota_balik,
        //                                 cast(((sum(a.count_filled) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban)) / sum(a.seat_map_capacity)) * 100 as decimal(10,2)) as bis_fully_percentage
        //                         from (
        //                             select d.open,
        //                                 d.jadwal_type,
        //                                 d.seat_map_capacity,
        //                                 count(c.id) as count_filled,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' THEN 1 END) as count_filled_umum,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' AND d.jadwal_type = '1' THEN 1 END) as count_filled_umum_mudik,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' AND d.jadwal_type = '2' THEN 1 END) as count_filled_umum_balik,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' THEN 1 END) as count_filled_paguyuban,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' AND d.jadwal_type = '1' THEN 1 END) as count_filled_paguyuban_mudik,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' AND d.jadwal_type = '2' THEN 1 END) as count_filled_paguyuban_balik,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL THEN 1 END) as count_pending_verif,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '1' THEN 1 END) as count_pending_verif_mudik,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '2' THEN 1 END) as count_pending_verif_balik,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL THEN 1 END) as count_success_verif,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '1' THEN 1 END) as count_success_verif_mudik,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '2' THEN 1 END) as count_success_verif_balik,
        //                                 count(case when b.is_verified = '2' THEN 1 END) as count_fail_cerif,
        //                                 count(case when b.is_verified = '2' AND d.jadwal_type = '1' THEN 1 END) as count_fail_cerif_mudik,
        //                                 count(case when b.is_verified = '2' AND d.jadwal_type = '2' THEN 1 END) as count_fail_cerif_balik
        //                             from t_billing_mudik a
        //                             join t_transaction_mudik b
        //                                 on a.id = b.billing_id
        //                             left join t_jadwal_seat_mudik c
        //                                 on b.id = c.transaction_id
        //                             right join (
        //                                 select a.id, c.seat_map_capacity, a.open, a.jadwal_type
        //                                 from t_jadwal_mudik a
        //                                 left join m_armada_mudik b
        //                                     on a.jadwal_armada_id = b.id
        //                                 left join m_seat_map c
        //                                     on b.armada_sheet_id = c.id
        //                                 where a.is_deleted = 0
        //                             ) d
        //                             on a.billing_jadwal_id = d.id
        //                             group by d.id
        //                             ) a
        //                         ;")->getRow();

        // return $this->db->query("SELECT sum(a.seat_map_capacity) as kuota_all,
        //                             sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_all_mudik,
        //                             sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_all_balik,
        //                             sum(case when a.open = 1 THEN a.seat_map_capacity END) as kuota_umum,
        //                             sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_umum_mudik,
        //                             sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_umum_balik,
        //                             sum(case when a.open = 0 THEN a.seat_map_capacity END) as kuota_paguyuban,
        //                             sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_paguyuban_mudik,
        //                             sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_paguyuban_balik,
        //                             sum(case when a.open = 0 THEN a.seat_map_capacity END) + sum(a.count_filled_paguyuban) + sum(a.count_filled_umum)  as count_filled,
        //                             sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) + sum(a.count_filled_umum_mudik) + sum(a.count_filled_paguyuban_mudik) as count_filled_mudik,
        //                             sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) + sum(a.count_filled_umum_balik) + sum(a.count_filled_paguyuban_balik) as count_filled_balik,
        //                             sum(a.count_filled_umum) as count_filled_umum,
        //                             sum(a.count_filled_umum_mudik) as count_filled_umum_mudik,
        //                             sum(a.count_filled_umum_balik) as count_filled_umum_balik,
        //                             sum(a.count_filled_paguyuban) as count_filled_paguyuban,
        //                             sum(a.count_filled_paguyuban_mudik) as count_filled_paguyuban_mudik,
        //                             sum(a.count_filled_paguyuban_balik) as count_filled_paguyuban_balik,
        //                             sum(a.count_pending_verif) as count_pending_verif,
        //                             sum(a.count_pending_verif_mudik)as count_pending_verif_mudik,
        //                             sum(a.count_pending_verif_balik)as count_pending_verif_balik,
        //                             sum(a.count_success_verif) + sum(case when a.open = 0 THEN a.seat_map_capacity END) as count_success_verif,
        //                             sum(a.count_success_verif_mudik) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as count_success_verif_mudik,
        //                             sum(a.count_success_verif_balik) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as count_success_verif_balik,
        //                             sum(a.count_fail_cerif) as count_fail_verif,
        //                             sum(a.count_fail_cerif_mudik) as count_fail_verif_mudik,
        //                             sum(a.count_fail_cerif_balik) as count_fail_verif_balik,
        //                             sum(a.seat_map_capacity) - sum(a.count_filled_umum) - sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban) as count_all_remainder_kuota,
        //                             sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) - sum(a.count_filled_umum_mudik) - sum(a.count_filled_paguyuban_mudik) as count_all_remainder_kuota_mudik,
        //                             sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) - sum(a.count_filled_umum_balik) - sum(a.count_filled_paguyuban_balik) as count_all_remainder_kuota_balik,
        //                             cast(((sum(case when a.open = 0 THEN a.seat_map_capacity END) + sum(a.count_filled_paguyuban) + sum(a.count_filled_umum)) / sum(a.seat_map_capacity)) * 100 as decimal(10,2)) as bis_fully_percentage
        //                         from (
        //                             select d.open,
        //                                 d.jadwal_type,
        //                                 d.seat_map_capacity,
        //                                 count(c.id) as count_filled,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' THEN 1 END) as count_filled_umum,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' AND d.jadwal_type = '1' THEN 1 END) as count_filled_umum_mudik,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '0' AND d.jadwal_type = '2' THEN 1 END) as count_filled_umum_balik,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' THEN 1 END) as count_filled_paguyuban,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' AND d.jadwal_type = '1' THEN 1 END) as count_filled_paguyuban_mudik,
        //                                 count(case when c.id AND a.billing_is_paguyuban = '1' AND d.jadwal_type = '2' THEN 1 END) as count_filled_paguyuban_balik,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL THEN 1 END) as count_pending_verif,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '1' THEN 1 END) as count_pending_verif_mudik,
        //                                 count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '2' THEN 1 END) as count_pending_verif_balik,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL THEN 1 END) as count_success_verif,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '1' THEN 1 END) as count_success_verif_mudik,
        //                                 count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '2' THEN 1 END) as count_success_verif_balik,
        //                                 count(case when b.is_verified = '2' THEN 1 END) as count_fail_cerif,
        //                                 count(case when b.is_verified = '2' AND d.jadwal_type = '1' THEN 1 END) as count_fail_cerif_mudik,
        //                                 count(case when b.is_verified = '2' AND d.jadwal_type = '2' THEN 1 END) as count_fail_cerif_balik
        //                             from t_billing_mudik a
        //                             join t_transaction_mudik b
        //                                 on a.id = b.billing_id
        //                             left join t_jadwal_seat_mudik c
        //                                 on b.id = c.transaction_id
        //                             right join (
        //                                 select a.id, c.seat_map_capacity, a.open, a.jadwal_type
        //                                 from t_jadwal_mudik a
        //                                 left join m_armada_mudik b
        //                                     on a.jadwal_armada_id = b.id
        //                                 left join m_seat_map c
        //                                     on b.armada_sheet_id = c.id
        //                                 where a.is_deleted = 0
        //                             ) d
        //                             on a.billing_jadwal_id = d.id
        //                             group by d.id
        //                         ) a;")->getRow();

        return $this->db->query("SELECT sum(a.seat_map_capacity) as kuota_all,
                                    sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_all_mudik,
                                    sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_all_balik,
                                    sum(case when a.open = 1 THEN a.seat_map_capacity END) as kuota_umum,
                                    sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_umum_mudik,
                                    sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_umum_balik,
                                    sum(case when a.open = 0 THEN a.seat_map_capacity END) as kuota_paguyuban,
                                    sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) as kuota_paguyuban_mudik,
                                    sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) as kuota_paguyuban_balik,
                                    sum(case when a.open = 0 THEN a.seat_map_capacity END) + sum(a.count_filled_paguyuban_campuran) + sum(a.count_filled_umum)  as count_filled,
                                    sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) + sum(a.count_filled_umum_mudik) + sum(a.count_filled_paguyuban_campuran_mudik) as count_filled_mudik,
                                    sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) + sum(a.count_filled_umum_balik) + sum(a.count_filled_paguyuban_campuran_balik) as count_filled_balik,
                                    sum(a.count_filled_umum) as count_filled_umum,
                                    sum(a.count_filled_umum_mudik) as count_filled_umum_mudik,
                                    sum(a.count_filled_umum_balik) as count_filled_umum_balik,
                                    sum(a.count_filled_paguyuban) as count_filled_paguyuban,
                                    sum(a.count_filled_paguyuban_mudik) as count_filled_paguyuban_mudik,
                                    sum(a.count_filled_paguyuban_balik) as count_filled_paguyuban_balik,
                                    sum(a.count_filled_paguyuban_campuran) as count_filled_paguyuban_campuran,
                                    sum(a.count_filled_paguyuban_campuran_mudik) as count_filled_paguyuban_campuran_mudik,
                                    sum(a.count_filled_paguyuban_campuran_balik) as count_filled_paguyuban_campuran_balik,
                                    sum(a.count_pending_verif) as count_pending_verif,
                                    sum(a.count_pending_verif_mudik) as count_pending_verif_mudik,
                                    sum(a.count_pending_verif_balik) as count_pending_verif_balik,
                                    sum(a.count_success_verif) + sum(case when a.open = 0 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban) as count_success_verif,
                                    sum(a.count_success_verif_mudik) + sum(case when a.open = 0 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban_mudik) as count_success_verif_mudik,
                                    sum(a.count_success_verif_balik) + sum(case when a.open = 0 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) - sum(a.count_filled_paguyuban_balik) as count_success_verif_balik,
                                    sum(a.count_fail_cerif) as count_fail_verif,
                                    sum(a.count_fail_cerif_mudik) as count_fail_verif_mudik,
                                    sum(a.count_fail_cerif_balik) as count_fail_verif_balik,
                                    sum(a.seat_map_capacity) - sum(a.count_filled_umum) - sum(count_filled_paguyuban_campuran) - sum(case when a.open = 0 THEN a.seat_map_capacity END) as count_all_remainder_kuota,
                                    sum(case when a.open = 1 AND a.jadwal_type = 1 THEN a.seat_map_capacity END) - sum(a.count_filled_umum_mudik) - sum(a.count_filled_paguyuban_campuran_mudik) as count_all_remainder_kuota_mudik,
                                    sum(case when a.open = 1 AND a.jadwal_type = 2 THEN a.seat_map_capacity END) - sum(a.count_filled_umum_balik) - sum(a.count_filled_paguyuban_campuran_balik) as count_all_remainder_kuota_balik,
                                    cast(((sum(case when a.open = 0 THEN a.seat_map_capacity END) + sum(a.count_filled_paguyuban_campuran) + sum(a.count_filled_umum)) / sum(a.seat_map_capacity)) * 100 as decimal(10,2)) as bis_fully_percentage
                                from (
                                    select d.open,
                                        d.jadwal_type,
                                        d.seat_map_capacity,
                                        count(c.id) as count_filled,
                                        count(case when c.id AND a.billing_is_paguyuban = '0' THEN 1 END) as count_filled_umum,
                                        count(case when c.id AND a.billing_is_paguyuban = '0' AND d.jadwal_type = '1' THEN 1 END) as count_filled_umum_mudik,
                                        count(case when c.id AND a.billing_is_paguyuban = '0' AND d.jadwal_type = '2' THEN 1 END) as count_filled_umum_balik,
                                        count(case when c.id AND a.billing_is_paguyuban = '1' AND d.open = '0' THEN 1 END) as count_filled_paguyuban,
                                        count(case when c.id AND a.billing_is_paguyuban = '1' AND d.open = '0' AND d.jadwal_type = '1' THEN 1 END) as count_filled_paguyuban_mudik,
                                        count(case when c.id AND a.billing_is_paguyuban = '1' AND d.open = '0' AND d.jadwal_type = '2' THEN 1 END) as count_filled_paguyuban_balik,
                                        count(case when c.id AND a.billing_is_paguyuban = '1' AND d.open = '1' THEN 1 END) as count_filled_paguyuban_campuran,
                                        count(case when c.id AND a.billing_is_paguyuban = '1' AND d.open = '1' AND d.jadwal_type = '1' THEN 1 END) as count_filled_paguyuban_campuran_mudik,
                                        count(case when c.id AND a.billing_is_paguyuban = '1' AND d.open = '1' AND d.jadwal_type = '2' THEN 1 END) as count_filled_paguyuban_campuran_balik,
                                        count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL THEN 1 END) as count_pending_verif,
                                        count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '1' THEN 1 END) as count_pending_verif_mudik,
                                        count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '2' THEN 1 END) as count_pending_verif_balik,
                                        count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL THEN 1 END) as count_success_verif,
                                        count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '1' THEN 1 END) as count_success_verif_mudik,
                                        count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL AND d.jadwal_type = '2' THEN 1 END) as count_success_verif_balik,
                                        count(case when b.is_verified = '2' THEN 1 END) as count_fail_cerif,
                                        count(case when b.is_verified = '2' AND d.jadwal_type = '1' THEN 1 END) as count_fail_cerif_mudik,
                                        count(case when b.is_verified = '2' AND d.jadwal_type = '2' THEN 1 END) as count_fail_cerif_balik
                                    from t_billing_mudik a
                                    join t_transaction_mudik b
                                        on a.id = b.billing_id
                                    left join t_jadwal_seat_mudik c
                                        on b.id = c.transaction_id
                                    right join (
                                        select a.id, c.seat_map_capacity, a.open, a.jadwal_type
                                        from t_jadwal_mudik a
                                        left join m_armada_mudik b
                                            on a.jadwal_armada_id = b.id
                                        left join m_seat_map c
                                            on b.armada_sheet_id = c.id
                                        where a.is_deleted = 0
                                    ) d
                                    on a.billing_jadwal_id = d.id
                                    group by d.id
                                ) a;")->getRow();
    }

    // model count all motis by eo
    public function getCountAllMotisByEO()
    {
        $iduser = $this->session->get('id');

        $idArrUser = [$iduser];

        // temporary
        if($this->session->get('role') == 18) {
            array_push($idArrUser, 230);
        }

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

        // return $this->db->query("SELECT count(c.id) as count_all_motis,
        //                                     sum(case when a.jadwal_type = '1' THEN 1 ELSE 0 END) as count_all_motis_mudik,
        //                                     sum(case when a.jadwal_type = '2' THEN 1 ELSE 0 END) as count_all_motis_balik
        //                             FROM t_jadwal_motis_mudik a
        //                             JOIN t_billing_motis_mudik b
        //                             ON a.id = b.motis_jadwal_id
        //                             JOIN t_motis_manifest_mudik c
        //                             ON b.id = c.motis_billing_id
        //                             WHERE a.created_by IN (" . implode(',', $idArrUser) . ")
        //                             AND a.is_deleted = 0
        //                             ")->getRow();

        return $this->db->query("SELECT sum(a.kuota_motis) kuota_motis,
                                        sum(case when a.jadwal_type = '1' THEN a.kuota_motis ELSE 0 END) as kuota_motis_mudik,
                                        sum(case when a.jadwal_type = '2' THEN a.kuota_motis ELSE 0 END) as kuota_motis_balik,
                                        sum(count_all_motis) as motis_filled,
                                        sum(count_all_motis_mudik) as motis_mudik_filled,
                                        sum(count_all_motis_balik) as motis_balik_filled,
                                        sum(a.kuota_motis) - sum(count_all_motis) as motis_avail,
                                        sum(case when a.jadwal_type = '1' THEN a.kuota_motis ELSE 0 END) - sum(count_all_motis_mudik) as motis_mudik_avail,
                                        sum(case when a.jadwal_type = '2' THEN a.kuota_motis ELSE 0 END) - sum(count_all_motis_balik) as motis_balik_avail
                                FROM (
                                    SELECT a.id, 
                                            a.quota_max as kuota_motis,
                                        a.jadwal_type,
                                        count(c.id) as count_all_motis,
                                        sum(case when a.jadwal_type = '1' THEN 1 ELSE 0 END) as count_all_motis_mudik,
                                        sum(case when a.jadwal_type = '2' THEN 1 ELSE 0 END) as count_all_motis_balik
                                    FROM t_jadwal_motis_mudik a
                                    JOIN t_billing_motis_mudik b
                                        ON a.id = b.motis_jadwal_id
                                    JOIN t_motis_manifest_mudik c
                                        ON b.id = c.motis_billing_id
                                    WHERE a.created_by IN (" . implode(',', $idArrUser) . ")
                                    AND a.is_deleted = 0
                                    GROUP BY a.id
                                ) a")->getRow();
    }

    // model count all verif by eo
    public function getCountAllVerifByEO() {
        return $this->db->query("SELECT 
                                        count(c.id),
                                        count(case when b.is_verified = '0' AND c.transaction_id IS NOT NULL THEN 1 END) as count_not_yet_verif,
                                        count(case when b.is_verified = '1' AND c.transaction_id IS NOT NULL THEN 1 END) as count_verif,
                                        count(case when b.is_verified = '2' THEN 1 END) as count_fail,
                                        count(case when a.billing_cancel = '1' THEN 1 END) as count_expired
                                from t_billing_mudik a
                                join t_transaction_mudik b
                                    on a.id = b.billing_id
                                left join t_jadwal_seat_mudik c
                                    on b.id = c.transaction_id;")->getRow();
    }

    public function getCountRampcheckPerBptd()
    {
        // $response = $this->db->query("SELECT
        //                                 a.instansi_detail_name,
        //                                 IF(b.user IS NULL, 0, b.user) AS user_admin,
        //                                 IF(c.user IS NULL, 0, c.user) AS user_petugas,
        //                                 IF(d.rampcheck IS NULL, 0, d.rampcheck) AS rampcheck
        //                             FROM m_instansi_detail a
        //                             LEFT JOIN (
        //                                 SELECT 
        //                                     a.instansi_detail_id,
        //                                     count(*) AS USER,
        //                                     kode
        //                                 FROM m_user_web a 
        //                                 INNER JOIN m_instansi_detail b
        //                                     ON b.id=a.instansi_detail_id
        //                                 WHERE a.instansi_detail_id IS NOT NULL 
        //                                     AND a.is_deleted=0
        //                                     AND b.is_deleted=0
        //                                 GROUP BY a.instansi_detail_id ORDER BY a.instansi_detail_id) b
        //                             ON a.id = b.instansi_detail_id
        //                             LEFT JOIN (
        //                                 SELECT 
        //                                     a.instansi_detail_id,
        //                                     count(*) AS USER,
        //                                     kode
        //                                 FROM m_user_web a 
        //                                 INNER JOIN m_instansi_detail b
        //                                     ON b.id=a.instansi_detail_id
        //                                 WHERE a.instansi_detail_id IS NOT NULL 
        //                                     AND a.is_deleted=0
        //                                     AND b.is_deleted=0
        //                                 GROUP BY a.instansi_detail_id ORDER BY a.instansi_detail_id
        //                             ) c
        //                             ON c.kode LIKE concat(b.kode,'.%')
        //                             LEFT JOIN (
        //                                 SELECT 
        //                                     a.id, 
        //                                     b.created_by, 
        //                                     sum(b.rampcheck) AS rampcheck,
        //                                     IF(ROUND((LENGTH(c.kode)-LENGTH( REPLACE (c.kode, '.', ''))) / LENGTH('.')) = 2,SUBSTRING_INDEX(c.kode, '.', LENGTH(c.kode) - LENGTH(REPLACE(c.kode, '.', ''))),c.kode) AS kode_p 
        //                                 FROM m_user_web a
        //                                 LEFT JOIN (
        //                                     SELECT k.created_by, count(*) AS rampcheck FROM t_rampcheck k
        //                                     WHERE k.is_deleted = 0
        //                                     GROUP BY k.created_by) b
        //                             ON a.id = b.created_by
        //                             LEFT JOIN m_instansi_detail c
        //                                     ON c.id=a.instansi_detail_id
        //                             WHERE a.is_deleted = 0
        //                                 AND c.is_deleted = 0 
        //                             GROUP BY kode_p
        //                             ) d
        //                             ON d.kode_p = a.kode
        //                             WHERE rampcheck > 0
        //                                 ORDER BY rampcheck DESC
        //                                 ")->getResultArray();
        
		$response = $this->db->query("select a.id,a.instansi_detail_name,ifnull(sum(b.j),0) as rampcheck from m_instansi_detail a 
		left join(
		select year(a.rampcheck_date) as tahun,a.created_by,b.instansi_detail_id,count(*) as j from t_rampcheck a
		left join m_user_web b on a.created_by=b.id
		where a.is_deleted=0 and year(a.rampcheck_date)=year(current_date()) and b.instansi_detail_id is not null
		group by b.instansi_detail_id
		) b on a.id=b.instansi_detail_id
		where (a.instansi_detail_id=334 or a.id=b.instansi_detail_id) and a.is_deleted=0
		group by left(a.kode,11)
		order by rampcheck desc")->getResultArray();
                                        return $response;
    }

    public function getLastFiveRampcheck()
    {
      $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');
        if($this->session->get('instansi_detail_id') != null){

          $response = $this->db->query("SELECT date_format(a.created_at, '%d-%m-%Y %H:%i:%s') as created_at, a.rampcheck_no, date_format(a.rampcheck_date, '%d-%m-%Y') as rampcheck_date,a1.user_web_name as user_web_name, a.rampcheck_nama_lokasi, a.rampcheck_noken, c.jenis_angkutan_name, a.rampcheck_trayek, 
          CASE WHEN b.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
          WHEN b.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
          when b.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
          ELSE 'Dilarang Operasional' END AS rampcheck_status
          FROM t_rampcheck a
          INNER JOIN m_user_web a1 on a.created_by=a1.id
          LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
          INNER JOIN m_jenis_angkutan c ON c.id = a.rampcheck_jenis_angkutan_id
          INNER JOIN m_instansi_detail d ON d.id=a1.instansi_detail_id
          WHERE a.is_deleted = 0 AND (a.created_by=? OR 
                IF( POSITION(? IN d.kode)>0
                    , d.kode LIKE CONCAT_WS( 
                        '', 
                        LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1)
                        ,'%'
                        ) 
                    ,d.kode LIKE '000%'
                ) 
        )
          ORDER BY a.rampcheck_date DESC,a.id DESC
          LIMIT 5", array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();

        } else{ 
          $response = $this->db->query("SELECT date_format(a.created_at, '%d-%m-%Y %H:%i:%s') as created_at, a.rampcheck_no, date_format(a.rampcheck_date, '%d-%m-%Y') as rampcheck_date,a1.user_web_name as user_web_name, a.rampcheck_nama_lokasi, a.rampcheck_noken, c.jenis_angkutan_name, a.rampcheck_trayek, 
                      CASE WHEN b.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
                      WHEN b.rampcheck_kesimpulan_status = 1 THEN 'Peringatan / Perbaiki'
                      when b.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
                      ELSE 'Dilarang Operasional' END AS rampcheck_status
                      FROM t_rampcheck a
                      INNER JOIN m_user_web a1 on a.created_by=a1.id
                      LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
                      INNER JOIN m_jenis_angkutan c ON c.id = a.rampcheck_jenis_angkutan_id
                      WHERE a.is_deleted = 0
                      ORDER BY a.rampcheck_date DESC,a.id DESC
                      LIMIT 5")->getResultArray();
        }
        return $response;
    }

    public function getListJadwalMudikPercentage() {
        if ($this->session->get('id') == 229) {
            return $this->db->query("SELECT a.id,
                                            c.armada_name,
                                            c.armada_code,
                                            d.route_name,
                                            a.jadwal_date_depart,
                                            a.jadwal_time_depart,
                                            a.jadwal_date_arrived,
                                            a.jadwal_time_arrived,
                                            a.jadwal_type,
                                            a.open, 
                                            count(b.id) as 'seat_total', 
                                            count(b.transaction_id) as 'seat_filled',
                                            (count(b.id) - count(b.transaction_id)) AS 'seat_avail',
                                            FLOOR(count(b.transaction_id) / count(b.id) * 100) as percentage_fully
                                    FROM t_jadwal_mudik a
                                    JOIN t_jadwal_seat_mudik b
                                        ON a.id = b.jadwal_id
                                    JOIN m_armada_mudik c
                                        ON a.jadwal_armada_id = c.id
                                    JOIN m_route d
                                        ON a.jadwal_route_id = d.id
                                    WHERE a.is_deleted = 0
                                        AND c.is_deleted = 0
                                        AND d.is_deleted = 0
                                    GROUP BY a.id
                                    ORDER BY a.jadwal_date_depart ASC, a.jadwal_time_depart ASC
                                    ")->getResultArray();
        } else {
            return $this->db->query("SELECT * 
                                        FROM (SELECT a.id,
                                                c.armada_name,
                                                c.armada_code,
                                                d.route_name,
                                                a.jadwal_date_depart,
                                                a.jadwal_time_depart,
                                                a.jadwal_date_arrived,
                                                a.jadwal_time_arrived,
                                                a.jadwal_type,
                                                a.open, 
                                                count(b.id) AS 'seat_total', 
                                                count(b.transaction_id) AS 'seat_filled',
                                                (count(b.id) - count(b.transaction_id)) AS 'seat_avail',
                                                FLOOR(count(b.transaction_id) / count(b.id) * 100) AS percentage_fully
                                        FROM t_jadwal_mudik a
                                        JOIN t_jadwal_seat_mudik b
                                            ON a.id = b.jadwal_id
                                        JOIN m_armada_mudik c
                                            ON a.jadwal_armada_id = c.id
                                        JOIN m_route d
                                            ON a.jadwal_route_id = d.id
                                        WHERE a.is_deleted = 0 AND a.open = 1
                                        GROUP BY a.id ) a WHERE a.percentage_fully < '100'
                                    ")->getResult();
        }
    }

    public function getListJadwalMudikPercentageAvail() {
        if ($this->session->get('id') == 230) {
            return $this->db->query("SELECT a.id,
                                            c.armada_name,
                                            c.armada_code,
                                            d.route_name,
                                            a.jadwal_date_depart,
                                            a.jadwal_time_depart,
                                            a.jadwal_date_arrived,
                                            a.jadwal_time_arrived,
                                            a.jadwal_type,
                                            a.open, 
                                            count(b.id) as 'seat_total', 
                                            count(b.transaction_id) as 'seat_filled',
                                            (count(b.id) - count(b.transaction_id)) AS 'seat_avail',
                                            FLOOR(count(b.transaction_id) / count(b.id) * 100) as percentage_fully
                                    FROM t_jadwal_mudik a
                                    JOIN t_jadwal_seat_mudik b
                                        ON a.id = b.jadwal_id
                                    JOIN m_armada_mudik c
                                        ON a.jadwal_armada_id = c.id
                                    JOIN m_route d
                                        ON a.jadwal_route_id = d.id
                                    WHERE a.is_deleted = 0
                                        AND c.is_deleted = 0
                                        AND d.is_deleted = 0
                                    GROUP BY a.id
                                    ORDER BY a.jadwal_date_depart ASC, a.jadwal_time_depart ASC
                                    ")->getResultArray();
        } else {
            return $this->db->query("SELECT * 
                                        FROM (SELECT a.id,
                                                c.armada_name,
                                                c.armada_code,
                                                d.route_name,
                                                a.jadwal_date_depart,
                                                a.jadwal_time_depart,
                                                a.jadwal_date_arrived,
                                                a.jadwal_time_arrived,
                                                a.jadwal_type,
                                                a.open, 
                                                count(b.id) AS 'seat_total', 
                                                count(b.transaction_id) AS 'seat_filled',
                                                (count(b.id) - count(b.transaction_id)) AS 'seat_avail',
                                                FLOOR(count(b.transaction_id) / count(b.id) * 100) AS percentage_fully
                                        FROM t_jadwal_mudik a
                                        JOIN t_jadwal_seat_mudik b
                                            ON a.id = b.jadwal_id
                                        JOIN m_armada_mudik c
                                            ON a.jadwal_armada_id = c.id
                                        JOIN m_route d
                                            ON a.jadwal_route_id = d.id
                                        WHERE a.is_deleted = 0 AND a.open = 1
                                        GROUP BY a.id ) a WHERE a.percentage_fully < '100'
                                    ")->getResult();
        }
    }

     public function getListJadwalMotisPercentage() {
        return $this->db->query("SELECT b.*,
                                        JSON_ARRAYAGG(
                                            JSON_OBJECT (
                                                'id', a.id,
                                                'armada_name', a.armada_name
                                                )
                                            ) AS 'armada'
                                    FROM m_armada_motis_mudik a
                                    JOIN (
                                    SELECT a.id, d.route_name,
                                            a.jadwal_date_depart,
                                            a.jadwal_time_depart,
                                            a.jadwal_date_arrived,
                                            a.jadwal_time_arrived,
                                            a.jadwal_type,
                                            a.quota_public,
                                            a.quota_paguyuban,
                                            a.quota_max,
                                            FLOOR(count(b.motis_jadwal_id) / a.quota_max * 100) as percentage_fully
                                    FROM t_jadwal_motis_mudik a
                                    LEFT JOIN t_billing_motis_mudik b
                                        ON a.id = b.motis_jadwal_id
                                    LEFT JOIN t_motis_manifest_mudik c
                                        ON b.id = c.motis_billing_id
                                    JOIN m_route d
                                        ON a.jadwal_route_id = d.id                      
                                    WHERE a.is_deleted = 0
                                    AND NOT b.motis_status_verif = 2
                                    AND NOT b.motis_cancel = 1
                                    GROUP BY a.id
                                    ) b
                                    ON b.id = a.jadwal_motis_mudik_id    
                                    WHERE a.is_deleted = 0 
                                    GROUP BY b.id")->getResult();
    }

    public function getMudikInfo()
    {
        $response = $this->db->query("SELECT concat(date_format(a.jadwal_date_depart, '%d %M %Y'), ' ', a.jadwal_time_depart) AS jadwal_depart, concat(date_format(a.jadwal_date_arrived, '%d %M %Y'), ' ', a.jadwal_time_arrived) AS jadwal_arrived,
                                    d.route_name, d.route_from, d.route_to, d.route_from_latlng, d.route_to_latlng, d.route_time, d.route_distance, d.route_polyline, 
                                    json_object('po_name', c.po_name, 'po_logo', c.po_logo, 'po_description', c.po_description, 'armada_name', b.armada_name, 'seat_map_capacity', g.seat_map_capacity, b.armada_image, b.armada_code) AS armada_info,
                                    json_object( 'terminal_from_name' , e.terminal_name, 'terminal_from_code', e.terminal_code, 'terminal_from_type', e.terminal_type, 'terminal_from_address', e.terminal_address) AS terminal_from,
                                    json_object( 'terminal_to_name' , f.terminal_name, 'terminal_to_code', f.terminal_code, 'terminal_to_type', f.terminal_type, 'terminal_to_address', f.terminal_address) AS terminal_to
                                    FROM t_jadwal_mudik a
                                    INNER JOIN m_armada_mudik b ON b.id = a.jadwal_armada_id
                                    INNER JOIN m_po c ON c.id = b.po_id
                                    INNER JOIN m_route d ON d.id = a.jadwal_route_id
                                    INNER JOIN m_terminal e ON e.id = d.terminal_from_id
                                    INNER JOIN m_terminal f ON f.id = d.terminal_to_id
                                    INNER JOIN m_seat_map g ON g.id = b.armada_sheet_id
                                    WHERE a.is_deleted = '0' AND a.jadwal_type = 1")->getResultArray();
        return $response;
    }

    public function getCountArmadaRampcheck()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');  
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT DISTINCT date_format(b.rampcheck_date, '%Y') AS year_rampcheck, count(b.id) AS ttl_rampcheck, 
            (SELECT count(a.id) FROM t_rampcheck a 
                        INNER JOIN m_user_web b ON a.created_by=b.id
                        INNER JOIN m_instansi_detail c ON c.id=b.instansi_detail_id
            WHERE date_format(a.rampcheck_date, '%m-%Y') = date_format(CURRENT_DATE(), '%m-%Y') AND a.is_deleted = 0 
              AND (a.created_by=? OR 
                                IF( POSITION(? IN c.kode)>0
                                    , c.kode LIKE CONCAT_WS( 
                                        '', 
                                        LEFT(c.kode,POSITION(? IN c.kode)+LENGTH(?)-1)
                                        ,'%'
                                        ) 
                                    ,c.kode LIKE '000%'
                                ) 
                                )
            ) AS this_month,
                        SUM(
                        CASE WHEN a.rampcheck_kesimpulan_status = '0' OR a.rampcheck_kesimpulan_status = '1' THEN 1
                        ELSE 0
                        END
                        ) AS laik,
                        SUM(
                        CASE WHEN a.rampcheck_kesimpulan_status = '2' OR a.rampcheck_kesimpulan_status = '3' THEN 1
                        ELSE 0
                        END
                        ) AS tidak_laik
                        FROM t_rampcheck_kesimpulan a
                        JOIN t_rampcheck b ON b.id = a.rampcheck_id
                        INNER JOIN m_user_web c on b.created_by=c.id
                        INNER JOIN m_instansi_detail d ON d.id=c.instansi_detail_id
                        WHERE b.is_deleted = '0' AND date_format(b.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')
                        AND (b.created_by=? OR 
                                IF( POSITION(? IN d.kode)>0
                                    , d.kode LIKE CONCAT_WS( 
                                        '', 
                                        LEFT(d.kode,POSITION(? IN d.kode)+LENGTH(?)-1)
                                        ,'%'
                                        ) 
                                    ,d.kode LIKE '000%'
                                ) 
                                )",array($iduser,$instansiId,$instansiId,$instansiId, $iduser,$instansiId,$instansiId,$instansiId))->getResultArray();
        } else {
            $response = $this->db->query("SELECT DISTINCT date_format(b.rampcheck_date, '%Y') AS year_rampcheck, 
            count(DISTINCT b.rampcheck_noken) AS ttl_rampcheck, 
            (SELECT count(DISTINCT rampcheck_noken) FROM t_rampcheck WHERE date_format(rampcheck_date, '%m-%Y') = date_format(CURRENT_DATE(), '%m-%Y') AND is_deleted = 0) AS this_month,
            (
                SELECT count(DISTINCT b.rampcheck_noken) AS ttl_armada FROM t_rampcheck_kesimpulan a
                        JOIN t_rampcheck b ON b.id = a.rampcheck_id
                        WHERE a.rampcheck_kesimpulan_status IN ('0', '1')
            ) AS laik,
            (
                SELECT count(DISTINCT b.rampcheck_noken) FROM t_rampcheck_kesimpulan a
                        JOIN t_rampcheck b ON b.id = a.rampcheck_id
                        WHERE a.rampcheck_kesimpulan_status IN ('2', '3')
            ) AS tidak_laik
                        FROM t_rampcheck_kesimpulan a
                        JOIN t_rampcheck b ON b.id = a.rampcheck_id
                        INNER JOIN m_user_web c ON b.created_by=c.id
                        WHERE b.is_deleted = '0' AND date_format(b.rampcheck_date, '%Y') = date_format(CURRENT_DATE(), '%Y')")->getResultArray();
        }

        return $response;
    }

    public function getCountArmadaRampcheckToday()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');  
        if($this->session->get('instansi_detail_id')!=null){
            $response = $this->db->query("SELECT count(a.rampcheck_no) AS ttl_rampcheck
            FROM
            t_rampcheck a 
            inner join m_user_web b on a.created_by=b.id
            inner join m_instansi_detail c on c.id = b.instansi_detail_id
            WHERE a.is_deleted = '0' 
            AND a.rampcheck_date = CURRENT_DATE()
            AND (a.created_by=? OR 
                IF( POSITION(? IN c.kode)>0
                    , c.kode like CONCAT_WS( 
                        '', 
                        LEFT(c.kode,POSITION(? IN c.kode)+LENGTH(?)-1)
                        ,'%'
                        ) 
                    ,c.kode like '000%'
                ) 
            )", array($iduser,$instansiId,$instansiId,$instansiId))->getResultArray();    
        }else{
            $response = $this->db->query("SELECT count(rampcheck_noken) AS ttl_rampcheck FROM t_rampcheck WHERE rampcheck_date = CURRENT_DATE() AND is_deleted='0'")->getResultArray();
            
        }
        return $response;
    }

}
