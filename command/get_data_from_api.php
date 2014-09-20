<?php

use Buzz\Browser;

require_once 'vendor/autoload.php';

$bicingApi = new \BicingStats\Adapter\BicingApi(new Browser());

$stations = $bicingApi->getAllStations();
var_dump(reset($stations));
