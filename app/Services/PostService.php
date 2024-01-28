<?php

namespace App\Services;

use App\Entities\Post;
use Doctrine\DBAL\Connection;

class PostService
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    public function save(Post $post): Post
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('posts')
            ->values([
                'title' => ':title',
                'content' => ':content',
                'created_at' => ':created_at'
            ])
            ->setParameters([
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
            ])
            ->executeQuery();

        $postId = $this->connection->lastInsertId();
        $post->setId($postId);

        return $post;
    }
}