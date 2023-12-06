<?php

/** Дополнительные / вспомогательные функции **/

/**
 * @param mixed $stuff
 * @return void
 */
function show(mixed $stuff): void
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

/**
 * @param string $str
 * @return string
 */
function esc(string $str): string
{
    return htmlspecialchars($str);
}