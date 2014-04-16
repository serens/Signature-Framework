<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\View;

/**
 * Class ViewInterface
 * @package Signature\Mvc\View
 */
interface ViewInterface
{
    /**
     * Renders the view.
     * @return string|null
     */
    public function render();

    /**
     * Renders the view with the give template
     * @param string $templateFilename
     * @return string|null
     */
    public function renderWith($templateFilename);

    /**
     * Returns the filename of the template with which the view should be rendered.
     * @return string
     */
    public function getTemplate();

    /**
     * Sets the template which should be used for rendering purposes.
     * @param string $templateFilename
     * @return \Signature\Mvc\View\ViewInterface
     */
    public function setTemplate($templateFilename);

    /**
     * Sets view data.
     * @param mixed $data
     * @param mixed $value
     * @return \Signature\Mvc\View\ViewInterface
     */
    public function setViewData($data, $value = null);

    /**
     * Gets the view data.
     * @throws \OutOfRangeException
     * @param string $key
     * @return mixed
     */
    public function getViewData($key = null);

    /**
     * Sets the layout-template which used be used to render.
     * @param string $layoutFilename
     * @return \Signature\Mvc\View\ViewInterface
     */
    public function setLayout($layoutFilename);

    /**
     * Returns the active layout filename.
     * @return string
     */
    public function getLayout();

    /**
     * Includes a partial template within the currently rendered main template.
     * @param string $partialFilename
     * @return void
     */
    public function renderPartial($partialFilename);
}
