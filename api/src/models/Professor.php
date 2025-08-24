<?php

    class Professor implements JsonSerializable {

        public function __construct(
            private ?int $idProfessor = null,
            private ?string $nomeProfessor = ""
        )
        {
            
        }
        public function jsonSerialize():array {


            return [
                'idProfessor' => $this->idProfessor,
                'nomeProfessor' =>$this->nomeProfessor
            ];
        }
        public function getIdProfessor():int{
            return $this->idProfessor;
        }
        public function setIdProfessor(?int $idProfessor):self {
            $this->idProfessor = $idProfessor;
            return $this;
        }
        public function getNomeProfessor():string{
            return $this->nomeProfessor;
        }
        public function setNomeProfessor(?string $nomeProfessor):self {
            $this->nomeProfessor = $nomeProfessor;
            return $this;
        }

    }