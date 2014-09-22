<?php

namespace BicingStats\Domain\Model\Station;

use BicingStats\Domain\Model\Space\Address;
use BicingStats\Domain\Model\Space\Position;

class Station
{
    private $id;
    private $name;
    private $districtCode; // this is some internal district code in the bicing DB

    /**
     * @var int[]
     */
    private $nearbyStationIds;

    private $addressNumber;

    private $longitude;

    private $latitude;

    private $addressStreet;

    private $addressZipCode;

    private function __construct()
    {

    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return new Address(
            new Position($this->longitude, $this->latitude),
            $this->addressZipCode,
            $this->addressStreet,
            $this->addressNumber
        );
    }

    private function setAddress(Address $address)
    {
        $this->addressNumber = $address->getNumber();
        $this->longitude = $address->getPosition()->getLongitude();
        $this->latitude = $address->getPosition()->getLatitude();
        $this->addressStreet = $address->getStreet();
        $this->addressZipCode = $address->getZipCode();
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
        $this->setAddress(new Address(
            new Position(
                $apiData['AddressGmapsLongitude'],
                $apiData['AddressGmapsLatitude']
            ),
            $apiData['AddressZipCode'],
            $apiData['AddressStreet1'],
            $apiData['AddressNumber']
        ));

        $this->nearbyStationIds = explode(',', $apiData['NearbyStationList']);
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
     * @var array
     */
    public function toArray()
    {
        $data = array();

        foreach ($this as $property => $value) {
            $data[$property] = $value;
        }

        return $data;
    }
}
