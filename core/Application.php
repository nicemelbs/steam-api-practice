<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;
use Exception;

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

    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $errorCode = $e->getCode();

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