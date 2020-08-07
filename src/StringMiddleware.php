<?php

/**
 * @see       https://github.com/open-code-modeling/php-code-generator-transformator for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\CodeGenerator\Transformator;

use OpenCodeModeling\CodeGenerator\Workflow;

final class StringMiddleware
{
    /**
     * @var callable
     */
    private $component;

    public function __construct(callable $component)
    {
        $this->component = $component;
    }

    public function __invoke(string $data): string
    {
        return ($this->component)($data);
    }

    public static function workflowComponentDescription(
        callable $component,
        string $input,
        string $output
    ): Workflow\Description {
        return new Workflow\ComponentDescriptionWithSlot(
            new self($component),
            $output,
            $input
        );
    }
}
