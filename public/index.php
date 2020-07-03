<?
/*
 * Инициализация базовых параметров
 * system/config/app.php, system/config/db.php - настроить перед первым запусокм
 * Режим отладки включен по умолчанию
 */
require '../system/config/init.php';
/*
 * Определение текущего маршруда и передача управления контроллеру
 */
$route = new \system\core\Router();
$route->match();



