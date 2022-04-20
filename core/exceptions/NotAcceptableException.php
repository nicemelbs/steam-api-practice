<?php

namespace app\core\exceptions;

class NotAcceptableException extends \Exception
{
    protected $code = 406;
    protected $message = "Not acceptable";

}