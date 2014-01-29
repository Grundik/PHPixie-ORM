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
	
	protected function get_owner_ids_subquery($params, $conditions) {
		$repo = $config['owner_repo'];
		$query = $repo->connection()->query('select')
						->fields(array($repo->id_field()))
						->from($repo->table());
						
		$this->mapper->add_conditions($query, $conditions);
		return $query;
	}
	
	protected function process_items_relationship($config, $query, $group, $relationship, $plan) {
		$subquery = $this->get_owner_ids_subquery($params, $group->conditions());
		$this->id_strategy->add_condition($query, $group->logic, $group->negated(), $config['item_key'], $subquery);
	}
	
	protected function process_owner_relationship($config, $query, $group, $relationship, $plan) {
		$subquery = $this->get_item_ids_subquery($params, $group->conditions());
		$this->id_strategy->add_condition($$query, $group->logic, $group->negated(), $config['owner_repo']->id_field(), $subquery);
	}
	
	public function process_relationship($query, $model_name, $relationship, $plan) {
		
	}
}