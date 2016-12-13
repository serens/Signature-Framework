<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\ActiveRecord;

use Signature\Persistence\ResultCollectionInterface;

/**
 * Interface ModelInterface
 * @package Signature\Persistence\ActiveRecord
 */
interface ModelInterface
{
    /**
     * Checks, if a given set of fields are available on this record model.
     * @param array $fields
     * @return bool
     */
    public function hasFields(array $fields): bool;

    /**
     * Checks, if a given field is available on this record model.
     * @param string $field
     * @return bool
     */
    public function hasField(string $field): bool;

    /**
     * Returns all values of this record model.
     * @return array
     */
    public function getFieldValues(): array;

    /**
     * Sets multiple field values at once.
     *
     * After calling this method no more fields can be added to the model.
     * @param array $fieldValues
     * @throws \BadMethodCallException
     * @return ModelInterface
     */
    public function setFieldValues(array $fieldValues): ModelInterface;

    /**
     * Returns all values of this record model.
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the table name to which this record model belongs to.
     *
     * By default the full qualified classname is seperated by underscores and the last part of this will be taken as
     * the table name. This method must be overridden, when the standard-behavior is not wished.
     * @return string
     */
    public function getTableName(): string;

    /**
     * Returns the primary id of this record model.
     * @return int
     */
    public function getID(): int;

    /**
     * Returns the value of the given field.
     * @param string $field
     * @throws Exception\InvalidFieldException
     * @return string|null
     */
    public function getFieldValue(string $field);

    /**
     * Returns the name of the field which represents the primary key of the record model.
     *
     * Override this method when the default value ("ID") is not wished.
     * @return string
     */
    public function getPrimaryKeyName(): string;

    /**
     * Sets the value of a field.
     * @param string $field
     * @param mixed $value
     * @throws Exception\InvalidFieldException
     * @return ModelInterface
     */
    public function setFieldValue(string $field, $value): ModelInterface;

    /**
     * Creates a new row of this model.
     *
     * A new row is only created, if this model does not have a primary key id set.
     * @return ModelInterface
     */
    public function create(): ModelInterface;

    /**
     * Saves the current state of this model.
     * @throws Exception\InvalidRecordException
     * @return ModelInterface
     */
    public function save(): ModelInterface;

    /**
     * Deletes the row of this model.
     * @throws Exception\InvalidRecordException
     * @return void
     */
    public function delete();

    /**
     * Loads data into this model by fetching a row from the database using the primary key.
     * @param int $id
     * @return bool True, if the record could be loaded.
     */
    public function find(int $id): bool;

    /**
     * Loads data into this model by fetching a row identified by $field.
     * @param string $field
     * @param string $value
     * @return ResultCollectionInterface
     */
    public function findByField(string $field, string $value): ResultCollectionInterface;

    /**
     * Finds records by a given sql-statement.
     * @param string $fields
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @return ResultCollectionInterface
     */
    public function findByQuery(string $fields = '*', string $where = '', string $orderBy = '', string $limit = ''): ResultCollectionInterface;

    /**
     * Loads all rows of the table.
     * @return ResultCollectionInterface
     */
    public function findAll(): ResultCollectionInterface;
}
