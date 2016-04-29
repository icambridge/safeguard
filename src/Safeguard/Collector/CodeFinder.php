<?php

namespace Safeguard\Collector;

class CodeFinder
{
    /**
     * @param string $directory
     * @return string[]
     */
    public function getFileNames($directory)
    {
        $output = [];
        /** @var string[] $files */
        $files = glob($directory . "/*");

        foreach ($files as $file) {
            if (is_dir($file)) {
                $filenames = $this->getFileNames($file);
                $output = array_merge($output, $filenames);
                continue;
            }

            if (preg_match("|\.php$|", $file)) {
                $output[] = $file;
            }

        }

        return $output;
    }
}
