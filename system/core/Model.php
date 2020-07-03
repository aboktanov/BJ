<?php
/*
 * Модель базовый класс
 */

namespace system\core;

use system\lib\DB;

abstract class Model
{
    /*
     * Имя связанной таблицы. Если default, имя равно имени класса в нижнем регистре (без Model)
     */
    protected $tableName = 'default';
    /*
     * Наименование столбца ID
     */
    protected $idColumn = 'id';
    protected $db;
    protected $prefix;
    /*
     * Определяет поля таблицы, используется для создания таблицы с случае ее отсутствия.
     * Пример:
     *      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     *      name VARCHAR(100) NOT NULL,
     *      active INT(6),
     *      comment VARCHAR(255),
     *      import_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     *      UNIQUE KEY `uk_name` (`name`)
     *
     */
    protected $tableFields;

    /*
     * Определяем имя связанной таблицы
     * Инициализируем соединение
     * Проверяем существование связанной таблицы и создаем(при необходимости)
     */
    function __construct()
    {
        if ($this->tableName == 'default') {
            $splitClassName = explode('\\', get_class($this));
            $tableName = strtolower(str_replace('Model', '', end($splitClassName)));
            $this->tableName = $tableName;
        }

        $this->DBInit();

        if ($this->tableFields)
            $this->testAndCreateTable();
    }

    /*
     * Инициализируем соединение
     * Задаем префикс таблиц в БД
     */
    protected function DBInit()
    {
        $this->db = new DB();
        if (!$this->prefix)
            $this->prefix = $this->db->getPrefix();
    }

    /*
     * Проверка на существование и создание связанной таблицы
     */
    protected function testAndCreateTable()
    {
        $result = $this->db->query('CHECK TABLE `' . $this->prefix . '_' . $this->tableName . '`');
        if ($result[0]['Msg_text'] != 'OK') {
            $query = "CREATE TABLE `" . $this->prefix . "_" . $this->tableName . "` (" . $this->tableFields . ")";
            $this->db->query($query);
        }

    }

    /*
     * Возвращает все елементы связанной таблицы
     */
    public function all()
    {
        return $this->db->query('SELECT * from `' . $this->prefix . '_' . $this->tableName . '`');
    }

    /*
     * Возвращает элемент связанной таблицы с заданным ID
     */
    public function getItem($id)
    {
        return $this->db->query('SELECT * from `' . $this->prefix . '_' . $this->tableName . '` where `' . $this->idColumn . '`=' . $id);
    }
}

