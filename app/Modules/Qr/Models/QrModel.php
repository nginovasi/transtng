<?php

namespace App\Modules\Qr\Models;

use App\Core\BaseModel;

class QrModel extends BaseModel
{
	public function getUserDetail()
	{
		return $this->db->query('select a.* from m_user_web a where a.id = ' . $this->session->get('id') . ' and a.is_deleted = 0')->getRow();
	}
	
}
