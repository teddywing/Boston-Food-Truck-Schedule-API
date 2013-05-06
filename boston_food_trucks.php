<?php

class BostonFoodTrucks {
	
	private $food_truck_schedule_url = 'http://www.cityofboston.gov/business/mobile/schedule-app.asp?v=1&71';
	private $food_truck_html = '';
	private $dom = null;
	private $finder = null;
	
	private $class_company = 'com';
	private $class_day_of_the_week = 'dow';
	private $class_time_of_day = 'tod';
	private $class_location = 'loc';
	
	private $food_trucks_nodes = array(
		'companies' => null,
		'company_urls' => null,
		'days_of_week' => null,
		'times_of_day' => null,
		'locations' => null,
	);
	
	private $food_truck_output = array(
    	'food_trucks' => array()
	);
	
	public $locations_downtown = array(
		'(25) Innovation District, Seaport Blvd at Thomson',
		'(23) Chinatown/Park Street, Boylston St near Washington St',
		'Rose Kennedy Greenway, Beach Street in Chinatown',
		'Rose Kennedy Greenway, Dewey Square, South Station',
		'Greenway (at High St #1)',
		'Rose Kennedy Greenway,Congress Street near Wharf',
		'Greenway - Rose Kennedy Greenway, Milk Street by Aquarium',
		'Rose Kennedy Greenway, Milk Street by Aquarium',
		'Rose Kennedy Greenway @ State Street',
		'Rose Kennedy Greenway, Cross and Hanover Streets',
		'Boston Common, Brewer Fountain by Tremont and Boylston Streets',
		'(24) Financial District, Pearl Street at Franklin',
		'(22) Financial District, Milk and Kilby Streets',
		'Downtown - City Hall Plaza, Fisher Park'
        'City Hall Plaza, Fisher Park'
	);
	
	
	function __construct () {
		$this->food_truck_html = file_get_contents($this->food_truck_schedule_url);
		$this->dom = new DOMDocument;
		$this->dom->loadHTML($this->food_truck_html);
		$this->finder = new DomXPath($this->dom);
		
		$this->food_truck_nodes['companies'] = 
			$this->finder->query('//td[@class="' . $this->class_company . '"]/a/text()');
		$this->food_truck_nodes['company_urls'] = 
			$this->finder->query('//td[@class="' . $this->class_company . '"]/a/@href');
		$this->food_truck_nodes['days_of_week'] = 
			$this->finder->query('//td[@class="' . $this->class_day_of_the_week . '"]/text()');
		$this->food_truck_nodes['times_of_day'] = 
			$this->finder->query('//td[@class="' . $this->class_time_of_day . '"]/text()');
		$this->food_truck_nodes['locations'] = 
			$this->finder->query('//td[@class="' . $this->class_location . '"]/text()');	
	}
	
	
	function schedule ($options = array()) {
// 		for ($i = 0; $i < $this->food_truck_nodes['locations']->length; $i++) {
// 			if (isset($options['days_of_week']) && 
// 			in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week'])) {
// 				
// 				if (isset($options['times_of_day']) && 
// 				in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day'])) {
// 					
// 					if (isset($options['locations']) && 
// 					in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
// 						
// 						$this->_add_food_truck($i);
// 						
// 					}
// 					else {
// 						$this->_add_food_truck($i);
// 					}
// 				}
// 				else {
// 					$this->_add_food_truck($i);
// 				}
// 			}
// 			else {
// 				$this->_add_food_truck($i);
// 			}
// 		}
// 		
// 		
// 		$has_days = isset($options['days_of_week']);
// 		$has_times = isset($options['times_of_day']);
// 		$has_locations = isset($options['locations']);
// 		
// 		$add_by_days = function($list_index) {
// 			if (in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week'])) {
// 				$this->_add_food_truck($list_index);
// 			}
// 		};
// 		
// 		$add_by_times = function($list_index) {
// 			if (in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day'])) {
// 				$this->_add_food_truck($list_index);
// 			}
// 		};
// 		
// 		$add_by_locations = function($list_index) {
// 			if (in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
// 				$this->_add_food_truck($list_index);
// 			}
// 		};
// 		
// 		if ($has_days and $has_times and $has_locations) {
// 			$add_by_days($i);
// 			$add_by_times($i);
// 			$add_by_locations($i);
// 		}
// 		else if (! $has_days and $has_times and $has_locations) {
// 			$add_by_times($i);
// 			$add_by_locations($i);
// 		}
// 		else if ($has_days and ! $has_times and $has_locations) {
// 			$add_by_days($i);
// 			$add_by_locations($i);
// 		}
// 		else if ($has_days and $has_times and ! $has_locations) {
// 			$add_by_days($i);
// 			$add_by_locations($i);
// 		}
// 		else if (! $has_days and ! $has_times and $has_locations) {
// 			$add_by_locations($i);
// 		}
		
		
// 		$has_days = isset($options['days_of_week']);
// 		$has_times = isset($options['times_of_day']);
// 		$has_locations = isset($options['locations']);
// 		
// 		if (! $has_days and ! $has_times and ! $has_locations) {
// 			for ($i = 0; $i < $this->food_truck_nodes['locations']->length; $i++) {
// 				$this->_add_food_truck($i);
// 			}
// 		}
// 		else {
// 			if ($has_days) {
// 				for ($i = 0; $i < $this->food_truck_nodes['days_of_week']->length; $i++) {
// 					if (in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week'])) {
// 						$this->_add_food_truck($i);
// 					}
// 				}
// 			}
// 			
// 			if ($has_times) {
// 				for ($i = 0; $i < $this->food_truck_nodes['times_of_day']->length; $i++) {
// 					if (in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day'])) {
// 						$this->_add_food_truck($i);
// 					}
// 				}
// 			}
// 			
// 			if ($has_locations) {
// 				for ($i = 0; $i < $this->food_truck_nodes['locations']->length; $i++) {
// 					if (in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
// 						$this->_add_food_truck($i);
// 					}
// 				}
// 			}
// 		}
		
		
		$has_days = isset($options['days_of_week']);
		$has_times = isset($options['times_of_day']);
		$has_locations = isset($options['locations']);
		
		for ($i = 0; $i < $this->food_truck_nodes['locations']->length; $i++) {
			if (! $has_days and ! $has_times and ! $has_locations) {
				$this->_add_food_truck($i);
			}
			else if ($has_days and ! $has_times and ! $has_locations) {
				if (in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week'])) {
					$this->_add_food_truck($i);
				}
			}
			else if (! $has_days and $has_times and ! $has_locations) {
				if (in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day'])) {
					$this->_add_food_truck($i);
				}
			}
			else if (! $has_days and ! $has_times and $has_locations) {
				if (in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
					$this->_add_food_truck($i);
				}
			}
			else if ($has_days and $has_times and ! $has_locations) {
				if (in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week']) and in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day'])) {
					$this->_add_food_truck($i);
				}
			}
			else if ($has_days and ! $has_times and $has_locations) {
				if (in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week']) and in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
					$this->_add_food_truck($i);
				}
			}
			else if (! $has_days and $has_times and $has_locations) {
				if (in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day']) and in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
					$this->_add_food_truck($i);
				}
			}
			else if ($has_days and $has_times and $has_locations) {
				if (in_array($this->food_truck_nodes['days_of_week']->item($i)->nodeValue, $options['days_of_week']) and in_array($this->food_truck_nodes['times_of_day']->item($i)->nodeValue, $options['times_of_day']) and in_array($this->food_truck_nodes['locations']->item($i)->nodeValue, $options['locations'])) {
					$this->_add_food_truck($i);
				}
			}
		}
		
		
		return json_encode($this->food_truck_output);
	}
	
	
	function _add_food_truck ($list_index) {
		$this->food_truck_output['food_trucks'][] = array(
			'company' => $this->food_truck_nodes['companies']->item($list_index)->nodeValue,
			'company_url' => $this->food_truck_nodes['company_urls']->item($list_index)->nodeValue,
			'day_of_week' => $this->food_truck_nodes['days_of_week']->item($list_index)->nodeValue,
			'time_of_day' => $this->food_truck_nodes['times_of_day']->item($list_index)->nodeValue,
			'location' => $this->food_truck_nodes['locations']->item($list_index)->nodeValue
		);
	}
	
	
	function trucks_now () {
		return $this->schedule(array(
			'days_of_week' => array(date('l')),
			'times_of_day' => array('Lunch')
		));
	}
}
