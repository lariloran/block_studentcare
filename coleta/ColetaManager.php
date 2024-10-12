<?php
class ColetaManager {

    // Método para obter as coletas de um professor
    public function get_coletas_by_professor($professor_id) {
        global $DB;
        
        // Consulta para buscar as coletas do professor específico
        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
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
// Método para gerar a lista de coletas em HTML
public function listar_coletas($professor_id) {
    // Obtém as coletas
    $coletas = $this->get_coletas_by_professor($professor_id);
    
    if (empty($coletas)) {
        return "<p>Nenhuma coleta cadastrada.</p>";
    }

    // Inicia a lista HTML
    $html = '<div class="accordion">';

    // Adiciona uma variável JavaScript com os dados das coletas
    $html .= '<script>const coletasData = ' . json_encode(array_values($coletas)) . ';</script>';

    // Itera pelas coletas e cria os itens da lista
    foreach ($coletas as $coleta) {
        $html .= '<div class="accordion-item">';
        $html .= '<div class="accordion-header">';
        $html .= '<button class="accordion-button" type="button" data-toggle="collapse" data-target="#coleta' . $coleta->id . '" aria-expanded="false" aria-controls="coleta' . $coleta->id . '">';
        $html .= '<i class="fa fa-plus"></i> ' . format_string($coleta->nome) . ' - (' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . ')';
        $html .= '</button>';
        $html .= '</div>';

        // Detalhes da coleta
        $html .= '<div id="coleta' . $coleta->id . '" class="collapse accordion-body">';
        $html .= '<p><strong>Descrição:</strong> ' . format_text($coleta->descricao) . '</p>';
        $html .= '<p><strong>ID do Curso:</strong> ' . format_string($coleta->curso_id) . '</p>';
        $html .= '<p><strong>Data de Início:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . '</p>';
        $html .= '<p><strong>Data de Fim:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_fim)) . '</p>';

        // Adiciona as informações de notificação
        $html .= '<p><strong>Notificar Aluno:</strong> ' . ($coleta->notificar_alunos ? 'Sim' : 'Não') . '</p>';
        $html .= '<p><strong>Receber Alerta:</strong> ' . ($coleta->receber_alerta ? 'Sim' : 'Não') . '</p>';

        // Botão para baixar CSV via redirecionamento
        $html .= '<button class="btn btn-secondary" onclick="downloadCSV(' . $coleta->id . ');">'; 
        $html .= '<i class="fa fa-file-csv"></i> Baixar CSV';
        $html .= '</button>';

        $html .= '</div>'; // Fecha collapse
        $html .= '</div>'; // Fecha accordion-item
    }

    // Fecha a lista
    $html .= '</div>';
    
// Adiciona a função JavaScript
$html .= '<script>
    function downloadCSV(coletaId) {

const downloadUrl = "Download.php?coleta_id=" + coletaId;
                window.location.href = downloadUrl; // Redireciona para o download

    }
</script>';

    
    return $html;
}


    // Método para baixar os dados da coleta em CSV// Método para baixar os dados da coleta em CSV
    public function download_csv($coleta_id) {
        global $DB;
    
        // Consulta para obter os dados da coleta específica
        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
                FROM {ifcare_cadastrocoleta} 
                WHERE id = :coleta_id";
    
        // Parâmetros da consulta
        $params = [
            'coleta_id' => $coleta_id
        ];
    
        // Obtém os dados da coleta
        $coleta = $DB->get_record_sql($sql, $params);
    
        // Verifica se a coleta foi encontrada
        if (!$coleta) {
            echo "Coleta não encontrada.";
            return;
        }
    
        // Limpa qualquer saída anterior
        ob_clean(); // Limpa o buffer de saída
    
        // Define o cabeçalho do CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . mb_convert_encoding($coleta->nome, 'UTF-8') . '.csv"');
    
        // Abre o manipulador de saída
        $output = fopen('php://output', 'w');
    
        // Adiciona o BOM para UTF-8
        fputs($output, "\xEF\xBB\xBF");
    
        // Escreve o cabeçalho do CSV
        fputcsv($output, [
            mb_convert_encoding('Nome', 'UTF-8'),
            mb_convert_encoding('Data de Início', 'UTF-8'),
            mb_convert_encoding('Data de Fim', 'UTF-8'),
            mb_convert_encoding('Descrição', 'UTF-8'),
            mb_convert_encoding('ID do Curso', 'UTF-8'),
            mb_convert_encoding('Notificar Aluno', 'UTF-8'),
            mb_convert_encoding('Receber Alerta', 'UTF-8')
        ]);
    
        // Escreve os dados da coleta
        fputcsv($output, [
            mb_convert_encoding($coleta->nome, 'UTF-8'),
            date('d/m/Y H:i', strtotime($coleta->data_inicio)),
            date('d/m/Y H:i', strtotime($coleta->data_fim)),
            mb_convert_encoding($coleta->descricao, 'UTF-8'),
            $coleta->curso_id,
            $coleta->notificar_alunos ? 'Sim' : 'Não',
            $coleta->receber_alerta ? 'Sim' : 'Não'
        ]);
    
        // Fecha o manipulador
        fclose($output);
        exit; // Finaliza o script
    }
    
    

}
?>

<!-- CSS -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .accordion {
        max-width: 600px; /* Limitar a largura do acordeão */
        margin: 20px auto; /* Centralizar o acordeão */
        border-radius: 8px; /* Cantos arredondados */
        overflow: hidden; /* Esconde bordas no colapso */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
        background: #fff; /* Fundo branco */
    }

    .accordion-item {
        border-bottom: 1px solid #ddd; /* Linha entre itens */
    }

    .accordion-header {
        background: #b3d7ff; /* Cor de fundo suave */
        color: #333; /* Texto escuro */
        padding: 10px; /* Padding para o cabeçalho */
        cursor: pointer; /* Cursor de pointer para indicar que é clicável */
        transition: background 0.3s; /* Transição suave para a cor de fundo */
    }

    .accordion-header:hover {
        background: #99c2ff; /* Cor de fundo ao passar o mouse */
    }

    .accordion-button {
        width: 100%; /* Largura total do botão */
        text-align: left; /* Alinhamento à esquerda */
        border: none; /* Sem borda */
        background: none; /* Sem fundo */
        font-size: 14px; /* Tamanho da fonte reduzido */
        color: #333; /* Texto escuro */
    }

    .accordion-body {
        padding: 10px; /* Padding para o corpo */
        background: #f9f9f9; /* Fundo cinza claro */
        transition: max-height 0.2s ease-out; /* Transição para altura máxima */
    }

    .accordion-body p {
        margin: 4px 0; /* Margem reduzida nos parágrafos */
        font-size: 13px; /* Tamanho da fonte dos parágrafos */
    }

    .fa {
        margin-right: 8px; /* Espaçamento para o ícone */
    }
</style>

<!-- JavaScript (usando jQuery para simplificação) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.accordion-button').click(function () {
            $(this).find('i').toggleClass('fa-plus fa-minus');
        });
    });
</script>
