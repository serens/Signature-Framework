<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\ActiveRecord;

use Signature\Persistence\ResultCollectionInterface;

/**
 * Interface RecordInterface
 * @package Signature\Persistence\ActiveRecord
 */
interface RecordInterface
{
    /**
     * Checks, if a given set of fields are available on this record.
     * @param array $fields
     * @return bool
     */
    public function hasFields(array $fields): bool;

    /**
     * Checks, if a given field is available on this record.
     * @param string $field
     * @return bool
     */
    public function hasField(string $field): bool;

    /**
     * Returns all values of this record.
     * @return array
     */
    public function getFieldValues(): array;

    /**
     * Sets multiple field values at once.
     * @param array $fieldValues
     * @throws \BadMethodCallException
     * @return RecordInterface
     */
    public function setFieldValues(array $fieldValues): RecordInterface;

    /**
     * Returns all values of this record.
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the table name to which this record belongs to.
     *
     * By default the full qualified classname is seperated by underscores and the last part of this will be taken as
     * the table name. This method must be overridden, when the standard-behavior is not wished.
     * @return string
     */
    public function getTableName(): string;

    /**
     * Returns the primary id of this record.
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
     * Returns the name of the field which represents the primary key of the record.
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
     * @return RecordInterface
     */
    public function setFieldValue(string $field, $value): RecordInterface;

    /**
     * Creates a new row of this record.
     *
     * A new row is only created, if this record does not have a primary key id set.
     * @return RecordInterface
     */
    public function create(): RecordInterface;

    /**
     * Saves the current state of this record.
     * @throws Exception\InvalidRecordException
     * @return RecordInterface
     */
    public function save(): RecordInterface;

    /**
     * Deletes the row of this record.
     * @throws Exception\InvalidRecordException
     * @return void
     */
    public function delete();

    /**
     * Loads data into this record by fetching a row from the database using the primary key.
     * @param int $id
     * @return bool True, if the record could be loaded.
     */
    public function load(int $id): bool;

    /**
     * Finds a record by the given id.
     * @param int $id
     * @return RecordInterface|null
     */
    public static function find(int $id);

    /**
     * Loads data into this record by fetching a row identified by $field.
     * @param string $field
     * @param string $value
     * @return ResultCollectionInterface
     */
    public static function findByField(string $field, string $value): ResultCollectionInterface;

    /**
     * Finds records by a given sql-statement.
     * @param string $fields
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @return ResultCollectionInterface
     */
    public static function findByQuery(string $fields = '*', string $where = '', string $orderBy = '', string $limit = ''): ResultCollectionInterface;

    /**
     * Loads all rows of the table.
     * @return ResultCollectionInterface
     */
    public static function findAll(): ResultCollectionInterface;
}
