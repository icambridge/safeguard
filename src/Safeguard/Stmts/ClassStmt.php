<?php

namespace Safeguard\Stmts;

class ClassStmt
{
    /**
     * @var Method[]
     */
    private $methods = [];
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param Method[] $methods
     */
    public function __construct($name, array $methods)
    {
        $this->methods = $methods;
        $this->name = $name;
    }

    public function getTypeHints()
    {
        $paramTypes = [];
        foreach ($this->methods as $method) {
            $paramTypes = array_merge($method->getTypeHints(), $paramTypes);
        }

        return $paramTypes;
    }
}
