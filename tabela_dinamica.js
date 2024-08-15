document.addEventListener('DOMContentLoaded', function() {
    const choiceDropdown = document.querySelector('select[name="FIELDNAME"]'); // Altere FIELDNAME para o nome real do campo
    const containerTabela = document.getElementById('container-tabela');

    // Defina as emoções para cada classe
    const emocaoPorClasse = {
        'option1': ['alegria', 'esperanca', 'orgulho','raiva', 'ansiedade', 'vergonha','desesperança','tédio'],
        'option2': ['alegria', 'esperanca', 'orgulho','raiva', 'ansiedade', 'vergonha','desesperança','tédio'],
        'option3': ['alegria', 'esperanca', 'orgulho', 'alívio', 'raiva', 'ansiedade', 'vergonha','desesperança']
    };

    // Função para renderizar a tabela com base na opção selecionada
    function renderizarTabela(opcaoSelecionada) {
        const listaEmocoes = emocaoPorClasse[opcaoSelecionada] || [];
        let tabelaHtml = '<table><thead><tr><th></th><th>Nome da Emoção</th><th>Antes</th><th>Durante</th><th>Depois</th></tr></thead><tbody>';

        listaEmocoes.forEach(emocao => {
            tabelaHtml += `
                <tr>
                    <td><input type="checkbox" name="emocao_${emocao}" /></td>
                    <td>${emocao}</td>
                    <td><input type="checkbox" name="antes_${emocao}" /></td>
                    <td><input type="checkbox" name="durante_${emocao}" /></td>
                    <td><input type="checkbox" name="depois_${emocao}" /></td>
                </tr>`;
        });

        tabelaHtml += '</tbody></table>';
        containerTabela.innerHTML = tabelaHtml;
    }

    // Adicione o listener para mudanças na seleção do dropdown
    choiceDropdown.addEventListener('change', function() {
        const opcaoSelecionada = choiceDropdown.value;
        renderizarTabela(opcaoSelecionada);
    });

    // Renderize a tabela para a primeira opção ao carregar a página
    if (choiceDropdown.value) {
        renderizarTabela(choiceDropdown.value);
    } else {
        // Caso nenhuma opção esteja selecionada por padrão, selecione a primeira e renderize a tabela
        choiceDropdown.value = 'option1';
        renderizarTabela('option1');
    }
});
