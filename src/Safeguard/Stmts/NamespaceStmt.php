<?php

namespace Safeguard\Stmts;

class NamespaceStmt
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ClassStmt[]
     */
    private $classes = [];

    /**
     * @param string $name
     * @param ClassStmt[] $classes
     */
    public function __construct($name, array $classes)
    {
        $this->name = $name;
        $this->classes = $classes;
    }

    /**
     * @return ClassStmt[]
     */
    public function getClasses()
    {
        return $this->classes;
    }

    public function getTypeHints()
    {
        $typeHints = [];

        foreach ($this->classes as $class) {
            $typeHints = array_merge($typeHints, $class->getTypeHints());
        }

        return $typeHints;
    }
}
