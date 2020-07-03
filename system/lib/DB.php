<?php
/*
 * Работа с MYSQL (драйвер MYSQLi)
 */
namespace system\lib;

use system\core\Router;

class DB
{
    protected $connection;
    protected $prefix;
    /*
     * Получаем базовые параметры сервера и БД
     * Устанавливаем соединение (если нет установленного)
     * В случае ошибок отображаем страницу 500
     */
    function __construct()
    {
        $mysqlSettings = require '../system/config/db.php';
        $this->prefix=$mysqlSettings['prefix'];

        if (!$this->connection) {
            $connectionID = mysqli_init();
            $connectionID->options(MYSQLI_OPT_CONNECT_TIMEOUT, $mysqlSettings['timeout']);
            $connectionID->real_connect($mysqlSettings["host"], $mysqlSettings["username"], $mysqlSettings["password"]);
            if (mysqli_connect_errno()) {
                new \system\core\View('page500', ['pageTitle' => '500']);//
                exit();
            }
            if (!$connectionID->select_db($mysqlSettings["database"])) {
                $connectionID->close();
                new \system\core\View('page500', ['pageTitle' => '500']);//
                exit();
            }
            $connectionID->query("SET NAMES 'utf8'");

            $this->connection = $connectionID;
        }
    }
    /*
     * escape_string()
     */
    public function escape($value)
    {
        return $this->connection->escape_string($value);
    }
    /*
     * Выполняет SQL запрос
     * При удачном SELECT возвращает набор данных
     * При удачном INSERT возвращает ID (['insert_id'])
     * При удачном UPDATE возвращает TRUE
     */
    public function query($query)
    {
        if ($result = $this->connection->query($query)) {
            $data = array();

            if($result===true){
                if($this->connection->insert_id){
                    $data[]=['insert_id'=>$this->connection->insert_id];
                }
                else
                    return true;
            }
            if(is_object($result)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                }
                $result->close();
            }

            return $data;

        } else {
            return false;
        }
    }
    /*
     * Возвращает префикс таблиц в БД
     */
    public function getPrefix(){
        return $this->prefix;
    }

}