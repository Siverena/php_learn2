<?php

namespace GeekBrains\LevelTwo\Blog;

class Comment
{
    private UUID $uuid;
    private UUID $post;
    private UUID $author;
    private string $text;

    /**
     * @param UUID $uuid
     * @param UUID $post
     * @param UUID $author
     * @param string $text
     */
    public function __construct(UUID $uuid, UUID $post, UUID $author, string $text)
    {
        $this->uuid = $uuid;
        $this->post = $post;
        $this->author = $author;
        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->text;
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