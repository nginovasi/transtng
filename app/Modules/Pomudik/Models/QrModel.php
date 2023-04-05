<?php
namespace App\Modules\Qr\Models;

use App\Core\BaseModel;
use LDAP\Result;

class QRModel extends BaseModel
{
    public function getQr()
    {
        return $this->db->query('SELECT a.* from t_transaction_mudik a where a.billing_code != 0')->getResult();
    }

}