<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BanWord extends Constraint
{
     public function __construct( // les mots choisis banni 
        public string $message = 'This contains a banned word "{{ banWord }}".', //message pour dire que le mot est banni 
        public array $banWords = ['spam', 'viagra'], // les mots banni
        ?array $groups = null,
        mixed $payload = null
        ) {

            parent:: __construct(null, $groups, $payload);
    }



}
