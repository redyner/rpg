-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08-Set-2021 às 23:46
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atributos`
--

INSERT INTO `atributos` (`id_atributo`, `sta`, `str`, `int`, `dex`, `id_classe`, `id_inimigo`, `id_item`) VALUES
(1, 10, 10, 10, 10, 1, NULL, NULL),
(2, 10, 10, 10, 10, 2, NULL, NULL),
(3, 10, 10, 10, 10, 3, NULL, NULL),
(4, 20, 5, 5, 5, NULL, 1, NULL),
(5, 100, 10, 10, 10, NULL, 2, NULL),
(6, 150, 15, 15, 15, NULL, 3, NULL),
(7, 300, 30, 30, 30, NULL, 4, NULL),
(8, 1, 1, 1, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id_classe` int(11) NOT NULL AUTO_INCREMENT,
  `nm_classe` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_classe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `classes`
--

INSERT INTO `classes` (`id_classe`, `nm_classe`) VALUES
(1, 'warrior'),
(2, 'archer'),
(3, 'wizard');

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
  PRIMARY KEY (`id_inimigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `inimigos`
--

INSERT INTO `inimigos` (`id_inimigo`, `nm_inimigo`, `classe`, `xp`, `lv`, `raridade`, `drop`) VALUES
(1, 'Javali', NULL, 100, NULL, NULL, NULL),
(2, 'Urso', NULL, 200, NULL, NULL, NULL),
(3, 'Lobo', NULL, 400, NULL, NULL, NULL),
(4, 'Drag', NULL, 800, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventarios`
--

DROP TABLE IF EXISTS `inventarios`;
CREATE TABLE IF NOT EXISTS `inventarios` (
  `id_inventario` int(11) NOT NULL,
  `slot` varchar(45) DEFAULT NULL,
  `refino` int(11) DEFAULT NULL,
  `id_personagem` int(11) NOT NULL,
  `id_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_inventario`),
  KEY `fk_iventarios_personagens1_idx` (`id_personagem`),
  KEY `fk_iventarios_Itens1_idx` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `inventarios`
--

INSERT INTO `inventarios` (`id_inventario`, `slot`, `refino`, `id_personagem`, `id_item`) VALUES
(1, '1', 0, 1, 1);

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
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `itens`
--

INSERT INTO `itens` (`id_item`, `nm_item`, `lv`, `valor`) VALUES
(1, 'espada', '1', '1');

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
  `lv` int(11) DEFAULT NULL,
  `id_classe` int(11) NOT NULL,
  `id_player` int(11) NOT NULL,
  PRIMARY KEY (`id_personagem`),
  KEY `fk_personagens_classes1_idx` (`id_classe`),
  KEY `fk_personagens_player1_idx` (`id_player`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `personagens`
--

INSERT INTO `personagens` (`id_personagem`, `nick`, `xp`, `xp_max`, `lv`, `id_classe`, `id_player`) VALUES
(1, 'Apolo', 0, 100, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id_player` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_player`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `player`
--

INSERT INTO `player` (`id_player`, `login`, `senha`, `gold`) VALUES
(1, 'rediner', 'df819af6bdcb198c22040c26d9f3bd98', NULL);

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
