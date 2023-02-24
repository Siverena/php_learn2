<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\LikesRepository;

use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\Exceptions\LikeNotFoundException;
use GeekBrains\LevelTwo\Blog\Like;
use GeekBrains\LevelTwo\Blog\UUID;
use \PDO;

class SqliteLikesRepository implements LikesRepositoryInterface
{
	private PDO $connection;
	public function __construct(PDO $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @param Like $like
	 */
	public function save(Like $like): void
	{
		$statement = $this->connection->prepare(
			'INSERT INTO likes (uuid, post_uuid, author_uuid) VALUES (:uuid, :post_uuid, :author_uuid)'
		);
		$statement-> execute([
			':uuid' => $like->uuid(),
			':post_uuid' => $like->getPost(),
			':author_uuid' => $like->getAuthor()
		]);
	}

	/**
	 * @param UUID $uuid
	 * @return Like
	 * @throws LikeNotFoundException
	 * @throws InvalidArgumentException
	 */
	public function get(UUID $uuid): Like
	{
		$statement = $this->connection->prepare(
			'SELECT * FROM likes WHERE uuid = :uuid'
		);
		$statement->execute([
			':uuid' => (string)$uuid,
		]);
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if ($result === false) {
			throw new LikeNotFoundException(
				"Cannot find like: $uuid"
			);
		}
		return new Like(
			new UUID($result['uuid']),
			new UUID($result['post_uuid']),
			new UUID($result['author_uuid'])
		);
	}

	/**
	 * @param UUID $post_uuid
	 * @return Array
	 * @throws LikeNotFoundException
	 */
	public function getByPostUuid(UUID $post_uuid): array
	{
		$statement = $this->connection->prepare(
			'SELECT * FROM likes WHERE post_uuid = :post_uuid'
		);
		$statement->execute([
			':uuid' => (string)$post_uuid,
		]);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if ($result === false) {
			throw new LikeNotFoundException(
				"Cannot find likes by post: $post_uuid"
			);
		}
		$likes = [];
		foreach ($result as $like) {
			$likes[] = new Like(
				new UUID($like['uuid']),
				new UUID($like['post_uuid']),
				new UUID($like['author_uuid'])
			);
		}
		return $likes;
	}
}