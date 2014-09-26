<?php

namespace BicingStats\Bundle\MainBundle\Controller;

use BicingStats\Domain\Model\Station\Station;
use BicingStats\Domain\Model\Station\StationState;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/graph")
 */
class GraphController extends Controller
{
    /**
     * @Route("/stationstate/{id}")
     * @Template()
     */
    public function chartAction($id)
    {
        $stationRepository = $this->getDoctrine()->getRepository('StationMapping:Station');
        /**
         * @var Station $station
         */
        $station = $stationRepository->findOneById($id);


//        $availableBikes = array_map(function (StationState $stationState) {
//                return $stationState->getAvailableBikes();
//            }, $station->getStationStates());

        $availableBikes = array(5);
        //var_dump($availableBikes);

        $series = array(
            array("name" => "Data Serie Name",    "data" => $availableBikes),
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
