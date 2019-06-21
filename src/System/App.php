<?php

namespace App\System;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\Router;

class App
{
    private $request;
    private $router;            # это объект Маршрутизатора
    private $routes;            # коллекция маршрутов для этого проекта
    private $requestContext;
    private $controller;
    private $arguments;
    private $basePath;

    private $container;

    public static $instance = null;

    public static function getInstance($basePath = null)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($basePath);
        };

        return static::$instance;
    }

    private function __construct($basePath)
    {
        $this->basePath = $basePath;

        $this->setRequest();                # для определения объекта запроса
        $this->setRequestContext();         # для определения контекста запроса
        $this->setRouter();                 # для определения маршрутизатора

        $this->routes = $this->router->getRouteCollection();
    }

    private function setRequest()
    {
        $this->request = Request::createFromGlobals();
    }

    private function setRequestContext()
    {
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getRequestContext()
    {
        return $this->requestContext;
    }


    private function setRouter()
    {
        $fileLocator = new FileLocator(array(__DIR__));
        $this->router = new Router(
            new YamlFileLoader($fileLocator),
            $this->basePath . "/config/routes.yaml",
            array('cache_dir' => $this->basePath . '/storage/cache')
        );
    }

    public function getController()
    {
        return (new ControllerResolver())->getController($this->request);
    }

    public function getArguments($controller)
    {
        return (new ArgumentResolver())->getArguments($this->request, $controller);
    }


    public function run()
    {
        $matcher = new UrlMatcher($this->routes, $this->requestContext);
        try {
            $this->request->attributes->add($matcher->match($this->request->getPathInfo()));

            $this->controller = $this->getController();
            $this->arguments = $this->getArguments($this->controller);

//            dd($this->controller, $this->arguments);

            $response = call_user_func_array($this->controller, $this->arguments);

        } catch (\Exception $e) {
            exit('error');
        }

        $response->send();
    }

    public function add($key, $object){
        $this->container[$key] = $object;
        return $object;
    }

    public function get($key){
        if (isset($this->container[$key])){
            return $this->container[$key];
        }

        return null;
    }
}