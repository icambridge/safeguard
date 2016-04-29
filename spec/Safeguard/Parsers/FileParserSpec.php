<?php

namespace spec\Safeguard\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Safeguard\Parsers\ClassParser;
use Safeguard\Parsers\FileParser;
use Safeguard\Parsers\FunctionParser;
use Safeguard\Parsers\NamespaceParser;
use Safeguard\Stmts\File;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Function_;

class FileParserSpec extends ObjectBehavior
{
    function let(FunctionParser $functionParser, NamespaceParser $namespaceParser, ClassParser $classParser)
    {
        $this->beConstructedWith($functionParser, $namespaceParser, $classParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileParser::class);
    }

    function it_returns_method_objects_for_all_class_methods(
        FunctionParser $functionParser,
        NamespaceParser $namespaceParser,
        ClassParser $classParser
    ) {
        $functionName = 'isReal';
        $functionStmt = new Function_($functionName);

        $param = new Param('container');
        $param->type = new Name('ContainerInterface');
        $functionStmt->params = [$param];

        $stmts = [
            $functionStmt
        ];
        $functionParser->processFunctions($stmts)->willReturn([]);
        $namespaceParser->processNamespaces($stmts)->willReturn([]);
        $classParser->processClasses($stmts)->willReturn([]);

        $this->processFile($stmts)->shouldBeAnInstanceOf(File::class);
    }
}
