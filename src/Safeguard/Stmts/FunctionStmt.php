<?php

namespace Safeguard\Stmts;

class FunctionStmt
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Param[]
     */
    private $params = [];

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
