<?php

namespace BicingStats\Domain\Model\Space;

class Position
{
    /**
     * @var int
     */
    private $longitude;

    /**
     * @var int
     */
    private $latitude;

    public function __construct($longitude, $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /**
     * @return int
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}
