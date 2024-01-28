<?php

namespace App\Entities;

class Post
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $content,
        private \DateTimeImmutable|null $createdAt
    )
    {
    }

    public static function create(
        string $title,
        string $content,
        int $id = null,
        \DateTimeImmutable|null $createdAt = null
    ): static
    {
        return new static($id, $title, $content, $createdAt);
    }
}