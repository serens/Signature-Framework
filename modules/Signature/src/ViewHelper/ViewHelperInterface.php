<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\ViewHelper;

use Signature\Mvc\View\ViewInterface;

/**
 * Class ViewHelperInterface
 * @package Signature\ViewHelper
 */
interface ViewHelperInterface
{
    /**
     * @return string
     */
    public function render(): string;

    /**
     * @param array $arguments
     * @return ViewHelperInterface
     */
    public function setArguments(array $arguments = []): ViewHelperInterface;

    /**
     * @param ViewInterface $view
     * @return ViewHelperInterface
     */
    public function setView(ViewInterface $view): ViewHelperInterface;
}
