-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 27, 2025 at 06:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `termanbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `intentos`
--

CREATE TABLE `intentos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `puntaje_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `intentos`
--

INSERT INTO `intentos` (`id`, `usuario_id`, `fecha`, `puntaje_total`) VALUES
(1, 1, '2025-05-22 10:27:00', 36),
(2, 2, '2025-05-26 11:09:09', 39);

-- --------------------------------------------------------

--
-- Table structure for table `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `intento_id` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `pregunta` int(11) NOT NULL,
  `respuesta_usuario` varchar(5) NOT NULL,
  `respuesta_correcta` varchar(5) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `respuestas`
--

INSERT INTO `respuestas` (`id`, `intento_id`, `serie`, `pregunta`, `respuesta_usuario`, `respuesta_correcta`, `es_correcta`) VALUES
(1, 1, 1, 1, 'c', 'b', 0),
(2, 1, 1, 2, 'b', 'a', 0),
(3, 1, 1, 3, 'c', 'a', 0),
(4, 1, 1, 4, 'b', 'b', 1),
(5, 1, 1, 5, 'b', 'd', 0),
(6, 1, 1, 6, 'c', 'c', 1),
(7, 1, 1, 7, 'c', 'a', 0),
(8, 1, 1, 8, 'd', 'c', 0),
(9, 1, 1, 9, 'd', 'c', 0),
(10, 1, 1, 10, 'a', 'c', 0),
(11, 1, 2, 1, 'c', 'c', 1),
(12, 1, 2, 2, 'c', 'a', 0),
(13, 1, 2, 3, 'b', 'b', 1),
(14, 1, 2, 4, 'b', 'c', 0),
(15, 1, 2, 5, 'b', 'c', 0),
(16, 1, 2, 6, 'c', 'b', 0),
(17, 1, 2, 7, 'a', 'c', 0),
(18, 1, 2, 8, 'a', 'c', 0),
(19, 1, 2, 9, 'b', 'b', 1),
(20, 1, 2, 10, 'a', 'a', 1),
(21, 1, 3, 1, 'b', 'b', 1),
(22, 1, 3, 2, 'b', 'a', 0),
(23, 1, 3, 3, 'b', 'b', 1),
(24, 1, 3, 4, 'b', 'b', 1),
(25, 1, 3, 5, 'b', 'b', 1),
(26, 1, 3, 6, 'b', 'b', 1),
(27, 1, 3, 7, 'b', 'a', 0),
(28, 1, 3, 8, 'a', 'a', 1),
(29, 1, 3, 9, 'b', 'b', 1),
(30, 1, 3, 10, 'a', 'a', 1),
(31, 1, 4, 1, 'c', 'b', 0),
(32, 1, 4, 2, 'd', 'b', 0),
(33, 1, 4, 3, 'd', 'c', 0),
(34, 1, 4, 4, 'b', 'a', 0),
(35, 1, 4, 5, 'c', 'd', 0),
(36, 1, 4, 6, 'd', 'c', 0),
(37, 1, 4, 7, 'b', 'b', 1),
(38, 1, 4, 8, 'd', 'a', 0),
(39, 1, 4, 9, 'a', 'a', 1),
(40, 1, 4, 10, 'c', 'a', 0),
(41, 1, 5, 1, 'b', 'c', 0),
(42, 1, 5, 2, 'd', 'b', 0),
(43, 1, 5, 3, 'b', 'd', 0),
(44, 1, 5, 4, 'd', 'a', 0),
(45, 1, 5, 5, 'd', 'd', 1),
(46, 1, 5, 6, 'd', 'c', 0),
(47, 1, 5, 7, 'b', 'b', 1),
(48, 1, 5, 8, 'b', 'b', 1),
(49, 1, 5, 9, 'b', 'a', 0),
(50, 1, 5, 10, 'b', 'c', 0),
(51, 1, 6, 1, 'b', 'a', 0),
(52, 1, 6, 2, 'b', 'b', 1),
(53, 1, 6, 3, 'b', 'b', 1),
(54, 1, 6, 4, 'b', 'a', 0),
(55, 1, 6, 5, 'b', 'a', 0),
(56, 1, 6, 6, 'b', 'b', 1),
(57, 1, 6, 7, 'b', 'b', 1),
(58, 1, 6, 8, 'b', 'b', 1),
(59, 1, 6, 9, 'a', 'a', 1),
(60, 1, 6, 10, 'a', 'a', 1),
(61, 1, 7, 1, 'd', 'a', 0),
(62, 1, 7, 2, 'b', 'a', 0),
(63, 1, 7, 3, 'd', 'c', 0),
(64, 1, 7, 4, 'c', 'b', 0),
(65, 1, 7, 5, 'd', 'b', 0),
(66, 1, 7, 6, 'c', 'd', 0),
(67, 1, 7, 7, 'b', 'c', 0),
(68, 1, 7, 8, 'b', 'a', 0),
(69, 1, 7, 9, 'd', 'a', 0),
(70, 1, 7, 10, 'b', 'd', 0),
(71, 1, 8, 1, 'b', 'a', 0),
(72, 1, 8, 2, 'b', 'b', 1),
(73, 1, 8, 3, 'b', 'a', 0),
(74, 1, 8, 4, 'b', 'b', 1),
(75, 1, 8, 5, 'b', 'a', 0),
(76, 1, 8, 6, 'b', 'b', 1),
(77, 1, 8, 7, 'a', 'b', 0),
(78, 1, 8, 8, 'a', 'a', 1),
(79, 1, 8, 9, 'b', 'a', 0),
(80, 1, 8, 10, 'a', 'a', 1),
(81, 1, 9, 1, 'c', 'd', 0),
(82, 1, 9, 2, 'c', 'e', 0),
(83, 1, 9, 3, 'b', 'c', 0),
(84, 1, 9, 4, 'a', 'b', 0),
(85, 1, 9, 5, 'd', 'c', 0),
(86, 1, 9, 6, 'b', 'd', 0),
(87, 1, 9, 7, 'c', 'e', 0),
(88, 1, 9, 8, 'c', 'a', 0),
(89, 1, 9, 9, 'd', 'd', 1),
(90, 1, 9, 10, 'c', 'c', 1),
(91, 1, 10, 1, 'c', 'a', 0),
(92, 1, 10, 2, 'b', 'a', 0),
(93, 1, 10, 3, 'b', 'd', 0),
(94, 1, 10, 4, 'b', 'a', 0),
(95, 1, 10, 5, 'c', 'a', 0),
(96, 1, 10, 6, 'b', 'b', 1),
(97, 1, 10, 7, 'b', 'a', 0),
(98, 1, 10, 8, 'a', 'a', 1),
(99, 1, 10, 9, 'c', 'a', 0),
(100, 1, 10, 10, 'b', 'b', 1),
(101, 2, 1, 1, 'a', 'b', 0),
(102, 2, 1, 2, 'a', 'a', 1),
(103, 2, 1, 3, 'a', 'a', 1),
(104, 2, 1, 4, 'b', 'b', 1),
(105, 2, 1, 5, 'b', 'd', 0),
(106, 2, 1, 6, 'b', 'c', 0),
(107, 2, 1, 7, 'b', 'a', 0),
(108, 2, 1, 8, 'b', 'c', 0),
(109, 2, 1, 9, 'c', 'c', 1),
(110, 2, 1, 10, 'b', 'c', 0),
(111, 2, 2, 1, 'a', 'c', 0),
(112, 2, 2, 2, 'b', 'a', 0),
(113, 2, 2, 3, 'c', 'b', 0),
(114, 2, 2, 4, 'c', 'c', 1),
(115, 2, 2, 5, 'a', 'c', 0),
(116, 2, 2, 6, 'a', 'b', 0),
(117, 2, 2, 7, 'b', 'c', 0),
(118, 2, 2, 8, 'a', 'c', 0),
(119, 2, 2, 9, 'b', 'b', 1),
(120, 2, 2, 10, 'c', 'a', 0),
(121, 2, 3, 1, 'a', 'b', 0),
(122, 2, 3, 2, 'a', 'a', 1),
(123, 2, 3, 3, 'a', 'b', 0),
(124, 2, 3, 4, 'a', 'b', 0),
(125, 2, 3, 5, 'b', 'b', 1),
(126, 2, 3, 6, 'b', 'b', 1),
(127, 2, 3, 7, 'b', 'a', 0),
(128, 2, 3, 8, 'a', 'a', 1),
(129, 2, 3, 9, 'b', 'b', 1),
(130, 2, 3, 10, 'a', 'a', 1),
(131, 2, 4, 1, 'b', 'b', 1),
(132, 2, 4, 2, 'b', 'b', 1),
(133, 2, 4, 3, 'c', 'c', 1),
(134, 2, 4, 4, 'd', 'a', 0),
(135, 2, 4, 5, 'b', 'd', 0),
(136, 2, 4, 6, 'c', 'c', 1),
(137, 2, 4, 7, 'd', 'b', 0),
(138, 2, 4, 8, 'd', 'a', 0),
(139, 2, 4, 9, 'b', 'a', 0),
(140, 2, 4, 10, 'b', 'a', 0),
(141, 2, 5, 1, 'b', 'c', 0),
(142, 2, 5, 2, 'b', 'b', 1),
(143, 2, 5, 3, 'c', 'd', 0),
(144, 2, 5, 4, 'c', 'a', 0),
(145, 2, 5, 5, 'a', 'd', 0),
(146, 2, 5, 6, 'b', 'c', 0),
(147, 2, 5, 7, 'b', 'b', 1),
(148, 2, 5, 8, 'b', 'b', 1),
(149, 2, 5, 9, 'b', 'a', 0),
(150, 2, 5, 10, 'b', 'c', 0),
(151, 2, 6, 1, 'a', 'a', 1),
(152, 2, 6, 2, 'a', 'b', 0),
(153, 2, 6, 3, 'a', 'b', 0),
(154, 2, 6, 4, 'a', 'a', 1),
(155, 2, 6, 5, 'a', 'a', 1),
(156, 2, 6, 6, 'b', 'b', 1),
(157, 2, 6, 7, 'b', 'b', 1),
(158, 2, 6, 8, 'b', 'b', 1),
(159, 2, 6, 9, 'a', 'a', 1),
(160, 2, 6, 10, 'a', 'a', 1),
(161, 2, 7, 1, 'b', 'a', 0),
(162, 2, 7, 2, 'b', 'a', 0),
(163, 2, 7, 3, 'd', 'c', 0),
(164, 2, 7, 4, 'b', 'b', 1),
(165, 2, 7, 5, 'b', 'b', 1),
(166, 2, 7, 6, 'b', 'd', 0),
(167, 2, 7, 7, 'b', 'c', 0),
(168, 2, 7, 8, 'b', 'a', 0),
(169, 2, 7, 9, 'b', 'a', 0),
(170, 2, 7, 10, 'b', 'd', 0),
(171, 2, 8, 1, 'a', 'a', 1),
(172, 2, 8, 2, 'a', 'b', 0),
(173, 2, 8, 3, 'a', 'a', 1),
(174, 2, 8, 4, 'b', 'b', 1),
(175, 2, 8, 5, 'a', 'a', 1),
(176, 2, 8, 6, 'b', 'b', 1),
(177, 2, 8, 7, 'a', 'b', 0),
(178, 2, 8, 8, 'b', 'a', 0),
(179, 2, 8, 9, 'b', 'a', 0),
(180, 2, 8, 10, 'a', 'a', 1),
(181, 2, 9, 1, 'b', 'd', 0),
(182, 2, 9, 2, 'b', 'e', 0),
(183, 2, 9, 3, 'b', 'c', 0),
(184, 2, 9, 4, 'b', 'b', 1),
(185, 2, 9, 5, 'b', 'c', 0),
(186, 2, 9, 6, 'b', 'd', 0),
(187, 2, 9, 7, 'b', 'e', 0),
(188, 2, 9, 8, 'b', 'a', 0),
(189, 2, 9, 9, 'b', 'd', 0),
(190, 2, 9, 10, 'b', 'c', 0),
(191, 2, 10, 1, 'a', 'a', 1),
(192, 2, 10, 2, 'b', 'a', 0),
(193, 2, 10, 3, 'b', 'd', 0),
(194, 2, 10, 4, 'b', 'a', 0),
(195, 2, 10, 5, 'b', 'a', 0),
(196, 2, 10, 6, 'b', 'b', 1),
(197, 2, 10, 7, 'b', 'a', 0),
(198, 2, 10, 8, 'b', 'a', 0),
(199, 2, 10, 9, 'b', 'a', 0),
(200, 2, 10, 10, 'b', 'b', 1);

-- --------------------------------------------------------

--
-- Table structure for table `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `intento_id` int(11) NOT NULL,
  `puntaje_total` int(11) NOT NULL,
  `interpretacion` varchar(255) DEFAULT NULL,
  `fecha_resultado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `edad`, `ciudad`, `departamento`, `fecha_registro`) VALUES
(1, 'Miyo', 22, 'Tijuana', 'Sistemas', '2025-05-22 17:27:00'),
(2, 'Manolo Lama', 22, 'Mexicali', 'Administracion', '2025-05-26 18:09:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `intentos`
--
ALTER TABLE `intentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `intento_id` (`intento_id`);

--
-- Indexes for table `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `intento_id` (`intento_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `intentos`
--
ALTER TABLE `intentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `intentos`
--
ALTER TABLE `intentos`
  ADD CONSTRAINT `intentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`intento_id`) REFERENCES `intentos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`intento_id`) REFERENCES `intentos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
