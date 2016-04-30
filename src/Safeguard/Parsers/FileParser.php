<?php

namespace Safeguard\Parsers;

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
     * @var AliasParser
     */
    private $aliasParser;

    /**
     * @param FunctionParser $functionParser
     * @param NamespaceParser $namespaceParser
     * @param ClassParser $classParser
     * @param AliasParser $aliasParser
     */
    public function __construct(
        FunctionParser $functionParser,
        NamespaceParser $namespaceParser,
        ClassParser $classParser,
        AliasParser $aliasParser
    ) {
        $this->functionParser = $functionParser;
        $this->namespaceParser = $namespaceParser;
        $this->classParser = $classParser;
        $this->aliasParser = $aliasParser;
    }

    public function processFile($filename, $nodes)
    {
        $functions = $this->functionParser->processFunctions($nodes);
        $namespaces = $this->namespaceParser->processNamespaces($nodes);
        $classes = $this->classParser->processClasses($nodes);
        $aliasResolver = $this->aliasParser->createResolver($nodes);

        return new File($filename, $aliasResolver, $classes, $namespaces, $functions);
    }
}
