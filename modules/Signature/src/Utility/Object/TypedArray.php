<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Utility\Object;

/**
 * Class TypedArray
 * @package Signature\Utility\Object
 */
class TypedArray extends \ArrayObject
{
    /**
     * @var string
     */
    protected $scalarOrClassname = '';

    /**
     * Constructor. Sets the name of the classes or scalar types which can be added to this list.
     * @throws \InvalidArgumentException
     * @param string $scalarOrClassname
     */
    public function __construct($scalarOrClassname)
    {
        $scalarOrClassname = strtolower(trim($scalarOrClassname));

        if ($scalarOrClassname === 'stdclass') {
            throw new \InvalidArgumentException('stdClass is not allowed. Please use a specific classname or a scalar type.');
        }

        $this->scalarOrClassname = $scalarOrClassname;
    }

    /**
     * Sets a new object to the list.
     * @throws \InvalidArgumentException
     * @param integer $index
     * @param mixed   $newObject
     * @return void
     */
    public function offsetSet($index, $newObject)
    {
        if ($this->isElementValid($newObject)) {
            parent::offsetSet($index, $newObject);
        } else {
            throw new \InvalidArgumentException($this->getExceptionString('newObject', $newObject));
        }
    }

    /**
     * Returns the name of the class or the scalar name which can be added to this list.
     * @return string
     */
    public function getClassname()
    {
        return $this->scalarOrClassname;
    }

    /**
     * Adds a new object to the end of the list.
     * @throws \InvalidArgumentException
     * @param  mixed $object
     * @return void
     */
    public function append($object)
    {
        if ($this->isElementValid($object)) {
            parent::append($object);
        } else {
            throw new \InvalidArgumentException($this->getExceptionString('object', $object));
        }
    }

    /**
     * Creates a message for a exception.
     * @param  string $argumentName
     * @param  mixed  $object
     * @return string
     */
    private function getExceptionString($argumentName, $object)
    {
        return sprintf(
            'Argument $%s is not an instance of type &lt;%s&gt;. Given type was &lt;%s&gt;.',
            $argumentName,
            $this->getClassname(),
            gettype($object)
        );
    }

    /**
     * Checks, if a given object is valid.
     * @param  mixed $object
     * @return boolean
     */
    private function isElementValid($object)
    {
        switch ($this->getClassname()) {
            case 'boolean':
            case 'bool':
                return is_bool($object);

            case 'string':
                return is_string($object);

            case 'integer':
            case 'int':
                return is_int($object);

            case 'array':
                return is_array($object);

            case 'float':
                return is_float($object);

            default:
                return (is_object($object) && is_a($object, $this->getClassname()));
        }
    }
}
