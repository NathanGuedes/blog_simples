<?php

namespace Http\Controllers\Errors;

use Core\Response;
use Exception;
use Http\Controllers\Controller;

class NotFoundController extends Controller
{
    public function __construct()
    {
        http_response_code(404);
    }

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        return new Response($this->view('errors/404'));
    }
}