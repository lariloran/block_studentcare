<?
class CadastroColeta {
    private $nome;
    private $dataInicio;
    private $horaInicio;
    private $dataFim;
    private $horaFim;
    private $descricao;
    private $receberAlerta;
    private $notificarAlunos;
    private $classesAEQ;

    public function __construct($nome, $dataInicio, $horaInicio, $dataFim, $horaFim, $descricao, $receberAlerta, $notificarAlunos) {
        $this->nome = $nome;
        $this->dataInicio = $dataInicio;
        $this->horaInicio = $horaInicio;
        $this->dataFim = $dataFim;
        $this->horaFim = $horaFim;
        $this->descricao = $descricao;
        $this->receberAlerta = $receberAlerta;
        $this->notificarAlunos = $notificarAlunos;
        $this->classesAEQ = [];
    }

    // Getters e Setters para os atributos
    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }

    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    public function getDataFim() {
        return $this->dataFim;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function getHoraFim() {
        return $this->horaFim;
    }

    public function setHoraFim($horaFim) {
        $this->horaFim = $horaFim;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    // Métodos para trabalhar com Classes AEQ
    public function addClasseAEQ(ClasseAEQ $classeAEQ) {
        $this->classesAEQ[] = $classeAEQ;
    }

    public function getClassesAEQ() {
        return $this->classesAEQ;
    }

    public function isReceberAlerta() {
        return $this->receberAlerta;
    }

    public function setReceberAlerta($receberAlerta) {
        $this->receberAlerta = $receberAlerta;
    }

    public function isNotificarAlunos() {
        return $this->notificarAlunos;
    }

    public function setNotificarAlunos($notificarAlunos) {
        $this->notificarAlunos = $notificarAlunos;
    }

    // Método para exibir os dados da coleta
    public function mostrarCadastroColeta() {
        echo "Nome da Coleta: " . $this->nome . PHP_EOL;
        echo "Data Início: " . $this->dataInicio . " " . $this->horaInicio . PHP_EOL;
        echo "Data Fim: " . $this->dataFim . " " . $this->horaFim . PHP_EOL;
        echo "Descrição: " . $this->descricao . PHP_EOL;
        echo "Receber Alerta: " . ($this->receberAlerta ? 'Sim' : 'Não') . PHP_EOL;
        echo "Notificar Alunos: " . ($this->notificarAlunos ? 'Sim' : 'Não') . PHP_EOL;

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