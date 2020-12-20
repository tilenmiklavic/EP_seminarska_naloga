-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema trgovina
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema trgovina
-- -----------------------------------------------------
DROP SCHEMA `trgovina`;
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
  `naslov_slike` VARCHAR(100) NULL DEFAULT NULL,
  `active` TINYINT NULL DEFAULT '1',
  `ocena` INTEGER NULL DEFAULT '5',
  `stevilo_ocen` INTEGER NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_slovenian_ci;


-- -----------------------------------------------------
-- Table `trgovina`.`uporabniki`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`uporabniki` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `priimek` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `geslo` VARCHAR(100) NOT NULL,
  `tip` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `ulica` VARCHAR(45) NULL DEFAULT NULL,
  `hisna_stevilka` INT NULL DEFAULT NULL,
  `posta` VARCHAR(45) NULL DEFAULT NULL,
  `postna_stevilka` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 36
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_slovenian_ci;


-- -----------------------------------------------------
-- Table `trgovina`.`narocila`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`narocila` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uporabniki_id` INT NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_narocila_uporabniki_idx` (`uporabniki_id` ASC) VISIBLE,
  CONSTRAINT `fk_narocila_uporabniki`
    FOREIGN KEY (`uporabniki_id`)
    REFERENCES `trgovina`.`uporabniki` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_slovenian_ci;


-- -----------------------------------------------------
-- Table `trgovina`.`podrobnosti_narocila`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trgovina`.`podrobnosti_narocila` (
  `id_podrobnosti_narocila` INT NOT NULL AUTO_INCREMENT,
  `id_artikla` INT NOT NULL,
  `kolicina` INT NULL DEFAULT NULL,
  `narocila_id` INT NOT NULL,
  PRIMARY KEY (`id_podrobnosti_narocila`, `narocila_id`),
  INDEX `fk_podrobnosti_narocila_narocila1_idx` (`narocila_id` ASC) VISIBLE,
  CONSTRAINT `fk_podrobnosti_narocila_narocila1`
    FOREIGN KEY (`narocila_id`)
    REFERENCES `trgovina`.`narocila` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_slovenian_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (1,'Lojze','Novak','admin@ep.si','$2y$10$VDxBuhuXrw8G/O9iioKpVOJQ.fFrPOKuIeN9y4uBvjvESb2xOn2Ja','admin','active',NULL,NULL,NULL,NULL);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (2,'Ana','Kovac','ana@ep.si','$2y$10$pzN6HMq3dcGPeqd.4TrNpeXW21om8LwWetyyOGZDDCOvo0Df6r2Yu','prodajalec','active',NULL,NULL,NULL,NULL);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (3,'Bojan','Kovacic','bojan@gmail.com','$2y$10$VDxBuhuXrw8G/O9iioKpVOJQ.fFrPOKuIeN9y4uBvjvESb2xOn2Ja','prodajalec','inactive',NULL,NULL,NULL,NULL);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (4,'Matic','Nogometas','matic@gmail.com','$2y$10$VDxBuhuXrw8G/O9iioKpVOJQ.fFrPOKuIeN9y4uBvjvESb2xOn2Ja','stranka','active','Svetosavksa ulika',2,'Ljubljana',1000);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (5,'Tjasa','Tuta','tjasa@gmail.com','$2y$10$VDxBuhuXrw8G/O9iioKpVOJQ.fFrPOKuIeN9y4uBvjvESb2xOn2Ja','stranka','active','Vilharjeva cesta',105,'Ljubljana',1000);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (6,'Izidor','Leban','izidor@gmail.com','$2y$10$VDxBuhuXrw8G/O9iioKpVOJQ.fFrPOKuIeN9y4uBvjvESb2xOn2Ja','stranka','active','Smoletova ulica',83,'Ljubljana',1000);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (7,'Lenart','Miklavci','lenart@gmail.com','$2y$10$VDxBuhuXrw8G/O9iioKpVOJQ.fFrPOKuIeN9y4uBvjvESb2xOn2Ja','stranka','active','Kettejeva ulica',15,'Maribor',2000);
INSERT INTO `uporabniki` (`id`,`ime`,`priimek`,`email`,`geslo`,`tip`,`status`,`ulica`,`hisna_stevilka`,`posta`,`postna_stevilka`) VALUES (8,'Matija','Miklavic','matija@gmail.com','$2y$10$ovkBjg9R6oVfquQDLMELfeXoo2FI6qt2dBxixt.542snG1tQi27.G','stranka','active','Mladinska ulica',66,'Kranj',4000);

INSERT INTO `artikli` (`id`,`ime`,`avtor`,`zalozba`,`cena`,`slike`,`naslov_slike`,`active`, `ocena`, `stevilo_ocen`) VALUES (7,'Harry Potter','J.K. Rowling','Mladinska',50,NULL,'https://images-na.ssl-images-amazon.com/images/I/81iqZ2HHD-L.jpg',0, 5, 1);
INSERT INTO `artikli` (`id`,`ime`,`avtor`,`zalozba`,`cena`,`slike`,`naslov_slike`,`active`, `ocena`, `stevilo_ocen`) VALUES (8,'Gospodar Prstanov','J.R.R. Tolkien','Mladinska Knjiga',20,NULL,'https://images-na.ssl-images-amazon.com/images/I/8134AkhQJgL.jpg',1, 4, 1);
INSERT INTO `artikli` (`id`,`ime`,`avtor`,`zalozba`,`cena`,`slike`,`naslov_slike`,`active`, `ocena`, `stevilo_ocen`) VALUES (9,'Stoparski vodic po galaksiji','Douglas Adams','Mladinska Knjiga',30,NULL,'https://images.penguinrandomhouse.com/cover/9781400052929',1, 3, 1);
INSERT INTO `artikli` (`id`,`ime`,`avtor`,`zalozba`,`cena`,`slike`,`naslov_slike`,`active`, `ocena`, `stevilo_ocen`) VALUES (10,'Test','Avtor','Zalozba test',100,NULL,NULL,1, 5, 1);
INSERT INTO `artikli` (`id`,`ime`,`avtor`,`zalozba`,`cena`,`slike`,`naslov_slike`,`active`, `ocena`, `stevilo_ocen`) VALUES (11,'Robin Hood','Mladinska Knjiga','Howard Pyle',25,NULL,'https://images-na.ssl-images-amazon.com/images/I/71-8zYH9nIL.jpg',1, 5, 1);