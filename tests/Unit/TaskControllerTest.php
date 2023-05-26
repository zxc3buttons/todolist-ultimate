<?php

use App\Exceptions\AttachedFileLinkEmptyException;
use App\Exceptions\CategoryIdEmptyException;
use App\Exceptions\DescriptionEmptyException;
use App\Exceptions\IncorrectCategoryIdException;
use App\Exceptions\IncorrectDescriptionException;
use App\Exceptions\IncorrectNameException;
use App\Exceptions\IncorrectProjectIdException;
use App\Exceptions\IncorrectStatusIdException;
use App\Exceptions\IncorrectUserIdException;
use App\Exceptions\NameEmptyException;
use App\Exceptions\ProjectIdEmptyException;
use App\Exceptions\ShouldBeEndedAtEmptyException;
use App\Exceptions\StatusIdEmptyException;
use App\Exceptions\UserIdEmptyException;
use App\Http\Controllers\TaskController;
use App\Http\Services\interfaces\TaskService;
use App\Http\Services\interfaces\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{

    /** @var UserService|MockInterface */
    private MockInterface|UserService $taskServiceMock;

    /** @var TaskController */
    private TaskController $taskController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskServiceMock = Mockery::mock(TaskService::class);
        $this->taskController = new TaskController($this->taskServiceMock);
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testCreateThrowsUserIdEmptyException(): void
    {
        $request = new Request(['userId' => '']);

        $this->expectException(UserIdEmptyException::class);
        $this->expectExceptionMessage('UserId field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsIncorrectUserIdException(): void
    {
        $request = new Request(['userId' => 'abc']);

        $this->expectException(IncorrectUserIdException::class);
        $this->expectExceptionMessage('UserId field should be a integer number');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsNameEmptyException(): void
    {
        $request = new Request(['userId' => 1, 'name' => '']);

        $this->expectException(NameEmptyException::class);
        $this->expectExceptionMessage('Name field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsIncorrectNameException(): void
    {
        $request = new Request(['userId' => 1, 'name' => 123]);

        $this->expectException(IncorrectNameException::class);
        $this->expectExceptionMessage('Name field should be a string');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsCategoryIdEmptyException(): void
    {
        $request = new Request(['userId' => 1, 'name' => '123', 'categoryId' => '']);

        $this->expectException(CategoryIdEmptyException::class);
        $this->expectExceptionMessage('CategoryId field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsIncorrectCategoryIdException(): void
    {
        $request = new Request(['userId' => 1, 'name' => '123', 'categoryId' => 'das']);

        $this->expectException(IncorrectCategoryIdException::class);
        $this->expectExceptionMessage('CategoryId field should be a integer number');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsDescriptionEmptyException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => ''
        ]);

        $this->expectException(DescriptionEmptyException::class);
        $this->expectExceptionMessage('Description field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsIncorrectDescriptionException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => 12
        ]);

        $this->expectException(IncorrectDescriptionException::class);
        $this->expectExceptionMessage('Description field should be a string');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsProjectIdEmptyException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => '12',
            'projectId' => ''
        ]);

        $this->expectException(ProjectIdEmptyException::class);
        $this->expectExceptionMessage('ProjectId field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsIncorrectProjectIdException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => '12',
            'projectId' => 'da'
        ]);

        $this->expectException(IncorrectProjectIdException::class);
        $this->expectExceptionMessage('ProjectId field should be a integer number');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsStatusIdEmptyException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => '12',
            'projectId' => 1,
            'statusId' => ''
        ]);

        $this->expectException(StatusIdEmptyException::class);
        $this->expectExceptionMessage('StatusId field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsIncorrectStatusIdException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => '12',
            'projectId' => 1,
            'statusId' => 'czx'
        ]);

        $this->expectException(IncorrectStatusIdException::class);
        $this->expectExceptionMessage('StatusId field should be a integer number');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsShouldBeEndedAtEmptyException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => '12',
            'projectId' => 1,
            'statusId' => 1,
            'shouldBeEndedAt' => '',

        ]);

        $this->expectException(ShouldBeEndedAtEmptyException::class);
        $this->expectExceptionMessage('ShouldBeEndedAt field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }

    public function testCreateThrowsAttachedFileLinkEmptyException(): void
    {
        $request = new Request([
            'userId' => 1,
            'name' => '123',
            'categoryId' => 1,
            'description' => '12',
            'projectId' => 1,
            'statusId' => 1,
            'shouldBeEndedAt' => '2022-12-12 18:46:21',

        ]);

        $this->expectException(AttachedFileLinkEmptyException::class);
        $this->expectExceptionMessage('AttachedFileLink field is empty');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->taskController->create($request);
    }
}
