<?php
    require_once "api/src/db/Database.php";
    require_once "api/src/models/Disciplina.php";

class DisciplinaDAO{
    public function readAll():array {
        $resultados = [];
            $query =
            'SELECT 
            disciplina.id_disciplina, 
            disciplina.nome_disciplina, 
            disciplina.media, 
            disciplina.id_professor, 
            disciplina.id_aluno,
            aluno.nome AS nome_aluno,
            professor.nome_professor AS nome_professor
            FROM disciplina
            JOIN professor ON disciplina.id_professor = professor.id_professor  
            JOIN aluno ON disciplina.id_aluno = aluno.id_aluno 
            ORDER BY disciplina.nome_disciplina ASC;
            ';

            $statement = Database::getConnection()->query(query: $query);
            $resultados =[];

            while($stdLinha = $statement->fetch(mode:PDO::FETCH_OBJ)){
                    $disciplina = (new Disciplina())
                        ->setIdDisciplina((int)$stdLinha->id_disciplina)
                        ->setNomeDisciplina($stdLinha->nome_disciplina)
                        ->setMedia((int)$stdLinha->media);

                    $disciplina->getProfessor()
                        ->setIdProfessor((int)$stdLinha->id_professor)
                        ->setNomeProfessor($stdLinha->nome_professor);

                    $disciplina->getAluno()
                        ->setIdAluno((int)$stdLinha->id_aluno)
                        ->setNomeAluno($stdLinha->nome_aluno);

                    $resultados[] = $disciplina;
                }
                    
            
            // $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            return $resultados;
        }
    public function readByName(string $nomeDisciplina):Disciplina|array {
        $resultados = [];
            $query =
            'SELECT 
            nome_disciplina, media, id_professor, id_aluno 
            FROM disciplina
            WHERE nome_disciplina = :nomeDisciplina
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':nomeDisciplina' => $nomeDisciplina]
            );

            $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            return $resultados;
        }
    public function create(Disciplina $disciplina) :Disciplina {
            $query =
            'INSERT INTO
            disciplina (nome_disciplina, media, id_professor, id_aluno)
            VALUES 
            (:nome_disciplina, :media, :id_professor, :id_aluno);
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [
                        ':nome_disciplina' => $disciplina->getNomeDisciplina(),
                        ':media' => $disciplina->getMedia(),
                        ':id_professor' => $disciplina->getProfessor()->getIdProfessor(),
                        ':id_aluno' => $disciplina->getAluno()->getIdAluno()
                        ]
            );
            
            $disciplina->setIdDisciplina(idDisciplina:(int)Database::getConnection()->lastInsertId());
            return $disciplina;
        }
        public function readById(int $idDisciplina):Aluno |array{
            $resultados = [];
            $query = 'SELECT
            disciplina.id_disciplina,
            disciplina.nome_disciplina,
            disciplina.media,
            disciplina.id_professor,
            professor.nome_professor AS nome_professor,
            disciplina.id_aluno,
            aluno.nome AS nome_aluno
        FROM disciplina
        JOIN professor ON disciplina.id_professor = professor.id_professor
        JOIN aluno ON disciplina.id_aluno = aluno.id_aluno
        WHERE disciplina.id_disciplina = :id_Disciplina
            ';

            $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [':id_Disciplina' => (int) $idDisciplina]
            );
            // $stdClass = $statement->fetch(mode:PDO::FETCH_OBJ);
            $resultados = $statement->fetchAll(mode:PDO::FETCH_ASSOC);
            // $aluno = new Aluno(idAluno: $stdClass->id_aluno, nomeAluno:$stdClass->nome);

            return $resultados;
        }
        public function update(Disciplina $disciplina):bool{
            $query = 'UPDATE disciplina SET 
        nome_disciplina = :nome_disciplina, 
        media = :media, 
        id_professor = :id_professor, 
        id_aluno = :id_aluno 
        WHERE id_disciplina = :id_disciplina';

        $statement = Database::getConnection()->prepare($query);
        $statement->execute([
            ':nome_disciplina' => $disciplina->getNomeDisciplina(),
            ':media' => $disciplina->getMedia(),
            ':id_professor' => $disciplina->getProfessor()->getIdProfessor(),
            ':id_aluno' => $disciplina->getAluno()->getIdAluno(),
            ':id_disciplina' => $disciplina->getIdDisciplina()
        ]);

            return $statement->rowCount() >0;
        }
        public function delete(int $idDisciplina):bool{
            $query =
                'DELETE FROM disciplina 
                WHERE id_disciplina = :idDisciplina;
                ';
              $statement = Database::getConnection()->prepare(query: $query);
            $statement->execute(
                params: [
                ':idDisciplina' => $idDisciplina
            ]);

            return $statement->rowCount() >0;
        }
    }