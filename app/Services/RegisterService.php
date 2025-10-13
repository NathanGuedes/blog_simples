<?php

namespace Services;

use Contracts\UserRepositoryInterface;
use Exceptions\ValidationException;
use Models\UserDTO;
use Utils\Validator;

class RegisterService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ValidationException
     */
    public function register(array $data): void
    {
        $validator = new Validator();
        $validator
            ->required('name', $data['name'] ?? null, 'Name')
            ->minLength('name', $data['name'] ?? null, 1, 'Name')
            ->required('email', $data['email'] ?? null, 'Email')
            ->email('email', $data['email'] ?? null, 'Email')
            ->required('password', $data['password'] ?? null, 'Password')
            ->required('password_confirm', $data['password_confirm'] ?? null, 'Password Confirm')
            ->minLength('password', $data['password'] ?? null, 6, 'Password')
            ->passwordMatch('password', [$data['password'], $data['password_confirm']], 'Password');

        if ($validator->fails()) {
            throw new ValidationException($validator->getErrors());
        }

        $this->userRepository->create(
            new UserDTO($data)
        );
    }
}
