<?php

namespace Validators;

use Support\Csrf;

class ForgotPasswordFormValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

//        if (Csrf::validateToken()) {
//            $errors['error'] = Csrf::validateToken();
//        }

        foreach ($data as $field => $value) {
            if (empty($value)) {
                $errors[$field] = "$field is required";
            }
        }

        if (empty($errors)) {

            if ($data['password'] != $data['password_confirm']) {
                $errors['password'] = "Passwords do not match";
                $errors['password_confirm'] = "Passwords do not match";
            }
        }

        return $errors;
    }
}