<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\ViewHelper;

/**
 * Class ViewHelperInterface
 * @package Signature\ViewHelper
 */
interface ViewHelperInterface
{
    /**
     * @return string
     */
    public function render();

    /**
     * @param array $arguments
     * @return ViewHelperInterface
     */
    public function setArguments(array $arguments = []);

    /**
     * @param \Signature\Mvc\View\ViewInterface $view
     * @return ViewHelperInterface
     */
    public function setView(\Signature\Mvc\View\ViewInterface $view);
}
