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

class CodeListToFiles
{
    /**
     * @var StringToFile
     **/
    private $stringToFile;

    public function __construct(StringToFile $stringToFile)
    {
        $this->stringToFile = $stringToFile;
    }

    public function __invoke(array $codeList): void
    {
        foreach ($codeList as $name => $info) {
            if (! isset($info['code']) || ! isset($info['filename'])) {
                throw new RuntimeException(
                    'Invalid code list info provided. Need array with key "code" and "filename".'
                );
            }

            ($this->stringToFile)($info['code'], $info['filename']);
        }
    }

    public static function workflowComponentDescription(
        StringToFile $stringToFile,
        string $inputCodeList
    ): Workflow\Description {
        return new ComponentDescriptionWithInputSlotOnly(
            new self($stringToFile),
            $inputCodeList
        );
    }
}
