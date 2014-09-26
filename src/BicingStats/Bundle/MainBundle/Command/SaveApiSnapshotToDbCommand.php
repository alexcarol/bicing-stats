<?php

namespace BicingStats\Bundle\MainBundle\Command;

use BicingStats\Domain\Model\Station\Station;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveApiSnapshotToDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bicing-stats:take-snapshot')
            ->setDescription('Saves Bicing Api snasphot to the db');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bicingApi = $this->getContainer()->get('bicing_stats.bicing_api');
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $stationRepository = $entityManager->getRepository('StationMapping:Station');

        $stationStates = $bicingApi->getSnapshot();

        $unsavedCollections = 0;
        foreach ($stationStates as $stationState) {
            /** @var Station $station */
            $station = $stationRepository->findOneById($stationState->getStation()->getId());

            if ($station) {
                $currentStationState = $station->getCurrentStationState();
                if (!$currentStationState->isEqual($stationState)) {
                    /*
                     * we should try to find a way to know if there are changes to the "Station" DB,
                     * maybe with a database listener?
                     */
                    $stationState->setStation($station);
                    $entityManager->persist($stationState);
                } else {
                    ++$unsavedCollections;
                }

            } else {
                $entityManager->persist($stationState->getStation());
                $entityManager->persist($stationState);
            }

        }

        $entityManager->flush();

        $this->getContainer()->get('logger')->info(sprintf('Skipped saving of %d station states', $unsavedCollections));
        $output->writeln('Saved successfully!');
    }
}
