<?php

namespace App\Modules\Laporan\Models;

use App\Core\BaseModel;

class LaporanModel extends BaseModel
{
    public function lapspda_export($filter)
    {
        $opsi = $filter['opsi'];
        $spda_date = $filter['spda_date'];
        $spda_month = $filter['spda_month'];
        $spda_year = $filter['spda_year'];
        $kategori_angkutan_id = $filter['kategori_angkutan_id'];
        $trayek_id = $filter['trayek_id'];

        if ($opsi == 1) {
            $query = "  SELECT DISTINCT b.kategori_angkutan_name, d.armada_plat_number, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, count(a.kd_bus_spda) AS jml_bus, a.ritase_spda, a.ttl_penumpang_spda,  
                        CONCAT(CEIL((a.ttl_penumpang_spda / d.armada_kapasitas) * 100), ' %') AS load_factor 
                        FROM t_form_spda a
                        LEFT JOIN m_kategori_angkutan b ON b.id = a.kategori_angkutan_id
                        LEFT JOIN m_route c ON c.id = a.trayek_id
                        LEFT JOIN m_armada d ON d.id = a.kd_bus_spda
                        WHERE a.tgl_spda = '" . $spda_date . "' AND a.kategori_angkutan_id = '" . $kategori_angkutan_id . "' AND a.trayek_id = '" . $trayek_id . "'
                        GROUP BY b.kategori_angkutan_name, d.armada_plat_number, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, a.ritase_spda, a.ttl_penumpang_spda, 'load factor'
                        ORDER BY a.tgl_spda";
        } else {
            $query = "  SELECT DISTINCT b.kategori_angkutan_name, '' as armada_plat_number, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, count(a.kd_bus_spda) AS jml_bus, a.ritase_spda, a.ttl_penumpang_spda,  
                        CONCAT(CEIL((a.ttl_penumpang_spda / d.armada_kapasitas) * 100), ' %') AS load_factor 
                        FROM t_form_spda a
                        LEFT JOIN m_kategori_angkutan b ON b.id = a.kategori_angkutan_id
                        LEFT JOIN m_route c ON c.id = a.trayek_id
                        LEFT JOIN m_armada d ON d.id = a.kd_bus_spda
                        WHERE extract(YEAR_MONTH FROM a.tgl_spda) = '" . $spda_year . $spda_month . "' AND a.kategori_angkutan_id = '" . $kategori_angkutan_id . "' AND a.trayek_id = '" . $trayek_id . "'
                        GROUP BY b.kategori_angkutan_name, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, a.ritase_spda, a.ttl_penumpang_spda, 'load factor'
                        ORDER BY a.tgl_spda";
        }
        $result = $this->db->query($query)->getResult();

        return $result;
    }

    public function laprampcheck_export($filter)
    {

        // $rampcheckMonth = $filter['rampcheckMonth'];
        // $rampcheckYear = $filter['rampcheckYear'];

        $query = "SELECT a.rampcheck_no, a.rampcheck_date, a.rampcheck_jenis_lokasi_id, a.rampcheck_nama_lokasi, a.rampcheck_po_name, a.rampcheck_noken, a.rampcheck_stuk, d.jenis_lokasi_name,
                  CASE WHEN a.rampcheck_jenis_lokasi_id = 1 THEN c.terminal_name
                  ELSE a.rampcheck_nama_lokasi
                  END AS rampcheck_lokasi,
                  a.rampcheck_trayek, CASE WHEN b.rampcheck_kesimpulan_status = 0 THEN 'DIIJINKAN OPERASIONAL'
                  WHEN b.rampcheck_kesimpulan_status = 1 THEN 'PERINGATAN/PERBAIKI'
                  WHEN b.rampcheck_kesimpulan_status = 2 THEN 'TILANG DAN DILARANG OPERASIONAL'
                  ELSE 'DILARANG OPERASIONAL'
                  END AS rampcheck_kesimpulan
                  FROM t_rampcheck a
                  JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
                  LEFT JOIN m_terminal c ON c.id = a.rampcheck_nama_lokasi
                  LEFT JOIN m_jenis_lokasi d ON d.id = a.rampcheck_jenis_lokasi_id WHERE a.is_deleted = '0' and MONTH(a.rampcheck_date) = '" . uri_segment(3) . "' AND YEAR(a.rampcheck_date) = '" . uri_segment(4) . "'";

        $result = $this->db->query($query)->getResult();

        return $result;
    }

