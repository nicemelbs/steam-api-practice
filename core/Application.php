<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static string $ROOT_DIR;
    public static Application $app;
    public Controller $controller;
    public Session $session;
    public Database $db;
    public ?DbModel $user; // variable could be null
    public string $userClass;
    public string $layout = 'main';
    public View $view;
    public static Client $client;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();
        $this->db = new Database($config['db']);
        $this->userClass = $config['userClass'];

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }


       self::initCaching();
    }

    private static function initCaching()
    {
        // Create a HandlerStack
        $stack = HandlerStack::create();

        // Choose a cache strategy: the PrivateCacheStrategy is good to start with
        $cache_strategy_class = '\\Kevinrob\\GuzzleCache\\Strategy\\PrivateCacheStrategy';

        // Instantiate the cache storage: a PSR-6 file system cache with
        // a default lifetime of 1 minute (60 seconds).
        $cache_storage = new Psr6CacheStorage(
            new FilesystemAdapter('', 0, '/tmp/guzzle-cache'), 60 );

        // Add cache middleware to the top of the stack with `push`
        $stack->push(
        new CacheMiddleware(
            new $cache_strategy_class (
                $cache_storage
            )
        ),
        'cache'
    );

        // Initialize the client with the handler option
        self::$client = new Client(['handler' => $stack]);
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $errorCode = intval($e->getCode());
            $errorMessage = $e->getMessage();
            $this->response->setStatusCode($errorCode);
            echo $this->view->renderView("error", [
                'exception' => $e
            ]);
        }
    }


    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function getLayout(): string
    {
        return self::$app->layout;
    }

    public function login(DbModel $user): bool
    {
        $this->user = $user;
        $primaryValue = $user->primaryValue();
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout()
    {
        $this->session->destroy();
        $this->user = null;
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    //Generate HTML tag to display the favicon
    public function favicon($fileName = 'favicon.ico'): string
    {
        $fileName = realpath(self::$ROOT_DIR . '/' . $fileName);
        //check if file exists
        if (file_exists($fileName)) {
            $favicon = '<link rel="shortcut icon" href="' . $fileName . '"><link type="image/x-icon" rel="icon" href="' . $fileName . '">';
        } else {
            $favicon = '';
        }
        return $favicon;
    }
}