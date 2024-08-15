document.addEventListener('DOMContentLoaded', function() {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]');
    const containerTabela = document.getElementById('container-tabela');
    const resumoSelecoes = document.getElementById('resumo-selecoes');

    const emocaoPorClasse = {
        'Emoções relacionadas às aulas': ['alegria', 'esperanca', 'orgulho', 'raiva', 'ansiedade', 'vergonha', 'desesperança', 'tédio'],
        'Emoções relacionadas aos testes': ['alegria', 'esperanca', 'orgulho', 'raiva', 'ansiedade', 'vergonha', 'desesperança', 'tédio'],
        'Emoções relacionadas ao aprendizado': ['alegria', 'esperanca', 'orgulho', 'alívio', 'raiva', 'ansiedade', 'vergonha', 'desesperança']
    };

    let selecoes = {};

    function renderizarTabela(opcaoSelecionada) {
        const listaEmocoes = emocaoPorClasse[opcaoSelecionada] || [];
        let tabelaHtml = `
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all" ${isAllSelected(opcaoSelecionada) ? 'checked' : ''} /></th>
                        <th>Nome da Emoção</th>
                        <th>Antes</th>
                        <th>Durante</th>
                        <th>Depois</th>
                    </tr>
                </thead>
                <tbody>`;

        listaEmocoes.forEach(emocao => {
            tabelaHtml += `
                <tr>
                    <td><input type="checkbox" class="emotion-checkbox" data-emocao="${emocao}" ${selecoes[opcaoSelecionada] && selecoes[opcaoSelecionada].includes(emocao) ? 'checked' : ''} /></td>
                    <td>${emocao}</td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="antes" data-emocao="${emocao}" ${selecoes[opcaoSelecionada] && selecoes[opcaoSelecionada].includes(emocao) ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="durante" data-emocao="${emocao}" ${selecoes[opcaoSelecionada] && selecoes[opcaoSelecionada].includes(emocao) ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="depois" data-emocao="${emocao}" ${selecoes[opcaoSelecionada] && selecoes[opcaoSelecionada].includes(emocao) ? 'checked' : ''} /></td>
                </tr>`;
        });

        tabelaHtml += '</tbody></table>';
        containerTabela.innerHTML = tabelaHtml;

        atualizarResumo();

        const selectAllCheckbox = document.getElementById('select-all');
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            const checked = selectAllCheckbox.checked;
            emotionCheckboxes.forEach(checkbox => {
                checkbox.checked = checked;
                const emocao = checkbox.getAttribute('data-emocao');
                if (checked && !selecoes[opcaoSelecionada].includes(emocao)) {
                    selecoes[opcaoSelecionada].push(emocao);
                } else if (!checked) {
                    selecoes[opcaoSelecionada] = selecoes[opcaoSelecionada].filter(em => em !== emocao);
                }
                // Marca ou desmarca os checkboxes de tempo
                document.querySelectorAll(`input[data-emocao="${emocao}"].time-checkbox`).forEach(timeCheckbox => {
                    timeCheckbox.checked = checked;
                });
            });
            atualizarResumo();
        });
    }

    function atualizarResumo() {
        let resumoHtml = '<p>Você selecionou as seguintes emoções:</p>';
        for (let classe in emocaoPorClasse) {
            const itensSelecionados = selecoes[classe] && selecoes[classe].length > 0 ? selecoes[classe].join(', ') : 'Nenhuma seleção';
            resumoHtml += `<div class="resumo-classe">
                                <strong>${classe}:</strong> 
                                <span class="resumo-itens">${itensSelecionados}</span>
                            </div>`;
        }
        resumoSelecoes.innerHTML = resumoHtml;
    }

    function isAllSelected(classe) {
        return selecoes[classe] && selecoes[classe].length === emocaoPorClasse[classe].length;
    }

    choiceDropdown.addEventListener('change', function() {
        const opcaoSelecionada = choiceDropdown.value;
        if (opcaoSelecionada && !selecoes[opcaoSelecionada]) {
            selecoes[opcaoSelecionada] = [];
        }
        renderizarTabela(opcaoSelecionada);
    });

    containerTabela.addEventListener('change', function(e) {
        const opcaoSelecionada = choiceDropdown.value;
        if (e.target.classList.contains('emotion-checkbox')) {
            const emocao = e.target.getAttribute('data-emocao');
            const checked = e.target.checked;

            if (checked) {
                if (!selecoes[opcaoSelecionada].includes(emocao)) {
                    selecoes[opcaoSelecionada].push(emocao);
                }
                // Marca todos os checkboxes de tempo
                document.querySelectorAll(`input[data-emocao="${emocao}"].time-checkbox`).forEach(timeCheckbox => {
                    timeCheckbox.checked = true;
                });
            } else {
                selecoes[opcaoSelecionada] = selecoes[opcaoSelecionada].filter(em => em !== emocao);
                // Desmarca todos os checkboxes de tempo
                document.querySelectorAll(`input[data-emocao="${emocao}"].time-checkbox`).forEach(timeCheckbox => {
                    timeCheckbox.checked = false;
                });
            }
            atualizarResumo();
        }
    });

    // Inicializa o formulário
    function inicializarFormulario() {
        const inicialClasse = choiceDropdown.value || 'Emoções relacionadas às aulas';
        choiceDropdown.value = inicialClasse;
        renderizarTabela(inicialClasse);

        // Simula a mudança de seleção para atualizar a tabela e o resumo
        const event = new Event('change');
        choiceDropdown.dispatchEvent(event);
    }

    inicializarFormulario();
});
