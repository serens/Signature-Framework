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
     * @var int
     */
    protected $iteratorPos = 0;

    /**
     * @var bool
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
     * @param  int $index
     * @throws \OutOfBoundsException If given index is out of bounds.
     * @return array|object
     */
    public function getElement(int $index)
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
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * Returns all items contained in this collection as an array.
     * @return array
     */
    public function toArray(): array
    {
        return $this->collection;
    }

    /**
     * Returns true, if current iteration position is on 1st item in collection.
     * @return bool
     */
    public function First(): bool
    {
        return ($this->Pos() == 1);
    }

    /**
     * Returns the current iteration index.
     * @return int
     */
    public function Pos(): int
    {
        return $this->iteratorPos + 1;
    }

    /**
     * Returns true, if current iteration position is set on the last item in this collection.
     * @return bool
     */
    public function Last(): bool
    {
        return ($this->Pos() == $this->count());
    }

    /**
     * Returns true, if current iteration position is odd.
     * @return bool
     */
    public function Odd(): bool
    {
        return !$this->Even();
    }

    /**
     * Returns true, if current iteration position is even.
     * @return bool
     */
    public function Even(): bool
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
     * @return array|object
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
    public function valid(): bool
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
     * @param string $modelClassname
     * @throws \InvalidArgumentException If argument $modelClassname does not implement ModelInterface.
     * @return ResultCollectionInterface
     */
    public function convertToModels(string $modelClassname): ResultCollectionInterface
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
