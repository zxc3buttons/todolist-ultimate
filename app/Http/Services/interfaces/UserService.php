<?php

namespace App\Http\Services\interfaces;

interface UserService
{
    public function create(string $name, string $email, string $password,
                           string $profilePhotoLink = null, string $bio = null, string $jobSphere = null): array;
}
