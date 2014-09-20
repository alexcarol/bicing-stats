<?php

use Buzz\Browser;

require_once 'vendor/autoload.php';

$application = new \BicingStats\BicingStatsApplication();

$bicingApi = $application->getService('bicing_stats.bicing_api');
$stations = $bicingApi->getAllStations();
var_dump(reset($stations));
