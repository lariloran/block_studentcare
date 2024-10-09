<?php
class CadastroColeta {
    private $nome;
    private $dataInicio;
    private $horaInicio;
    private $dataFim;
    private $horaFim;
    private $descricao;
    private $receberAlerta;
    private $notificarAlunos;
    private $cursoId;  
    private $professorId;  
    private $classesAEQ;

    public function __construct($nome, $dataInicio, $horaInicio, $dataFim, $horaFim, $descricao, $receberAlerta, $notificarAlunos, $cursoId, $professorId) {
        $this->nome = $nome;
        $this->dataInicio = $dataInicio;
        $this->horaInicio = $horaInicio;
        $this->dataFim = $dataFim;
        $this->horaFim = $horaFim;
        $this->descricao = $descricao;
        $this->receberAlerta = $receberAlerta;
        $this->notificarAlunos = $notificarAlunos;
        $this->cursoId = $cursoId; 
        $this->professorId = $professorId; 
        $this->classesAEQ = [];
    }

    public function getCursoId() {
        return $this->cursoId;
    }

    public function setCursoId($cursoId) {
        $this->cursoId = $cursoId;
    }

    public function getProfessorId() {
        return $this->professorId;
    }

    public function setProfessorId($professorId) {
        $this->professorId = $professorId;
    }


    public function mostrarCadastroColeta() {
        echo "Nome da Coleta: " . $this->nome . PHP_EOL;
        echo "Data Início: " . $this->dataInicio . " " . $this->horaInicio . PHP_EOL;
        echo "Data Fim: " . $this->dataFim . " " . $this->horaFim . PHP_EOL;
        echo "Descrição: " . $this->descricao . PHP_EOL;
        echo "Receber Alerta: " . ($this->receberAlerta ? 'Sim' : 'Não') . PHP_EOL;
        echo "Notificar Alunos: " . ($this->notificarAlunos ? 'Sim' : 'Não') . PHP_EOL;
        echo "Curso ID: " . $this->cursoId . PHP_EOL;  
        echo "Professor ID: " . $this->professorId . PHP_EOL;  

        echo "Classes AEQ: " . PHP_EOL;
        foreach ($this->classesAEQ as $classe) {
            echo "- " . $classe->getNomeClasse() . PHP_EOL;
            foreach ($classe->getListaEmocoes() as $emocao) {
                echo "  * Emoção: " . $emocao->getNome() . PHP_EOL;
                echo "    Antes: " . ($emocao->isAntes() ? 'Sim' : 'Não') . PHP_EOL;
                echo "    Durante: " . ($emocao->isDurante() ? 'Sim' : 'Não') . PHP_EOL;
                echo "    Depois: " . ($emocao->isDepois() ? 'Sim' : 'Não') . PHP_EOL;
            }
        }
    }
}

