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
            // Verifica se a emoção já foi selecionada anteriormente
            const isChecked = selecoes[nomeClasse] && selecoes[nomeClasse].includes(emocao.nome);
            
            tabelaHtml += `
                <tr>
                    <td><input type="checkbox" class="emotion-checkbox" data-emocao="${emocao.nome}" data-classe="${nomeClasse}" ${isChecked ? 'checked' : ''} /></td>
                    <td>${emocao.nome}</td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="antes" data-emocao="${emocao.nome}" ${emocao.antes ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="durante" data-emocao="${emocao.nome}" ${emocao.durante ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="depois" data-emocao="${emocao.nome}" ${emocao.depois ? 'checked' : ''} /></td>
                </tr>`;
        });

        tabelaHtml += '</tbody></table>';
        containerTabela.innerHTML = tabelaHtml;

        const selectAllCheckbox = document.getElementById('select-all');
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');
        const allRows = document.querySelectorAll('tbody tr');

        // Função para marcar/desmarcar todos os checkboxes da linha
        allRows.forEach(row => {
            const emotionCheckbox = row.querySelector('.emotion-checkbox');
            const timeCheckboxes = row.querySelectorAll('.time-checkbox');
            
            emotionCheckbox.addEventListener('change', function () {
                const checked = emotionCheckbox.checked;
                timeCheckboxes.forEach(checkbox => {
                    checkbox.checked = checked;
                });
                atualizarSelecoes(nomeClasse);
                atualizarResumo();
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
            atualizarSelecoes(nomeClasse);
            atualizarResumo();
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
        for (const classe in selecoes) {
            if (selecoes[classe].length > 0) {
                const emocoes = selecoes[classe].join(', ');
                const resumoItem = document.createElement('div');
                resumoItem.textContent = `Classe: ${classe} | Emoções: ${emocoes}`;
                resumoSelecoes.appendChild(resumoItem);
            }
        }
    }

    // Inicialização
    choiceDropdown.dispatchEvent(new Event('change'));
});
