<?php

require_once 'function.php';
require_once 'users.model.php';
require_once 'faq.model.php';
require_once 'questions.model.php';
require_once 'answers.model.php';

$errors = [];

if (!isAuthorized()) {
    http_response_code(403);
    die();
} else {
    $user = getUserByLogin($_SESSION['user']);
    $_SESSION['user_id'] = $user['user_id'];
}

if (!empty($_POST['action'])) {
    $params = array_merge([], $_POST);
    switch ($_POST['action']) {
        case 'add':
            if (isDataCategory()) {
                if (getCategoryByName($_POST['category_name'])) {
                    array_push($errors, "Такая категория уже существует");
                    break;
                }
            } else {
                array_push($errors, "Введите все необходимые данные для создания новой категории");
                break;
            }
            createUser($params);
            break;
        case 'answer':
            if (!isDataAnswer()) {
                array_push($errors, "Введите ответ.");
                break;
            }
            addAnswerByQuestionId($params);
            updateQuestions($params);
            break;
        case 'add_question':
            addQuestion($params);
            break;
        case 'add_subject':
            addSubject($params);
            break;
    }
}

if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
    deleteUser($_GET['user_id']);
}

?>


<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<title>FAQ</title>
</head>
<body>
<header>
	<h1>Добро пожаловать, <?php $users = getUserById($_SESSION['user_id']); echo $users['fio'];?>!</h1>
</header>

<section>
    <div class="col-lg-8" style="display: inline-block;">
        <form method="POST" class="form-inline">
            <div class="form-group">
                <label for="sort">Сортировать по:</label>
                <select name="sort_by" id="sort" class="form-control">
                    <option selected disabled>Выберите тип сортировки</option>
                    <option value="description">Вопросу</option>
                    <option value="subject">Теме</option>
                    <option value="date_created">Дате добавления</option>
                    <option value="status">Статус ответа</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="sort" value="Отсортировать" class="btn btn-default">
            </div>
        </form>
    </div>
    <div class="col-lg-8" style="display: inline-block;">
        <br>
        <button type="button" class="btn btn-sm btn-outline-secondary"><a class="nav-link" href="admins.php">Пользователи</a></button>
        <button type="button" class="btn btn-sm btn-danger" disabled><a class="nav-link" href="logout.php">Выход</a></button>
    </div>
</section>

<section class="cd-faq">

        <ul class="cd-faq-categories">
            <?php
                $categories = getAllCategories();
                foreach ($categories as $category) {
            ?>
                <li><a href="#<?= $category['category_name']; ?>"><?= $category['category_name']; ?></a></li>
            <?php
            } //foreach categories
            ?>
        </ul> <!-- cd-faq-categories -->

	<div class="cd-faq-items">

		<ul id="basics" class="cd-faq-group">
            <?php

            $categories = getAllCategories();

            foreach ($categories as $category) {
                ?>
			<li class="cd-faq-title"><h2><?= $category['category_name'] ?></h2></li>

            <?php

                if (isset($_POST['sort_by'])) {
                    $questions = getQuestionsByCategory($category['id_category'], $_POST['sort_by']);
                } else {
                    $questions = getQuestionsByCategory($category['id_category'], null);
                }

                foreach ($questions as $question) {
                    ?>
                    <li>
                        <a class="cd-faq-trigger" href=""><?= $question['question_text'] ?></a>
                        <div class="cd-faq-content">
                            <p>
                                <?php
                                    $Answers = getAnswerByQuestionId($question['id_question']);

                                    if (is_array($Answers)) {
                                        foreach ($Answers as $Answer) {
                                            echo $Answer['answer_text'];
                                        }
                                    } else {echo 'Ответа пока нет';}

                                ?>
                            </p>
                            <div>
                                <hr>

                                <div class="badge badge badge-light"> <!--  общая информация по вопросу -->
                                    <?php
                                        echo 'Дата создания: '. $question['creation_date'].'<br>';
                                    ?>
                                </div><br>

                                <div> <!--  Действие по вопросу -->
                                    <?php
                                        if ($question['answer_is_done'] == "0" ) {
                                    ?>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <a style="text-decoration: none; color: white;" href="?id_question=<?= $question['id_question'] ?>&action=change">Ответить</a>
                                            </button>

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <a style="text-decoration: none; color: white;" href="?id_question=<?= $question['id_question'] ?>&action=delete">Удалить</a>
                                            </button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" class="btn btn-sm btn-success cd-faq-content">
                                                <a style="text-decoration: none; color: white;" href="?id_question=<?= $question['id_question'] ?>&action=update">Изменить ответ</a>
                                            </button>
                                            <?php
                                        }
                                    ?>
                                </div>

                                <div class="badge badge-light">
                                    <?php
                                        $makeUser = getWhoAnswerTheQuestion($question['user_id']);
                                        foreach ($makeUser as $maker) {
                                            if ($question['answer_is_done'] == '1') {
                                                echo 'Автор ответа: '.$maker['fio'];
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <form method="POST" action="" class="form-inline">
                                    <?php

                                    if (!empty($_GET) && $_GET['action'] == 'change' && $_GET['id_question'] == $question['id_question'] ) {
                                        ?>
                                            <textarea class="form-control" name="answer_text" placeholder="your answer" cols="70" rows="3"></textarea>
                                            <input type="checkbox" name="visible" value="1" id="visible"><label for="visible">Скрытый ответ</label><br>
                                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
                                            <input type="hidden" name="id_question" value="<?= $_GET['id_question']?>">
                                            <input type="hidden" name="answer_is_done" value="1">
                                            <button type="submit" name="action" value="answer" class="btn btn-sm btn-success">Сохранить</button>
                                        <?php
                                    }
                                    elseif (!empty($_GET) && $_GET['action'] == 'update' && $_GET['id_question'] == $question['id_question'] ) {
                                        $Answers = getAnswerByQuestionId($_GET['id_question']);

                                        foreach ($Answers as $Answer) {
                                            ?>
                                                <textarea class="form-control" name="answer_text" placeholder="your answer" cols="70" rows="3" value="<?=$Answer['answer_text']?>"></textarea>
                                            <?php
                                        }
                                    }
                                    ?>
                                </form>
                                <?php foreach ($errors as $error): ?>
                                    <div class="alert alert-danger"><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div> <!-- cd-faq-content -->
                    </li>
                    <?php
                    } //if getQuestionsByCategory
                } //foreach questions
            ?>
		</ul> <!-- cd-faq-group -->
	</div> <!-- cd-faq-items -->
	<a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>
