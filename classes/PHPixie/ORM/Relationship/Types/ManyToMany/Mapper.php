<?php

namespace PHPixie\ORM\Relationships\ManyToMany;

class Mapper {
	
	protected function normalize_config($config) {
		$left_model = $config->get('left.model');
		$right_model = $config->get('right.model');
		
		$left_repo = $this->registry->get($left_model);
		$right_repo = $this->registry->get($right_model);
		
		
		$config = array(
			'left_repo' => $left_repo,
			'right_repo' => $right_repo,
			'pivot_connection' => $config->get('pivot_connection', $left_repo->connection_name())
			'pivot' => $config->get('pivot', $left_repo->plural_model_name().'_'.$left_repo->plural_model_name()),
		);
		
		foreach(array('left', 'right') as $side) {
			
			if ($property = $config->get("{$side}.property", null)) {
				$config["{$side}_property"] = $property;
				$default_key = $this->inflector->singular($property).'_id';
				
			}else {
				$opposing_side = $side === 'left' ? 'right' : 'left';
				$opposing_repo = $config["{$opposing_side}_repo"];
				
				$config["{$side}_property"] = $opposing_repo->plural_model_name();
				$default_key = $opposing_repo->model_name().'_id';
				
			}
			
			$config["{$side}_pivot_key"] = $config->get("{$side}.pivot_key", $default_key);
		}
		
		return $config;
	}
	
	protected function relationship_properties($config) {
		return array(
			$params['left_repo']->model_name() => array(
				$params['left_property']
			),
			
			$params['right_repo']->model_name() => array(
				$params['right_property']
			),
		);
	}
}