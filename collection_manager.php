<?php
class collection_manager
{

    public function get_coletas_by_professor($professor_id)
    {
        global $DB;

        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta , resource_id
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

        // Inclui o CSS inline
        $html = '<style>
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
            .btn-coleta {
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
            .btn-coleta:hover {
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
.card-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 300px;
    min-height: 200px; /* Define uma altura mínima */
    text-align: left;
    transition: transform 0.3s;
}

            .card:hover {
                transform: scale(1.05);
            }
            .card h3 {
                font-size: 18px;
                margin-bottom: 10px;
                color: #333;
            }
            .card p {
                margin: 5px 0;
                font-size: 14px;
                color: #555;
            }
            .card .btn-coleta {
                margin-top: 10px;
                background-color: #4CAF50;
                color: white;
                padding: 8px 16px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .card .btn-coleta:hover {
                background-color: #45a049;
            }
              .filter-container-coleta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin: 20px 0;
        padding: 10px 15px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap; /* Permite que os elementos se ajustem em telas menores */
    }
    .filter-container-coleta label {
        font-size: 16px;
        color: #333;
        font-weight: bold;
    }
    .filter-container-coleta input[type="text"] {
        padding: 8px 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: border-color 0.3s;
        background-color: #fff;
        color: #333;
        flex-grow: 1; /* Faz o input crescer para ocupar mais espaço */
        max-width: 250px; /* Limita o tamanho máximo do input */
    }
    .filter-container-coleta input[type="text"]:focus {
        border-color: #4CAF50;
        outline: none;
    }
    .filter-container-coleta select {
        padding: 8px 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: border-color 0.3s;
        background-color: #fff;
        color: #333;
    }
    .filter-container-coleta select:focus {
        border-color: #4CAF50;
        outline: none;
    }
    .filter-container-coleta button {
        padding: 8px 16px;
        font-size: 16px;
        color: white;
        background-color: #4CAF50;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .filter-container-coleta button:hover {
        background-color: #45a049;
    }
    .filter-container-coleta button:active {
        transform: scale(0.98);
    }
    .filter-container-coleta button .icon {
        font-size: 14px;
    }
                .btn-coleta,
.btn-coleta-ativo {
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
.btn-coleta-ativo:hover {
    background-color: #45a049;
}

        </style>';


        $html .= '<div class="filter-container-coleta">
                    <label for="searchBox">Buscar:</label>
                    <input type="text" id="searchBox" placeholder="Buscar por nome, disciplina, descrição, tipo de recurso..." onkeyup="filtrarColetas()">
                    
                    <label for="orderBy">Ordenar por:</label>
                    <select id="orderBy" onchange="ordenarColetas()">
                        <option value="nome">Nome da Coleta</option>
                        <option value="data_inicio">Data de Início</option>
                        <option value="data_fim">Data de Fim</option>
                        <option value="curso_nome">Disciplina</option>
                    </select>
                    <button id="orderDirection" onclick="toggleOrderDirection()">Ascendente <i class="icon fa fa-arrow-up"></i></button>
                </div>';

        $html .= '<div class="card-list" id="coletasContainer">';

        $coletas = $this->get_coletas_by_professor($professor_id);

        if (empty($coletas)) {
            return "<p>Nenhuma coleta cadastrada.</p>";
        }

        foreach ($coletas as $coleta) {
            $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
            $curso_nome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';
            $coleta->curso_nome = $curso_nome;

            // Busca o tipo e o nome do recurso/atividade
            $resource_info = '--';
            $module = $DB->get_record('course_modules', ['id' => $coleta->resource_id], 'module');

            if ($module) {
                $mod_info = $DB->get_record('modules', ['id' => $module->module], 'name');
                if ($mod_info) {
                    $resource_info = ucfirst($mod_info->name);
                }
            }

            $coleta->recurso_nome = $resource_info;

            $html .= '<div class="card" 
                         data-nome="' . format_string($coleta->nome) . '" 
                         data-data_inicio="' . $coleta->data_inicio . '" 
                         data-data_fim="' . $coleta->data_fim . '" 
                         data-curso_nome="' . $curso_nome . '" 
                         data-recurso_nome="' . $coleta->recurso_nome . '">
                        <h3>' . format_string($coleta->nome) . '</h3>
                        <p><strong>Disciplina:</strong> ' . $curso_nome . '</p>
                        <p><strong>Data de Início:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . '</p>
                        <p><strong>Data de Fim:</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_fim)) . '</p>
                        <button class="btn-coleta" onclick="abrirModal(' . $coleta->id . ')">Detalhes</button>
                     </div>';
        }

        $html .= '</div>';

        $html .= '<script>const coletasData = ' . json_encode(array_values($coletas)) . ';</script>';
        $html .= '<script>
            let isAscending = true;

            function toggleOrderDirection() {
                isAscending = !isAscending;
                const button = document.getElementById("orderDirection");
                button.innerText = isAscending ? "Ascendente " : "Descendente ";
                let icon = button.querySelector(".icon");
                if (!icon) {
                    icon = document.createElement("i");
                    icon.classList.add("icon");
                    button.appendChild(icon);
                }
                icon.className = isAscending ? "icon fa fa-arrow-up" : "icon fa fa-arrow-down";
                ordenarColetas();
            }

            function ordenarColetas() {
                const orderBy = document.getElementById("orderBy").value;
                const container = document.getElementById("coletasContainer");
                const cards = Array.from(container.getElementsByClassName("card"));

                cards.sort((a, b) => {
                    let valA = a.getAttribute("data-" + orderBy);
                    let valB = b.getAttribute("data-" + orderBy);

                    if (orderBy === "data_inicio" || orderBy === "data_fim") {
                        valA = new Date(valA);
                        valB = new Date(valB);
                    } else {
                        valA = valA.toLowerCase();
                        valB = valB.toLowerCase();
                    }

                    if (isAscending) {
                        return valA < valB ? -1 : valA > valB ? 1 : 0;
                    } else {
                        return valA > valB ? -1 : valA < valB ? 1 : 0;
                    }
                });

                container.innerHTML = "";
                cards.forEach(card => container.appendChild(card));
            }
function filtrarColetas() {
    const searchTerm = document.getElementById("searchBox").value.toLowerCase();
    const container = document.getElementById("coletasContainer");
    const cards = Array.from(container.getElementsByClassName("card"));

    cards.forEach(card => {
        const nome = card.getAttribute("data-nome")?.toLowerCase() || "";
        const cursoNome = card.getAttribute("data-curso_nome")?.toLowerCase() || "";
        const descricao = card.getAttribute("data-descricao")?.toLowerCase() || "";
        const recursoNome = card.getAttribute("data-recurso_nome")?.toLowerCase() || "";

        const matches = nome.includes(searchTerm) || 
                        cursoNome.includes(searchTerm) || 
                        descricao.includes(searchTerm) || 
                        recursoNome.includes(searchTerm);

        // Usa `visibility: hidden` para manter o layout e evitar lacunas
        card.style.visibility = matches ? "visible" : "hidden";
        card.style.position = matches ? "static" : "absolute";
    });
}




            function abrirModal(coletaId) {
                const coleta = coletasData.find(c => c.id == coletaId);
        
                document.getElementById("modalColetaNome").textContent = coleta.nome;
                document.getElementById("modalColetaDescricao").textContent = coleta.descricao ? coleta.descricao : "--";
                document.getElementById("modalColetaDisciplina").textContent = coleta.curso_nome ? coleta.curso_nome : "Disciplina não encontrada";
                document.getElementById("modalColetaInicio").textContent = new Date(coleta.data_inicio).toLocaleString();
                document.getElementById("modalColetaFim").textContent = new Date(coleta.data_fim).toLocaleString();
                document.getElementById("modalNotificarAlunos").textContent = coleta.notificar_alunos == 1 ? "Sim" : "Não";
                document.getElementById("modalReceberAlerta").textContent = coleta.receber_alerta == 1 ? "Sim" : "Não";
                document.getElementById("modalRecursoNome").textContent = coleta.recurso_nome;
    
                const coletaUrl = `${M.cfg.wwwroot}/blocks/ifcare/view.php?coletaid=${coleta.id}`;
                const modalColetaUrlElement = document.getElementById("modalColetaUrl");
                modalColetaUrlElement.href = coletaUrl;
                modalColetaUrlElement.textContent = coleta.nome;

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
        <p><strong>Preview Coleta:</strong> <a id="modalColetaUrl" href="#" target="_blank">Link da Coleta</a></p>
        <p><strong>Disciplina:</strong> <span id="modalColetaDisciplina"></span></p>
        <p><strong>Data de Início:</strong> <span id="modalColetaInicio"></span></p>
        <p><strong>Data de Fim:</strong> <span id="modalColetaFim"></span></p>
        <p><strong>Descrição:</strong> <span id="modalColetaDescricao"></span></p>
        <p><strong>Notificar Aluno:</strong> <span id="modalNotificarAlunos"></span></p>
        <p><strong>Receber Alerta:</strong> <span id="modalReceberAlerta"></span></p>
        <p><strong>Recurso/Atividade vinculado:</strong> <span id="modalRecursoNome"></span></p>
        <!-- Novo campo para o tipo de recurso -->

        <div class="button-group">
            <button id="downloadCSV" class="btn-coleta btn-coleta-secondary">
                <i class="fa fa-file-csv"></i> Baixar CSV
            </button>
            <button id="downloadJSON" class="btn-coleta btn-coleta-secondary">
                <i class="fa fa-file-code"></i> Baixar JSON
            </button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>