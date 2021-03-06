<?php

namespace spec\Safeguard\Stmts;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\Param;

class MethodSpec extends ObjectBehavior
{
    const TYPE_HINT = 'TYPE_HINT';

    function let(Param $param)
    {
        $this->beConstructedWith('__construct', [$param]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\Stmts\Method');
    }

    function it_returns_type_hints(Param $param)
    {
        $param->getTypeHint()->willReturn(self::TYPE_HINT);
        $this->getTypeHints()->shouldBe([self::TYPE_HINT]);
    }
}
