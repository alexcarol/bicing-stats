<?php

namespace BicingStats\Domain\Repository;

use AlexCarol\Component\Storage\Storage;
use BicingStats\Domain\Model\Station\StationState;

class StationRepository
{
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function save(StationState $stationState)
    {
        $this->storage->save($stationState);
    }
}
