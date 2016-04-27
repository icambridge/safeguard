<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Param as ParamNode;
use PhpParser\Node\Stmt;
use Safeguard\Stmts\FunctionStmt;
use Safeguard\Stmts\Param;

class FunctionParser
{
    /**
     * @param Stmt[] $stmts
     * @return FunctionStmt[]
     */
    public function processFunctions($stmts)
    {
        $functions = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Stmt\Function_) {
                $functions[] = $this->processFunction($stmt);
            }
        }

        return $functions;
    }


    protected function processFunction(Stmt\Function_ $function_)
    {
        $name = $function_->name;
        $params = $this->processParams($function_->params);

        return new FunctionStmt($name, $params);
    }

    /**
     * @param ParamNode[] $rawParams
     * @return Param[]
     */
    public function processParams(array $rawParams)
    {
        $params = [];
        foreach ($rawParams as $param) {
            $params[] = $this->convertParam($param);
        }

        return $params;
    }

    /** TODO move to Param parser */
    protected function convertParam(ParamNode $param)
    {
        $name = $param->name;
        $typeHint = implode("\\",  $param->type->parts);

        return new Param($name, $typeHint);
    }
}
