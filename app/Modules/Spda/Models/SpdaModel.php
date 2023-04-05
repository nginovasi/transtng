<?php
namespace App\Modules\Spda\Models;

use App\Core\BaseModel;

class SpdaModel extends BaseModel
{
    public function spda_export($filter)
	{
		$data_explode = explode(".", $filter);
		$no_spda = $data_explode[0];
		$id_spda = $data_explode[1];
		
		$query = "SELECT a.id, d.trayek_name, a.no_spda, a.tgl_spda, b.nama_pengemudi, c.armada_code, a.ritase_spda, a.jrk_tempuh_spda, a.wkt_tempuh_spda, a.bbm_spda, c.armada_kapasitas, a.ttl_penumpang_spda, a.ttl_pdptan_spda,
        form_spda_ttd_pengemudi, form_spda_ttd_manager, form_spda_nama_manager
		FROM t_form_spda a
		LEFT JOIN m_driver b ON b.id = a.driver_spda
		LEFT JOIN m_armada c ON c.id = a.kd_bus_spda 
		 LEFT JOIN m_trayek d ON d.id = a.trayek_id
        WHERE a.is_deleted = 0 AND a.id='" . base64_decode($data_explode['1']) . "' AND a.no_spda='" . base64_decode($data_explode['0']) . "' ";
		
		return $this->db->query($query)->getRow();
	}

  public function saveSpdaForm( array $dataSpda) {
		$db = \Config\Database::connect();
		$builderSpda = $db->table('t_form_spda');
		$builderSpdaForm = $db->table('t_form_spda');
		$this->db->transBegin();

		if ($builderSpda->insert($dataSpda)) {
			return $db->insertID();
		} else {
			return false;
		}
	}

}
