<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Core;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'AutoloaderInterface.php';

/**
 * Class Autoloader
 * @package Signature\Core
 */
abstract class Autoloader implements AutoloaderInterface
{
    /**
     * Autoloads a single class.
     * @param string $className
     * @return boolean
     */
    public static function autoload($className)
    {
        $className = ltrim((string) $className, '\\');
        $fileName  = self::MODULES_PATHNAME . DIRECTORY_SEPARATOR;
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace      = substr($className, 0, $lastNsPos);
            $namespaceParts = explode('\\', $namespace);
            $moduleName     = array_shift($namespaceParts);
            $namespace      = $moduleName . '\\' . self::SOURCES_PATHNAME . '\\' . implode('\\', $namespaceParts);
            $className      = substr($className, $lastNsPos + 1);
            $fileName      .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require_once $fileName;

            return true;
        }

        return false;
    }
}
