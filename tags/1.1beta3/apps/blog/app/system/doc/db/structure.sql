-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 27 2009 г., 13:38
-- Версия сервера: 5.1.36
-- Версия PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `phpdays-blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `_blog_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `_blog_category_id` smallint(5) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_change` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `status` enum('active','inactive','draft') NOT NULL,
  PRIMARY KEY (`_blog_id`),
  KEY `_post_category_id` (`_blog_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `blog_category`
--

CREATE TABLE IF NOT EXISTS `blog_category` (
  `_blog_category_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `url_name` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desctiption` text NOT NULL,
  PRIMARY KEY (`_blog_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `blog_tag`
--

CREATE TABLE IF NOT EXISTS `blog_tag` (
  `_blog_tag_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `_blog_id` smallint(5) NOT NULL,
  `material` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  PRIMARY KEY (`_blog_tag_id`),
  KEY `_blog_id` (`_blog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `_blog-blog_tag`
--
CREATE TABLE IF NOT EXISTS `_blog-blog_tag` (
`_blog_id` smallint(5)
,`_blog_tag_id` smallint(5)
);
-- --------------------------------------------------------

--
-- Структура для представления `_blog-blog_tag`
--
DROP TABLE IF EXISTS `_blog-blog_tag`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `_blog-blog_tag` AS select `blog`.`_blog_id` AS `_blog_id`,`blog_tag`.`_blog_tag_id` AS `_blog_tag_id` from (`blog` join `blog_tag` on((`blog`.`_blog_id` = `blog_tag`.`_blog_id`)));
