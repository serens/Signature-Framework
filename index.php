<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

// Include and register autoloader
require_once __DIR__ . '/modules/Signature/src/Core/Autoloader.php';

spl_autoload_register([\Signature\Core\Autoloader::class, 'autoload']);

// Initialize the module loader and let him load the modules.
(new \Signature\Module\Loader())->start();
