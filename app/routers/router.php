<?php

class Router
{
    private $dirConroller = '';
    private $db = '';
    private $urls = [];

    function __construct($dirConroller, $db)
    {
        $this->dirConroller = $dirConroller;
        $this->db = $db;
    }

    /**
     * Добавление роутеров
     * @param $url урл
     * @param $controllerAndAction пример: BookController@getUpdate
     */
    public function get($url, $controllerAndAction, $params = [])
    {
        $this->add('GET', $url, $controllerAndAction, $params);
    }

    /**
     * Добавление роутеров
     * @param $url урл
     * @param $controllerAndAction пример: BookController@postUpdate
     */
    public function post($url, $controllerAndAction, $params = [])
    {
        $this->add('POST', $url, $controllerAndAction, $params);
    }

    /**
     * Добавление роутеров
     * @param $url урл
     * @param $controllerAndAction пример: BookController@list
     */
    public function add($method, $url, $controllerAndAction, $params)
    {
        list($controller, $action) = explode('@', $controllerAndAction);

        $this->urls[$method][$url] = [
            'controller' => $controller,
            'action' => $action,
            'params' => $params
        ];
    }

    /**
     * Подключение контроллеров
     * @param $url текущий урл
     */
    public function run($currentUrl)
    {
        if (isset($this->urls[$_SERVER['REQUEST_METHOD']])) {
            foreach ($this->urls[$_SERVER['REQUEST_METHOD']] as $url => $urlData) {
                if (preg_match('(^'.$url.'$)', $currentUrl, $matchList)) {
                    $params = [];
                    foreach ($urlData['params'] as $param => $i) {
                        $params[$param] = $matchList[$i];
                    }
                    include $this->dirConroller.$urlData['controller'].'.php';
                    $controller = new $urlData['controller']($this->db);
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $controller->$urlData['action']($params, $_POST);
                    } else {
                        $controller->$urlData['action']($params);
                    }
                }
            }
        }
    }
}

$router = new Router('controller/', $db);

$router->get('/', 'UsersController@getAllUsersList');
$router->get('/users/add/', 'UsersController@getAddNewUser');
$router->post('/users/add/', 'UsersController@postAddNewUser');
$router->get('/users/update/id/(\d+)/', 'UsersController@UserUpdate', ['id' => 1]);
$router->post('/users/update/id/(\d+)/', 'UsersController@UserUpdate', ['id' => 1]);
$router->get('/users/delete/id/(\d+)/', 'UsersController@getUserDelete', ['id' => 1]);



/*
Удаляем "/?", потому что не сделали настройки на серверах
 */
$currentUrl = str_replace('', '', $_SERVER['REQUEST_URI']);
$router->run($currentUrl);

// Продолжение следует...