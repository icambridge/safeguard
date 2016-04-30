<?php

namespace Safeguard\Command;

use Safeguard\Collector\CodeFinder;
use Safeguard\Parsers\AliasParser;
use Safeguard\Parsers\ClassMethodParser;
use Safeguard\Parsers\ClassParser;
use Safeguard\Parsers\CodeParser;
use Safeguard\Parsers\FileParser;
use Safeguard\Parsers\FunctionParser;
use Safeguard\Parsers\NamespaceParser;
use Safeguard\Parsers\ParamParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScanCommand extends Command
{
    protected function configure()
    {
        $this->setName("scan")
            ->setDescription('Scans directory for invalid code')
            ->addArgument('directory', InputArgument::REQUIRED, 'The directory to be scanned');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('directory');

        $codeFinder = new CodeFinder();
        $codeParser = new CodeParser();
        $paramParser = new ParamParser();
        $classMethodParser = new ClassMethodParser($paramParser);
        $classParser = new ClassParser($classMethodParser);
        $namespaceParser = new NamespaceParser($classParser);
        $functionParser = new FunctionParser($paramParser);
        $aliasParser = new AliasParser();
        $fileParser = new FileParser($functionParser, $namespaceParser, $classParser, $aliasParser);

        $realpath = realpath($name);
        $files = $codeFinder->getFileNames($realpath);
        foreach ($files as $filename) {
            $nodes = $codeParser->parseCode($filename);
            $file = $fileParser->processFile($filename, $nodes);
        }

        $message = sprintf("Finished %d files scanned", count($files));
        $output->writeln($message);
    }
}
