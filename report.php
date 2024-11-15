<?php
require_once('../../config.php');
require_login();

$context = context_course::instance($COURSE->id);
$PAGE->set_url('/blocks/ifcare/report.php');
$PAGE->set_context($context);
$PAGE->set_title("Relatório de Coletas de Emoções");

echo $OUTPUT->header();

// Captura o parâmetro 'coletaid' da URL
$selected_coletaid = optional_param('coletaid', '', PARAM_INT);

// Obter as coletas para o combo
$coletas = $DB->get_records_menu('ifcare_cadastrocoleta', null, 'nome', 'id, nome');
?>

<!-- Combo para Seleção de Coleta -->
<div class="filter-container-coleta">
    <label for="coletaSelect"><strong>Selecione uma Coleta:</strong></label>
    <select id="coletaSelect" name="coletaid">
        <option value="">Escolha uma coleta</option>
        <?php foreach ($coletas as $id => $nome): ?>
            <option value="<?php echo $id; ?>" <?php echo ($id == $selected_coletaid) ? 'selected' : ''; ?>>
                <?php echo $nome; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Cards de Gráficos -->
<div class="card-list" id="graficosContainer">
    <div class="card">
        <canvas id="previewChart" width="150" height="100"></canvas>
        <h3>Barras Empilhadas</h3>
        <p>Exibe a distribuição de respostas por escala Likert.</p>
        <button class="btn-coleta" onclick="abrirModalGrafico()">Visualizar Gráfico</button>
    </div>
</div>


<!-- Modal de Tela Cheia para o Gráfico de Barras Empilhadas -->
<div id="graficoModal" class="modal-fullscreen">
    <div class="modal-content-fullscreen">
        <span class="close-fullscreen" onclick="fecharModalGrafico()">&times;</span>
        <canvas id="stackedBarChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart;

    document.addEventListener('DOMContentLoaded', function () {
        // Dados fictícios para o gráfico de pré-visualização
        const previewData = {
            labels: ['Discordo Totalmente', 'Discordo', 'Neutro', 'Concordo', 'Concordo Totalmente'],
            datasets: [{
                label: '',
                data: [12, 19, 3, 5, 2], // Dados de exemplo
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        };

        // Inicializa o gráfico de pré-visualização no canvas
        const previewCtx = document.getElementById('previewChart').getContext('2d');
        new Chart(previewCtx, {
            type: 'bar',
            data: previewData,
            options: {
                responsive: false,
                plugins: {
                    legend: { display: false }, // Oculta a legenda no preview
                    title: { display: false }   // Oculta o título no preview
                },
                scales: {
                    x: { display: false }, // Oculta os eixos no preview
                    y: { display: false }
                }
            }
        });
    });

    // Função para carregar dados do gráfico com base no coletaid
    function loadChartData(coletaid) {
        if (coletaid) {
            fetch('/blocks/ifcare/load_coleta_data.php?coletaid=' + coletaid)
                .then(response => response.json())
                .then(data => {
                    updateChart(data.chart_data);
                });
        } else {
            if (chart) chart.destroy();
        }
    }

    // Carrega o gráfico automaticamente se o coletaid está presente
    document.addEventListener('DOMContentLoaded', function () {
        const selectedColetaId = "<?php echo $selected_coletaid; ?>";
        if (selectedColetaId) {
            loadChartData(selectedColetaId);
        }
    });

    // Carrega o gráfico quando uma coleta é selecionada manualmente
    document.getElementById('coletaSelect').addEventListener('change', function () {
        loadChartData(this.value);
    });

    function abrirModalGrafico() {
        document.getElementById("graficoModal").style.display = "flex";
    }

    function fecharModalGrafico() {
        document.getElementById("graficoModal").style.display = "none";
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
                    title: {
                        display: true,
                        text: 'Distribuição de Respostas por Escala Likert',
                        font: {
                            size: 20
                        },
                        padding: { top: 10, bottom: 20 }
                    }
                },
                scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true } }
            }
        });
    }

    window.onclick = function (event) {
        if (event.target == document.getElementById("graficoModal")) {
            fecharModalGrafico();
        }
    }
</script>

<style>
    /* Mantendo a consistência visual do layout */
    .filter-container-coleta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin: 20px 0;
        padding: 15px 20px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-container-coleta label {
        font-size: 16px;
        color: #333;
        font-weight: bold;
    }

    .filter-container-coleta select {
        padding: 8px 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        color: #333;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-list {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .btn-coleta {
        display: inline-flex;
        align-items: center;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-coleta:hover {
        background-color: #45a049;
    }

    .modal-fullscreen {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        overflow-y: auto;
    }

    .modal-content-fullscreen {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 95%;
        max-width: 1200px;
        max-height: 95vh;
        position: relative;
        overflow-y: auto;
    }

    .close-fullscreen {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
    }

    .preview-image,
    #previewChart {
        width: 100%;
        /* Ajusta a largura para preencher o card */
        height: auto;
        /* Mantém a proporção */
        margin-bottom: 10px;
        /* Espaçamento entre o gráfico e o título */
    }
</style>

<?php
echo $OUTPUT->footer();
?>