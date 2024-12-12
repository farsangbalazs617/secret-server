<?php declare(strict_types=1);

namespace SecretServer;

use Slim\Factory\AppFactory;
use Slim\App;

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
     * IDO NOT instanciate it directly.
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
     * Runs the Slim application, initializing the routes and executing the application.
     */
    public function run(): void
    {
        self::initRoutes();
        self::$SlimApp->run();
    }

    /**
     * Initializes the routes for the Slim application.
     */
    private static function initRoutes(): void
    {
        self::$SlimApp->post('/api/secret', function ($request, $response) {
            return 'TESZT POST';
        });

        self::$SlimApp->get('/api/secret/{hash}', function ($request, $response, $args) {
            return 'TESZT GET';
        });
    }
}
