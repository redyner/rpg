-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 18-Out-2021 às 19:43
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rpg`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atributos`
--

DROP TABLE IF EXISTS `atributos`;
CREATE TABLE IF NOT EXISTS `atributos` (
  `id_atributo` int(11) NOT NULL AUTO_INCREMENT,
  `sta` int(11) DEFAULT NULL,
  `str` int(11) DEFAULT NULL,
  `int` int(11) DEFAULT NULL,
  `dex` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_inimigo` int(11) DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_atributo`),
  KEY `fk_atributos_classes1_idx` (`id_classe`),
  KEY `fk_atributos_inimigos1_idx` (`id_inimigo`),
  KEY `fk_atributos_Itens1_idx` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atributos`
--

INSERT INTO `atributos` (`id_atributo`, `sta`, `str`, `int`, `dex`, `id_classe`, `id_inimigo`, `id_item`) VALUES
(1, 3, 4, 1, 2, 1, NULL, NULL),
(2, 2, 2, 2, 4, 2, NULL, NULL),
(3, 2, 1, 4, 3, 3, NULL, NULL),
(4, 2, 5, 5, 5, NULL, 1, NULL),
(5, 10, 10, 10, 10, NULL, 2, NULL),
(6, 15, 15, 15, 15, NULL, 3, NULL),
(7, 30, 30, 30, 30, NULL, 4, NULL),
(8, 3, 4, 1, 2, NULL, NULL, 1),
(9, 2, 5, 5, 5, NULL, 5, NULL),
(10, 15, 15, 15, 15, NULL, 6, NULL),
(11, 250, 150, 150, 150, NULL, 7, NULL),
(12, 125, 75, 75, 75, NULL, 8, NULL),
(13, 30, 30, 30, 30, NULL, 9, NULL),
(14, 30, 30, 30, 30, NULL, 10, NULL),
(15, 30, 30, 30, 30, NULL, 11, NULL),
(16, 30, 30, 30, 30, NULL, 12, NULL),
(17, 5, 10, 10, 10, NULL, 13, NULL),
(18, 75, 50, 50, 50, NULL, 14, NULL),
(19, 2, 2, 2, 4, NULL, NULL, 2),
(20, 2, 1, 4, 3, NULL, NULL, 3),
(21, 6, 8, 2, 4, NULL, NULL, 4),
(22, 4, 4, 4, 8, NULL, NULL, 5),
(23, 4, 2, 8, 6, NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id_classe` int(11) NOT NULL AUTO_INCREMENT,
  `nm_classe` varchar(45) DEFAULT NULL,
  `imagem` varchar(45) NOT NULL,
  PRIMARY KEY (`id_classe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `classes`
--

INSERT INTO `classes` (`id_classe`, `nm_classe`, `imagem`) VALUES
(1, 'warrior', 'warrior.jpg'),
(2, 'archer', 'archer.jpg'),
(3, 'wizard', 'wizard.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int(11) NOT NULL AUTO_INCREMENT,
  `id_player` int(11) NOT NULL,
  PRIMARY KEY (`id_equipe`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `equipe`
--

INSERT INTO `equipe` (`id_equipe`, `id_player`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `inimigos`
--

DROP TABLE IF EXISTS `inimigos`;
CREATE TABLE IF NOT EXISTS `inimigos` (
  `id_inimigo` int(11) NOT NULL AUTO_INCREMENT,
  `nm_inimigo` varchar(45) DEFAULT NULL,
  `classe` int(11) DEFAULT NULL,
  `xp` int(11) DEFAULT NULL,
  `lv` int(11) DEFAULT NULL,
  `raridade` int(11) DEFAULT NULL,
  `drop` int(11) DEFAULT NULL,
  `imagem` varchar(45) NOT NULL,
  PRIMARY KEY (`id_inimigo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `inimigos`
--

INSERT INTO `inimigos` (`id_inimigo`, `nm_inimigo`, `classe`, `xp`, `lv`, `raridade`, `drop`, `imagem`) VALUES
(1, 'Javali', NULL, 100, 1, NULL, NULL, 'jav.jpg'),
(2, 'Urso', NULL, 250, 3, NULL, NULL, 'urso.jpg'),
(3, 'Lobo', NULL, 250, 3, NULL, NULL, 'lobo.jpg'),
(4, 'Drag', NULL, 750, 8, NULL, NULL, 'red_drag.jpg'),
(5, 'Goblin', NULL, 100, 1, NULL, NULL, 'goblin.jpg'),
(6, 'Orc', NULL, 500, 5, NULL, NULL, 'orc.jpg'),
(7, 'Boss', NULL, 5000, 50, NULL, NULL, 'boss.jpg'),
(8, 'Blue_Drag', NULL, 3000, 30, NULL, NULL, 'blue_drag.jpg'),
(9, 'Cerberus', NULL, 750, 8, NULL, NULL, 'cerberus.jpg'),
(10, 'Demon', NULL, 750, 8, NULL, NULL, 'demon.jpg'),
(11, 'Ogro', NULL, 750, 8, NULL, NULL, 'ogro.jpg'),
(12, 'Ice_Warrior', NULL, 750, 8, NULL, NULL, 'ice_warrior.jpg'),
(13, 'Snake', NULL, 150, 2, NULL, NULL, 'snake.jpg'),
(14, 'Ice_King', NULL, 1500, 15, NULL, NULL, 'ice_king.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventarios`
--

DROP TABLE IF EXISTS `inventarios`;
CREATE TABLE IF NOT EXISTS `inventarios` (
  `id_inventario` int(11) NOT NULL AUTO_INCREMENT,
  `slot` varchar(45) DEFAULT NULL,
  `refino` int(11) DEFAULT NULL,
  `equipado` char(1) DEFAULT 'N',
  `id_personagem` int(11) NOT NULL,
  `id_item` int(11) DEFAULT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_inventario`),
  KEY `fk_iventarios_personagens1_idx` (`id_personagem`),
  KEY `fk_iventarios_Itens1_idx` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `inventarios`
--

INSERT INTO `inventarios` (`id_inventario`, `slot`, `refino`, `equipado`, `id_personagem`, `id_item`, `data`) VALUES
(1, '1', 6, 'S', 1, 5, '2021-10-18 19:39:45'),
(2, '1', 0, 'N', 2, 3, '2021-10-18 19:39:45'),
(3, '1', 0, 'N', 3, 3, '2021-10-18 19:39:45'),
(4, '2', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(5, '3', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(6, '4', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(7, '5', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(8, '6', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(9, '7', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(10, '8', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(11, '9', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(12, '10', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(13, '11', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(14, '12', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(15, '13', 0, 'N', 1, NULL, '2021-10-18 19:39:45'),
(16, '14', NULL, 'N', 1, NULL, '2021-10-18 19:39:45'),
(17, '15', NULL, 'N', 1, NULL, '2021-10-18 19:39:45'),
(18, '4', 1000, 'N', 2, 1, '2021-10-18 19:39:45'),
(19, '4', 3, 'N', 2, 3, '2021-10-18 19:39:45'),
(20, '4', 130, 'N', 2, 4, '2021-10-18 19:39:45'),
(21, '5', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(22, '6', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(23, '7', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(24, '8', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(25, '9', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(26, '10', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(27, '11', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(28, '12', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(29, '13', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(30, '14', 0, 'N', 2, NULL, '2021-10-18 19:39:45'),
(31, '15', 0, 'N', 2, NULL, '2021-10-18 19:39:45');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens`
--

DROP TABLE IF EXISTS `itens`;
CREATE TABLE IF NOT EXISTS `itens` (
  `id_item` int(11) NOT NULL,
  `nm_item` varchar(45) DEFAULT NULL,
  `lv` varchar(45) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `tipo` int(11) DEFAULT '1',
  `id_classe` int(11) DEFAULT NULL,
  `imagem` varchar(45) NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_classe_idx` (`id_classe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `itens`
--

INSERT INTO `itens` (`id_item`, `nm_item`, `lv`, `valor`, `tipo`, `id_classe`, `imagem`) VALUES
(1, 'espada1', '1', '100', 1, 1, 'espada.png'),
(2, 'arco1', '1', '100', 1, 2, 'arco.png'),
(3, 'cajado1', '1', '100', 1, 3, 'cajado.jpg'),
(4, 'espada2', '10', '1000', 1, 1, 'espada2.png'),
(5, 'arco2', '10', '1000', 1, 2, 'arco2.png'),
(6, 'cajado2', '10', '1000', 1, 3, 'cajado2.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personagens`
--

DROP TABLE IF EXISTS `personagens`;
CREATE TABLE IF NOT EXISTS `personagens` (
  `id_personagem` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(45) DEFAULT NULL,
  `xp` int(11) DEFAULT '0',
  `xp_max` int(11) DEFAULT '100',
  `lv` int(11) DEFAULT '1',
  `gold` int(11) DEFAULT '0',
  `id_classe` int(11) NOT NULL,
  `id_player` int(11) NOT NULL,
  PRIMARY KEY (`id_personagem`),
  KEY `fk_personagens_classes1_idx` (`id_classe`),
  KEY `fk_personagens_player1_idx` (`id_player`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `personagens`
--

INSERT INTO `personagens` (`id_personagem`, `nick`, `xp`, `xp_max`, `lv`, `gold`, `id_classe`, `id_player`) VALUES
(1, 'Apolo', 10300, 10550, 20, 9999999, 2, 1),
(2, 'Samuel', 7100, 53150, 1001, 9999999, 1, 2),
(3, 'Artemis', 0, 100, 1, 9999999, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id_player` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_player`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `player`
--

INSERT INTO `player` (`id_player`, `login`, `senha`, `email`, `data`) VALUES
(1, 'rediner', 'df819af6bdcb198c22040c26d9f3bd98', '', '2021-10-18 19:42:02'),
(2, 'Samuel', '81dc9bdb52d04dc20036dbd8313ed055', '', '2021-10-18 19:42:02'),
(3, 'helen', 'df819af6bdcb198c22040c26d9f3bd98', '', '2021-10-18 19:42:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `raridades`
--

DROP TABLE IF EXISTS `raridades`;
CREATE TABLE IF NOT EXISTS `raridades` (
  `id_raridade` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `drop` int(11) DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  `id_inimigo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_raridade`),
  KEY `fk_raridades_Itens1_idx` (`id_item`),
  KEY `fk_raridades_inimigos1_idx` (`id_inimigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id_skill` int(11) NOT NULL,
  `nm_skill` varchar(45) DEFAULT NULL,
  `lv` int(11) DEFAULT NULL,
  `mutiplicador` int(11) DEFAULT NULL,
  `id_classe` int(11) NOT NULL,
  `imagem` varchar(45) NOT NULL,
  PRIMARY KEY (`id_skill`),
  KEY `fk_skills_classes1_idx` (`id_classe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atributos`
--
ALTER TABLE `atributos`
  ADD CONSTRAINT `fk_atributos_Itens1` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_atributos_classes1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_atributos_inimigos1` FOREIGN KEY (`id_inimigo`) REFERENCES `inimigos` (`id_inimigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `fk_iventarios_Itens1` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_iventarios_personagens1` FOREIGN KEY (`id_personagem`) REFERENCES `personagens` (`id_personagem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `personagens`
--
ALTER TABLE `personagens`
  ADD CONSTRAINT `id_classe` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_player` FOREIGN KEY (`id_player`) REFERENCES `player` (`id_player`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `raridades`
--
ALTER TABLE `raridades`
  ADD CONSTRAINT `fk_raridades_Itens1` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_raridades_inimigos1` FOREIGN KEY (`id_inimigo`) REFERENCES `inimigos` (`id_inimigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `fk_skills_classes1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
