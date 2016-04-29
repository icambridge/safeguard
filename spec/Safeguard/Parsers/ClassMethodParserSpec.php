<?php

namespace spec\Safeguard\Parsers;

use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Parsers\ClassMethodParser;
use Safeguard\Parsers\ParamParser;
use Safeguard\Stmts\Method;

class ClassMethodParserSpec extends ObjectBehavior
{
    function let(ParamParser $paramParser)
    {
        $this->beConstructedWith($paramParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ClassMethodParser::class);
    }

    function it_returns_method_objects_for_all_class_methods(ParamParser $paramParser)
    {
        $className = 'Test';
        $class = new Class_($className);

        $methodName = 'isReal';
        $methodStmt = new ClassMethod($methodName);

        $param = new Param('container');
        $param->type = new Name('ContainerInterface');
        $methodStmt->params = [$param];

        $paramParser->processParams($methodStmt->params)->willReturn([]);

        $class->stmts = [
            $methodStmt
        ];

        $this->processMethods($class)[0]->shouldBeAnInstanceOf(Method::class);
    }
}
