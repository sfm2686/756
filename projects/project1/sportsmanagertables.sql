-- MySQL Script generated by MySQL Workbench
-- Mon Jun  4 07:56:46 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `server_sport`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_sport` ;

CREATE TABLE IF NOT EXISTS `server_sport` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_season`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_season` ;

CREATE TABLE IF NOT EXISTS `server_season` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `year` CHAR(4) NOT NULL,
  `description` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_league`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_league` ;

CREATE TABLE IF NOT EXISTS `server_league` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_position`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_position` ;

CREATE TABLE IF NOT EXISTS `server_position` (
  `name` VARCHAR(50) NOT NULL,
  `id` INT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_slseason`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_slseason` ;

CREATE TABLE IF NOT EXISTS `server_slseason` (
  `sport` INT NOT NULL,
  `league` INT NOT NULL,
  `season` INT NOT NULL,
  INDEX `ssksseasonFK_idx` (`season` ASC),
  PRIMARY KEY (`sport`, `league`, `season`),
  INDEX `sslsleagueFK_idx` (`league` ASC),
  INDEX `sslssportFK_idx` (`sport` ASC),
  CONSTRAINT `sslssportFK`
    FOREIGN KEY (`sport`)
    REFERENCES `server_sport` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `sslsleaguetFK`
    FOREIGN KEY (`league`)
    REFERENCES `server_league` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `sslsseasonFK`
    FOREIGN KEY (`season`)
    REFERENCES `server_season` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_team`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_team` ;

CREATE TABLE IF NOT EXISTS `server_team` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `mascot` VARCHAR(50) NULL,
  `sport` INT NOT NULL,
  `league` INT NOT NULL,
  `season` INT NOT NULL,
  `picture` VARCHAR(50) NULL,
  `homecolor` VARCHAR(25) NOT NULL DEFAULT 'white',
  `awaycolor` VARCHAR(25) NOT NULL,
  `maxplayers` VARCHAR(45) NOT NULL DEFAULT '15',
  PRIMARY KEY (`id`),
  INDEX `sls_idx` (`sport` ASC, `league` ASC, `season` ASC),
  INDEX `sls_sport_idx` (`sport` ASC),
  INDEX `sls_league_idx` (`league` ASC),
  INDEX `sls_season_idx` (`season` ASC),
  CONSTRAINT `slsFK`
    FOREIGN KEY (`sport`  , `league`, `season`)
    REFERENCES `server_slseason` (`sport`  , `league`, `season`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_player` ;

CREATE TABLE IF NOT EXISTS `server_player` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(50) NOT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `dateofbirth` DATE NOT NULL,
  `jerseynumber` VARCHAR(45) NOT NULL,
  `team` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `teamFK_idx` (`team` ASC),
  INDEX `playPosFK_idx` (`id` ASC),
  CONSTRAINT `teamFK`
    FOREIGN KEY (`team`)
    REFERENCES `server_team` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_schedule` ;

CREATE TABLE IF NOT EXISTS `server_schedule` (
  `sport` INT NOT NULL,
  `league` INT NOT NULL,
  `season` INT NOT NULL,
  `hometeam` INT NOT NULL,
  `awayteam` INT NOT NULL,
  `homescore` INT NOT NULL DEFAULT 0,
  `awayscore` INT NOT NULL DEFAULT 0,
  `scheduled` DATETIME NOT NULL,
  `completed` BIT(1) NOT NULL DEFAULT 0,
  INDEX `sportleagueseasonFK_idx` (`sport` ASC, `league` ASC, `season` ASC),
  INDEX `hometeamFK_idx` (`hometeam` ASC),
  INDEX `awayteamFK_idx` (`awayteam` ASC),
  CONSTRAINT `schslseasonFK`
    FOREIGN KEY (`sport` , `league` , `season`)
    REFERENCES `server_slseason` (`sport` , `league` , `season`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `hometeamFK`
    FOREIGN KEY (`hometeam`)
    REFERENCES `server_team` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `awayteamFK`
    FOREIGN KEY (`awayteam`)
    REFERENCES `server_team` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_roles` ;

CREATE TABLE IF NOT EXISTS `server_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO `server_roles` (`id`, `name`) VALUES
(1,	'Admin'),
(2,	'League Manager'),
(3,	'Team Manager'),
(4,	'Coach'),
(5,	'Parent');

-- -----------------------------------------------------
-- Table `server_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_user` ;

CREATE TABLE IF NOT EXISTS `server_user` (
  `username` VARCHAR(25) NOT NULL,
  `role` INT NOT NULL,
  `password` CHAR(60) NOT NULL,
  `team` INT NULL,
  `league` INT NULL,
  PRIMARY KEY (`username`),
  INDEX `roleFK_idx` (`role` ASC),
  INDEX `teamUserFK_idx` (`team` ASC),
  INDEX `leagueUserFK_idx` (`league` ASC),
  CONSTRAINT `roleFK`
    FOREIGN KEY (`role`)
    REFERENCES `server_roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `teamUserFK`
    FOREIGN KEY (`team`)
    REFERENCES `server_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `leagueUserFK`
    FOREIGN KEY (`league`)
    REFERENCES `server_league` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_playerpos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `server_playerpos` ;

CREATE TABLE IF NOT EXISTS `server_playerpos` (
  `player` INT NULL,
  `position` INT NULL,
  PRIMARY KEY (`player`, `position`),
  INDEX `ppPlayerFK_idx` (`player` ASC),
  INDEX `posFK_idx` (`position` ASC),
  CONSTRAINT `posPlayerFK`
    FOREIGN KEY (`player`)
    REFERENCES `server_player` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `posFK`
    FOREIGN KEY (`position`)
    REFERENCES `server_position` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;