    public function cekdatapnp_export($filter)
    {
        // if (base64_decode($filter) == "mudik") {
        //     return base64_decode($filter);
        //     $where = "a.jadwal_type = '1'";
        // } else if (base64_decode($filter) == "balik"){
        //     return base64_decode($filter);
        //     $where = "a.jadwal_type = '2'";
        // } else {
        $data_explode = explode(".", $filter);
        $id = base64_decode($data_explode[0]);
        $jadwal = base64_decode($data_explode[1]);
        $where = "AND a.id = '$id' AND a.open = '1' AND a.jadwal_type = '$jadwal' AND d.billing_cancel = 0 ORDER BY b.jadwal_id, c.transaction_booking_name ASC";
        // }

        $query = "SELECT
                        b.*,
                        c.transaction_booking_name,
                        d.billing_status_verif,
                        CONCAT(SUBSTRING(c.transaction_nik, 1, 13),'XXX') AS nik,
                        DATE_FORMAT(c.verified_at, '%d/%m/%Y %T') AS verified_at,
                        e.user_web_name,
                        g.route_name,
                        f.armada_name,
                        f.armada_code,
                        CONCAT(f.armada_name, ' (', f.armada_code,') - (', DATE_FORMAT(a.jadwal_date_depart, '%d/%m/%Y'), ' ', a.jadwal_time_depart, ' s/d ', DATE_FORMAT(a.jadwal_date_arrived, '%d/%m/%Y'), ' ', a.jadwal_time_arrived,')') AS info_jadwal,
                        CASE
                            WHEN d.billing_status_verif = 0 THEN IF(NOW() > d.billing_verif_expired_date , '1', '0')
                            WHEN d.billing_status_verif = 1 THEN IF(NOW() > d.billing_verif_expired_date , '0', '1')
                        END AS 'status_expired',
                        CASE 
                            WHEN a.jadwal_type = 1 THEN 'Mudik'
                            WHEN a.jadwal_type = 2 THEN 'Balik'
                        END AS 'arus',
                        IF (h.user_mobile_phone IS NULL, '-', h.user_mobile_phone) AS phone
                    FROM t_jadwal_mudik a
                    JOIN t_jadwal_seat_mudik b ON a.id = b.jadwal_id
                    LEFT JOIN t_transaction_mudik c ON b.transaction_id = c.id
                    LEFT JOIN t_billing_mudik d ON c.billing_id = d.id
                    LEFT JOIN m_user_web e ON e.id = c.verified_by
                    LEFT JOIN m_armada_mudik f ON a.jadwal_armada_id = f.id
                    LEFT JOIN m_route g ON a.jadwal_route_id = g.id
                    LEFT JOIN m_user_mobile h ON h.id = d.billing_user_id 
                    WHERE a.is_deleted = 0 $where";

        $result = $this->db->query($query)->getResult();
        return array($result);
    }

