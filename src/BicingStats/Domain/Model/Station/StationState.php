<?php

namespace BicingStats\Domain\Model\Station;

class StationState
{
    const STATUS_CODE_OPN = 'OPN';

    private $id; // unused, but needed for doctrine...

    /**
     * @var Station
     */
    private $station;

    private $statusCode;
    private $availableBikes;

    private $freeSlots;

    /**
     * @var \DateTime
     */
    private $time;

    public function __construct(Station $station, $availableBikes, $freeSlots, $statusCode, \DateTime $time)
    {
        $this->station = $station;
        $this->availableBikes = $availableBikes;
        $this->freeSlots = $freeSlots;
        $this->statusCode = $statusCode;
        $this->time = $time;
    }

    public static function constructFromApiData(array $apiData, \DateTime $time)
    {
        $station = Station::constructFromApiData($apiData);
        $availableBikes = $apiData['StationAvailableBikes'];
        $freeSlots = $apiData['StationFreeSlot'];
        $statusCode = $apiData['StationStatusCode'];
        $instance = new static($station, $availableBikes, $freeSlots, $statusCode, $time);

        return $instance;
    }

    public function getStation()
    {
        return $this->station;
    }

    public function setStation(Station $station)
    {
        $this->station = $station;
    }
}
