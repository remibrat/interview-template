<?php

namespace App\Validator;

use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraint;

/**
* @Annotation
* @Assert
*/
class PasswordSpecial extends Constraint
{
    public $message = "Your password must contains at least one special character";
}