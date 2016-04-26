<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Stmt;
use Safeguard\Stmts\NamespaceStmt;

class NamespaceParser
{
    /**
     * @var ClassParser
     */
    private $classParser;

    /**
     * @param ClassParser $classParser
     */
    public function __construct(ClassParser $classParser)
    {
        $this->classParser = $classParser;
    }

    /**
     * @param Stmt[] $stmts
     * @return NamespaceStmt[]
     */
    public function processNamespaces($stmts)
    {
        $namespaces = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Stmt\Namespace_) {
                $namespaces[] = $this->processNamespace($stmt);
            }
        }
        return $namespaces;
    }

    /**
     * @param Stmt\Namespace_ $namespace_
     * @return NamespaceStmt
     */
    protected function processNamespace(Stmt\Namespace_ $namespace_)
    {
        $classes = $this->classParser->processClasses($namespace_->stmts);
        $name = implode("\\",  $namespace_->name->parts);

        return new NamespaceStmt($name, $classes);
    }
}
