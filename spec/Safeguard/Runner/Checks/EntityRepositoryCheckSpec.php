<?php

namespace spec\Safeguard\Runner\Checks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Exceptions\Result\FailException;
use Safeguard\Runner\Checks\CheckInterface;
use Safeguard\Runner\Checks\EntityRepositoryCheck;
use Safeguard\Stmts\ClassStmt;
use Safeguard\Stmts\File;

class EntityRepositoryCheckSpec extends ObjectBehavior
{
    const ALIAS = 'EntityRepository';

    const DOCTRINE_ORM_ENTITY_REPOSITORY = 'Doctrine\ORM\EntityRepository';

    function it_is_initializable()
    {
        $this->shouldHaveType(EntityRepositoryCheck::class);
    }

    function it_is_a_check()
    {
        $this->shouldImplement(CheckInterface::class);
    }

    function it_fails_if_someone_extends_entity_repository(ClassStmt $classStmt, File $file)
    {
        $classStmt->getParentClass()->willReturn(self::ALIAS);
        $classStmt->isChildClass()->willReturn(true);
        $file->isClassAnAliasFor(self::ALIAS, self::DOCTRINE_ORM_ENTITY_REPOSITORY)->willReturn(true);
        $file->getClasses()->willReturn([$classStmt]);
        $this->shouldThrow(FailException::class)->duringCheck($file);
    }

    function it_does_fail_if_alias_does_not_match(ClassStmt $classStmt, File $file)
    {
        $classStmt->getParentClass()->willReturn(self::ALIAS);
        $classStmt->isChildClass()->willReturn(true);
        $file->isClassAnAliasFor(self::ALIAS, self::DOCTRINE_ORM_ENTITY_REPOSITORY)->willReturn(false);
        $file->getClasses()->willReturn([$classStmt]);
        $this->shouldNotThrow(FailException::class)->duringCheck($file);
    }

    function it_does_not_fail_if_someone_extends_entity_repository(ClassStmt $classStmt, File $file)
    {
        $classStmt->isChildClass()->willReturn(false);
        $file->getClasses()->willReturn([$classStmt]);
        $this->shouldNotThrow(FailException::class)->duringCheck($file);
    }
}
