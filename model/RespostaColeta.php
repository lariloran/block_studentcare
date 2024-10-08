<?php
class RespostaColeta {
    private $id;
    private $perguntaId;
    private $alunoId;
    private $coletaId;
    private $resposta;
    private $dataResposta;

    public function __construct($id, $perguntaId, $alunoId, $coletaId, $resposta, $dataResposta) {
        $this->id = $id;
        $this->perguntaId = $perguntaId;
        $this->alunoId = $alunoId;
        $this->coletaId = $coletaId;
        $this->resposta = $resposta;
        $this->dataResposta = $dataResposta;
    }

    public function getId() {
        return $this->id;
    }

    public function getPerguntaId() {
        return $this->perguntaId;
    }

    public function getAlunoId() {
        return $this->alunoId;
    }

    public function getColetaId() {
        return $this->coletaId;
    }

    public function getResposta() {
        return $this->resposta;
    }

    public function getDataResposta() {
        return $this->dataResposta;
    }
}
?>
