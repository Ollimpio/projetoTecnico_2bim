CREATE DATABASE teste;
USE teste;

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

