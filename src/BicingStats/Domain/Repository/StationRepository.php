<?php

namespace BicingStats\Domain\Repository;

use AlexCarol\Component\Storage\Storage;
use BicingStats\Domain\Model\Collection\StationCollection;

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

    public function saveCollection(StationCollection $stationCollection)
    {
        $this->storage->save($stationCollection->toArray());
    }
}
