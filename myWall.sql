SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mywall` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mywall` ;

-- -----------------------------------------------------
-- Table `mywall`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mywall`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mywall`.`messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mywall`.`messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `users_id` INT NOT NULL ,
  `comment` TEXT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_messages_users_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_messages_users`
    FOREIGN KEY (`users_id` )
    REFERENCES `mywall`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mywall`.`comments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mywall`.`comments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `messages_id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  `comment` TEXT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_comments_messages1_idx` (`messages_id` ASC) ,
  INDEX `fk_comments_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_comments_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `mywall`.`messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `mywall`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mywall` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