    public function cekdatapnp_xls($filter)
    {
        if (isset($filter['jadwal_type'])) {
            if (base64_decode($filter['jadwal_type']) == "mudik") {
                $where = "AND a.open = 1 AND a.jadwal_type = 1 AND d.billing_cancel = 0 ORDER BY b.jadwal_id, c.transaction_booking_name ASC";
                $text = "Mudik";
            } else if (base64_decode($filter['jadwal_type']) == "balik") {
                $where = "AND a.open = 1 AND a.jadwal_type = 2 AND d.billing_cancel = 0 ORDER BY b.jadwal_id, c.transaction_booking_name ASC";
                $text = "Balik";
            } else {
                $id = base64_decode($filter['jadwal_mudik_id']);
                $jadwal = base64_decode($filter['jadwal']);
                $where = "AND a.id = '$id' AND a.jadwal_type = '$jadwal' AND a.open = 1 AND d.billing_cancel = 0 ORDER BY b.jadwal_id, c.transaction_booking_name ASC";
                $text = "";
            }
        } else {
            $id = base64_decode($filter['jadwal_mudik_id']);
            $jadwal = base64_decode($filter['jadwal']);
            $where = "AND a.id = '$id' AND a.jadwal_type = '$jadwal' AND a.open = 1 AND d.billing_cancel = 0 ORDER BY b.jadwal_id, c.transaction_booking_name ASC";
            $text = "";
        }

        $query = "SELECT
                        b.*,
                        c.transaction_booking_name,
                        d.billing_status_verif,
                        CONCAT(SUBSTRING(c.transaction_nik, 1, 13),'XXX') AS nik,
                        DATE_FORMAT(c.verified_at, '%d/%m/%Y %T') AS verified_at,
                        e.user_web_name,
                        g.route_name,
                        f.armada_name,
                        f.armada_code,
                        CONCAT(f.armada_name, ' (', f.armada_code,') - (', DATE_FORMAT(a.jadwal_date_depart, '%d/%m/%Y'), ' ', a.jadwal_time_depart, ' s/d ', DATE_FORMAT(a.jadwal_date_arrived, '%d/%m/%Y'), ' ', a.jadwal_time_arrived,')') AS info_jadwal,
                        CASE
                            WHEN d.billing_status_verif = 0 THEN IF(NOW() > d.billing_verif_expired_date , '1', '0')
                            WHEN d.billing_status_verif = 1 THEN IF(NOW() > d.billing_verif_expired_date , '0', '1')
                        END AS 'status_expired',
                        CASE 
                            WHEN a.jadwal_type = 1 THEN 'Mudik'
                            WHEN a.jadwal_type = 2 THEN 'Balik'
                        END AS 'arus',
                        IF (h.user_mobile_phone IS NULL, '-', h.user_mobile_phone) AS phone
                    FROM t_jadwal_mudik a
                    JOIN t_jadwal_seat_mudik b ON a.id = b.jadwal_id
                    LEFT JOIN t_transaction_mudik c ON b.transaction_id = c.id
                    LEFT JOIN t_billing_mudik d ON c.billing_id = d.id
                    LEFT JOIN m_user_web e ON e.id = c.verified_by
                    LEFT JOIN m_armada_mudik f ON a.jadwal_armada_id = f.id
                    LEFT JOIN m_route g ON a.jadwal_route_id = g.id
                    LEFT JOIN m_user_mobile h ON h.id = d.billing_user_id 
                    WHERE a.is_deleted = 0 $where";
        $result = $this->db->query($query)->getResult();

        return array($result, $text);
    }

    public function cekdatamotis_export($filter)
    {
        $data_explode = explode(".", $filter);
        $id = base64_decode($data_explode[0]);
        $jadwal = base64_decode($data_explode[1]);

        $query = "SELECT a.nama_pemilik_kendaraan, CONCAT(a.jenis_kendaraan, ' (', a.no_kendaraan,')') AS kendaraan, e.user_mobile_name, IF(e.user_mobile_phone IS NULL, '-', CONCAT('+',e.user_mobile_phone)) AS user_mobile_phone, a.no_stnk_kendaraan, CONCAT(SUBSTRING(a.nik_pendaftar_kendaraan, 1, 13),'XXX') AS nik_pendaftar_kendaraan, d.route_name, d.route_from, d.route_to, 
                    b.motis_status_verif, DATE_FORMAT(b.motis_date_verif, '%d/%m/%Y %T') AS motis_date_verif, DATE_FORMAT(b.motis_verif_expired_date, '%d/%m/%Y') AS motis_verif_expired_date,
                    CASE 
                        WHEN b.motis_status_verif = 0 THEN IF (NOW() > b.motis_verif_expired_date, 'Expired', 'Masih Berlaku')
                        WHEN b.motis_status_verif = 1 THEN IF (b.motis_date_verif > b.motis_verif_expired_date, 'Expired', 'Masih Berlaku')
                        WHEN b.motis_status_verif = 2 THEN IF (b.motis_date_verif > b.motis_verif_expired_date, 'Expired', 'Expired')
                    END AS status_expired,
                    CASE 
                        WHEN c.jadwal_type = 1 THEN 'Mudik'
                        WHEN c.jadwal_type = 2 THEN 'Balik'
                    END AS 'arus'
                    FROM t_motis_manifest_mudik a
                    JOIN t_billing_motis_mudik b ON b.id = a.motis_billing_id
                    JOIN t_jadwal_motis_mudik c ON c.id = b.motis_jadwal_id
                    JOIN m_route d ON d.id = c.jadwal_route_id
                    JOIN m_user_mobile e ON e.id = b.motis_user_id 
                    WHERE b.motis_armada_id = '$id' AND b.motis_cancel = 0
                    ORDER BY e.user_mobile_name ASC, a.nama_pemilik_kendaraan ASC;";

        $result = $this->db->query($query)->getResult();
        return array($result);
    }

