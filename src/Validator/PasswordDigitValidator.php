<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordDigitValidator extends ConstraintValidator
{
    public function validate($pwd, Constraint $constraint) 
    {
        if (!$constraint instanceof PasswordDigit)
            throw new UnexpectedTypeException($constraint, PasswordDigit::class);

        if (null === $pwd || '' === $pwd)
            return;
        
        $no_digit = preg_match('/(?=.*\d)/', $pwd) == false;

        if ($no_digit)
            $this->context->buildViolation($constraint->message, [], 'validators')
                ->addViolation();
    }
}