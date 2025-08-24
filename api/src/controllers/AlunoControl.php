<?php
    require_once "api/src/DAO/AlunoDAO.php";
    require_once "api/src/http/Response.php";
    class AlunoControl{
        // Roteador >> Middleware's >> [Controlers] >> DAO
        public function index():never{
            $alunoDAO =new AlunoDAO();
            $resposta =  $alunoDAO->readAll();
            (new Response(
                success: true,
                message: "Alunos selecionados com suecsso",
                data: [
                    'Alunos'=> $resposta
                ],
                httpCode: 200
            ))->send();
            exit();
        }

        public function show(int $idAluno):never{
            $alunoDAO =new AlunoDAO();
            $resposta =  $alunoDAO->readById(idAluno:$idAluno);
            (new Response(
                success: true,
                message: "Aluno selecionados com suecsso",
                data: [
                    'Alunos'=> $resposta
                ],
                httpCode: 200
            ))->send();
            exit();
        }

        public function store(stdClass $stdAluno): never{

            $aluno = new Aluno();
            $aluno->setNomeAluno(nomeAluno: $stdAluno->aluno->nomeAluno);
            
            $alunoDAO = new AlunoDAO();
            $novoAluno = $alunoDAO->create($aluno);
            (new Response(
                success: true,
                message: 'Aluno cadastrado com sucesso',
                data: [
                    'alunos'=> $novoAluno
                ],
                httpCode: 200
            ))->send();
            exit();
        }

        public function edit(stdClass $stdAluno):never{
            $alunoDAO =new AlunoDAO();
            $aluno = new Aluno();
            $aluno->setIdAluno($stdAluno->aluno->idAluno)
            ->setNomeAluno($stdAluno->aluno->nomeAluno);   
            
            if ($alunoDAO->update(aluno:$aluno) == true){
                (new Response(
                    success: true,
                    message: 'Aluno atualizado com sucesso',
                    data: [
                        'alunos'=> $aluno                   
                    ],
                    httpCode: 200
                ))->send();
            
            }else{
                (new Response(
                success: false,
                message: 'Aluno não foi atualizado',
                error: [
                    'code'=> 'update_error',
                    'message' => 'Não foi possivel atualizar o aluno'
                ],
                httpCode: 200
            ))->send();
            }
            exit();
        }
        public function destroy(int $idAluno):never{
            $alunoDAO = new AlunoDAO();
            
            if ($alunoDAO->delete(idAluno: $idAluno)){
                (new Response(
                    success: true,
                    message: 'Aluno excluido com sucesso',
                    httpCode: 200
                ))->send();
            exit();                
            }else{
                (new Response(
                success: false,
                message: 'Não foi possivel excluir o aluno',
                error: [
                    'code'=> 'delete_error',
                    'message' => 'O aluno não pode ser excluido'
                ],
                httpCode: 200
            ))->send();
            }
            exit();
        }

    }