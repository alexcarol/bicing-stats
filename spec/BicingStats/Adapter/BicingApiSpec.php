<?php

namespace spec\BicingStats\Adapter;

use BicingStats\Adapter\BicingApi;
use Buzz\Browser;
use Buzz\Message\MessageInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin BicingApi
 */
class BicingApiSpec extends ObjectBehavior
{

    /**
     * @var Browser
     */
    private $browser;

    function let(Browser $browser)
    {
        $this->browser = $browser;

        $this->beConstructedWith($browser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BicingStats\Adapter\BicingApi');
    }

    function it_parses_properly(MessageInterface $messageInterface)
    {
        $messageInterface->getContent()->willReturn(
            <<<JSON
[{
	"command": "settings",
	"settings": {
		"basePath": "\/",
		"pathPrefix": "ca\/",
		"ajaxPageState": {
			"theme": "bicing",
			"theme_token": "NngnJfQN6FaHhoz6tHcHih5kFdxcm0b7EeWdAgd492M"
		}
	},
	"merge": true
}, {
	"command": "insert",
	"method": null,
	"selector": null,
	"data": "[{\u0022StationID\u0022:\u00221\u0022,\u0022StationName\u0022:\u002201 - C\\\/ GRAN VIA CORTS CATALANES 760\u0022,\u0022DisctrictCode\u0022:\u00222\u0022,\u0022AddressGmapsLongitude\u0022:\u00222.180042000000000000\u0022,\u0022AddressGmapsLatitude\u0022:\u002241.39795200000000000\u0022,\u0022StationAvailableBikes\u0022:\u002217\u0022,\u0022StationFreeSlot\u0022:\u00222\u0022,\u0022AddressZipCode\u0022:\u002208013\u0022,\u0022AddressStreet1\u0022:\u0022Gran Via Corts Catalanes\u0022,\u0022AddressNumber\u0022:\u0022760\u0022,\u0022NearbyStationList\u0022:\u002224,369,387,426\u0022,\u0022StationStatusCode\u0022:\u0022OPN\u0022}]",
	"settings": null
}, {
	"command": "insert",
	"method": "prepend",
	"selector": null,
	"data": "",
	"settings": null
}]
JSON
    );

        $this->browser->post(BicingApi::BICING_URL)->willReturn($messageInterface);

        $stationType = 'BicingStats\Domain\Model\Station';
        $this->getAllStations()->shouldHaveCount(1);;
    }
}
