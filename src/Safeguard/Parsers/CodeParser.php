<?php

namespace Safeguard\Parsers;

use PhpParser\ParserFactory;

class CodeParser
{
    private $parser;

    public function __construct()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
    }

    public function parseCode($file)
    {
        $code = file_get_contents($file);

        return $this->parser->parse($code);
    }
}
