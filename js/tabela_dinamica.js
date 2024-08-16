document.addEventListener('DOMContentLoaded', function () {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]');
    const containerTabela = document.getElementById('container-tabela');
    const resumoSelecoes = document.getElementById('resumo-selecoes');

    // Mapeamento das classes para os nomes legíveis
    const nomesLegiveisClasses = {
        'class1': 'Emoções relacionadas às aulas',
        'class2': 'Emoções relacionadas aos testes',
        'class3': 'Emoções relacionadas ao aprendizado'
    };

    const emocaoPorClasse = {
        'class1': ['alegria', 'esperanca', 'orgulho', 'raiva', 'ansiedade', 'vergonha', 'desesperança', 'tédio'],
        'class2': ['alegria', 'esperanca', 'orgulho', 'raiva', 'ansiedade', 'vergonha', 'desesperança', 'tédio'],
        'class3': ['alegria', 'esperanca', 'orgulho', 'alívio', 'raiva', 'ansiedade', 'vergonha', 'desesperança']
    };

    const corClasses = {
        'class1': 'tabela-aula',
        'class2': 'tabela-teste',
        'class3': 'tabela-aprendizado'
    };

    let selecoes = {};

    function renderizarTabela(opcaoSelecionada) {
        const listaEmocoes = emocaoPorClasse[opcaoSelecionada] || [];
        const nomeClasse = nomesLegiveisClasses[opcaoSelecionada] || opcaoSelecionada;

        let tabelaHtml = `
        <table>
                <thead>
                 <tr>
                        <th colspan="5">${nomeClasse}</th>
                    </tr>
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
            const selecionado = selecoes[opcaoSelecionada] && selecoes[opcaoSelecionada][emocao] || {};
            tabelaHtml += `
                <tr>
                    <td><input type="checkbox" class="emotion-checkbox" data-emocao="${emocao}" ${Object.keys(selecionado).length > 0 ? 'checked' : ''} /></td>
                    <td>${emocao}</td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="antes" data-emocao="${emocao}" ${selecionado.antes ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="durante" data-emocao="${emocao}" ${selecionado.durante ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="time-checkbox" data-tempo="depois" data-emocao="${emocao}" ${selecionado.depois ? 'checked' : ''} /></td>
                </tr>`;
        });

        tabelaHtml += '</tbody></table>';
        containerTabela.innerHTML = tabelaHtml;

        atualizarResumo();

        const selectAllCheckbox = document.getElementById('select-all');
        const emotionCheckboxes = document.querySelectorAll('.emotion-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            const checked = selectAllCheckbox.checked;
            emotionCheckboxes.forEach(checkbox => {
                checkbox.checked = checked;
                const emocao = checkbox.getAttribute('data-emocao');
                if (checked) {
                    selecoes[opcaoSelecionada][emocao] = {
                        antes: true,
                        durante: true,
                        depois: true
                    };
                } else {
                    delete selecoes[opcaoSelecionada][emocao];
                }
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
            const nomeClasse = nomesLegiveisClasses[classe] || classe;
            const itensSelecionados = selecoes[classe] || {};
            const resumoItens = Object.keys(itensSelecionados).map(emocao => {
                const tempo = itensSelecionados[emocao];
                return `${emocao}(${tempo.antes ? 'A' : '-'},${tempo.durante ? 'D' : '-'},${tempo.depois ? 'D' : '-'})`;
            }).join(', ');
            resumoHtml += `<div class="resumo-classe">
                                <strong>${nomeClasse}:</strong> 
                                <span class="resumo-itens">${resumoItens || 'Nenhuma seleção'}</span>
                            </div>`;
        }
        resumoSelecoes.innerHTML = resumoHtml;
    }

    function isAllSelected(classe) {
        return selecoes[classe] && Object.keys(selecoes[classe]).length === emocaoPorClasse[classe].length;
    }

    choiceDropdown.addEventListener('change', function () {
        const opcaoSelecionada = choiceDropdown.value;
        if (opcaoSelecionada && !selecoes[opcaoSelecionada]) {
            selecoes[opcaoSelecionada] = {};
        }
        // Remove a classe de cor anterior
        containerTabela.classList.remove(...Object.values(corClasses));
        // Adiciona a nova classe de cor
        containerTabela.classList.add(corClasses[opcaoSelecionada]);
        renderizarTabela(opcaoSelecionada);
    });

    containerTabela.addEventListener('change', function (e) {
        const opcaoSelecionada = choiceDropdown.value;
        if (e.target.classList.contains('emotion-checkbox')) {
            const emocao = e.target.getAttribute('data-emocao');
            const checked = e.target.checked;
            if (checked) {
                selecoes[opcaoSelecionada][emocao] = selecoes[opcaoSelecionada][emocao] || { antes: true, durante: false, depois: false };
                document.querySelector(`input[data-emocao="${emocao}"][data-tempo="antes"]`).checked = true;
            } else {
                delete selecoes[opcaoSelecionada][emocao];
                document.querySelectorAll(`input[data-emocao="${emocao}"].time-checkbox`).forEach(timeCheckbox => {
                    timeCheckbox.checked = false;
                });
            }
            atualizarResumo();
        } else if (e.target.classList.contains('time-checkbox')) {
            const emocao = e.target.getAttribute('data-emocao');
            const tempo = e.target.getAttribute('data-tempo');
            const checked = e.target.checked;
            if (!selecoes[opcaoSelecionada][emocao]) {
                selecoes[opcaoSelecionada][emocao] = { antes: false, durante: false, depois: false };
            }
            selecoes[opcaoSelecionada][emocao][tempo] = checked;

            const tempoSelecionado = selecoes[opcaoSelecionada][emocao];
            if (!tempoSelecionado.antes && !tempoSelecionado.durante && !tempoSelecionado.depois) {
                selecoes[opcaoSelecionada][emocao].antes = true;
                document.querySelector(`input[data-emocao="${emocao}"][data-tempo="antes"]`).checked = true;
            }

            const emotionCheckbox = document.querySelector(`input[data-emocao="${emocao}"].emotion-checkbox`);
            if (checked) {
                emotionCheckbox.checked = true;
            }
            atualizarResumo();
        }
    });

    function inicializarFormulario() {
        const inicialClasse = choiceDropdown.value || 'class1';
        choiceDropdown.value = inicialClasse;
        containerTabela.classList.add(corClasses[inicialClasse]);
        renderizarTabela(inicialClasse);

        const event = new Event('change');
        choiceDropdown.dispatchEvent(event);
    }

    inicializarFormulario();
});
