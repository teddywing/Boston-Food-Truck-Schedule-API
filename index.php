<?php

// error_reporting(0);

require_once('boston_food_trucks.php');

$BostonFoodTrucks = new BostonFoodTrucks;


//echo $BostonFoodTrucks->schedule();
//echo $BostonFoodTrucks->trucks_now();

echo $BostonFoodTrucks->schedule(array(
	'days_of_week' => array(date('l')),
	'times_of_day' => array('Lunch'),
	'locations'    => $BostonFoodTrucks->locations_downtown
));