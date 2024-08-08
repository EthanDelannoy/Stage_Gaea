<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BanWordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var BanWord $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $value = strtolower($value); //met la valeur en majuscule 

        foreach($constraint->banWords as $banWord){
            if (str_contains($value, $banWord)) { // Si détecte un mot bannie alors l'erreur se met 
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ banWord }}', $banWord)
                ->addViolation();
            }
        }
    }
}
