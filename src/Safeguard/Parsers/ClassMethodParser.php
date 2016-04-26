<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Param as ParamNode;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Safeguard\Stmts\Method;
use Safeguard\Stmts\Param;

class ClassMethodParser
{
    /**
     * @param Class_ $classNode
     * @return Method[]
     */
    public function processMethods($classNode)
    {
        if (!$classNode instanceof Class_) {
            return [];
        }

        $output = [];

        foreach ($classNode->stmts as $stmt) {
            if ($stmt instanceof ClassMethod) {
                $output[] = $this->convertMethod($stmt);
            }
        }

        return $output;
    }

    protected function convertMethod(ClassMethod $classMethod)
    {
        $name = $classMethod->name;
        $params = [];
        foreach ($classMethod->params as $param) {
            $params[] = $this->convertParam($param);
        }

        return new Method($name, $params);
    }

    protected function convertParam(ParamNode $param)
    {
        $name = $param->name;
        $typeHint = implode("\\",  $param->type->parts);

        return new Param($name, $typeHint);
    }
}
