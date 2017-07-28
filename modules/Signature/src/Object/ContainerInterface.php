<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Object;

/**
 * Interface ContainerInterface
 * @package Signature\Object
 */
interface ContainerInterface
{
    /**
     * Gets an entry out of the container specified by an identifier name.
     * @param string $identifier
     * @return mixed
     */
    public function get(string $identifier);

    /**
     * Returns true if the container has an entry for the given identifier.
     * @param string $identifier
     * @return bool
     */
    public function has(string $identifier): bool;

    /**
     * Adds a registered entry to the container.
     * @param string $identifier
     * @param string $classname
     * @return ContainerInterface
     */
    public function register(string $identifier, string $classname): ContainerInterface;
}
