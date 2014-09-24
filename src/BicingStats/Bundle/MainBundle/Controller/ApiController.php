<?php

namespace BicingStats\Bundle\MainBundle\Controller;

use BicingStats\Domain\Model\Station\StationState;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiController extends FOSRestController
{
    /**
     * @Route("/stationstate")
     */
    public function stationStateAction()
    {
        $repository = $this->getDoctrine()->getRepository('StationMapping:StationState');
        $data = $repository->findLastSnapshot();

        return JsonResponse::create(
            array_map(
                function (StationState $stationState) {
                    $station = $stationState->getStation();

                    return array(
                        'name' => $station->getName(),
                        'statusCode' => $stationState->getStatusCode(),
                        'availableBikes' => $stationState->getAvailableBikes(),
                        'freeSlots' => $stationState->getFreeSlots(),
                        'latitude' => $station->getLatitude(),
                        'longitude' => $station->getLongitude(),
                    );
                },
                $data
            )
        );
    }
}
