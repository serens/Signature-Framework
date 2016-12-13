<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\ActiveRecord;

use Signature\Persistence\ResultCollectionInterface;

/**
 * Class AbstractModel
 * @package Signature\Persistence\ActiveRecord
 */
abstract class AbstractModel implements ModelInterface
{
    use \Signature\Persistence\PersistenceServiceTrait;

    /**
     * @var array
     */
    protected $fieldValues = [];

    /**
     * @var string
     */
    protected $tableName = '';

    /**
     * @var string
     */
    protected $primaryKeyName = 'ID';

    /**
     * Sets the fields of this record object.
     * @param array $fieldValues
     */
    public function __construct(array $fieldValues = null)
    {
        if (null !== $fieldValues) {
            $this->setFieldValues($fieldValues);
        }

        if ('' === $this->tableName) {
            $this->tableName = $this->determineTablenameFromClassname(get_class($this));
        }
    }

    /**
     * Returns the tablename in which the data of this model is stored.
     * @param string $className
     * @return string
     */
    protected function determineTablenameFromClassname(string $className): string
    {
        // Get rid of namespaces and underscores and just take the last part of the classname.
        $classname  = str_replace('\\', '_', $className);
        $classParts = explode('_', $classname);
        $classname  = array_pop($classParts);

        return strtolower($classname);
    }

