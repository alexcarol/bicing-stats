<?php

namespace BicingStats\Bundle\MainBundle\Controller;

use BicingStats\Bundle\MainBundle\Repository\StationStateRepository;
use BicingStats\Domain\Model\Station\Station;
use BicingStats\Domain\Model\Station\StationState;
use Ivory\GoogleMapBundle\Entity\Marker;
use Ivory\GoogleMapBundle\Model\Overlays\InfoWindowBuilder;
use Ivory\GoogleMapBundle\Model\Overlays\MarkerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class MapController extends Controller
{
    /**
     * @Route("/map")
     * @Method("GET")
     * @Template()
     */
    public function currentStationAction()
    {
        $repository = $this->getDoctrine()->getRepository('StationMapping:Station');
        /** @var Station[] $stations */
        $stations = $repository->findAll();

        $mapBuilder = $this->get('ivory_google_map.map.builder');

        $map = $mapBuilder->build();
        $map->setAutoZoom(true);

        $map->setCenter(41.4150506, 2.1793174);
        $map->setStylesheetOptions(
            array(
                'width' => '100%',
                'height' => '100%',
                'position' => 'absolute',
                'left' => 0,
            )
        );

        $markerBuilder = $this->get('ivory_google_map.marker.builder');

        $infoWindowBuilder = $this->get('ivory_google_map.info_window.builder');

        foreach ($stations as $station) {
            $marker = $this->getMarker($markerBuilder, $station->getCurrentStationState(), $infoWindowBuilder);

            $map->addMarker($marker);
        }

        $mapHelper = $this->get('ivory_google_map.helper.map');

        return array('map' => $mapHelper->render($map));
    }

    /**
     * @param $markerBuilder
     * @param $stationState
     * @param $infoWindowBuilder
     *
     * @return Marker
     */
    private function getMarker(
        MarkerBuilder $markerBuilder,
        StationState $stationState,
        InfoWindowBuilder $infoWindowBuilder
    ) {
        $marker = $markerBuilder->build();
        $station = $stationState->getStation();
        $marker->setPosition(
            $station->getLatitude(),
            $station->getLongitude()
        );
        $infoWindow = $infoWindowBuilder->build();
        $infoWindow->setContent(
            sprintf(
                'Bikes remaining : %d <br />Free spaces: %d',
                $stationState->getAvailableBikes(),
                $stationState->getFreeSlots()
            )
        );

        $marker->setInfoWindow($infoWindow);

        return $marker;
    }
}
