<?php

namespace BicingStats\Domain\Model\Space;

class Address
{
    /**
     * @var Position
     */
    private $position;

    private $zipCode;

    private $street;

    private $number;

    public function __construct(Position $position, $zipCode, $street, $number)
    {
        $this->position = $position;
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
}
