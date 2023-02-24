<?php

namespace GeekBrains\LevelTwo\Blog\Http\Actions\Posts;

use GeekBrains\LevelTwo\Blog\Exceptions\HttpException;
use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\Http\Actions\ActionInterface;
use GeekBrains\LevelTwo\Blog\Http\ErrorResponse;
use GeekBrains\LevelTwo\Blog\Http\Request;
use GeekBrains\LevelTwo\Blog\Http\Response;
use GeekBrains\LevelTwo\Blog\Http\SuccessfulResponse;
use GeekBrains\LevelTwo\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use GeekBrains\LevelTwo\Blog\UUID;

class FindByUuid implements ActionInterface
{
	public function __construct(
		private PostsRepositoryInterface $postsRepository
	) {
	}
	public function handle(Request $request): Response
	{
		try {
			$uuid = new UUID($request->query('uuid'));
		} catch (HttpException | InvalidArgumentException $e) {
			return new ErrorResponse($e->getMessage(),400);
		}
		try {
			$post = $this->postsRepository->get($uuid);
		} catch (PostNotFoundException $e) {
			return new ErrorResponse($e->getMessage(),404);
		}
		// Возвращаем успешный ответ
		return new SuccessfulResponse([
			'author_uuid' => $post->getAuthor(),
			'title' => $post->getTitle(),
			'text' => $post->getText()
		], 200);
	}
}