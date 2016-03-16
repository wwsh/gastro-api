<?php

namespace spec\WW\Gastro\ApiBundle\Types;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WW\Gastro\ApiBundle\Types\PriceType');
    }
}
