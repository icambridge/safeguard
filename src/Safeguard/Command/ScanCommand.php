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
use Safeguard\Runner\Checks\CheckRunner;
use Safeguard\Runner\Checks\ContainerCheck;
use Safeguard\Runner\Checks\EntityRepositoryCheck;
use Safeguard\Runner\ResultsCollector;
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
        // Move somewhere else.
        $codeFinder = new CodeFinder();
        $codeParser = new CodeParser();
        $paramParser = new ParamParser();
        $classMethodParser = new ClassMethodParser($paramParser);
        $classParser = new ClassParser($classMethodParser);
        $namespaceParser = new NamespaceParser($classParser);
        $functionParser = new FunctionParser($paramParser);
        $aliasParser = new AliasParser();
        $fileParser = new FileParser($functionParser, $namespaceParser, $classParser, $aliasParser);
        $resultCollector = new ResultsCollector();
        $containerCheck = new ContainerCheck();
        $entityRepositoryCheck = new EntityRepositoryCheck();
        $checkRunner = new CheckRunner([$containerCheck, $entityRepositoryCheck], $resultCollector);

        $realpath = realpath($name);
        $files = $codeFinder->getFileNames($realpath);
        foreach ($files as $filename) {
            $nodes = $codeParser->parseCode($filename);
            $file = $fileParser->processFile($filename, $nodes);
            $checkRunner->check($file);
        }

        $message = sprintf("Finished %d files scanned", count($files));
        $output->writeln($message);

        // TODO Move to results formatter
        foreach ($resultCollector->getResults() as $type => $results) {
                foreach ($results as $file => $messages) {
                    foreach ($messages as $message) {
                        $resultMessage = sprintf("%s - %s - %s", $type, $file, $message);
                        $output->writeln($resultMessage);
                    }
                }
        }
    }
}
