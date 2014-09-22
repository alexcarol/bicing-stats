<?php

namespace BicingStats\Adapter;

use BicingStats\Domain\Model\Collection\StationCollection;
use BicingStats\Domain\Model\Station\Station;
use BicingStats\Domain\Model\Station\StationState;
use Buzz\Browser;

class BicingApi
{
    const BICING_URL = 'https://www.bicing.cat/ca/formmap/getJsonObject';

    private $browser;

    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    /**
     * @return StationState[]
     */
    public function getSnapshot()
    {
        $response = $this->browser->post(self::BICING_URL);

        $stations = $this->parse($response->getContent());

        $time = new \DateTime();

        return array_map(
            function($element) use ($time) {
                return StationState::constructFromApiData($element, $time);
            },
            $stations
        );
    }

    private function parse($rawContent)
    {
        $content = json_decode($rawContent, true);


        return $this->getData($content);
    }

    private function getData(array $content)
    {
        foreach ($content as $elem) {
            if (isset($elem['data'])) {
                return json_decode($elem['data'], true);
            }
        }

        return [];
    }
}
