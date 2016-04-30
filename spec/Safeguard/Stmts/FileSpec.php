<?php

namespace spec\Safeguard\Stmts;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\AliasResolver;
use Safeguard\Stmts\ClassStmt;
use Safeguard\Stmts\File;
use Safeguard\Stmts\FunctionStmt;
use Safeguard\Stmts\NamespaceStmt;

class FileSpec extends ObjectBehavior
{
    const FILENAME = "filename";

    function it_is_initializable()
    {
        $this->shouldHaveType(File::class);
    }

    function let(AliasResolver $aliasResolver)
    {
        $this->beConstructedWith(self::FILENAME, $aliasResolver, [], [], []);
    }

    function it_returns_true_when_class_is_an_alias(AliasResolver $aliasResolver)
    {
        $alias = 'Roger';
        $className = 'Rabbit\Rabbit';
        $aliasResolver->isAliasFor($alias, $className)->willReturn(true);;
        $this->isClassAnAliasFor($alias, $className)->shouldBe(true);
    }

    function it_returns_count_of_classes_in_a_file(AliasResolver $aliasResolver)
    {
        $classes = [1,2];
        $this->beConstructedWith(self::FILENAME, $aliasResolver, $classes, [], []);
        $this->getNumberOfClasses()->shouldBe(2);
    }

    function it_returns_count_of_namespaces_in_a_file(AliasResolver $aliasResolver)
    {
        $namespaces = [1,2];
        $this->beConstructedWith(self::FILENAME, $aliasResolver, [], $namespaces, []);
        $this->getNumberOfNamespaces()->shouldBe(2);
    }

    function it_returns_count_of_functions_in_a_file(AliasResolver $aliasResolver)
    {
        $functions = [1,2];
        $this->beConstructedWith(self::FILENAME, $aliasResolver, [], [], $functions);
        $this->getNumberOfFunctions()->shouldBe(2);
    }

    function it_returns_param_types(AliasResolver $aliasResolver, ClassStmt $classStmt, NamespaceStmt $namespaceStmt, FunctionStmt $functionStmt)
    {
        $this->beConstructedWith(self::FILENAME, $aliasResolver, [$classStmt], [$namespaceStmt], [$functionStmt]);
        $classStmt->getTypeHints()->willReturn(['Type']);
        $functionStmt->getTypeHints()->willReturn(['TypeTwo']);
        $namespaceStmt->getTypeHints()->willReturn(['TypeThree']);

        $this->getTypeHints()->shouldHaveCount(3);
        $this->getTypeHints()->shouldContain('Type');
        $this->getTypeHints()->shouldContain('TypeTwo');
        $this->getTypeHints()->shouldContain('TypeThree');
    }
}
