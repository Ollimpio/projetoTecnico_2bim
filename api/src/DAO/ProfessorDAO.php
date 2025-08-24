<?php
    require_once "api/src/db/Database.php";
    require_once "api/src/models/Professor.php";
    class ProfessorDAO{
        // Roteador >> Middleware's >> Controlers >> [DAO]
        public function readAll():array {
            $resultados = [];
            $query = 'SELECT
            id_professor,
            nome_professor
            FROM professor
            ORDER BY nome_professor ASC
            ';

            $statement = Database::getConnection()->query(query: $query);
            $statement->execute();
            /*
            while($stdLinha = $statement->fetch(mode:PDO::FETCH_OBJ)){
                $Professor = new Professor();
                $Professor->setIdProfessor(idProfessor: $stdLinha->id_Professor)
                 ->setNomeProfessor(nomeProfessor: $stdLinha->nome);
                 $resultados[] = $Professor; 
            }
            */
            $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            return $resultados;
        }
        public function readById(int $idProfessor):Professor |array{
            $resultados = [];
            $query = 'SELECT
            id_professor,
            nome_professor
            FROM Professor
            WHERE id_professor = :id_Professor
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':id_Professor' => (int) $idProfessor]
            );
            // $stdClass = $statement->fetch(mode:PDO::FETCH_OBJ);
            $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            // $Professor = new Professor(idProfessor: $stdClass->id_Professor, nomeProfessor:$stdClass->nome);

            return $resultados;
        }

        public function readByName(string $nomeProfessor):Professor|null {
            $query =
            'SELECT
            id_professor,
            nome_professor
            FROM Professor
            WHERE nome_professor = :nomeProfessor
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':nomeProfessor' => $nomeProfessor]
            );
            
            $objStdProfessor = $statement->fetch(mode:PDO::FETCH_OBJ);

            if (!$objStdProfessor){
                return null;
            }
 
            return (new Professor())
                ->setIdProfessor(idProfessor: $objStdProfessor->id_Professor)
                ->setNomeProfessor(nomeProfessor: $objStdProfessor->nome);
        }

        public function create(Professor $Professor) :Professor {
            $query =
            'INSERT INTO
            professor (nome_professor)
            VALUES (:nomeProfessor)
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':nomeProfessor' => $Professor->getNomeProfessor()]
            );

            $Professor->setIdProfessor(idProfessor:(int)Database::getConnection()->lastInsertId());
            return $Professor;
        }

        public function update(Professor $Professor):bool{
            $query =
            'UPDATE professor
            SET nome_professor = :novoNomeProfessor
            WHERE id_professor = :idProfessor;
            ';
              $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':novoNomeProfessor' => $Professor->getNomeProfessor(),
                ':idProfessor' => $Professor->getIdProfessor()
            ]);

            return $statement->rowCount() >0;
        }

        public function delete(int $idProfessor):bool{
            $query =
                'DELETE FROM professor
                WHERE id_professor = :idProfessor;
                ';
              $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [
                ':idProfessor' => $idProfessor
            ]);

            return $statement->rowCount() >0;
        }
    }