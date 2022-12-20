<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Brian Rogers <captbrogers@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CardKeep\Tests\Unit\Controller;

use OCA\CardKeep\Controller\NoteApiController;

class NoteApiControllerTest extends NoteControllerTest {
	public function setUp(): void {
		parent::setUp();
		$this->controller = new NoteApiController($this->request, $this->service, $this->userId);
	}
}
