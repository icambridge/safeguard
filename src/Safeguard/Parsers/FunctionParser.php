<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Param as ParamNode;
use PhpParser\Node\Stmt;
use Safeguard\Stmts\FunctionStmt;
use Safeguard\Stmts\Param;

class FunctionParser
{
    /**
     * @var ParamParser
     */
    private $paramParser;

    /**
     * @param ParamParser $paramParser
     */
    public function __construct(ParamParser $paramParser)
    {
        $this->paramParser = $paramParser;
    }

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
        $params = $this->paramParser->processParams($function_->params);

        return new FunctionStmt($name, $params);
    }

}
