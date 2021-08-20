<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordSpecialValidator extends ConstraintValidator
{
    public function validate($pwd, Constraint $constraint) 
    {
        if (!$constraint instanceof PasswordSpecial)
            throw new UnexpectedTypeException($constraint, PasswordSpecial::class);

        if (null === $pwd || '' === $pwd)
            return;
        
        // check if pwd contains special character(s)
        $no_special = preg_match('/(?=.*[!@#$%^&*.,:=?;+])/', $pwd) == false;

        if ($no_special)
            $this->context->buildViolation($constraint->message, [], 'validators')
                ->addViolation();
    }
}