<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\LikesRepository;

use GeekBrains\LevelTwo\Blog\Like;
use GeekBrains\LevelTwo\Blog\UUID;

interface LikesRepositoryInterface
{
	/**
	 * @param Like $like
	 */
	public function save(Like $like): void;

	/**
	 * @param UUID $uuid
	 * @return Like
	 */
	public function get(UUID $uuid): Like;

	/**
	 * @param UUID $post_uuid
	 * @return Like
	 */
	public function getByPostUuid(UUID $post_uuid): Like;
}