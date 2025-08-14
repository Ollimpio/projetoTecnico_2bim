<?php
    require_once "api/src/DAO/AlunoDAO.php";
    require_once "api/src/http/Response.php";
    class AlunoControl{
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

            exit();
        }

    }