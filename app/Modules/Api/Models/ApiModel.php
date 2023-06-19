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

  function toStream($table,$dataArray){
        $curl = curl_init();
        $datapost['key']    = 'ngiraya';
        $datapost['table']  = $table;
        $datapost['data']   = $dataArray;
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://stream.nginovasi.id:5002/api/listener',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($datapost),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic aHViZGF0Ok51c2FudGFyYTQw',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
