<?php

namespace Safeguard\Parsers;

use Safeguard\AliasResolver;
use Safeguard\Stmts\File;

class FileParser
{
    /**
     * @var FunctionParser
     */
    private $functionParser;
    /**
     * @var NamespaceParser
     */
    private $namespaceParser;
    /**
     * @var ClassParser
     */
    private $classParser;

    /**
     * @param FunctionParser $functionParser
     * @param NamespaceParser $namespaceParser
     * @param ClassParser $classParser
     */
    public function __construct(
        FunctionParser $functionParser,
        NamespaceParser $namespaceParser,
        ClassParser $classParser
    ) {
        $this->functionParser = $functionParser;
        $this->namespaceParser = $namespaceParser;
        $this->classParser = $classParser;
    }

    public function processFile($nodes)
    {
        $functions = $this->functionParser->processFunctions($nodes);
        $namespaces = $this->namespaceParser->processNamespaces($nodes);
        $classes = $this->classParser->processClasses($nodes);
        $aliasResolver = new AliasResolver($nodes);

        return new File($aliasResolver, $classes, $namespaces, $functions);
    }
}