    public function cekdatamotis_xls($filter)
    {
        if (isset($filter['jadwal_mudik_id'])) {
            if ($filter['jadwal_mudik_id'] != '') {
                $jadwal_mudik_id = base64_decode($filter['jadwal_mudik_id']);
                $where = "b.motis_armada_id = '$jadwal_mudik_id' AND b.motis_cancel = 0";
            }
        } else if (isset($filter['jadwal'])) {
            if ($filter['jadwal'] != '') {
                $tipejadwal = base64_decode($filter['jadwal']);
                if ($tipejadwal == 'mudik') {
                    $where = "c.jadwal_type = '1' AND b.motis_cancel = 0";
                } else if ($tipejadwal == 'balik') {
                    $where = "c.jadwal_type = '2' AND b.motis_cancel = 0";
                }
            }
        } else {
            $jadwal_mudik_id = base64_decode($filter['jadwal_mudik_id']);
            $tipejadwal = base64_decode($filter['jadwal']);
            $where = "c.jadwal_type = '$tipejadwal' AND b.motis_armada_id = '$jadwal_mudik_id' AND b.motis_cancel = 0";
        }

        $query = "SELECT
                        IF (a.nama_pemilik_kendaraan IS NULL, '-', a.nama_pemilik_kendaraan) AS nama_pemilik_kendaraan,
                        CONCAT(a.jenis_kendaraan, ' (', a.no_kendaraan, ')') AS kendaraan,
                        e.user_mobile_name,
                        IF(e.user_mobile_phone IS NULL, '-', CONCAT('\'',e.user_mobile_phone)) AS user_mobile_phone,
                        e.user_mobile_email,
                        CONCAT(' \'', a.no_stnk_kendaraan) as no_stnk_kendaraan,
                        CONCAT(SUBSTRING(a.nik_pendaftar_kendaraan, 1, 13), 'XXX') AS nik_pendaftar_kendaraan,
                        IF (f.armada_name IS NULL, '-', f.armada_name) AS armada_name,
                        d.route_name, d.route_from, d.route_to, b.motis_status_verif,
                        IF (b.motis_date_verif IS NULL, '-', DATE_FORMAT(b.motis_date_verif, '%d/%m/%Y %T')) AS motis_date_verif,
                        DATE_FORMAT(b.motis_verif_expired_date, '%d/%m/%Y %T') AS motis_verif_expired_date,
                        CASE
                            WHEN b.motis_status_verif = 0 THEN IF (DATE(NOW()) > DATE(b.motis_verif_expired_date), 'Expired', 'Belum Validasi')
                            WHEN b.motis_status_verif = 1 THEN IF (DATE(b.motis_date_verif) > DATE(b.motis_verif_expired_date), 'Sudah Validasi', 'Sudah Validasi')
                        END AS status_expired,
                        CASE
                            WHEN c.jadwal_type = 1 THEN 'Mudik'
                            WHEN c.jadwal_type = 2 THEN 'Balik'
                        END AS 'arus',
                        b.motis_is_paguyuban
                    FROM t_motis_manifest_mudik a
                    JOIN t_billing_motis_mudik b ON b.id = a.motis_billing_id
                    JOIN t_jadwal_motis_mudik c ON c.id = b.motis_jadwal_id
                    JOIN m_route d ON d.id = c.jadwal_route_id
                    JOIN m_user_mobile e ON e.id = b.motis_user_id
                    LEFT JOIN m_armada_motis_mudik f ON f.id = b.motis_armada_id 
                    WHERE $where AND b.motis_status_verif IN (0,1)
                    ORDER BY f.armada_name ASC, e.user_mobile_name ASC, a.nama_pemilik_kendaraan ASC, b.motis_jadwal_id ASC;";

        $result = $this->db->query($query)->getResult();
        return array($result);
    }

    public function getRekapRampcheck()
    {
      $response = $this->db->query("SELECT a.rampcheck_no, a.rampcheck_date, c.jenis_lokasi_name, a.rampcheck_nama_lokasi , a.rampcheck_po_name,
      a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name , a.rampcheck_trayek, b.rampcheck_kesimpulan_status,
      CASE
        WHEN b.rampcheck_kesimpulan_status = '0' THEN 'DIIJINKAN OPERASIONAL'
        WHEN b.rampcheck_kesimpulan_status = '1' THEN 'PERINGATAN/PERBAIKI'
        WHEN b.rampcheck_kesimpulan_status = '2' THEN 'TILANG DAN DILARANG OPERASIONAL'
      ELSE 'DILARANG OPERASIONAL'
      END AS rampcheck_kesimpulan_status
      FROM t_rampcheck a
      JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
      JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
      JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
      WHERE a.is_deleted = '0'
      ORDER BY a.rampcheck_date desc")->getResultArray();

      return $response;
  }
}
