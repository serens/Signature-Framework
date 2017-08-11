<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Object;

use Signature\Service\AbstractService;
use Signature\Service\ServiceInterface;

/**
 * Class ObjectProviderService
 * @package Signature\Object
 */
final class ObjectProviderService extends AbstractService implements ContainerInterface
{
    /**
     * @var ObjectProviderService
     */
    static protected $instance = null;

    /**
     * @var array
     */
    protected $registry = [
        'ObjectProviderService' => self::class
    ];

    /**
     * @var array
     */
    protected $singletons = [];

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
    public static function getInstance(): ObjectProviderService
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @inheritdoc
     */
    public function register(string $identifier, string $classname): ContainerInterface
    {
        $this->registry[$identifier] = $classname;

        return $this;
    }

    /**
     * Injects all registered identifiers to the given object.
     * @param object $object
     * @throws \InvalidArgumentException When provided object is not an object.
     * @return void
     */
    public function injectDependencies($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Given argument $object is not an object.');
        }

        foreach ($this->registry as $identifier => $classname) {
            if (method_exists($object, $setterMethodname = 'set' . $identifier)) {
                $dependency = ($classname == get_class($this))
                    ? $this
                    : $this->get($identifier);

                $object->$setterMethodname($dependency);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function get(string $identifier)
    {
        if (array_key_exists($identifier, $this->singletons)) {
            return $this->singletons[$identifier];
        }

        $classname = $this->has($identifier) ? $this->registry[$identifier] : $identifier;
        $arguments = func_get_args();

        array_shift($arguments); // Remove 1st argument $identifier

        $object = count($arguments)
            ? (new \ReflectionClass($classname))->newInstanceArgs($arguments)
            : new $classname();

        // Inject dependencies to new object
        $this->injectDependencies($object);

        if ($object instanceof ServiceInterface) {
            $object->init();
        }

        if ($object instanceof SingletonInterface) {
            $this->singletons[$identifier] = $object;
        }

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function has(string $identifier): bool
    {
        return array_key_exists($identifier, $this->registry);
    }
}
