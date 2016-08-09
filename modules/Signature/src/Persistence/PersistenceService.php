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
     * @param  string $string
     * @return string
     */
    public function backquote($string)
    {
        return '`' . $string . '`';
    }

    /**
     * Quotes a given string.
     * @param  string $string
     * @return string
     */
    public function quote($string)
    {
        return "'" . $string . "'";
    }

    /**
     * Executes a SQL-query and returns a Result collection.
     * @param string $queryString
     * @return ResultCollectionInterface
     */
    public function query($queryString)
    {
        return $this->getProvider()->query($queryString);
    }

    /**
     * Returns the current configured persistence provider.
     * @return ProviderInterface
     * @throws \UnexpectedValueException
     */
    public function getProvider()
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
    public function setProvider(ProviderInterface $provider)
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
     * @return integer
     */
    public function getLastInsertId()
    {
        return $this->getProvider()->getLastInsertId();
    }

    /**
     * Sets the connection info used to connect to the data source.
     * @param array $connectionInfo
     * @return PersistenceService
     */
    public function setConnectionInfo(array $connectionInfo)
    {
        $this->getProvider()->setConnectionInfo($connectionInfo);

        return $this;
    }
}
