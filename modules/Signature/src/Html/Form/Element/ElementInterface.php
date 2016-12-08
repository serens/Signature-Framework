<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

use Signature\Html\Form\FormInterface;

/**
 * Interface ElementInterface
 * @package Signature\Html\Form\Element
 */
interface ElementInterface extends \Signature\Html\TagInterface
{
    /**
     * Sets the form this element belongs to.
     * @param FormInterface $form
     * @return ElementInterface
     */
    public function setForm(FormInterface $form): ElementInterface;

    /**
     * Returns the current form this element belongs to.
     * @return FormInterface
     */
    public function getForm(): FormInterface;

    /**
     * Sets the current value of the form element.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue(string $value): ElementInterface;

    /**
     * Returns the current value of the form element.
     * @return string
     */
    public function getValue(): string;
}
