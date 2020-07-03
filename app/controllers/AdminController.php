<?php
/*
 * Только для авторизированных пользователей
 * Форма редактирования задачи
 * Изменение статуса задачи
 */
namespace app\controllers;

use system\core\Controller;
use system\core\View;

use app\models\TasksModel;

class AdminController extends Controller
{
    /*
     * Форма редактирования задачи
     * Только для авторизированных пользователей
     */
    public function editForm($success = '', $error = '')
    {
        $data['pageTitle'] = 'BeeJee Редактировать задачу';

        if (!$this->inputValue('i_id')) {
            $this->redirectByName('index');
        }


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

        if (!isset($_SESSION['userAuth'])) {
            $data['error'] = 'Редактирование задачи доступно только авторизированным пользователям.';
            $data['i_email'] = '';
            $data['i_name'] = '';
            $data['i_task'] = '';
            $data['i_id'] = '';
            new View('admin', $data);
            return;
        }


        if($error) {
            $data['i_email'] = $this->inputValue('i_email');
            $data['i_name'] = $this->inputValue('i_name');
            $data['i_task'] = $this->inputValue('i_task');
            $data['i_id'] = $this->inputValue('i_id');
        }
        else {
            $id = $String = preg_replace("/[^0-9]/ui", '', $this->inputValue('i_id'));
            if ($id) {
                $model = new TasksModel();
                $task = $model->getItem($id)[0];
                $data['i_email'] = $task['email'];
                $data['i_name'] = $task['user_name'];
                $data['i_task'] = $task['task'];
                $data['i_id'] = $task['id'];
            }
        }

        new View('admin', $data);
    }

    /*
     * Валидация данных
     * Сохранение измений Задачи
     * Только для авторизированных пользователей
     */
    public function taskEdit()
    {
        $data['pageTitle'] = 'BeeJee Редактировать задачу';
        $data['success'] = '';
        $data['error'] = '';

        $data['i_email_error'] = '';
        $data['i_name_error'] = '';
        $data['i_task_error'] = '';

        if (!isset($_SESSION['userAuth'])) {
            $data['error'] = 'Редактирование задачи доступно только авторизированным пользователям.';
            $data['i_email'] = '';
            $data['i_name'] = '';
            $data['i_task'] = '';
            $data['i_id'] = '';
            new View('admin', $data);
            return;
        }

        $data['i_email'] = $this->inputValue('i_email');
        $data['i_name'] = $this->inputValue('i_name');
        $data['i_task'] = $this->inputValue('i_task');
        $data['i_id'] = $this->inputValue('i_id');

        if ($data['i_email'] && $data['i_name'] && $data['i_task']&& $data['i_id']) {
            if (filter_var($data['i_email'], FILTER_VALIDATE_EMAIL) !== false) {
                $id = $String = preg_replace("/[^0-9]/ui", '', $this->inputValue('i_id'));
                if ($data['i_name'] != '' && $data['i_task'] != '' && $id) {
                    $model = new TasksModel();
                    if ($model->taskUpdate($id, $data)!=false) {
                        $this->editForm('Задача успешно сохранена.');
                        return true;
                    } else {
                        $this->editForm('', 'Сохранение не удалось.');
                        return false;
                    }
                }
            }

        } else {
            $data['error'] = 'Сохранение не удалось.';

            if (filter_var($data['i_email'], FILTER_VALIDATE_EMAIL) == false)
                $data['i_email_error'] = 'Неккоректный E-mail.';
            if ($data['i_name'] == '')
                $data['i_name_error'] = 'Имя не может быть пустым.';
            if ($data['i_task'] == '')
                $data['i_task_error'] = 'Задача не может быть пустой.';
        }

        new View('admin', $data);
    }
    /*
     * Изменеие статуса задачи на "выполнено" (код 2)
     * Только для авторизированных пользователей
     */
    public function exec()
    {
        if (isset($_SESSION['userAuth'])) {
            if ($this->inputValue('i_id')) {
                $id = $String = preg_replace("/[^0-9]/ui", '', $this->inputValue('i_id'));
                if ($id) {
                    $model = new TasksModel();
                    $task = $model->getItem($id)[0];
                    if ($task['state'] == '1') {
                        $model->stateUpdate($id, 2);
                    }
                }
            }
        }

        $this->redirectByName('index');
    }
}