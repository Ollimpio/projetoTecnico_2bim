<?php
require_once "api/src/models/Disciplina.php";
require_once "api/src/DAO/DisciplinaDAO.php";

    class DisciplinaControl{
        public function index(): never{
            $disciplinaDAO = new DisciplinaDAO();
            $disciplinas = $disciplinaDAO->readAll();
            (new Response(
                success: true,
                message: 'Disciplinas selecionadas com sucesso',
                data: [
                    'disciplinas'=> $disciplinas
                ],
                httpCode: 200
            ))->send();
            exit();
        }
        public function store(stdClass $stdDisciplina): never{

            $Disciplina = new Disciplina();
            $Disciplina->setNomeDisciplina($stdDisciplina->disciplina->nomeDisciplina);
            $Disciplina->setMedia($stdDisciplina->disciplina->media);
            $Disciplina->getAluno()->setIdAluno($stdDisciplina->disciplina->aluno->idAluno);
            $Disciplina->getProfessor()->setIdProfessor($stdDisciplina->disciplina->professor->idProfessor);

            $DisciplinaDAO = new DisciplinaDAO();
            $novaDisciplina = $DisciplinaDAO->create(disciplina:$Disciplina);

            // Buscar a disciplina recém-criada com nomes completos
            $disciplinaCompleta = $DisciplinaDAO->readById($novaDisciplina->getIdDisciplina());

            (new Response(
                success: true,
                message: 'Professor cadastrado com sucesso',
                data: [
                    'Disciplina'=> $disciplinaCompleta[0] // ou ajuste conforme retorno do seu DAO
                ],
                httpCode: 200
            ))->send();
    exit();
        }
        public function show(int $idDisciplina):never{
            $disciplinaDAO =new DisciplinaDAO();
            $resposta =  $disciplinaDAO->readById(idDisciplina:$idDisciplina);
            (new Response(
                success: true,
                message: "Disciplina selecionada com suecsso",
                data: [
                    'Disciplina'=> $resposta
                ],
                httpCode: 200
            ))->send();
            exit();
        }
        public function edit(stdClass $stdDisciplina):never{
            $disciplinaDAO =new DisciplinaDAO();
            $Disciplina = new Disciplina();
            $Disciplina->
            setIdDisciplina($stdDisciplina->disciplina->idDisciplina)
            ->setNomeDisciplina($stdDisciplina->disciplina->nomeDisciplina)
            ->setMedia($stdDisciplina->disciplina->media);
            
            $Disciplina->getAluno()
                ->setIdAluno($stdDisciplina->disciplina->aluno->idAluno)
                ->setNomeAluno($stdDisciplina->disciplina->aluno->nomeAluno ?? "");
            $Disciplina->getProfessor()
                ->setIdProfessor($stdDisciplina->disciplina->professor->idProfessor)
                ->setNomeProfessor($stdDisciplina->disciplina->professor->nomeProfessor ?? "");
            
            if ($disciplinaDAO->update(disciplina:$Disciplina)){
                // Buscar a disciplina atualizada do banco para garantir todos os campos preenchidos
                $disciplinaAtualizada = $disciplinaDAO->readById($Disciplina->getIdDisciplina());
                (new Response(
                    success: true,
                    message: 'Disciplina atualizada com sucesso',
                    data: [
                        'Disciplina'=> $disciplinaAtualizada                   
                    ],
                    httpCode: 200
                ))->send();
            
            }else{
                (new Response(
                success: false,
                message: 'Disciplina não foi atualizada',
                error: [
                    'code'=> 'update_error',
                    'message' => 'Não foi possivel atualizar a disciplina'
                ],
                httpCode: 400
            ))->send();
            }
            exit();
        }
        public function destroy(int $idDisciplina):never{
            $DisciplinaDAO = new DisciplinaDAO();
            
            if ($DisciplinaDAO->delete(idDisciplina: $idDisciplina)){
                (new Response(
                    success: true,
                    message: 'Disciplina excluido com sucesso',
                    httpCode: 200
                ))->send();
            exit();                
            }else{
                (new Response(
                success: false,
                message: 'Não foi possivel excluir a Disciplina',
                error: [
                    'code'=> 'delete_error',
                    'message' => 'A Disciplina não pode ser excluido'
                ],
                httpCode: 200
            ))->send();
            }
            exit();
        }
    }