<?php

/**
 * @see       https://github.com/open-code-modeling/php-code-generator-transformator for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\CodeGenerator\Transformator;

use DOMDocument;
use OpenCodeModeling\CodeGenerator\Transformator\Exception\RuntimeException;
use OpenCodeModeling\CodeGenerator\Workflow;

/**
 * Loads a XML file with DOM. This is needed for xsl:include for instance.
 */
final class FileToDomDocument
{
    public function __invoke(string $file): DOMDocument
    {
        // TODO file check / error handling
        $dom = new DOMDocument();

        if (false === $dom->load($file)) {
            throw new RuntimeException(
                \sprintf('Error loading XML file "%s"', $file)
            );
        }

        return $dom;
    }

    public static function workflowComponentDescription(
        string $inputFile,
        string $output
    ): Workflow\Description {
        return new Workflow\ComponentDescriptionWithSlot(
            new self(),
            $output,
            $inputFile
        );
    }
}
