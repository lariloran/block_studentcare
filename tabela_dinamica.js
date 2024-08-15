document.addEventListener('DOMContentLoaded', function() {
    const selectClasses = document.getElementById('id_aeqclasses');
    const containerTabela = document.getElementById('container-tabela');

    // Defina as emoções para cada classe
    const emocaoPorClasse = {
        'class1': ['alegria', 'esperanca', 'orgulho','raiva', 'ansiedade', 'vergonha','desesperança','tédio'],
        'class2': ['alegria', 'esperanca', 'orgulho','raiva', 'ansiedade', 'vergonha','desesperança','tédio'],
        'class3': ['alegria', 'esperanca', 'orgulho', 'alívio', 'raiva', 'ansiedade', 'vergonha','desesperança']
    };

    // Função para renderizar a tabela com base na classe selecionada
    function renderizarTabela(classeSelecionada) {
        const listaEmocoes = emocaoPorClasse[classeSelecionada] || [];
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

    // Adicione o listener para mudanças na seleção de classes
    selectClasses.addEventListener('change', function() {
        const classeSelecionada = selectClasses.value;
        renderizarTabela(classeSelecionada);
    });

    // Renderize a tabela para a primeira classe ao carregar a página
    if (selectClasses.value) {
        renderizarTabela(selectClasses.value);
    } else {
        // Caso nenhuma classe esteja selecionada por padrão, selecione a primeira e renderize a tabela
        selectClasses.value = 'class1';
        renderizarTabela('class1');
    }
});
