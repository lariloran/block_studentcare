<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Collection Manager
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class collection_manager {

    //Busca todas as coletas das disciplinas onde o usuário é professor.
    public function excluir_coleta($coletaid) {
        global $DB, $CFG;

        $transaction = $DB->start_delegated_transaction();

        try {
            $resourceidinstance = $DB->get_field('studentcare_cadastrocoleta', 'resource_id', ['id' => $coletaid]);

            if ($resourceidinstance) {
                // Busca diretamente o ID em `course_modules` onde `instance` é igual ao `resource_id`.
                $course_module_id = $DB->get_field('course_modules', 'id', ['instance' => $resourceidinstance]);

                if ($coursemoduleid) {
                    require_once($CFG->dirroot . '/course/lib.php');
                    course_delete_module($course_module_id);
                }
            }


            $DB->delete_records('studentcare_resposta', ['coleta_id' => $coletaid]);

            $DB->delete_records('studentcare_associacao_classe_emocao_coleta', ['cadastrocoleta_id' => $coletaid]);

            $DB->delete_records('studentcare_cadastrocoleta', ['id' => $coletaid]);

            $transaction->allow_commit();
        } catch (Exception $e) {
            $transaction->rollback($e);
            throw $e;
        }
    }

    public function listar_coletas($usuarioid) {
        global $DB, $CFG, $PAGE;
        require_once($CFG->dirroot . '/course/lib.php');

        $html = '<style>

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
                background-color: rgba(0, 0, 0, 0.5);
                overflow-y: auto; /* Permite scroll para toda a janela, se necessário */
                padding-top: 20px; /* Adiciona um espaçamento superior geral */
            }

            .modal-content {
                position: relative;
                background-color: white;
                margin: 50px auto; /* Define uma margem superior mínima */
                padding: 30px;
                border-radius: 15px;
                width: 90%; /* Aumenta a largura para ocupar 90% da tela */
                max-width: 800px; /* Aumenta a largura máxima */
                max-height: 90vh; /* Limita a altura máxima */
                overflow-y: auto; /* Adiciona scroll para conteúdo longo */
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
            }

            .modal-content h2 {
                font-size: 24px;
                color: #333;
                margin-bottom: 15px;
                text-align: center;
                max-width: 90%; /* Máximo de 90% da largura da janela */
                max-height: 80%; /* Máximo de 80% da altura da janela */
                overflow-y: auto; /* Adiciona rolagem se o conteúdo for muito longo */
            }

            .modal-content span#modalColetaDescricao {
                word-wrap: break-word; /* Força a quebra de palavras longas */
                overflow-wrap: break-word; /* Garante suporte adicional para quebra de palavras */
                white-space: pre-wrap; /* Preserva quebras de linha no texto original */
                display: block; /* Garante que o texto ocupe o espaço do elemento */
                max-height: 200px; /* Define uma altura máxima para a descrição */
                overflow-y: auto; /* Adiciona rolagem se o conteúdo exceder o limite */
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
                padding: 16px; /* Reduz o padding para economizar espaço */
                max-width: 250px; /* Diminui a largura máxima */
                min-height: 180px; /* Ajusta a altura mínima */
                text-align: left;
                transition: transform 0.3s;
                font-size: 14px; /* Reduz o tamanho do texto */
                line-height: 1.4; /* Ajusta o espaçamento entre linhas */
            }

            .card:hover {
                transform: scale(1.05);
            }

            .card h3 {
                font-size: 16px; /* Reduz o tamanho do título */
                margin-bottom: 8px;
                color: #333;
                
            }

            .card p {
                margin: 4px 0; /* Diminui o espaçamento entre os parágrafos */
                font-size: 13px; /* Reduz o texto das informações */
                color: #555;
                white-space: nowrap;
                overflow: hidden; /* Oculta o texto excedente */
                text-overflow: ellipsis; /* Adiciona reticências no final do texto */
            }

            .card .btn-coleta {
                width: 100%; /* Faz o botão ocupar toda a largura do card */
                text-align: center; /* Centraliza o texto no botão */
                display: block; /* Garante que o botão seja um elemento de bloco */
                margin-top: auto; /* Faz o botão alinhar-se ao final do card */
                padding: 8px 12px; /* Reduz o padding para diminuir a altura */
                font-size: 14px; /* Ajusta o tamanho do texto para harmonizar */
                border-radius: 4px; /* Mantém bordas arredondadas, mas sutis */
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


            .pagination-controls {
                position: relative; /* Ajuste conforme necessário */
                text-align: center;
                margin: 20px 0;
            }

            .pagination-controls button {
                margin: 5px;
                padding: 10px 15px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .pagination-controls button:hover {
                background-color: #45a049;
            }

            .pagination-controls button.btn-coleta-ativo {
                background-color: #2E7D32; /* Cor diferenciada para página ativa */
                cursor: default;
            }
            .button-group {
                display: flex; /* Coloca os itens em linha */
                flex-wrap: wrap; /* Permite quebrar para a próxima linha se o espaço não for suficiente */
                gap: 10px; /* Espaçamento entre os botões */
                justify-content: center; /* Alinha os botões no centro do modal */
                margin-top: 20px; /* Espaçamento superior */
            }

        </style>';

        $html .= '<div class="filter-container-coleta">
        <label for="searchBox"><strong>' . get_string('search_label', 'block_studentcare') . ':</strong></label>
        <input type="text" id="searchBox" placeholder="' . get_string('search_placeholder', 'block_studentcare') . '" onkeyup="filtrarColetas()">
    
        <label for="orderBy"><strong>' . get_string('order_by_label', 'block_studentcare') . ':</strong></label>
        <select id="orderBy" onchange="ordenarColetas()">
            <option value="data_criacao">' . get_string('order_by_creation_date', 'block_studentcare') . '</option>
            <option value="nome">' . get_string('order_by_collection_name', 'block_studentcare') . '</option>
            <option value="data_inicio">' . get_string('order_by_start_date', 'block_studentcare') . '</option>
            <option value="data_fim">' . get_string('order_by_end_date', 'block_studentcare') . '</option>
            <option value="curso_nome">' . get_string('order_by_course', 'block_studentcare') . '</option>
        </select>
    
        <button id="orderDirection" onclick="toggleOrderDirection()">' . get_string('ascending', 'block_studentcare') . ' <i class="icon fa fa-arrow-up"></i></button>
    
        <label for="pageSize"><strong>' . get_string('show_label', 'block_studentcare') . ':</strong></label>
        <select id="pageSize" onchange="atualizarPaginacao()">
            <option value="5">' . get_string('show_5_per_page', 'block_studentcare') . '</option>
            <option value="10" selected>' . get_string('show_10_per_page', 'block_studentcare') . '</option>
            <option value="15">' . get_string('show_15_per_page', 'block_studentcare') . '</option>
            <option value="20">' . get_string('show_20_per_page', 'block_studentcare') . '</option>
        </select>
    </div>
    ';

        $html .= '<div class="card-list" id="coletasContainer">';

        $html .= '<div class="card" style="text-align: center; cursor: pointer;" onclick="window.location.href=\'' . new moodle_url('/blocks/studentcare/register.php') . '\'">
        <h3 style="font-size: 50px; color: #4CAF50; margin: 20px 0;">
            <i class="fa fa-plus-circle"></i>
        </h3>
        <p style="font-size: 18px; font-weight: bold; color: #333;">' . get_string('new_collection', 'block_studentcare') . '</p>
    </div>';


        $coletas = $this->get_coletas_by_professor($usuarioid);

        if (!empty($coletas)) {
            foreach ($coletas as $coleta) {
                $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
                $cursonome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';
                $coleta->curso_nome = $cursonome;

                $resourceinfo = '--';
                $resourcename = '--';
                $sectionname = '--';

                $module = $DB->get_record('course_modules', ['id' => $coleta->resource_id_atrelado], 'module');
                if ($module) {
                    $modinfo = $DB->get_record('modules', ['id' => $module->module], 'name');
                    if ($modinfo) {
                        $resourceinfo = ucfirst($modinfo->name);
                    }
                    $resourcename_record = $DB->get_record('course_modules', ['id' => $coleta->resource_id_atrelado], 'id, instance');
                    if ($resourcename_record) {
                        $resourcename = $DB->get_field($modinfo->name, 'name', ['id' => $resourcename_record->instance]);
                    }
                }

                $sectionname = get_section_name($coleta->curso_id, $coleta->section_id);


                $coleta->recurso_nome = $resourceinfo;
                $coleta->resource_name = $resourcename;
                $coleta->section_name = $sectionname;

                $html .= '<div class="card" 
                data-id="' . $coleta->id . '" 
                data-nome="' . format_string($coleta->nome) . '" 
                data-data_inicio="' . $coleta->data_inicio . '" 
                data-data_fim="' . $coleta->data_fim . '" 
                data-data_criacao="' . $coleta->data_criacao . '" 
                data-curso_nome="' . $cursonome . '" 
                data-recurso_nome="' . $coleta->recurso_nome . '" 
                data-resource_name="' . format_string($coleta->resource_name) . '" 
                data-section_name="' . format_string($coleta->section_name) . '">
                <h3>' . format_string(mb_strimwidth($coleta->nome, 0, 40, "...")) . '</h3>
                <p><strong>' . get_string('course', 'block_studentcare') . ':</strong> ' . $cursonome . '</p>
                <p><strong>' . get_string('start_date', 'block_studentcare') . ':</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . '</p>
                <p><strong>' . get_string('end_date', 'block_studentcare') . ':</strong> ' . date('d/m/Y H:i', strtotime($coleta->data_fim)) . '</p>
                <button class="btn-coleta" onclick="abrirModal(' . $coleta->id . ')"><i class="fa fa-info-circle"></i> ' . get_string('details', 'block_studentcare') . '</button>
             </div>';
            }
        }

        $html .= '</div>';

        $html .= '<div id="paginationControls" class="pagination-controls"></div>'; // Mova o container para o final

        $html .= '<script>const coletasData = ' . json_encode(array_values($coletas)) . ';</script>';
        $html .= '<script>
            let isAscending = true;

            let currentPage = 1;

            function atualizarPaginacao() {
                currentPage = 1; // Reseta para a primeira página ao mudar o tamanho
                renderizarPaginacao();
            }

            function renderizarPaginacao() {
                const pageSize = parseInt(document.getElementById("pageSize").value);
                const cards = Array.from(document.querySelectorAll("#coletasContainer .card"))
                    .filter(card => card.hasAttribute("data-id")); // Exclui o card de Nova Coleta da paginação
                const totalCards = cards.length;
                const totalPages = Math.ceil(totalCards / pageSize);

                // Oculta todos os cards exceto o card de Nova Coleta
                document.querySelectorAll("#coletasContainer .card").forEach(card => {
                    if (!card.hasAttribute("data-id")) {
                        card.style.display = "block"; // Mantém o card de Nova Coleta visível
                    } else {
                        card.style.display = "none"; // Oculta os demais cards inicialmente
                    }
                });

                // Exibe os cards da página atual
                const start = (currentPage - 1) * pageSize;
                const end = start + pageSize;

                cards.slice(start, end).forEach(card => {
                    card.style.display = "block"; // Exibe os cards relevantes da página atual
                });

                // Renderiza os controles de paginação
                renderizarControlesPaginacao(totalPages);
            }


            function renderizarControlesPaginacao(totalPages) {
                const container = document.getElementById("paginationControls");
                if (!container) return;

                container.innerHTML = ""; // Limpa os controles anteriores

                // Adiciona os botões de página
                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement("button");
                    button.textContent = i;
                    button.classList.add("btn-coleta");
                    if (i === currentPage) button.classList.add("btn-coleta-ativo");
                    button.addEventListener("click", () => {
                        currentPage = i;
                        renderizarPaginacao();
                    });
                    container.appendChild(button);
                }
            }


            document.addEventListener("DOMContentLoaded", function () {
                renderizarPaginacao(); // Renderiza a paginação ao carregar a página
            });

            function toggleOrderDirection() {
                const translations = {
                ascending: "' . get_string('ascending', 'block_studentcare') . '",
                descending: "' . get_string('descending', 'block_studentcare') . '"
            };

                isAscending = !isAscending;
                const button = document.getElementById("orderDirection");
                button.innerText = isAscending ? translations.ascending + " " : translations.descending + " ";
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
                    let valA = a.getAttribute("data-" + orderBy) || "";
                    let valB = b.getAttribute("data-" + orderBy) || "";

            if (orderBy === "data_inicio" || orderBy === "data_fim" || orderBy === "data_criacao") {
                valA = new Date(valA);
                valB = new Date(valB);
            }
            else {
                        // Transforma valores para lower case para comparação consistente de strings
                        valA = valA.toString().toLowerCase();
                        valB = valB.toString().toLowerCase();
                    }

                    if (isAscending) {
                        return valA < valB ? -1 : valA > valB ? 1 : 0;
                    } else {
                        return valA > valB ? -1 : valA < valB ? 1 : 0;
                    }
                });

                // Limpa o container e reaplica os cards na nova ordem
                container.innerHTML = "";
                cards.forEach(card => container.appendChild(card));

                renderizarPaginacao();
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

                renderizarPaginacao();
            }


            function abrirModal(coletaId) {
                const coleta = coletasData.find(c => c.id == coletaId);
                const modalDisciplina = document.getElementById("modalColetaDisciplina");

                document.getElementById("modalColetaNome").textContent = coleta.nome;
                document.getElementById("modalColetaDescricao").textContent = coleta.descricao ? coleta.descricao : "--";
                if (coleta.curso_id && coleta.curso_nome) {
                    modalDisciplina.textContent = coleta.curso_nome;
                    modalDisciplina.href = `${M.cfg.wwwroot}/course/view.php?id=${coleta.curso_id}`;
                } else {
                    modalDisciplina.textContent = "Disciplina não encontrada";
                    modalDisciplina.href = "#";
                }               
                document.getElementById("modalColetaInicio").textContent = new Date(coleta.data_inicio).toLocaleString();
                document.getElementById("modalColetaFim").textContent = new Date(coleta.data_fim).toLocaleString();
                document.getElementById("modalNotificarAlunos").textContent = coleta.notificar_alunos == 1 ? "' .
                    get_string('yes', 'block_studentcare') . '" : "' . get_string('no', 'block_studentcare') . '";
                document.getElementById("modalReceberAlerta").textContent = coleta.receber_alerta == 1 ? "' .
                    get_string('yes', 'block_studentcare') . '" : "' . get_string('no', 'block_studentcare') . '";
                document.getElementById("modalResourceName").textContent = coleta.resource_name;
                document.getElementById("modalSectionName").textContent = coleta.section_name;
                $.ajax({
                    url: `${M.cfg.wwwroot}/blocks/studentcare/get_associated_class_emotions.php`,
                    type: "GET",
                    data: { coleta_id: coletaId },
                    success: function (response) {
                        // Verifica se a resposta está vazia ou contém mensagens específicas
                        if (response.trim() === "<p>Nenhuma emoção ou classe AEQ cadastrada para esta coleta.</p>") {
                            document.getElementById("modalEmocoes").innerHTML = response; // Exibe a mensagem amigável
                        } else if (response.trim() === "") {
                            document.getElementById("modalEmocoes").innerHTML = "<p>Erro: Nenhuma resposta recebida.</p>";
                        } else {
                            document.getElementById("modalEmocoes").innerHTML = response; // Insere o conteúdo retornado
                        }
                    },
                    error: function () {
                        // Exibe mensagem de erro apenas para problemas reais de requisição
                        document.getElementById("modalEmocoes").innerHTML = "<p>Erro ao carregar emoções e classes AEQ.</p>";
                    }
                });

                const coletaUrl = `${M.cfg.wwwroot}/blocks/studentcare/view.php?coletaid=${coleta.id}`;
                const modalColetaUrlElement = document.getElementById("modalColetaUrl");
                modalColetaUrlElement.href = coletaUrl;
                modalColetaUrlElement.textContent = coleta.nome;

                document.getElementById("downloadCSV").setAttribute("data-id", coleta.id);
                document.getElementById("downloadJSON").setAttribute("data-id", coleta.id);
        
                // Atualiza o botão de exclusão no modal
                const deleteButton = document.getElementById("deleteColeta");
                deleteButton.setAttribute("data-id", coleta.id);
                deleteButton.setAttribute("data-name", coleta.nome);

                const modal = document.getElementById("coletaModal");
                modal.style.display = "block";
                    adicionarEventosFechamento(modal);

            }
    
            function adicionarEventosFechamento(modal) {
                // Fecha o modal ao clicar no "x"
                modal.querySelector(".close").onclick = function () {
                    modal.style.display = "none";
                };

                // Fecha o modal ao clicar fora do conteúdo
                modal.addEventListener("click", function (event) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });
            }

            document.getElementById("downloadCSV").onclick = function() {
            const coletaId = this.getAttribute("data-id");
            const downloadUrl = "Download.php?coleta_id=" + coletaId + "&format=csv";
            window.location.href = downloadUrl;
            };

            document.getElementById("downloadJSON").onclick = function() {
                const coletaId = this.getAttribute("data-id");
                const downloadUrl = "Download.php?coleta_id=" + coletaId + "&format=json";
                window.location.href = downloadUrl;
            };

            
            function abrirGrafico() {
                const coletaId = document.getElementById("modalColetaUrl").getAttribute("href").split("=").pop();
                window.location.href = M.cfg.wwwroot + "/blocks/studentcare/report.php?coletaid=" + coletaId;
            }



            function fecharModalDetalhe() {
                document.getElementById("coletaModal").style.display = "none";
            }


            window.onclick = function(event) {
                if (event.target == document.getElementById("confirmDeleteModal")) {
                    fecharConfirmacao();
                }
            }

            function editarColeta() {
                const coletaId = document.getElementById("modalColetaUrl").getAttribute("href").split("=").pop();
                window.location.href = M.cfg.wwwroot + "/blocks/studentcare/edit.php?coletaid=" + coletaId;  
                // Redireciona para edit_form.php com o ID da coleta
            }

        </script>';


        return $html;
    }

    public function get_coletas_by_professor($usuarioid) {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/lib/accesslib.php');

        $sql = "SELECT DISTINCT c.id, c.nome, c.data_inicio, c.data_fim, c.descricao, 
                                    c.curso_id, c.notificar_alunos, c.receber_alerta, 
                                    c.resource_id_atrelado, c.section_id, c.data_criacao
                    FROM {studentcare_cadastrocoleta} c
                    JOIN {context} ctx ON ctx.instanceid = c.curso_id
                    JOIN {role_assignments} ra ON ra.contextid = ctx.id
                    JOIN {role} r ON r.id = ra.roleid
                    WHERE ctx.contextlevel = :context_course_level
                      AND (c.usuario_id = :usuario_id_cadastro OR 
                           (ra.userid = :usuario_id_professor AND r.shortname = :role_teacher))
                    ORDER BY c.data_criacao DESC";

        $params = ['context_course_level' => CONTEXT_COURSE, 'usuario_id_cadastro' => $usuarioid, 'usuario_id_professor' => $usuarioid, 'role_teacher' => 'editingteacher',];

        return $DB->get_records_sql($sql, $params);
    }

    public function download_csv($coletaid) {
        global $DB;

        $sql = "SELECT id, nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
                FROM {studentcare_cadastrocoleta} 
                WHERE id = :coleta_id";
        $params = ['coleta_id' => $coletaid];
        $coleta = $DB->get_record_sql($sql, $params);

        $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
        $cursonome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';

        if (!$coleta) {
            echo "Coleta não encontrada.";
            return;
        }

        $perguntas = $this->obter_perguntas_associadas($coletaid);


        $sql_respostas = "SELECT r.id, a.username AS usuario, a.email, p.id AS pergunta_id, p.pergunta_texto, r.resposta,
            r.data_resposta, 
        ra.roleid, role.shortname AS role_name
        FROM {studentcare_resposta} r
        JOIN {user} a ON a.id = r.usuario_id
        JOIN {studentcare_pergunta} p ON p.id = r.pergunta_id
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
        fputcsv($output, [mb_convert_encoding($coleta->nome, 'UTF-8'),
            date('d/m/Y H:i', strtotime($coleta->data_inicio)),
            date('d/m/Y H:i', strtotime($coleta->data_fim)),
            mb_convert_encoding($coleta->descricao, 'UTF-8'),
            $cursonome, $coleta->notificar_alunos ? get_string('yes', 'moodle') : get_string('no', 'block_studentcare'),
            $coleta->receber_alerta ? get_string('yes', 'moodle') : get_string('no', 'block_studentcare')

        ]);

        fputcsv($output, ['ID da Pergunta', 'Classe AEQ', 'Emoção', 'Pergunta']);
        foreach ($perguntas as $pergunta) {
            fputcsv($output, [$pergunta->pergunta_id, mb_convert_encoding($pergunta->nome_classe, 'UTF-8'),
                mb_convert_encoding($pergunta->emocao_nome, 'UTF-8'), !empty($pergunta->pergunta_texto) &&
                get_string_manager()->string_exists($pergunta->pergunta_texto, 'block_studentcare') ?
                    mb_convert_encoding(get_string($pergunta->pergunta_texto, 'block_studentcare'), 'UTF-8') :
                    mb_convert_encoding('Texto não definido', 'UTF-8') // Texto padrão
            ]);
        }

        fputcsv($output, ['Usuario', 'Email', 'Role', 'ID da Pergunta', 'Resposta', 'Data de Resposta']);
        foreach ($respostas as $resposta) {
            fputcsv($output, [mb_convert_encoding($resposta->usuario, 'UTF-8'),
                mb_convert_encoding($resposta->email, 'UTF-8'),
                mb_convert_encoding($resposta->role_name, 'UTF-8'), $resposta->pergunta_id, $resposta->resposta,
                date('d/m/Y H:i', strtotime($resposta->data_resposta))]);
        }

        fclose($output);
        exit;
    }

    private function obter_perguntas_associadas($coletaid) {
        global $DB;

        $sql = "SELECT pergunta.id AS pergunta_id, 
                       classe.nome_classe, 
                       emocao.nome AS emocao_nome, 
                       pergunta.pergunta_texto
                FROM {studentcare_associacao_classe_emocao_coleta} assoc
                JOIN {studentcare_classeaeq} classe ON classe.id = assoc.classeaeq_id
                JOIN {studentcare_emocao} emocao ON emocao.id = assoc.emocao_id
                JOIN {studentcare_pergunta} pergunta ON pergunta.emocao_id = emocao.id
                WHERE assoc.cadastrocoleta_id = :coleta_id";

        $params = ['coleta_id' => $coletaid];
        return $DB->get_records_sql($sql, $params);
    }

    public function download_json($coletaid) {
        global $DB;

        $sql = "SELECT nome, data_inicio, data_fim, descricao, curso_id, notificar_alunos, receber_alerta 
                FROM {studentcare_cadastrocoleta} 
                WHERE id = :coleta_id";

        $params = ['coleta_id' => $coletaid];
        $coleta = $DB->get_record_sql($sql, $params);

        if (!$coleta) {
            echo "Coleta não encontrada.";
            return;
        }

        $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
        $cursonome = $curso ? format_string($curso->fullname) : 'Disciplina não encontrada';

        $perguntas = $this->obter_perguntas_associadas($coletaid);

        $context = context_course::instance($coleta->curso_id);

        $sql_respostas = "SELECT r.id, a.username AS usuario, a.email, p.id AS pergunta_id, p.pergunta_texto, r.resposta,
                            r.data_resposta, ra.roleid, role.shortname AS role_name
                          FROM {studentcare_resposta} r
                          JOIN {user} a ON a.id = r.usuario_id
                          JOIN {studentcare_pergunta} p ON p.id = r.pergunta_id
                          JOIN {role_assignments} ra ON ra.userid = a.id
                          JOIN {role} role ON role.id = ra.roleid
                          WHERE r.coleta_id = :coleta_id
                          AND ra.contextid = :contextid";

        $params['contextid'] = $context->id;

        $respostas = $DB->get_records_sql($sql_respostas, $params);

        ob_clean();

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $coleta->nome . '.json"');

        $coleta_data = ['nome' => $coleta->nome, 'data_inicio' => $coleta->data_inicio, 'data_fim' => $coleta->data_fim,
            'descricao' => $coleta->descricao, 'curso_nome' => $cursonome,
            'notificar_alunos' => $coleta->notificar_alunos ? get_string('yes', 'block_studentcare') :
                get_string('no', 'block_studentcare'),
            'receber_alerta' => $coleta->receber_alerta ? get_string('yes', 'block_studentcare') :
                get_string('no', 'block_studentcare'), 'perguntas' => [], 'respostas' => []];

        foreach ($perguntas as $pergunta) {
            $texto_pergunta = (!empty($pergunta->pergunta_texto) && get_string_manager()->string_exists($pergunta->pergunta_texto,
                    'block_studentcare')) ? get_string($pergunta->pergunta_texto, 'block_studentcare') : 'Texto não definido';
            // Fallback para texto padrão

            $coleta_data['perguntas'][] = ['id' => $pergunta->pergunta_id, 'classe_aeq' => $pergunta->nome_classe,
                'emocao' => $pergunta->emocao_nome, 'texto_pergunta' => $texto_pergunta];
        }


        foreach ($respostas as $resposta) {
            $coleta_data['respostas'][] = ['usuario' => $resposta->usuario, 'email' => $resposta->email,
                'funcao' => $resposta->role_name, 'id_pergunta' => $resposta->pergunta_id, 'resposta' => $resposta->resposta,
                'data_resposta' => $resposta->data_resposta];
        }

        echo json_encode($coleta_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function obter_emocoes_e_classes($coletaid) {
        global $DB;

        $sql = "SELECT 
                    classe.nome_classe, 
                    GROUP_CONCAT(DISTINCT emocao.nome ORDER BY emocao.nome SEPARATOR ', ') AS emocoes
                FROM {studentcare_associacao_classe_emocao_coleta} assoc
                JOIN {studentcare_classeaeq} classe ON classe.id = assoc.classeaeq_id
                JOIN {studentcare_emocao} emocao ON emocao.id = assoc.emocao_id
                WHERE assoc.cadastrocoleta_id = :coleta_id
                GROUP BY classe.id, classe.nome_classe
                ORDER BY FIELD(classe.id, 1, 2, 3), classe.nome_classe";

        $params = ['coleta_id' => $coletaid];
        return $DB->get_records_sql($sql, $params);
    }


}

