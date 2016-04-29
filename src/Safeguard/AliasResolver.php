<?php

namespace Safeguard;

use PhpParser\Node\Stmt\UseUse;

class AliasResolver
{
    /**
     * @var string[string]
     */
    protected $aliases = [];

    public function __construct(array $nodes)
    {
        // TODO move to factory
        $this->prepareData($nodes);
    }

    /**
     * @param string $alias
     * @param string $fqn
     * @return bool
     */
    public function isAliasFor($alias, $fqn)
    {
        if (!array_key_exists($alias, $this->aliases)) {
            return false;
        }

        return ($fqn === $this->aliases[$alias]);
    }

    protected function prepareData($nodes)
    {
        foreach ($nodes as $node)
        {
            if ($node instanceof UseUse) {
                $this->prepareUseStatement($node);
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
