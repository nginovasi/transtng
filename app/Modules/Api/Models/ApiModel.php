<?php namespace App\Modules\Api\Models;

use App\Core\BaseModel;

class ApiModel extends BaseModel
{ 
  public function insertlog($data)
  {
    $this->db->table('s_log_api_traffic_count')->insert($data);
  }

  public function deleteLog(){
    $this->db->query('delete from s_log_api_traffic_count where date(created_at) != CURRENT_DATE');
  }
  
  public function insertAnprlog($data)
  {
    $this->db->table('s_log_api_anpr')->insert($data);
  }

  public function deleteAnprLog(){
    $this->db->query('delete from s_log_api_anpr where date(created_at) != CURRENT_DATE');
  }
}
