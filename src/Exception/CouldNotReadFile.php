<?php

/**
 * @see       https://github.com/open-code-modeling/php-code-generator-transformator for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\CodeGenerator\Transformator\Exception;

final class CouldNotReadFile extends RuntimeException
{
    public static function withFile(string $file): self
    {
        return new self(
            \sprintf('Could not read file "%s".', $file)
        );
    }
}
