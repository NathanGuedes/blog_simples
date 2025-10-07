<?php

namespace Http\Controllers;


use Contracts\ControllerInterface;
use Core\Response;
use Exception;

class HomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Response
    {
        return new Response($this->view('home'));
    }
}