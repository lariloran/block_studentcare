<?php

class EmocoesColeta
{
    private $id; // Identificador único da associação
    private $cadastroColetaId; // ID da coleta associada
    private $classeAeqId; // ID da classe AEQ associada
    private $emocaoId; // ID da emoção associada

    // Construtor padrão
    public function __construct($id = null, $cadastroColetaId = null, $classeAeqId = null, $emocaoId = null)
    {
        $this->id = $id;
        $this->cadastroColetaId = $cadastroColetaId;
        $this->classeAeqId = $classeAeqId;
        $this->emocaoId = $emocaoId;
    }

    // Métodos getters e setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCadastroColetaId()
    {
        return $this->cadastroColetaId;
    }

    public function setCadastroColetaId($cadastroColetaId)
    {
        $this->cadastroColetaId = $cadastroColetaId;
    }

    public function getClasseAeqId()
    {
        return $this->classeAeqId;
    }

    public function setClasseAeqId($classeAeqId)
    {
        $this->classeAeqId = $classeAeqId;
    }

    public function getEmocaoId()
    {
        return $this->emocaoId;
    }

    public function setEmocaoId($emocaoId)
    {
        $this->emocaoId = $emocaoId;
    }
}

?>
