<?php

class Model {
	protected $_db, $_table, $_modelName, $_softDelete = true,$_columnNames = [];
	public $id;

	public function __construct($table){
		$this->_db = DB::getInstance();
		$this->_table = $table;
		$this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
//		$this->_setTableColumns();
	}
/*
***************Pokus o zavedení možnosti objektu používat funkce např $user->login(); ***********************

	protected function _setTableColumns(){
		$columns = $this->getColumns();
		foreach ($columns as $column) {
			$columnName = $column->Field;
			$this->_columnNames[] = $column->Field;
			$this->{$columnName} = null;
		}
	}

	public function getColumns(){
		return $this->_db->get_columns($this->_table);
	}

	public function get($params = []){
		$results = [];
		$resultsQuery = $this->_db->get($this->_table, $params);
		foreach ($resultsQuery as $result) {
			$obj = new $this->_modelName($this->_table);
			$obj->populate($result);
			$results[] = $obj;
		}
		return $results;
	}

	public function getFirst($params = []){
		$resultQuery = $this->_db->getFirst($this->_table, $params);
		$result = new $this->_modelName($this->_table);
		if ($resultQuery) {
			$result->populate($resultQuery);
		}
		return $result;
	}

	protected function populate($result){
		foreach ($result as $key => $value) {
				$this->$key = $value;
			}
	}
*/

	public function findFirst($params = []){
		$params = $this->_softDelete($params);
		return $this->_db->getFirst($this->_table, $params);
	}

	public function findAll($params = []){
		$params = $this->_softDelete($params);
		return $this->_db->get($this->_table, $params);
	}

	public function findByID($id){
		$params = $this->_softDelete($params);
		return $this->findFirst(['conditions' => "id = ?", 'bind' => [$id]]);
	}

	protected function _softDelete($params){
		if ($this->_softDelete) {
			if (array_key_exists('conditions', $params)) {
				if (is_array($params['conditions'])) {
					$params['conditions'][] = "deleted != 1";
				}else {
					$params['conditions'] .= " AND deleted != 1";
				}
			}else{
				$params['conditions'] = "deleted != 1";
			}
		}

		return $params;
	}

	public function save(){
		$fields = [];
		foreach ($this->_columnNames as $column) {
			$fields[$column] = $this->$column;
		}
		//detect if it should be updated or inserted
		if (property_exists($this, 'id' && $this->id != '')) {
			return $this->update($this->id, $fields);
		}else{
			return $this->insert($fields); 
		}
	}

	public function insert($fields, $values = []){
		if ($fields != '' || $values != []) {	
			return $this->_db->insert($this->_table, $fields, $values);
		}else{
			return false;
		}
	}

	public function update($id = '', $fields, $values = []){
		if ($fields = '' || empty($values) || $id == '') {
			return false;
		}else{
			return $this->_db->update($this->_table, $id, $fields, $values);
		}
	}

	public function delete($id = ''){
		if ($id == '' && $this->id == '') return false;
		$id = ($id = '')? $this->id : $id;

		if ($this->_softDelete) {
			return $this->update($id, 'deleted', [1]);
		}else{
			return $this->_db->delete($this->table, $id);
		}
	}

	public function query($sql, $bind = []){
		return $this->_db->query($sql, $bind);
	}

	public function data(){
		$data = new stdClass();
		foreach ($this->_columnNames as $column) {
			$data->column = $this->column;
		}
		return $data;
	}

	public function assign($params){
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				if (in_array($key, $this->_columnNames)) {
					$this->$key = sanitize($value);
				}
			}
			return true;
		}
		return false;
	}


}