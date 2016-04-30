<?php

namespace Safeguard\Runner\Checks;

use Safeguard\Exceptions\Result\FailException;
use Safeguard\Exceptions\Result\WarningException;
use Safeguard\Stmts\File;

interface CheckInterface
{
    /**
     * @param File $file
     * @return void
     * @throws FailException
     * @throws WarningException
     */
    public function check(File $file);
}
