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
     *     'StationID' =>
    string(1) "1"
    'StationName' =>
    string(36) "01 - C/ GRAN VIA CORTS CATALANES 760"
    'DisctrictCode' =>
    string(1) "2"
    'AddressGmapsLongitude' =>
    string(20) "2.180042000000000000"
    'AddressGmapsLatitude' =>
    string(20) "41.39795200000000000"
    'StationAvailableBikes' =>
    string(2) "17"
    'StationFreeSlot' =>
    string(1) "2"
    'AddressZipCode' =>
    string(5) "08013"
    'AddressStreet1' =>
    string(24) "Gran Via Corts Catalanes"
    'AddressNumber' =>
    string(3) "760"
    'NearbyStationList' =>
    string(14) "24,369,387,426"
    'StationStatusCode' =>
    string(3) "OPN"
     */


}
