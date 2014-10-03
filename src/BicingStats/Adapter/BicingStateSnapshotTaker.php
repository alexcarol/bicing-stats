<?php

namespace BicingStats\Adapter;

use BicingStats\Bundle\MainBundle\Repository\StationStateRepository;
use BicingStats\Domain\Model\Station\Station;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

final class BicingStateSnapshotTaker
{
    /**
     * @var BicingApi
     */
    private $bicingApi;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var StationStateRepository
     */
    private $stationStateRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        BicingApi $bicingApi,
        EntityManager $entityManager,
        StationStateRepository $stationStateRepository,
        LoggerInterface $logger
    ) {
        $this->bicingApi = $bicingApi;
        $this->entityManager = $entityManager;
        $this->stationStateRepository = $stationStateRepository;
        $this->logger = $logger;
    }

    public function take()
    {
        $stationStates = $this->bicingApi->getSnapshot();

        $unsavedCollections = 0;
        foreach ($stationStates as $stationState) {
            /** @var Station $station */
            $station = $this->stationStateRepository->findOneById($stationState->getStation()->getId());

            if ($station) {
                $currentStationState = $station->getCurrentStationState();
                if (!$currentStationState->isEqual($stationState)) {
                    /*
                     * we should try to find a way to know if there are changes to the "Station" DB,
                     * maybe with a database listener?
                     */
                    $stationState->setStation($station);
                    $this->entityManager->persist($stationState);
                } else {
                    ++$unsavedCollections;
                }

            } else {
                $this->entityManager->persist($stationState->getStation());
                $this->entityManager->persist($stationState);
            }

        }

        $this->entityManager->flush();

        $this->logger->info(sprintf('Skipped saving of %d station states', $unsavedCollections));
    }
}
