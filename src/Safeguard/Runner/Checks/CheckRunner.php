<?php

namespace Safeguard\Runner\Checks;

use Safeguard\Exceptions\Result\ResultException;
use Safeguard\Runner\ResultsCollector;
use Safeguard\Stmts\File;

class CheckRunner implements CheckInterface
{
    /**
     * @var CheckInterface[]
     */
    private $checks;
    /**
     * @var ResultsCollector
     */
    private $resultsCollector;

    /**
     * @param CheckInterface[] $checks
     * @param ResultsCollector $resultsCollector
     */
    public function __construct($checks, ResultsCollector $resultsCollector)
    {
        $this->checks = $checks;
        $this->resultsCollector = $resultsCollector;
    }

    public function check(File $file)
    {
        foreach ($this->checks as $check) {
            try {
                $check->check($file);
            } Catch (ResultException $result) {
                $this->resultsCollector->logResult($result);
            }
        }
    }
}
