<?
class Emocao {
    private $id;
    private $nome;
    private $antes;
    private $durante;
    private $depois;

    public function __construct($id, $nome, $antes, $durante, $depois) {
        $this->id = $id;
        $this->nome = $nome;
        $this->antes = $antes;
        $this->durante = $durante;
        $this->depois = $depois;
    }

    public function getNome() {
        return $this->nome;
    }

    public function isAntes() {
        return $this->antes;
    }

    public function isDurante() {
        return $this->durante;
    }

    public function isDepois() {
        return $this->depois;
    }
}