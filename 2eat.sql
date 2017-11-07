-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 07-Nov-2017 às 17:16
-- Versão do servidor: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2eat`
--
CREATE DATABASE IF NOT EXISTS `2eat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `2eat`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

CREATE TABLE `receita` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `imagemUrl` varchar(400) DEFAULT NULL,
  `ingredientes` text NOT NULL,
  `descricao` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `nota` float DEFAULT NULL,
  `tempo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tag` varchar(250) NOT NULL,
  `ava_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`id`, `titulo`, `imagemUrl`, `ingredientes`, `descricao`, `id_user`, `nota`, `tempo`, `tag`, `ava_num`) VALUES
(2, 'Eee', NULL, 'Eeeeee\nCccccc\nLlllllllllll', 'Bacon\n\nCcxx', 50, NULL, '2017-10-30 17:08:07', '#rrrrttt', 0),
(3, 'Aa', NULL, 'Aaaa', 'Aaaaaaa', 50, NULL, '2017-10-30 22:29:43', 'Rrrr', 0),
(4, 'Cccc', NULL, 'Eeeeeee', 'Aaaaaaaaa', 50, NULL, '2017-10-30 23:40:19', 'tttt', 0),
(5, 'Dddddd', NULL, 'Xxxxxx', 'Hhhhhhhhhh', 50, NULL, '2017-10-30 23:41:15', 'Ooooooo', 0),
(6, 'Tttt', NULL, 'Iiiiiiiii', 'Llllllllllllll', 50, NULL, '2017-10-30 23:54:15', 'Vvvvvvvv', 0),
(7, 'Gggg', NULL, 'Gggggg', 'Mmmm', 50, NULL, '2017-10-31 20:38:13', 'Aaaaa', 0),
(8, 'Rrrrr', NULL, 'Tttttttt', 'Lllllll', 52, NULL, '2017-10-31 21:18:56', 'Dddddddd', 0),
(9, 'Ftg', NULL, 'Yyyyyyy', 'Kkkkkkkkkk', 50, NULL, '2017-11-01 00:37:27', '#gggggg', 0),
(10, 'Popo?', NULL, 'Ddddd', 'Ttttttttt', 50, NULL, '2017-11-01 01:44:20', '#hue', 0),
(11, 'ola', NULL, '-Chocolate Quente\r\n-Goiaba\r\n-Refrigerante', 'Mistura tudo e vc verá que a dor de barriga será monstra!', 27, NULL, '2017-11-04 18:00:22', '#uia', 0),
(12, 'Toddy', NULL, '- Duas colheres de sopa de Toddy\r\n- 300ml de Leite', 'Com um copo de sua preferencia, adicione o leite e em seguida adicione as duas colheres do achocolatado. Misture bastante ate que a mistura fique homogenea.', 27, 4.5, '2017-11-07 03:56:03', '#Toddyzao', 10),
(13, 'Tttttt', NULL, 'Nnnnnnnnnn', 'Nnnnnnnnnn', 55, NULL, '2017-11-07 20:41:40', 'Dddddddd', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `senha` varchar(100) COLLATE utf8_bin NOT NULL,
  `profiss` tinyint(1) DEFAULT NULL,
  `nota` float DEFAULT NULL,
  `foto` varchar(200) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `nome`, `email`, `senha`, `profiss`, `nota`, `foto`) VALUES
(1, 'Luiz Gustavo', 'lgpa@icomp.ufam.edu.br', '$2y$10$b2ohlYiVw0tTgFTbCfUEOOehcY./KMFaZsdzVgKek9J6P/vd1OiU2', NULL, NULL, NULL),
(24, 'Werr', 's@z', '$2y$10$ic/BgOYae27KtexjmLVx6.XuSzgcJR.W4YaBAbR6lyOE8hFAxmHc6', NULL, NULL, NULL),
(25, 'Rrrrr', 'rrrr', '$2y$10$R/lqQaJQvVNrhPaNaSs4pOWG6j1Q7J0qUfcaU13n0dttmAg82wRKi', NULL, NULL, NULL),
(26, 'Rrrr', 'rrrrr', '$2y$10$zuskcs2tF.eTzkdky/hC3eZA6QSiwiNRWcburDDOYKEfXrfu4.jaK', NULL, NULL, NULL),
(27, 'Augusto', 'arra@3dd.com', '$2y$10$N6UNOgJ2l/VTlF/sCq3IsurUJPmFGUQMBIOPiaasgmp3CQZ5GatfS', NULL, NULL, NULL),
(28, '', '', '$2y$10$EOm8ebib.pR31MoNudIQSuJLd7gfxKQrz7nOMeU5rgcj/xGFky/LW', NULL, NULL, NULL),
(32, 'Rrtt', 'tttt', '$2y$10$JwK3T6FfHcQQSyTEiZ3Br.Wo7BmXy5RQk.4RN31W4uD9uEcZoFc..', NULL, NULL, NULL),
(38, 'Rrrr', 'eeeee', '$2y$10$50MmRWOUB29KnG.3dJSwDeYWmOdMiQiW9We7TmJEXGTUWOHlbKRyC', NULL, NULL, NULL),
(41, 'Eeeeuuuu', 'ffff', '$2y$10$lfCjr3Id.UuFmTJJRYXQKuTwoi.OVrq9o/voPEcdOlLOMhJ.m36WO', NULL, NULL, NULL),
(42, 'Teste', 'lgpa2@icomp.ufam.edu.br', '$2y$10$jzW5Uz3pZFHZRQfBoe4Gt.gJobqKSwveDN4F5A9dE42p/8R/fW6YW', NULL, NULL, NULL),
(44, 'Xxxxxxx', 'xxxxxxxxx', '$2y$10$8O1kx9x8XzYDboh6wxV9SOHh9S/ZyhD022HDboLmRmHLuDYFFrL2q', NULL, NULL, NULL),
(45, 'Rrrrr', 'aqwwee', '$2y$10$S5cBg3rSLlkomq/Y8cPySOMbUiWX5FVfHyN89dmvHhjp/TjZiDT2e', NULL, NULL, NULL),
(46, 'Ttttyyyyiii', 'ttttyyyyyuuuujj', '$2y$10$y9OnDPuuUO7eywfBndTSjef2F6kAf2XY3aGiFAUQumUQi6FXbqtky', NULL, NULL, NULL),
(47, 'LG', 'arra@icomp.ufam.edu.br', '$2y$10$/51HSRbJ3Et3dsbAfijEy.YIqyLiWLBRs0Er1Z/jnMX2JFHtDfaLm', NULL, NULL, NULL),
(49, 'Aaaaaaaaszzzz', 'arra3@icomp.ufam.edu.br', '$2y$10$rDHN9GFvXfXSoSufTMRKoul7U2gn2sCWir6cUTK8Q/ENq5G1.JMMW', NULL, NULL, NULL),
(50, 'A', 'a', '$2y$10$b2ohlYiVw0tTgFTbCfUEOOehcY./KMFaZsdzVgKek9J6P/vd1OiU2', NULL, NULL, NULL),
(51, 'B', 'b', '$2y$10$xx5Un/yvnLtb1FLi2vOGxeMSRzJm2oI42WDvNkwKliD2PsyFyGqki', NULL, NULL, NULL),
(52, 'Thiego', 'thi@rromb.ado', '$2y$10$Q5jHDwat6eU0Sb8xbRHY6uEAluy3Sh3TubJZKGUkNCHE9LPpJBjk6', NULL, NULL, NULL),
(53, 'C', 'c', '$2y$10$67Ww52n3HXH49bbgExAnBO41wNlwyQ6p5aklxVzYvTyT/wFdGxz0K', NULL, NULL, NULL),
(55, 'F', 'f', '$2y$10$bdxwbPONKiA4C99ZQ6QAlux2gFmcWTsFlEE98A3mJ4UQa3f9Ab.Mq', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_relation`
--

CREATE TABLE `user_relation` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_user_follow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_relation`
--

INSERT INTO `user_relation` (`id`, `id_user`, `id_user_follow`) VALUES
(2, 50, 27),
(5, 50, 52),
(9, 50, 55),
(6, 53, 50),
(8, 55, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unico` (`email`);

--
-- Indexes for table `user_relation`
--
ALTER TABLE `user_relation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unico` (`id_user`,`id_user_follow`),
  ADD KEY `fk_id_user` (`id_user`) USING BTREE,
  ADD KEY `fk_user_follow` (`id_user_follow`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `receita`
--
ALTER TABLE `receita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `user_relation`
--
ALTER TABLE `user_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
