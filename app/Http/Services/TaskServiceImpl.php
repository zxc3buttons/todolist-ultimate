<?php

namespace App\Http\Services;

use App\Exceptions\CategoryNotFoundException;
use App\Exceptions\InvalidDataFormatException;
use App\Exceptions\ProjectNotFoundException;
use App\Exceptions\StatusNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Services\interfaces\TaskService;
use App\Models\Category;
use App\Models\Project;
use App\Models\Report;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TaskServiceImpl implements TaskService
{

    /**
     * @inheritDoc
     */
    public function getTask(int $taskId): Task
    {
        // TODO: Implement getTask() method.
    }

    /**
     * @inheritDoc
     */
    public function getTasks(): Collection
    {
        // TODO: Implement getTasks() method.
    }

    /**
     * @inheritDoc
     */
    public function getTasksByCategory(int $categoryId): Collection
    {
        // TODO: Implement getTasksByCategory() method.
    }

    /**
     * @inheritDoc
     */
    public function getTasksByStatus(int $statusId): Collection
    {
        // TODO: Implement getTasksByStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function getSortedTasksByEndTime(): Collection
    {
        // TODO: Implement getSortedTasksByEndTime() method.
    }

    /**
     * @inheritDoc
     */
    public function getSortedTasksByStartTime(): Collection
    {
        // TODO: Implement getSortedTasksByStartTime() method.
    }

    /**
     * @inheritDoc
     */
    public function getTasksInCertainFormat(string $format): string
    {
        // TODO: Implement getTasksInCertainFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function getTasksByAssign(int $assignId): Collection
    {
        // TODO: Implement getTasksByAssign() method.
    }

    /**
     * @inheritDoc
     * @throws UserNotFoundException
     * @throws ProjectNotFoundException
     * @throws StatusNotFoundException
     * @throws InvalidDataFormatException
     * @throws CategoryNotFoundException
     */
    public function create(int $userId, string $name, int $categoryId, string $description,
                               int $projectId, int $statusId,
                               string $shouldBeEndedAt, string $attachedFileLink): Task|JsonResponse
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                throw new UserNotFoundException("User with ID $userId not found.");
            }

            $category = Category::find($categoryId);
            if (!$category) {
                throw new CategoryNotFoundException("Category with ID $categoryId not found.");
            }

            $project = Project::find($projectId);
            if (!$project) {
                throw new ProjectNotFoundException("Project with ID $projectId not found.");
            }

            $status = Status::find($statusId);
            if (!$status) {
                throw new StatusNotFoundException("Status with ID $statusId not found.");
            }

            $shouldBeEndedAtTimestamp = strtotime($shouldBeEndedAt);
            if (!$shouldBeEndedAtTimestamp) {
                throw new InvalidDataFormatException("Invalid date format for shouldBeEndedAt parameter.");
            }

        } catch (Exception $exception){
            Log::notice('Not Found 404: '. $exception->getMessage());
            return response()->json([
                'title' => 'Not Found',
                'message' => $exception->getMessage(),
                'code' => 404
            ], 404);
        }

        try {
            $task = new Task([
                'user_id' => $userId,
                'name' => $name,
                'category_id' => $categoryId,
                'description' => $description,
                'project_id' => $projectId,
                'status_id' => $statusId,
                'should_be_ended' => date('Y-m-d H:i:s', $shouldBeEndedAtTimestamp),
                'attached_file_link' => $attachedFileLink,
            ]);

            $task->save();

            return $task;

        } catch (Exception $exception) {
            Log::error('Internal Server Error 500: '. $exception->getMessage());
            return response()->json([
                'title' => 'Internal Server Error',
                'code' => 500
            ], 500);
        }
    }

    /**
     * @inheritDoc
     */
    public function updateTask(int $taskId, int $userId, string $name, int $categoryId,
                               string $description, int $statusId, string $attachedFileLink): Task
    {
        // TODO: Implement updateTask() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteTask(int $taskId): Task
    {
        // TODO: Implement deleteTask() method.
    }

    /**
     * @inheritDoc
     */
    public function restoreTask(int $taskId): Task
    {
        // TODO: Implement restoreTask() method.
    }

    /**
     * @inheritDoc
     */
    public function decomposeTask(array $todos, int $taskId): Task
    {
        // TODO: Implement decomposeTask() method.
    }

    /**
     * @inheritDoc
     */
    public function getProgressBar(int $taskId): int
    {
        // TODO: Implement getProgressBar() method.
    }

    /**
     * @inheritDoc
     */
    public function setAssignsToTask(array $assigns, int $taskId): Task
    {
        // TODO: Implement setAssignsToTask() method.
    }

    /**
     * @inheritDoc
     */
    public function getReportByTimeInterval(array $params, string $dateFirst, string $dateSecond): Report
    {
        // TODO: Implement getReportByTimeInterval() method.
    }
}
