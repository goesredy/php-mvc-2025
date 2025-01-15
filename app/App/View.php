<?php

namespace skensa\Belajar\PHP\MVC\App;

class View
{
    public static function render(string $view, $model)
    {
        require APP_PATH . '/View/' . $view . '.php';
    }
}

