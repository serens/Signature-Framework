<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\ViewHelper;

use Signature\ViewHelper\ArgumentDescription;

/**
 * Class AbstractViewHelper
 * @package Signature\ViewHelper
 */
abstract class AbstractViewHelper implements ViewHelperInterface
{
    /**
     * @var array<\Signature\ViewHelper\ArgumentDescription>
     */
    protected $argumentDescriptions = [];

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var \Signature\Mvc\View\Viewinterface
     */
    protected $view;

    /**
     * Validates each entry in $this->argumentDescriptions to ensure each element is lower case and
     * an argument description exists.
     */
    public function __construct()
    {
        $argumentDescriptionsSanitized = [];

        foreach ($this->argumentDescriptions as $argumentName => $description) {
            if (!$description instanceof ArgumentDescription) {
                $description = new ArgumentDescription(false);
            }

            $argumentDescriptionsSanitized[trim(strtolower($argumentName))] = $description;
        }

        $this->argumentDescriptions = $argumentDescriptionsSanitized;
    }

    /**
     * Sets the arguments for the viewhelper.
     *
     * Will also check if all required arguments are given and are of correct type.
     * @param array $arguments
     * @throws \InvalidArgumentException
     * @return ViewHelperInterface
     */
    public function setArguments(array $arguments = [])
    {
        $this->arguments = [];

        foreach ($arguments as $argument => $value) {
            $argument = trim(strtolower($argument));

            if (!array_key_exists($argument, $this->argumentDescriptions)) {
                throw new \InvalidArgumentException(sprintf(
                    'The argument "%s" is not registered on ViewHelper "%s". Valid arguments are %s.',
                    $argument,
                    get_class($this),
                    implode(', ', array_keys($this->argumentDescriptions))
                ));
            }

            $this->arguments[$argument] = $value;
        }

        $this->validateArguments();

        return $this;
    }

    /**
     * @param \Signature\Mvc\View\ViewInterface $view
     * @return ViewHelperInterface
     */
    public function setView(\Signature\Mvc\View\ViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Checks if a given argument exists in this view helper.
     * @param string $argument
     * @return boolean
     */
    protected function hasArgument($argument)
    {
        return array_key_exists(trim(strtolower($argument)), $this->arguments);
    }

    /**
     * Returns the value of a given argument of this view helper.
     * @param string $argument
     * @return mixed|null
     */
    protected function getArgument($argument)
    {
        $argument = trim(strtolower($argument));

        return $this->hasArgument($argument) ? $this->arguments[$argument] : null;
    }

    /**
     * Valdates all arguments.
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function validateArguments()
    {
        /** @var ArgumentDescription $description */
        foreach ($this->argumentDescriptions as $argument => $description) {
            $typeError     = false;
            $foundType     = '';
            $argumentValue = $this->getArgument($argument);

            // Check, if all required arguments have been set
            if ($description->isRequired() && !$this->hasArgument($argument)) {
                throw new \InvalidArgumentException(sprintf(
                    'Required argument "%s" missing in ViewHelper "%s".',
                    $argument,
                    get_class($this)
                ));
            }

            // Mixed arguments do not need further checks
            if ('mixed' === $description->getType()) {
                continue;
            }

            // Check, if all arguments have the required type
            if (null !== $argumentValue) {
                if ($description->mustBeScalarType() && gettype($argumentValue) != $description->getType()) {
                    $typeError = true;
                    $foundType = gettype($argumentValue);
                }

                if (!$description->mustBeScalarType() && get_class($argumentValue) != $description->getType()) {
                    $typeError = true;
                    $foundType = get_class($argumentValue);
                }

                if ($typeError) {
                    throw new \InvalidArgumentException(sprintf(
                        'Argument "%s" must be of type "%s", but "%s" given in ViewHelper "%s".',
                        $argument,
                        $description->getType(),
                        $foundType,
                        get_class($this)
                    ));
                }
            }
        }
    }

    /**
     * Returns the argument description of a given argument.
     * @param string $argument
     * @return ArgumentDescription
     */
    protected function getArgumentDescription($argument)
    {
        return $this->argumentDescriptions[strtolower(trim($argument))];
    }
}
