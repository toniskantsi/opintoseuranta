-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 14.10.2021 klo 13:12
-- Palvelimen versio: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opintoseuranta`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `mystudents`
--

CREATE TABLE `mystudents` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL COMMENT 'Oppilas ketä opettaja seuraa',
  `teacher_id` int(11) NOT NULL COMMENT 'Opettajan id'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `mystudents`
--

INSERT INTO `mystudents` (`id`, `student_id`, `teacher_id`) VALUES
(45, 64, 44),
(48, 65, 67),
(49, 68, 64);

-- --------------------------------------------------------

--
-- Rakenne taululle `studies`
--

CREATE TABLE `studies` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL COMMENT 'Oppilaan id',
  `opintoaine` varchar(255) NOT NULL,
  `tehtava` varchar(255) NOT NULL,
  `vaihe` varchar(255) NOT NULL,
  `date` datetime NOT NULL COMMENT 'Päivämäärä milloin muokattu',
  `muokkaaja` int(11) NOT NULL COMMENT 'Käyttäjä joka viimeksi muokannut'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `studies`
--

INSERT INTO `studies` (`id`, `student_id`, `opintoaine`, `tehtava`, `vaihe`, `date`, `muokkaaja`) VALUES
(80, 62, 'Kemia', 'Laboratorio', 'Kesken', '2021-10-14 00:15:47', 67),
(81, 65, 'Kemia', 'Moolit', 'Valmis', '2021-10-12 00:00:00', 65),
(83, 65, 'Historia', 'Sodat', 'Kesken', '2021-10-14 11:37:13', 67),
(84, 62, 'Matikka', 'Algebra', 'Valmis', '2021-10-13 00:00:00', 62),
(86, 62, 'Kemia', 'Moolit', 'Kesken', '2021-10-13 23:49:49', 62),
(87, 68, 'Kemia', 'Taulukot', 'Aloittamatta', '2021-10-14 11:57:31', 68),
(88, 68, 'Matikka', 'Algebra', 'Kesken', '2021-10-14 14:35:43', 68),
(89, 68, 'Matikka Kemia Liikunta', 'asdasdasdasdasdasdasdasdasd', 'Aloittamatta', '2021-10-14 00:00:00', 68),
(90, 68, 'Liikunta', '', 'Valmis', '2021-10-14 00:00:00', 68),
(91, 68, 'Liikunta', '', 'Aloittamatta', '2021-10-14 00:00:00', 68);

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` int(11) NOT NULL COMMENT '0=opettaja 1=oppilas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `usertype`) VALUES
(44, 'teacher', 'teacher', 'teacher@hotmail.com', '$2y$10$qRlZp/qlljXwb2KY4ntmv.FdB8khZPAHZ/Xer9m6CQGVhFSjpn8j.', 0),
(57, 'oppilas', 'oppilas', 'oppilas@hotmail.com', '$2y$10$zAot7j27LJ5faRH2dv9vf.yF.IaTvErGkgbnzwlQ7S1HsCLUJYpsC', 1),
(60, 'test', 'test', 'test@hotmail.com', '$2y$10$P02ZumdF2BAtqNU2Qpp3X.aKt0uQHsBu1d1lRs9H/nRPrpJELJSke', 1),
(61, 'opettaja', 'opettaja', 'opettaja@hotmail.com', '$2y$10$GvrkIzqF1cqzc4XZ8AYx.ufSA1AmUWAtikW/UQe153WrHje4bFXHi', 0),
(62, 'Samuli', 'Edelmann', 'samuli@asd.com', '$2y$10$McnCvwvDTUvQ0UWc8fmuQucDYbdg9hrPuE.t3g18F8kVnXJH4HMWu', 1),
(63, 'Jasper', 'PÃ¤Ã¤kkÃ¶nen', 'jasu@asd.com', '$2y$10$M.hvksKvn9bdcBo6ZBc0jOwaFle7lJw4VeeAhuYm6JTO9QChte3pe', 1),
(64, 'Samuli', 'Putro', 'putro@asd.com', '$2y$10$w4TjI6mgp1Psd7UlWsHtLO/eQ9BY2lt8uLABnWeSif1syXJvTv3Qa', 0),
(65, 'Toni', 'Skantsi', 'asd@asd.com', '$2y$10$0pr3RnhwHtmtQ8B.nYQTEOhTr3Rksqy2KiIelrbMDY9.91KVY1N3.', 1),
(66, 'Jari', 'Litmanen', 'jari@asd.com', '$2y$10$DrZedqmy85EkYKtTvRjs7uwKLO/BK6JwjJw7IwR/eohfLyjYSyJEi', 1),
(67, 'Teemu', 'SelÃ¤nne', 'teme@asd.com', '$2y$10$AiJLXzQfe1mIPV6y4EeJFeBawHucCQy7z0153TqPR0K2J6yRvcWhm', 0),
(68, 'Markku', 'Kanerva', 'markku@asd.com', '$2y$10$kUKdsRYSGstyKig2pJpEgei3S9Mo/0ySvadOQuFuPdgyopbu6aBEi', 1),
(69, 'asdad', 'dsds', 'asdssds@asd.com', '$2y$10$VjZct0wwmwmeReaiROQCLu1spHGcxhwXmjCDbnXKIreVUFbial19G', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mystudents`
--
ALTER TABLE `mystudents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`,`teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `studies`
--
ALTER TABLE `studies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mystudents`
--
ALTER TABLE `mystudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `studies`
--
ALTER TABLE `studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `mystudents`
--
ALTER TABLE `mystudents`
  ADD CONSTRAINT `mystudents_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mystudents_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Rajoitteet taululle `studies`
--
ALTER TABLE `studies`
  ADD CONSTRAINT `studies_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
