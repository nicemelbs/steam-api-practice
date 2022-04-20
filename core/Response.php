<?php

namespace app\core;

class Response
{
    public function setStatusCode($httpCode)
    {
        http_response_code($httpCode);
    }

    public function redirect(string $string)
    {
        header('Location: ' . $string);

    }

}