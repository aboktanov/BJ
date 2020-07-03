<?php
/*
 * Контроллер базовый класс
 */
namespace system\core;

abstract class Controller
{
    /*
     * Передает управление в соответствии с именованным маршрутом
     */
    protected function redirectByName($routeName)
    {
        $route = new \system\core\Router();
        $_SESSION['prevRoute']=$route->name();
        $route->matchByName($routeName);
        exit;
    }
    /*
     * Получает параметр по имени, переданный GET или POST методом
     */
    public function inputValue($name){
        foreach ($_GET as $valueName => $value){
            if($valueName==$name)
                return htmlspecialchars($value);
        }

        foreach ($_POST as $valueName => $value){
            if($valueName==$name)
                return htmlspecialchars($value);
        }
        return false;
    }

}