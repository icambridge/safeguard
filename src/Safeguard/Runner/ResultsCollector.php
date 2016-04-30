<?php

namespace Safeguard\Runner;

use Safeguard\Exceptions\Result\ResultException;

class ResultsCollector
{
    private $results = [];

    public function __construct()
    {
        $this->results = [
            'fail' => [],
            'warning' => []
        ];
    }

    /**
     * @param ResultException $result
     */
    public function logResult(ResultException $result)
    {
        $type = $result->getResultType();
        $file = $result->getFile()->getName();
        $this->results[$type][$file][] = $result->getMessage();
    }

    public function getResults()
    {
        return $this->results;
    }
}
