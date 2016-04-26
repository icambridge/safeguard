<?php

namespace spec\Safeguard\Parsers;

use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Parsers\ClassMethodParser;
use Safeguard\Parsers\ClassParser;
use Safeguard\Stmts\ClassStmt;

class ClassParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ClassParser::class);
    }

    function let(ClassMethodParser $classMethodParser)
    {
        $this->beConstructedWith($classMethodParser);
    }

    function it_returns_class_stmts(ClassMethodParser $classMethodParser)
    {
        $className = 'Test';
        $class = new Class_($className);

        $methodName = 'isReal';
        $methodStmt = new ClassMethod($methodName);

        $param = new Param('container');
        $param->type = new Name('ContainerInterface');
        $methodStmt->params = [$param];

        $class->stmts = [
            $methodStmt
        ];
        $stmts = [$class];
        $classMethodParser->processMethods($class)->willReturn([]);
        $this->processClasses($stmts)[0]->shouldBeAnInstanceOf(ClassStmt::class);
    }
}
