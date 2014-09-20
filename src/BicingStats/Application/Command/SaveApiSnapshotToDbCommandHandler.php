<?php

namespace BicingStats\Application\Command;

use AlexCarol\Component\Framework\Command;
use AlexCarol\Component\Framework\CommandHandler;
use BicingStats\Adapter\BicingApi;
use BicingStats\Domain\Repository\StationRepository;

final class SaveApiSnapshotToDbCommandHandler implements CommandHandler
{

    /**
     * @var StationRepository
     */
    private $stationRepository;

    /**
     * @var BicingApi
     */
    private $bicingApi;

    public function __construct(
        BicingApi $bicingApi,
        StationRepository $stationRepository
    ) {
        $this->bicingApi = $bicingApi;
        $this->stationRepository = $stationRepository;
    }

    public function handle(Command $command)
    {
        $stationCollection = $this->bicingApi->getSnapshot();

        $this->stationRepository->saveCollection($stationCollection);
    }
}
