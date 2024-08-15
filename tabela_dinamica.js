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

        selectAllCheckbox.addEventListener('change', function() {
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
            const itensSelecionados = selecoes[classe] || {};
            const resumoItens = Object.keys(itensSelecionados).map(emocao => {
                const tempo = itensSelecionados[emocao];
                return `${emocao}(${tempo.antes ? 'A' : '-'},${tempo.durante ? 'D' : '-'},${tempo.depois ? 'D' : '-'})`;
            }).join(', ');
            resumoHtml += `<div class="resumo-classe">
                                <strong>${classe}:</strong> 
                                <span class="resumo-itens">${resumoItens || 'Nenhuma seleção'}</span>
                            </div>`;
        }
        resumoSelecoes.innerHTML = resumoHtml;
    }

    function isAllSelected(classe) {
        return selecoes[classe] && Object.keys(selecoes[classe]).length === emocaoPorClasse[classe].length;
    }

    choiceDropdown.addEventListener('change', function() {
        const opcaoSelecionada = choiceDropdown.value;
        if (opcaoSelecionada && !selecoes[opcaoSelecionada]) {
            selecoes[opcaoSelecionada] = {};
        }
        renderizarTabela(opcaoSelecionada);
    });

    containerTabela.addEventListener('change', function(e) {
        const opcaoSelecionada = choiceDropdown.value;
        if (e.target.classList.contains('emotion-checkbox')) {
            const emocao = e.target.getAttribute('data-emocao');
            const checked = e.target.checked;
            if (checked) {
                selecoes[opcaoSelecionada][emocao] = selecoes[opcaoSelecionada][emocao] || { antes: false, durante: false, depois: false };
                document.querySelectorAll(`input[data-emocao="${emocao}"].time-checkbox`).forEach(timeCheckbox => {
                    timeCheckbox.checked = true;
                });
                selecoes[opcaoSelecionada][emocao] = {
                    antes: true,
                    durante: true,
                    depois: true
                };
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
            atualizarResumo();
        }
    });

    function inicializarFormulario() {
        const inicialClasse = choiceDropdown.value || 'Emoções relacionadas às aulas';
        choiceDropdown.value = inicialClasse;
        renderizarTabela(inicialClasse);

        const event = new Event('change');
        choiceDropdown.dispatchEvent(event);
    }

    inicializarFormulario();
});
