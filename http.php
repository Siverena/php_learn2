<?php
use GeekBrains\LevelTwo\Blog\Exceptions\AppException;
use GeekBrains\LevelTwo\Blog\Http\Actions\Posts\FindByUuid;
use GeekBrains\LevelTwo\Blog\Http\Actions\Users\FindByUsername;
use GeekBrains\LevelTwo\Blog\Http\ErrorResponse;
use GeekBrains\LevelTwo\Blog\Http\HttpException;
use GeekBrains\LevelTwo\Blog\Http\Request;
use GeekBrains\LevelTwo\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use GeekBrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';
// Создаём объект запроса из суперглобальных переменных
$request = new Request(
	$_GET,
	$_SERVER,file_get_contents('php://input'),
);

try {
// Пытаемся получить путь из запроса
	$path = $request->path();
} catch (HttpException) {
// Отправляем неудачный ответ,
// если по какой-то причине
// не можем получить путь
	(new ErrorResponse)->send();
// Выходим из программы
	return;
}
$routes = [
// Создаём действие, соответствующее пути /users/show
	'/users/show' => new FindByUsername(
// Действию нужен репозиторий
		new SqliteUsersRepository(
// Репозиторию нужно подключение к БД
			new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
		)
	),
// Второй маршрут
	'/posts/show' => new FindByUuid(
		new SqlitePostsRepository(
			new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
		)
	),
];
// Если у нас нет маршрута для пути из запроса -
// отправляем неуспешный ответ
if (!array_key_exists($path, $routes)) {
	(new ErrorResponse('Not found'))->send();
	return;
}
// Выбираем найденное действие
$action = $routes[$path];
try {
// Пытаемся выполнить действие,
// при этом результатом может быть
// как успешный, так и неуспешный ответ
	$response = $action->handle($request);
} catch (AppException $e) {
// Отправляем неудачный ответ,
// если что-то пошло не так
	(new ErrorResponse($e->getMessage()))->send();
}
// Отправляем ответ
$response->send();
