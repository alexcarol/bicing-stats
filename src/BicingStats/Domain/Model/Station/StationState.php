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

    /**
     * @return mixed
     */
    public function getAvailableBikes()
    {
        return $this->availableBikes;
    }

    /**
     * @return mixed
     */
    public function getFreeSlots()
    {
        return $this->freeSlots;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    public function isEqual(StationState $stationState)
    {
        if ($stationState->availableBikes != $this->availableBikes) {
            return false;
        }

        if ($stationState->freeSlots != $this->freeSlots) {
            return false;
        }

        if ($stationState->statusCode != $this->statusCode) {
            return false;
        }

        if ($stationState->station->getId() != $this->station->getId()) {
            return false;
        }

        return true;
    }
}
