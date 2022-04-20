<?php

namespace app\core;

class View
{

    public string $title = '';

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{ content }}', $viewContent, $layoutContent);
    }

    public function layoutContent()
    {

        if (isset(Application::$app->controller)) {
            $layout = Application::$app->controller->layout;
        } else
            $layout = Application::$app->getLayout();
        //output buffering way to store output to variables
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";

        //ob_get_clean - returns the value of the
        //current output buffer and cleans the buffer
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params)
    {

        foreach ($params as $key => $value) {
            //$$ operator creates a variable with the name equal to the value of $key.
            //in this case, if I have ['alice' => 'umbrella']
            //it will create a new variable $alice
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();

    }
}