<?php
/*
 * Маршрутизация
 */

namespace system\core;

class Router
{
    protected $routes = [];

    function __construct()
    {
        /*
         * Массив маршрутов
         */
        $routes = require '../routes/web.php';
        /*
         * Шаблон маршрутов
         */
        foreach ($routes as $route => $details) {
            $route = '#^' . $route . '$#';
            $this->routes[$route] = $details;
        }
    }

    /*
     * Определение соответствия текущего маршрута и передача управления
     * Если маршрут не найден, отображаем страницу 404
     */
    public function match()
    {
        $urlSplit = explode('?', $_SERVER['REQUEST_URI']);
        $url = rtrim($urlSplit[0], '/');
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route => $details) {
            if (preg_match($route, $url)) {
                if ($details['method'] != 'ALL') {
                    if ($details['method'] == $method) {
                        $this->action($details);
                        return true;
                    }
                } else {
                    $this->action($details);
                    return true;
                }
            }
        }
        new \system\core\View('page404', ['pageTitle' => '404']);
    }

    /*
     * Опредение маршрута по имени и передача управления
     * Если маршрут не найден, действия не выполняются
     */
    public function matchByName($routeName)
    {
        foreach ($this->routes as $route => $details) {
            if ($details['name'] == $routeName) {
                $this->action($details);
                return true;
            }
        }
        return false;
    }

    /*
     * Определение имени текущего маршрута
     */
    public function name()
    {
        $url = rtrim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $details) {
            if (preg_match($route, $url)) {
                return $details['name'];
            }
        }
        return false;
    }

    /*
     * Определение контроллера и метода
     * Если контроллер или метод не найдены, отображаем страницу 500
     */
    protected function action($routeDetails)
    {
        $controllerPath = 'app\controllers\\' . $routeDetails['controller'];
        $controllerAction = $routeDetails['action'];
        if (class_exists($controllerPath)) {

            if (method_exists($controllerPath, $controllerAction)) {
                $controller = new $controllerPath;
                $controller->$controllerAction();
            } else {
                new \system\core\View('page500', ['pageTitle' => '500']);//Метод не найден
                return false;
            }
        } else {
            new \system\core\View('page500', ['pageTitle' => '500']);//Контроллер не найден
            return false;
        }
        return true;
    }


}