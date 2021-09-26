-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-51231-db.mysql-51231:19464
-- Tempo de geração: 26/09/2021 às 15:16
-- Versão do servidor: 8.0.26
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Estrutura para tabela `atributos`
--

CREATE TABLE `atributos` (
  `id_atributo` int NOT NULL,
  `sta` int DEFAULT NULL,
  `str` int DEFAULT NULL,
  `int` int DEFAULT NULL,
  `dex` int DEFAULT NULL,
  `id_classe` int DEFAULT NULL,
  `id_inimigo` int DEFAULT NULL,
  `id_item` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `atributos`
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
(21, 4, 2, 8, 6, NULL, NULL, 4),
(22, 4, 4, 4, 8, NULL, NULL, 5),
(23, 4, 5, 8, 6, NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `classes`
--

CREATE TABLE `classes` (
  `id_classe` int NOT NULL,
  `nm_classe` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `classes`
--

INSERT INTO `classes` (`id_classe`, `nm_classe`) VALUES
(1, 'warrior'),
(2, 'archer'),
(3, 'wizard');

-- --------------------------------------------------------

--
-- Estrutura para tabela `inimigos`
--

CREATE TABLE `inimigos` (
  `id_inimigo` int NOT NULL,
  `nm_inimigo` varchar(45) DEFAULT NULL,
  `classe` int DEFAULT NULL,
  `xp` int DEFAULT NULL,
  `lv` int DEFAULT NULL,
  `raridade` int DEFAULT NULL,
  `drop` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `inimigos`
--

INSERT INTO `inimigos` (`id_inimigo`, `nm_inimigo`, `classe`, `xp`, `lv`, `raridade`, `drop`) VALUES
(1, 'Javali', NULL, 100, 1, NULL, NULL),
(2, 'Urso', NULL, 250, 3, NULL, NULL),
(3, 'Lobo', NULL, 250, 3, NULL, NULL),
(4, 'Drag', NULL, 750, 8, NULL, NULL),
(5, 'Goblin', NULL, 100, 1, NULL, NULL),
(6, 'Orc', NULL, 500, 5, NULL, NULL),
(7, 'Boss', NULL, 5000, 50, NULL, NULL),
(8, 'Blue_Drag', NULL, 3000, 30, NULL, NULL),
(9, 'Cerberus', NULL, 750, 8, NULL, NULL),
(10, 'Demon', NULL, 750, 8, NULL, NULL),
(11, 'Ogro', NULL, 750, 8, NULL, NULL),
(12, 'Ice_Warrior', NULL, 750, 8, NULL, NULL),
(13, 'Snake', NULL, 150, 2, NULL, NULL),
(14, 'Ice_King', NULL, 1500, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `inventarios`
--

CREATE TABLE `inventarios` (
  `id_inventario` int NOT NULL,
  `slot` varchar(45) DEFAULT NULL,
  `refino` int DEFAULT NULL,
  `id_personagem` int NOT NULL,
  `id_item` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `inventarios`
--

INSERT INTO `inventarios` (`id_inventario`, `slot`, `refino`, `id_personagem`, `id_item`) VALUES
(1, '1', 0, 1, 1),
(2, '1', 0, 2, 2),
(3, '1', 0, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id_item` int NOT NULL,
  `nm_item` varchar(45) DEFAULT NULL,
  `lv` varchar(45) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `tipo` int DEFAULT NULL,
  `id_classe` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id_item`, `nm_item`, `lv`, `valor`, `tipo`, `id_classe`) VALUES
(1, 'espada1', '1', '100', 0, 1),
(2, 'arco1', '1', '100', 0, 2),
(3, 'cajado1', '1', '100', 0, 3),
(4, 'espada2', '10', '1000', 0, 1),
(5, 'arco2', '10', '1000', 0, 2),
(6, 'cajado2', '10', '1000', 0, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `personagens`
--

CREATE TABLE `personagens` (
  `id_personagem` int NOT NULL,
  `nick` varchar(45) DEFAULT NULL,
  `xp` int DEFAULT '0',
  `xp_max` int DEFAULT '100',
  `lv` int DEFAULT '1',
  `gold` int DEFAULT '0',
  `id_classe` int NOT NULL,
  `id_player` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `personagens`
--

INSERT INTO `personagens` (`id_personagem`, `nick`, `xp`, `xp_max`, `lv`, `gold`, `id_classe`, `id_player`) VALUES
(1, 'Apolo', 1000, 1850, 8, 760, 2, 1),
(2, 'Samuel', 3600, 6050, 15, 3240, 1, 2),
(3, 'Artemis', 0, 100, 1, 0, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `player`
--

CREATE TABLE `player` (
  `id_player` int NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `player`
--

INSERT INTO `player` (`id_player`, `login`, `senha`) VALUES
(1, 'rediner', 'df819af6bdcb198c22040c26d9f3bd98'),
(2, 'Samuel', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'helen', 'df819af6bdcb198c22040c26d9f3bd98');

-- --------------------------------------------------------

--
-- Estrutura para tabela `raridades`
--

CREATE TABLE `raridades` (
  `id_raridade` int NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `drop` int DEFAULT NULL,
  `id_item` int DEFAULT NULL,
  `id_inimigo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `skills`
--

CREATE TABLE `skills` (
  `id_skill` int NOT NULL,
  `nm_skill` varchar(45) DEFAULT NULL,
  `lv` int DEFAULT NULL,
  `mutiplicador` int DEFAULT NULL,
  `id_classe` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `atributos`
--
ALTER TABLE `atributos`
  ADD PRIMARY KEY (`id_atributo`),
  ADD KEY `id_classe` (`id_classe`) USING BTREE,
  ADD KEY `id_item` (`id_item`) USING BTREE,
  ADD KEY `id_inimigo` (`id_inimigo`) USING BTREE;

--
-- Índices de tabela `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id_classe`);

--
-- Índices de tabela `inimigos`
--
ALTER TABLE `inimigos`
  ADD PRIMARY KEY (`id_inimigo`);

--
-- Índices de tabela `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_personagem` (`id_personagem`) USING BTREE,
  ADD KEY `id_item` (`id_item`) USING BTREE;

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_classe` (`id_classe`) USING BTREE;

--
-- Índices de tabela `personagens`
--
ALTER TABLE `personagens`
  ADD PRIMARY KEY (`id_personagem`),
  ADD KEY `id_classe` (`id_classe`) USING BTREE,
  ADD KEY `id_player` (`id_player`) USING BTREE;

--
-- Índices de tabela `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id_player`);

--
-- Índices de tabela `raridades`
--
ALTER TABLE `raridades`
  ADD PRIMARY KEY (`id_raridade`),
  ADD KEY `id_item` (`id_item`) USING BTREE,
  ADD KEY `id_inimigo` (`id_inimigo`) USING BTREE;

--
-- Índices de tabela `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id_skill`),
  ADD KEY `id_classe` (`id_classe`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `atributos`
--
ALTER TABLE `atributos`
  MODIFY `id_atributo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `classes`
--
ALTER TABLE `classes`
  MODIFY `id_classe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `inimigos`
--
ALTER TABLE `inimigos`
  MODIFY `id_inimigo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `personagens`
--
ALTER TABLE `personagens`
  MODIFY `id_personagem` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `player`
--
ALTER TABLE `player`
  MODIFY `id_player` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `atributos`
--
ALTER TABLE `atributos`
  ADD CONSTRAINT `fk_atributos_classes1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id_classe`),
  ADD CONSTRAINT `fk_atributos_inimigos1` FOREIGN KEY (`id_inimigo`) REFERENCES `inimigos` (`id_inimigo`),
  ADD CONSTRAINT `fk_atributos_Itens1` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`);

--
-- Restrições para tabelas `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `fk_iventarios_Itens1` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`),
  ADD CONSTRAINT `fk_iventarios_personagens1` FOREIGN KEY (`id_personagem`) REFERENCES `personagens` (`id_personagem`);

--
-- Restrições para tabelas `personagens`
--
ALTER TABLE `personagens`
  ADD CONSTRAINT `id_classe` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id_classe`),
  ADD CONSTRAINT `id_player` FOREIGN KEY (`id_player`) REFERENCES `player` (`id_player`);

--
-- Restrições para tabelas `raridades`
--
ALTER TABLE `raridades`
  ADD CONSTRAINT `fk_raridades_inimigos1` FOREIGN KEY (`id_inimigo`) REFERENCES `inimigos` (`id_inimigo`),
  ADD CONSTRAINT `fk_raridades_Itens1` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`);

--
-- Restrições para tabelas `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `fk_skills_classes1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id_classe`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
