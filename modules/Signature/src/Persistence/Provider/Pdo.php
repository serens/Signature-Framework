<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\Provider;

use Signature\Persistence\ResultCollection;
use Signature\Persistence\ResultCollectionInterface;

/**
 * Class Pdo
 * @package Signature\Persistence\Provider
 */
class Pdo implements ProviderInterface
{
    /**
     * @var \PDO
     */
    protected $pdo = null;

    /**
     * @var array
     */
    protected $connectionInfo = null;

    /**
     * @var array
     */
    protected $requiredConnectionInfoFields = ['Host', 'Username', 'Password', 'Database'];

    /**
     * Quotes a single string.
     * @param string $string
     * @return string
     */
    public function quote(string $string): string
    {
        return $this->pdo->quote($string);
    }

    /**
     * Executes a SQL-query and returns a Result collection.
     * @param string $queryString
     * @throws \RuntimeException If query could not be executed.
     * @return ResultCollectionInterface
     */
    public function query(string $queryString): ResultCollectionInterface
    {
        if (false === ($result = $this->pdo->query($queryString))) {
            $error = $this->pdo->errorInfo();

            throw new \RuntimeException('The query (' . htmlspecialchars($queryString) . ') contains an error: ' . $error[2]);
        }

        $items = $result->fetchAll(\PDO::FETCH_ASSOC);
        $result->closeCursor();

        return new ResultCollection($items);
    }

    /**
     * Returns the last generated id.
     * @return int
     */
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Connects to a data source.
     * @throws \UnexpectedValueException If no connection is set yet.
     * @throws \InvalidArgumentException
     * @throws \PDOException
     * @return void
     */
    public function connect()
    {
        if (null === $this->connectionInfo) {
            throw new \UnexpectedValueException('No connection information is set.');
        }

        // Do not connect if connection info is empty
        foreach ($this->requiredConnectionInfoFields as $requiredField) {
            if ((string) $this->connectionInfo[$requiredField] === '') {
                return;
            }
        }

        $this->pdo = new \PDO(sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8',
                $this->connectionInfo['Host'],
                $this->connectionInfo['Database']
            ),
            $this->connectionInfo['Username'],
            $this->connectionInfo['Password']
        );
    }

    /**
     * Sets the connection info used to connect to the data source.
     * @param array $connectionInfo
     * @throws \InvalidArgumentException If connection information is not valid.
     * @return ProviderInterface
     */
    public function setConnectionInfo(array $connectionInfo): ProviderInterface
    {
        foreach ($this->requiredConnectionInfoFields as $requiredField) {
            if (!array_key_exists($requiredField, $connectionInfo)) {
                throw new \InvalidArgumentException(
                    'Given connection information does not contain required field "' . $requiredField . '". ' .
                    'Given fields: ' . implode(', ', array_keys($connectionInfo)) . '.'
                );
            }
        }

        $this->connectionInfo = $connectionInfo;

        return $this;
    }
}
