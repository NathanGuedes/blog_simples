<?php

namespace Http\Controllers;

use Core\Request;
use Core\Response;
use Exception;
use Exceptions\NotFoundException;
use Exceptions\ValidationException;
use PDOException;
use Services\PostsService;
use Support\Flash;

class PostsController extends Controller
{

    public function __construct(private readonly PostsService $postService)
    {
    }

    public function store(array $request): void
    {
        try {
            $this->postService->create($request);
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
        } catch (PDOException $e) {
            $this->handlePdoException($e);
        } catch (Exception $e) {
            $this->handleGenericException($e);
        }

        Response::redirect("/", Request::create()->post ?? []);
    }

    /**
     * @throws NotFoundException|Exception
     */
    public function showPost(array $data): Response
    {
        try {
            $post = $this->postService->onlyPost($data['id']);
        } catch (NotFoundException $e) {
            Flash::set('error', $e->getMessage());
            Response::redirect("/");
        }

        $comments = $this->postService->postComments($data['id']);

        return new Response($this->view('show_post', [
            'post' => $post,
            'comments' => $comments
        ]));
    }

    public function destroyPost(array $data): void
    {
        try {
            $this->postService->delete($data['id']);
        } catch (ValidationException $e) {
            Flash::set('error', $e->getMessage());
            Response::redirect("/post/" . $data['id'], Request::create()->post);
        } catch (PDOException|Exception $e) {
            Flash::set('error', "Não foi possivel, concluir sua solicitação , tente mais tarde.");
            Response::redirect("/post/" . $data['id'], Request::create()->post);
        }

        Response::redirect("/", Request::create()->post);

    }

    /**
     * @throws NotFoundException
     * @throws Exception
     */
    public function updatePostForm(array $data): Response
    {
        return new Response($this->view('post_update', [
            'post' => $this->postService->onlyPostEdit($data['id'])
        ]));
    }

    public function updatePost(array $request): void
    {
        try {
            $this->postService->update($request);
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
        } catch (PDOException $e) {
            $this->handlePdoException($e);
        } catch (Exception $e) {
            $this->handleGenericException($e);
        }

        Response::redirect("/post/" . $request['id'], Request::create()->post);
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