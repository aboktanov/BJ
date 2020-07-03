<?php

require 'app.php';
/*
 * Вывод сообщений об ошибках только в режиме отладки
 */
if ($mainENV['debugMode']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
/*
 * Часовой пояс
 */
date_default_timezone_set($mainENV['timezone']);
/*
 * Сессии для хранения информации о текущем пользователе и авторизации
 */
session_start();

/*
 * Автозагрузка классов
 */
spl_autoload_register(function ($class) {
    $file = '../' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file))
        include_once($file);
});
