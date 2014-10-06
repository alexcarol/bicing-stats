<?php

namespace BicingStats\Domain\Repository;

use BicingStats\Domain\Model\Station\StationState;

interface CurrentStationStateRepository
{
    /**
     * @return StationState
     */
    public function get();

    public function set(StationState $stationState);
}
