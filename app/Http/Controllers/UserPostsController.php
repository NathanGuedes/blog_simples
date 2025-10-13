<?php

namespace Http\Controllers;

use Core\Request;
use Core\Response;
use Exception;
use Exceptions\ValidationException;
use PDOException;
use Services\UserPostsService;
use Support\Flash;
use Support\SessionManager;

class UserPostsController extends Controller
{

    public function __construct(private readonly UserPostsService $userPostsService)
    {
    }

    /**
     * @throws Exception
     */
    public function index(array $data): Response
    {
        return new Response($this->view('user_profile', [
            'posts' => $this->userPostsService->allPosts($data['user'])
        ]));
    }

    private function handleValidationException(ValidationException $e): void
    {
        foreach ($e->getErrors() as $field => $error) {
            Flash::set($field, $error);
        }
        Response::redirect("/", Request::create()->post ?? []);
    }

    private function handlePdoException(PDOException $e): void
    {
        Flash::set('error', "Não foi possivel, concluir Post , tente mais tarde.");
        Response::redirect("/", Request::create()->post);
    }

    private function handleGenericException(): void
    {
        Flash::set('error', "Não foi possivel, concluir seu registro, tente mais tarde.");
        Response::redirect("/", Request::create()->post);
    }

}