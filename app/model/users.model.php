<?php

require_once (__ROOT__. '/core/db.connect.php');

function createUser($params = [])
{
    $sql = "INSERT INTO `users` (login, password, email, fio, user_id_creater) VALUES (:login, :password, :email, :fio, :user_id_creater)";
    $hash_password = password_hash($params['password'], PASSWORD_DEFAULT);

    $query = connectDB()->prepare($sql);
    $query->bindParam(':login', $params['login'], PDO::PARAM_STR);
    $query->bindParam(':password', $hash_password, PDO::PARAM_STR);
    $query->bindParam(':email', $params['email'], PDO::PARAM_STR);
    $query->bindParam(':fio', $params['fio'], PDO::PARAM_STR);
    $query->bindParam(':user_id_creater', $params['user_id_creater'], PDO::PARAM_STR);
    return $query->execute();
}

function deleteUser($user_id)
{
    $query = connectDB()->prepare("DELETE FROM `users` WHERE `user_id` = :user_id");
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    redirect('admins');
}

function updateUser($params = [])
{
    $hash_password = password_hash($params['password'], PASSWORD_DEFAULT);
    print $hash_password;

    $query = connectDB()->prepare("UPDATE `users` SET `password` = :new_password WHERE `user_id` = :user_id");
    $query->execute([':user_id' => $params['user_id'], ':new_password' => $hash_password]);
    redirect('admins');
}

function getAllUsers($user_id, $sortOfType)
{
    if (isset($sortOfType)) {
        switch ($sortOfType) {
            case 'date_created':
                $sortOfType = 'date_added';
                break;
            case 'login':
                $sortOfType = 'login';
                break;
            case 'fio':
                $sortOfType = 'fio';
                break;
        }
        $query = connectDB()->prepare("SELECT user_id, login, password, email, fio, date_added, user_id_creater FROM users 
        WHERE user_id <> $user_id
        ORDER BY " . $sortOfType . " ASC");
        $query->bindParam(':user_id', $user_id, PDO::FETCH_ASSOC);
        $query->execute();
        return $query->fetchAll();
    } else {
        $query = connectDB()->prepare("SELECT user_id, login, password, email, fio, date_added, user_id_creater FROM users WHERE user_id <> $user_id");
        $query->bindParam(':user_id', $user_id, PDO::FETCH_ASSOC);
        $query->execute();
        return $query->fetchAll();
    }
}

function getWhoCreateUser($user_id_creater)
{
    $query = connectDB()->prepare("SELECT login FROM users WHERE user_id = $user_id_creater");
    $query->execute();
    return $query->fetchAll();
}

function getUserById($id)
{
    $query = connectDB()->prepare("SELECT user_id, login, fio FROM users WHERE user_id = :user_id");
    $query->bindParam(':user_id', $id, PDO::PARAM_INT);
    $query->execute();
    if ($user = $query->fetch(PDO::FETCH_ASSOC)) {
        return $user;
    }
    return false;
}

function getUserByLogin($login)
{
    $query = connectDB()->prepare("SELECT user_id, login, password FROM users WHERE `login` = :login");
    $query->bindParam(':login', $login, PDO::PARAM_STR);
    $query->execute();
    if ($user = $query->fetch(PDO::FETCH_ASSOC)) {
        return $user;
    }
    return false;
}