<?php
require_once "api/src/models/Aluno.php";
require_once "api/src/models/Professor.php";
    class Disciplina implements JsonSerializable{

   
        public function __construct(
                private ?int $idDisciplina = null,
                private string $nomeDisciplina = "",
                private int $media = 0,
                private Aluno $aluno = new Aluno(),
                private Professor $professor = new Professor()
            )
            {
                
            }
    public function jsonSerialize(): array {
        return [
            'idDisciplina' => $this->getIdDisciplina(),
            'nomeDisciplina' => $this->getNomeDisciplina(),
            'media' => $this->getMedia(),
            'aluno' => [
                'idAluno' => $this->getAluno()->getIdAluno(),
                'nomeAluno' => $this->getAluno()->getNomeAluno()  
            ],
            'professor' => [
                'idProfessor' => $this->getProfessor()->getIdProfessor(),
                'nomeProfessor' => $this->getProfessor()->getNomeProfessor()  
            ]
        ];
    }        
    public function getIdDisciplina(): int
    {
        return $this->idDisciplina;
    }

    public function setIdDisciplina(int $idDisciplina): self
    {
        $this->idDisciplina = $idDisciplina;
        return $this;
    }

    public function getNomeDisciplina(): string
    {
        return $this->nomeDisciplina;
    }

    public function setNomeDisciplina(string $nomeDisciplina): self
    {
        $this->nomeDisciplina = $nomeDisciplina;
        return $this;
    }

    public function getMedia(): int
    {
        return $this->media;
    }

    public function setMedia(int $media): self
    {
        $this->media = $media;
        return $this;
    }

    public function getAluno(): Aluno
    {
        return $this->aluno;
    }

    public function setAluno(Aluno $aluno): self
    {
        $this->aluno = $aluno;
        return $this;
    }

    public function getProfessor(): Professor
    {
        return $this->professor;
    }

    public function setProfessor(Professor $professor): self
    {
        $this->professor = $professor;
        return $this;
    }
    }