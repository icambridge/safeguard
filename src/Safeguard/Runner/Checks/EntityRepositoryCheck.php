<?php

namespace Safeguard\Runner\Checks;

use Safeguard\Exceptions\Result\FailException;
use Safeguard\Exceptions\Result\WarningException;
use Safeguard\Stmts\ClassStmt;
use Safeguard\Stmts\File;

class EntityRepositoryCheck implements CheckInterface
{
    /**
     * @param File $file
     * @return void
     * @throws FailException
     * @throws WarningException
     */
    public function check(File $file)
    {
        foreach ($file->getClasses() as $class) {
            $this->checkClass($class, $file);
        }
    }

    protected function checkClass(ClassStmt $classStmt, File $file)
    {
        if (!$classStmt->isChildClass()) {
            return;
        }

        if ($file->isClassAnAliasFor($classStmt->getParentClass(), 'Doctrine\ORM\EntityRepository')) {
            throw new FailException("Extended Doctrine Entity Repository", $file);
        }
    }
}
