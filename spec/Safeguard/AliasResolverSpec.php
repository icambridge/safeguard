<?php

namespace spec\Safeguard;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\UseUse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AliasResolverSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Safeguard\AliasResolver');
    }

    function it_knows_if_string_is_alias_for_something()
    {
        $nameStr = 'Symfony\Component\DependencyInjection\ContainerInterface';
        $alias = 'ContainerInterface';
        $name = new Name($nameStr);
        $useUse = new UseUse($name, $alias);
        $this->beConstructedWith([$useUse]);
        $this->isAliasFor($alias, $nameStr)->shouldBe(true);
    }

    function it_knows_if_string_is_not_alias_for_something()
    {
        $nameStr = 'Symfony\Component\DependencyInjection\ContainerInterface';
        $alias = 'ContainerInterface';
        $name = new Name($nameStr);
        $useUse = new UseUse($name, $alias);
        $this->beConstructedWith([$useUse]);
        $this->isAliasFor("FakeClass", $nameStr)->shouldBe(false);
    }
}
