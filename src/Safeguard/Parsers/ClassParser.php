<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Stmt;
use Safeguard\Stmts\ClassStmt;

class ClassParser
{
    /**
     * @var ClassMethodParser
     */
    private $classMethodParser;

    /**
     * @param ClassMethodParser $classMethodParser
     */
    public function __construct(ClassMethodParser $classMethodParser)
    {
        $this->classMethodParser = $classMethodParser;
    }

    /**
     * @param Stmt[] $stmts
     * @return ClassStmt[]
     */
    public function processClasses(array $stmts)
    {
        $classes = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Stmt\Class_)
            {
                $classes[] = $this->processClass($stmt);
            }
        }

        return $classes;
    }

    /**
     * @param Stmt\Class_ $class_
     * @return ClassStmt
     */
    protected function processClass(Stmt\Class_ $class_)
    {
        $methods = $this->classMethodParser->processMethods($class_);
        $name = $class_->name;
        $extendsClassName = $this->extractExtends($class_);
        $implements = $this->extractImplements($class_);

        return new ClassStmt($name, $methods, $extendsClassName, $implements);
    }

    protected function extractExtends(Stmt\Class_ $class_)
    {
        if (empty($class_->extends) || empty($class_->extends->parts)) {
            return null;
        }

        return implode('\\', $class_->extends->parts);
    }

    protected function extractImplements(Stmt\Class_ $class_)
    {
        $implements = [];
        foreach ($class_->implements as $implement) {
            if (empty($implement) || empty($implement->parts)) {
                continue;
            }
            $implements[] =  implode('\\', $implement->parts);
        }

        return $implements;
    }
}
