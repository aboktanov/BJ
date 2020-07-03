<?php
/*
 * Отображение списка задач
 * Отображение формы создания новой задачи
 * Для авторизированных пользователей доступ к Редактированию, Изменению статуса
 * Валидация данных
 */
namespace app\controllers;

use system\core\Controller;
use system\core\View;

use app\models\TasksModel;

class TaskController extends Controller
{
    /*
     * Количество элементов на одну страницу
     */
    protected $itemPerPage = 3;

    /*
     * Задаем значения по умолчания
     * Первая страница
     * Сортировка по имени пользователя
     * Сортировка по возрастанию
     */
    function __construct()
    {
        if (!isset($_SESSION['currentPage']))
            $_SESSION['currentPage'] = 1;

        if (!isset($_SESSION['sort']))
            $_SESSION['sort'] = 'user_name';

        if (!isset($_SESSION['direction']))
            $_SESSION['direction'] = 'ASC';

    }
    /*
     * Опредеяем набор данных (задач) с учетом сортировки
     * Отображаем страницу main (+ форма создания новой задачи)
     */
    public function index($success = '', $error = '')
    {
        if ($this->inputValue('page'))
            $_SESSION['currentPage'] = $this->inputValue('page');

        if ($this->inputValue('sort')) {
            if ($_SESSION['sort'] == $this->inputValue('sort')) {
                if ($_SESSION['direction'] == 'ASC')
                    $_SESSION['direction'] = 'DESC';
                else
                    $_SESSION['direction'] = 'ASC';
            }
            else {
                $_SESSION['sort'] = $this->inputValue('sort');
                $_SESSION['direction'] == 'ASC';
            }
        }

        $data['sort']=$_SESSION['sort'];
        $data['sortDirection']=$_SESSION['direction'];

        $model = new TasksModel();
        $tasks = $model->allSort($_SESSION['sort'],$_SESSION['direction']);
        if ($tasks) {
            $data['tasks'] = $this->pageTask($tasks);
            $data['pages'] = $this->pages($tasks);
        } else {
            $data['tasks'] = '';
            $data['pages'] = '';
        }

        $data['pageTitle'] = 'BeeJee Задачи';

        if ($success)
            $data['success'] = $success;
        else
            $data['success'] = '';
        if ($error)
            $data['error'] = $error;
        else
            $data['error'] = '';


        $data['i_email_error'] = '';
        $data['i_name_error'] = '';
        $data['i_task_error'] = '';

        $data['i_email'] = '';
        $data['i_name'] = '';
        $data['i_task'] = '';

        if($error) {
            $data['i_email'] = $this->inputValue('i_email');
            $data['i_name'] = $this->inputValue('i_name');
            $data['i_task'] = $this->inputValue('i_task');
        }

        if(isset($_SESSION['userAuth']))
            $data['admin'] = true;
        else
            $data['admin'] = false;

        $data['currentPage'] = $_SESSION['currentPage'];


        new View('main', $data);
    }
    /*
     * Добавление новой задачи (действие)
     * Валидация данных, отображение ошибок валидации
     * В случае успеха, отображаем список задач
     *
     */
    public function taskAdd()
    {
        $data['pageTitle'] = 'BeeJee Новая задача';
        $data['success'] = '';
        $data['error'] = '';
        $data['i_email_error'] = '';
        $data['i_name_error'] = '';
        $data['i_task_error'] = '';

        $data['i_email'] = $this->inputValue('i_email');
        $data['i_name'] = $this->inputValue('i_name');
        $data['i_task'] = $this->inputValue('i_task');

        if ($data['i_email'] && $data['i_name'] && $data['i_task']) {
            if (filter_var($data['i_email'], FILTER_VALIDATE_EMAIL) !== false) {
                if ($data['i_name'] != '' && $data['i_task'] != '') {
                    $model = new TasksModel();
                    if ($model->newTask($data)) {
                        $this->index('Задача успешно добавлена.');
                        return true;
                    } else {
                        $this->index('', 'Новая задача не добавлена.');
                        return false;
                    }
                }
            }

        } else {
            $data['error'] = 'Новая задача не добавлена. Форма заполнена некорректно.';

            if (filter_var($data['i_email'], FILTER_VALIDATE_EMAIL) == false)
                $data['i_email_error'] = 'Неккоректный E-mail.';
            if ($data['i_name'] == '')
                $data['i_name_error'] = 'Имя не может быть пустым.';
            if ($data['i_task'] == '')
                $data['i_task_error'] = 'Задача не может быть пустой.';
        }
        new View('newTask', $data);
    }
    /*
     * Возвращает набор задач для текущей страницы
     */
    protected function pageTask($tasks)
    {
        $itemStart = ($_SESSION['currentPage'] - 1) * $this->itemPerPage;
        $itemEnd = $itemStart + $this->itemPerPage;

        if (count($tasks) < ($itemStart + $this->itemPerPage))
            $itemEnd = count($tasks);

        for ($i = $itemStart; $i < $itemEnd; $i++)
            $pageTask[] = $tasks[$i];

        return $pageTask;
    }
    /*
     * Возвращает количество страниц, необходимых для отображения всех имеющихся задач
     */
    protected function pages($tasks)
    {
        $pages = (int)(count($tasks) / $this->itemPerPage);

        if ((count($tasks) % $this->itemPerPage) > 0)
            $pages++;

        return $pages;
    }
}