-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-05-24 00:17:52
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `matiday1_base`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `buy`
--

CREATE TABLE `buy` (
  `buy_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `status` int(1) NOT NULL,
  `buy_category_id` int(3) NOT NULL COMMENT '1:在庫なし 2:在庫あり',
  `sort_no` int(3) NOT NULL,
  `status_sort_no` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `buy`
--

INSERT INTO `buy` (`buy_id`, `name`, `status`, `buy_category_id`, `sort_no`, `status_sort_no`) VALUES
(1, '人参', 2, 0, 0, 1),
(2, '大根', 1, 0, 1, 2),
(3, '豆腐', 2, 0, 2, 2),
(4, '玉ねぎ', 1, 0, 3, 1),
(5, 'キャベツ', 2, 0, 4, 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `goal`
--

CREATE TABLE `goal` (
  `goal_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `goal`
--

INSERT INTO `goal` (`goal_id`, `name`) VALUES
(1, '英語'),
(2, '韓国語!'),
(3, 'ダイエット'),
(6, '英語!');

-- --------------------------------------------------------

--
-- テーブルの構造 `list`
--

CREATE TABLE `list` (
  `list_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `comment` text NOT NULL,
  `list_category_id` int(11) NOT NULL,
  `list_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `list`
--

INSERT INTO `list` (`list_id`, `name`, `comment`, `list_category_id`, `list_date`) VALUES
(1, 'aa!', '', 2, '0000-00-00'),
(3, 'aaaaa', '', 3, '0000-00-00'),
(4, 'ss', '', 2, '0000-00-00');

-- --------------------------------------------------------

--
-- テーブルの構造 `list_category`
--

CREATE TABLE `list_category` (
  `list_category_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `list_category`
--

INSERT INTO `list_category` (`list_category_id`, `name`) VALUES
(1, '映画'),
(2, 'ドラマ'),
(3, '漫画'),
(4, '本');

-- --------------------------------------------------------

--
-- テーブルの構造 `menu_data`
--

CREATE TABLE `menu_data` (
  `menu_data_id` int(11) NOT NULL,
  `menu1` varchar(128) NOT NULL,
  `menu2` varchar(128) NOT NULL,
  `menu3` varchar(128) NOT NULL,
  `menu4` varchar(128) NOT NULL,
  `memo` varchar(256) NOT NULL,
  `menu_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `menu_data`
--

INSERT INTO `menu_data` (`menu_data_id`, `menu1`, `menu2`, `menu3`, `menu4`, `memo`, `menu_date`) VALUES
(1, 'aaa', '', '', '', '', '2024-05-01'),
(2, '', 'aaa', '', '', '', '2024-05-02'),
(3, 'aaa', '', '', '', '', '2024-04-04'),
(4, '', 'aaa', '', '', '', '2024-05-04');

-- --------------------------------------------------------

--
-- テーブルの構造 `payment_category`
--

CREATE TABLE `payment_category` (
  `payment_category_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `payment_type` int(1) NOT NULL COMMENT '1:支出 2:収入',
  `sort_no` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `payment_category`
--

INSERT INTO `payment_category` (`payment_category_id`, `name`, `payment_type`, `sort_no`) VALUES
(1, 'aaa', 1, 0),
(2, 'sss!!', 2, 2),
(3, 'ddd', 1, 1),
(10, 'sss', 1, 2),
(11, 'fff', 1, 2),
(12, 'ddddd', 1, 3),
(13, 'dddddQQ', 2, 3),
(14, 'fffss', 1, 4),
(15, 'fff!', 1, 5),
(16, 'sss!', 2, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `payment_data`
--

CREATE TABLE `payment_data` (
  `payment_data_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `memo` varchar(256) NOT NULL,
  `payment_category_id` int(3) NOT NULL,
  `money` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `payment_data`
--

INSERT INTO `payment_data` (`payment_data_id`, `title`, `memo`, `payment_category_id`, `money`, `date`) VALUES
(1, 'aa', '', 1, 111, '2024-05-02'),
(2, 'ssss', '', 2, 11, '2024-04-04');

-- --------------------------------------------------------

--
-- テーブルの構造 `schedule_category`
--

CREATE TABLE `schedule_category` (
  `schedule_category_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `schedule_category`
--

INSERT INTO `schedule_category` (`schedule_category_id`, `name`) VALUES
(1, 'ｓｓｓ'),
(2, 'ラジオ');

-- --------------------------------------------------------

--
-- テーブルの構造 `schedule_data`
--

CREATE TABLE `schedule_data` (
  `schedule_data_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `detail` text NOT NULL,
  `dialy` text NOT NULL,
  `schedule_category_id` int(11) NOT NULL,
  `schedule_status_id` int(3) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `schedule_data`
--

INSERT INTO `schedule_data` (`schedule_data_id`, `title`, `detail`, `dialy`, `schedule_category_id`, `schedule_status_id`, `spot_id`, `date`) VALUES
(1, 'ｄｄｄ', 'ああ', 'あああ', 1, 1, 1, '2024-05-17'),
(2, 'あああ', 'あ', 'あ', 2, 1, 1, '2024-05-23');

-- --------------------------------------------------------

--
-- テーブルの構造 `schedule_status`
--

CREATE TABLE `schedule_status` (
  `schedule_status_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `schedule_status`
--

INSERT INTO `schedule_status` (`schedule_status_id`, `name`) VALUES
(1, '行った'),
(2, '外れた');

-- --------------------------------------------------------

--
-- テーブルの構造 `spot`
--

CREATE TABLE `spot` (
  `spot_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `area` varchar(256) NOT NULL,
  `capa` int(11) NOT NULL,
  `capa_stand` int(11) NOT NULL,
  `url` varchar(256) NOT NULL,
  `memo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `spot`
--

INSERT INTO `spot` (`spot_id`, `name`, `area`, `capa`, `capa_stand`, `url`, `memo`) VALUES
(1, 'Kアリーナ', 'かながわ', 100000, 0, '', 'aa'),
(2, 'aa', '', 0, 0, '', '');

-- --------------------------------------------------------

--
-- テーブルの構造 `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `task_category_id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `task_status_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `task`
--

INSERT INTO `task` (`task_id`, `name`, `task_category_id`, `goal_id`, `start_date`, `end_date`, `task_status_id`) VALUES
(2, 'aaaa', 1, 1, '2024-04-30', '2024-04-30', 0),
(3, 'aaa', 1, 2, '2024-05-28', '2024-06-06', 0),
(4, 'ｓｓｓ!', 2, 1, '2024-04-30', '2024-05-21', 1),
(5, 'ｓｓ', 2, 2, '2024-05-08', '2024-05-27', 0),
(6, 'ああ', 2, 2, '2024-05-01', '2024-05-22', 1),
(7, 'ああ', 2, 2, '2024-05-01', '2024-05-22', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `task_category`
--

CREATE TABLE `task_category` (
  `task_category_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `task_category`
--

INSERT INTO `task_category` (`task_category_id`, `name`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- テーブルの構造 `task_data`
--

CREATE TABLE `task_data` (
  `task_data_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_data_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `task_status`
--

CREATE TABLE `task_status` (
  `task_status_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `task_status`
--

INSERT INTO `task_status` (`task_status_id`, `name`) VALUES
(0, '未着手'),
(1, '着手中'),
(2, '完了'),
(3, '中止');

-- --------------------------------------------------------

--
-- テーブルの構造 `todo`
--

CREATE TABLE `todo` (
  `todo_id` int(11) NOT NULL,
  `todo` varchar(256) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `todo_interval_id` int(11) NOT NULL,
  `detail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `todo`
--

INSERT INTO `todo` (`todo_id`, `todo`, `goal_id`, `todo_interval_id`, `detail`) VALUES
(1, 'あああ', 1, 1, 'ああ'),
(2, 'ああああ', 2, 3, 'あ'),
(3, 'ｑｑｑｑｑｑｑｑ', 1, 1, ''),
(5, 'あああああああ', 2, 2, '');

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_data`
--

CREATE TABLE `todo_data` (
  `todo_data_id` int(11) NOT NULL,
  `todo_id` int(11) NOT NULL,
  `todo_data_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `todo_data`
--

INSERT INTO `todo_data` (`todo_data_id`, `todo_id`, `todo_data_date`) VALUES
(1, 1, '2024-05-07'),
(2, 1, '2024-05-17');

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_interval`
--

CREATE TABLE `todo_interval` (
  `todo_interval_id` int(11) NOT NULL,
  `name` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `todo_interval`
--

INSERT INTO `todo_interval` (`todo_interval_id`, `name`) VALUES
(1, '日'),
(2, '週'),
(3, '月');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`buy_id`);

--
-- テーブルのインデックス `goal`
--
ALTER TABLE `goal`
  ADD PRIMARY KEY (`goal_id`);

--
-- テーブルのインデックス `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`list_id`);

--
-- テーブルのインデックス `list_category`
--
ALTER TABLE `list_category`
  ADD PRIMARY KEY (`list_category_id`);

--
-- テーブルのインデックス `menu_data`
--
ALTER TABLE `menu_data`
  ADD PRIMARY KEY (`menu_data_id`);

--
-- テーブルのインデックス `payment_category`
--
ALTER TABLE `payment_category`
  ADD PRIMARY KEY (`payment_category_id`);

--
-- テーブルのインデックス `payment_data`
--
ALTER TABLE `payment_data`
  ADD PRIMARY KEY (`payment_data_id`),
  ADD KEY `payment_category_id` (`payment_category_id`);

--
-- テーブルのインデックス `schedule_category`
--
ALTER TABLE `schedule_category`
  ADD PRIMARY KEY (`schedule_category_id`);

--
-- テーブルのインデックス `schedule_data`
--
ALTER TABLE `schedule_data`
  ADD PRIMARY KEY (`schedule_data_id`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `schedule_category_id` (`schedule_category_id`),
  ADD KEY `schedule_status_id` (`schedule_status_id`);

--
-- テーブルのインデックス `schedule_status`
--
ALTER TABLE `schedule_status`
  ADD PRIMARY KEY (`schedule_status_id`);

--
-- テーブルのインデックス `spot`
--
ALTER TABLE `spot`
  ADD PRIMARY KEY (`spot_id`);

--
-- テーブルのインデックス `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- テーブルのインデックス `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`task_category_id`);

--
-- テーブルのインデックス `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`task_status_id`);

--
-- テーブルのインデックス `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`todo_id`),
  ADD KEY `task_category_id` (`goal_id`),
  ADD KEY `task_interval_id` (`todo_interval_id`);

--
-- テーブルのインデックス `todo_data`
--
ALTER TABLE `todo_data`
  ADD PRIMARY KEY (`todo_data_id`),
  ADD KEY `task_id` (`todo_id`);

--
-- テーブルのインデックス `todo_interval`
--
ALTER TABLE `todo_interval`
  ADD PRIMARY KEY (`todo_interval_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `buy`
--
ALTER TABLE `buy`
  MODIFY `buy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `goal`
--
ALTER TABLE `goal`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `list`
--
ALTER TABLE `list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `list_category`
--
ALTER TABLE `list_category`
  MODIFY `list_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `menu_data`
--
ALTER TABLE `menu_data`
  MODIFY `menu_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `payment_category`
--
ALTER TABLE `payment_category`
  MODIFY `payment_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- テーブルの AUTO_INCREMENT `payment_data`
--
ALTER TABLE `payment_data`
  MODIFY `payment_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `schedule_category`
--
ALTER TABLE `schedule_category`
  MODIFY `schedule_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `schedule_data`
--
ALTER TABLE `schedule_data`
  MODIFY `schedule_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `schedule_status`
--
ALTER TABLE `schedule_status`
  MODIFY `schedule_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `spot`
--
ALTER TABLE `spot`
  MODIFY `spot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `task_category`
--
ALTER TABLE `task_category`
  MODIFY `task_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `task_status`
--
ALTER TABLE `task_status`
  MODIFY `task_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `todo`
--
ALTER TABLE `todo`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `todo_data`
--
ALTER TABLE `todo_data`
  MODIFY `todo_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `todo_interval`
--
ALTER TABLE `todo_interval`
  MODIFY `todo_interval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `payment_data`
--
ALTER TABLE `payment_data`
  ADD CONSTRAINT `payment_data_ibfk_1` FOREIGN KEY (`payment_category_id`) REFERENCES `payment_category` (`payment_category_id`);

--
-- テーブルの制約 `schedule_data`
--
ALTER TABLE `schedule_data`
  ADD CONSTRAINT `schedule_data_ibfk_1` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`spot_id`),
  ADD CONSTRAINT `schedule_data_ibfk_2` FOREIGN KEY (`schedule_category_id`) REFERENCES `schedule_category` (`schedule_category_id`),
  ADD CONSTRAINT `schedule_data_ibfk_3` FOREIGN KEY (`schedule_status_id`) REFERENCES `schedule_status` (`schedule_status_id`);

--
-- テーブルの制約 `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`goal_id`) REFERENCES `task_category` (`task_category_id`),
  ADD CONSTRAINT `todo_ibfk_2` FOREIGN KEY (`todo_interval_id`) REFERENCES `todo_interval` (`todo_interval_id`);

--
-- テーブルの制約 `todo_data`
--
ALTER TABLE `todo_data`
  ADD CONSTRAINT `todo_data_ibfk_1` FOREIGN KEY (`todo_id`) REFERENCES `todo` (`todo_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
