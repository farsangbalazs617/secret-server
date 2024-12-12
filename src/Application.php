<?php declare(strict_types=1);

namespace SecretServer;

use Slim\Factory\AppFactory;
use Slim\App;

use SecretServer\Services\Config;

/**
 * The main application class that manages the Slim application instance and initializes the routes.
 * 
 * This class follows the Singleton pattern to ensure there is only one instance of the Application class.
 * It is responsible for creating and running the Slim application, as well as defining the API routes.
 * 
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */
final class Application
{

    /**
     * Stores the singleton instance of the App class.
     */
    private static Application $instance;

    /**
     * Stores the singleton instance of the App class.
     */
    private static ?App $SlimApp = null;

    /**
     * DO NOT instanciate directly.
     */
    public function __construct()
    {
        self::$SlimApp = AppFactory::create();
    }

    /**
     * Returns the singleton instance of the Application class.
     *
     * If an instance of the Application class has already been created, this method
     * will return that instance. Otherwise, it will create a new instance and return it.
     *
     * @return Application The singleton instance of the Application class.
     */
    public static function getInstance(): Application
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::$instance;
    }

    /**
     * Runs the Slim application, handling any exceptions that occur.
     * 
     * This method initializes the routes for the Slim application, and then runs the application.
     * If any exceptions occur during the execution of the application, this method will catch them,
     * set the appropriate HTTP response headers, and return a JSON-encoded error response.
     */
    public function run(): void
    {
        try {
            
            self::initRoutes();
            self::$SlimApp->run();

        } catch (\Exception $e) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode([
                'error' => [
                    'code'      => $e->getCode(),
                    'message'   => $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Initializes the routes for the Slim application.
     * 
     * This method reads the routes configuration from the 'routes' key in the Config class,
     * and registers each route with the Slim application. The routes are defined as an
     * array, where each element contains the 'route', 'method', 'class', and 'function'
     * keys to specify the route, HTTP method, and the handler class and function.
     * 
     */
    private static function initRoutes(): void
    {

        $routes = Config::get('routes');

        if (!is_array($routes)) {
            return;
        }

        foreach ($routes as  $route) {
            if (!isset($route['route']) || !isset($route['method']) || !isset($route['class']) || !isset($route['function'])) {
                continue;
            }

            self::$SlimApp->{$route['method']}($route['route'], [$route['class'], $route['function']]);
        }
    }
}
