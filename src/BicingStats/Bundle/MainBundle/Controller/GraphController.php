<?php

namespace BicingStats\Bundle\MainBundle\Controller;

use BicingStats\Domain\Model\Station\Station;
use BicingStats\Domain\Model\Station\StationState;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/graph")
 */
class GraphController extends Controller
{
    /**
     * @Route("/stationstate/{stationId}", requirements={"stationId"="\d+"}, name="station_state_graph")
     * @Method("GET")
     * @Template()
     */
    public function chartAction($stationId)
    {
        $stationRepository = $this->getDoctrine()->getRepository('StationMapping:Station');
        /**
         * @var Station $station
         */
        $station = $stationRepository->findOneById($stationId);

        $startingTime = time() - 86400;

        $availableBikes = [];
        foreach ($station->getStationStates() as $stationState){
            $stationStateTime = $stationState->getTime()->getTimestamp();
            if ($stationStateTime >= $startingTime) { // this needs to be optimized
                $relativeTimeOfTheDayInHours = ($stationStateTime - $startingTime) / 3600; // this is not really the relative time of the day, need to calculate properly
                $availableBikes[] = [$relativeTimeOfTheDayInHours, $stationState->getAvailableBikes()];
            }
        };

        $availableBikes[] = [(time() - $startingTime)/3600, $station->getCurrentStationState()->getAvailableBikes()];

        $series = array(
            array(
                "name" => sprintf('Available bikes for %d', $stationId),
                'data' => $availableBikes,
            ),
        );

        $chart = new Highchart();
        $chart->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $chart->title->text('Chart Title');
        $chart->xAxis->title(array('text'  => "Horizontal axis title"));
        $chart->yAxis->title(array('text'  => "Vertical axis title"));
        $chart->series($series);

        return array('chart' => $chart);
    }
}
