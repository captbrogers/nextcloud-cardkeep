<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Brian Rogers <captbrogers@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CardKeep\Db;

use JsonSerializable;
use OCP\AppFramework\Db\Entity;

/**
 * @method getId(): int
 * @method getTitle(): string
 * @method setTitle(string $title): void
 * @method getContent(): string
 * @method setContent(string $content): void
 * @method getCreatedAt(): ?string
 * @method getUpdatedAt(): ?string
 * @method getUserId(): string
 * @method setUserId(string $userId): void
 */
class Note extends Entity implements JsonSerializable
{
    protected string $title = '';
    protected string $content = '';
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;
    protected string $userId = '';

    public function jsonSerialize(): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'content'    => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
