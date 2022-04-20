<?php

namespace app\core;

class Session
{

    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$message) {
            $message['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        //delete flash messages marked to be removed
        foreach ($_SESSION[self::FLASH_KEY] as $key => &$message) {
            if ($message['remove']) {
                unset($_SESSION[self::FLASH_KEY][$key]);
            }
        }
    }

    public function hasFlash($key)
    {
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy()
    {
        $this->remove('user');
    }
}