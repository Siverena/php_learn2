<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\CommentsRepository;

use GeekBrains\LevelTwo\Blog\Comment;
use GeekBrains\LevelTwo\Blog\UUID;

interface CommentsRepositoryInterface
{
    /**
     * @param Comment $comment
     */
    public function save(Comment $comment): void;

    /**
     * @param UUID $uuid
     * @return Comment
     */
    public function get(UUID $uuid): Comment;
}