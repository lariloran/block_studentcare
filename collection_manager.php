<?php
class collection_manager {

    public function get_coletas_by_professor($professor_id) {
        global $DB;

        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
                FROM {ifcare_cadastrocoleta} 
                WHERE professor_id = :professor_id
                ORDER BY data_inicio DESC";

        $params = ['professor_id' => $professor_id];

        return $DB->get_records_sql($sql, $params);
    }

    private function obter_perguntas_associadas($coleta_id) {
        global $DB;

        $sql = "SELECT CONCAT(assoc.id, '-', emocao.id, '-', pergunta.id) AS unique_id, 
                       classe.nome_classe, 
                       emocao.nome AS emocao_nome, 
                       pergunta.pergunta_texto
                FROM {ifcare_associacao_classe_emocao_coleta} assoc
                JOIN {ifcare_classeaeq} classe ON classe.id = assoc.classeaeq_id
                JOIN {ifcare_emocao} emocao ON emocao.id = assoc.emocao_id
                JOIN {ifcare_pergunta} pergunta ON pergunta.emocao_id = emocao.id
                WHERE assoc.cadastrocoleta_id = :coleta_id";

        $params = ['coleta_id' => $coleta_id];
        return $DB->get_records_sql($sql, $params);
    }

    public function listar_coletas($professor_id) {
        global $DB;

        $coletas = $this->get_coletas_by_professor($professor_id);

        if (empty($coletas)) {
            return "<p>Nenhuma coleta cadastrada.</p>";
        }

        $html = '<div class="accordion">';
        foreach ($coletas as $coleta) {
            $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
            $curso_nome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';
            $coleta->curso_nome = $curso_nome;

            $html .= '<div class="accordion-item">';
            $html .= '<div class="accordion-header">';
            $html .= '<button class="accordion-button" type="button" onclick="abrirModal(' . $coleta->id . ');" aria-expanded="false">';
            $html .= '<i class="fa fa-plus"></i> ' . format_string($coleta->nome) . ' - (' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . ')';
            $html .= '</button>';
            $html .= '</div>';

            $html .= '<div id="coleta' . $coleta->id . '" class="collapse accordion-body">';
            $html .= '<p><strong>Descrição:</strong> ' . (!empty($coleta->descricao) ? format_text($coleta->descricao) : '--') . '</p>';
            $html .= '<p><strong>Disciplina:</strong> ' . $curso_nome . '</p>';
            $html .= '<p><strong>Data de Início:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . '</p>';
            $html .= '<p><strong>Data de Fim:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_fim)) . '</p>';
            $html .= '<p><strong>Notificar Aluno:</strong> ' . ($coleta->notificar_alunos == 1 ? 'Sim' : 'Não') . '</p>';
            $html .= '<p><strong>Receber Alerta:</strong> ' . ($coleta->receber_alerta == 1 ? 'Sim' : 'Não') . '</p>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '<script>const coletasData = ' . json_encode(array_values($coletas)) . ';</script>';
        $html .= '<script>
            function abrirModal(coletaId) {
                const coleta = coletasData.find(c => c.id == coletaId);
                
                document.getElementById("modalColetaNome").textContent = coleta.nome;
                document.getElementById("modalColetaDescricao").textContent = coleta.descricao ? coleta.descricao : "--";
                document.getElementById("modalColetaDisciplina").textContent = coleta.curso_nome ? coleta.curso_nome : "Disciplina não encontrada";
                document.getElementById("modalColetaInicio").textContent = new Date(coleta.data_inicio).toLocaleString();
                document.getElementById("modalColetaFim").textContent = new Date(coleta.data_fim).toLocaleString();
                document.getElementById("modalNotificarAlunos").textContent = coleta.notificar_alunos == 1 ? "Sim" : "Não";
                document.getElementById("modalReceberAlerta").textContent = coleta.receber_alerta == 1 ? "Sim" : "Não";

                document.getElementById("downloadCSV").setAttribute("data-id", coleta.id);
                document.getElementById("downloadJSON").setAttribute("data-id", coleta.id);

                document.getElementById("coletaModal").style.display = "block";
            }

            document.querySelector(".close").onclick = function() {
                document.getElementById("coletaModal").style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == document.getElementById("coletaModal")) {
                    document.getElementById("coletaModal").style.display = "none";
                }
            };

            document.getElementById("downloadCSV").onclick = function() {
                const coletaId = this.getAttribute("data-id");
                const downloadUrl = "download.php?coleta_id=" + coletaId + "&format=csv";
                window.location.href = downloadUrl;
            };

            document.getElementById("downloadJSON").onclick = function() {
                const coletaId = this.getAttribute("data-id");
                const downloadUrl = "download.php?coleta_id=" + coletaId + "&format=json";
                window.location.href = downloadUrl;
            };
        </script>';

        return $html;
    }

