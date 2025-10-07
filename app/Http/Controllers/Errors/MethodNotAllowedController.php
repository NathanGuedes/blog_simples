<?php

namespace Http\Controllers\Errors;

use Contracts\ControllerInterface;
use Core\Response;
use Http\Controllers\Controller;

class MethodNotAllowedController extends Controller
{
    public function __construct()
    {
        http_response_code(405);
    }

    public function index(): Response
    {
        return new Response("405 Not Allowed");
    }
}