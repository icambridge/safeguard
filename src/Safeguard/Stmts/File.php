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
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param AliasResolver $aliasResolver
     * @param ClassStmt[] $classes
     * @param NamespaceStmt[] $namespaces
     * @param FunctionStmt[] $functions
     */
    public function __construct($name, AliasResolver $aliasResolver, $classes, $namespaces, $functions)
    {
        $this->aliasResolver = $aliasResolver;
        $this->classes = $classes;
        $this->namespaces = $namespaces;
        $this->functions = $functions;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
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

    public function getTypeHints()
    {
        $typeHints = [];

        foreach ($this->namespaces as $namespace) {
            $typeHints = array_merge($typeHints, $namespace->getTypeHints());
        }

        foreach ($this->classes as $class) {
            $typeHints = array_merge($typeHints, $class->getTypeHints());
        }

        foreach ($this->functions as $function) {
            $typeHints = array_merge($typeHints, $function->getTypeHints());
        }

        return $typeHints;
    }

    public function getClasses()
    {
        $classes = $this->classes;
        foreach ($this->namespaces as $namespace) {
            $classes = array_merge($classes, $namespace->getClasses());
        }

        return $classes;
    }
}
