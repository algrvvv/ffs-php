<?php

class App
{
    private $controller = 'Home';
    private string $method = 'index';

    /**
     * @return array
     */
    private function splitURL(): array
    {
        return explode('/', trim($_GET['url'] ?? 'home', '/'));
    }

    public function loadController(): void
    {
        $URL = $this->splitURL();
        /** получение нужного контроллера **/
        $filename = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            require "../app/controllers/_404.php";
            $this->controller = '_404';
        }

        $controller = new $this->controller();

        /** проверка на наличие метода в классе **/
        if(isset($URL[1])){
            if(method_exists($controller, $URL[1])){
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        call_user_func_array([$controller, $this->method], $URL);
    }
}