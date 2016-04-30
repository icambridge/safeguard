<?php

namespace Safeguard\Stmts;

class Method
{
    /**
     * @var Param[]
     */
    private $params = [];

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param Param[] $params
     */
    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->params = $params;
    }

    public function getTypeHints()
    {
        $typeHints = [];
        foreach ($this->params as $param) {
            $typeHints[] = $param->getTypeHint();
        }

        return $typeHints;
    }
}
