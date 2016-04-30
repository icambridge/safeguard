<?php

namespace spec\Safeguard\Runner;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Exceptions\Result\FailException;
use Safeguard\Exceptions\Result\WarningException;
use Safeguard\Runner\ResultsCollector;
use Safeguard\Stmts\File;

class ResultsCollectorSpec extends ObjectBehavior
{
    const FILENAME = "filename";

    const MESSAGE = "Inheirts Doctrine Entity Manger";

    function it_is_initializable()
    {
        $this->shouldHaveType(ResultsCollector::class);
    }

    function it_logs_a_fail_againist_file(File $file)
    {
        $file->getName()->willReturn(self::FILENAME);
        $exception = new FailException(self::MESSAGE, $file->getWrappedObject());
        $this->logResult($exception);
        $result = $this->getResults();
        $result->shouldBeArray();
        $result->shouldBe(['fail' => [self::FILENAME => [self::MESSAGE]], 'warning' => []]);
    }

    function it_logs_a_warning_againist_file(File $file)
    {
        $file->getName()->willReturn(self::FILENAME);
        $exception = new WarningException(self::MESSAGE, $file->getWrappedObject());
        $this->logResult($exception);
        $result = $this->getResults();
        $result->shouldBeArray();
        $result->shouldBe(['fail' => [], 'warning' => [self::FILENAME => [self::MESSAGE]]]);
    }
}
