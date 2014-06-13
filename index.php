<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

// Include and register autoloader
require_once __DIR__ . '/modules/Signature/src/Core/Autoloader.php';

spl_autoload_register(array('Signature\\Core\\Autoloader', 'autoload'));

// Initialize the module loader and let him load the modules.
$moduleLoader = new \Signature\Module\Loader();

$moduleLoader->start();
