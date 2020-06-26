<?php

namespace ReloadlyPHP;


class Session
{

    private static $_instance;
    private $session_name;

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new Session();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->session_name = "token".uniqid().time();
    }

    public function get() : ?string
    {
        return ($this->exists()) ? $_SESSION[$this->session_name] :null;
    }

    public function exists() : ?string
    {
        return (isset($_SESSION[$this->session_name]));
    }

    public function set(string $token) : self
    {
        $_SESSION[$this->session_name] = $token;
        return $this;
    }

    public function delete() : self
    {
        if(isset($_SESSION[$this->session_name])) {
            unset($_SESSION[$this->session_name]);
        }

        return $this;
    }

}