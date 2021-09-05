-- MySQL Script generated by MySQL Workbench
-- Sat Sep  4 17:52:28 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema rpg
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema rpg
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `rpg` DEFAULT CHARACTER SET utf8 ;
USE `rpg` ;

-- -----------------------------------------------------
-- Table `rpg`.`player`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rpg`.`player` (
  `idplayer` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NULL,
  `senha` VARCHAR(45) NULL,
  PRIMARY KEY (`idplayer`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rpg`.`personagens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rpg`.`personagens` (
  `idpersonagens` INT NOT NULL AUTO_INCREMENT,
  `nick` VARCHAR(45) NULL,
  `classe` INT NULL,
  `hp` INT NULL,
  `atk` INT NULL,
  `def` INT NULL,
  `spd` INT NULL,
  `xp` INT NULL,
  `xpmax` INT NULL,
  `lv` INT NULL,
  `idplayer` INT NOT NULL,
  PRIMARY KEY (`idpersonagens`),
  INDEX `fk_personagens_player_idx` (`idplayer` ASC),
  CONSTRAINT `fk_personagens_player`
    FOREIGN KEY (`idplayer`)
    REFERENCES `rpg`.`player` (`idplayer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rpg`.`monstros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rpg`.`monstros` (
  `idpersonagens` INT NOT NULL AUTO_INCREMENT,
  `nick` VARCHAR(45) NULL,
  `classe` INT NULL,
  `hp` INT NULL,
  `atk` INT NULL,
  `def` INT NULL,
  `spd` INT NULL,
  `xp` INT NULL,
  `lv` INT NULL,
  `raridade` INT NULL,
  `drop` INT NULL,
  PRIMARY KEY (`idpersonagens`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;