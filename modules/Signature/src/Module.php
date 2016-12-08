<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature;

use Signature\Core\Error\DefaultExceptionHandler;
use Signature\Logging\LoggingService;
use Signature\Module\ModuleInterface;
use Signature\Mvc\Controller\AboutConfigController;
use Signature\Mvc\Controller\ErrorController;
use Signature\Mvc\Dispatcher;
use Signature\Mvc\Request;
use Signature\Mvc\Response;
use Signature\Mvc\ResponseInterface;
use Signature\Mvc\Routing\Exception\NoRouteFoundException;
use Signature\Mvc\Routing\Router;
use Signature\Mvc\View\PhpView;
use Signature\Persistence\PersistenceService;
use Signature\Persistence\Provider\Pdo;

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
    protected $version = '0.2 Alpha';

    /**
     * @var string
     */
    protected $description = 'A simple and fast MVC Framework for PHP 7.0.';

    /**
     * @var string
     */
    protected $url = 'http://www.signature-framework.com/';

    /**
     * Initializes this module.
     * @return bool
     */
    public function init(): bool
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
     * @return bool
     * @throws \RuntimeException
     */
    public function start(): bool
    {
        /*
         * Initialize persistence service here, because an application module has to set
         * connection settings first.
         */
        $this->initializePersistenceService();

        if (null === ($response = $this->handleRequest())) {
            throw new \RuntimeException('The request could not be handled.');
        } else {
            $response->output();

            return true;
        }
    }

    /**
     * Returns the core configuration of the Signature module.
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'Service' => [
                'Persistence' => [
                    'DefaultProviderClassname' => Pdo::class,
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
                        'ControllerClassname' => ErrorController::class,
                        'ActionName'          => 'noRouteFound'
                    ]
                ],
                'View' => [
                    'DefaultViewClassname' => PhpView::class
                ],
                'Routing' => [
                    'Matcher' => [
                        'Signature\\Mvc\\Routing\\Matcher\\DefaultMatcher' => [], // DefaultMatcher has no configuration
                        'Signature\\Mvc\\Routing\\Matcher\\UriMatcher'     => [
                            'Routes' => [
                                'about:config' => [
                                    'Uris'                => ['/about/config', '/about/config/'],
                                    'ControllerClassname' => AboutConfigController::class,
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
     * @return ResponseInterface
     */
    protected function handleRequest(): ResponseInterface
    {
        $matcherConfig = $this->configurationService->getConfigByPath('Signature', 'Mvc.Routing.Matcher');

        /** @var Response $response */
        $response = $this->objectProviderService->create(Response::class);

        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->objectProviderService->create(Dispatcher::class);

        /** @var Router $router */
        $router = $this->objectProviderService->create(Router::class, $matcherConfig);

        /** @var Request $request */
        $request = $this->objectProviderService->create(Request::class);

        $request
            ->setRequestUri($_SERVER['REQUEST_URI'])
            ->setParameters(isset($_REQUEST) ? $_REQUEST : []);

        try {
            $router->match($request);
        } catch (NoRouteFoundException $e) {
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
     * @return ModuleInterface
     */
    protected function initializeObjectProviderService(): ModuleInterface
    {
        $this->objectProviderService
            ->registerService('PersistenceService', PersistenceService::class)
            ->registerService('LoggingService', LoggingService::class);

        return $this;
    }

    /**
     * Takes all request variables and removes slashes from them.
     * @param array $requestVariables
     * @return Module
     */
    protected function initializeRequestVariables(array &$requestVariables = []): Module
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

        set_exception_handler(function ($t) {
            DefaultExceptionHandler::handleException($t);
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
             * @var PersistenceService $persistenceService
             */
            $persistenceService = $this->objectProviderService->getService('PersistenceService');

            $persistenceService
                ->setProvider($providerInstance)
                ->setConnectionInfo($connectionInfo)
                ->connect();
        }
    }
}
