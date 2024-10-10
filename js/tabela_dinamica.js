document.addEventListener('DOMContentLoaded', function () {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]');
    const containerTabela = document.getElementById('container-tabela');
    const resumoSelecoes = document.getElementById('resumo-selecoes');

    // Armazenar seleções de todas as classes
    let selecoes = {};

    function buscarEmocoes(classeId) {
        return fetch(`http://localhost/blocks/ifcare/api/ifcare_emocao.php?classeaeq_id=${classeId}`)
            .then(response => response.json());
    }

    function renderizarTabela(emocoes, nomeClasse) {
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
                    <td><input type="checkbox" class="emotion-checkbox" data-emocao="${emocao.nome}" data-classe="${nomeClasse}" /></td>
                    <td>${emocao.nome}</td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="antes" data-emocao="${emocao.nome}" checked /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="durante" data-emocao="${emocao.nome}" checked /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="depois" data-emocao="${emocao.nome}" checked /></td>
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
                    // Verifica se todas as checkboxes estão desmarcadas
                    const anyChecked = Array.from(timeCheckboxes).some(checkbox => checkbox.checked);
                    if (!anyChecked) {
                        // Reverte a alteração
                        this.checked = true;
                    }
                    atualizarSelecoes(nomeClasse);
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
                    // Marcar "Antes" como checked
                    if (timeCheckbox.getAttribute('data-tempo') === 'antes') {
                        timeCheckbox.checked = true;
                    } else {
                        timeCheckbox.checked = checked; // Marcar/desmarcar "Durante" e "Depois"
                    }
                });
            });
            atualizarSelecoes(nomeClasse);
            atualizarResumo();
        });

        // Adiciona evento de alteração para as checkboxes de emoção
        emotionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                atualizarSelecoes(nomeClasse);
                atualizarResumo();
            });
        });

        atualizarResumo();
    }

    // Atualizar as seleções de uma determinada classe
    function atualizarSelecoes(classe) {
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');
        selecoes[classe] = [];

        emotionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const emocao = checkbox.getAttribute('data-emocao');
                selecoes[classe].push(emocao);
            }
        });
    }

    choiceDropdown.addEventListener('change', function () {
        const opcaoSelecionada = choiceDropdown.value;
        if (opcaoSelecionada) {
            buscarEmocoes(opcaoSelecionada)
                .then(emocoes => {
                    const nomeClasse = choiceDropdown.options[choiceDropdown.selectedIndex].text;
                    renderizarTabela(emocoes, nomeClasse);
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
