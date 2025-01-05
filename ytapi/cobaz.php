<?php


error_reporting(1);
set_include_path(__DIR__.'google-api-php-client/src/');

//require_once('Google/autoload.php');

require_once 'Client.php';
echo "ssssss";
require_once 'Service/YouTube.php';

session_start();

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setAccessType("offline");
$client->setScopes(array('https://www.googleapis.com/auth/youtube.force-ssl', 'https://www.googleapis.com/auth/youtubepartner-channel-audit', 'https://www.googleapis.com/auth/youtube', 'https://www.googleapis.com/auth/youtube.readonly', 'https://www.googleapis.com/auth/yt-analytics.readonly', 'https://www.googleapis.com/auth/yt-analytics-monetary.readonly','https://www.googleapis.com/auth/youtubepartner'));
$client->setDeveloperKey($key);

$analytics = new Google_Service_YouTubeAnalytics($client);

$ids = 'channel==' . $channel_url . '';
$end_date = date("Y-m-d"); 
$start_date = date('Y-m-d', strtotime("-30 days"));
$optparams = array(
'dimensions' => 'day',
);

$metric = 'views';

try{

$api = $analytics->reports->query($ids, $start_date, $end_date, $metric, $optparams);

foreach ($api->rows as $r) {
    $date = $r[0];
    $views = $r[1];

$stmt = $db->prepare("INSERT INTO test (date,views,channel_url) VALUES (:date,:views,:channel_url)");
$stmt->execute([':date' => $date, ':views' => $views, ':channel_url' => $channel_url]);
}
}catch (Google_Service_Exception $e) {
    echo sprintf('<p>A service error occurred: <code>%s</code></p>',
    htmlspecialchars($e->getMessage()));
}
?>
