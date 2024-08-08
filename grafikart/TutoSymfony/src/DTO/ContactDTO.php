<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO {

    #[Assert\NotBlank] // ne peux pas être vide 
    #[Assert\Length(min: 3, max:20)] // min 3 caractére / max 20 caractére
    public string $name = '';

    #[Assert\NotBlank] // ne peux pas être vide 
    #[Assert\Email] // il faut que son email soit valide 
    public string $email = '';

    #[Assert\NotBlank] // ne peux pas être vide 
    #[Assert\Length(min: 3, max:200)] // min 3 caractére / max 200 caractére
    public string $message = '';

    #[Assert\NotBlank]  // ne peux pas être vide 
    public string $service = '';

}