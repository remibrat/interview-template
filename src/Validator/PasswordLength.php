<?php

namespace App\Validator;

use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraint;

/**
* @Annotation
* @Assert
*/
class PasswordLength extends Constraint
{
    public $message = "Your password must contains at least 8 characters";
}