<?php
    require_once "api/src/http/Response.php";
    require_once "api/src/DAO/AlunoDAO.php";
    class AlunoMiddleware{
        // Roteador >> [Middleware's] >> Controlers >> DAO
        public function stringJsonToStdClass($requestbody): stdClass{
            $stdAluno = json_decode(json: $requestbody);
            if (json_last_error() !== JSON_ERROR_NONE){
                (new Response(
                    success: false,
                    message: 'Aluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Json inválido" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if(!isset($stdAluno->aluno)){
                (new Response(
                    success: false,
                    message: 'Aluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o objeto Aluno" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdAluno->aluno->nomeAluno)){
                (new Response(
                    success: false,
                    message: 'Aluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o nome do aluno" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            return $stdAluno;
        }
        public function isValidNomeAluno($nomeAluno):self{
            
            if (!isset($nomeAluno)){
                (new Response(
                    success: false,
                    message: 'Aluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O aluno não foi enviado" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if(strlen(string: $nomeAluno) < 3){
                (new Response(
                    success: false,
                    message: 'Aluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O aluno precisa de pelo menos 3 caracteres" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }

        public function hasNotAlunoByName($nomeAluno):self {

            $alunoDao = new AlunoDAO();
            $aluno = $alunoDao->readByName(nomeAluno:$nomeAluno);
            if(isset($aluno)){
                (new Response(
                        success: false,
                        message: 'Aluno inválido',
                        error: [
                            "code" => "validation_error",
                            "message"=> "Já existe um aluno cadastrado com esse exato nome" 
                        ],
                        httpCode: 400
                    ))->send();
                    exit();
            }
            return $this;
        }
        public function hasAlunoById($idAluno):self {

            $alunoDao = new AlunoDAO();
            $aluno = $alunoDao->readIdAndNomeById(idAluno:$idAluno);
            if(empty($aluno)){
                (new Response(
                        success: false,
                        message: 'Aluno inválido',
                        error: [
                            "code" => "validation_error",
                            "message"=> "Não existe um aluno cadastrado com esse Id" 
                        ],
                        httpCode: 400
                    ))->send();
                    exit();
            }
            return $this;
        }
        public function isValidId($idAluno):self {
            if(! isset($idAluno)){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar o Aluno',
                    error: [
                        "code" => "aluno_validation_error",
                        "message"=> "O id fornecido não é valido" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            elseif(! is_numeric($idAluno)){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar o Aluno',
                    error: [
                        "code" => "aluno_validation_error",
                        "message"=> "O id fornecido não é numérico" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }elseif($idAluno < 0){
                               (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar o Aluno',
                    error: [
                        "code" => "aluno_validation_error",
                        "message"=> "O id fornecido não é positivo" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }
    }
