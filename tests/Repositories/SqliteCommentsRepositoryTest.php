<?php

namespace GeekBrains\LevelTwo\UnitTests\Repositories;

use GeekBrains\LevelTwo\Blog\Comment;
use GeekBrains\LevelTwo\Blog\Exceptions\CommentNotFoundException;
use GeekBrains\LevelTwo\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use GeekBrains\LevelTwo\Blog\UUID;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItSavesPostToDatabase():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementMock = $this->createMock(PDOStatement::class);
        $statementMock
            ->expects($this->once()) // Ожидаем, что будет вызван один раз
            ->method('execute') // метод execute
            ->with([
                ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':post_uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':author_uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':text' => 'text',
            ]);
        $connectionStub->method('prepare')->willReturn($statementMock);
        $repository = new SqliteCommentsRepository($connectionStub);
        $repository->save(
            new Comment(
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                'text'
            )
        );
    }

    /**
     * @throws \GeekBrains\LevelTwo\Blog\Exceptions\CommentNotFoundException
     * @throws \GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException
     */
    public function testItGetsCommentByUuid(): void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementMock = $this->createMock(PDOStatement::class);
        $statementMock->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementMock);

        $commentsRepository = new SqliteCommentsRepository($connectionStub);
        $comment = $commentsRepository->get(new UUID('9dba7ab0-93be-4ff4-9699-165320c97694'));

        $this->assertSame('9dba7ab0-93be-4ff4-9699-165320c97694', (string)$comment->uuid());
    }

    /**
     * @throws \GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException
     */
    public function testItThrowsAnExceptionWhenPostNotFound(): void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('fetch')->willReturn(false);

        $connectionStub->method('prepare')->willReturn($statementStub);
        $repository = new SqliteCommentsRepository($connectionStub);
        $comment = new Comment(
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            'text'
        );

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot find comment: 123e4567-e89b-12d3-a456-426614174000');
        $repository->get(new UUID('123e4567-e89b-12d3-a456-426614174000'));
    }

}