<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Object;

/**
 * Class ObjectProviderService
 * @package Signature\Object
 */
final class ObjectProviderService extends \Signature\Service\AbstractInjectableService
{
    /**
     * @var ObjectProviderService
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $registeredServices = [
        'ObjectProviderService' => \Signature\Object\ObjectProviderService::class,
        'ModuleService'         => \Signature\Module\ModuleService::class,
        'ConfigurationService'  => \Signature\Configuration\ConfigurationService::class,
    ];

    /**
     * @var array
     */
    protected $singletonServices = [];

    /**
     * Disable the constructor as this class is a singleton.
     */
    private function __construct()
    {
    }

    /**
     * Get the instance of this Service.
     * @return ObjectProviderService
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Adds a new service mapping to the service manager.
     * @param string $serviceIdentifier
     * @param string $serviceClassname
     * @return \Signature\Object\ObjectProviderService
     */
    public function registerService($serviceIdentifier, $serviceClassname)
    {
        $this->registeredServices[$serviceIdentifier] = $serviceClassname;

        return $this;
    }

    /**
     * Returns the current service mapping.
     * @return array
     */
    public function getRegisteredServices()
    {
        return $this->registeredServices;
    }

    /**
     * Returns an instance of the service named in $serviceIdentifier.
     * @throws \OutOfBoundsException
     * @throws \UnexpectedValueException
     * @param string $serviceIdentifier
     * @return \Signature\Service\InjectableServiceInterface
     */
    public function getService($serviceIdentifier)
    {
        if (array_key_exists($serviceIdentifier, $this->singletonServices)) {
            return $this->singletonServices[$serviceIdentifier];
        } else {
            if (!array_key_exists($serviceIdentifier, $this->registeredServices)) {
                throw new \OutOfBoundsException(
                    'A service identified by "' . $serviceIdentifier . '" has not been registered.'
                );
            }

            /* @var $seviceObject \Signature\Service\InjectableServiceInterface */
            $serviceObject = new $this->registeredServices[$serviceIdentifier];

            if (!$serviceObject instanceof \Signature\Service\InjectableServiceInterface) {
                throw new \UnexpectedValueException(
                    $serviceIdentifier . ' must implement Signature\Service\InjectableServiceInterface.'
                );
            }

            $this->injectServices($serviceObject);

            $serviceObject->init();

            if ($serviceObject->threatAsSingleton()) {
                $this->singletonServices[$serviceIdentifier] = $serviceObject;
            }

            return $serviceObject;
        }
    }

    /**
     * Injects all registered registeredServices to the given object.
     * @param object $object
     * @throws \InvalidArgumentException When provides object is not an object.
     * @return void
     */
    public function injectServices($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Given argument $object is not an object.');
        }

        foreach ($this->registeredServices as $serviceIdentifier => $serviceClassname) {
            if (method_exists($object, $setterMethodname = 'set' . $serviceIdentifier)) {
                $serviceInstance = ($serviceClassname == get_class($this))
                    ? $this
                    : $this->getService($serviceIdentifier);

                $object->$setterMethodname($serviceInstance);
            }
        }
    }

    /**
     * Creates an instance of the given classname.
     * @throws \RuntimeException If class does not exist.
     * @param string $className
     * @return object
     */
    public function create($className)
    {
        if (!class_exists($className)) {
            throw new \RuntimeException('Cannot load class "' . $className . '".');
        }

        $arguments = func_get_args();

        array_shift($arguments); // Remove 1st argument $className

        if (count($arguments)) {
            $reflectionClass = new \ReflectionClass($className);
            $object          = $reflectionClass->newInstanceArgs($arguments);
        } else {
            $object = new $className();
        }

        // Inject service to new object
        $this->injectServices($object);

        return $object;
    }
}
