<?php

namespace GeekBrains\LevelTwo\Blog;

class Like
{
	private UUID $uuid;
	private UUID $post;
	private UUID $author;
	/**
	 * @param UUID $uuid
	 * @param UUID $post
	 * @param UUID $author
	 * @param string $text
	 */
	public function __construct(UUID $uuid, UUID $post, UUID $author)
	{
		$this->uuid = $uuid;
		$this->post = $post;
		$this->author = $author;
	}

	/**
	 * @return UUID
	 */
	public function uuid(): UUID
	{
		return $this->uuid;
	}

	/**
	 * @return int
	 */
	public function getAuthor(): UUID
	{
		return $this->author;
	}

	/**
	 * @param UUID $author
	 */
	public function setAuthor(UUID $author): void
	{
		$this->author = $author;
	}

	/**
	 * @return UUID
	 */
	public function getPost(): UUID
	{
		return $this->post;
	}

	/**
	 * @param UUID $post
	 */
	public function setPost(UUID $post): void
	{
		$this->post = $post;
	}

}