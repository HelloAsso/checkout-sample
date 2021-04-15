<?php

class Config
{
    private static $_instance;

    public $clientId = "";
    public $clientSecret = "";
    public $organismSlug = "";
    public $baseUrl = "https://localhost:3000";
    public $returnUrl = "https://localhost:3000/return";

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