    /**
     * Checks, if a given set of fields are available on this record model.
     * @param array $fields
     * @return bool
     */
    public function hasFields(array $fields): bool
    {
        foreach ($fields as $field) {
            if (!$this->hasField($field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks, if a given field is available on this record model.
     * @param string $field
     * @return bool
     */
    public function hasField(string $field): bool
    {
        return array_key_exists($field, $this->fieldValues);
    }

    /**
     * Returns all values of this record model.
     * @return array
     */
    public function getFieldValues(): array
    {
        return $this->toArray();
    }

    /**
     * Sets multiple field values at once.
     * @param array $fieldValues
     * @return ModelInterface
     */
    public function setFieldValues(array $fieldValues): ModelInterface
    {
        foreach ($fieldValues as $field => $value) {
            $this->setFieldValue($field, $value);
        }

        return $this;
    }

    /**
     * Returns all values of this record model.
     * @return array
     */
    public function toArray(): array
    {
        return $this->fieldValues;
    }

    /**
     * Sets the value of a field.
     * @param string $field
     * @param mixed $value
     * @return ModelInterface
     */
    public function setFieldValue(string $field, $value): ModelInterface
    {
        if (method_exists($this, $setter = 'set' . ucfirst(strtolower($field)))) {
            $this->$setter($value);
        } else {
            $this->fieldValues[$field] = $value;
        }

        return $this;
    }

    /**
     * Deletes the row of this model.
     * @throws Exception\InvalidRecordException If no primary key exists for this model.
     * @return void
     */
    public function delete()
    {
        if (!$this->getID()) {
            throw new Exception\InvalidRecordException();
        }

        $query = sprintf(
            'DELETE FROM %s WHERE %s = %s LIMIT 1',
            $this->persistenceService->backquote($this->getTableName()),
            $this->persistenceService->backquote($this->getPrimaryKeyName()),
            $this->persistenceService->quote($this->getID())
        );

        $this->persistenceService->query($query);
    }

    /**
     * Returns the primary id of this record model.
     * @return int
     */
    public function getID(): int
    {
        return (int) $this->getFieldValue($this->getPrimaryKeyName());
    }

    /**
     * Returns the value of the given field.
     * @param string $field
     * @throws Exception\InvalidFieldException
     * @return string|null
     */
    public function getFieldValue(string $field)
    {
        if ($this->hasField($field)) {
            return $this->fieldValues[$field];
        }

        throw new Exception\InvalidFieldException($field);
    }

    /**
     * Returns the name of the field which represents the primary key of the record model.
     *
     * Override this method when the default value ("ID") is not wished.
     * @return string
     */
    public function getPrimaryKeyName(): string
    {
        return $this->primaryKeyName;
    }

    /**
     * Returns the table name to which this record model belongs to.
     *
     * By default the full qualified classname is seperated by underscores and the last part of this will be taken as
     * the table name. This method must be overridden, when the standard-behavior is not wished.
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Creates a new row of this model.
     *
     * A new row is only created, if this model does not have a primary key id set.
     * @return ModelInterface
     */
    public function create(): ModelInterface
    {
        if ($this->hasField($this->getPrimaryKeyName()) && $this->getID()) {
            return $this;
        }

        $fields = [];
        $values = [];

        foreach ($this->getFieldValues() as $field => $value) {
            if ($field == $this->getPrimaryKeyName()) {
                continue;
            }

            $fields[] = $this->persistenceService->backquote($field);
            $values[] = is_null($value) ? 'NULL' : $this->persistenceService->quote($value);
        }

        $this->persistenceService->query(sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->persistenceService->backquote($this->getTableName()),
            implode(',', $fields),
            implode(',', $values)
        ));

        $this->setFieldValue($this->getPrimaryKeyName(), $this->persistenceService->getLastInsertId());

        return $this;
    }

    /**
     * Saves the current state of this model.
     * @throws Exception\InvalidRecordException
     * @return ModelInterface
     */
    public function save(): ModelInterface
    {
        if (!$this->getID()) {
            throw new Exception\InvalidRecordException();
        }

        $fieldValues = [];

        foreach ($this->getFieldValues() as $field => $value) {
            if ($field == $this->getPrimaryKeyName()) {
                continue;
            }

            $value         = is_null($value) ? 'NULL' : $this->persistenceService->quote($value);
            $fieldValues[] = sprintf('%s = %s', $this->persistenceService->backquote($field), $value);
        }

        $this->persistenceService->query(sprintf(
            'UPDATE %s SET %s WHERE %s = %s LIMIT 1',
            $this->persistenceService->backquote($this->getTableName()),
            implode(',', $fieldValues),
            $this->persistenceService->backquote($this->getPrimaryKeyName()),
            $this->persistenceService->quote($this->getID())
        ));

        return $this;
    }

    /**
     * Loads data into this model by fetching a row from the database using the primary key.
     * @param int $id
     * @return bool True, if the record could be loaded.
     */
    public function find(int $id): bool
    {
        if (($result = $this->findByField($this->getPrimaryKeyName(), $id)) && $result->count()) {
            $this->setFieldValues($result->getFirst()->getFieldValues());

            return true;
        }

        return false;
    }

    /**
     * Loads data into this model by fetching a row identified by $field.
     * @param string $field
     * @param string $value
     * @return ResultCollectionInterface
     */
    public function findByField(string $field, string $value): ResultCollectionInterface
    {
        $where = sprintf(
            '%s = %s',
            $this->persistenceService->backquote($field),
            $this->persistenceService->quote($value)
        );

        return $this->findByQuery('*', $where);
    }

    /**
     * Finds records by a given sql-statement.
     * @param string $fields
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @return ResultCollectionInterface
     */
    public function findByQuery(string $fields = '*', string $where = '', string $orderBy = '', string $limit = ''): ResultCollectionInterface
    {
        if ('' !== $where) {
            $where = 'WHERE ' . $where;
        }

        if ('' !== $orderBy) {
            $orderBy = 'ORDER BY ' . $orderBy;
        }

        if ('' !== $limit) {
            $limit = 'LIMIT ' . $limit;
        }

        $result = $this->persistenceService->query(sprintf(
            'SELECT %s FROM %s %s %s %s',
            $fields,
            $this->persistenceService->backquote($this->getTableName()),
            $where,
            $orderBy,
            $limit
        ));

        return $result->convertToModels(get_class($this));
    }

    /**
     * Loads all rows of the table.
     * @return ResultCollectionInterface
     */
    public function findAll(): ResultCollectionInterface
    {
        return $this->findByQuery();
    }
}
