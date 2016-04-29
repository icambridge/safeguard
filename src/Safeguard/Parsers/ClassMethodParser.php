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
        $params = $this->paramParser->processParams($classMethod->params);

        return new Method($name, $params);
    }
}
