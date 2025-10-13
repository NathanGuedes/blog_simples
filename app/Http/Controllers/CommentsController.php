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
            $this->handleValidationException($e, $data['post_id']);
        } catch (PDOException $e) {
            $this->handlePdoException($e, $data['post_id']);
        } catch (Exception $e) {
            $this->handleGenericException($e, $data['post_id']);
        }

        Response::redirect("/post/" . $data['post_id'], Request::create()->post);
    }

    public function destroyComment(array $comment_id)
    {
        $comment_id = $comment_id['id'];
        $form_data = Request::create()->post;

        try {
            $this->commentsService->destroy($comment_id, $form_data);
        } catch (PDOException $e) {
            $this->handlePdoException($e, $data['post_id']);
        }catch (Exception $e) {
            $this->handleGenericException($e, $form_data['post_id']);
        }

        Response::redirect("/post/" . $form_data['post_id'], Request::create()->post);
    }

    public function updateComment(array $data)
    {
        $comment_id = $data['id'];
        $form_data = Request::create()->post;

        try {
            $this->commentsService->update($comment_id, $form_data);
        } catch (ValidationException $e) {
            $this->handleValidationException($e, $form_data['post_id']);
        } catch (PDOException $e) {
            $this->handlePdoException($e, $form_data['post_id']);
        } catch (Exception $e) {
            $this->handleGenericException($e, $form_data['post_id']);
        }

        Response::redirect("/post/" . $form_data['post_id'], Request::create()->post);
    }

    private function handleValidationException(ValidationException $e, int $post_id): void
    {
        foreach ($e->getErrors() as $field => $error) {
            Flash::set($field, $error);
        }
        Response::redirect("/post/" . $post_id, Request::create()->post);
    }

    private function handlePdoException(PDOException $e, int $post_id): void
    {
        Flash::set('error', "Não foi possivel, concluir Post , tente mais tarde.");
        Response::redirect("/post/" . $post_id, Request::create()->post);
    }

    private function handleGenericException(Exception $e, int $post_id): void
    {
        Flash::set('error', "Não foi possivel, concluir seu registro, tente mais tarde.");
        Response::redirect("/post/" . $post_id, Request::create()->post);
    }

}