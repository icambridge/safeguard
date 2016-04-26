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
        $output = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Stmt\Class_)
            {
                $output[] = $this->processClass($stmt);
            }
        }

        return $output;
    }

    /**
     * @param Stmt\Class_ $class_
     * @return ClassStmt
     */
    protected function processClass(Stmt\Class_ $class_)
    {
        $methods = $this->classMethodParser->processMethods($class_);
        $name = $class_->name;

        return new ClassStmt($name, $methods);
    }
}
