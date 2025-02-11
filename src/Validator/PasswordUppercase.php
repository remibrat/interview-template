<?php

namespace App\Validator;

use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraint;

/**
* @Annotation
* @Assert
*/
class PasswordUppercase extends Constraint
{
    public $message = "Your password must contains at least one uppercase letter";
}