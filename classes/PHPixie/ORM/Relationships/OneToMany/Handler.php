<?php

namespace PHPixe\ORM\Relationships\OneToMany;

class Handler{
	
	protected $id_subquery_strategy;
	
	public function items_query($owner_condition, $property) {
		$config = $this->get_config($owner_condition->model_name(), $property);
		return $config['item_repo']->query()
									->related($config['item_property'], $owner_condition);
	}
	
	public function owner_query($item_condition, $property) {
		$config = $this->get_config($item_condition->model, $property);
		return $config['owner_repo']->query()
									->related($config['owner_property'], $item_condition);
	}
	
	protected function get_owner_keys_subquery($params, $conditions) {
		$repo = $config['item_repo'];
		$query = $repo->connection()->query('select')
						->distinct()
						->fields(array($config['item_key']))
						->table($repo->table());
						
		$this->mapper->add_conditions($query, $conditions);
		return $query;
	}
	
	public function process_relationship($query, $model_name, $relationship, $plan) {
		
	}
}