<?php

namespace GeekBrains\LevelTwo\Blog\Http;

class SuccessfulResponse extends Response
{
    protected const SUCCESS = true;
// Успешный ответ содержит массив с данными,
// по умолчанию - пустой
    public function __construct(
        private array $data = [],
        protected int $responseCode = 200
    ) {
    }
// Реализация абстрактного метода
// родительского класса
    protected function payload(): array
    {
        return ['data' => $this->data];
    }

}