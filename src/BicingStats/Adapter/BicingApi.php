<?php

namespace BicingStats\Adapter;

use BicingStats\Domain\Model\Station;
use Buzz\Browser;

class BicingApi
{
    const BICING_URL = 'https://www.bicing.cat/ca/formmap/getJsonObject';

    private $browser;

    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    public function getAllStations()
    {
        $response = $this->browser->post(self::BICING_URL);

        $stations = $this->parse($response->getContent());

        return array_map(
            function($element) {
                return Station::constructFromApiData($element);
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