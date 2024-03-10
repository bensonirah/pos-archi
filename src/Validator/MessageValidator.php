<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MessageValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var Message $constraint */

        if (null === $value || '' === $value) {
            return;
        }
        if (strlen($value)<30) {
            return;
        }
        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
