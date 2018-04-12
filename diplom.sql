-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 10 2018 г., 13:43
-- Версия сервера: 5.6.38
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Diplom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id_answer` int(11) NOT NULL,
  `answer_text` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `visible` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id_answer`, `answer_text`, `user_id`, `id_question`, `id_status`, `visible`) VALUES
(6, '0', 0, 0, 1, 1),
(9, '1414', 0, 0, 1, NULL),
(10, 'simple answer', 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `id_subject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_category`, `category_name`, `id_subject`) VALUES
(1, 'BASICS', 0),
(2, 'MOBILE', 0),
(3, 'ACCOUNT', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id_question` int(11) NOT NULL,
  `question_text` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_status` int(11) DEFAULT NULL,
  `id_category` int(5) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer_is_done` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id_question`, `question_text`, `email`, `creation_date`, `id_status`, `id_category`, `visible`, `user_id`, `answer_is_done`) VALUES
(1, 'Самый простой вопрос', 'a@mail.ru', '2018-04-08 12:01:43', NULL, 0, 0, 2, 1),
(2, 'Еще один такой же простой вопрос', 'ku@ya.ru', '2018-04-10 07:44:23', NULL, 0, 0, 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Ожидает ответа'),
(2, 'Ответ получен');

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id_subject` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id_subject`, `subject_name`, `id_category`) VALUES
(1, 'name', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id_creater` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `email`, `fio`, `date_added`, `user_id_creater`) VALUES
(2, 'admin', '$2y$10$tdc1ClGXSTS445e0KihB0OPhMqRg4wdhazo2BCkJFM7SlgarftT0O', 'admin@ya.ru', 'Main Admin', '2018-04-10 10:15:56', 0),
(23, 'admin2', '$2y$10$NyQvDLjjkHeIGAt.wWHydeHpnUrNpXL9XKMGrKVgK63z6Zuz34Wy2', 'admin@mail.ru', 'Admin Adminich', '2018-04-09 13:55:37', 2),
(24, 'admin3', '$2y$10$2R7Yh27pnzM1CD8dPFEB9OnoufPk9vWZEDCu5WP1FXKoeTehRcBde', 'amin3@mail.ru', 'Admin2 Adminich', '2018-04-07 08:49:18', 2),
(26, 'admin1', '$2y$10$i/787wafrxVTEmn4wSIOi.OMmndGEzpo0lCOD4q4qZpcqdw/WTCEC', 'admin@yandex.ru', 'Admn1 Admin1', '2018-04-07 10:50:43', 2),
(27, 'newadmin', '$2y$10$YOtsbrJTK7lOdbGJh0WE0uYM5ZGfnHpe1/agvaAM3YOsbiBS4UpxC', 'newadmin@yandex.ru', 'Admin New', '2018-04-07 12:32:46', 23);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id_answer`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id_subject`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id_answer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
