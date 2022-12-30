<?php
// Include and register autoloader
require_once __DIR__ . '/../modules/Signature/src/Core/Autoloader.php';

spl_autoload_register([\Signature\Core\Autoloader::class, 'autoload']);
