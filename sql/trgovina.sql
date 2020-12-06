-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema trgovina
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema trgovina
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `trgovina` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci ;
USE `trgovina` ;

-- -----------------------------------------------------
-- Table `trgovina`.`uporabniki`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`uporabniki` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tip` VARCHAR(45) NOT NULL,
  `certifikat` VARCHAR(45) NULL DEFAULT NULL,
  `uporabnisko_ime` VARCHAR(45) NOT NULL,
  `geslo` VARCHAR(45) NOT NULL,
  `ime` VARCHAR(45) NOT NULL,
  `priimek` VARCHAR(45) NULL DEFAULT NULL,
  `status` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `certifikat_UNIQUE` (`certifikat` ASC) VISIBLE,
  UNIQUE INDEX `uporabnisko_ime_UNIQUE` (`uporabnisko_ime` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trgovina`.`narocila`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`narocila` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uporabniki_id` INT NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `uporabniki_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_narocila_uporabniki_idx` (`uporabniki_id` ASC) VISIBLE,
  CONSTRAINT `fk_narocila_uporabniki`
    FOREIGN KEY (`uporabniki_id`)
    REFERENCES `trgovina`.`uporabniki` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trgovina`.`podrobnosti_narocila`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`podrobnosti_narocila` (
  `id_podrobnosti_narocila` INT NOT NULL,
  `id_artikla` INT NOT NULL,
  `kolicina` INT NULL DEFAULT NULL,
  `narocila_id` INT NOT NULL,
  PRIMARY KEY (`id_podrobnosti_narocila`, `narocila_id`),
  INDEX `fk_podrobnosti_narocila_narocila1_idx` (`narocila_id` ASC) VISIBLE,
  CONSTRAINT `fk_podrobnosti_narocila_narocila1`
    FOREIGN KEY (`narocila_id`)
    REFERENCES `trgovina`.`narocila` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trgovina`.`artikli`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`artikli` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `opis` VARCHAR(45) NULL DEFAULT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `slike` LONGBLOB NULL DEFAULT NULL,
  `podrobnosti_narocila_id` INT NOT NULL,
  PRIMARY KEY (`id`, `podrobnosti_narocila_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_artikli_podrobnosti_narocila1_idx` (`podrobnosti_narocila_id` ASC) VISIBLE,
  CONSTRAINT `fk_artikli_podrobnosti_narocila1`
    FOREIGN KEY (`podrobnosti_narocila_id`)
    REFERENCES `trgovina`.`podrobnosti_narocila` (`id_podrobnosti_narocila`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `uporabniki` (id, tip, certifikat, uporabnisko_ime, geslo, ime, priimek, status) VALUES (1, "admin", null, "admin", "admin", "Janez", "Novak", "aktiviran");
