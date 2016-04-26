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
}
