-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 15, 2025 at 03:44 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `space_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `agencies`
--

CREATE TABLE `agencies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `founded_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `name`, `country`, `founded_year`) VALUES
(1, 'NASA', 'USA', 1958),
(2, 'ESA', 'Europe', 1975),
(3, 'SpaceX', 'USA', 2002);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `mission_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `mission_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 1, 'Ta misja była przełomowa dla ludzkości.', '2025-06-07 12:02:47'),
(2, 2, 1, 'Bardzo ciekawa misja Europejskiej Agencji Kosmicznej.', '2025-06-07 12:02:47'),
(6, 3, 2, 'dimson', '2025-06-08 10:24:11'),
(7, 3, 2, 'dima', '2025-06-08 18:24:46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`id`, `title`, `description`, `launch_date`, `agency_id`, `image_url`) VALUES
(1, 'Przelot Juice Venus', 'Drugi przelot obok misji Jupiter Icy Moons Explorer (Juice) Europejskiej Agencji Kosmicznej (ESA) zmierzającej do układu Jowisza.', '2025-08-31', 2, 'images/mis_01.jpeg'),
(2, 'Oddokowanie Boeinga Starliner-1', 'Boeing CST-100 Starliner odłączy się od Międzynarodowej Stacji Kosmicznej i przeprowadzi deorbitację jako część swojej pierwszej misji operacyjnej. Po deorbitacji kapsuła znajdzie się w atmosferze Ziemi i wyląduje na „White Sands Missile Range” za pomocą spadochronów.', '2025-12-31', 1, 'images/mis_02.jpeg'),
(3, 'Przystań SNC-1 Dream Chaser', 'NASA TV będzie transmitować na żywo spotkanie i przechwycenie statku transportowego Dream Chaser firmy Sierra Nevada Corporation, który zabierze go na Międzynarodową Stację Kosmiczną.', '2025-12-31', 1, 'images/mis_03.jpeg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `avatar`) VALUES
(1, 'testuser', 'test@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'user', ''),
(2, 'dimatest48', 'dimatest2112@gmail.com', '9e72af74175fbe6260cd3dcf9686547fe2e58c70075f7d94e450ff6559e87c9e', 'admin', 'avatars/6845d555e30cb.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mission_id` (`mission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
