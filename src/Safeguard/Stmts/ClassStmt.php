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
     * @var string
     */
    private $extends;

    /**
     * @var string[]
     */
    private $implements;

    /**
     * @param string $name
     * @param Method[] $methods
     * @param string $extends
     * @param string[] $implements
     */
    public function __construct($name, array $methods, $extends, $implements)
    {
        $this->methods = $methods;
        $this->name = $name;
        $this->extends = $extends;
        $this->implements = $implements;
    }

    public function getTypeHints()
    {
        $paramTypes = [];
        foreach ($this->methods as $method) {
            $paramTypes = array_merge($method->getTypeHints(), $paramTypes);
        }

        return $paramTypes;
    }

    public function getParentClass()
    {
        return $this->extends;
    }

    public function getImplements()
    {
        return $this->implements;
    }

    public function isChildClass()
    {
        return !empty($this->extends);
    }
}
