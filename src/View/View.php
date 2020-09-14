<?php
namespace View;

class View
{
    private $templatesPath;

    private $extraVars = [];

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }
        //Что бы можно было передавать переменные типа $this->view->setVar('user', $this->user); Короче без рендера.
    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHtml(string $templateName, array $vars = [], int $code = 200)
    {
        http_response_code($code); //Код ответа на случай если страница не найдена
        extract($vars);
        extract($this->extraVars);

        //Положим поток в буфер на случай ошибки
        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }
}