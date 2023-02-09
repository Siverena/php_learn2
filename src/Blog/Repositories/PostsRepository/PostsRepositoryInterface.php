<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\PostsRepository;

use GeekBrains\LevelTwo\Blog\Post;
use GeekBrains\LevelTwo\Blog\UUID;

interface PostsRepositoryInterface
{
    /**
     * @param Post $user
     */
    public function save(Post $user): void;

    /**
     * @param UUID $uuid
     * @return Post
     */
    public function get(UUID $uuid): Post;
}