<?php

namespace PHPixie\ORM\Relationships\OneToMany;

class Mapper {
	
	protected function normalize_config($config) {
		$owner_model = $config->get('owner.model');
		$item_model = $config->get('items.model');
		
		$owner_repo = $this->registry->get($owner_model);
		$item_repo = $this->registry->get($item_model);
		
		return array(
			'owner_repo' => $owner_repo,
			'item_repo' => $item_repo,
			
			'item_key' => $config->get('items.owner_id', $owner_model.'_id'),
			
			'owner_property' => $this->inflector->plural($items_model),
			'item_property' => $owner_model
		);
	}
	
}