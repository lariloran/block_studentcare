document.addEventListener('DOMContentLoaded', function () {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]');
    const containerTabela = document.getElementById('container-tabela');
    const resumoSelecoes = document.getElementById('resumo-selecoes');

    // Armazenar seleções de todas as classes
    let selecoes = {};
    let dadosSelecoes = []; // Array para armazenar todas as emoções com informações
    let emocoesHidden = {}; // Array para armazenar as emoções selecionadas em um campo oculto
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

        // Função para marcar/desmarcar todos os checkboxes da tabela
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

        // Adiciona evento de alteração para as checkboxes de emoção
        emotionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
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
        emocoesHidden[classe] = []; // Certifique-se de que esta inicialização está correta
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
                emocoesHidden[classe].push(dadoSelecionado); // Agora estamos empurrando o objeto individualmente
            }
        });
    
        // Preenche o campo oculto com as seleções
        document.getElementById('emocao_selecionadas').value = JSON.stringify(emocoesHidden);
    
        console.log(dadosSelecoes); // Exibe o array completo no console para fins de debug
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
        // Limpar o resumo anterior
        resumoSelecoes.innerHTML = '';

        // Exibir o resumo com todas as seleções de todas as classes
        const options = choiceDropdown.options;
        for (let i = 0; i < options.length; i++) {
            const classe = options[i].text;
            if (selecoes[classe] && selecoes[classe].length > 0) {
                const emocoes = selecoes[classe].join(', ');
                const resumoItem = document.createElement('div');
                resumoItem.textContent = `Classe: ${classe} | Emoções: ${emocoes}`;
                resumoSelecoes.appendChild(resumoItem);
            } else {
                const resumoItem = document.createElement('div');
                resumoItem.textContent = `Classe: ${classe} | Emoções: nenhuma seleção`;
                resumoSelecoes.appendChild(resumoItem);
            }
        }
    }

    
    // Inicialização - Adiciona mensagens iniciais no quadro de resumo
    function inicializarResumo() {
        const options = choiceDropdown.options;
        for (let i = 0; i < options.length; i++) {
            const classe = options[i].text;
            selecoes[classe] = [];  // Inicializa com nenhuma seleção
            const resumoItem = document.createElement('div');
            resumoItem.textContent = `Classe: ${classe} | Emoções: nenhuma seleção`;
            resumoSelecoes.appendChild(resumoItem);
        }
    }

    // Inicialização
    inicializarResumo();
    choiceDropdown.dispatchEvent(new Event('change'));
});
