<?php

namespace BicingStats\Bundle\MainBundle\Controller;

use Ivory\GoogleMap\Overlays\InfoWindow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

final class MapController extends Controller
{
    /**
     * @Route("/map")
     * @return Response
     */
    public function currentStationAction()
    {
        $repository = $this->getDoctrine()->getRepository('StationMapping:StationState');
        $data = $repository->findLastSnapshot();

        $mapBuilder = $this->get('ivory_google_map.map.builder');

        $map = $mapBuilder->build();
        $map->setAutoZoom(true);

        $map->setCenter(41.4150506, 2.1793174);

        $markerBuilder = $this->get('ivory_google_map.marker.builder');

        $infoWindowBuilder = $this->get('ivory_google_map.info_window.builder');

        foreach ($data as $element) {
            $latitude = $element['latitude'];
            $longitude = $element['longitude'];

            $marker = $markerBuilder->build();
            $marker->setPosition($latitude, $longitude);
            $infoWindow = $infoWindowBuilder->build();
            $infoWindow->setContent(
                sprintf(
                    'Bikes remaining : %d
Free spaces: %d',
                    $element['availableBikes'],
                    $element['freeSlots']
                )
            );

            $marker->setInfoWindow($infoWindow);

            $map->addMarker($marker);

        }

        $mapHelper = $this->get('ivory_google_map.helper.map');

        return new Response($mapHelper->render($map));
    }
}
