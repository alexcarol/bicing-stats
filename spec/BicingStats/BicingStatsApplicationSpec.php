<?php

namespace spec\BicingStats;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BicingStatsApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BicingStats\BicingStatsApplication');
    }
}
