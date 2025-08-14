<?php

    class Aluno implements JsonSerializable {

        public function __construct(
            private ?int $idAluno = null,
            private ?string $nomeAluno = ""
        )
        {
            
        }
        public function jsonSerialize():array {


            return [
                'idAluno' => $this->idAluno,
                'nomeAluno' =>$this->nomeAluno
            ];
        }
        public function getIdAluno():int{
            return $this->idAluno;
        }
        public function setIdAluno(?int $idAluno):self {
            $this->idAluno = $idAluno;
            return $this;
        }
        public function getNomeAluno():string{
            return $this->nomeAluno;
        }
        public function setNomeAluno(?string $nomeAluno):self {
            $this->nomeAluno = $nomeAluno;
            return $this;
        }

    }