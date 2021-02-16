<?php

    // composer autoloader
    require 'vendor/autoload.php';

    // project loader
    require 'Config.php';
    require 'Controllers/FormController.php';
    require 'Models/FormViewModel.php';
    require 'Services/HelloAssoApiWrapper.php';

    // router
    $router = new AltoRouter();
    $helloassoApiWrapper = new Services\HelloAssoApiWrapper(Config::getInstance());
    $formController = new Controllers\FormController($helloassoApiWrapper);

    $router->map('GET', '/', 'get');
    $router->map('POST', '/', 'post');
    $router->map('GET', '/success', 'success');
    $router->map('GET', '/error', 'error');

    $match = $router->match();
    
    if(is_array($match)) {
        list($view, $data) = $formController->{$match['target']}($match['params']);
        require __DIR__ . "/Views/$view.phtml";    
    }

?>