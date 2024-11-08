<?php
class collection_manager
{

    public function get_coletas_by_professor($professor_id)
    {
        global $DB;

        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
                FROM {ifcare_cadastrocoleta} 
                WHERE professor_id = :professor_id
                ORDER BY data_inicio DESC";

        $params = ['professor_id' => $professor_id];

        return $DB->get_records_sql($sql, $params);
    }

    private function obter_perguntas_associadas($coleta_id)
    {
        global $DB;

        $sql = "SELECT pergunta.id AS pergunta_id, 
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


    public function listar_coletas($professor_id)
    {
        global $DB;
    
        $coletas = $this->get_coletas_by_professor($professor_id);
    
        if (empty($coletas)) {
            return "<p>Nenhuma coleta cadastrada.</p>";
        }
    
        // Estrutura de cartões para exibir as coletas
        $html = '<div class="card-list">';
        foreach ($coletas as $coleta) {
            $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
            $curso_nome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';
            $coleta->curso_nome = $curso_nome;
    
            $html .= '<div class="card">';
            $html .= '<h3>' . format_string($coleta->nome) . '</h3>';
            $html .= '<p><strong>Disciplina:</strong> ' . $curso_nome . '</p>';
            $html .= '<p><strong>Data de Início:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . '</p>';
            $html .= '<p><strong>Data de Fim:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_fim)) . '</p>';
            $html .= '<button class="btn" onclick="abrirModal(' . $coleta->id . ')">Detalhes</button>';
            $html .= '</div>';
        }
        $html .= '</div>';
    
        // Script para manipular o modal e os downloads
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
    
            document.querySelector(".close").onclick = function () {
                document.getElementById("coletaModal").style.display = "none";
            };
    
            window.onclick = function (event) {
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
    

    public function download_csv($coleta_id)
    {
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


        $sql_respostas = "SELECT r.id, a.username AS usuario, a.email, p.id AS pergunta_id, p.pergunta_texto, r.resposta, r.data_resposta, 
        ra.roleid, role.shortname AS role_name
        FROM {ifcare_resposta} r
        JOIN {user} a ON a.id = r.usuario_id
        JOIN {ifcare_pergunta} p ON p.id = r.pergunta_id
        JOIN {role_assignments} ra ON ra.userid = a.id
        JOIN {role} role ON role.id = ra.roleid
        WHERE r.coleta_id = :coleta_id
        AND ra.contextid = :contextid";

        $context = context_course::instance($coleta->curso_id);
        $params['contextid'] = $context->id;

        $respostas = $DB->get_records_sql($sql_respostas, $params);

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

        fputcsv($output, ['ID da Pergunta', 'Classe AEQ', 'Emoção', 'Pergunta']);
        foreach ($perguntas as $pergunta) {
            fputcsv($output, [
                $pergunta->pergunta_id, 
                mb_convert_encoding($pergunta->nome_classe, 'UTF-8'),
                mb_convert_encoding($pergunta->emocao_nome, 'UTF-8'),
                mb_convert_encoding($pergunta->pergunta_texto, 'UTF-8')
            ]);
        }

        fputcsv($output, ['Usuario', 'Email', 'Role', 'ID da Pergunta', 'Resposta', 'Data de Resposta']);
        foreach ($respostas as $resposta) {
            fputcsv($output, [
                mb_convert_encoding($resposta->usuario, 'UTF-8'), 
                mb_convert_encoding($resposta->email, 'UTF-8'), 
                mb_convert_encoding($resposta->role_name, 'UTF-8'), 
                $resposta->pergunta_id, // ID da pergunta
                $resposta->resposta, // Resposta do aluno
                date('d/m/Y H:i', strtotime($resposta->data_resposta)) // Data da resposta
            ]);
        }

        fclose($output);
        exit;
    }

    public function download_json($coleta_id)
    {
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
    
        // Obtendo perguntas associadas
        $perguntas = $this->obter_perguntas_associadas($coleta_id);
    
        // Obtendo o contexto do curso
        $context = context_course::instance($coleta->curso_id);
    
        // Obtendo respostas dos alunos com função
        $sql_respostas = "SELECT r.id, a.username AS usuario, a.email, p.id AS pergunta_id, p.pergunta_texto, r.resposta, r.data_resposta, 
                          ra.roleid, role.shortname AS role_name
                          FROM {ifcare_resposta} r
                          JOIN {user} a ON a.id = r.usuario_id
                          JOIN {ifcare_pergunta} p ON p.id = r.pergunta_id
                          JOIN {role_assignments} ra ON ra.userid = a.id
                          JOIN {role} role ON role.id = ra.roleid
                          WHERE r.coleta_id = :coleta_id
                          AND ra.contextid = :contextid";
    
        $params['contextid'] = $context->id;
    
        $respostas = $DB->get_records_sql($sql_respostas, $params);
    
        ob_clean();
    
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $coleta->nome . '.json"');
    
        // Preparando os dados para o JSON
        $coleta_data = [
            'nome' => $coleta->nome,
            'data_inicio' => $coleta->data_inicio,
            'data_fim' => $coleta->data_fim,
            'descricao' => $coleta->descricao,
            'curso_nome' => $curso_nome,
            'notificar_alunos' => $coleta->notificar_alunos ? 'Sim' : 'Não',
            'receber_alerta' => $coleta->receber_alerta ? 'Sim' : 'Não',
            'perguntas' => [],
            'respostas' => []
        ];
    
        // Adicionando perguntas ao JSON
        foreach ($perguntas as $pergunta) {
            $coleta_data['perguntas'][] = [
                'id' => $pergunta->pergunta_id,
                'classe_aeq' => $pergunta->nome_classe,
                'emocao' => $pergunta->emocao_nome,
                'texto_pergunta' => $pergunta->pergunta_texto
            ];
        }
    
        // Adicionando respostas ao JSON
        foreach ($respostas as $resposta) {
            $coleta_data['respostas'][] = [
                'usuario' => $resposta->usuario,
                'email' => $resposta->email,
                'funcao' => $resposta->role_name, // Nome da função do usuário
                'id_pergunta' => $resposta->pergunta_id,
                'resposta' => $resposta->resposta,
                'data_resposta' => $resposta->data_resposta
            ];
        }
    
        echo json_encode($coleta_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
                <i class="fa fa-file-code"></i> Baixar JSON
            </button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.accordion-button').click(function () {
            $(this).find('i').toggleClass('fa-plus fa-minus');
        });
    });
</script>