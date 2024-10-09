<?
class ClasseAeq {
    private $nomeClasse;

    public function __construct($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }

    public function getNomeClasse() {
        return $this->nomeClasse;
    }

    public function setNomeClasse($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }
}
