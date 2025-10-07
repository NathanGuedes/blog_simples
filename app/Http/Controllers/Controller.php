<?php

namespace Http\Controllers;

use Contracts\ControllerInterface;
use Exception;
use League\Plates\Engine;

abstract class Controller
{
    /**
     * @throws Exception
     */
    public static function view(string $view, array $data = []): string
    {
        $path = basePath() . '/resources/views/';

        if (! file_exists($path . $view . '.php')) {
            throw new Exception('View ' . $view . ' does not exist');
        }

        $templates = new Engine($path);
        return $templates->render($view, $data);
    }
}