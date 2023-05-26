<?php

namespace App\Http\Services;

use App\Exceptions\EmailExistsException;
use App\Http\Services\interfaces\UserService;
use App\Models\User;
use Illuminate\Http\Response;

class UserServiceImpl implements UserService
{

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string|null $profilePhotoLink
     * @param string|null $bio
     * @param string|null $jobSphere
     * @return array
     * @throws EmailExistsException
     */
    public function create(string $name, string $email, string $password, string $profilePhotoLink = null,
                           string $bio = null, string $jobSphere = null): array
    {
        $user = new User();
        $user->name = $name;

        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            throw new EmailExistsException(
                "User with Email $email already exists.",
                Response::HTTP_BAD_REQUEST
            );
        }

        $user->email = $email;
        $user->password = bcrypt($password);
        $user->profile_photo_link = $profilePhotoLink;
        $user->bio = $bio;
        $user->job_sphere = $jobSphere;
        $user->save();

        return $user->toArray();
    }
}
