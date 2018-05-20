-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 20-Maio-2018 às 04:03
-- Versão do servidor: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

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
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE `avaliacao` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_receita` int(11) NOT NULL,
  `nota` float DEFAULT NULL,
  `texto` text,
  `tempo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `id_user`, `id_receita`, `nota`, `texto`, `tempo`) VALUES
(11, 50, 11, 4, NULL, '2017-11-21 12:25:48'),
(12, 51, 11, 3, 'Legal!!\nMas chato', '2017-11-21 12:42:09'),
(13, 50, 12, 2, 'Nao gostei', '2017-11-21 20:57:48'),
(14, 27, 11, NULL, 'Pq nao comentas? Eh deveras legal', '2017-11-23 12:23:47'),
(15, 58, 16, 4, 'E se botar molho de tomate?', '2018-04-24 22:24:20'),
(17, 50, 16, 5, 'texto', '2018-04-24 22:25:21'),
(18, 50, 16, 3, 'teste', '2018-04-24 22:26:03'),
(19, 50, 16, 6, 'gostei!', '2018-05-11 12:35:03'),
(20, 60, 17, 5, 'ta ruim', '2018-05-12 15:45:23'),
(21, 61, 10, 10, 'melhor bolo de chocolate com macarronada q eu ja comi', '2018-05-14 23:14:02'),
(30, 50, 19, 4, 'teste', '2018-05-15 11:51:59'),
(31, 50, 19, 3, 'kkk', '2018-05-15 11:52:26'),
(32, 50, 19, 1, NULL, '2018-05-15 11:52:52'),
(33, 65, 6, 4, 'eerrrr', '2018-05-15 12:06:25'),
(34, 65, 7, 6, 'ggggg', '2018-05-15 12:10:32'),
(35, 50, 19, 6, 'ttttbswkn', '2018-05-15 20:42:11'),
(36, 66, 6, 10, 'gggg', '2018-05-15 20:59:52'),
(37, 66, 6, 10, NULL, '2018-05-15 21:00:51'),
(38, 50, 12, 3, 'teste', '2018-05-16 23:37:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

DROP TABLE IF EXISTS `receita`;
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
  `ava_num` int(11) DEFAULT NULL,
  `comment_num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`id`, `titulo`, `imagemUrl`, `ingredientes`, `descricao`, `id_user`, `nota`, `tempo`, `tag`, `ava_num`, `comment_num`) VALUES
(2, 'Macarronada', NULL, 'Eeeeee\nCccccc\nLlllllllllll', 'Bacon\n\nCcxx', 50, NULL, '2018-05-11 12:53:30', '#rrrrttt', NULL, NULL),
(3, 'Pimenta', NULL, 'Aaaa', 'Aaaaaaa', 50, NULL, '2018-05-11 12:53:37', 'Rrrr', NULL, NULL),
(4, 'File Mignon assado', NULL, 'Eeeeeee', 'Aaaaaaaaa', 50, NULL, '2018-05-11 12:54:01', 'tttt', NULL, NULL),
(5, 'Banda de Tambaqui Assada', NULL, 'Xxxxxx', 'Hhhhhhhhhh', 50, NULL, '2018-05-11 12:54:08', 'Ooooooo', NULL, NULL),
(6, 'Pão Assado', NULL, 'Pão integral, Alho', 'Passar o alho no pão e assar!', 50, 8, '2018-05-15 21:00:51', 'Vvvvvvvv', 3, 2),
(7, 'Yakissoba', NULL, 'Gggggg', 'Mmmm', 50, 6, '2018-05-15 12:10:32', 'Aaaaa', 1, 1),
(8, 'Frango Grelhado', NULL, 'Tttttttt', 'Lllllll', 52, NULL, '2018-05-11 12:56:17', 'Dddddddd', NULL, NULL),
(9, 'Bife Acebolado', NULL, 'Yyyyyyy', 'Kkkkkkkkkk', 50, NULL, '2018-05-11 12:56:56', '#gggggg', NULL, NULL),
(10, 'Bolo de Chocolate', NULL, 'Ddddd', 'Ttttttttt', 50, 10, '2018-05-14 23:14:02', '#hue', 1, 1),
(11, 'Pudim', NULL, '-Chocolate Quente\r\n-Goiaba\r\n-Refrigerante', 'Mistura tudo e vc vera que a dor de barriga sera monstra!', 27, 3.5, '2018-05-11 12:58:01', '#uia', 2, 1),
(12, 'Toddy', NULL, '- Duas colheres de sopa de Toddy\r\n- 300ml de Leite', 'Com um copo de sua preferencia, adicione o leite e em seguida adicione as duas colheres do achocolatado. Misture bastante ate que a mistura fique homogênea.', 27, 2, '2018-05-16 23:37:48', '#Toddyzao', 1, 2),
(13, 'Tttttt', NULL, 'Nnnnnnnnnn', 'Nnnnnnnnnn', 55, NULL, '2017-11-15 19:28:40', 'Dddddddd', NULL, NULL),
(16, 'Uuu', NULL, 'Hhhhhhhhjh', 'Gffghg', 58, 4.5, '2018-05-11 12:35:03', '#zuei', 4, 4),
(17, 'Teste legal', NULL, 'Arroz', 'Ferva\n', 50, 5, '2018-05-12 15:45:23', 'Geleia', 1, 1),
(18, 'Legal', NULL, 'Todos', 'Aeho', 60, NULL, '2018-05-12 15:46:43', 'Ttt', NULL, NULL),
(19, 'Cake de Pudim', NULL, 'Leite desnatado\n2 ovos\n1 pacote de bolo pronto de sua preferencia\n', 'Reserve meio litro do leite para a cobertura. Prepare o bolo conforme as instruções da embalagem. Adicione o leite no bolo e ponha para assar.', 61, 3.5, '2018-05-15 23:52:14', '#uau', 4, 3),
(20, 'Teste', NULL, 'Hhh', 'Llll', 65, NULL, '2018-05-15 12:12:06', 'Hj', NULL, NULL),
(21, 'Tt', NULL, 'Bb', 'Uuu', 65, NULL, '2018-05-15 12:12:31', 'Ooo', NULL, NULL),
(22, 'Ee', NULL, 'Gg', 'Yy', 65, NULL, '2018-05-15 12:16:44', 'Yy', NULL, NULL),
(24, 'Teste', NULL, 'Teste', 'Teste', 50, NULL, '2018-05-16 23:39:18', 'Teste', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `res_comentario`
--

DROP TABLE IF EXISTS `res_comentario`;
CREATE TABLE `res_comentario` (
  `id` int(11) NOT NULL,
  `id_comenta` int(11) NOT NULL,
  `texto` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `tempo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `res_comentario`
--

INSERT INTO `res_comentario` (`id`, `id_comenta`, `texto`, `id_user`, `tempo`) VALUES
(1, 11, 'Nao sei nao, acho que isso ta errado', 27, '2017-11-23 13:12:07'),
(2, 11, 'Quer apostar que estou certo?', 50, '2017-11-23 13:14:07'),
(3, 11, 'briga! briga! briga!', 55, '2017-11-23 13:15:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
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
(27, 'Augusto', 'arra@3dd.com', '$2y$10$N6UNOgJ2l/VTlF/sCq3IsurUJPmFGUQMBIOPiaasgmp3CQZ5GatfS', NULL, NULL, NULL),
(42, 'Teste', 'lgpa2@icomp.ufam.edu.br', '$2y$10$jzW5Uz3pZFHZRQfBoe4Gt.gJobqKSwveDN4F5A9dE42p/8R/fW6YW', NULL, NULL, NULL),
(45, 'Raissa', 'rara@gmail.com', '$2y$10$S5cBg3rSLlkomq/Y8cPySOMbUiWX5FVfHyN89dmvHhjp/TjZiDT2e', NULL, NULL, NULL),
(46, 'Amanda', 'am@hotmail.com', '$2y$10$y9OnDPuuUO7eywfBndTSjef2F6kAf2XY3aGiFAUQumUQi6FXbqtky', NULL, NULL, NULL),
(47, 'Arra', 'arra@icomp.ufam.edu.br', '$2y$10$/51HSRbJ3Et3dsbAfijEy.YIqyLiWLBRs0Er1Z/jnMX2JFHtDfaLm', NULL, NULL, NULL),
(49, 'Osmar', 'osmarcontato@icomp.ufam.edu.br', '$2y$10$rDHN9GFvXfXSoSufTMRKoul7U2gn2sCWir6cUTK8Q/ENq5G1.JMMW', NULL, NULL, NULL),
(50, 'LG', 'lg@gmail.com', '$2y$10$b2ohlYiVw0tTgFTbCfUEOOehcY./KMFaZsdzVgKek9J6P/vd1OiU2', NULL, NULL, NULL),
(51, 'Bruna', 'bru@gmail.com', '$2y$10$xx5Un/yvnLtb1FLi2vOGxeMSRzJm2oI42WDvNkwKliD2PsyFyGqki', NULL, NULL, NULL),
(52, 'Thiego', 'thi@gmail.com', '$2y$10$Q5jHDwat6eU0Sb8xbRHY6uEAluy3Sh3TubJZKGUkNCHE9LPpJBjk6', NULL, NULL, NULL),
(53, 'Carla', 'carla@gmail.com', '$2y$10$67Ww52n3HXH49bbgExAnBO41wNlwyQ6p5aklxVzYvTyT/wFdGxz0K', NULL, NULL, NULL),
(55, 'Fernando', 'fer@gmail.com', '$2y$10$bdxwbPONKiA4C99ZQ6QAlux2gFmcWTsFlEE98A3mJ4UQa3f9Ab.Mq', NULL, NULL, NULL),
(56, 'Jailson', 'ja@dom.com', '$2y$10$6f/bOP8kf8zCfaHjphn3uOSeVoWmaBdV5diH0gNLpC7CcokbQF3M2', NULL, NULL, NULL),
(57, 'Tiago', 'tga@icomp.ufam.edu.br', '$2y$10$97SwtBALpoyZ7VYJV.tZsejqjXktFdKNHH9vpQk2b1bsuQXc1Da5e', NULL, NULL, NULL),
(58, 'João', 'joao@gmail.com', '$2y$10$lcjYtFffFAvD/YGdHQkVYuw3rt1frpde/bY1p/3K2IgVKGCP8XYay', NULL, NULL, NULL),
(59, 'Gabriela', 'gabi@gmail.com', '$2y$10$NUqnEg.0ovUQq.KiEyzCHuk22mX6iB0t7vQqPV3OewcBq6.nifUNe', NULL, NULL, NULL),
(60, 'Alo', 'a@a.com', '$2y$10$yFkZIDkDYnIrNYbJT6vwQO2Vo0dNUx8p4iPWWn/ZnADVLJDJkJ4O6', NULL, NULL, NULL),
(61, 'Bulma', 'anapaulaholmes@gmail.com', '$2y$10$GgKa5agPA.0sg1fj8jCVWu7IPdchuCmAv0Fp3oVLszXshKTL.D7km', NULL, NULL, NULL),
(65, 'Teste bem legal', 'b@b.com', '$2y$10$UYLRvUZIUTcAjuxF9r8ET.WUW/6SCsAsZxD.2nrrilBZfskPQpAZu', NULL, NULL, NULL),
(66, 'Guga', 'f@f.com', '$2y$10$mGXP73bu8bKl.qNa7DFUeueKrLuHDhU.HCA2hcAheL3gdUJloboRa', NULL, NULL, NULL),
(67, 'Vania', 'va@a.com', '$2y$10$tvXh/o8MuCiFHpMtljxgI.lx6e1FGKLjKVG15O36bX3zfEnp6r3pa', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_relation`
--

DROP TABLE IF EXISTS `user_relation`;
CREATE TABLE `user_relation` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_user_follow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_relation`
--

INSERT INTO `user_relation` (`id`, `id_user`, `id_user_follow`) VALUES
(21, 50, 1),
(2, 50, 27),
(27, 50, 46),
(5, 50, 52),
(9, 50, 55),
(13, 50, 57),
(18, 50, 58),
(28, 50, 59),
(30, 50, 60),
(32, 50, 61),
(41, 50, 66),
(10, 51, 27),
(6, 53, 50),
(8, 55, 50),
(11, 56, 50),
(12, 57, 27),
(15, 57, 50),
(20, 58, 27),
(19, 58, 50),
(16, 58, 52),
(29, 60, 50),
(31, 61, 50),
(37, 65, 27),
(35, 65, 46),
(36, 65, 47),
(33, 65, 50),
(38, 65, 52),
(34, 65, 60),
(40, 66, 1),
(39, 66, 50),
(42, 67, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rec` (`id_receita`),
  ADD KEY `avalia` (`id_user`) USING BTREE;

--
-- Indexes for table `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `res_comentario`
--
ALTER TABLE `res_comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comentario` (`id_comenta`) USING BTREE,
  ADD KEY `user` (`id_user`);

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
-- AUTO_INCREMENT for table `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `receita`
--
ALTER TABLE `receita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `res_comentario`
--
ALTER TABLE `res_comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `user_relation`
--
ALTER TABLE `user_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `fk_receitaId2` FOREIGN KEY (`id_receita`) REFERENCES `receita` (`id`),
  ADD CONSTRAINT `fk_userId2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `res_comentario`
--
ALTER TABLE `res_comentario`
  ADD CONSTRAINT `fk_comentario` FOREIGN KEY (`id_comenta`) REFERENCES `avaliacao` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
