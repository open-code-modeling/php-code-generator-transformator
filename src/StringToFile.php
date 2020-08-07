<?php

/**
 * @see       https://github.com/open-code-modeling/php-code-generator-transformator for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\CodeGenerator\Transformator;

use OpenCodeModeling\CodeGenerator\Transformator\Exception\RuntimeException;
use OpenCodeModeling\CodeGenerator\Workflow;
use OpenCodeModeling\CodeGenerator\Workflow\ComponentDescriptionWithInputSlotOnly;

class StringToFile
{
    public function __invoke(string $data, string $filename): void
    {
        $dir = \dirname($filename);

        if (! \is_dir($dir) && ! \mkdir($dir, 0777, true) && ! \is_dir($dir)) {
            throw new RuntimeException(\sprintf('Directory "%s" could not be created.', $dir));
        }

        if (false === \file_put_contents($filename, $data)) {
            throw new RuntimeException(\sprintf('File "%s" could not be written.', $filename));
        }
    }

    public static function workflowComponentDescription(
        string $inputData,
        string $inputFilename
    ): Workflow\Description {
        return new ComponentDescriptionWithInputSlotOnly(
            new self(),
            $inputData,
            $inputFilename
        );
    }
}
