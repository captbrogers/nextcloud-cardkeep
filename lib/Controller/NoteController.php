<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Brian Rogers <captbrogers@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CardKeep\Controller;

use OCA\CardKeep\AppInfo\Application;
use OCA\CardKeep\Controller\Errors;
use OCA\CardKeep\Service\NoteService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class NoteController extends Controller
{
    use Errors;

    /**
     * The service provider for Notes.
     *
     * @var \OCA\CardKeep\Service\NoteService
     */
    private NoteService $service;

    /**
     * The User's ID.
     *
     * @var string|null
     */
    private ?string $userId;

    /**
     * Class constructor.
     *
     * @package Namespace\App\Class
     * @since   1.0.0
     *
     * @param OCP\IRequest\IRequest            $request  NextCloud's Request object.
     * @param OCA\CardKeep\Service\NoteService $service  The Note service provider.
     * @param string|null                      $userId   The user ID to use.
     *
     * @return void
     */
    public function __construct(IRequest $request, NoteService $service, ?string $userId)
    {
        parent::__construct(Application::APP_ID, $request);
        $this->service = $service;
        $this->userId = $userId;
    }

    /**
     * Show all the Notes.
     *
     * @NoAdminRequired
     *
     * @package OCA\CardKeep\Controller\NoteController
     * @since   1.0.0
     *
     * @return \OCP\AppFramework\Http\DataResponse
     */
    public function index(): DataResponse
    {
        return new DataResponse($this->service->findAll($this->userId));
    }

    /**
     * Show a specific Note by ID.
     *
     * @NoAdminRequired
     *
     * @package OCA\CardKeep\Controller\NoteController
     * @since   1.0.0
     *
     * @param int $id  The ID of the note.
     *
     * @return \OCP\AppFramework\Http\DataResponse
     */
    public function show(int $id): DataResponse
    {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->find($id, $this->userId);
        });
    }

    /**
     * Show the page/form to create a new Note.
     *
     * @NoAdminRequired
     *
     * @package OCA\CardKeep\Controller\NoteController
     * @since   1.0.0
     *
     * @param string $title    The title of the note.
     * @param string $content  The content of the note.
     *
     * @return \OCP\AppFramework\Http\DataResponse
     */
    public function create(string $title, string $content): DataResponse
    {
        return new DataResponse($this->service->create($title, $content, $this->userId));
    }

    /**
     * Update a Note by ID.
     *
     * @NoAdminRequired
     *
     * @package OCA\CardKeep\Controller\NoteController
     * @since   1.0.0
     *
     * @param int    $id       The ID of the note.
     * @param string $title    The title of the note.
     * @param string $content  The content of the note.
     *
     * @return \OCP\AppFramework\Http\DataResponse
     */
    public function update(int $id, string $title, string $content): DataResponse
    {
        return $this->handleNotFound(function () use ($id, $title, $content) {
            return $this->service->update($id, $title, $content, $this->userId);
        });
    }

    /**
     * Destroy a Note by ID.
     *
     * @NoAdminRequired
     *
     * @package OCA\CardKeep\Controller\NoteController
     * @since   1.0.0
     *
     * @param int $id  The ID of the note.
     *
     * @return \OCP\AppFramework\Http\DataResponse
     */
    public function destroy(int $id): DataResponse
    {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->delete($id, $this->userId);
        });
    }
}
