<?php

namespace Safeguard\Stmts;

class File
{
    /**
     * @var ClassStmt[]
     */
    private $classes = [];

    /**
     * @var NamespaceStmt[]
     */
    private $namespaces = [];

    /**
     * @var FunctionStmt[]
     */
    private $functions = [];

    /**
     * @var AliasResolver
     */
    private $aliasResolver;

    /**
     * @param AliasResolver $aliasResolver
     * @param ClassStmt[] $classes
     * @param NamespaceStmt[] $namespaces
     * @param FunctionStmt[] $functions
     */
    public function __construct(AliasResolver $aliasResolver, $classes, $namespaces, $functions)
    {
        $this->aliasResolver = $aliasResolver;
        $this->classes = $classes;
        $this->namespaces = $namespaces;
        $this->functions = $functions;
    }

    public function isClassAnAliasFor($alias, $className)
    {
        return $this->aliasResolver->isAliasFor($alias, $className);
    }

    public function getNumberOfClasses()
    {
        return count($this->classes);
    }

    public function getNumberOfNamespaces()
    {
        return count($this->namespaces);
    }

    public function getNumberOfFunctions()
    {
        return count($this->functions);
    }
}
