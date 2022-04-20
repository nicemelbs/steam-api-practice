<?php

namespace app\core\exceptions;

class MethodNotAllowedException extends \Exception
{
    protected $code = 405;
    protected $message = "Method not allowed.";
}