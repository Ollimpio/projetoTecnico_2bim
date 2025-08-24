<?php
    require_once "api/src/DAO/ProfessorDAO.php";
    require_once "api/src/http/Response.php";
    class ProfessorControl{
        // Roteador >> Middleware's >> [Controlers] >> DAO
        public function index():never{
            $ProfessorDAO =new ProfessorDAO();
            $resposta =  $ProfessorDAO->readAll();
            (new Response(
                success: true,
                message: "Professors selecionados com suecsso",
                data: [
                    'Professors'=> $resposta
                ],
                httpCode: 200
            ))->send();
            exit();
        }

        public function show(int $idProfessor):never{
            $ProfessorDAO =new ProfessorDAO();
            $resposta =  $ProfessorDAO->readById(idProfessor:$idProfessor);
            (new Response(
                success: true,
                message: "Professor selecionados com suecsso",
                data: [
                    'Professors'=> $resposta
                ],
                httpCode: 200
            ))->send();
            exit();
        }

        public function store(stdClass $stdProfessor): never{

            $Professor = new Professor();
            $Professor->setNomeProfessor(nomeProfessor: $stdProfessor->professor->nomeProfessor);
            
            $ProfessorDAO = new ProfessorDAO();
            $novoProfessor = $ProfessorDAO->create($Professor);
            (new Response(
                success: true,
                message: 'Professor cadastrado com sucesso',
                data: [
                    'Professors'=> $novoProfessor
                ],
                httpCode: 200
            ))->send();
            exit();
        }

        public function edit(stdClass $stdProfessor):never{
            $ProfessorDAO =new ProfessorDAO();
            $Professor = new Professor();
            $Professor->setIdProfessor($stdProfessor->professor->idProfessor)
            ->setNomeProfessor($stdProfessor->professor->nomeProfessor);   
            
            if ($ProfessorDAO->update(Professor:$Professor) == true){
                (new Response(
                    success: true,
                    message: 'Professor atualizado com sucesso',
                    data: [
                        'Professors'=> $Professor                   
                    ],
                    httpCode: 200
                ))->send();
            
            }else{
                (new Response(
                success: false,
                message: 'Professor não foi atualizado',
                error: [
                    'code'=> 'update_error',
                    'message' => 'Não foi possivel atualizar o Professor'
                ],
                httpCode: 200
            ))->send();
            }
            exit();
        }
        public function destroy(int $idProfessor):never{
            $ProfessorDAO = new ProfessorDAO();
            
            if ($ProfessorDAO->delete(idProfessor: $idProfessor)){
                (new Response(
                    success: true,
                    message: 'Professor excluido com sucesso',
                    httpCode: 200
                ))->send();
            exit();                
            }else{
                (new Response(
                success: false,
                message: 'Não foi possivel excluir o Professor',
                error: [
                    'code'=> 'delete_error',
                    'message' => 'O Professor não pode ser excluido'
                ],
                httpCode: 200
            ))->send();
            }
            exit();
        }

    }