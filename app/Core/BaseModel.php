<?php 
namespace App\Core;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class BaseModel extends Model
{
	protected $db;

	protected $session;

	protected $request;

	function __construct(RequestInterface $request=null) {
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->request = $request;
	}

	function log_action($action, $result){
		helper("extension");
		$builder = $this->db->table('s_log_privilege');
		$post = $this->request->getVar();

		foreach ($post as $key => $value) {
            if(strpos($key, 'password')!== false){
                $post[$key] = md5(base64_encode($value."abcdexxxyqt"));
            }
        }

		$log_data = [
			'log_action' => $action,
			'log_url' => $_SERVER['REQUEST_URI'],
            'log_param' => json_encode($post),
			'log_result' => $result,
			'log_ip' => get_client_ip(),
            'log_user_agent' => get_client_user_agent(),
			'user_web_id' => $this->session->get('id')
		];

		$builder->insert($log_data);
	}

	function log_api($data){
		$builder = $this->db->table('s_log_api');
		$builder->insert($data);
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

	function base_insertRID($data, $table){
		$builder = $this->db->table($table);

		$builder->insert($data);
		return $this->db->insertID();
	}

	function base_insertBatch($data, $table){
		$builder = $this->db->table($table);

		$builder->insertBatch($data);
		return $this->db->insertID();
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

	function base_deletev2($table, $where){
		$builder = $this->db->table($table);
		$builder->where($where);

		$updateData['is_deleted'] = 1;
		$updateData['deleted_at'] = date('Y-m-d H:i:s');
		$updateData['deleted_by'] = $this->session->get('id');

		return $builder->update($updateData);
	}


	function base_load_datatable($baseQuery, $whereQuery, $whereTerm, $start, $length, $orderColumn, $orderDirection, $groupBy = NULL){
		$q = ($whereTerm != "" ? $baseQuery . " and (" . implode(" or ", array_map(function($x) use ($whereTerm) {
			return $x == "json" ? "JSON_SEARCH(".$x.", 'one', ?, '', '$[*]')" : $x . " like ?";
		}, $whereQuery)) . ")" : $baseQuery) . ($groupBy != NULL ? "group by " . implode(", ", $groupBy) : "") . " order by ".$orderColumn." ".$orderDirection;

		$whereKey = array_map(function($x) use ($whereTerm){
			return "%".addslashes($whereTerm)."%";
		}, $whereQuery);

        $allData = count($this->db->query($baseQuery)->getResult());
        $filteredData = count($this->db->query($q, $whereKey)->getResult());

        $q .= $length > -1 ? " limit ".$start.",".$length : "";

        return [ "data" => $this->db->query($q, $whereKey)->getResult(), "allData" => $allData, "filteredData" => $filteredData ];
	}

	function base_load_select2($baseQuery, $whereField, $keyword, $page, $perpage){
        $q = $whereField != "" ? $baseQuery . " and (" .implode(" or ", array_map(function($x) use ($keyword) {
            return $x . " like ?";
        }, $whereField)) . ")" : $baseQuery;

        $whereKey = array_map(function($x) use ($keyword) {
            return "%".addslashes($keyword)."%";
        }, $whereField);

        // $q .= " limit ".($page * $perpage).",".$perpage;

        return $whereField != "" ? $this->db->query($q, $whereKey)->getResult() : $this->db->query($q)->getResult();
    }

    public function export_view($menu , $filter){
        return $this->$menu($filter);
    
    }
}