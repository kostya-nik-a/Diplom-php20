<?php

require_once (__ROOT__. '/core/db.connect.php');

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
    $query = $db->prepare("INSERT INTO `answers` (answer_text, user_id, id_question, id_status, visible) 
    VALUES (:answer_text, :user_id, :id_question, :id_status, :visible)");
    $query->bindParam(':answer_text', $params['answer_text'], PDO::PARAM_INT);
    $query->bindParam(':user_id', $params['user_id'], PDO::PARAM_STR);
    $query->bindParam(':id_question', $params['id_question'], PDO::PARAM_STR);
    $query->bindParam(':id_status', $params['id_status'], PDO::PARAM_STR);
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

function getAssignedTasks($user_id) {
    $db = connectDB();
    $query = $db->prepare("SELECT a.*, b.login FROM task AS a LEFT JOIN user AS b ON (a.user_id = b.id) WHERE a.assigned_user_id = :user_id");
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll();
}



function assignTask($params = []) {
    $db = connectDB();
    $query = $db->prepare("UPDATE `task` SET `assigned_user_id` = :assignee WHERE `id` = :task_id");
    $query->execute([':assignee' => $params['assignee'], ':task_id' => $params['task_id']]);
}

function editTask($action, $param) {
    $db = connectDB();
    switch ($action) {
        case 'complete':
            $query = $db->prepare("UPDATE `task` SET `is_done` = '1' WHERE `id` = :id");
            $query->bindParam(':id', $param, PDO::PARAM_INT);
            $query->execute();
            break;
        case 'delete':
            $query = $db->prepare("DELETE FROM `task` WHERE `id` = :id");
            $query->bindParam(':id', $param, PDO::PARAM_INT);
            $query->execute();
            break;
    }
}
