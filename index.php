<?php

error_reporting(0);

require_once('boston_food_trucks.php');

$BostonFoodTrucks = new BostonFoodTrucks;
$schedule = $BostonFoodTrucks->schedule(array(
	'days_of_week' => array(date('l')),
	'times_of_day' => array('Lunch'),
	'locations'    => $BostonFoodTrucks->locations_downtown
));

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Downtown Boston Food Truck Schedule</title>
	<meta name="description" content="">

	<meta name="viewport" content="width=device-width">
	
	
	<link rel="stylesheet" href="assets/fonts/gandhi-sans-fontfacekit/stylesheet.css">
	<link rel="stylesheet" href="assets/fonts/Hominis-fontfacekit/stylesheet.css">
	
	<style>
		body {
			background-color: #f5f5f5;
			font-family: GandhiSansRegular, Helvetica, sans-serif;
		}
		
		h1, h2 {
			font: 3.5em/1.1em HominisNormal, serif;
			text-align: center;
		}
		
		h2 { font-size: 2em; margin-top: -0.6em; }
		
		
		div[role="main"] {
			font-size: 1.3em;
		}
		
		table {
			margin: 0 auto;
			position: relative;
			left: 1em;
		}
		
		table tr td { padding: 0.3em; }
		
		table tr td.company { text-align: right; }
		
		
		footer {
			text-align: center;
			margin: 1.2em 0 0.8em;
		}
		
		footer hr {
			border: none;
			background-color: #ccc;
			height: 1px;
			width: 25%;
			margin: 0.7em auto;
		}
		
		
		a { color: #1A84B3; }
		a:hover { color: #156A90; }
		a:active { color: #10506D; }
		
		
		@media only screen and (max-width: 960px) {
			table { left: 0; }
			
			table tr td.company {
				display: inline;
				text-align: left;
				font-size: 1.2em;
			}
			
			table tr td.location {
				display: block;
				font-size: 0.8em;
				margin-bottom: 0.7em;
			}
		}
		
		@media only screen and (max-width: 488px) {
			h1 { font-size: 2em; }
			h2 { font-size: 1em; }
		}
	</style>
</head>
<body>
	<header>
		<h1>Downtown Boston Food Truck Schedule</h1>
		<h2>Today at Lunch</h2>
	</header>
	
	<div role="main">
		<table id="trucks">
			<?php foreach ($schedule['food_trucks'] as $truck): ?>
				<tr>
					<td class="company">
						<?php if ($truck['company_url']): ?>
							<a href="<?= $truck['company_url'] ?>"><?= $truck['company'] ?></a>
						<?php else: ?>
							<?= $truck['company'] ?>
						<?php endif; ?>
					</td>
					
					<td class="location">
						<?= $truck['location'] ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	
	<footer>
		<hr />
		
		Created by <a href="http://teddywing.com">Teddy Wing</a> | <a href="https://github.com/teddywing/Boston-Food-Truck-Schedule-API">Boston Food Truck Schedule API</a>
	</footer>
</body>
</html>