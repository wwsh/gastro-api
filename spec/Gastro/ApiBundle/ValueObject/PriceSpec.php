<?php

namespace spec\WW\Gastro\ApiBundle\ValueObject;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WW\Gastro\ApiBundle\ValueObject\Price');
    }
}
