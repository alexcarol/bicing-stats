<?php

require_once 'vendor/autoload.php';

$application = new \BicingStats\BicingStatsApplication();

$command = new \AlexCarol\Component\Framework\Command('save_api_snapshot_to_db', array());

$application->handleCommand($command);
