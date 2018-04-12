<?php

require_once "db.connect.php";

function getQuestionById($id_question) {
    $db = connectDB();
    $query = $db->prepare("SELECT * FROM questions WHERE id_question = :id_question");
    $query->bindParam(':id_question', $id_question, PDO::PARAM_INT);
    $query->execute();
    if ($categories = $query->fetch(PDO::FETCH_ASSOC)) {
        return $categories;
    }
    return false;
}

function getQuestionsByCategory($id_category, $sortOfType) {
    $db = connectDB();

    if (isset($sortOfType)) {
        switch ($sortOfType) {
            case 'date_created':
                $sortOfType = 'creation_date';
                break;
            case 'description':
                $sortOfType = 'question_text';
                break;
            case 'subject':
                $sortOfType = 'id_subject';
                break;
        }
        $query = $db->prepare("SELECT * FROM questions WHERE id_category = :id_category ORDER BY ".$sortOfType."  ASC");
        $query->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    elseif ($sortOfType == 'status') {
        $query = $db->prepare("SELECT * FROM questions WHERE id_category = :id_category ORDER BY answer_is_done DESC");
        $query->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    else {
        $query = $db->prepare("SELECT * FROM questions WHERE id_category = :id_category");
        $query->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    if ($categories = $query->fetchAll(PDO::FETCH_ASSOC)) {
        return $categories;
    }
    return false;
}

function addQuestion($params = []) {
    $db = connectDB();
    $query = $db->prepare("INSERT INTO `questions` (question_text, email, id_category, visible) 
        VALUES (:question_text, :id_category, :visible)");
    $query->bindParam(':question_text', $params['question_text'], PDO::PARAM_STR);
    $query->bindParam(':id_category', $params['id_category'], PDO::PARAM_STR);
    $query->bindParam(':visible', $params['visible'], PDO::PARAM_STR);
    $query->execute();
}

function deleteQuestion($id_question) {
    $db = connectDB();
    $query = $db->prepare("DELETE FROM `questions` WHERE `id_question` = :id_question");
    $query->bindParam(':id_question', $id_question, PDO::PARAM_INT);
    $query->execute();
    redirect('main_admin');
}

function getAllQuestions($sortOfType) {
    $db = connectDB();

    if (isset($sortOfType)) {
        switch ($sortOfType) {
            case 'date_created':
                $sortOfType = 'creation_date';
            break;
            case 'description':
                $sortOfType = 'question_text';
            break;
            case 'subject':
                $sortOfType = 'id_subject';
            break;
        }
        $query = $db->prepare("SELECT * FROM questions ORDER BY ".$sortOfType."  ASC");
        $query->execute();
        return $query->fetchAll();
    }
    elseif ($sortOfType == 'status') {
        $query = $db->prepare("SELECT * FROM questions ORDER BY answer_is_done DESC");
        $query->execute();
        return $query->fetchAll();
    }
    else {
        $query = $db->prepare("SELECT * FROM questions");
        $query->execute();
        return $query->fetchAll();
    }
}

function getWhoAnswerTheQuestion($user_id) {
    $db = connectDB();
    $query = $db->prepare("SELECT login, fio FROM users WHERE user_id = $user_id");
    $query->execute();
    return $query->fetchAll();
}

function updateQuestions($params = []) {
    $db = connectDB();
    $query = $db->prepare("UPDATE `questions` SET `answer_is_done` = :answer_is_done WHERE `id_question` = :id_question");
    $query->execute([':id_question' => $params['id_question'], ':answer_is_done' => $params['answer_is_done']]);
    redirect('main_admin');
}
