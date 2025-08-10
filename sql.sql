CREATE DATABASE Projeto_web;
USE Projeto_web;
CREATE TABLE aluno (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255)
);
CREATE TABLE professor (
    id_professor INT PRIMARY KEY,
    nome_professor VARCHAR(255),
    vale_alimentacao INT
);
CREATE TABLE disciplina (
    id_disciplina INT AUTO_INCREMENT PRIMARY KEY,
    nome_disciplina VARCHAR(255),
    media int,
    id_professor INT NOT NULL,
    id_aluno INT NOT NULL,
    FOREIGN KEY (id_professor) REFERENCES professor(id_professor),
    FOREIGN KEY (id_aluno) REFERENCES aluno(id_aluno)
);
-- -- MySQL Workbench Forward Engineering

-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -- -----------------------------------------------------
-- -- Schema mydb
-- -- -----------------------------------------------------
-- -- -----------------------------------------------------
-- -- Schema projeto_web
-- -- -----------------------------------------------------

-- -- -----------------------------------------------------
-- -- Schema projeto_web
-- -- -----------------------------------------------------
-- CREATE SCHEMA IF NOT EXISTS `projeto_web` DEFAULT CHARACTER SET utf8mb4 ;
-- USE `projeto_web` ;

-- -- -----------------------------------------------------
-- -- Table `projeto_web`.`aluno`
-- -- -----------------------------------------------------
-- CREATE TABLE IF NOT EXISTS `projeto_web`.`aluno` (
--   `id_aluno` INT(11) NOT NULL AUTO_INCREMENT,
--   `nome` VARCHAR(255) NOT NULL,
--   PRIMARY KEY (`id_aluno`))
-- ENGINE = InnoDB
-- DEFAULT CHARACTER SET = utf8mb4;


-- -- -----------------------------------------------------
-- -- Table `projeto_web`.`professor`
-- -- -----------------------------------------------------
-- CREATE TABLE IF NOT EXISTS `projeto_web`.`professor` (
--   `id_professor` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
--   `nome_professor` VARCHAR(255) NOT NULL,
--   `vale_alimentacao` TINYINT(1) NOT NULL,
--   PRIMARY KEY (`id_professor`),
--   UNIQUE INDEX `id_professor_UNIQUE` (`id_professor` ASC) VISIBLE)
-- ENGINE = InnoDB
-- DEFAULT CHARACTER SET = utf8mb4;


-- -- -----------------------------------------------------
-- -- Table `projeto_web`.`disciplina`
-- -- -----------------------------------------------------
-- CREATE TABLE IF NOT EXISTS `projeto_web`.`disciplina` (
--   `id_disciplina` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
--   `nome_disciplina` VARCHAR(255) NOT NULL,
--   `media` INT(11) UNSIGNED NOT NULL,
--   `id_professor` INT(11) UNSIGNED NOT NULL,
--   `id_aluno` INT(11) UNSIGNED NOT NULL,
--   PRIMARY KEY (`id_disciplina`),
--   INDEX `id_professor` (`id_professor` ASC) VISIBLE,
--   INDEX `id_aluno` (`id_aluno` ASC) VISIBLE,
--   UNIQUE INDEX `id_disciplina_UNIQUE` (`id_disciplina` ASC) VISIBLE,
--   CONSTRAINT `disciplina_ibfk_1`
--     FOREIGN KEY (`id_professor`)
--     REFERENCES `projeto_web`.`professor` (`id_professor`),
--   CONSTRAINT `disciplina_ibfk_2`
--     FOREIGN KEY (`id_aluno`)
--     REFERENCES `projeto_web`.`aluno` (`id_aluno`))
-- ENGINE = InnoDB
-- DEFAULT CHARACTER SET = utf8mb4;


-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -- -----------------------------------------------------
-- -- Data for table `projeto_web`.`aluno`
-- -- -----------------------------------------------------
-- START TRANSACTION;
-- USE `projeto_web`;
-- INSERT INTO `projeto_web`.`aluno` (`id_aluno`, `nome`) VALUES (1, 'Bruno Olimpio');
-- INSERT INTO `projeto_web`.`aluno` (`id_aluno`, `nome`) VALUES (2, 'Kaio Silva');
-- INSERT INTO `projeto_web`.`aluno` (`id_aluno`, `nome`) VALUES (3, 'Pedro Ricarte');
-- INSERT INTO `projeto_web`.`aluno` (`id_aluno`, `nome`) VALUES (4, 'Yago Nogueira');

-- COMMIT;
