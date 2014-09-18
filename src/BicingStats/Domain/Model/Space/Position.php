<?php

namespace BicingStats\Domain\Model\Space;

class Position
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }
}
