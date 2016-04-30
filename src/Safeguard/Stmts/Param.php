<?php

namespace Safeguard\Stmts;

class Param
{
    /**
     * @var string
     */
    private $typeHint;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @param string $typeHint
     */
    public function __construct($name, $typeHint)
    {
        $this->typeHint = $typeHint;
        $this->name = $name;
    }

    public function getTypeHint()
    {
        return $this->typeHint;
    }
}
