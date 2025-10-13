<?php

namespace Http\Controllers;

use Core\Request;
use Core\Response;
use Exception;
use Exceptions\ValidationException;
use PDOException;
use Services\CommentsService;
use Support\Flash;

class CommentsController extends Controller
{

    public function __construct(private readonly CommentsService $commentsService)
    {
    }

    public function store(array $data): void
    {
        try {
            $this->commentsService->create($data);
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
        } catch (PDOException $e) {
            $this->handlePdoException($e);
        } catch (Exception $e) {
            $this->handleGenericException($e);
        }

        Response::redirect("/post/" . $data['post_id'], Request::create()->post);
    }

    private function handleValidationException(ValidationException $e): void
    {
        foreach ($e->getErrors() as $field => $error) {
            Flash::set($field, $error);
        }
        Response::redirect("/post/" . $data['post_id'], Request::create()->post);
    }

    private function handlePdoException(PDOException $e): void
    {
        Flash::set('error', "Não foi possivel, concluir Post , tente mais tarde.");
        Response::redirect("/post/" . $data['post_id'], Request::create()->post);
    }

    private function handleGenericException(): void
    {
        Flash::set('error', "Não foi possivel, concluir seu registro, tente mais tarde.");
        Response::redirect("/post/" . $data['post_id'], Request::create()->post);
    }

}