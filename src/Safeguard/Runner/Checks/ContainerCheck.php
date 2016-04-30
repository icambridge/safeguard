<?php

namespace Safeguard\Runner\Checks;

use Safeguard\Exceptions\Result\FailException;
use Safeguard\Exceptions\Result\WarningException;
use Safeguard\Stmts\File;

class ContainerCheck implements CheckInterface
{
    /**
     * @param File $file
     * @return void
     * @throws FailException
     * @throws WarningException
     */
    public function check(File $file)
    {
        $typeHints = $file->getTypeHints();
        foreach ($typeHints as $typeHint) {
            if (!$typeHint){
                continue;
            }
            if ($file->isClassAnAliasFor($typeHint, 'Symfony\Component\DependencyInjection\ContainerInterface')) {
                throw new FailException("Injecting the container", $file);
            }
        }
    }
}
