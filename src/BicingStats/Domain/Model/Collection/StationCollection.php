<?php

namespace BicingStats\Domain\Model\Collection;

use BicingStats\Domain\Model\Station;

class StationCollection
{
    /**
     * @var Station[]
     */
    private $stations;

    private $timestamp;

    public function __construct(array $stations, $timestamp)
    {
        $this->stations = $stations;
        $this->timestamp = $timestamp;
    }

    /**
     * @return Station[]
     */
    public function getStations()
    {
        return $this->stations;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function toArray()
    {
        return array(
            'timestamp' => $this->timestamp,
            'stations' => array_map(
                function(Station $station) {
                    return $station->toArray();
                },
                $this->stations
            )
        );
    }
}

