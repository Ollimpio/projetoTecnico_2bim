<?php
    require_once "api/src/http/utils/Logger.php";
    require_once "api/src/http/Response.php";
    require_once "api/src/routes/Router.php";
    
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
                require_once "api/src/db/Database.php";
                $query = "select now() as momento";
                $statement = Database::getConnection()->prepare(query:$query);
                $statement->execute();
                $stdLinha = $statement->fetch(mode:PDO::FETCH_OBJ);

                echo json_encode(value:$stdLinha);
            
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->get(pattern:'/alunos/(\d+)',fn: function($idAluno):never{
            try{
                echo $idAluno;
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->post(pattern:'/alunos',fn: function():never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                echo"recebeu o texto json com sucsso: $requestBody";
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->put(pattern:'/alunos/(\d+)',fn: function($idAluno):never{
            try{
                echo $idAluno;
            
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
        $this->router->delete(pattern:'/alunos/(\d+)',fn: function($idAluno):never{
            try{
                echo $idAluno;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de alunos');
            };
            exit();
        });
    }

    private function setupProfessoresRoutes():void{
        $this->router->get(pattern:'/professores',fn: function():never{
            try{
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
            };
            exit();
        });
        $this->router->get(pattern:'/professores/(\d+)',fn: function($idProfessor):never{
            try{
                echo $idProfessor;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
            };
            exit();
        });
        $this->router->post(pattern:'/professores',fn: function():never{
            try{
                $requestBody = file_get_contents(filename:'php://input' );
                echo"recebeu o texto json com sucsso: $requestBody";
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
            };
            exit();
        });
        $this->router->put(pattern:'/professores/(\d+)',fn: function($idProfessor):never{
            try{
                echo $idProfessor;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
            };
            exit();
        });
        $this->router->delete(pattern:'/professores/(\d+)',fn: function($idProfessor):never{
            try{
                echo $idProfessor;
                
            }catch(Throwable $throwable){
                $this->sendErrorResponse(throwable: $throwable, message:'Erro na seleção de professores');
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
                'problemCode' => $throwable->getCode(),
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
                'problemCode' => 'rouring_error',
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