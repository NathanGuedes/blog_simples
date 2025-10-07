<?php

namespace Validators;

use Support\Csrf;

class SessionFormValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (Csrf::validateToken()) {
            $errors['error'] = Csrf::validateToken();
        }

        foreach($data as $field => $value){
            if (empty($value)){
                $errors[$field] = "$field is required";
            }
        }

        if (empty($errors)){

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email address is not valid";
            }
        }

        return $errors;
    }
}