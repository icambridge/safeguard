<?php

namespace spec\Safeguard\Stmts;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParamSpec extends ObjectBehavior
{
    const TYPE_HINT = 'TypeHint';

    const NAME = 'Name';

    function let()
    {
        $this->beConstructedWith(self::NAME, self::TYPE_HINT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\Stmts\Param');
    }

    function it_returns_type_hint()
    {
        $this->getTypeHint()->shouldBe(self::TYPE_HINT);
    }
}
