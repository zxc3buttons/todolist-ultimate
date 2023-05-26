<?php

namespace App\Http\Controllers;

use App\Exceptions\AttachedFileLinkEmptyException;
use App\Exceptions\CategoryIdEmptyException;
use App\Exceptions\DescriptionEmptyException;
use App\Exceptions\IncorrectAttachedFileLinkException;
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
use App\Http\Services\interfaces\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @throws IncorrectUserIdException
     * @throws IncorrectDescriptionException
     * @throws CategoryIdEmptyException
     * @throws StatusIdEmptyException
     * @throws NameEmptyException
     * @throws IncorrectCategoryIdException
     * @throws ShouldBeEndedAtEmptyException
     * @throws DescriptionEmptyException
     * @throws IncorrectProjectIdException
     * @throws ProjectIdEmptyException
     * @throws AttachedFileLinkEmptyException
     * @throws IncorrectAttachedFileLinkException
     * @throws IncorrectStatusIdException
     * @throws IncorrectNameException
     * @throws UserIdEmptyException
     */
    public function create(Request $request): JsonResponse
    {
        $userId = $request->input('userId');
        if (empty($userId)) {
            throw new UserIdEmptyException('UserId field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_int($userId)) {
            throw new IncorrectUserIdException(
                'UserId field should be a integer number',
                Response::HTTP_BAD_REQUEST
            );
        }

        $name = $request->input('name');
        if (empty($name)) {
            throw new NameEmptyException('Name field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_string($name)) {
            throw new IncorrectNameException('Name field should be a string', Response::HTTP_BAD_REQUEST);
        }

        $categoryId = $request->input('categoryId');
        if (empty($categoryId)) {
            throw new CategoryIdEmptyException('CategoryId field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_int($categoryId)) {
            throw new IncorrectCategoryIdException(
                'CategoryId field should be a integer number',
                Response::HTTP_BAD_REQUEST
            );
        }

        $description = $request->input('description');
        if (empty($description)) {
            throw new DescriptionEmptyException('Description field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_string($description)) {
            throw new IncorrectDescriptionException(
                'Description field should be a string',
                Response::HTTP_BAD_REQUEST
            );
        }

        $projectId = $request->input('projectId');
        if (empty($projectId)) {
            throw new ProjectIdEmptyException('ProjectId field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_int($projectId)) {
            throw new IncorrectProjectIdException(
                'ProjectId field should be a integer number',
                Response::HTTP_BAD_REQUEST
            );
        }

        $statusId = $request->input('statusId');
        if (empty($statusId)) {
            throw new StatusIdEmptyException('StatusId field is empty', Response::HTTP_BAD_REQUEST);
        }
        if (!is_int($statusId)) {
            throw new IncorrectStatusIdException(
                'StatusId field should be a integer number',
                Response::HTTP_BAD_REQUEST
            );
        }

        $shouldBeEndedAt = $request->input('shouldBeEndedAt');
        if (empty($shouldBeEndedAt)) {
            throw new ShouldBeEndedAtEmptyException(
                'ShouldBeEndedAt field is empty',
                Response::HTTP_BAD_REQUEST
            );
        }
        if (!is_string($shouldBeEndedAt)) {
            throw new IncorrectStatusIdException(
                'StatusId field should be a integer number',
                Response::HTTP_BAD_REQUEST
            );
        }

        $attachedFileLink = $request->input('attachedFileLink');
        if (empty($attachedFileLink)) {
            throw new AttachedFileLinkEmptyException(
                'AttachedFileLink field is empty',
                Response::HTTP_BAD_REQUEST
            );
        }
        if (!is_string($attachedFileLink)) {
            throw new IncorrectAttachedFileLinkException(
                'AttachedFileLink field should be a string',
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $this->taskService->create(
            $userId,
            $name,
            $categoryId,
            $description,
            $projectId,
            $statusId,
            $shouldBeEndedAt,
            $attachedFileLink
        );

        return response()->json([
            'data' => $user,
        ]);
    }
}
