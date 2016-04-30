<?php

namespace Safeguard\Parsers;

use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
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

            if ($node instanceof Namespace_) {
                $this->handleNamespace($node);
            }
            if ($node instanceof Use_) {
                $this->handleUse($node);
            }
            if ($node instanceof UseUse) {
                $this->prepareUseStatement($node);
            }
        }

        return new AliasResolver($this->aliases);
    }

    protected function handleNamespace(Namespace_ $namespace_)
    {
        foreach ($namespace_->stmts as $stmt) {
            if ($stmt instanceof Use_) {
                $this->handleUse($stmt);
            }
        }
    }

    protected function handleUse(Use_ $use_)
    {
        foreach ($use_->uses as $use) {
            if ($use instanceof UseUse) {
                $this->prepareUseStatement($use);
            }
        }
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
