<?php

namespace Safeguard\Stmts;

class AliasResolver
{
    /**
     * @var string[string]
     */
    protected $aliases = [];

    /**
     * @param array $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
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
}
