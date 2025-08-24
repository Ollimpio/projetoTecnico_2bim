<?php
    require_once "api/src/http/Response.php";
    class DisciplinaMiddleware{

        /*
   {
        "disciplina":{
                "nomeDisciplina": "PAW",
                "media": 8,
                "idProfessor":1,
                "idAluno":1
            
        }
    }
    */
        public function stringJsonToStdClass($requestbody):stdClass{
            $stdDisciplina = json_decode(json: $requestbody);
            if (json_last_error() !== JSON_ERROR_NONE){
                (new Response(
                    success: false,
                    message: 'Disciplina inválida',
                    error: [
                        "code" => "disciplina_validation_error",
                        "message"=> "Json inválido" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if(!isset($stdDisciplina->disciplina)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o objeto Disciplina" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdDisciplina->disciplina->nomeDisciplina)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o nome da Disciplina" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdDisciplina->disciplina->media)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado a média do aluno" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdDisciplina->disciplina->professor)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o campo professor" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdDisciplina->disciplina->professor->idProfessor)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o id do Professor" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdDisciplina->disciplina->aluno)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o campo aluno  " 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if (!isset($stdDisciplina->disciplina->aluno->idAluno)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Não foi enviado o id do aluno  " 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            return $stdDisciplina;
        }
        public function isValidNomeDisciplina($nomeDisciplina):self{
            
            if (!isset($nomeDisciplina)){
                (new Response(
                    success: false,
                    message: 'Disciplina inválida',
                    error: [
                        "code" => "validation_error",
                        "message"=> "A disciplina não foi enviado" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if(strlen(string: $nomeDisciplina) < 2){
                (new Response(
                    success: false,
                    message: 'Disciplina inválida',
                    error: [
                        "code" => "validation_error",
                        "message"=> "A disciplina precisa de pelo menos 3 caracteres" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }
        public function isValidNomeMedia($media):self{
            
            if (!isset($media)){
                (new Response(
                    success: false,
                    message: 'Média inválida',
                    error: [
                        "code" => "validation_error",
                        "message"=> "A média não foi enviado" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if( !is_numeric($media)){
                (new Response(
                    success: false,
                    message: 'Média inválida',
                    error: [
                        "code" => "validation_error",
                        "message"=> "A média prescisa um numero" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            else if($media <0){
                (new Response(
                    success: false,
                    message: 'Média inválida',
                    error: [
                        "code" => "validation_error",
                        "message"=> "A média prescisa ser superior a zero" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }
        public function isValidIdProfessor($idProfessor):self{
            
            if (!isset($idProfessor)){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O professor não foi enviado" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if($idProfessor < 0){
                (new Response(
                    success: false,
                    message: 'Professor inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O id do Professor precisa ser superior a zero" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if( !is_numeric($idProfessor)){
                (new Response(
                    success: false,
                    message: 'idProfessor inválida',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O id do professor prescisa ser um numero" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            return $this;
        }
        public function isValidIdAluno($idAluno):self{
            
            if (!isset($idAluno)){
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
            }else if($idAluno < 0){
                (new Response(
                    success: false,
                    message: 'Aluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O id do aluno precisa ser superior a zero" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }else if( !is_numeric($idAluno)){
                (new Response(
                    success: false,
                    message: 'idAluno inválido',
                    error: [
                        "code" => "validation_error",
                        "message"=> "O id do Aluno prescisa ser um numero" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }

            return $this;
        }
        public function hasNotDisciplinaByName($nomeDisciplina):self{
            $disciplinaDAO = new DisciplinaDAO();
            $disciplina = $disciplinaDAO->readByName(nomeDisciplina: $nomeDisciplina);
            if(!empty($disciplina)){
                (new Response(
                    success: false,
                    message: 'Disciplina já existe',
                    error: [
                        "code" => "validation_error",
                        "message"=> "Já existe uma disciplina com esse nome" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            return $this;

    }
    public function isValidId($idDisciplina):self {
            if(! isset($idDisciplina)){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar a disciplina',
                    error: [
                        "code" => "aluno_validation_error",
                        "message"=> "O id fornecido não é valido" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
            elseif(! is_numeric($idDisciplina)){
                (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar a disciplina',
                    error: [
                        "code" => "aluno_validation_error",
                        "message"=> "O id fornecido não é numérico" 
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }elseif($idDisciplina < 0){
                    (new Response(
                    success: false,
                    message: 'Não foi possivel encontrar a disciplina',
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