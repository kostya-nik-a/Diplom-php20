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


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>
    <title>Test</title>
</head>
<body>
<div> <!-- центрирующий блок -->
    <div> <!-- Верхнее меню-->
        <ul class="nav nav-pills nav-fill navbar-light bg-light">
            <li class="nav-item">
                <button type="button" class="btn btn-outline-secondary"><a class="nav-link" href="#">Категории</a></button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-outline-secondary"><a class="nav-link" href="#">Темы</a></button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-outline-secondary"><a class="nav-link" href="#">Вопросы и ответы</a></button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-outline-secondary"><a class="nav-link" href="admins.php">Пользователи</a></button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-sm btn-danger" disabled><a class="nav-link" href="logout.php">Выход</a></button>
            </li>
        </ul>
    </div>

    <div style="margin-bottom: 20px; border-top: 2px; border-top-color: black;">
        <br>
        <h1>Добро пожаловать, <?php $users = getUserById($_SESSION['user_id']); echo $users['fio'];?>!</h1>
        <br>
    </div>

    <div style="display: inline-block; width: 20%;"> Здесь отображается список категорий
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <?php
                $categories = getAllCategories();

                foreach ($categories as $category) {
                    ?>
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
                       aria-controls="v-pills-home" aria-selected="true">
                        <?php
                        echo $category['category_name'];
                        ?>
                    </a><br>
                    <?php
                }
            ?>
            <form method="POST" action="" class="form-inline">
                <div class="form-row align-items-center">
                    <input type="text" name="category_name" placeholder="name" value="" class="form-control">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
                    <button type="submit" name="action" value="add" class="btn btn-success">Добавить категорию</button><br>
                </div>
            </form>

            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
        </div>
    </div>

    <div style="display: inline-block; width: 59%; margin-bottom: 20px;">
        <div class="col-lg-8">
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
        <div>
            <br>
        </div>
        <!--
        <div class="col-lg-9">
            <form method="POST" action="" class="form-inline">
                <div class="form-row align-items-center">
                    <input type="text" name="email" placeholder="e-mail" value="" class="form-control">
                    <textarea name="question" placeholder="your question" cols="70" rows="3" class="form-control"></textarea>
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
                    <input type="hidden" name="user_id_creater" value="<?= $_SESSION['user_id']?>">
                    <button type="submit" name="action" value="add_question" class="btn btn-success">Добавить вопрос</button><br>
                </div>
            </form>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        </div>
        -->

        // В ВИДЕ БЛОКОВ

        <div class="cd-faq-items">
            <ul id="basics" class="cd-faq-group">
                <li class="cd-faq-title"><h2>Basics</h2></li>
                <li>
                    <a class="cd-faq-trigger" href="#0">How do I change my password?</a>
                    <div class="cd-faq-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis nihil sed consequatur atque repellendus fugit perspiciatis rerum et. Dolorum consequuntur fugit deleniti, soluta fuga nobis. Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis, assumenda accusamus cumque perferendis eos aut quidem! Aut, totam rerum, cupiditate quae aperiam voluptas rem inventore quas, ex maxime culpa nam soluta labore at amet nihil laborum? Explicabo numquam, sit fugit, voluptatem autem atque quis quam voluptate fugiat earum rem hic, reprehenderit quaerat tempore at. Aperiam.</p>
                    </div> <!-- cd-faq-content -->
                </li>
            </ul>
        </div>
        <a href="#0" class="cd-close-panel">Close</a>


        // В ВИДЕ ТАБЛИЦЫ
        <div>
        <table class="table table-hover table-striped m-t-xl">
            <thead>
            <tr>
                <th>Вопрос</th>
                <th>E-mail</th>
                <th>Visible</th>
                <th>Date creation</th>
                <th>Статус</th>
                <th>Автор ответа</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="cd-faq-trigger">
                <tr>
                <?php

                if (isset($_POST['sort_by'])) {
                    $questions = getAllQuestions($_POST['sort_by']);
                } else {
                    $questions = getAllQuestions(null);
                }

                foreach ($questions as $question) {
                ?>
                    <td><?= $question['question_text'] ?></td>
                    <td><?= $question['email'] ?></td>
                    <td><?= $question['visible'] ?></td>
                    <td><?= $question['creation_date'] ?></td>

                    <?php
                        $status = getStatusByGetAnswer($question['answer_is_done']);

                        foreach ($status as $val) {
                            if ($question['answer_is_done'] == '0') {
                                ?>
                                <td><?php echo $val['status'] ?></td>
                                <?php
                            } else {
                                ?>
                                <td><?php echo $val['status'] ?></td>

                                <?php
                            }
                        }

                    $makeUser = getWhoAnswerTheQuestion($question['user_id']);

                    foreach ($makeUser as $maker) {
                        ?>
                        <td><?= $maker['fio'] ?></td>
                        <?php
                    }
                    ?>
                    <?php

                        if (!$question['answer_is_done'] == "1" ) {
                            ?>
                            <td>
                                <button type="submit" class="btn btn-success">
                                    <a style="text-decoration: none; color: white;"
                                       href="?id_question=<?= $question['id_question'] ?>&action=change">Ответить</a>
                                </button>

                                <button type="submit" class="btn btn-danger">
                                    <a style="text-decoration: none; color: white;"
                                       href="?id_question=<?= $question['id_question'] ?>&action=delete">Удалить</a>
                                </button>
                            </td>
                    <?php
                    } else {
                    ?>
                            <td>
                                <button type="submit" class="btn btn-success cd-faq-content">
                                    <a style="text-decoration: none; color: white;"
                                       href="?id_question=<?= $question['id_question'] ?>&action=view">Посмотреть ответ</a>
                                </button>
                            </td>
                <?php
                        }
                    ?>
                </tr>

                <form method="POST" action="" class="form-inline">
                <?php

                    if (!empty($_GET) && $_GET['action'] == 'change' && $_GET['id_question'] == $question['id_question'] ) {
                ?>
                    <tr>
                        <td colspan="9">
                        <textarea class="form-control" name="answer_text" placeholder="your answer" cols="70" rows="3"></textarea>
                        <input type="checkbox" name="visible" value="1" id="visible"><label for="visible">Скрытый ответ</label><br>
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
                        <input type="hidden" name="id_question" value="<?= $_GET['id_question']?>">
                        <input type="hidden" name="answer_is_done" value="1">
                        <button type="submit" name="action" value="answer" class="btn btn-success">Сохранить</button>
                        </td>
                    </tr>
                <?php
                    } elseif (!empty($_GET) && $_GET['action'] == 'view' && $_GET['id_question'] == $question['id_question'] ) {

                        $Answers = getAnswerByQuestionId($_GET['id_question']);

                        foreach ($Answers as $Answer) {
                            ?>
                        <tr>
                            <td colspan="9">
                                <?= $Answer['answer_text'] ?>
                            </td>
                        </tr>
                            <?php
                        }
                }
                ?>
                </form>
            <?php
            }
            ?>
            </tr>
            </tbody>
        </table>
        </div>
        <hr>

        <!-- СОЗДАНИЕ НОВОЙ ТЕМЫ-->
        <div>
            <form method="POST" action="" class="form-inline">
                <div class="form-row align-items-center">
                    <div class="form-group">
                        <label for="sort">Категории:</label>
                        <select name="sort_by" id="sort" class="form-control">
                            <?php
                            $categories = getAllCategories();

                            foreach ($categories as $category) {
                                ?>
                                <option value="description"><?php
                                    echo $category['category_name'];
                                    ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="text" name="subject_name" placeholder="name" value="" class="form-control">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
                    <button type="submit" name="action" value="add_subject" class="btn btn-success">Создать тему</button><br>
                </div>
            </form>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        </div>
    </div>


</div>
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
