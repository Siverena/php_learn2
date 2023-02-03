<?php

    require_once "autoloader.php";

use GeekBrains\LevelTwo\Blog\User;
use GeekBrains\LevelTwo\Person\Name;
use GeekBrains\LevelTwo\Person\Person;
use GeekBrains\LevelTwo\Blog\Post;
use GeekBrains\LevelTwo\Blog\Repositories\InMemoryUsersRepository;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;




$name = new Name('Petr',"Petrov");
$person = new Person($name, new DateTimeImmutable());
$post = new Post(1, $person, "Привет!");

$name1 = new Name("Ivan", "Ivanov");
$name2 = new Name("Джамшут","Равшанов");
$user1 = new User(1, $name1, "Admin");
$user2 = new User(2, $name2, "user2");

$userRepository = new InMemoryUsersRepository();
$userRepository->save($user1);
$userRepository->save($user2);
try {
    echo $userRepository->get(1);
    echo $userRepository->get(2);
    echo $userRepository->get(3);
} catch (UserNotFoundException $exception) {
    echo $exception->getMessage();
} catch (Exception $exception) {
    echo "Что-то пошло не так..." . PHP_EOL;
    echo $exception->getMessage();
}