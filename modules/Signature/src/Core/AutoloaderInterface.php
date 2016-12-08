<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Core;

/**
 * Interface AutoloaderInterface
 * @package Signature\Core
 */
interface AutoloaderInterface
{
    /**
     * @var string
     */
    const MODULES_PATHNAME = 'modules';

    /**
     * @var string
     */
    const SOURCES_PATHNAME = 'src';

    /**
     * Autoloads a single class.
     * @param string $className
     * @return bool
     */
    public static function autoload(string $className): bool;
}
