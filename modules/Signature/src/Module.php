<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature;

/**
 * Class Module
 * @package Signature
 */
class Module extends \Signature\Module\AbstractModule
{
    use \Signature\Object\ObjectProviderServiceTrait;

    /**
     * @var string
     */
    protected $author = 'Sven Erens <sven@signature-framework.com>';

    /**
     * @var string
     */
    protected $copyright = 'Copyright &copy; 2014';

    /**
     * @var string
     */
    protected $version = '0.1 Alpha';

    /**
     * @var string
     */
    protected $description = 'A simple and fast MVC Framework for PHP 5.4.';

    /**
     * @var string
     */
    protected $url = 'http://www.signature-framework.com/';

    /**
     * Initializes this module.
     * @return boolean
     */
    public function init()
    {
        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            $this
                ->initializeRequestVariables($_REQUEST)
                ->initializeRequestVariables($_POST)
                ->initializeRequestVariables($_GET);
        }

        $this
            ->initializeErrorHandling()
            ->initializeObjectProviderService();

        return parent::init();
    }

    /**
     * Starts the module by giving control to the request handler.
     * @return boolean
     * @throws \RuntimeException
     */
    public function start()
    {
        /*
         * Initialize persistence service here, because an application module has to set
         * connection settings first.
         */
        $this->initializePersistenceService();

        if (null === ($response = $this->handleRequest())) {
            throw new \RuntimeException('The request could not be handled.');
        } else {
            echo $response->getContent();

            return true;
        }
    }

    /**
     * Returns the core configuration of the Signature module.
     * @return array
     */
    public function getConfig()
    {
        return [
            'Service' => [
                'Persistence' => [
                    'DefaultProviderClassname' => 'Signature\\Persistence\\Provider\\Pdo',
                    'ConnectionInfo'           => [
                        'Host'     => '',
                        'Username' => '',
                        'Password' => '',
                        'Database' => ''
                    ],
                ],
            ],
            'Mvc' => [
                'Controller' => [
                    'NoRouteFoundHandling' => [
                        'ControllerClassname' => 'Signature\\Mvc\\Controller\\ErrorController',
                        'ActionName'          => 'noRouteFound'
                    ]
                ],
                'View' => [
                    'DefaultViewClassname' => 'Signature\\Mvc\\View\\PhpView'
                ],
                'Routing' => [
                    'Matcher' => [
                        'Signature\\Mvc\\Routing\\Matcher\\DefaultMatcher' => [], // DefaultMatcher has no configuration
                        'Signature\\Mvc\\Routing\\Matcher\\UriMatcher'     => [
                            'Routes' => [
                                'about:config' => [
                                    'Uris'                => ['/about/config', '/about/config/'],
                                    'ControllerClassname' => 'Signature\\Mvc\\Controller\\AboutConfigController',
                                    'ActionName'          => 'index',
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Creates a request-object and handles it by passing it to the dispatcher.
     *
     * This is the main entry point of the framework.
     * @return \Signature\Mvc\ResponseInterface
     */
    protected function handleRequest()
    {
        $matcherConfig = $this->configurationService->getConfigByPath('Signature', 'Mvc.Routing.Matcher');

        /** @var \Signature\Mvc\Response $response */
        $response = $this->objectProviderService->create('Signature\\Mvc\\Response');

        /** @var \Signature\Mvc\Dispatcher $dispatcher */
        $dispatcher = $this->objectProviderService->create('Signature\\Mvc\\Dispatcher');

        /** @var \Signature\Mvc\Routing\Router $router */
        $router = $this->objectProviderService->create('Signature\\Mvc\\Routing\\Router', $matcherConfig);

        /** @var \Signature\Mvc\Request $request */
        $request = $this->objectProviderService->create('Signature\\Mvc\\Request');

        $request
            ->setRequestUri($_SERVER['REQUEST_URI'])
            ->setParameters(isset($_REQUEST) ? $_REQUEST : []);

        try {
            $router->match($request);
        } catch (\Signature\Mvc\Routing\Exception\NoRouteFoundException $e) {
            $fallback = $this->configurationService->getConfigByPath('Signature', 'Mvc.Controller.NoRouteFoundHandling');

            $request
                ->setControllerName($fallback['ControllerClassname'])
                ->setControllerActionName($fallback['ActionName']);
        }

        $dispatcher->dispatch($request, $response);

        return $response;
    }

    /**
     * Adds several services to the service provider service.
     * @return \Signature\Module\ModuleInterface
     */
    protected function initializeObjectProviderService()
    {
        $this->objectProviderService
            ->registerService('PersistenceService', 'Signature\\Persistence\\PersistenceService')
            ->registerService('LoggingService', 'Signature\\Logging\\LoggingService');

        return $this;
    }

    /**
     * Takes all request variables and removes slashes from them.
     * @param array $requestVariables
     * @return Module
     */
    protected function initializeRequestVariables(array &$requestVariables = [])
    {
        if (!$requestVariables)
            return $this;

        foreach ($requestVariables as $key => $value) {
            if (is_array($value)) {
                $this->initializeRequestVariables($requestVariables[$key]);
            } else {
                $requestVariables[$key] = stripslashes($value);
            }
        }

        return $this;
    }

    /**
     * Sets the errorreporting-level and sets up handlers for errors and exceptions.
     * @return Module
     */
    protected function initializeErrorHandling()
    {
        // Set the error reporting...
        error_reporting(E_ALL ^ E_DEPRECATED);

        // ... and set error- and exception andlers:
        set_error_handler(function ($errno, $errstr, $errfile, $errline, $context) {
            \Signature\Core\Error\DefaultErrorHandler::handleError($errno, $errstr, $errfile, $errline, $context);
        }, error_reporting());

        set_exception_handler(function ($e) {
            \Signature\Core\Error\DefaultExceptionHandler::handleException($e);
        });

        return $this;
    }

    /**
     * Initializes the persistence service, by passing some data to it.
     *
     * If configuration does not contain info about default provider, the persistence service will not be initialized.
     * @return void
     */
    protected function initializePersistenceService()
    {
        $connectionInfo
            = $this->configurationService->getConfigByPath('Signature', 'Service.Persistence.ConnectionInfo');

        // Don't try to connect to database, if no connection info has been set yet
        if (!is_array($connectionInfo))
            return;

        $providerClassname =
            $this->configurationService->getConfigByPath('Signature', 'Service.Persistence.DefaultProviderClassname');

        if (null !== $providerClassname) {
            $providerInstance = $this->objectProviderService->create($providerClassname);

            /**
             * As this module has been created before the object provider knew about the persistence service,
             * we must retrieve the service manually.
             * @var \Signature\Persistence\PersistenceService $persistenceService
             */
            $persistenceService = $this->objectProviderService->getService('PersistenceService');

            $persistenceService
                ->setProvider($providerInstance)
                ->setConnectionInfo($connectionInfo)
                ->connect();
        }
    }
}
