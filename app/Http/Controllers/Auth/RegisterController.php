<?php

namespace Http\Controllers\Auth;

use Contracts\ControllerInterface;
use Core\Request;
use Core\Response;
use Exception;
use Exceptions\ValidationException;
use Http\Controllers\Controller;
use PDOException;
use Random\RandomException;
use Services\RegisterService;
use Support\Flash;

class RegisterController extends Controller implements ControllerInterface
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        return new Response($this->view('auth/registerForm'));
    }

    public function register(array $request): void
    {
        try {
            $this->registerService->register($request);
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
        } catch (PDOException $e) {
            $this->handlePdoException($e);
        } catch (Exception $e) {
            $this->handleGenericException($e);
        }

        Response::redirect("/login", Request::create()->post ?? []);
    }

    private function handleValidationException(ValidationException $e): void
    {
        foreach ($e->getErrors() as $field => $error) {
            Flash::set($field, $error);
        }
        Response::redirect("/register", Request::create()->post);
    }

    private function handlePdoException(PDOException $e): void
    {
        if ($e->getCode() == 23505) {
            Flash::set('email', "Já existe uma conta com este e-mail. Tente fazer login ou use outro e-mail.");
            Response::redirect("/register", Request::create()->post);
        }

        Flash::set('error', "Não foi possivel, concluir seu registro, tente mais tarde.");
        Response::redirect("/register", Request::create()->post);
    }

    private function handleGenericException(): void
    {
        Flash::set('error', "Não foi possivel, concluir seu registro, tente mais tarde.");
        Response::redirect("/register", Request::create()->post);
    }
}