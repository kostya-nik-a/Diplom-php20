<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 1);

require_once 'app/vendor/autoload.php';

//Подключение к базе данных
include 'app/core/db.connect.php';

$db = connectDB();

include 'app/controllers/authController.php';

include 'app/routers/router.php';