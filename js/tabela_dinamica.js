document.addEventListener('DOMContentLoaded', function () {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]');
    const containerTabela = document.getElementById('container-tabela');
    const resumoSelecoes = document.getElementById('resumo-selecoes');
    const saveButton = document.getElementById('id_save'); // Botão de salvar

    let selecoes = {};    // Armazenar seleções de todas as classes
    let dadosSelecoes = []; // Array para armazenar todas as emoções com informações
    let emocoesHidden = {}; // Armazenar as emoções selecionadas em um campo oculto

    function buscarEmocoes(classeId) {
        return fetch(`http://localhost/blocks/ifcare/api/ifcare_emocao.php?classeaeq_id=${classeId}`)
            .then(response => response.json());
    }

    function renderizarTabela(emocoes, nomeClasse, classeId) {
        let tabelaHtml = `
        <table>
            <thead>
                <tr>
                    <th colspan="5">${nomeClasse}</th>
                </tr>
                <tr>
                    <th><input type="checkbox" id="select-all" /></th>
                    <th>Nome da Emoção</th>
                    <th>Antes</th>
                    <th>Durante</th>
                    <th>Depois</th>
                </tr>
            </thead>
            <tbody>`;

        emocoes.forEach(emocao => {
            tabelaHtml += `
                <tr>
                    <td><input type="checkbox" class="emotion-checkbox" data-emocao="${emocao.nome}" data-id="${emocao.id}" data-classe="${nomeClasse}" data-classeid="${classeId}" /></td>
                    <td>${emocao.nome}</td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="antes" data-emocao="${emocao.nome}" data-id="${emocao.id}" checked /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="durante" data-emocao="${emocao.nome}" data-id="${emocao.id}" checked /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="depois" data-emocao="${emocao.nome}" data-id="${emocao.id}" checked /></td>
                </tr>`;
        });

        tabelaHtml += '</tbody></table>';
        containerTabela.innerHTML = tabelaHtml;

        const selectAllCheckbox = document.getElementById('select-all');
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');
        const allRows = document.querySelectorAll('tbody tr');

        // Função para garantir que pelo menos uma checkbox esteja marcada por linha
        allRows.forEach(row => {
            const timeCheckboxes = row.querySelectorAll('.time-checkbox');

            timeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const anyChecked = Array.from(timeCheckboxes).some(checkbox => checkbox.checked);
                    if (!anyChecked) {
                        this.checked = true;
                    }
                    atualizarSelecoes(nomeClasse, classeId);
                    atualizarResumo();
                });
            });
        });

                // Marcar/desmarcar todas as emoções e tempos quando o select-all for alterado
                selectAllCheckbox.addEventListener('change', function () {
                    const checked = selectAllCheckbox.checked;
                    emotionCheckboxes.forEach(checkbox => {
                        checkbox.checked = checked;
                        const row = checkbox.closest('tr');
                        const timeCheckboxes = row.querySelectorAll('.time-checkbox');
                        timeCheckboxes.forEach(timeCheckbox => {
                            timeCheckbox.checked = checked;
                        });
                    });
                    atualizarSelecoes(nomeClasse, classeId);
                    atualizarResumo();
                });
        
                // Alteração de estado da checkbox da emoção
                emotionCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const row = checkbox.closest('tr');
                        const timeCheckboxes = row.querySelectorAll('.time-checkbox');
        
                        if (checkbox.checked) {
                            // Marca todas as checkboxes (Antes, Durante e Depois)
                            timeCheckboxes.forEach(timeCheckbox => {
                                timeCheckbox.checked = true;
                            });
                        } else {
                            // Desmarca todas as checkboxes (exceto "Antes" que sempre precisa estar marcada)
                            timeCheckboxes.forEach(timeCheckbox => {
                                timeCheckbox.checked = false;
                            });
                            row.querySelector('input[data-tempo="antes"]').checked = true;
                        }
                        
                        atualizarSelecoes(nomeClasse, classeId);
                        atualizarResumo();
                    });
                });
        
                atualizarResumo();
            }

    // Atualizar as seleções de uma determinada classe
    function atualizarSelecoes(classe, classeId) {
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');
        selecoes[classe] = [];
        emocoesHidden[classe] = []; 
        dadosSelecoes = []; // Reinicializa o array de seleções
    
        emotionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const emocao = checkbox.getAttribute('data-emocao');
                const emocaoId = checkbox.getAttribute('data-id');
    
                // Verifica os valores de antes, durante e depois
                const row = checkbox.closest('tr');
                const antes = row.querySelector('input[data-tempo="antes"]').checked;
                const durante = row.querySelector('input[data-tempo="durante"]').checked;
                const depois = row.querySelector('input[data-tempo="depois"]').checked;
    
                // Armazena a emoção e suas informações no array
                const dadoSelecionado = {
                    classeId: classeId,
                    emocaoNome: emocao,
                    emocaoId: emocaoId,
                    antes: antes,
                    durante: durante,
                    depois: depois
                };
    
                // Armazena a emoção selecionada
                dadosSelecoes.push(dadoSelecionado);
    
                // Atualiza as seleções
                selecoes[classe].push(emocao);
                // Adiciona o dado selecionado em emocoesHidden
                emocoesHidden[classe].push(dadoSelecionado); 
            }
        });
    
        // Preenche o campo oculto com as seleções
        document.getElementById('emocao_selecionadas').value = JSON.stringify(emocoesHidden);
        console.log(emocoesHidden);
        // Atualiza o estado do botão "Salvar"
        toggleSaveButton();
    }

    // Habilita ou desabilita o botão "Salvar"
    function toggleSaveButton() {
        saveButton.disabled = Object.keys(selecoes).length === 0 || Object.values(selecoes).every(emocoes => emocoes.length === 0);
    }

    choiceDropdown.addEventListener('change', function () {
        const opcaoSelecionada = choiceDropdown.value;
        if (opcaoSelecionada) {
            buscarEmocoes(opcaoSelecionada)
                .then(emocoes => {
                    const nomeClasse = choiceDropdown.options[choiceDropdown.selectedIndex].text;
                    const classeId = opcaoSelecionada;
                    renderizarTabela(emocoes, nomeClasse, classeId);
                });
        }
    });

    function atualizarResumo() {
        resumoSelecoes.innerHTML = '';

        // Exibir o resumo com todas as seleções de todas as classes
        const options = choiceDropdown.options;
        for (let i = 0; i < options.length; i++) {
            const classe = options[i].text;
            if (selecoes[classe] && selecoes[classe].length > 0) {
                const emocoes = selecoes[classe].join(', ');
                const resumoItem = document.createElement('div');
                resumoItem.textContent = `${classe}: ${emocoes}`;
                resumoSelecoes.appendChild(resumoItem);
            } else {
                const resumoItem = document.createElement('div');
                resumoItem.textContent = `${classe}: Nenhuma emoção selecionada`;
                resumoSelecoes.appendChild(resumoItem);
            }
        }
    }

    // Inicialização - Adiciona mensagens iniciais no quadro de resumo
    function inicializarResumo() {
        const options = choiceDropdown.options;
        for (let i = 0; i < options.length; i++) {
            const classe = options[i].text;
            selecoes[classe] = [];  
            const resumoItem = document.createElement('div');
            resumoItem.textContent = `${classe}: Nenhuma emoção selecionada`;
            resumoSelecoes.appendChild(resumoItem);
        }
    }

    // Inicialização
    inicializarResumo();
    choiceDropdown.dispatchEvent(new Event('change'));
});
