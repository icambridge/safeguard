<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Stmt\UseUse;
use Safeguard\Stmts\AliasResolver;

class AliasParser
{
    private $aliases = [];

    /**
     * @param $nodes
     * @return AliasResolver
     */
    public function createResolver($nodes)
    {
        $this->aliases = [];
        foreach ($nodes as $node) {
            if ($node instanceof UseUse) {
                $this->prepareUseStatement($node);
            }
        }

        return new AliasResolver($this->aliases);
    }

    protected function prepareUseStatement(UseUse $useUse)
    {
        $alias = $useUse->alias;
        if (!$alias) {
            return;
        }

        $parts = $useUse->name->parts;
        $fqn = implode("\\", $parts);
        $this->aliases[$alias] = $fqn;
    }
}
