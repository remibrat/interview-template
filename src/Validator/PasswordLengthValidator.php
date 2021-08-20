<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PasswordLengthValidator extends ConstraintValidator
{
    public function validate($pwd, Constraint $constraint) 
    {
        if (!$constraint instanceof PasswordLength)
            throw new UnexpectedTypeException($constraint, PasswordLength::class);

        if (null === $pwd || '' === $pwd)
            return;

        // check if pwd length is superior to 8
        $too_short = strlen($pwd) < 8;

        if ($too_short)
            $this->context->buildViolation($constraint->message, [], 'validators')
                ->addViolation();
    }
}