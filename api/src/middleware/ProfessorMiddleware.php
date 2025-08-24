<?php
    require_once "api/src/http/Response.php";
    require_once "api/src/DAO/ProfessorDAO.php";
    class ProfessorMiddleware{
        // Roteador >> [Middleware's] >> Controlers >> DAO
        public function stringJsonToStdClass($requestbody): stdClass{
            $stdProfessor = json_decode(json: $requestbody);
            if (json_last_error() !== JSON_ERROR_NONE){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Json inválido" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if(!isset($stdProfessor->professor)){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o objeto Professor" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdProfessor->professor->nomeProfessor)){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o nome do Professor" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            return $stdProfessor;
        }
        public function isValidNomeProfessor($nomeProfessor):self{
            
            if (!isset($nomeProfessor)){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O Professor não foi enviado" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if(strlen(string: $nomeProfessor) < 3){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O Professor precisa de pelo menos 3 caracteres" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }
        public function isValidValeAlimentacao($valeAlimentacao):self{
            
            if (!isset($valeAlimentacao)){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O Vale Alimentação não foi enviado" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if ($valeAlimentacao < 0 ){
                (new Response(
                    success: false,
                    message: 'Vale Alimentação negativo',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O valor do Vale alimentação precisa ser positivo" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }

        public function hasNotProfessorByName($nomeProfessor):self {

            $ProfessorDao = new ProfessorDAO();
            $Professor = $ProfessorDao->readByName(nomeProfessor:$nomeProfessor);
            if(isset($Professor)){
                (new Response(
                        success: false,
                        message: 'Professor inválido',
                        error: [
                            "code" => "validation_error",
                            "message"=> "Já existe um Professor cadastrado com esse exato nome" 
                        ],
                        httpCode: 400
                    ))->send();
                    exit();
            }
            return $this;
        }
        public function hasProfessorById($idProfessor):self {

            $ProfessorDao = new ProfessorDAO();
            $Professor = $ProfessorDao->readById(idProfessor:$idProfessor);
            if(empty($Professor)){
                (new Response(
                        success: false,
                        message: 'Professor inválido',
                        error: [
                            "code" => "validation_error",
                            "message"=> "Não existe um professor cadastrado com esse Id" 
                        ],
                        httpCode: 400
                    ))->send();
                    exit();
            }
            return $this;
        }
        public function isValidId($idProfessor):self {
            if(! isset($idProfessor)){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar o Professor',
                    error: [
                        "code" => "Professor_validation_error",
                        "message"=> "O id fornecido não é valido" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            elseif(!is_numeric($idProfessor)){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar o Professor',
                    error: [
                        "code" => "Professor_validation_error",
                        "message"=> "O id fornecido não é numérico" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }elseif($idProfessor < 0){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar o Professor',
                    error: [
                        "code" => "Professor_validation_error",
                        "message"=> "O id fornecido não é positivo" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }
    }
