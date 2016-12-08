<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\Provider;

use Signature\Persistence\ResultCollectionInterface;

/**
 * Interface ProviderInterface
 * @package Signature\Persistence\Provider
 */
interface ProviderInterface
{
    /**
     * Quotes a single string.
     * @param string $string
     * @return string
     */
    public function quote(string $string): string;

    /**
     * Executes a SQL-query and returns a Result collection.
     * @param string $queryString
     * @throws \RuntimeException If query could not be executed.
     * @return ResultCollectionInterface
     */
    public function query(string $queryString): ResultCollectionInterface;

    /**
     * Connects to a data source.
     * @throws \InvalidArgumentException
     * @return void
     */
    public function connect();

    /**
     * Returns the last generated id.
     * @return int
     */
    public function getLastInsertId(): int;

    /**
     * Sets the connection info used to connect to the data source.
     * @param array $connectionInfo
     * @return ProviderInterface
     */
    public function setConnectionInfo(array $connectionInfo): ProviderInterface;
}
