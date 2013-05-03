<?php

error_reporting(0);

$food_truck_html = file_get_contents('http://www.cityofboston.gov/business/mobile/schedule-app.asp?v=1&71');

$dom = new DOMDocument;
$dom->loadHTML($food_truck_html);
$finder = new DomXPath($dom);

$class_company = 'com';
$class_day_of_the_week = 'dow';
$class_time_of_day = 'tod';
$class_location = 'loc';

$companies = $finder->query('//td[@class="' . $class_company . '"]/a/text()');
$company_urls = $finder->query('//td[@class="' . $class_company . '"]/a/@href');
$days_of_week = $finder->query('//td[@class="' . $class_day_of_the_week . '"]/text()');
$times_of_day = $finder->query('//td[@class="' . $class_time_of_day . '"]/text()');
$locations = $finder->query('//td[@class="' . $class_location . '"]/text()');

echo var_dump($locations->item(0)->nodeValue);
echo ' :: ';
echo $locations->length;

echo ' :: ';
echo date('l');

echo ' :: ';

$today_as_string = date('l');
$time_of_day_filter = 'Lunch';
$locations_filter = array();

$todays_lunch_food_trucks = array(
    'food_trucks' => array()
);

for ($i = 0; $i < $locations->length; $i++) {
    if ($days_of_week->item($i)->nodeValue == $today_as_string) {
        if ($times_of_day->item($i)->nodeValue == $time_of_day_filter) {
            echo '<p><a href="' . $company_urls->item($i)->nodeValue. '">' . $companies->item($i)->nodeValue . '</a></p>';

            array_push($todays_lunch_food_trucks['food_trucks'], array(
                'company' => $companies->item($i)->nodeValue,
                'company_url' => $company_urls->item($i)->nodeValue,
                'day_of_week' => $today_as_string,
                'time_of_day' => $time_of_day_filter,
                'location' => $locations->item($i)->nodeValue
            ));
        }
    }
}

echo json_encode($todays_lunch_food_trucks);
# echo $food_truck_html;
