<?php
/*
 * method - GET, POST или ALL(любой)
 * controller - контроллер, регистр важен
 * action - действие, регистр важен
 * name - имя маршрута, используется для удобной навигации
 */
return [
    '' => [
        'method' => 'GET',
        'controller' => 'TaskController',
        'action' => 'index',
        'name' => 'index'],
    '/taskAdd' => [
        'method' => 'POST',
        'controller' => 'TaskController',
        'action' => 'taskAdd',
        'name' => 'index'],
    '/loginForm' => [
        'method' => 'GET',
        'controller' => 'LoginController',
        'action' => 'index',
        'name' => 'login'],
    '/login' => [
        'method' => 'POST',
        'controller' => 'LoginController',
        'action' => 'login',
        'name' => 'login'],
    '/logout' => [
        'method' => 'GET',
        'controller' => 'LoginController',
        'action' => 'logout',
        'name' => 'logout'],
    '/edit' => [
        'method' => 'GET',
        'controller' => 'AdminController',
        'action' => 'editForm',
        'name' => 'editForm'],
    '/taskEdit' => [
        'method' => 'POST',
        'controller' => 'AdminController',
        'action' => 'taskEdit',
        'name' => 'taskEdit'],
    '/exec' => [
        'method' => 'GET',
        'controller' => 'AdminController',
        'action' => 'exec',
        'name' => 'exec'],
];