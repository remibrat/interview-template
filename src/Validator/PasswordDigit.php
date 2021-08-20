<?php

namespace App\Validator;

use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraint;

/**
* @Annotation
* @Assert
*/
class PasswordDigit extends Constraint
{
    public $message = "Your password must contains at least one number";
}