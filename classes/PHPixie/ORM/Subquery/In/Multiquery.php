<?php

namespace PHPixie\ORM\Subquery\In;

class Multiquery extends PHPixie\ORM\Subquery\In {
	
	protected $steps;
	
	public function __construct($steps) {
		$this->steps = $steps;
	}
	
	public function add_subquery_condition($query, $logic, $negated, $field, $subquery) {
		$placeholder = $query->get_builder('where')
				->placeholder($logic, $negated);
				
		$step = $this->steps->in_subquery($subquery, $placeholder, $field);
		$plan->prepend_step($step);
	}
	
}