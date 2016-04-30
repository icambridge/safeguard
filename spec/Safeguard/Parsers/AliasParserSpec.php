<?php

namespace spec\Safeguard\Parsers;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\UseUse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Stmts\AliasResolver;
use Safeguard\Parsers\AliasParser;

class AliasParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AliasParser::class);
    }

    function it_builds_resolver()
    {
        $nameStr = 'Symfony\Component\DependencyInjection\ContainerInterface';
        $alias = 'ContainerInterface';
        $name = new Name($nameStr);
        $useUse = new UseUse($name, $alias);
        $this->createResolver([$useUse])->shouldBeAnInstanceOf(AliasResolver::class);
    }
}
