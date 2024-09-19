<?php

namespace App\Service;

use App\Entity\User;
use DateTime;

class UserService
{
    public function calculateAge(User $user): int
    {
        $birthDate = $user->getBirthDate();
        $date = new DateTime();
        $age = $date->diff($birthDate)->y;
        return $age;
    }
}