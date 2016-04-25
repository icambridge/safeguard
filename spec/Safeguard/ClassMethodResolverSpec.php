<?php

namespace spec\Safeguard;

use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\Method;

class ClassMethodResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\ClassMethodResolver');
    }

    function it_returns_method_objects_for_all_class_methods()
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

        $this->processMethods($class)[0]->shouldBeAnInstanceOf(Method::class);
    }
}
