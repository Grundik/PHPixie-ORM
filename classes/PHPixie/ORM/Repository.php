<?php

namespace PHPixie\ORM;

class  Repository {
	
	protected $model_name;
	protected $table;
	protected $inflector;
	protected $connection_name;
	protected $id_field;
	
	public function __construct($inflector, $model_name, $config) {
		$this->inflector = $inflector;
		
		$this->connection_name = $config->get('connection', 'default');
		
		$this->table = $config->get('table', null);
		if ($this->table === null)
			$this->table = $inflector->plural($model_name);
		
		$this->id_field = $config->get('id_field', 'id');
	}
	
	public function model_name() {
		return $this->model_name;
	}
	
	
	public function get_data($model) {
		return get_object_vars($model);
	}
	
	public abstract function save($model) {
		if ($model->loaded()) {
			$query = $this->db->query('update', $this->connection_name)
									->where($this->id_field, $);
									
		}else {
			$query = $this->db->query('insert', $this->connection_name);
		}
		
		$query->data($this->get_data($model));
		$query->execute();
	}
	
	
	

}