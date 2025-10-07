<?php

namespace Http\Controllers\Auth;

use Contracts\ControllerInterface;
use Core\Request;
use Core\Response;
use Exception;
use Exceptions\ActiveValidationException;
use Exceptions\ValidationException;
use Http\Controllers\Controller;
use Services\SessionService;
use Support\Flash;

class SessionController extends Controller implements ControllerInterface
{

    public function __construct(private readonly SessionService $sessionService) {}

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        return new Response($this->view('auth/sessionForm'));
    }

    public function store(array $request): void
    {
        try {
            $this->sessionService->session($request);
        } catch (ValidationException $e) {
            $errors = $e->getErrors();
            if (is_array($errors)) {
                foreach ($errors as $field => $error) {
                    Flash::set($field, $error);
                }
            } else {
                Flash::set('error', $errors);
            }
            Response::redirect("/login", $request);
        } catch (ActiveValidationException){
            Response::redirect("/email/activation/send");
        } catch (Exception) {
            Flash::set('error', "Não foi possivel, concluir seu login, tente mais tarde.");
            Response::redirect("/register", Request::create()->post);
        }

        redirect("/");
    }

    public function destroy(): void
    {
        $this->sessionService->killSession();

        redirect("/");
    }
}
