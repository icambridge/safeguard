<?php

namespace spec\Safeguard\Parsers;

use PhpParser\Node\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Parsers\ParamParser;
use Safeguard\Stmts\Param;
use PhpParser\Node\Param as ParamNode;

class ParamParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParamParser::class);
    }

    function it_returns_params()
    {
        $param = new ParamNode('container');
        $param->type = new Name('ContainerInterface');
        $params = [$param];

        $this->processParams($params)[0]->shouldBeAnInstanceOf(Param::class);
    }
}
