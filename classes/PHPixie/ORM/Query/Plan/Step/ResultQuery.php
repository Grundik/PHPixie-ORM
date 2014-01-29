<?php

namespace PHPixie\ORM\Query\Plan\Step;

class Query extends \PHPixie\ORM\Query\Plan\Step {
	
	protected $query;
	protected $model;
	protected $result;
	
	
	public function __construct($query, $model) {
		$this->query = $query;
		$this->model = $model;
	}
	
	public function execute() {
		$this->result = $this->query->execute();
	}
	
	public function result() {
		return $this->result;
	}
}