<?php

namespace BicingStats\Domain\Model;

use BicingStats\Domain\Model\Space\Address;
use BicingStats\Domain\Model\Space\Position;

class Station
{
    const STATUS_CODE_OPN = 'OPN';

    private $id;
    private $name;
    private $districtCode; // this is some internal district code in the bicing DB

    private $availableBikes;
    private $freeSlots;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var int[]
     */
    private $nearbyStationIds;

    private $statusCode;

    private function __construct()
    {

    }

    public static function constructFromApiData(array $apiData)
    {
        $instance = new static();
        $instance->hydrateFromApiData($apiData);

        return $instance;
    }

    private function hydrateFromApiData(array $apiData)
    {
        $this->id = $apiData['StationID'];
        $this->name = $apiData['StationName'];
        $this->districtCode = $apiData['DisctrictCode'];
        $this->availableBikes = $apiData['StationAvailableBikes'];
        $this->freeSlots = $apiData['StationFreeSlot'];
        $this->address = new Address(
            new Position(
                $apiData['AddressGmapsLongitude'],
                $apiData['AddressGmapsLatitude']
            ),
            $apiData['AddressZipCode'],
            $apiData['AddressStreet1'],
            $apiData['AddressNumber']
        );

        $this->nearbyStationIds = explode(',', $apiData['NearbyStationList']);
        $this->statusCode = $apiData['StationStatusCode'];
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
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
    public function getDistrictCode()
    {
        return $this->districtCode;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \int[]
     */
    public function getNearbyStationIds()
    {
        return $this->nearbyStationIds;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @var array
     */
    public function getData()
    {
        $data = array();

        foreach ($this as $property => $value) {
            $data[$property] = $value;
        }

        return $data;
    }
}
