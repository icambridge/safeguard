<?php

namespace Safeguard\Exceptions\Result;

use Exception;
use Safeguard\Stmts\File;

abstract class ResultException extends \Exception
{
    protected $file;

    public function __construct($message, File $file)
    {
        parent::__construct($message);
        $this->file = $file;
    }

    abstract function getResultType();
}
