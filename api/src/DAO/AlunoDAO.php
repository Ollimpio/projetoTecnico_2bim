<?php
    require_once "api/src/db/Database.php";
    require_once "api/src/models/Aluno.php";
    class AlunoDAO{
        // Roteador >> Middleware's >> Controlers >> [DAO]
        public function readAll():array {
            $resultados = [];
            $query = 'SELECT
            id_aluno,
            nome
            FROM aluno
            ORDER BY nome ASC
            ';

            $statement = Database::getConnection()->query(query: $query);
            $statement->execute();
            /*
            while($stdLinha = $statement->fetch(mode:PDO::FETCH_OBJ)){
                $aluno = new Aluno();
                $aluno->setIdAluno(idAluno: $stdLinha->id_aluno)
                 ->setNomeAluno(nomeAluno: $stdLinha->nome);
                 $resultados[] = $aluno; 
            }
            */
            $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            return $resultados;
        }
        public function readById(int $idAluno):Aluno |array{
            $resultados = [];
            $query = 'SELECT
            id_aluno,
            nome
            FROM aluno
            WHERE id_aluno = :id_Aluno
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':id_Aluno' => (int) $idAluno]
            );
            // $stdClass = $statement->fetch(mode:PDO::FETCH_OBJ);
            $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            // $aluno = new Aluno(idAluno: $stdClass->id_aluno, nomeAluno:$stdClass->nome);

            return $resultados;
        }

        public function readByName(string $nomeAluno):Aluno|null {
            $query =
            'SELECT
            id_aluno,
            nome
            FROM aluno
            WHERE nome = :nomeAluno
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':nomeAluno' => $nomeAluno]
            );
            
            $objStdAluno = $statement->fetch(mode:PDO::FETCH_OBJ);

            if (!$objStdAluno){
                return null;
            }
 
            return (new Aluno())
                ->setIdAluno(idAluno: $objStdAluno->id_aluno)
                ->setNomeAluno(nomeAluno: $objStdAluno->nome);
        }

        public function create(Aluno $aluno) :Aluno {
            $query =
            'INSERT INTO
            aluno (nome)
            VALUES (:nomeAluno)
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':nomeAluno' => $aluno->getNomeAluno()]
            );

            $aluno->setIdAluno(idAluno:(int)Database::getConnection()->lastInsertId());
            return $aluno;
        }

        public function update(Aluno $aluno):bool{
            $query =
            'UPDATE aluno
            SET nome = :novoNomeAluno
            WHERE id_aluno = :idAluno;
            ';
              $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':novoNomeAluno' => $aluno->getNomeAluno(),
                ':idAluno' => $aluno->getIdAluno()
            ]);

            return $statement->rowCount() >0;
        }

        public function delete(int $idAluno):bool{
            $query =
                'DELETE FROM aluno
                WHERE id_aluno = :idAluno;
                ';
              $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [
                ':idAluno' => $idAluno
            ]);

            return $statement->rowCount() >0;
        }
    }