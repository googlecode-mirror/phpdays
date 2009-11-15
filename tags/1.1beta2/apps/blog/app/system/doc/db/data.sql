-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 27 2009 г., 13:40
-- Версия сервера: 5.1.36
-- Версия PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `phpdays-blog`
--

--
-- Дамп данных таблицы `blog`
--

INSERT INTO `blog` (`_blog_id`, `_blog_category_id`, `date_create`, `date_change`, `title`, `description`, `content`, `status`) VALUES
(1, 1, '2009-09-26 00:00:00', '2009-09-27 00:00:00', 'Test blog article', 'Small description by test blog article Small description by test blog article Small description by test blog article ', 'Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.', 'active'),
(2, 1, '2009-09-14 00:00:00', '2009-09-26 00:00:00', 'Demo blog', 'About demo blog.About demo blog.About demo blog.About demo blog.About demo blog.About demo blog.About demo blog.', 'Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.Full text of test blog article.', 'active');

--
-- Дамп данных таблицы `blog_category`
--

INSERT INTO `blog_category` (`_blog_category_id`, `url_name`, `name`, `title`, `desctiption`) VALUES
(1, 'test', 'Test', 'Тест', 'Тест Тест Тест Тест'),
(2, 'about', 'About', 'О блоге', 'О блоге О блоге О блоге О блоге');

--
-- Дамп данных таблицы `blog_tag`
--

INSERT INTO `blog_tag` (`_blog_tag_id`, `_blog_id`, `material`, `color`) VALUES
(1, 2, 'test', ''),
(2, 2, 'proba', ''),
(3, 2, 'blog', ''),
(4, 1, 'test', ''),
(5, 1, 'php', '');