?>

<div id="coletaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalColetaNome"></h2>
        <p><strong><?php echo get_string('preview_coleta', 'block_studentcare'); ?>:</strong>
            <a id="modalColetaUrl" href="#" target="_blank"><?php echo get_string('link_coleta', 'block_studentcare'); ?></a>
        </p>
        <p><strong><?php echo get_string('disciplina', 'block_studentcare'); ?>:</strong>
            <a id="modalColetaDisciplina" href="#" target="_blank" style="color: #0073AA; text-decoration: none;"></a>
        </p>
        <p><strong><?php echo get_string('data_inicio', 'block_studentcare'); ?>:</strong> <span id="modalColetaInicio"></span></p>
        <p><strong><?php echo get_string('data_fim', 'block_studentcare'); ?>:</strong> <span id="modalColetaFim"></span></p>
        <p><strong><?php echo get_string('nome_secao_vinculada', 'block_studentcare'); ?>:</strong> <span
                    id="modalSectionName"></span></p>
        <p><strong><?php echo get_string('nome_atividade_recurso_vinculado', 'block_studentcare'); ?>:</strong> <span
                    id="modalResourceName"></span></p>
        <p><strong><?php echo get_string('notificar_aluno', 'block_studentcare'); ?>:</strong> <span
                    id="modalNotificarAlunos"></span></p>
        <p><strong><?php echo get_string('receber_alerta', 'block_studentcare'); ?>:</strong> <span id="modalReceberAlerta"></span>
        </p>
        <p><strong><?php echo get_string('descricao', 'block_studentcare'); ?>:</strong> <span id="modalColetaDescricao"></span></p>
        <div id="modalEmocoes"></div>

        <div class="button-group">
            <button id="downloadCSV" class="btn-coleta btn-coleta-secondary">
                <i class="fa fa-file-csv"></i> <?php echo get_string('baixar_csv', 'block_studentcare'); ?>
            </button>
            <button id="downloadJSON" class="btn-coleta btn-coleta-secondary">
                <i class="fa fa-file-code"></i> <?php echo get_string('baixar_json', 'block_studentcare'); ?>
            </button>
            <button id="editarColeta" class="btn-coleta btn-coleta-secondary" onclick="editarColeta()">
                <i class="fa fa-edit"></i> <?php echo get_string('editar', 'block_studentcare'); ?>
            </button>
            <button id="deleteColeta" class="btn-coleta btn-coleta-secondary" data-id="" data-name=""
                    onclick="window.studentcare.confirmarExclusaoModal(this)">
                <i class="fa fa-trash"></i> <?php echo get_string('excluir', 'block_studentcare'); ?>
            </button>

            <button id="graficoColeta" class="btn-coleta btn-coleta-secondary" onclick="abrirGrafico()">
                <i class="fa fa-chart-bar"></i> <?php echo get_string('graficos', 'block_studentcare'); ?>
            </button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
