<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence;

/**
 * Interface ResultCollectionInterface
 * @package Signature\Persistence\Provider
 */
interface ResultCollectionInterface extends \Iterator, \Countable
{
    /**
     * Retrives the first element of this collection.
     * @return array|object
     */
    public function getFirst();

    /**
     * Retrieves the last element of this collection.
     * @return array|object
     */
    public function getLast();

    /**
     * Returns a sinle record from this collection.
     * @param  integer $index
     * @throws \OutOfBoundsException If given index is out of bounds.
     * @return array|object
     */
    public function getElement($index);

    /**
     * Returns an array representation of this collecion.
     * @return array
     */
    public function toArray();

    /**
     * Converts the items in this collection to models.
     * @param $modelClassname
     * @throws \InvalidArgumentException
     * @return ResultCollectionInterface
     */
    public function convertToModels($modelClassname);
}
