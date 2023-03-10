<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\PostsRepository;

use GeekBrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use GeekBrains\LevelTwo\Blog\Post;
use GeekBrains\LevelTwo\Blog\UUID;
use \PDO;

class SqlitePostsRepository implements PostsRepositoryInterface
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Post $post
     */
    public function save(Post $post): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text) VALUES (:uuid, :author_uuid, :title, :text) '
        );
        $statement-> execute([
            ':uuid' => $post->uuid(),
            ':author_uuid' => $post->getAuthor(),
            ':title' => $post->getTitle(),
            ':text' => $post->getText()
        ]);
    }

    /**
     * @param UUID $uuid
     * @return Post
     * @throws PostNotFoundException
     * @throws \GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException
     */
    public function get(UUID $uuid): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new PostNotFoundException(
                "Cannot find post: $uuid"
            );
        }
        return new Post(
            new UUID($result['uuid']),
            new UUID($result['author_uuid']),
            $result['title'],
            $result['text']
        );
    }

	/**
	 * @param UUID $uuid
	 */
	public function delete(UUID $uuid): void
	{
		$statement = $this->connection->prepare(
			'DELETE FROM posts WHERE uuid = :uuid'
		);
		$statement-> execute([
			':uuid' => (string)$uuid
		]);
	}
}