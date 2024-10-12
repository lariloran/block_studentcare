<?php
class ColetaManager {

    // Método para obter as coletas de um professor
    public function get_coletas_by_professor($professor_id) {
        global $DB;
        
        // Consulta para buscar as coletas do professor específico
        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id 
                FROM {ifcare_cadastrocoleta} 
                WHERE professor_id = :professor_id
                ORDER BY data_inicio DESC";
        
        // Parâmetros da consulta
        $params = [
            'professor_id' => $professor_id
        ];
        
        // Executa a consulta e retorna os registros
        return $DB->get_records_sql($sql, $params);
    }

    // Método para gerar a lista de coletas em HTML
    public function listar_coletas($professor_id) {
        // Obtem as coletas
        $coletas = $this->get_coletas_by_professor($professor_id);
        
        if (empty($coletas)) {
            return "<p>Nenhuma coleta cadastrada.</p>";
        }

        // Inicia a lista HTML
        $html = '<div class="accordion">';

        // Itera pelas coletas e cria os itens da lista
        foreach ($coletas as $coleta) {
            $html .= '<div class="accordion-item">';
            $html .= '<div class="accordion-header">';
            $html .= '<button class="accordion-button" type="button" data-toggle="collapse" data-target="#coleta' . $coleta->id . '" aria-expanded="false" aria-controls="coleta' . $coleta->id . '">';
            $html .= '<i class="fa fa-plus"></i> ' . format_string($coleta->nome) . ' - (' . date('d/m/Y', strtotime($coleta->data_inicio)) . ')';
            $html .= '</button>';
            $html .= '</div>';

            // Detalhes da coleta
            $html .= '<div id="coleta' . $coleta->id . '" class="collapse accordion-body">';
            $html .= '<p><strong>Descrição:</strong> ' . format_text($coleta->descricao) . '</p>';
            $html .= '<p><strong>ID do Curso:</strong> ' . format_string($coleta->curso_id) . '</p>';
            $html .= '<p><strong>Data de Fim:</strong> ' . date('d/m/Y', strtotime($coleta->data_fim)) . '</p>';
            $html .= '</div>'; // Fecha collapse
            $html .= '</div>'; // Fecha accordion-item
        }

        // Fecha a lista
        $html .= '</div>';
        
        return $html;
    }
}
?>
