<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\View;

/**
 * Class PhpView
 * @package Signature\Mvc\View
 */
class PhpView implements ViewInterface
{
    /**
     * @var array
     */
    protected $viewData = [];

    /**
     * @var string
     */
    protected $templateFilename = '';

    /**
     * @var string
     */
    protected $layoutFilename = '';

    /**
     * Implemented magic method which creates an easier access to view-data in view-context.
     * @param string $varname
     * @return mixed
     */
    public function __get($varname)
    {
        return $this->getViewData($varname);
    }

    /**
     * Gets the view data.
     * @throws \OutOfRangeException
     * @param string $key
     * @return mixed
     */
    public function getViewData($key = null)
    {
        if (null === $key) {
            return $this->viewData;
        }

        if (array_key_exists($key, $this->viewData)) {
            return $this->viewData[$key];
        } else {
            throw new \OutOfRangeException(
                'This view does not contain a variable with the name "' . $key . '". ' .
                'Known variables are: "' . implode('", "', array_keys($this->viewData)) . '".'
            );
        }
    }

    /**
     * Sets view data.
     * @param mixed $data
     * @param mixed $value
     * @return \Signature\Mvc\View\ViewInterface
     */
    public function setViewData($data, $value = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->viewData[$key] = $value;
            }
        } else {
            $this->viewData[$data] = $value;
        }

        return $this;
    }

    /**
     * Renders the view.
     * @return string|null
     */
    public function render()
    {
        return $this->renderWith($this->getTemplate());
    }

    /**
     * Renders the view with the given template
     * @param string $templateFilename
     * @throws \Signature\Mvc\Exception\Exception If the assigned template cannot be found.
     * @return string|null
     */
    public function renderWith($templateFilename)
    {
        if ($template = $this->getTemplate()) {
            if (file_exists($template)) {
                ob_start();

                include $template;

                if (!$content = ob_get_contents()) {
                    $content = '';
                }

                ob_clean();

                if ($this->getLayout()) {
                    $layoutView = new \Signature\Mvc\View\PhpView();
                    $layoutView
                        ->setTemplate($this->getLayout())
                        ->setViewData('content', $content);

                    return $layoutView->render();
                } else {
                    return $content;
                }
            } else {
                throw new \Signature\Mvc\Exception\Exception(
                    'Assigned template "' . $template . '" cannot be loaded.'
                );
            }
        }

        return 'No template has been assigned to this view.';
    }

    /**
     * Returns the filename of the template with which the view should be rendered.
     * @return string
     */
    public function getTemplate()
    {
        return $this->templateFilename;
    }

    /**
     * Returns the active layout filename.
     * @return string
     */
    public function getLayout()
    {
        return $this->layoutFilename;
    }

    /**
     * Sets the template which should be used for rendering purposes.
     * @param string $templateFilename
     * @return \Signature\Mvc\View\ViewInterface
     */
    public function setTemplate($templateFilename)
    {
        $this->templateFilename = $templateFilename;

        return $this;
    }

    /**
     * Sets the layout-template which used be used to render.
     * @param string $layoutFilename
     * @return \Signature\Mvc\View\ViewInterface
     */
    public function setLayout($layoutFilename)
    {
        $this->layoutFilename = $layoutFilename;

        return $this;
    }

    /**
     * Includes a partial template within the currently rendered main template.
     * @param string $partialFilename
     * @return void
     */
    public function renderPartial($partialFilename)
    {
        if (file_exists($partialFilename)) {
            include $partialFilename;
        } else {
            echo 'Partial template [' . $partialFilename . '] cannot be loaded.';
        }
    }
}
