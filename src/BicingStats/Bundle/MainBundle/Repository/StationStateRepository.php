<?php

namespace BicingStats\Bundle\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

final class StationStateRepository extends EntityRepository
{
    public function findLastSnapshot()
    {
        $time = $this->getMaxTime();

        $query = $this
            ->createQueryBuilder('s')
            ->select('station.name, s.statusCode, s.availableBikes, s.freeSlots, station.latitude, station.longitude')
            ->from('StationMapping:Station', 'station')
            ->where('s.time = :time')
            ->andWhere('station.id = s.station')
            ->setParameter(':time', $time)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return \DateTime
     */
    private function getMaxTime()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            <<<QUERY
            SELECT s.time
FROM StationMapping:StationState as s
ORDER BY s.time DESC
QUERY
        );
        $query->setMaxResults(1);

        $result = $query->getResult();
        /**
         * @var $time \DateTime
         */
        $time = reset($result)['time'];

        return $time;
    }
}
