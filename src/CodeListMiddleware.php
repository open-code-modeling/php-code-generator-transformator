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

final class CodeListMiddleware
{
    /**
     * @var callable
     **/
    private $component;

    public function __construct(callable $stringMiddleware)
    {
        $this->component = $stringMiddleware;
    }

    public function __invoke(array $codeList): array
    {
        foreach ($codeList as $name => &$info) {
            if (! isset($info['code']) || ! isset($info['filename'])) {
                throw new RuntimeException(
                    'Invalid code list info provided. Need array with key "code" and "filename".'
                );
            }

            $info['code'] = ($this->component)($info['code']);
        }

        return $codeList;
    }

    public static function workflowComponentDescription(
        callable $component,
        string $inputCodeList,
        string $output
    ): Workflow\Description {
        return new Workflow\ComponentDescriptionWithSlot(
            new self($component),
            $output,
            $inputCodeList
        );
    }
}
