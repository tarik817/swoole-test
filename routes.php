<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, array $args) {
	$sql = "SELECT location, date, temperature FROM temperature ORDER BY date DESC LIMIT 25";
	$stmt = $this->db->prepare($sql);
	$stmt->execute();
	$results = $stmt->fetchAll();
	$coordinates = [];
	$labels = [];
	foreach ($results as $row) {
		$coordinates[] = $row['temperature'];
		$labels[] = $row['date'];
	}
	$coordinates = array_reverse($coordinates);
	$labels = array_reverse($labels);

    return $this->view->render($response, 'index.php', compact('results', 'coordinates', 'labels'));
});

$app->post('/new', function (Request $request, Response $response, array $args) {
	$locationParam = $request->getParsedBodyParam('location');
	$temperatureParam = $request->getParsedBodyParam('temperature');
	if (!$locationParam || !$temperatureParam) {
		return $response->withStatus(400, 'Correct params was not supplied.');
	}

	$stmt = $this->db->prepare("INSERT INTO temperature (location, date, temperature) VALUES (:location, :date, :temperature)");
	$stmt->bindParam(':location', $location);
	$stmt->bindParam(':date', $date);
	$stmt->bindParam(':temperature', $temperature);

	$location = $locationParam;
	$date = date('Y-m-d H:i:s');
	$temperature = $temperatureParam;
	$stmt->execute();

	return $response;
});