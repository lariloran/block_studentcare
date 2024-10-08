<?php
class PerguntaAeq {
    private $id;
    private $emocaoId;
    private $classeaeqId;
    private $perguntaTexto;

    public function __construct($id, $emocaoId, $classeaeqId, $perguntaTexto) {
        $this->id = $id;
        $this->emocaoId = $emocaoId;
        $this->classeaeqId = $classeaeqId;
        $this->perguntaTexto = $perguntaTexto;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmocaoId() {
        return $this->emocaoId;
    }

    public function getClasseaeqId() {
        return $this->classeaeqId;
    }

    public function getPerguntaTexto() {
        return $this->perguntaTexto;
    }
}
?>
