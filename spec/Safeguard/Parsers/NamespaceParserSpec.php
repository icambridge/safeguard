<?php

namespace spec\Safeguard\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NamespaceParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\Parsers\NamespaceParser');
    }

//    function it_returns_namespace_object()
//    {
//
//    }
}
