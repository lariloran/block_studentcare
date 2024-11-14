<?php
require_once('../../config.php');
require_login();

$context = context_course::instance($COURSE->id);
$PAGE->set_url('/blocks/ifcare/report.php');
$PAGE->set_context($context);
$PAGE->set_title("Relatório de Coletas de Emoções");

echo $OUTPUT->header();

$coletas = $DB->get_records_menu('ifcare_cadastrocoleta', null, 'nome', 'id, nome');
?>

<h3>Selecione uma Coleta</h3>
<select id="coletaSelect" name="coletaid">
    <option value="">Escolha uma coleta</option>
    <?php foreach ($coletas as $id => $nome): ?>
        <option value="<?php echo $id; ?>"><?php echo $nome; ?></option>
    <?php endforeach; ?>
</select>

<!-- Tabela e Gráfico -->
<div id="tabela-container">
    <h3>Relatório de Respostas por Pergunta e Escala Likert</h3>
    <table border="1" style="width: 100%; text-align: center;">
        <thead>
            <tr>
                <th>Pergunta</th>
                <th>Discordo Totalmente</th>
                <th>Discordo</th>
                <th>Neutro</th>
                <th>Concordo</th>
                <th>Concordo Totalmente</th>
            </tr>
        </thead>
        <tbody id="tabela-body">
            <tr><td colspan="6">Selecione uma coleta para ver os dados</td></tr>
        </tbody>
    </table>
</div>

<h3>Distribuição de Respostas por Pergunta</h3>
<canvas id="stackedBarChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart;

    document.getElementById('coletaSelect').addEventListener('change', function() {
        const coletaid = this.value;
        if (coletaid) {
            fetch('/blocks/ifcare/load_coleta_data.php?coletaid=' + coletaid)
                .then(response => response.json())
                .then(data => {
                    updateTable(data.tabela_dados);
                    updateChart(data.chart_data);
                });
        } else {
            document.getElementById('tabela-body').innerHTML = '<tr><td colspan="6">Selecione uma coleta para ver os dados</td></tr>';
            if (chart) chart.destroy();
        }
    });

    function updateTable(tabela_dados) {
        const tbody = document.getElementById('tabela-body');
        tbody.innerHTML = '';
        for (const [pergunta, respostas] of Object.entries(tabela_dados)) {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${pergunta}</td>` + respostas.map(qtd => `<td>${qtd}</td>`).join('');
            tbody.appendChild(row);
        }
    }

    function updateChart(chart_data) {
        const ctx = document.getElementById('stackedBarChart').getContext('2d');
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chart_data.labels,
                datasets: chart_data.datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribuição de Respostas por Escala Likert' }
                },
                scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true } }
            }
        });
    }
</script>

<?php
echo $OUTPUT->footer();
?>
