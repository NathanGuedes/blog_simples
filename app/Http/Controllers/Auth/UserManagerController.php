<?php

namespace Http\Controllers\Auth;


use Core\Request;
use Core\Response;
use Exception;
use Exceptions\ActiveValidationException;
use Exceptions\InvalidTokenException;
use Exceptions\ValidationException;
use Http\Controllers\Controller;
use Random\RandomException;
use Services\SessionService;
use Services\UserManagerService;
use Support\Flash;
use Support\SessionManager;

class UserManagerController extends Controller
{
    public function __construct(private readonly UserManagerService $userManagerService,
                                private readonly SessionService     $sessionService,
                                private readonly SessionManager     $sessionManager
    )
    {
    }

    /**
     * @throws Exception
     */
    public function startSendEmailActivation(string $userEmail): void
    {
        $user = $this->sessionManager->get('user');
        $this->userManagerService->emailActiveSend($user);

        $this->sessionService->killSession();

        new Response($this->view('auth/validateEmail', [
            'email' => $userEmail
        ]))->send();
    }

    /**
     * @throws Exception
     */
    public function confirmEmailActivation(array $token): void
    {
        $token = $token['token'];
        try {
            $this->userManagerService->confirmEmail($token);
        } catch (InvalidTokenException $e) {
            Response::redirect('/login', [
                'error' => 'Link de confirmação inválido'
            ]);
        } catch (ActiveValidationException $e) {
            $this->sessionService->startSessionLogin([
                'name' => $e->getDataError()['name'],
                'email' => $e->getDataError()['email']
            ]);
            $this->startSendEmailActivation($e->getDataError()['email']);
        }

        Flash::set('success', 'Conta ativada com sucesso!');
        Response::redirect('/login');
    }

    /**
     * @throws Exception
     */
    public function showForgotPasswordEmailForm(): Response
    {
        return new Response($this->view('auth/forgot'));
    }

    /**
     * @throws RandomException
     * @throws Exception
     */
    public function startSendEmailForgotPassword(array $data): void
    {
        $this->userManagerService->forgotPasswordSend($data);

        new Response($this->view('auth/validateEmailPasswordForgot', [
            'email' => $data['email']
        ]))->send();
    }

    /**
     * @throws Exception
     */
    public function showForgotPasswordRecoveryForm($token): Response
    {
        try {
            $this->userManagerService->checkToken($token['token']);
        } catch (InvalidTokenException $e) {
            Flash::set('error', 'Link de recuperação de senha inválido, tente novamente.');
            Response::redirect("/forgot/password/email");
        }

        return new Response($this->view('auth/forgotForm', [
            'token' => $token['token']
        ]));
    }

    public function updatePassword(array $dataForm): void
    {
        $userEmail = '';
        try {
            $userEmail = $this->userManagerService->updatePassword($dataForm);
        } catch (ValidationException $e) {
            foreach ($e->getErrors() as $field => $error) {
                Flash::set($field, $error);
            }
            Response::redirect("/forgot/password/email/recovery/" . $e->getErrors()['__token']);
        }

        Flash::set('success', 'Senha alterada com sucesso!');
        Response::redirect("/login", [
            'email' => $userEmail
        ]);
    }
}