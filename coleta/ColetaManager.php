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
    global $DB; // Certifique-se de usar o objeto DB para realizar consultas
    
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
        // Busca o nome do curso (disciplina) a partir do curso_id
        $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
        $curso_nome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';

        $html .= '<div class="accordion-item">';
        $html .= '<div class="accordion-header">';
        $html .= '<button class="accordion-button" type="button" data-toggle="collapse" data-target="#coleta' . $coleta->id . '" aria-expanded="false" aria-controls="coleta' . $coleta->id . '">';
        $html .= '<i class="fa fa-plus"></i> ' . format_string($coleta->nome) . ' - (' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . ')';
        $html .= '</button>';
        $html .= '</div>';

        // Detalhes da coleta
        $html .= '<div id="coleta' . $coleta->id . '" class="collapse accordion-body">';
        $html .= '<p><strong>Descrição:</strong> ' . (!empty($coleta->descricao) ? format_text($coleta->descricao) : '--') . '</p>';
        $html .= '<p><strong>Disciplina:</strong> ' . $curso_nome . '</p>';  // Mostra o nome da disciplina aqui
        $html .= '<p><strong>Data de Início:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . '</p>';
        $html .= '<p><strong>Data de Fim:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_fim)) . '</p>';

    // Adiciona as informações de notificação
$html .= '<p><strong>Notificar Aluno:</strong> ' . ($coleta->notificar_alunos == 1 ? 'Sim' : 'Não') . '</p>';
$html .= '<p><strong>Receber Alerta:</strong> ' . ($coleta->receber_alerta == 1 ? 'Sim' : 'Não') . '</p>';


        // Botões CSV e JSON
        $html .= '<div class="button-group">';
        $html .= '<button class="btn btn-secondary" onclick="downloadCSV(' . $coleta->id . ');">';
        $html .= '<i class="fa fa-file-csv"></i> Baixar CSV';
        $html .= '</button>';

        $html .= '<button class="btn btn-secondary" onclick="downloadJSON(' . $coleta->id . ');">';
        $html .= '<i class="fa fa-file-json"></i> Baixar JSON';
        $html .= '</button>';
        $html .= '</div>'; // Fecha button-group

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

    // Adiciona a função JavaScript para download em JSON
    $html .= '<script>
        function downloadJSON(coletaId) {
            const downloadUrl = "Download.php?coleta_id=" + coletaId + "&format=json"; // Passa o formato como parâmetro
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
    
    // Método para baixar os dados da coleta em JSON
// Método para baixar os dados da coleta em JSON
public function download_json($coleta_id) {
    global $DB;

    // Consulta para obter os dados da coleta específica
    $sql = "SELECT nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
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

    // Define o cabeçalho do JSON
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $coleta->nome . '.json"');

    // Envia os dados como JSON formatado
    echo json_encode($coleta, JSON_PRETTY_PRINT);
    exit; // Finaliza o script
}


}
?>

<!-- CSS -->
<style>body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

/* Estilo do container do accordion */
.accordion {
    max-width: 700px; /* Alinhado ao quiz-container */
    margin: 20px auto;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
    background: #fff; /* Fundo branco */
}

/* Estilo de cada item do accordion */
.accordion-item {
    border-bottom: 1px solid #ddd; /* Linha entre itens */
}

/* Estilo do cabeçalho do accordion com cor mais neutra */
.accordion-header {
    background: #f0f0f0; /* Cinza claro em vez de azul */
    color: #333;
    padding: 12px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.accordion-header:hover {
    background: #d8f3dc; /* Verde claro ao passar o mouse, combinando com os botões */
}

/* Estilo do botão do accordion */
.accordion-button {
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    font-size: 15px; /* Fonte um pouco maior */
    color: #333;
}

/* Corpo do accordion */
.accordion-body {
    padding: 12px;
    background: #f9f9f9; /* Fundo cinza claro */
    transition: max-height 0.3s ease;
}

/* Margens nos parágrafos dentro do accordion */
.accordion-body p {
    margin: 8px 0;
    font-size: 14px;
    color: #333;
}

/* Estilo dos botões */
.button-group {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.btn {
    display: inline-flex;
    align-items: center;
    background-color: #4CAF50; /* Verde para combinar com o view.php */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #45a049; /* Hover verde mais escuro */
}

/* Ícones dos botões */
.btn .fa {
    margin-right: 8px;
}

.fa-file-json:before {
    content: "\f6c0";
}

/* Tamanho do ícone */
.fa {
    font-size: 14px;
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
