<?php

namespace spec\Safeguard\Stmts;

use PhpParser\Node\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\AliasResolver;

class AliasResolverSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AliasResolver::class);
    }

    function it_knows_if_string_is_alias_for_something()
    {
        $nameStr = 'Symfony\Component\DependencyInjection\ContainerInterface';
        $alias = 'ContainerInterface';
        $this->beConstructedWith([$alias => $nameStr]);
        $this->isAliasFor($alias, $nameStr)->shouldBe(true);
    }

    function it_knows_if_string_is_not_alias_for_something()
    {
        $nameStr = 'Symfony\Component\DependencyInjection\ContainerInterface';
        $alias = 'ContainerInterface';
        $this->beConstructedWith([$alias => $nameStr]);
        $this->isAliasFor("FakeClass", $nameStr)->shouldBe(false);
    }
}
