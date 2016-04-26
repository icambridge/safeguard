<?php

namespace spec\Safeguard\Parsers;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Parsers\ClassParser;
use Safeguard\Stmts\NamespaceStmt;

class NamespaceParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\Parsers\NamespaceParser');
    }

    function let(ClassParser $classParser)
    {
        $this->beConstructedWith($classParser);
    }

    function it_returns_namespace_object(ClassParser $classParser)
    {

        $namespaceName = new Name('Test');
        $namespace = new Namespace_($namespaceName);

        $className = 'isReal';
        $class = new Class_($className);


        $namespace->stmts = [
            $class
        ];
        $stmts = [$namespace];
        $classParser->processClasses($namespace->stmts)->willReturn([]);

        $this->processNamespaces($stmts)[0]->shouldBeAnInstanceOf(NamespaceStmt::class);
    }
}
