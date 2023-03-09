<?php

namespace GeekBrains\LevelTwo\Blog\Http\Actions\Likes;

use GeekBrains\LevelTwo\Blog\Exceptions\HttpException;
use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\Http\Actions\ActionInterface;
use GeekBrains\LevelTwo\Blog\Http\ErrorResponse;
use GeekBrains\LevelTwo\Blog\Http\Request;
use GeekBrains\LevelTwo\Blog\Http\Response;
use GeekBrains\LevelTwo\Blog\Http\SuccessfulResponse;
use GeekBrains\LevelTwo\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use GeekBrains\LevelTwo\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use GeekBrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use GeekBrains\LevelTwo\Blog\UUID;

class CreateLike implements ActionInterface
{
	public function __construct(
		private LikesRepositoryInterface $likesRepository,
		private PostsRepositoryInterface $postsRepository,
		private UsersRepositoryInterface $usersRepository,
	) {
	}
	public function handle(Request $request): Response
	{
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
		$newLikeUuid = UUID::random();
		try {
			// Пытаемся создать объект статьи
			// из данных запроса
			$like = new Like(
				$newLikeUuid,
				$postUuid,
				$authorUuid,
			);
		} catch (HttpException $e) {
			return new ErrorResponse($e->getMessage());
		}
		// Сохраняем новую статью в репозитории
		$this->likesRepository->save($like);
		// Возвращаем успешный ответ,
		// содержащий UUID нового комментария
		return new SuccessfulResponse([
			'uuid' => (string)$newLikeUuid,
		], 201);
	}
}