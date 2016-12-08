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
    public function renderWith(string $templateFilename);

    /**
     * Returns the filename of the template with which the view should be rendered.
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Sets the template which should be used for rendering purposes.
     * @param string $templateFilename
     * @return ViewInterface
     */
    public function setTemplate(string $templateFilename): ViewInterface;

    /**
     * Sets view data.
     * @param mixed $data
     * @param mixed $value
     * @return ViewInterface
     */
    public function setViewData($data, $value = null): ViewInterface;

    /**
     * Checks if the given view data exists.
     * @param string $key
     * @return bool
     */
    public function hasViewData(string $key): bool;

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
     * @return ViewInterface
     */
    public function setLayout(string $layoutFilename): ViewInterface;

    /**
     * Returns the active layout filename.
     * @return string
     */
    public function getLayout(): string;

    /**
     * Includes a partial template within the currently rendered main template.
     * @param string $partialFilename
     * @return void
     */
    public function renderPartial(string $partialFilename);
}
