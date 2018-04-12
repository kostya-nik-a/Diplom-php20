<?php

require_once "db.connect.php";

function getAnswerByQuestionId($id_question) {
    $db = connectDB();
    $query = $db->prepare("SELECT * FROM answers WHERE id_question = :id_question");
    $query->bindParam(':id_question', $id_question, PDO::PARAM_INT);
    $query->execute();

    if ($answers = $query->fetchAll(PDO::FETCH_ASSOC)) {
        return $answers;
    }
    return false;
}

function addAnswerByQuestionId($params = []) {
    $db = connectDB();
    $query = $db->prepare("INSERT INTO `answers` (answer_text, id_question, visible) 
    VALUES (:answer_text, :id_question, :id_status, :visible)");
    $query->bindParam(':answer_text', $params['answer_text'], PDO::PARAM_INT);
    $query->bindParam(':id_question', $params['id_question'], PDO::PARAM_STR);
    //$query->bindParam(':id_status', $params['answer_is_done'], PDO::PARAM_STR);
    $query->bindParam(':visible', $params['visible'], PDO::PARAM_STR);
    $query->execute();
    return $query->fetchAll();
    redirect('main_admin');
}

function updateAnswers($params = []) {
    $db = connectDB();
    $query = $db->prepare("UPDATE `questions` SET `answer_is_done` = :answer_is_done WHERE `id_question` = :id_question");
    $query->execute([':id_question' => $params['id_question'], ':answer_is_done' => $params['answer_is_done']]);
    redirect('main_admin');
}
