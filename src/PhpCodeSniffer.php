<?php

/**
 * @see       https://github.com/open-code-modeling/php-code-generator-transformator for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-code-generator-transformator/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\CodeGenerator\Transformator;

\define('PHP_CODESNIFFER_VERBOSITY', 0);
\define('PHP_CODESNIFFER_CBF', true);

use OpenCodeModeling\CodeGenerator\Workflow\ComponentDescriptionWithSlot;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\DummyFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Util\Tokens;

/**
 * You have to include the PHP_CodeSniffer autoloader manually in the Code Generator configuration file
 *
 * include 'vendor/squizlabs/php_codesniffer/autoload.php';
 */
final class PhpCodeSniffer
{
    /**
     * @var Config
     **/
    private $config;

    /**
     * @var Ruleset
     **/
    private $ruleSet;

    public function __construct(Config $config)
    {
        Tokens::$arithmeticTokens; // needed as workaround for error: Use of undefined constant T_CLOSURE

        $this->config = $config;
        $this->ruleSet = new Ruleset($config);
    }

    public function __invoke(string $data): string
    {
        $file = new DummyFile($data, $this->ruleSet, $this->config);
        $file->process();
        $file->fixer->fixFile();

        return $file->fixer->getContents();
    }

    public static function workflowComponentDescription(
        ?Config $config,
        string $inputData,
        string $output
    ): ComponentDescriptionWithSlot {
        $config = $config ?: new Config(['inline'], false);

        return new ComponentDescriptionWithSlot(
            new self($config),
            $output,
            $inputData
        );
    }
}
