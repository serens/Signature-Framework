<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence;

use Signature\Service\AbstractInjectableService;
use Signature\Persistence\Provider\ProviderInterface;

/**
 * Class PersistenceService
 * @package Signature\Persistence
 */
class PersistenceService extends AbstractInjectableService implements ProviderInterface
{
    /**
     * @var \Signature\Persistence\Provider\ProviderInterface
     */
    protected $provider = null;

    /**
     * Backquotes a given string.
     * @param string $string
     * @return string
     */
    public function backquote(string $string): string
    {
        return '`' . $string . '`';
    }

    /**
     * Quotes a given string.
     * @param string $string
     * @return string
     */
    public function quote(string $string): string
    {
        return $this->getProvider()->quote($string);
    }

    /**
     * Executes a SQL-query and returns a Result collection.
     * @param string $queryString
     * @return ResultCollectionInterface
     */
    public function query(string $queryString): ResultCollectionInterface
    {
        return $this->getProvider()->query($queryString);
    }

    /**
     * @param string $queryString
     * @param array $parameters
     * @return ResultCollectionInterface
     */
    public function execute(string $queryString, array $parameters = []): ResultCollectionInterface
    {
        return $this->getProvider()->execute($queryString, $parameters);
    }

    /**
     * Returns the current configured persistence provider.
     * @return ProviderInterface
     * @throws \UnexpectedValueException
     */
    public function getProvider(): ProviderInterface
    {
        if (null === $this->provider) {
            throw new \UnexpectedValueException('No persistence provider has been set.');
        }

        return $this->provider;
    }

    /**
     * Sets a persistence provider.
     * @param ProviderInterface $provider
     * @return PersistenceService
     */
    public function setProvider(ProviderInterface $provider): PersistenceService
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Connects to a data source.
     * @throws \InvalidArgumentException
     * @return void
     */
    public function connect()
    {
        $this->getProvider()->connect();
    }

    /**
     * Returns the last generated id.
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->getProvider()->getLastInsertId();
    }

    /**
     * Sets the connection info used to connect to the data source.
     * @param array $connectionInfo
     * @return ProviderInterface
     */
    public function setConnectionInfo(array $connectionInfo): ProviderInterface
    {
        return $this->getProvider()->setConnectionInfo($connectionInfo);
    }
}
