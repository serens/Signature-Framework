<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Module;

use Signature\Module\ModuleInterface;
use Signature\Object\ObjectProviderService;

/**
 * Class Loader
 * @package Signature\Module
 */
final class Loader
{
    /**
     * @var string
     */
    const MODULES_PATHNAME = 'modules';

    /**
     * @var string
     */
    const CACHE_PATHNAME = 'cache';

    /**
     * @var string
     */
    const MODULELIST_CACHE_FILENAME = 'modulelist.php';

    /**
     * @var array
     */
    protected $modules = [];

    /**
     * @var string
     */
    protected $cacheFilename = '';

    /**
     * @var ObjectProviderService
     */
    protected $objectProviderService = null;

    /**
     * @var \Signature\Module\ModuleService
     */
    protected $moduleService = null;

    /**
     * @var \Signature\Configuration\ConfigurationService
     */
    protected $configurationService = null;

    /**
     * Contructor. Initializes member variables.
     */
    public function __construct()
    {
        $this->cacheFilename         = self::CACHE_PATHNAME . '/' . self::MODULELIST_CACHE_FILENAME;
        $this->objectProviderService = ObjectProviderService::getInstance();
        $this->moduleService         = $this->objectProviderService->getService('ModuleService');
        $this->configurationService  = $this->objectProviderService->getService('ConfigurationService');
    }

    /**
     * Loads and starts the modules. If no modules are found, an exception will be thrown.
     * @throws \RuntimeException
     * @return void
     */
    public function start()
    {
        if (!$modules = $this->getModules()) {
            throw new \RuntimeException('No modules are installed!');
        }

        // Initialize modules and pass them to the module service.
        $this->initializeModules($modules);

        // Start modules, which have been successfully initialized and passed to the module service.
        $this->startModules($this->moduleService->getRegisteredModules());
    }

    /**
     * Initializes all provided modules.
     *
     * If a module could be loaded and initialized it is passed to the Module Service. Each found module is
     * initialized by calling the modules init()-method. At this point a module should initialize it self. At least one
     * module should set some persistence settings if database access is needed.
     *
     * If a module returns false, no further modules will be initialized.
     * @param array $modules
     * @throws \UnexpectedValueException
     * @return void
     */
    protected function initializeModules(array $modules)
    {
        foreach ($modules as $moduleName) {
            $moduleClassname = $moduleName . '\\Module';
            $moduleInstance  = $this->objectProviderService->create($moduleClassname);

            if (!$moduleInstance instanceof ModuleInterface) {
                throw new \UnexpectedValueException(sprintf(
                    'Failed to initialize registered module "%s". Class "%s" must implement "Signature\Module\ModuleInterface".',
                    $moduleName,
                    $moduleClassname
                ));
            }

            // If module returnes false, stop loading further more modules...
            if (!$moduleInstance->init()) {
                return;
            }

            // ... otherwise register the module as a valid module.
            $this->moduleService->registerModule($moduleName, $moduleInstance);
            $this->configurationService->setConfig($moduleName, $moduleInstance->getConfig());
        }
    }

    /**
     * Starts the given module instances.
     *
     * If a module returns false, no further modules will be started..
     * @param array $modules
     * @return void
     */
    protected function startModules(array $modules)
    {
        /** @var $moduleInstance ModuleInterface */
        foreach ($modules as $moduleInstance) {
            // If module returnes false, stop starting further more modules
            if (!$moduleInstance->start()) {
                return;
            }
        }
    }

    /**
     * Returns all registered modules which reside in the modules-directory.
     * @return array
     */
    protected function getModules(): array
    {
        if (file_exists($this->cacheFilename)) {
            require_once $this->cacheFilename;
        } else {
            if ($modules = $this->retriveModulesFromModulesDirectory()) {
                $this->modules = $modules;
                $this->writeModulesCacheContent($modules);
            }
        }

        return $this->modules;
    }

    /**
     * Searches for modules in the modules-directory.
     * @throws \RuntimeException
     * @return array
     */
    protected function retriveModulesFromModulesDirectory(): array
    {
        if (!$dirHandle = opendir('./' . self::MODULES_PATHNAME)) {
            throw new \RuntimeException('Cannot open modules-directory.');
        }

        $foundModules = [];

        while ($dirName = readdir($dirHandle)) {
            $modulePath = './' . self::MODULES_PATHNAME . '/' . $dirName . '/';

            if (in_array($dirName, array('.', '..')) || !is_dir($modulePath))
                continue;

            if (file_exists($modulePath . 'src/' . ModuleInterface::MODULE_FILENAME)) {
                // Signature-Module should always be the first loaded module.
                strtolower($dirName) === 'signature'
                    ? array_unshift($foundModules, $dirName)
                    : array_push($foundModules, $dirName);
            } else {
                throw new \RuntimeException(sprintf(
                    'Directory "%s" does not contain a %s-file.',
                    $dirName,
                    ModuleInterface::MODULE_FILENAME
                ));
            }
        }

        closedir($dirHandle);

        return $foundModules;
    }

    /**
     * Writes the cache file which stores the found modules.
     * @param array $modules
     * @throws \RuntimeException When the file cannot be created or modified.
     * @return void
     */
    protected function writeModulesCacheContent(array $modules = array())
    {
        $cacheCode =
            '<?php ' . "\r\n" .
            '    /* This file has been automatically created on ' . date('Y-m-d, H:i:s') . " by the Signature Module Loader.\r\n" .
            '       Delete this file, if you want to create an updated module-file. */' . "\r\n";

        foreach ($modules as $module) {
            $cacheCode .= '    $this->addModule(\'' . $module . '\');' . "\r\n";
        }

        if (!@file_put_contents($this->cacheFilename, $cacheCode)) {
            throw new \RuntimeException('Cache file "' . $this->cacheFilename . '" cannot be created or modified.');
        }
    }

    /**
     * Adds a directory to the internal list of modules.
     * @param string $moduleName
     * @return Loader
     */
    protected function addModule(string $moduleName): Loader
    {
        $this->modules[] = $moduleName;

        return $this;
    }
}
