<?php

use Buzz\Browser;

require_once '../vendor/autoload.php';

$bicingApi = new \BicingStats\Adapter\BicingApi(new Browser());

var_dump(reset($bicingApi->getAllStations()));
