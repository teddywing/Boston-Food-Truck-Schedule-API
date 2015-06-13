<?php

require_once('boston_food_trucks.php');


class Request {
	public $parameters;
	
	public function parse_parameters () {
		$parameters = array();
		
		if (isset($_SERVER['QUERY_STRING'])) {
			parse_str($_SERVER['QUERY_STRING'], $parameters);
		}
		
		$this->parameters = $parameters;
	}
	
}


class Filters {
	public $filters;
	private $keys;
	
	public function __construct () {
		$this->keys = array('trucks',
			'days_of_week',
			'times_of_day',
			'locations');
	}
	
	
	public function get_filters ($array) {
		// If our array includes expected keys, add those to $this->filters
		foreach ($this->keys as $value) {
			if (isset($array[$value]) and is_array($array[$value])) {
				$this->filters[$value] = $array[$value];
			}
		}
	}
}


// Parse GET parameters
$R = new Request;
$R->parse_parameters();

// Get filters from GET parameters
$Filters = new Filters;
$Filters->get_filters($R->parameters);

// Output JSON from food truck API
$BostonFoodTrucks = new BostonFoodTrucks;
echo json_encode($BostonFoodTrucks->schedule($Filters->filters));
