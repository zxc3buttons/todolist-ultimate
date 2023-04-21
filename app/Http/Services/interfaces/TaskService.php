<?php

namespace App\Http\Services\interfaces;

use App\Models\Report;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

/**
 * Интерфейс TaskService, каким функционалом будет обладать TaskService
 *
 * @package   todolist-ultimate
 * @version   1.0
 * @author    Oleg Tokarev
 *
 */
interface TaskService
{
    /**
     * Метод получения задачи по её id
     *
     * @param int $taskId
     * @return Task
     */
    public function getTask(int $taskId): Task;

    /**
     * Метод получения всех задач
     *
     * @return Collection
     */
    public function getTasks() : Collection;

    /**
     * Метод получения задач по категоряии
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getTasksByCategory(int $categoryId): Collection;

    /**
     * Метод получения задач по статусу
     *
     * @param int $statusId
     * @return Collection
     */
    public function getTasksByStatus(int $statusId): Collection;

    /**
     * Метод получения отсортированного списка задач по критерию: конечное время выполнения
     *
     * @return Collection
     */
    public function getSortedTasksByEndTime(): Collection;

    /**
     * Метод получения отсортированного списка задач по критерию: стартовое время выполнения
     *
     * @return Collection
     */
    public function getSortedTasksByStartTime(): Collection;

    /**
     * Метод получения задач в определенном формате
     *
     * @param string $format
     * @return string
     */
    public function getTasksInCertainFormat(string $format): string;

    /**
     * Метод получения задач конкретного исполнителя по его id
     *
     * @param int $assignId
     * @return Collection
     */
    public function getTasksByAssign(int $assignId): Collection;

    /**
     * Метод создания задачи
     *
     * @param int $userId
     * @param string $name
     * @param int $categoryId
     * @param string $description
     * @param int $statusId
     * @param string $attachedFileLink
     * @return Task
     */
    public function createTask(int $userId, string $name, int $categoryId,
                               string $description,
                               int $statusId, string $attachedFileLink): Task;

    /**
     * Метод обновления задачи
     *
     * @param int $taskId
     * @param int $userId
     * @param string $name
     * @param int $categoryId
     * @param string $description
     * @param int $statusId
     * @param string $attachedFileLink
     * @return Task
     */
    public function updateTask(int $taskId, int $userId, string $name,
                               int $categoryId, string $description,
                               int $statusId, string $attachedFileLink): Task;

    /**
     * Метод удаления задачи
     *
     * @param int $taskId
     * @return Task
     */
    public function deleteTask(int $taskId): Task;

    /**
     * Метод восстановления задачи
     *
     * @param int $taskId
     * @return Task
     */
    public function restoreTask(int $taskId): Task;

    /**
     * Метод для декомпозиции задачи
     *
     * @param array $todos
     * @param int $taskId
     * @return Task
     */
    public function decomposeTask(array $todos, int $taskId): Task;

    /**
     * Метод получения прогресса выполнения задачи
     *
     * @param int $taskId
     * @return int
     */
    public function getProgressBar(int $taskId): int;

    /**
     * Метод установки исполнителей на задчу
     *
     * @param array $assigns
     * @param int $taskId
     * @return Task
     */
    public function setAssignsToTask(array $assigns, int $taskId) : Task;

    /**
     * Метод получения отчёта по определенному интервалу времени
     *
     * @param array $params
     * @param string $dateFirst
     * @param string $dateSecond
     * @return Report
     */
    public function getReportByTimeInterval(array $params, string $dateFirst, string $dateSecond) : Report;
}
