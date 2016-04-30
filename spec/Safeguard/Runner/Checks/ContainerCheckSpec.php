<?php

namespace spec\Safeguard\Runner\Checks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Exceptions\Result\FailException;
use Safeguard\Runner\Checks\CheckInterface;
use Safeguard\Runner\Checks\ContainerCheck;
use Safeguard\Stmts\File;

class ContainerCheckSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContainerCheck::class);
    }

    function it_is_a_check()
    {
        $this->shouldImplement(CheckInterface::class);
    }

    function it_throws_fail_if_container_is_injected(File $file)
    {
        $file->getTypeHints()->willReturn(['Container']);
        $file->isClassAnAliasFor(
            'Container',
            'Symfony\Component\DependencyInjection\ContainerInterface'
        )->willReturn(true);

        $this->shouldThrow(FailException::class)->duringCheck($file);
    }
}
