<?php

namespace App\Validator;

use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraint;

/**
* @Annotation
* @Assert
*/
class UniqueEmail extends Constraint
{
    public $message = "This email is already used.";
}