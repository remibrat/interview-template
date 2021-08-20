<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordLowercaseValidator extends ConstraintValidator
{
    public function validate($pwd, Constraint $constraint) 
    {
        if (!$constraint instanceof PasswordLowercase)
            throw new UnexpectedTypeException($constraint, PasswordLowercase::class);

        if (null === $pwd || '' === $pwd)
            return;
        
        // check if pwd contains lowercase letter(s)
        $no_lowercase = preg_match('/(?=.*[a-z])/', $pwd) == false;

        if ($no_lowercase)
            $this->context->buildViolation($constraint->message, [], 'validators')
                ->addViolation();
    }
}