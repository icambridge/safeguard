<?php

namespace spec\Safeguard\Stmts;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\ClassStmt;
use Safeguard\Stmts\Method;

class ClassStmtSpec extends ObjectBehavior
{
    const CLASS_NAME = 'file';

    const TYPE = 'Type';

    function let()
    {
        $this->beConstructedWith(self::CLASS_NAME, []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ClassStmt::class);
    }

    function it_returns_param_types_for_all_methods(Method $classMethod)
    {
        $classMethod->getTypeHints()->willReturn([self::TYPE]);
        $this->beConstructedWith(self::CLASS_NAME, [$classMethod]);
        $this->getTypeHints()->shouldBe([self::TYPE]);
    }
}
