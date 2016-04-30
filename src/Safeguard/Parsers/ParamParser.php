<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Param as ParamNode;
use PhpParser\Node\Stmt;
use Safeguard\Stmts\Param;

class ParamParser
{
    /**
     * @param ParamNode[] $rawParams
     * @return Param[]
     */
    public function processParams(array $rawParams)
    {
        $params = [];
        foreach ($rawParams as $param) {
            if (!$param instanceof ParamNode) {
                throw new \LogicException("Invalid type given to process params");
            }

            $params[] = $this->convertParam($param);
        }

        return $params;
    }

    protected function convertParam(ParamNode $param)
    {
        $name = $param->name;
        $typeHint = null;
        if (is_object($param->type) && $param->type->parts) {
            $typeHint = implode("\\",  $param->type->parts);
        }

        return new Param($name, $typeHint);
    }
}
