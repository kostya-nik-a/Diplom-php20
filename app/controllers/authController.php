<?php

define('__ROOT__', dirname(dirname(__FILE__)));

require_once (__ROOT__.'/vendor/autoload.php');
require_once (__ROOT__.'/model/function.php');
require_once (__ROOT__.'/model/users.model.php');

$errors = [];

if (isAuthorized())
{
redirect('app/controllers/adminController');
}

print_r($_POST);

if (!empty($_POST['action'])) {
    switch ($_POST['action']) {
        case 'auth':
            // Если передан пароль и логин
            if (!empty($_POST['user']['login']) && !empty($_POST['user']['password'])) {
                // Если пользователь существует
                if ($user = getUserByLogin($_POST['user']['login'])) {
                    // Проверяем пароль
                    // Если пароль совпадает, то
                    $hash = password_hash($_POST['user']['password'], PASSWORD_DEFAULT);

                    echo '<br>' .$_POST['user']['password'];
                    echo '<br>' .$hash;
                    echo '<br>' . $user['password'];

                    if (password_verify($_POST['user']['password'], $user['password'])) {
                        // Пишем в сессию
                        $_SESSION['user'] = $user['login'];
                        // и редиректим на admin.php
                        redirect('app/controllers/adminController');
                    } else {
                        // Если не совпадает, то выдаем ошибку
                        array_push($errors, "Неправильный логин или пароль");
                    }
                } else {
                    // Если пользователь не существует, то выдаем ошибку
                    array_push($errors, "Такого пользователя не существует. Зарегистрируйтесь.");
                }
            } else {
                // Показываем ошибку что нет логина или пароля
                array_push($errors, "Вы забыли указать логин или пароль");
            }
            break;
        case 'register':
            // Если передан пароль и логин
            if (!empty($_POST['user']['login']) && !empty($_POST['user']['password'])) {
                // Если пользователь существует
                if (getUserByLogin($_POST['user']['login'])) {
                    array_push($errors, "Такой пользователь уже существует в базе данных");
                } else {
                    // Если не существует, то создаем нового
                    // Если пользователь создан
                    if ($user = createUser($_POST['user'])) {
                        // Пишем в сессию
                        $_SESSION['user'] = $_POST['user']['login'];
                        // и редиректим на admin.php
                        redirect('app/controllers/adminController');
                    } else {
                        // Если пользоватеь не создан
                        // Бросаем исключение
                        array_push($errors, "Ошибка регистрации пользователя");
                    }
                }
            } else {
                // Показываем ошибку что нет логина или пароля
                array_push($errors, "Введите все необходимые данные для регистрации");
            }
            break;
    }
}

//Запускаем вывод на экран
// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem('app/views');

// Где будут хранится файлы кэша (php файлы)
$twig = new Twig_Environment($loader, array(
    'cache' => './tmp/cache',
    'auto_reload' => true,
));

// Если была попытка
if (isset($user)) {
    $params = ['user' => $user, 'errors' => $errors];
} else {
    $params = ['errors' => $errors];
}

echo $twig->render('auth.html', $params);