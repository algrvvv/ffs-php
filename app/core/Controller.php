<?php

class Controller
{
    /**
     * @param string $name
     * @return void
     */
    public function view(string $name): void
    {
        $filename = "../app/views/".$name.".view.php";
        if (file_exists($filename)) {
            require $filename;
        } else {
            require "../app/views/404.view.php";
        }
    }
}