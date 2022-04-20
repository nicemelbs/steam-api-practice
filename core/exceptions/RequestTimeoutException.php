<?php

namespace app\core\exceptions;

class RequestTimeoutException extends \Exception
{
    protected $code = 408;
    protected $message = "Request Timeout";

}