<?php

namespace App\Http\Controllers;

use App\Exceptions\EmailEmptyException;
use App\Exceptions\EmailFormatException;
use App\Exceptions\IncorrectNameException;
use App\Exceptions\InvalidBioException;
use App\Exceptions\InvalidJobSphereException;
use App\Exceptions\InvalidProfilePhotoLinkException;
use App\Exceptions\NameEmptyException;
use App\Exceptions\PasswordEmptyException;
use App\Exceptions\PasswordTooBigException;
use App\Exceptions\PasswordTooShortException;
use App\Http\Services\interfaces\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws NameEmptyException
     * @throws IncorrectNameException
     * @throws EmailEmptyException
     * @throws InvalidJobSphereException
     * @throws InvalidBioException
     * @throws InvalidProfilePhotoLinkException
     * @throws PasswordTooBigException
     * @throws PasswordTooShortException
     * @throws PasswordEmptyException
     * @throws EmailFormatException
     */
    public function create(Request $request): JsonResponse
    {
        $name = $request->input('name');
        if (empty($name)) {
            throw new NameEmptyException('Name field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_string($name)) {
            throw new IncorrectNameException('Name field should be a string', Response::HTTP_BAD_REQUEST);
        }

        $email = $request->input('email');
        if (empty($email)) {
            throw new EmailEmptyException('Email field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailFormatException('Invalid email format', Response::HTTP_BAD_REQUEST);
        }

        $password = $request->input('password');
        if (empty($password)) {
            throw new PasswordEmptyException('Password field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (strlen($password) < 6) {
            throw new PasswordTooShortException(
                'Password should be at least 6 characters long',
                Response::HTTP_BAD_REQUEST
            );
        }
        if (strlen($password) > 16) {
            throw new PasswordTooBigException(
                'Password should not be more than 16 characters long',
                Response::HTTP_BAD_REQUEST
            );
        }

        $profilePhotoLink = $request->input('profile_photo_link');
        if (!is_string($profilePhotoLink)) {
            throw new IncorrectNameException(
                'Profile photo link field should be a string',
                Response::HTTP_BAD_REQUEST
            );
        }
        if ($profilePhotoLink !== null && !filter_var($profilePhotoLink, FILTER_VALIDATE_URL)) {
            throw new InvalidProfilePhotoLinkException(
                'Invalid profile photo link format',
                Response::HTTP_BAD_REQUEST
            );
        }

        $bio = $request->input('bio');
        if ($bio !== null && !is_string($bio)) {
            throw new InvalidBioException(
                'Bio field should be a string',
                Response::HTTP_BAD_REQUEST
            );
        }

        $jobSphere = $request->input('job_sphere');
        if ($jobSphere !== null && !is_string($jobSphere)) {
            throw new InvalidJobSphereException(
                'Job sphere field should be a string',
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $this->userService->create($name, $email, $password, $profilePhotoLink, $bio, $jobSphere);

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }
}
