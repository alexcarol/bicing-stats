<?php

namespace BicingStats\Bundle\MainBundle\Command;

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

        foreach ($stationStates as $stationState) {
            $station = $stationRepository->findOneById($stationState->getStation()->getId());
            /*
             * we should try to find a way to know if there are changes to the "Station" DB,
             * maybe with a database listener?
             */
            if (!$station) {
                $entityManager->persist($stationState->getStation());
            } else {
                // look for differences
                $stationState->setStation($station);
            }
            $entityManager->persist($stationState);
        }

        $entityManager->flush();

        $output->writeln('Saved successfully!');
    }
}
