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
        $this->getContainer()->get('bicing_stats.adapter.bicing_state_snapshot_taker');

        $output->writeln('Saved successfully!');
    }
}
