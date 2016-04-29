<?php

namespace spec\Safeguard\Parsers;

use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Function_;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Parsers\FunctionParser;
use Safeguard\Parsers\ParamParser;
use Safeguard\Stmts\FunctionStmt;

class FunctionParserSpec extends ObjectBehavior
{
    function let(ParamParser $paramParser)
    {
        $this->beConstructedWith($paramParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FunctionParser::class);
    }

    function it_returns_method_objects_for_all_class_methods(ParamParser $paramParser)
    {
        $functionName = 'isReal';
        $functionStmt = new Function_($functionName);

        $param = new Param('container');
        $param->type = new Name('ContainerInterface');
        $functionStmt->params = [$param];

        $paramParser->processParams($functionStmt->params)->willReturn([]);

        $stmts = [
            $functionStmt
        ];

        $this->processFunctions($stmts)[0]->shouldBeAnInstanceOf(FunctionStmt::class);
    }
}
