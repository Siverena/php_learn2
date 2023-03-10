<?php

namespace GeekBrains\LevelTwo\Blog\Http\Actions\Posts;

use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\Exceptions\HttpException;
use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\Http\Actions\ActionInterface;
use GeekBrains\LevelTwo\Blog\Http\ErrorResponse;
use GeekBrains\LevelTwo\Blog\Http\Request;
use GeekBrains\LevelTwo\Blog\Http\Response;
use GeekBrains\LevelTwo\Blog\Http\SuccessfulResponse;
use GeekBrains\LevelTwo\Blog\Post;
use GeekBrains\LevelTwo\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use GeekBrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use GeekBrains\LevelTwo\Blog\UUID;

class CreatePost implements ActionInterface
{

	// Внедряем репозитории статей и пользователей
	public function __construct(
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
		// Пытаемся найти пользователя в репозитории
		try {
			$this->usersRepository->get($authorUuid);
		} catch (UserNotFoundException $e) {
			return new ErrorResponse($e->getMessage());
		}
		// Генерируем UUID для новой статьи
		$newPostUuid = UUID::random();
		try {
			// Пытаемся создать объект статьи
			// из данных запроса
			$post = new Post(
				$newPostUuid,
				$authorUuid,
				$request->jsonBodyField('title'),
				$request->jsonBodyField('text'),
			);
		} catch (HttpException $e) {
			return new ErrorResponse($e->getMessage(),500);
		}
		// Сохраняем новую статью в репозитории
		$this->postsRepository->save($post);
		// Возвращаем успешный ответ,
		// содержащий UUID новой статьи
		return new SuccessfulResponse([
			'uuid' => (string)$newPostUuid,
		], 201);
	}
}