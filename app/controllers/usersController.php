<?php

class UserController
{
    private $model = null;

    function __construct($db)
    {
        include 'model/users.model.php';
        $this->model = new Users($db);
    }

    /**
     * Отображаем шаблон
     * @param $template
     * @param $params
     */
    private function render($template, $params = [])
    {
        $fileView = 'view/'.$template;
        if (is_file($fileView)) {
            ob_start();
            if (count($params) > 0) {
                extract($params);
            }
            include $fileView;
            return ob_get_clean();
        }
    }

    /**
     * Форма добавление книги
     * @param $params array
     * @return mixed
     */
    function getAddNewUser()
    {
        echo $this->render('users/addNewUser.php');
    }

    /**
     * Добавление книги
     * @param $params array
     * @return mixed
     */
    function postAddNewUser($params, $post)
    {
        $updateParam = [];
        if (isset($post['name']) && isset($post['author']) && isset($post['year']) && isset($post['genre'])) {
            $idAdd = $this->model->createUser([
                'name' => $post['name'],
                'author' => $post['author'],
                'year' => $post['year'],
                'genre' => $post['genre'],
            ]);
            if ($idAdd) {
                header('Location: /');
            }
        }
    }

    /**
     * Удаление книги
     * @param $id
     */
    public function getUserDelete($params)
    {
        if (isset($params['user_id']) && is_numeric($params['user_id'])) {
            $isDelete = $this->model->deleteUser($params['user_id']);
            if ($isDelete) {
                header('Location: /');
            }
        }
    }

    /**
     * Форма редактирование данных
     * @param $id
     */

    public function getUserUpdate($params)
    {
        if (isset($params['user_id']) && is_numeric($params['user_id'])) {
            $user = $this->model->getUserByLogin($params['user_id']);
            echo $this->render('users/update.php', ['users' => $user]);
        }
    }


    /**
     * Изменение данных о книге
     * @param $id
     */

    public function postUserUpdate($params, $post)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $updateParam = [];
            if (isset($post['name'])) {
                $updateParam['name'] = $post['name'];
            }
            if (isset($post['author'])) {
                $updateParam['author'] = $post['author'];
            }
            if (isset($post['year']) && is_numeric($post['year'])) {
                $updateParam['year'] = $post['year'];
            }
            if (isset($post['genre'])) {
                $updateParam['genre'] = $post['genre'];
            }
            $isUpdate = $this->model->updateUser($params['id'], $updateParam);

            if ($isUpdate) {
                header('Location: /');
            }
        }
    }

    /**
     * Получение всех книг
     * @return array
     */
    public function getAllUsersList()
    {
        $users = $this->model->getAllUsers();
        echo $this->render('users/list.php', ['users' => $users]);
    }

}

