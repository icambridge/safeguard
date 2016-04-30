<?php

namespace spec\Safeguard\Runner\Checks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Runner\Checks\CheckInterface;
use Safeguard\Runner\Checks\CheckRunner;
use Safeguard\Stmts\File;

class CheckRunnerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CheckRunner::class);
    }

    function it_is_a_check()
    {
        $this->shouldImplement(CheckInterface::class);
    }

    function it_calls_checks(File $file, CheckInterface $checkOne, CheckInterface $checkTwo)
    {
        $checkOne->check($file)->shouldBeCalled();
        $checkTwo->check($file)->shouldBeCalled();

        $this->beConstructedWith([$checkOne, $checkTwo]);
        $this->check($file);
    }
}
