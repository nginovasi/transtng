<?php 
namespace App\Core;

use CodeIgniter\Model;

class BaseModel extends Model
{
	protected $db;

	protected $session;

	function __construct() {
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
	}

	function log_action($action, $result){
		$builder = $this->db->table('master_user_privileges_log');

		$log_data = [
			'log_action' => $action,
			'log_url' => $_SERVER['REQUEST_URI'],
			'log_result' => "Akses diberikan",
			'user_id' => $this->session->get('id'),
			'user_ip' => $_SERVER['REMOTE_ADDR']
		];

		$builder->insert($log_data);
	}

	function base_get($table, $where){
		$builder = $this->db->table($table);
		$builder->where($where);

		return $builder->get();
	}

	function base_insert($data, $table){
		$builder = $this->db->table($table);

		return $builder->insert($data);
	}

	function string_insert($data, $table){
		$builder = $this->db->table($table);

		return $builder->set($data)->getCompiledInsert();		
	}

	function base_update($data, $table, $where){
		$builder = $this->db->table($table);
		$builder->where($where);

		return $builder->update($data);	
	}

	function base_updatebatch($data, $table, $field){
		$builder = $this->db->table($table);

		return $builder->updateBatch($data, $field);
	}

	function base_delete($table, $where){
		$builder = $this->db->table($table);
		$builder->where($where);

		$updateData['is_deleted'] = 1;
		$updateData['last_edited_at'] = date('Y-m-d H:i:s');
		$updateData['last_edited_by'] = $this->session->get('id');

		return $builder->update($updateData);
	}

	function base_load_datatable($baseQuery, $whereQuery, $whereTerm, $start, $length, $orderColumn, $orderDirection){
		$q = ($whereTerm != "" ? $baseQuery . " and (" .implode(" or ", array_map(function($x) use ($whereTerm) {
			return $x . " like '%". $key ."%'";
		}, $whereQuery)) . ")" : $baseQuery) . " order by ".$orderColumn." ".$orderDirection;

        $allData = count($this->db->query($baseQuery)->getResult());
        $filteredData = count($this->db->query($q)->getResult());

        $q .= $length > -1 ? " limit ".$start.",".$length : "";

        return [ "data" => $this->db->query($q)->getResult(), "allData" => $allData, "filteredData" => $filteredData ];
	}
}