<?php
require_once 'vendor/autoload.php';

$client = new Google\Client();
$client->setApplicationName("Client_Library_Examples");
$client->setDeveloperKey("AIzaSyBM7a2OzN8yDoBJhJNx6Hl6Qh7ODjpRqrk");

$service = new Google\Service\Books($client);
$query = 'Orthodox';
$optParams = [
  'filter' => 'free-ebooks',
];
$results = $service->volumes->listVolumes($query, $optParams);

foreach ($results->getItems() as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}

?>
