<?php

namespace Services;

use Contracts\UserRepositoryInterface;
use Exceptions\ValidationException;
use Models\User;
use Random\RandomException;
use Support\Token;
use Validators\RegisterFormValidator;

class RegisterService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws RandomException
     * @throws ValidationException
     */
    public function register(array $formData): void
    {
        $errors = RegisterFormValidator::validate($formData);

        if (!empty($errors)) {
            throw new ValidationException($errors, code: 400);
        }

        $this->userRepository->create(
            new User($formData['name'], $formData['email'], $formData['password'])
        );
    }
}
