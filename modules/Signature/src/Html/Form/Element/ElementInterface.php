<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Html\Form\Element;

/**
 * Interface ElementInterface
 * @package Signature\Html\Form\Element
 */
interface ElementInterface extends \Signature\Html\TagInterface
{
    /**
     * Sets the form this element belongs to.
     * @param \Signature\Html\Form\FormInterface $form
     * @return ElementInterface
     */
    public function setForm(\Signature\Html\Form\FormInterface $form);

    /**
     * Returns the current form this element belongs to.
     * @return \Signature\Html\Form\FormInterface
     */
    public function getForm();

    /**
     * Sets the current value of the form element.
     * @param string $value
     * @return ElementInterface
     */
    public function setValue($value);

    /**
     * Returns the current value of the form element.
     * @return string
     */
    public function getValue();
}
