<?php

namespace spec\Safeguard\Stmts;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\ClassStmt;

class NamespaceStmtSpec extends ObjectBehavior
{
    const TYPE_HINT = 'TYPE_HINT';

    function let(ClassStmt $stmt)
    {
        $this->beConstructedWith("namespace", [$stmt]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\Stmts\NamespaceStmt');
    }

    function it_returns_type_hints(ClassStmt $stmt)
    {
        $stmt->getTypeHints()->willReturn([self::TYPE_HINT]);
        $this->getTypeHints()->shouldBe([self::TYPE_HINT]);
    }
}
