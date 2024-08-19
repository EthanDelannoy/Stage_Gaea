<?php

namespace App\Service;

use DateTimeInterface;

class UserService
{
    /**
     * Calcule l'âge d'une personne en fonction de sa date de naissance.
     *
     * @param DateTimeInterface|null $birthdate La date de naissance de l'utilisateur.
     * @return int|null L'âge de l'utilisateur, ou null si la date de naissance n'est pas définie.
     */
    public function calculateAge(?DateTimeInterface $birthdate): ?int
    {
        if ($birthdate === null) {
            return null;
        }

        $today = new \DateTime();
        $age = $today->diff($birthdate)->y;

        return $age;
    }
}