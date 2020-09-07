<?php

namespace Svv\Router;

use Svv\Exception\RouterException;

class Router
{

    private string $url;
    private array $routes = [];
    private array $namedRoutes = [];

    /**
     * Router constructor.
     *
     * @param string $url
     */
    public function __construct ($url)
    {
        $this->url = $url;
    }

    public function get (string $path, $callable, string $name = null)
    {
        return $this->add($path, $callable, $name, "GET");
    }

    public function post (string $path, $callable, string $name = null)
    {
        return $this->add($path, $callable, $name, "POST");
    }

    public function url (string $name, ?array $params = [])
    {
        if (!isset($this->namedRoutes[$name]))
        {
            throw new RouterException("No route matches this name");
        }

        return $this->namedRoutes[$name]->getUrl($params);
    }
    
    public function run ()
    {
        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]]))
        {
            throw new RouterException("No methods match");
        }

        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route)
        {
            if ($route->match($this->url))
            {
                return $route->call();
            }
        }

        throw new RouterException("No routes found!");
    }

    private function add (string $path, $callable, ?string $name, string $method)
    {
        $route = new Route($path, $callable);
        if (is_string($callable) && $name === null)
        {
            $name = $callable;
        }
        $this->routes[$method][] = $route;
        if ($name)
        {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

}
