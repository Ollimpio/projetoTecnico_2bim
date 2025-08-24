<?php
    require_once "api/src/utils/Logger.php";
    require_once "api/src/http/Response.php";
    require_once "api/src/routes/Router.php";
    require_once "api/src/controllers/AlunoControl.php";
    require_once "api/src/controllers/ProfessorControl.php";
    require_once "api/src/middleware/AlunoMiddleware.php";
    require_once "api/src/middleware/ProfessorMiddleware.php";
    
class Roteador{
    public function __construct(
        private $router = new Router()
    ){
        $this->setupHeader();
        $this->setupAlunosRoutes();
        $this->setupProfessoresRoutes();
        $this->setupDiciplinasRoutes();
        $this->setup404Routes();
    }
    private function setupHeader():void{
        header(header:'Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header(header: 'Access-Control-Allow-Origin:*');
        header(header:'Access-Control-Allow-Headers: Content-Type, Auhorization');
    }
    private function setupAlunosRoutes():void{
        $this->router->get(pattern:'/alunos',fn: function():never{
            try{
                if(isset($_GET['page']) && isset($_GET['limit'])){

                }else{

                    (new AlunoControl())->index();
                }

            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->get(pattern:'/alunos/(\d+)',fn: function($idAluno):never{
            try{
                $alunoMiddleware = new AlunoMiddleware();
                $alunoMiddleware->isValidId(idAluno:$idAluno);

                (new AlunoControl())
                    ->show(idAluno:$idAluno);
                    
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->post(pattern:'/alunos',fn: function():never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                
                $alunoMiddleware = new AlunoMiddleware();
                $objStd = $alunoMiddleware->stringJsonToStdClass(requestbody:$requestBody);
                
                
                $alunoMiddleware
                    ->isValidNomeAluno(nomeAluno:$objStd->aluno->nomeAluno)
                    ->hasNotAlunoByName(nomeAluno:$objStd->aluno->nomeAluno);
                    
                $alunoControl = new AlunoControl();
                $alunoControl->store($objStd);
                
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        // [Roteador] >> Middleware's >> Controlers >> DAO
        $this->router->put(pattern:'/alunos/(\d+)',fn: function($idAluno):never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                $alunoMiddleware = new AlunoMiddleware();
                $stdAluno = $alunoMiddleware->stringJsonToStdClass($requestBody);
                $alunoMiddleware    
                    ->isValidId(idAluno: $idAluno)
                    ->hasNotAlunoByName(nomeAluno:$stdAluno->aluno->nomeAluno);
                
                $stdAluno->aluno->idAluno = $idAluno;

                $alunoControl = new AlunoControl();
                $alunoControl->edit(stdAluno:$stdAluno);
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na atualização de alunos');
            };
            exit();
        });
        $this->router->delete(pattern:'/alunos/(\d+)',fn: function($idAluno):never{
            try{
                $alunoMiddleware = new AlunoMiddleware();
                $alunoMiddleware->isValidId(idAluno:$idAluno);

                $alunoControl = new AlunoControl();
                $alunoControl->destroy(idAluno:$idAluno);
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
    }

    private function setupProfessoresRoutes():void{
        $this->router->get(pattern:'/professores',fn: function():never{
            try{
                if(isset($_GET['page']) && isset($_GET['limit'])){

                }else{

                    (new ProfessorControl())->index();
                }

            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
            };
            exit();
        });
        $this->router->get(pattern:'/professores/(\d+)',fn: function($idProfessor):never{
            try{
                $professorMiddleware = new ProfessorMiddleware();
                $professorMiddleware->isValidId(idProfessor:$idProfessor);

                (new ProfessorControl())
                    ->show(idProfessor:$idProfessor);
                    
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professor');
            };
            exit();
        });
        $this->router->post(pattern:'/professores',fn: function():never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                
                $professorMiddleware = new ProfessorMiddleware();
                $objStd = $professorMiddleware->stringJsonToStdClass(requestbody:$requestBody);
                
                
                $professorMiddleware
                    ->isValidNomeProfessor(nomeProfessor:$objStd->professor->nomeProfessor)
                    ->isValidValeAlimentacao(valeAlimentacao:$objStd->professor->valeAlimentacao)
                    ->hasNotProfessorByName(nomeProfessor:$objStd->professor->nomeProfessor);
                    
                $professorControl = new ProfessorControl();
                $professorControl->store($objStd);
                
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
            };
            exit();
        });
        $this->router->put(pattern:'/professores/(\d+)',fn: function($idProfessor):never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                $professorMiddleware = new ProfessorMiddleware();
                $stdProfessor = $professorMiddleware->stringJsonToStdClass($requestBody);
                $professorMiddleware    
                    ->isValidId(idProfessor: $idProfessor)
                    ->hasNotProfessorByName(nomeProfessor:$stdProfessor->professor->nomeProfessor);
                
                $stdProfessor->professor->idProfessor = $idProfessor;

                $professorControl = new ProfessorControl();
                $professorControl->edit(stdProfessor:$stdProfessor);
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na atualização de professor');
            };
            exit();
        });
        $this->router->delete(pattern:'/professores/(\d+)',fn: function($idProfessor):never{
            try{
                $professorMiddleware = new ProfessorMiddleware();
                $professorMiddleware->isValidId(idProfessor:$idProfessor);

                $professorControl = new ProfessorControl();
                $professorControl->destroy(idProfessor:$idProfessor);
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professor');
            };
            exit();
        });
    }
    private function setupDiciplinasRoutes():void{ 
        $this->router->get(pattern:'/diciplinas',fn: function():never{
            try{
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de diciplinas');
            };
            exit();
        });
        $this->router->get(pattern:'/diciplinas/(\w+)',fn: function($nomeDiciplina):never{
            try{
                echo $nomeDiciplina;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->post(pattern:'/diciplinas',fn: function():never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                echo"recebeu o texto json com sucsso: $requestBody";
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->put(pattern:'/diciplinas/(\w+)',fn: function($nomeDiciplina):never{
            try{
                echo $nomeDiciplina;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->delete(pattern:'/diciplinas/(\w+)',fn: function($nomeDiciplina):never{
            try{
                echo $nomeDiciplina;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });

    }
    private  function sendErrorResponse(Throwable $throwable, $message):never{
        logger::log(throwable:$throwable);
        (new Response(
            success:false,
            message: $message,
            error:[
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage()
            ],
            httpCode:500

        ))->send();
        exit();
    }
    private function setup404Routes(): void{
         $this->router->set404(function(): void{
            (new Response(
            success:false,
            message: "Rota não encontrada",
            error:[
                'code' => 'rouring_error',
                'message' => 'rota não Mapeada'
            ],
            httpCode:404

        ))->send();
        });
    }
    public function start():void{

        $this->router->run();
    }
}

?>