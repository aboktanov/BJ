<?php
/*
 * Отображение (UI)
 */
namespace system\core;

class View
{
    protected $viewName;
    protected $data;

    /*
     * Определяем отображение, рендерим и отдаем
     */
    function __construct($viewName, $data = [])
    {
        $this->viewName = $viewName;
        $this->data = $data;

        echo $this->render($viewName, $data);
    }

    /*
     * Рендер отображения.
     * В рендер идет массив переменных $data, Роутер
     * Если в отображении указан шаблон в виде @layout('myLayout'), первой строкой, загружаем шаблон
     */
    protected function render()
    {
        if (!$this->viewName)
            return false;
        if (!file_exists('../app/views/' . $this->viewName . '.php'))
            return false;

        if ($this->data)
            extract($this->data);
        $route = new \system\core\Router();
        ob_start();

        require '../app/views/' . $this->viewName . '.php';

        $output = ob_get_clean();

        $layout = $this->getLayout();
        $output = preg_replace("/^@layout\('(.+)'\)/", '', $output);
        if ($layout) {
            $output = str_replace('@content', $output, $layout);
        }

        return $output;
    }
    /*
     * Рендер шаблона.
     * Шаблон указывается(при необходимости) в файле отображения в виде @layout('myLayout'), первой строкой
     * В рендер идет массив переменных $data
     * В шаблоне должно быть определено место вставки контента как @content, иначе шаблон игнорируется
     */
    protected function getLayout()
    {
        $view = file_get_contents('../app/views/' . $this->viewName . '.php');
        if (preg_match("/^@layout\('(.+)'\)/", $view, $matches)) {
            if (!file_exists('../app/views/layouts/' . $matches[1] . '.php')) {
                return false;
            }
            if ($this->data)
                extract($this->data);

            ob_start();

            require '../app/views/layouts/' . $matches[1] . '.php';

            $layout = ob_get_clean();

            if (preg_match("/@content/", $layout, $matches)) {
                return $layout;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
}