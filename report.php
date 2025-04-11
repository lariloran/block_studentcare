<?php
require_once('../../config.php');
require_login();

$context = cont// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * the first page to view the studentcare
 *
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package block_studentcare
 */

ext_course::instance($COURSE->id);
$PAGE->set_url('/blocks/studentcare/report.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('report', 'block_studentcare'));

echo $OUTPUT->header();

$selected_coletaid = optional_param('coletaid', '', PARAM_INT);

// Consulta SQL para buscar as coletas junto com o nome completo do curso
$sql = "
    SELECT DISTINCT c.id AS coleta_id, c.nome AS coleta_nome, c.curso_id, course.fullname AS curso_nome
    FROM {studentcare_cadastrocoleta} c
    JOIN {course} course ON course.id = c.curso_id
    LEFT JOIN {role_assignments} ra ON ra.contextid = (
        SELECT ctx.id FROM {context} ctx
        WHERE ctx.instanceid = course.id AND ctx.contextlevel = 50 LIMIT 1
    )
    LEFT JOIN {role} r ON r.id = ra.roleid
    WHERE (c.usuario_id = :usuario_id_1 OR (ra.userid = :usuario_id_2 AND r.shortname = 'editingteacher'))
    ORDER BY course.fullname, c.nome";

$params = [
    'usuario_id_1' => $USER->id,
    'usuario_id_2' => $USER->id // Parâmetro separado explicitamente
];

$coletas = $DB->get_records_sql($sql, $params);
?>

<!-- Combo para Seleção de Coleta -->
<div class="filter-container-coleta">
    <label for="coletaSelect"><strong><?php echo get_string('select_collection', 'block_studentcare'); ?>:</strong></label>
    <select id="coletaSelect" name="coletaid">
        <option value="" <?php echo empty($selected_coletaid) ? 'selected' : ''; ?>><?php echo get_string('choose_option', 'block_studentcare'); ?></option>
        <?php 
        $last_course_name = null;
        foreach ($coletas as $coleta): 
            // Agrupa por nome do curso
            if ($last_course_name !== $coleta->curso_nome): 
                if ($last_course_name !== null): ?>
                    </optgroup>
                <?php endif; ?>
                <optgroup label="<?php echo format_string($coleta->curso_nome); ?>">
            <?php 
            $last_course_name = $coleta->curso_nome;
            endif; 
            ?>
            <option value="<?php echo $coleta->coleta_id; ?>" <?php echo ($coleta->coleta_id == $selected_coletaid) ? 'selected' : ''; ?>>
                <?php echo format_string($coleta->coleta_nome); ?>
            </option>
        <?php endforeach; ?>
        <?php if ($last_course_name !== null): ?>
            </optgroup>
        <?php endif; ?>
    </select>
</div>



<!-- Cards de Gráficos -->
<div class="card-list" id="graficosContainer">
    <div class="card">
        <canvas id="previewChart" width="150" height="100"></canvas>
        <h3><?php echo get_string('stacked_bar', 'block_studentcare'); ?></h3>
        <p><?php echo get_string('stacked_bar_description', 'block_studentcare'); ?></p>
        <button class="btn-coleta" onclick="abrirModalGrafico()"><?php echo get_string('view_chart', 'block_studentcare'); ?></button>
    </div>
</div>

<!-- Modal de Tela Cheia para o Gráfico de Barras Empilhadas -->
<div id="graficoModal" class="modal-fullscreen">
    <div class="modal-content-fullscreen">
        <span class="close-fullscreen" onclick="fecharModalGrafico()">&times;</span>
        <canvas id="stackedBarChart"></canvas>
    </div>
</div>

<!-- Modal de Alerta -->
<div id="alertModal" class="modal-fullscreen">
    <div class="modal-content-fullscreen">
        <span class="close-fullscreen" onclick="fecharModalAlerta()">&times;</span>
        <p style="text-align: center; font-size: 18px; color: #333; font-weight: bold;">
            <?php echo get_string('select_collection_alert', 'block_studentcare'); ?>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart, modaChart;

    document.addEventListener('DOMContentLoaded', function () {
    
        const previewData = {
        labels: [
            "<?php echo get_string('strongly_disagree', 'block_studentcare'); ?>",
            "<?php echo get_string('disagree', 'block_studentcare'); ?>",
            "<?php echo get_string('neutral', 'block_studentcare'); ?>",
            "<?php echo get_string('agree', 'block_studentcare'); ?>",
            "<?php echo get_string('strongly_agree', 'block_studentcare'); ?>"
        ],
        datasets: [{
            label: '',
            data: [12, 19, 3, 5, 2],
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
        }]
    };

    const previewCtx = document.getElementById('previewChart').getContext('2d');
    new Chart(previewCtx, {
        type: 'bar',
        data: previewData,
        options: {
            responsive: false,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                x: { display: false },
                y: { display: false }
            }
        }
    });
});

    document.addEventListener('DOMContentLoaded', function () {
        const selectedColetaId = "<?php echo $selected_coletaid; ?>";
        if (selectedColetaId) {
            loadChartData(selectedColetaId);
        }
    });

    document.getElementById('coletaSelect').addEventListener('change', function () {
        loadChartData(this.value);
    });


    function abrirModalGrafico() {
    const selectedColeta = document.getElementById("coletaSelect").value;
    if (!selectedColeta) {
        abrirModalAlerta(); // Exibe o alerta se nenhuma coleta foi selecionada
        return;
    }
    const modal = document.getElementById("graficoModal");
    modal.style.display = "flex";
    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            fecharModalGrafico();
        }
    });
}

function abrirModalModa() {
    const selectedColeta = document.getElementById("coletaSelect").value;
    if (!selectedColeta) {
        abrirModalAlerta(); // Exibe o alerta se nenhuma coleta foi selecionada
        return;
    }
    const modal = document.getElementById("modaModal");
    modal.style.display = "flex";
    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            fecharModalModa();
        }
    });
}


function fecharModalGrafico() {
    document.getElementById("graficoModal").style.display = "none";
}



function fecharModalModa() {
    document.getElementById("modaModal").style.display = "none";
}

function abrirModalAlerta() {
    const modal = document.getElementById("alertModal");
    modal.style.display = "flex";

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            fecharModalAlerta();
        }
    });
}

function fecharModalAlerta() {
    document.getElementById("alertModal").style.display = "none";
}

    window.onclick = function (event) {
        if (event.target == document.getElementById("modaModal")) {
            fecharModalModa();
        }
    }

    function loadChartData(coletaid) {
        if (coletaid) {
            fetch('/blocks/studentcare/load_collection_data.php?coletaid=' + coletaid)
                .then(response => response.json())
                .then(data => {
                    updateChart(data.chart_data);      
                    //updateModaChart(data.moda_data);   
                });
        } else {
            if (chart) chart.destroy();
            if (modaChart) modaChart.destroy();
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
        title: {
            display: true,
            text: '<?php echo get_string("chart_title", "block_studentcare"); ?>', // Título traduzido
            font: { size: 20 },
            padding: { top: 10, bottom: 20 }
        }
    },
    scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true } }
}

        });
    }

</script>

<style>

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
        height: auto;
        margin-bottom: 10px;
    }
</style>

<?php
echo $OUTPUT->footer();
?>