document.addEventListener('DOMContentLoaded', function () {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]');
    const containerTabela = document.getElementById('container-tabela');
    const resumoSelecoes = document.getElementById('resumo-selecoes');

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
                    <td><input type="checkbox" class="emotion-checkbox" data-emocao="${emocao.nome}" /></td>
                    <td>${emocao.nome}</td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="antes" data-emocao="${emocao.nome}" ${emocao.antes ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="durante" data-emocao="${emocao.nome}" ${emocao.durante ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="depois" data-emocao="${emocao.nome}" ${emocao.depois ? 'checked' : ''} /></td>
                </tr>`;
        });

        tabelaHtml += '</tbody></table>';
        containerTabela.innerHTML = tabelaHtml;

        // Adiciona a lógica para o checkbox "Selecionar tudo"
        const selectAllCheckbox = document.getElementById('select-all');
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            const checked = selectAllCheckbox.checked;
            emotionCheckboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });
            atualizarResumo();
        });

        atualizarResumo();
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
        // Lógica para atualizar o resumo
    }

    // Inicialização
    choiceDropdown.dispatchEvent(new Event('change'));
});