    public function download_csv($coleta_id) {
        global $DB;

        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
                FROM {ifcare_cadastrocoleta} 
                WHERE id = :coleta_id";
        $params = ['coleta_id' => $coleta_id];
        $coleta = $DB->get_record_sql($sql, $params);

        $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
        $curso_nome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';

        if (!$coleta) {
            echo "Coleta não encontrada.";
            return;
        }

        $perguntas = $this->obter_perguntas_associadas($coleta_id);

        ob_clean();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . mb_convert_encoding($coleta->nome, 'UTF-8') . '.csv"');

        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");

        fputcsv($output, ['Nome', 'Data de Início', 'Data de Fim', 'Descrição', 'Disciplina', 'Notificar Aluno', 'Receber Alerta']);
        fputcsv($output, [
            mb_convert_encoding($coleta->nome, 'UTF-8'),
            date('d/m/Y H:i', strtotime($coleta->data_inicio)),
            date('d/m/Y H:i', strtotime($coleta->data_fim)),
            mb_convert_encoding($coleta->descricao, 'UTF-8'),
            $curso_nome,
            $coleta->notificar_alunos ? 'Sim' : 'Não',
            $coleta->receber_alerta ? 'Sim' : 'Não'
        ]);

        fputcsv($output, ['Classe AEQ', 'Emoção', 'Pergunta']);
        foreach ($perguntas as $pergunta) {
            fputcsv($output, [
                mb_convert_encoding($pergunta->nome_classe, 'UTF-8'),
                mb_convert_encoding($pergunta->emocao_nome, 'UTF-8'),
                mb_convert_encoding($pergunta->pergunta_texto, 'UTF-8')
            ]);
        }

        fclose($output);
        exit;
    }

public function download_json($coleta_id) {
    global $DB;

    $sql = "SELECT nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
            FROM {ifcare_cadastrocoleta} 
            WHERE id = :coleta_id";

    $params = ['coleta_id' => $coleta_id];
    $coleta = $DB->get_record_sql($sql, $params);

    if (!$coleta) {
        echo "Coleta não encontrada.";
        return;
    }

    $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
    $curso_nome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';

    $perguntas = $this->obter_perguntas_associadas($coleta_id);

    ob_clean();

    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $coleta->nome . '.json"');

    $coleta->curso_nome = $curso_nome;
    $coleta->perguntas = $perguntas;

    echo json_encode($coleta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

}
?>

<div id="coletaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalColetaNome"></h2>
        <p><strong>Descrição:</strong> <span id="modalColetaDescricao"></span></p>
        <p><strong>Disciplina:</strong> <span id="modalColetaDisciplina"></span></p>
        <p><strong>Data de Início:</strong> <span id="modalColetaInicio"></span></p>
        <p><strong>Data de Fim:</strong> <span id="modalColetaFim"></span></p>
        <p><strong>Notificar Aluno:</strong> <span id="modalNotificarAlunos"></span></p>
        <p><strong>Receber Alerta:</strong> <span id="modalReceberAlerta"></span></p>

        <div class="button-group">
            <button id="downloadCSV" class="btn btn-secondary">
                <i class="fa fa-file-csv"></i> Baixar CSV
            </button>
            <button id="downloadJSON" class="btn btn-secondary">
                <i class="fa fa-file-json"></i> Baixar JSON
            </button>
        </div>
    </div>
</div>

<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

.accordion {
    max-width: 700px;
    margin: 20px auto;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background: #fff;
}

.accordion-item {
    border-bottom: 1px solid #ddd;
}

.accordion-header {
    background: #f0f0f0;
    color: #333;
    padding: 12px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.accordion-header:hover {
    background: #d8f3dc;
}

.accordion-button {
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    font-size: 15px;
    color: #333;
}

.accordion-body {
    padding: 12px;
    background: #f9f9f9;
    transition: max-height 0.3s ease;
}

.accordion-body p {
    margin: 8px 0;
    font-size: 14px;
    color: #333;
}

.btn {
    display: inline-flex;
    align-items: center;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #45a049;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.accordion-button').click(function () {
            $(this).find('i').toggleClass('fa-plus fa-minus');
        });
    });
</script>
