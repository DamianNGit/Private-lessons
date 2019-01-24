-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Gru 2016, 01:25
-- Wersja serwera: 10.1.16-MariaDB
-- Wersja PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `id` int(11) NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `szkola` text COLLATE utf8_polish_ci NOT NULL,
  `przedmiot` text COLLATE utf8_polish_ci NOT NULL,
  `kontakt` text COLLATE utf8_polish_ci NOT NULL,
  `stawka` int(11) NOT NULL,
  `zdjecie` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ogloszenia`
--

INSERT INTO `ogloszenia` (`id`, `tresc`, `szkola`, `przedmiot`, `kontakt`, `stawka`, `zdjecie`) VALUES
(1, 'Praesent tellus tellus, sagittis ut laoreet vel, porta non lectus. Mauris et blandit ex. Morbi luctus congue ligula, in vehicula est posuere nec. ', 'podstawowka', 'historia', 'cokolwiek@gmail.com', 40, '<img src=img\\1.jpg>'),
(2, 'leo vel sem rutrum venenatis. In sit amet enim a nulla pulvinar auctor. Donec at justo velit. Fusce cursus leo sapien, eget consequat risus ', 'gimnazjum', 'matematyka', 'dafaf@op.pl', 60, '<img src=img\\2.jpg>'),
(3, 'Ut magna ipsum, euismod in nisl nec, cursus lobortis nisi. Aliquam blandit eros magna, ut efficitur lacus rhoncus sed. Aenean viverra ', 'podstawowka', 'matematyka', 'fsfjksjf@op.pl', 70, '<img src=img\\3.jpg>'),
(4, 'gravida orci lorem, ac mollis nisl lacinia non. Donec sollicitudin egestas felis, id ullamcorper purus sodales sit amet. Nunc quis aliquam ', 'podstawowka', 'przyroda', '344234249', 50, '<img src=img\\4.jpg>'),
(5, 'urna leo eget velit. Duis nec ornare nulla, ultricies finibus arcu. Morbi a velit ut purus semper lobortis at lobortis tellus. Nulla porta ', 'podstawowka', 'technika', 'sfg@op.pl', 45, '<img src=img\\5.jpg>'),
(6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sodales viverra cursus. Nunc fermentum turpis eu dolor ullamcorper, eget rutrum dolor molestie. Donec orci turpis, suscipit nec lacus vitae, mollis eleifend urna. Sed tincidunt ', 'podstawowka', 'matematyka', 'abacedlaada@gmail.com', 50, '<img src=img\\6.jpg>');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
