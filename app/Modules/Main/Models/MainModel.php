<?php namespace App\Modules\Main\Models;

use App\Core\BaseModel;

class MainModel extends BaseModel {

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function findByKoridor()
    {
        $sql = "SELECT a.*, b.name as text
                    FROM ref_jalur a
                    LEFT JOIN m_type_bis b
                        ON a.type_bis_id = b.id
                    WHERE a.is_deleted = 0";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

}
