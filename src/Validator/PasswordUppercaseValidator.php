<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordUppercaseValidator extends ConstraintValidator
{
    public function validate($pwd, Constraint $constraint) 
    {
        if (!$constraint instanceof PasswordUppercase)
            throw new UnexpectedTypeException($constraint, PasswordUppercase::class);

        if (null === $pwd || '' === $pwd)
            return;
        
        $no_uppercase = preg_match('/(?=.*[A-Z])/', $pwd) == false;

        if ($no_uppercase)
            $this->context->buildViolation($constraint->message, [], 'validators')
                ->addViolation();
    }
}