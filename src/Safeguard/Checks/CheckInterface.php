<?php

namespace Safeguard\Checks;

use Safeguard\Stmts\File;

interface CheckInterface
{
    public function check(File $file);
}
