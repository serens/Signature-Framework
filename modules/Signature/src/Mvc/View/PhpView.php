<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\Mvc\View;

use Signature\Mvc\Exception\Exception;
use Signature\Object\ObjectProviderService;
use Signature\ViewHelper\ViewHelperInterface;

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
     * @var array
     */
    protected $viewhelperInstanceContainer = [];

    /**
     * Constructor.
     * @param string $template
     * @param array $viewData
     */
    public function __construct($template = '', array $viewData = [])
    {
        if ('' !== $template) {
            $this->setTemplate($template);
        }

        if ($viewData) {
            $this->setViewData($viewData);
        }
    }

    /**
     * Implemented magic method which creates an easier access to view-data in view-context.
     * @param string $varname
     * @return mixed
     */
    public function __get(string $varname)
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

        if ($this->hasViewData($key)) {
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
     * @return ViewInterface
     */
    public function setViewData($data, $value = null): ViewInterface
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
     * Checks if the given view data exists.
     * @param string $key
     * @return bool
     */
    public function hasViewData(string $key): bool
    {
        return array_key_exists($key, $this->viewData);
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
     * @throws Exception If the assigned template cannot be found.
     * @return string|null
     */
    public function renderWith(string $templateFilename)
    {
        if ($templateFilename) {
            if (file_exists($templateFilename)) {
                ob_start();

                include $templateFilename;

                if (!$content = ob_get_clean()) {
                    $content = '';
                }

                if ($this->getLayout()) {
                    return
                        (new PhpView())
                            ->setTemplate($this->getLayout())
                            ->setViewData($this->getViewData())
                            ->setViewData('content', $content)
                            ->render();
                } else {
                    return $content;
                }
            } else {
                throw new Exception('Assigned template "' . $templateFilename . '" cannot be loaded.');
            }
        }

        return 'No template has been assigned to this view.';
    }

    /**
     * Returns the filename of the template with which the view should be rendered.
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->templateFilename;
    }

    /**
     * Returns the active layout filename.
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layoutFilename;
    }

    /**
     * Sets the template which should be used for rendering purposes.
     * @param string $templateFilename
     * @return ViewInterface
     */
    public function setTemplate(string $templateFilename): ViewInterface
    {
        $this->templateFilename = $templateFilename;

        return $this;
    }

    /**
     * Sets the layout-template which used be used to render.
     * @param string $layoutFilename
     * @return ViewInterface
     */
    public function setLayout(string $layoutFilename): ViewInterface
    {
        $this->layoutFilename = $layoutFilename;

        return $this;
    }

    /**
     * Renders information of the current view.
     * @return string
     */
    public function debug(): string
    {
        $debug = '';
        $info  = [
            'View' => [
                'Class' => get_class($this),
                'View template' => $this->getTemplate(),
                'Layout' => $this->getLayout(),
            ],
        ];

        $info['View variables'] = $this->getViewData();

        foreach ($info as $title => $data) {
            $debug .= ('<h2>' . $title . '</h2>');
            $debug .= '<dl>';

            foreach ($data as $key => $value) {
                $debug .= ('<dt>' . $key . '</dt>');
                $debug .= ('<dd>' . (is_object($value) ? ('Object: ' . get_class($value)) : $value) . '</dd>');
            }

            $debug .= '</dl>';
        }

        return $debug;
    }

    /**
     * Includes a partial template within the currently rendered main template.
     * @param string $partialFilename
     * @param array $additionalViewData
     * @return string
     */
    public function renderPartial(string $partialFilename, array $additionalViewData = []): string
    {
        if (file_exists($partialFilename)) {
            return
                (new PhpView())
                    ->setTemplate($partialFilename)
                    ->setViewData(array_merge($this->getViewData(), $additionalViewData))
                    ->render();
        }

        return 'Partial template [' . $partialFilename . '] cannot be loaded.';
    }

    /**
     * Renders the given viewhelper with the given arguments.
     * @param string $viewhelperClassname
     * @param array $arguments
     * @return string
     */
    public function viewhelper(string $viewhelperClassname, array $arguments = []): string
    {
        if ($viewhelper = $this->getViewHelperInstance($viewhelperClassname)) {
            $viewhelper->setArguments($arguments);
            return $viewhelper->render();
        }

        return '';
    }

    /**
     * Creates an instance of a viewhelper by a given classname.
     *
     * Viewhelper can be found in two places. 1st: Signature, 2nd: Module. When using a Signature viewhelper, there
     * is no need of a fully qualified namespace. In both cases the namespace-part "ViewHelper" can be ignored.
     * This will result in a shorter classname. But, if you want, you can still use the fully qualified namespace.
     *
     * Examples of viewhelper classnames:
     *  - Signature built in: \Signature\Format\Crop
     *  - Module provied: \MyModule\Format\Date
     *
     * The created instance will be cached.
     * @param string $viewhelperClassname
     * @throws \UnexpectedValueException If the viewhelper is not well implemented
     * @return ViewHelperInterface
     */
    public function getViewHelperInstance(string $viewhelperClassname): ViewHelperInterface
    {
        if ('\\' !== $viewhelperClassname[0]) {
            $viewhelperClassname = '\\' . $viewhelperClassname;
        }

        $namespaceParts = explode('\\', $viewhelperClassname);

        if ('ViewHelper' !== $namespaceParts[2]) {
            array_splice($namespaceParts, 2, 0, 'ViewHelper');
        }

        $newViewhelperClassname = implode('\\', $namespaceParts) . 'ViewHelper';

        if (array_key_exists($newViewhelperClassname, $this->viewhelperInstanceContainer)) {
            return $this->viewhelperInstanceContainer[$newViewhelperClassname];
        }

        $objectProviderService  = ObjectProviderService::getInstance();
        $viewhelperInstance     = $objectProviderService->get($newViewhelperClassname);

        if (!$viewhelperInstance instanceof ViewHelperInterface) {
            throw new \UnexpectedValueException(sprintf(
                'Invalid viewhelper. Viewhelper "%s" must implement \Signature\ViewHelper\ViewHelperInterface.',
                $newViewhelperClassname
            ));
        }

        $this->viewhelperInstanceContainer[$newViewhelperClassname] = $viewhelperInstance;

        return $viewhelperInstance;
    }
}
