<?php

namespace spec\Safeguard\Runner\Checks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Exceptions\Result\WarningException;
use Safeguard\Runner\Checks\CheckInterface;
use Safeguard\Runner\Checks\CheckRunner;
use Safeguard\Runner\ResultsCollector;
use Safeguard\Stmts\File;

class CheckRunnerSpec extends ObjectBehavior
{
    function let(ResultsCollector $resultsCollector)
    {
        $this->beConstructedWith([], $resultsCollector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CheckRunner::class);
    }

    function it_is_a_check()
    {
        $this->shouldImplement(CheckInterface::class);
    }

    function it_calls_checks(
        File $file,
        CheckInterface $checkOne,
        CheckInterface $checkTwo,
        ResultsCollector $resultsCollector
    ) {
        $checkOne->check($file)->shouldBeCalled();
        $checkTwo->check($file)->shouldBeCalled();

        $this->beConstructedWith([$checkOne, $checkTwo], $resultsCollector);
        $this->check($file);
    }

    function it_calls_result_logger(
        File $file,
        CheckInterface $checkOne,
        CheckInterface $checkTwo,
        ResultsCollector $resultsCollector
    ) {
        $exception = new WarningException("Message", $file->getWrappedObject());
        $checkOne->check($file)->shouldBeCalled();
        $checkTwo->check($file)->willThrow($exception);
        $resultsCollector->logResult($exception)->shouldBeCalled();
        $this->beConstructedWith([$checkOne, $checkTwo], $resultsCollector);
        $this->check($file);
    }
}
