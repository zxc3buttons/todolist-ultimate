<?php

namespace Tests\Unit;

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
use App\Http\Controllers\UserController;
use App\Http\Services\interfaces\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /** @var UserController */
    private UserController $userController;

    protected function setUp(): void
    {
        parent::setUp();

        $userServiceMock = Mockery::mock(UserService::class);
        $this->userController = new UserController($userServiceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testCreateThrowsNameEmptyException(): void
    {
        $request = new Request(['name' => '']);

        $this->expectException(NameEmptyException::class);
        $this->expectExceptionMessage('Name field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsIncorrectNameException(): void
    {
        $request = new Request(['name' => 123]);

        $this->expectException(IncorrectNameException::class);
        $this->expectExceptionMessage('Name field should be a string');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsEmailEmptyException(): void
    {
        $request = new Request(['name' => 'John', 'email' => '']);

        $this->expectException(EmailEmptyException::class);
        $this->expectExceptionMessage('Email field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsEmailFormatException(): void
    {
        $request = new Request(['name' => 'John', 'email' => 'invalid_email']);

        $this->expectException(EmailFormatException::class);
        $this->expectExceptionMessage('Invalid email format');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsPasswordEmptyException(): void
    {
        $request = new Request(['name' => 'John', 'email' => 'john@example.com', 'password' => '']);

        $this->expectException(PasswordEmptyException::class);
        $this->expectExceptionMessage('Password field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsPasswordTooShortException(): void
    {
        $request = new Request(['name' => 'John', 'email' => 'john@example.com', 'password' => '123']);

        $this->expectException(PasswordTooShortException::class);
        $this->expectExceptionMessage('Password should be at least 6 characters long');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsPasswordTooBigException(): void
    {
        $request = new Request(['name' => 'John', 'email' => 'john@example.com', 'password' => '12212121212121212123']);

        $this->expectException(PasswordTooBigException::class);
        $this->expectExceptionMessage('Password should not be more than 16 characters long');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsIncorrectNameExceptionWhenFileLinkInCorrect(): void
    {
        $request = new Request([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '122121212121',
            'profile_photo_link' => 1111
        ]);

        $this->expectException(IncorrectNameException::class);
        $this->expectExceptionMessage('Profile photo link field should be a string');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsInvalidProfilePhotoLinkException(): void
    {
        $request = new Request([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '122121212121',
            'profile_photo_link' => '1111'
        ]);

        $this->expectException(InvalidProfilePhotoLinkException::class);
        $this->expectExceptionMessage('Invalid profile photo link format');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsInvalidBioException(): void
    {
        $request = new Request([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '122121212121',
            'profile_photo_link' => 'http://qweqwe.ru/img1',
            'bio' => 123
        ]);

        $this->expectException(InvalidBioException::class);
        $this->expectExceptionMessage('Bio field should be a string');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }

    public function testCreateThrowsInvalidJobSphereException(): void
    {
        $request = new Request([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '122121212121',
            'profile_photo_link' => 'https://qweqwe.ru/img1',
            'bio' => '123',
            'job_sphere' => 123
        ]);

        $this->expectException(InvalidJobSphereException::class);
        $this->expectExceptionMessage('Job sphere field should be a string');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->userController->create($request);
    }
}
