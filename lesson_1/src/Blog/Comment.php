<?php

namespace GeekBrains\LevelTwo\Blog;

class Comment
{
    private int $id;
    private int $author;
    private int $post;
    private string $text;

    /**
     * @param int $id
     * @param int $author
     * @param int $post
     * @param string $text
     */
    public function __construct(int $id, int $author, int $post, string $text)
    {
        $this->id = $id;
        $this->author = $author;
        $this->post = $post;
        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getPost(): int
    {
        return $this->post;
    }

    /**
     * @param int $post
     */
    public function setPost(int $post): void
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

}