<?php

define('__ROOT__', dirname(dirname(__FILE__)));

require_once (__ROOT__.'/vendor/autoload.php');
require_once (__ROOT__.'/model/function.php');
require_once (__ROOT__.'/model/users.model.php');

$errors = [];

if (!isAuthorized()) {
    http_response_code(403);
    die();
} else {
    $user = getUserByLogin($_SESSION['user']);
    $_SESSION['user_id'] = $user['user_id'];
}

if (isset($_POST['sort_by'])) {
    $users = getAllUsers($_SESSION['user_id'], $_POST['sort_by']);
} else {
    $users = getAllUsers($_SESSION['user_id'], null);
}

foreach ($users as $user) {
    $userMaker = getWhoCreateUser($user['user_id_creater']);
}

if (!empty($_POST['action'])) {
    $params = array_merge([], $_POST);
    switch ($_POST['action']) {
        case 'add':
            if (isDataUser()) {
                if (getUserByLogin($_POST['login'])) {
                    array_push($errors, "Такой пользователь уже существует");
                    break;
                }
            } else {
                array_push($errors, "Введите все необходимые данные для создания нового пользователя");
                break;
            }
            createUser($params);
            break;
        case 'update':
            updateUser($params);
            break;
    }
}

if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
    deleteUser($_GET['user_id']);
}

$userMaker = getWhoCreateUser($users['user_id_creater']);
print_r($userMaker);

//Запускаем вывод на экран
// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem(__ROOT__.'/views');

// Где будут хранится файлы кэша (php файлы)
$twig = new Twig_Environment($loader, array(
    'cache' => './tmp/cache',
    'auto_reload' => true,
));

$params = ['user' => $user['login'],
    'users' => $users,
    'userMaker' => $userMaker,
    'errors' => $errors
];

// Выводим результат
echo $twig->render('users/users.html', $params);
