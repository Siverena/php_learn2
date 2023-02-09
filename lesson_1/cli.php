<?php
echo "Выбрана опция $argv[1]. Вы уверены? А, неважно...\n";
require_once __DIR__ . "/vendor/autoload.php";
use GeekBrains\LevelTwo\Blog\User;
use GeekBrains\LevelTwo\Blog\Post;
use GeekBrains\LevelTwo\Blog\Comment;
$faker = Faker\Factory::create("ru_RU");
$defaultUser = new User('0',"Default", "User", "defaultuser");
switch ($argv[1]){
    case "user":
        $id = rand(0,100);
        $name = explode(" ", $faker->name);
        $user = new User($id, $name[0], $name[1], $faker->userName());
        echo $user;
        break;
    case "post":
        $id = rand(0,100);
        $author = rand(0,100);
        $title = $faker->title();
        $text = $faker->text(100);
        $post = new Post($id, $author, $title, $text);
        echo $post;
        break;
    case "comment":
        $id = rand(0, 100);
        $author = rand(0, 100);
        $post = rand(0, 100);
        $text = $faker->text(50);
        $comment = new Comment($id,$author,$post,$text);
        echo $comment;
        break;
    default:
        echo "Чего тебе надобно, старче? Лень...";
}
//
//$userRepository = new InMemoryUsersRepository();
//$userRepository->save($user1);
//$userRepository->save($user2);
//try {
//    echo $userRepository->get(1);
//    echo $userRepository->get(2);
//    echo $userRepository->get(3);
//} catch (UserNotFoundException $exception) {
//    echo $exception->getMessage();
//} catch (Exception $exception) {
//    echo "Что-то пошло не так...\n";
//    echo $exception->getMessage();
//}