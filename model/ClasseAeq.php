<?
class ClasseAeq {
    private $nomeClasse;
    private $listaEmocoes = [];

    public function __construct($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }

    public function getNomeClasse() {
        return $this->nomeClasse;
    }

    public function setNomeClasse($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }

    public function adicionarEmocao(Emocao $emocao) {
        $this->listaEmocoes[] = $emocao;
    }

    public function getListaEmocoes() {
        return $this->listaEmocoes;
    }

    public function listarEmocoes() {
        foreach ($this->listaEmocoes as $emocao) {
            echo $emocao->getNome() . PHP_EOL;
        }
    }
}
