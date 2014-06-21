<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Persistence;

/**
 * Class ResultCollection
 * @package Signature\Persistence
 */
class ResultCollection implements \Signature\Persistence\ResultCollectionInterface
{
    /**
     * @var array
     */
    protected $collection = [];

    /**
     * @var integer
     */
    protected $iteratorPos = 0;

    /**
     * @var boolean
     */
    protected $convertedToModels = false;

    /**
     * Sets the elements in this collection.
     * @param array $tableRecords
     */
    public function __construct(array $tableRecords = [])
    {
        $this->collection = $tableRecords;
    }

    /**
     * Retrieves the first element in this collection.
     * @return array|object
     */
    public function getFirst()
    {
        return $this->getElement(0);
    }

    /**
     * Returns a sinle record from this collection.
     * @param  integer $index
     * @throws \OutOfBoundsException If given index is out of bounds.
     * @return array|object
     */
    public function getElement($index)
    {
        if ($index < 0 || $index > $this->count() - 1) {
            throw new \OutOfBoundsException('Index [' . $index . '] out of valid boundaries.');
        }

        return $this->collection[$index];
    }

    /**
     * Retrieves the last element in this collection.
     * @return array|object
     */
    public function getLast()
    {
        return $this->getElement($this->count() - 1);
    }

    /**
     * Returns the length of this collection.
     * @return integer
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * Returns all items contained in this collection as an array.
     * @return array
     */
    public function toArray()
    {
        return $this->collection;
    }

    /**
     * Returns true, if current iteration position is on 1st item in collection.
     * @return boolean
     */
    public function First()
    {
        return ($this->Pos() == 1);
    }

    /**
     * Returns the current iteration index.
     * @return integer
     */
    public function Pos()
    {
        return $this->iteratorPos + 1;
    }

    /**
     * Returns true, if current iteration position is set on the last item in this collection.
     * @return boolean
     */
    public function Last()
    {
        return ($this->Pos() == $this->count());
    }

    /**
     * Returns true, if current iteration position is odd.
     * @return boolean
     */
    public function Odd()
    {
        return !$this->Even();
    }

    /**
     * Returns true, if current iteration position is even.
     * @return boolean
     */
    public function Even()
    {
        return (($this->iteratorPos + 1) % 2 == 0);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        return $this->prepareItem(reset($this->collection));
    }

    /**
     * Sets the current iteration index of the collection.
     * @param array $item
     * @return array
     */
    private function prepareItem($item)
    {
        $this->iteratorPos = key($this->collection);

        return $item;
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::key()
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::next()
     */
    public function next()
    {
        return $this->prepareItem(next($this->collection));
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::current()
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Converts the items in this collection to models.
     * @param $modelClassname
     * @throws \InvalidArgumentException If argument $modelClassname does not implement ModelInterface.
     * @return ResultCollectionInterface
     */
    public function convertToModels($modelClassname)
    {
        if (!$this->count() || $this->convertedToModels) {
            return $this;
        }

        $objectProviderService = \Signature\Object\ObjectProviderService::getInstance();

        foreach ($this->collection as $key => $item) {
            /** @var \Signature\Persistence\ActiveRecord\AbstractModel $model */
            $model = $objectProviderService->create($modelClassname);

            if (!$model instanceof \Signature\Persistence\ActiveRecord\ModelInterface) {
                throw new \InvalidArgumentException(sprintf(
                    'Provided classname "%s" does not implement \Signature\Persistence\ActiveRecord\ModelInterface.',
                    $modelClassname
                ));
            }

            $this->collection[$key] = $model->setFieldValues($item);
        }

        $this->convertedToModels = true;

        return $this;
    }
}
