Boston Food Truck Schedule API
==============================

An API for the Boston food truck schedule. The original food truck schedule from the City of Boston website is available here: http://www.cityofboston.gov/business/mobile/schedule-tabs.asp

This was written because I wanted to be able to filter food trucks by those within walking distance from downtown.


# PHP API usage
An example of PHP API usage is available in the `index.php` file.

Here's another example of what's needed and how to use the API:

    require_once('boston_food_trucks.php');

    $BostonFoodTrucks = new BostonFoodTrucks;
    
    $schedule = $BostonFoodTrucks->schedule(array(
        'trucks'       => array('CloverDEV'),
    	'days_of_week' => array(date('l')),
    	'times_of_day' => array('Lunch'),
    	'locations'    => array('City Hall Plaza, Fisher Park')
    ));

You can include multiple filter options for each of `trucks`, `days_of_week`, `times_of_day`, and `locations`. Filters are not required. You can make use of all filters, some filters, or none at all. Querying the schedule with no filters, for example, will return all trucks on all days at all time periods at all locations.


# HTTP API usage
The HTTP API uses the PHP API as a backend, providing a thin layer over it for you to get food trucks in JSON over HTTP. The API operates over GET.

Here's how to get all food trucks for Tuesday and Wednesday at lunch via curl:

    curl -d "days_of_week[]=Tuesday&days_of_week[]=Wednesday&times_of_day[]=Lunch" -G http://example.com/http.php

Here is the truncated output of that call:

    {
      "food_trucks": [
        {
          "company": "Roxy's Gourmet Grilled Cheese 1",
          "company_url": "http:\/\/www.roxysgrilledcheese.com",
          "day_of_week": "Tuesday",
          "time_of_day": "Lunch",
          "location": "Greenway (at High St #1)"
        },
        {
          "company": "Roxy's Gourmet Grilled Cheese 1",
          "company_url": "http:\/\/www.roxysgrilledcheese.com",
          "day_of_week": "Wednesday",
          "time_of_day": "Lunch",
          "location": "(4) Prudential, on Belvidere Street "
        },
        {
          "company": "Area Four",
          "company_url": "",
          "day_of_week": "Tuesday",
          "time_of_day": "Lunch",
          "location": "Greenway (at High St #1)"
        },
    
        ...
      ]
    }


# License
Boston Food Truck Schedule API is licensed under the MIT License. See the included LICENSE file.
