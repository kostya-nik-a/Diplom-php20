<?php

include 'config.php';

function connectDB() {
        try {
            $connect = DB_DRIVER . ':host='. DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            $db = new PDO($connect, DB_USER,DB_PASS);
            return $db;
        }
        catch (Exception $e) {
            die('Error: ' . $e->getMessage() . '<br/>');
        }
        return $db;
    }