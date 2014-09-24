<?php

namespace BicingStats\Bundle\MainBundle\Controller;

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

        return JsonResponse::create($data);
    }
}
