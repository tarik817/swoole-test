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
	$stmt = $this->db->prepare("INSERT INTO temperature (location, date, temperature) VALUES (:location, :date, :temperature)");
	$stmt->bindParam(':location', $location);
	$stmt->bindParam(':date', $date);
	$stmt->bindParam(':temperature', $temperature);

	$location = $request->getParam('location');
	$date = date('Y-m-d H:i:s');
	$temperature = $request->getParam('temperature');;
	$stmt->execute();

	return $response;
});