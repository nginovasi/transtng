<?php
namespace App\Modules\Rampcheck\Models;

use App\Core\BaseModel;

class RampcheckModel extends BaseModel
{
    public function getTerminalLocation()
    {
        return $this->db->query('select a.terminal_city_name, a.id from m_terminal a where a.is_deleted = 0 and a.terminal_type = "A"')->getResult();
    }

    public function getTerminal()
    {
        return $this->db->query('select a.id, a.terminal_name from m_terminal a where a.is_deleted = 0 and a.terminal_type = "A"')->getResult();
    }

    public function getJenisAngkutan()
    {
        return $this->db->query('select a.* from m_jenis_angkutan a where a.is_deleted = 0')->getResult();
    }

    public function getJenisLokasi()
    {
        return $this->db->query('select a.* from m_jenis_lokasi a where a.is_deleted = 0')->getResult();
    }

    public function getTrayek()
    {
        return $this->db->query('select a.id, a.trayek_code, a.trayek_name from m_trayek a where a.is_deleted = 0')->getResult();
    }

    public function saveRampcheck(array $dataRampcheck)
    {
        $db = \Config\Database::connect();
        $builderRampcheck = $db->table('t_rampcheck');
        $builderRampcheckKesimpulan = $db->table('t_rampcheck_kesimpulan');
        $this->db->transBegin();

        if ($builderRampcheck->insert($dataRampcheck)) {
            return $db->insertID();
        } else {
            return false;
        }
    }

