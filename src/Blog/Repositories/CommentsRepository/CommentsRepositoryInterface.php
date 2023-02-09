<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\CommentsRepository;

use GeekBrains\LevelTwo\Blog\Comment;
use GeekBrains\LevelTwo\Blog\UUID;

interface CommentsRepositoryInterface
{
    /**
     * @param Comment $user
     */
    public function save(Comment $user): void;

    /**
     * @param UUID $uuid
     * @return Comment
     */
    public function get(UUID $uuid): Comment;
}