<?php
namespace App\Modules\Traffic\Models;

use App\Core\BaseModel;

class TrafficModel extends BaseModel
{
  public function getDataTraffic()
  {
    $response = $this->db->query('select log_result from s_log_api_traffic_count order by created_at desc limit 1')->getResult();
    return $response;
  }
}
