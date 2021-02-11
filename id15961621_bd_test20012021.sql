-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 11 2021 г., 04:34
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `id15961621_bd_test20012021`
--

-- --------------------------------------------------------

--
-- Структура таблицы `counters`
--

CREATE TABLE `counters` (
  `counter_id` int(11) NOT NULL,
  `counter_type` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `counter_number` char(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `counters`
--

INSERT INTO `counters` (`counter_id`, `counter_type`, `counter_number`) VALUES
(1, 'горячая вода', 'СГВ-123456'),
(13, 'горячая вода', 'СГВ-13243435'),
(13, 'горячая вода', 'СГВ-1525777'),
(11, 'горячая вода', 'СГВ-1548762'),
(1, 'холодная вода', 'СХВ-456789'),
(13, 'холодная вода', 'СХВ-51456025'),
(11, 'холодная вода', 'СХВ-641550'),
(11, 'электроэнергия', 'СЭ-15452'),
(13, 'электроэнергия', 'СЭ-546403419'),
(1, 'электроэнергия', 'СЭ-9870');

-- --------------------------------------------------------

--
-- Структура таблицы `information`
--

CREATE TABLE `information` (
  `info_id` int(11) NOT NULL,
  `info_name` text COLLATE utf8_unicode_ci NOT NULL,
  `info_inn` bigint(20) NOT NULL,
  `info_adress` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `information`
--

INSERT INTO `information` (`info_id`, `info_name`, `info_inn`, `info_adress`) VALUES
(1, 'ИП Хасанов Тимур Маратович', 123456789, '450064, Россия, РБ, г.Уфа, ул.Бикбая, 17'),
(11, 'ИП Хайруллин Руслан Рамилевич', 997788554, '450033, г.Уфа, ул.Сосновская, 54'),
(13, 'Кабирова Лилия Рустамовна', 123456789123, 'г. Уфа, ул. Бикбая, д. 17');

-- --------------------------------------------------------

--
-- Структура таблицы `result`
--

CREATE TABLE `result` (
  `result_id` int(11) NOT NULL,
  `result_type` text COLLATE utf8_unicode_ci NOT NULL,
  `result_number` text COLLATE utf8_unicode_ci NOT NULL,
  `result_res` int(11) NOT NULL,
  `result_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `result`
--

INSERT INTO `result` (`result_id`, `result_type`, `result_number`, `result_res`, `result_date`) VALUES
(13, 'холодная вода', 'cw-123456', 10, '2021-02-09 11:39:45'),
(13, 'горячая вода', 'ZX45678', 1, '2021-02-09 16:28:56'),
(13, 'горячая вода', 'ZX45678', 2, '2021-02-09 16:30:30'),
(13, 'холодная вода', 'cw-123456', 15, '2021-02-09 16:31:31'),
(13, 'горячая вода', 'ZX45678', 10, '2021-02-09 16:31:48'),
(13, 'холодная вода', 'cw-123456', 20, '2021-02-09 16:35:41'),
(13, 'холодная вода', 'cw-123456', 25, '2021-02-09 16:41:48'),
(13, 'холодная вода', 'cw-123456', 26, '2021-02-10 03:59:00'),
(1, 'горячая вода', 'СГВ-123456', 15, '2021-02-10 05:14:59'),
(1, 'электроэнергия', 'СЭ-9870', 11, '2021-02-10 11:38:38'),
(13, 'горячая вода', 'СГВ-1525777', 1, '2021-02-11 09:33:19');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_login` text COLLATE utf8_unicode_ci NOT NULL,
  `user_password` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`) VALUES
(1, 'box232', '123456'),
(11, 'pyshka-215', '123456пароль0'),
(13, 'lili', 'test');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `counters`
--
ALTER TABLE `counters`
  ADD UNIQUE KEY `counter_number` (`counter_number`);

--
-- Индексы таблицы `information`
--
ALTER TABLE `information`
  ADD UNIQUE KEY `info_id` (`info_id`);

--
-- Индексы таблицы `result`
--
ALTER TABLE `result`
  ADD UNIQUE KEY `result_date` (`result_date`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
