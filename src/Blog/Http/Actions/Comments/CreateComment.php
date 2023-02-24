<?php

namespace GeekBrains\LevelTwo\Blog\Http\Actions\Comments;

use GeekBrains\LevelTwo\Blog\Comment;
use GeekBrains\LevelTwo\Blog\Exceptions\HttpException;
use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\Http\Actions\ActionInterface;
use GeekBrains\LevelTwo\Blog\Http\ErrorResponse;
use GeekBrains\LevelTwo\Blog\Http\Request;
use GeekBrains\LevelTwo\Blog\Http\Response;
use GeekBrains\LevelTwo\Blog\Http\SuccessfulResponse;
use GeekBrains\LevelTwo\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use GeekBrains\LevelTwo\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use GeekBrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use GeekBrains\LevelTwo\Blog\UUID;

class CreateComment implements ActionInterface
{
// Внедряем репозитории статей и пользователей
	public function __construct(
		private CommentsRepositoryInterface $commentsRepository,
		private PostsRepositoryInterface $postsRepository,
		private UsersRepositoryInterface $usersRepository,
	) {
	}
	public function handle(Request $request): Response
	{
		// Пытаемся создать UUID пользователя из данных запроса
		try {
			$authorUuid = new UUID($request->jsonBodyField('author_uuid'));
		} catch (HttpException | InvalidArgumentException $e) {
			return new ErrorResponse($e->getMessage());
		}
		try {
			$postUuid = new UUID($request->jsonBodyField('post_uuid'));
		} catch (HttpException | InvalidArgumentException $e) {
			return new ErrorResponse($e->getMessage());
		}
		// Пытаемся найти пользователя в репозитории
		try {
			$this->usersRepository->get($authorUuid);
		} catch (UserNotFoundException $e) {
			return new ErrorResponse($e->getMessage());
		}
		// Пытаемся найти пост в репозитории
		try {
			$this->postsRepository->get($postUuid);
		} catch (PostNotFoundException $e) {
			return new ErrorResponse($e->getMessage());
		}
		// Генерируем UUID для новой статьи
		$newCommentUuid = UUID::random();
		try {
			// Пытаемся создать объект статьи
			// из данных запроса
			$comment = new Comment(
				$newCommentUuid,
				$postUuid,
				$authorUuid,
				$request->jsonBodyField('text'),
			);
		} catch (HttpException $e) {
			return new ErrorResponse($e->getMessage());
		}
		// Сохраняем новую статью в репозитории
		$this->commentsRepository->save($comment);
		// Возвращаем успешный ответ,
		// содержащий UUID нового комментария
		return new SuccessfulResponse([
			'uuid' => (string)$newCommentUuid,
		], 201);
	}
}