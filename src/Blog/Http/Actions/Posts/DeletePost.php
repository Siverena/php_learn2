<?php

namespace GeekBrains\LevelTwo\Blog\Http\Actions\Posts;

use GeekBrains\LevelTwo\Blog\Exceptions\HttpException;
use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use GeekBrains\LevelTwo\Blog\Http\Actions\ActionInterface;
use GeekBrains\LevelTwo\Blog\Http\Request;
use GeekBrains\LevelTwo\Blog\Http\Response;
use GeekBrains\LevelTwo\Blog\Http\ErrorResponse;
use GeekBrains\LevelTwo\Blog\Http\SuccessfulResponse;
use GeekBrains\LevelTwo\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use GeekBrains\LevelTwo\Blog\UUID;

class DeletePost implements ActionInterface
{

	public function __construct(
		private PostsRepositoryInterface $postsRepository
	) {
	}
	public function handle(Request $request): Response
	{
		// Пытаемся создать UUID пользователя из данных запроса
		try {
			$uuid = new UUID($request->query('uuid'));
		} catch (HttpException | InvalidArgumentException $e) {
			return new ErrorResponse($e->getMessage(),404);
		}
		try {
			$this->postsRepository->get($uuid);
		} catch (PostNotFoundException $e) {
			return new ErrorResponse($e->getMessage(),404);
		}
		try {
			$this->postsRepository->delete($uuid);
		} catch (\Exception $e) {
			echo $e;
		}
		return new SuccessfulResponse(
			['result' => "comment $uuid deleted"],200
		);
	}
}