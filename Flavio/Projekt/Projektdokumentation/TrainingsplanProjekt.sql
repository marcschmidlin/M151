-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Trainingsplan
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Trainingsplan
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Trainingsplan` DEFAULT CHARACTER SET utf8 ;
USE `Trainingsplan` ;

-- -----------------------------------------------------
-- Table `Trainingsplan`.`Benutzer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Trainingsplan`.`Benutzer` (
  `idBenutzer` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NULL,
  `Vorname` VARCHAR(45) NULL,
  `Alter` INT NULL,
  `email` VARCHAR(255) NULL,
  `Passwort` VARCHAR(255) NULL,
  `Gewicht` INT NULL,
  PRIMARY KEY (`idBenutzer`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Trainingsplan`.`Trainingplan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Trainingsplan`.`Trainingplan` (
  `idTrainingplan` INT NOT NULL AUTO_INCREMENT,
  `Benutzer_idBenutzer` INT NOT NULL,
  `Satzanzahl` INT NULL,
  `Gewicht` INT NULL,
  PRIMARY KEY (`idTrainingplan`),
  INDEX `fk_Trainingplan_Benutzer_idx` (`Benutzer_idBenutzer` ASC) ,
  CONSTRAINT `fk_Trainingplan_Benutzer`
    FOREIGN KEY (`Benutzer_idBenutzer`)
    REFERENCES `Trainingsplan`.`Benutzer` (`idBenutzer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Trainingsplan`.`Uebungen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Trainingsplan`.`Uebungen` (
  `idUebungen` INT NOT NULL,
  `Uebungname` VARCHAR(100) NULL,
  `Zielmuskel` VARCHAR(45) NULL,
  `Beschreibung` MEDIUMTEXT NULL,
  `UebungGif` VARCHAR(255) NULL,
  PRIMARY KEY (`idUebungen`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Trainingsplan`.`Trainingsplan_hat_Uebungen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Trainingsplan`.`Trainingsplan_hat_Uebungen` (
  `Uebungen_idUebungen` INT NOT NULL,
  `Trainingplan_idTrainingplan` INT NOT NULL,
  PRIMARY KEY (`Uebungen_idUebungen`, `Trainingplan_idTrainingplan`),
  INDEX `fk_Uebungen_has_Trainingplan_Trainingplan1_idx` (`Trainingplan_idTrainingplan` ASC) ,
  INDEX `fk_Uebungen_has_Trainingplan_Uebungen1_idx` (`Uebungen_idUebungen` ASC) ,
  CONSTRAINT `fk_Uebungen_has_Trainingplan_Uebungen1`
    FOREIGN KEY (`Uebungen_idUebungen`)
    REFERENCES `Trainingsplan`.`Uebungen` (`idUebungen`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Uebungen_has_Trainingplan_Trainingplan1`
    FOREIGN KEY (`Trainingplan_idTrainingplan`)
    REFERENCES `Trainingsplan`.`Trainingplan` (`idTrainingplan`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Trainingsplan`.`Gewicht`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Trainingsplan`.`Gewicht` (
  `idGewicht` INT NOT NULL AUTO_INCREMENT,
  `Datum` DATE NULL,
  `Gewicht` INT NULL,
  `Benutzer_idBenutzer` INT NOT NULL,
  PRIMARY KEY (`idGewicht`),
  INDEX `fk_Gewicht_Benutzer1_idx` (`Benutzer_idBenutzer` ASC),
  CONSTRAINT `fk_Gewicht_Benutzer1`
    FOREIGN KEY (`Benutzer_idBenutzer`)
    REFERENCES `Trainingsplan`.`Benutzer` (`idBenutzer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
