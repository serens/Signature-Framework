<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence\ActiveRecord;

/**
 * Interface ModelInterface
 * @package Signature\Persistence\ActiveRecord
 */
interface ModelInterface
{
    /**
     * Checks, if a given set of fields are available on this record model.
     * @param array $fields
     * @return boolean
     */
    public function hasFields(array $fields);

    /**
     * Checks, if a given field is available on this record model.
     * @param string $field
     * @return boolean
     */
    public function hasField($field);

    /**
     * Returns all values of this record model.
     * @return array
     */
    public function getFieldValues();

    /**
     * Sets multiple field values at once.
     *
     * After calling this method no more fields can be added to the model.
     * @param array $fieldValues
     * @throws \BadMethodCallException
     * @return ModelInterface
     */
    public function setFieldValues(array $fieldValues);

    /**
     * Returns all values of this record model.
     * @return array
     */
    public function toArray();

    /**
     * Returns the table name to which this record model belongs to.
     *
     * By default the full qualified classname is seperated by underscores and the last part of this will be taken as
     * the table name. This method must be overridden, when the standard-behavior is not wished.
     * @return string
     */
    public function getTableName();

    /**
     * Returns the primary id of this record model.
     * @return integer
     */
    public function getID();

    /**
     * Returns the value of the given field.
     * @param string $field
     * @throws Exception\InvalidFieldException
     * @return string
     */
    public function getFieldValue($field);

    /**
     * Returns the name of the field which represents the primary key of the record model.
     *
     * Override this method when the default value ("ID") is not wished.
     * @return string
     */
    public function getPrimaryKeyName();

    /**
     * Sets the value of a field.
     * @param string $field
     * @param mixed  $value
     * @throws Exception\InvalidFieldException
     * @return ModelInterface
     */
    public function setFieldValue($field, $value);

    /**
     * Creates a new row of this model.
     *
     * A new row is only created, if this model does not have a primary key id set.
     * @return ModelInterface
     */
    public function create();

    /**
     * Saves the current state of this model.
     * @throws Exception\InvalidRecordException
     * @return ModelInterface
     */
    public function save();

    /**
     * Deletes the row of this model.
     * @throws Exception\InvalidRecordException
     * @return void
     */
    public function delete();

    /**
     * Loads data into this model by fetching a row from the database using the primary key.
     * @param integer $id
     * @return boolean True, if the record could be loaded.
     */
    public function find($id);

    /**
     * Loads data into this model by fetching a row identified by $field.
     * @param string $field
     * @param string $value
     * @return \Signature\Persistence\ResultCollectionInterface
     */
    public function findByField($field, $value);

    /**
     * Finds records by a given sql-statement.
     * @param string $fields
     * @param string $where
     * @param string $orderBy
     * @param string $limit
     * @return \Signature\Persistence\ResultCollectionInterface
     */
    public function findByQuery($fields = '*', $where = '', $orderBy = '', $limit = '');

    /**
     * Loads all rows of the table.
     * @return \Signature\Persistence\ResultCollectionInterface
     */
    public function findAll();
}