    public function deleteRampcheck($id)
    {
        $this->db->transBegin();

        $updateData['is_deleted'] = 1;
        $updateData['updated_at'] = date('Y-m-d H:i:s');
        $updateData['updated_by'] = $this->session->get('id');

        $tableAdm = 't_rampcheck_adm';
        $builderAdm = $this->db->table($tableAdm);
        $builderAdm->where('rampcheck_id', $id);
        $builderAdm->update($updateData);

        $tableUtu = 't_rampcheck_utu';
        $builderUtu = $this->db->table($tableUtu);
        $builderUtu->where('rampcheck_id', $id);
        $builderUtu->update($updateData);

        $tableUtp = 't_rampcheck_utp';
        $builderUtp = $this->db->table($tableUtp);
        $builderUtp->where('rampcheck_id', $id);
        $builderUtp->update($updateData);

        $tableKesimpulan = 't_rampcheck_kesimpulan';
        $builderKesimpulan = $this->db->table($tableKesimpulan);
        $builderKesimpulan->where('rampcheck_id', $id);
        $builderKesimpulan->update($updateData);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $this->db->transComplete();
            return false;
        } else {
            $rampcheckHeader = $this->db->table('t_rampcheck');
            $rampcheckHeader->where('id', $id);

            $rampcheckHeader->update($updateData);

            $this->db->transCommit();
            $this->db->transComplete();
            return true;
        }
    }

    public function getDataRampcheck()
    {
        return $this->db->query("SELECT a.rampcheck_no, a.rampcheck_date, c.jenis_lokasi_name, d.terminal_name , a.rampcheck_po_name,
      a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name , f.trayek_name, b.rampcheck_kesimpulan_status,
      CASE
        WHEN b.rampcheck_kesimpulan_status = '0' THEN 'DIIJINKAN OPERASIONAL'
        WHEN b.rampcheck_kesimpulan_status = '1' THEN 'PERINGATAN/PERBAIKI'
        WHEN b.rampcheck_kesimpulan_status = '2' THEN 'TILANG DAN DILARANG OPERASIONAL'
      ELSE 'DILARANG OPERASIONAL'
      END AS rampcheck_kesimpulan_status
      FROM t_rampcheck a
      JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
      JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
      JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
      JOIN m_jenis_angkutan e on e.id = a.rampcheck_jenis_angkutan_id
      JOIN m_trayek f on f.id = a.rampcheck_trayek
      WHERE a.is_deleted = '0'")->getResult();
    }

    public function rampcheck_export($filter)
    {
        $data_explode = explode(".", $filter);

        $query = "SELECT a.id, a.rampcheck_no, a.rampcheck_date, f.jenis_lokasi_name, coalesce(h.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name, a.rampcheck_pengemudi, a.rampcheck_umur_pengemudi, a.rampcheck_po_name, a.rampcheck_noken, a.rampcheck_stuk, g.jenis_angkutan_name AS jenis_angkutan_name, a.rampcheck_trayek AS trayek_name, a.rampcheck_sticker_no,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_adm_ku', b.rampcheck_adm_ku, 'rampcheck_adm_kpr', b.rampcheck_adm_kpr, 'rampcheck_adm_kpc', b.rampcheck_adm_kpc, 'rampcheck_adm_sim', b.rampcheck_adm_sim))),']')AS json) AS administrasi,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_utu_lukd', d.rampcheck_utu_lukd, 'rampcheck_utu_lukj', d.rampcheck_utu_lukj, 'rampcheck_utu_lpad', d.rampcheck_utu_lpad, 'rampcheck_utu_lpaj', d.rampcheck_utu_lpaj, 'rampcheck_utu_lm', d.rampcheck_utu_lm, 'rampcheck_utu_lr', d.rampcheck_utu_lr, 'rampcheck_utu_kru', d.rampcheck_utu_kru, 'rampcheck_utu_krp', d.rampcheck_utu_krp, 'rampcheck_utu_kbd', d.rampcheck_utu_kbd, 'rampcheck_utu_kbb', d.rampcheck_utu_kbb, 'rampcheck_utu_skp', d.rampcheck_utu_skp, 'rampcheck_utu_pk', d.rampcheck_utu_pk, 'rampcheck_utu_pkw', d.rampcheck_utu_pkw, 'rampcheck_utu_pd', d.rampcheck_utu_pd, 'rampcheck_utu_jd', d.rampcheck_utu_jd, 'rampcheck_utu_apk', d.rampcheck_utu_apk, 'rampcheck_utu_apar', d.rampcheck_utu_apar))),']')AS json) AS unsur_utama,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_utp_sp_dpn', c.rampcheck_utp_sp_dpn, 'rampcheck_utp_sp_blk', c.rampcheck_utp_sp_blk, 'rampcheck_utp_bk_kcd', c.rampcheck_utp_bk_kcd, 'rampcheck_utp_bk_pu', c.rampcheck_utp_bk_pu, 'rampcheck_utp_bk_kru', c.rampcheck_utp_bk_kru, 'rampcheck_utp_bk_krp', c.rampcheck_utp_bk_krp, 'rampcheck_utp_bk_ldt', c.rampcheck_utp_bk_ldt, 'rampcheck_utp_ktd_jtd', c.rampcheck_utp_ktd_jtd, 'rampcheck_utp_pk_bc', c.rampcheck_utp_pk_bc, 'rampcheck_utp_pk_sp', c.rampcheck_utp_pk_sp, 'rampcheck_utp_pk_dkr', c.rampcheck_utp_pk_dkr, 'rampcheck_utp_pk_pbr', c.rampcheck_utp_pk_pbr, 'rampcheck_utp_pk_ls', c.rampcheck_utp_pk_ls, 'rampcheck_utp_pk_pgr', c.rampcheck_utp_pk_pgr, 'rampcheck_utp_pk_skp', c.rampcheck_utp_pk_skp, 'rampcheck_utp_pk_ptk', c.rampcheck_utp_pk_ptk))),']')AS json) AS unsur_penunjang,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_kesimpulan_status', e.rampcheck_kesimpulan_status, 'rampcheck_kesimpulan_catatan', e.rampcheck_kesimpulan_catatan, 'rampcheck_kesimpulan_ttd_pengemudi', e.rampcheck_kesimpulan_ttd_pengemudi, 'rampcheck_kesimpulan_nama_penguji', e.rampcheck_kesimpulan_nama_penguji, 'rampcheck_kesimpulan_no_penguji', e.rampcheck_kesimpulan_no_penguji, 'rampcheck_kesimpulan_ttd_penguji', e.rampcheck_kesimpulan_ttd_penguji, 'rampcheck_kesimpulan_nama_penyidik', e.rampcheck_kesimpulan_nama_penyidik, 'rampcheck_kesimpulan_no_penyidik', e.rampcheck_kesimpulan_no_penyidik, 'rampcheck_kesimpulan_ttd_penyidik', e.rampcheck_kesimpulan_ttd_penyidik, 'nama_pengemudi', a.rampcheck_pengemudi, 'document_rampcheck', i.document_filename))),']')AS json) AS unsur_kesimpulan
        FROM t_rampcheck a
        JOIN t_rampcheck_adm b ON b.rampcheck_id = a.id
        JOIN t_rampcheck_utp c ON c.rampcheck_id = a.id
        JOIN t_rampcheck_utu d ON d.rampcheck_id = a.id
        JOIN t_rampcheck_kesimpulan e ON e.rampcheck_id = a.id
        JOIN m_jenis_lokasi f ON f.id = a.rampcheck_jenis_lokasi_id
        JOIN m_jenis_angkutan g ON g.id = a.rampcheck_jenis_angkutan_id
        LEFT JOIN m_terminal h ON h.id = a.rampcheck_nama_lokasi
        LEFT JOIN m_document_rampcheck i ON i.rampcheck_id = a.id
        WHERE a.is_deleted = 0 AND a.id='" . base64_decode($data_explode['1']) . "' AND a.rampcheck_no='" . base64_decode($data_explode['0']) . "' ";

        return $this->db->query($query)->getRow();
    }

}
