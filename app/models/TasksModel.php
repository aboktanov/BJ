<?php

namespace app\models;

use system\core\Model;

class TasksModel extends Model
{
    /*
     * Структура таблицы Задач
     */
    protected $tableFields='
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        task TEXT NOT NULL,
        original_task TEXT NOT NULL,
        state INT(6) DEFAULT 1,
        active INT(6) DEFAULT 1,
        create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ';
    /*
     * Вставка новой задачи (Валидация на базе контроллера)
     */
    public function newTask($data){
        return $this->db->query("INSERT INTO `".$this->prefix."_".$this->tableName."` 
            SET `user_name`='".$this->db->escape($data['i_name'])."',
                `email`='".$this->db->escape($data['i_email'])."',
                `task`='".$this->db->escape($data['i_task'])."',
                `original_task`='".$data['i_task']."'
            ");
    }
    /*
     * Изменение задачи (Валидация на базе контроллера)
     */
    public function taskUpdate($id, $data){
        return $this->db->query("UPDATE `".$this->prefix."_".$this->tableName."` 
            SET `user_name`='".$this->db->escape($data['i_name'])."',
                `email`='".$this->db->escape($data['i_email'])."',
                `task`='".$this->db->escape($data['i_task'])."'
                where `id`=".(int)$id."
            ");
    }
    /*
     * Изменение статуса задачи (Валидация на базе контроллера)
     */
    public function stateUpdate($id, $state){
        return $this->db->query("UPDATE `".$this->prefix."_".$this->tableName."` 
            SET `state`='".(int)$state."'
                where `id`='".(int)$id."'
            ");
    }
    /*
     * Возвращает набор отсортированный по заданному полю и в заданном направлении
     */
    public function allSort($column, $direction)
    {
        return $this->db->query('SELECT * from `'.$this->prefix.'_'.$this->tableName.'`
            ORDER BY '.$column.' '.$direction);
    }
}