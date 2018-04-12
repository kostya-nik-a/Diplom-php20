<?php

require_once "db.connect.php";

function getAllCategories()  {
    $db = connectDB();
    $query = $db->prepare("SELECT * FROM categories");
    $query->execute();
    return $query->fetchAll();
}

function getCategoryByName($name) {
    $db = connectDB();
    $query = $db->prepare("SELECT category_name FROM categories WHERE category_name = :category_name");
    $query->bindParam(':category_name', $name, PDO::PARAM_INT);
    $query->execute();
    if ($categories = $query->fetch(PDO::FETCH_ASSOC)) {
        return $categories;
    }
    return false;
}

function addCategory($params = []) {
    $db = connectDB();
    $query = $db->prepare("INSERT INTO `categories` (category_name) VALUES (:category_name)");
    $query->bindParam(':category_name', $params['category_name'], PDO::PARAM_STR);
    $query->execute();
}

function deleteCategory($id_category) {
    $db = connectDB();
    $query = $db->prepare("DELETE FROM `categories` WHERE `category_name` = :category_name");
    $query->bindParam(':category_name', $id_category, PDO::PARAM_INT);
    $query->execute();
    redirect('admin');
}

function getAllSubjects()  {
    $db = connectDB();
    $query = $db->prepare("SELECT * FROM subjects");
    $query->execute();
    return $query->fetchAll();
}

function getSubjectByName($name) {
    $db = connectDB();
    $query = $db->prepare("SELECT subject_name FROM subjects WHERE subject_name = :subject_name");
    $query->bindParam(':subject_name', $name, PDO::PARAM_INT);
    $query->execute();
    if ($categories = $query->fetch(PDO::FETCH_ASSOC)) {
        return $categories;
    }
    return false;
}

function addSubject($params = []) {
    $db = connectDB();
    $query = $db->prepare("INSERT INTO `subjects` (subject_name) VALUES (:subject_name)");
    $query->bindParam(':subject_name', $params['subject_name'], PDO::PARAM_STR);
    $query->execute();
}

function deleteSubject($id_subject) {
    $db = connectDB();
    $query = $db->prepare("DELETE FROM `id_subject` WHERE `id_subject` = :id_subject");
    $query->bindParam(':id_subject', $id_subject, PDO::PARAM_INT);
    $query->execute();
    redirect('admin');
}

function getAllStatus()  {
    $db = connectDB();
    $query = $db->prepare("SELECT * FROM status");
    $query->execute();
    return $query->fetchAll();
}

function getStatusByGetAnswer($answer_is_done)  {
    $db = connectDB();
    $query = $db->prepare("SELECT status FROM status WHERE answer_is_done = :status_answer");
    $query->bindParam(':status_answer', $answer_is_done, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll();
}
