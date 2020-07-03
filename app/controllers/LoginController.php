<?php
/*
 * Форма аутентификации.
 * Выход из системы
 * Валидация данных
 *
 */
namespace app\controllers;

use system\core\Controller;
use system\core\View;

class LoginController extends Controller
{
    /*
     * Форма аутентификации
     */
    public function index($success = '', $error = '')
    {
        if(isset($_SESSION['userAuth'])){
            $this->redirectByName('index');
        }

        $data['pageTitle'] = 'BeeJee Аутентификация';

        if ($success)
            $data['success'] = $success;
        else
            $data['success'] = '';
        if ($error)
            $data['error'] = $error;
        else
            $data['error'] = '';

        $data['i_login_error'] = '';
        $data['i_password_error'] = '';

        $data['i_login'] = '';

        if ($error) {
            $data['i_login'] = $this->inputValue('i_login');
        }

        new View('login', $data);
    }
    /*
     * Аутентификация (действие)
     * Валидация данных. Проверка в форме "заглушки", логин "admin", пароль "123"
     * В случае успеха возвращаемся к списку задач, иначе форма с указанием ошибок
     */
    public function login()
    {
        if(isset($_SESSION['userAuth'])){
            $this->redirectByName('index');
        }

        $data['pageTitle'] = 'BeeJee Аутентификация';

        $data['success'] = '';
        $data['error'] = '';

        $data['i_login_error'] = '';
        $data['i_password_error'] = '';

        $data['i_login'] = $this->inputValue('i_login');
        $data['i_password'] = $this->inputValue('i_password');

        if ($data['i_login'] && $data['i_password']) {
            if($data['i_login']=='admin' && $data['i_password']=='123'){

                $_SESSION['userAuth']='admin';

                $this->redirectByName('index');
                exit();

                if(isset($_SESSION['prevRoute'])) {
                    $prevRoute= $_SESSION['prevRoute'];
                    unset($_SESSION['prevRoute']);
                    if($prevRoute!='logout')
                        $this->redirectByName($prevRoute);
                }

            }else{
                $data['error'] = 'Неверные пара Логин/Пароль.';
            }

        }else {
            $data['error'] = 'Авторизация не удалась.';

            if ($data['i_login'] == '')
                $data['i_login_error'] = 'Имя может быть пустым';
            if ($data['i_password'] == '')
                $data['i_password_error'] = 'Пароль не может быть пустым';
        }
        new View('login', $data);
    }
    /*
     * Выход из системы (действие)
     */
    public function logout()
    {
        if (isset($_SESSION['userAuth'])) {
            unset($_SESSION['userAuth']);
        }
        $this->redirectByName('index');
    }
}