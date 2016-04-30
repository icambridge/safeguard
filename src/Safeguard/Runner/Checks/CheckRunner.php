<?php

namespace Safeguard\Runner\Checks;

use Safeguard\Stmts\File;

class CheckRunner implements CheckInterface
{
    /**
     * @var CheckInterface[]
     */
    private $checks;

    /**
     * @param CheckInterface[] $checks
     */
    public function __construct($checks = [])
    {
        $this->checks = $checks;
    }

    public function check(File $file)
    {
        foreach ($this->checks as $check) {
            $check->check($file);
        }
    }
}
