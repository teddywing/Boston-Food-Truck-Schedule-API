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
	
	public $food_truck_output = array(
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
		'Downtown - City Hall Plaza, Fisher Park',
        'City Hall Plaza, Fisher Park'
	);
	
	
	public function __construct () {
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
	
	
	public function schedule ($options = array()) {
		$available_options = array(
			'trucks' => isset($options['trucks']),
			'days_of_week' => isset($options['days_of_week']),
			'times_of_day' => isset($options['times_of_day']),
			'locations' => isset($options['locations'])
		);
		$has_days = isset($options['days_of_week']);
		$has_times = isset($options['times_of_day']);
		$has_locations = isset($options['locations']);
		
		// Copy set options into their own array
		$set_options = array();
		foreach ($available_options as $key => $value) {
			if ($value) {
				$set_options[$key] = $value;
			}
		}
		
		// Go through all food trucks
		for ($i = 0; $i < $this->food_truck_nodes['locations']->length; $i++) {
			$matches = 0;
			
			// Perform filters on this food truck
			foreach ($set_options as $key => $value) {
				if ($value and call_user_func_array(array($this, $key), array($i, $options[$key]))) {
					$matches++;
				}
			}
			
			// If all filters pass, add this truck to the list
			if ($matches == sizeof($set_options)) {
				$this->_add_food_truck($i);
			}
		}
		
		
		return $this->food_truck_output;
	}
	
	
	// Filtering functions
	private function filter ($list_name, $list_index, $array) {
		return in_array($this->food_truck_nodes[$list_name]->item($list_index)->nodeValue, $array);
	}
	
	
	private function trucks ($list_index, $array) {
		return $this->filter('trucks', $list_index, $array);
	}
	
	
	private function days_of_week ($list_index, $array) {
		return $this->filter('days_of_week', $list_index, $array);
	}
	
	
	private function times_of_day ($list_index, $array) {
		return $this->filter('times_of_day', $list_index, $array);
	}
	
	
	private function locations ($list_index, $array) {
		return $this->filter('locations', $list_index, $array);
	}
	
	
	// Add food truck to the final list
	private function _add_food_truck ($list_index) {
		$this->food_truck_output['food_trucks'][] = array(
			'company' => $this->food_truck_nodes['companies']->item($list_index)->nodeValue,
			'company_url' => $this->food_truck_nodes['company_urls']->item($list_index)->nodeValue,
			'day_of_week' => $this->food_truck_nodes['days_of_week']->item($list_index)->nodeValue,
			'time_of_day' => $this->food_truck_nodes['times_of_day']->item($list_index)->nodeValue,
			'location' => $this->food_truck_nodes['locations']->item($list_index)->nodeValue
		);
	}
	
	
	// Show lunch trucks today
	public function trucks_now () {
		return $this->schedule(array(
			'days_of_week' => array(date('l')),
			'times_of_day' => array('Lunch')
		));
	}
}
