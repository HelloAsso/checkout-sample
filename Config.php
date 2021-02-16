<?php

class Config
{
    private static $_instance;

    public $partnerId = "";
    public $formUrl = "";
    public $successUrl = "http://localhost:3000/success";
    public $errorUrl = "http://localhost:3000/error";

    private function __construct()
    { }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config();
        }

        return self::$_instance;
    }
}
