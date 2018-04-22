<?php

session_start();

// Для того чтобы выводить все ошибки и предупреждения
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Установка и проверка времени жизни сессии, если пользователь долго не обращался к странице - удаляем сессию и создаем новую
$lifeLimit =30000;
if(isset($_SESSION['time'])&&(time()-$_SESSION['time'])>$lifeLimit) {
    session_destroy();
    session_start();
    redirect('index');
}
$_SESSION['time']=time();


// Перенаправление на другую страницу
function redirect($page) {
    header("Location: $page.php");
    die;
}

// Проверка, является ли пользователь просто аутоидентифицированным
function isAuthorized() {
    return !empty($_SESSION['user']);
}

function isDataUser() {
    if (empty($_POST['login']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['fio'])) {
        return false;
    } else {
        return true;
    }
}

function isDataCategory() {
    if (empty($_POST['category_name'])) {
        return false;
    } else {
        return true;
    }
}

function isDataAnswer() {
    if (empty($_POST['answer_text'])) {
        return false;
    } else {
        return true;
    }
}