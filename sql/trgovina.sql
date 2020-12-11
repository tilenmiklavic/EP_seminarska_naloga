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
-- Table `trgovina`.`artikli`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`artikli` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `avtor` VARCHAR(45) NOT NULL,
  `zalozba` VARCHAR(45) NOT NULL,
  `cena` INT NOT NULL,
  `slike` LONGBLOB NULL DEFAULT NULL,
  `naslov_slike` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trgovina`.`uporabniki`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`uporabniki` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `priimek` VARCHAR(45) NOT NULL,
  `vloga` VARCHAR(45) NOT NULL,
  `stanje` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trgovina`.`narocila`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`narocila` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uporabniki_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_narocila_uporabniki1_idx` (`uporabniki_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trgovina`.`podrobnosti_narocila`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`podrobnosti_narocila` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `artikli_id` INT NOT NULL,
  `narocila_id` INT NOT NULL,
  `kolicina` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_podrobnosti_narocila_artikli_idx` (`artikli_id` ASC) VISIBLE,
  INDEX `fk_podrobnosti_narocila_narocila1_idx` (`narocila_id` ASC) VISIBLE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO artikli (ime, avtor, zalozba, cena, slike, naslov_slike) VALUES ("Harry Potter", "J.K. Rowling", "Mladinska Knjiga", 50, NULL, "https://images-na.ssl-images-amazon.com/images/I/81iqZ2HHD-L.jpg");
INSERT INTO artikli (ime, avtor, zalozba, cena, slike, naslov_slike) VALUES ("Gospodar Prstanov", "J.R.R. Tolkien", "Mladinska Knjiga", 50, NULL, "https://images-na.ssl-images-amazon.com/images/I/8134AkhQJgL.jpg");
INSERT INTO artikli (ime, avtor, zalozba, cena, slike, naslov_slike) VALUES ("Stoparski vodic po galaksiji", "Douglas Adams", "Mladinska Knjiga", 50, NULL, "https://images.penguinrandomhouse.com/cover/9781400052929");