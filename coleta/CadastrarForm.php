<?php
require_once("$CFG->libdir/formslib.php");

class CadastrarForm extends moodleform
{
    // Construtor da classe
    public function __construct() {
        parent::__construct(); // Chama o construtor da classe pai
    }

    // Define o formulário
    public function definition()
    {
        global $PAGE, $COURSE;

        $mform = $this->_form;

        // Campo Nome
        $mform->addElement('text', 'name', get_string('name', 'block_ifcare'), array('size' => '50'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addRule('name', null, 'required', null, 'client');

        // Campo Data e Hora de Início da coleta
        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_ifcare'), array('optional' => false));
        $mform->addRule('starttime', null, 'required', null, 'client');

        // Campo Data e Hora de Fim da coleta
        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_ifcare'), array('optional' => false));
        $mform->addRule('endtime', null, 'required', null, 'client');

        // Campo Descrição
        $mform->addElement('textarea', 'description', get_string('description', 'block_ifcare'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        global $DB;

        // Consulta à tabela mdl_ifcare_classeaeq.
        $classes = $DB->get_records('ifcare_classeaeq');

        // Definir as opções para o select com os dados da tabela.
        $options = array();
        foreach ($classes as $class) {
            // Criar uma instância da ClasseAeq para cada registro.
            $classeAeq = new ClasseAeq($class->nome_classe);
            $options[$class->id] = $classeAeq->getNomeClasse(); // Usa o método getNomeClasse para obter o nome.
        }

        // Adiciona o campo select ao formulário.
        $mform->addElement('select', 'FIELDNAME', get_string('aeqclasses', 'block_ifcare'), $options);
        $mform->setType('FIELDNAME', PARAM_TEXT);

        // Adicione o contêiner para a tabela dinâmica
        $mform->addElement('html', '<div class="fitem">
                                    <div class="fitemtitle">Selecione as emoções</div>
                                    <div class="felement">
                                        <table id="container-tabela" class="generaltable"></table>
                                    </div>
                                </div>');

        // Inclui o JavaScript
        $PAGE->requires->js('/blocks/ifcare/js/tabela_dinamica.js');

        $mform->addElement('html', '<div class="fitem">
            <div class="fitemtitle">Resumo das Seleções</div>
            <div class="felement" id="resumo-selecoes">
                <ul id="resumo-lista">
                    <!-- Itens do resumo serão inseridos aqui pelo JavaScript -->
                </ul>
            </div>
        </div>');

        // Dentro do método de definição do seu formulário
$mform->addElement('hidden', 'courseid', 2); // 2 é o valor que você deseja passar
$mform->setType('courseid', PARAM_INT);


        // Flag "Receber alerta do andamento da coleta"
        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_ifcare'), null, array('group' => 1), array(0, 1));
        $mform->setDefault('alertprogress', 1);

        // Flag "Notificar os alunos"
        $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_ifcare'), null, array('group' => 1), array(0, 1));
        $mform->setDefault('notify_students', 1);

        // Botões de Salvar e Cancelar
        $this->add_action_buttons(true, get_string('submit', 'block_ifcare'));
    }

    // Função de validação personalizada (opcional)
    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        // Verifica se a data de fim é posterior à data de início
        if ($data['endtime'] <= $data['starttime']) {
            $errors['endtime'] = get_string('endtimeerror', 'block_ifcare');
        }

        return $errors;
    }

    // Função para processar o salvamento do formulário
    public function process_form($data) {
        global $DB, $USER;
    
        // Organiza os dados
        $nome = $data->name;
        $dataInicioFormatada = date('Y-m-d H:i:s', $data->starttime);
        $dataFimFormatada = date('Y-m-d H:i:s', $data->endtime);
        $descricao = $data->description;
        $receberAlerta = $data->alertprogress;
        $notificarAlunos = $data->notify_students;
        $cursoId = 2; // Definindo o courseid como 2
        $professorId = $USER->id;
    
        // Prepara os dados para inserção no banco
        $registro = new stdClass();
        $registro->nome = $nome;
        $registro->data_inicio = $dataInicioFormatada;
        $registro->data_fim = $dataFimFormatada;
        $registro->descricao = $descricao;
        $registro->receber_alerta = $receberAlerta;
        $registro->notificar_alunos = $notificarAlunos;
        $registro->curso_id = $cursoId; // Usando o courseid fixo
        $registro->professor_id = $professorId;
    
        // Insere os dados na tabela mdl_ifcare_cadastrocoleta
        $inserted = $DB->insert_record('ifcare_cadastrocoleta', $registro);

    
    if ($inserted) {
        echo "Registro inserido com sucesso na tabela ifcare_cadastrocoleta.";
    } else {
        echo "Erro ao inserir o registro na tabela ifcare_cadastrocoleta.";
    }
    }
    
    
}

// Classe CadastroColeta
class CadastroColeta {
    private $nome;
    private $dataInicio;
    private $horaInicio;
    private $dataFim;
    private $horaFim;
    private $descricao;
    private $receberAlerta;
    private $notificarAlunos;
    private $cursoId;  
    private $professorId;  
    private $classesAEQ; // Agora pode ser um array de objetos da classe ClasseAeq

    public function __construct($nome, $dataInicio, $horaInicio, $dataFim, $horaFim, $descricao, $receberAlerta, $notificarAlunos, $cursoId, $professorId) {
        $this->nome = $nome;
        $this->dataInicio = $dataInicio;
        $this->horaInicio = $horaInicio;
        $this->dataFim = $dataFim;
        $this->horaFim = $horaFim;
        $this->descricao = $descricao;
        $this->receberAlerta = $receberAlerta;
        $this->notificarAlunos = $notificarAlunos;
        $this->cursoId = $cursoId; 
        $this->professorId = $professorId; 
        $this->classesAEQ = []; // Inicializa como um array vazio
    }

    public function adicionarClasse($classe, $emoções) {
        // Adiciona a classe e as emoções associadas
        $this->classesAEQ[$classe] = $emoções;
    }

    // Exibe os dados do cadastro
    public function mostrarCadastroColeta() {
        echo "Nome da Coleta: " . $this->nome . PHP_EOL;
        echo "Data Início: " . $this->dataInicio . " " . $this->horaInicio . PHP_EOL;
        echo "Data Fim: " . $this->dataFim . " " . $this->horaFim . PHP_EOL;
        echo "Descrição: " . $this->descricao . PHP_EOL;
        echo "Receber Alerta: " . ($this->receberAlerta ? 'Sim' : 'Não') . PHP_EOL;
        echo "Notificar Alunos: " . ($this->notificarAlunos ? 'Sim' : 'Não') . PHP_EOL;
        echo "Curso ID: " . $this->cursoId . PHP_EOL;  
        echo "Professor ID: " . $this->professorId . PHP_EOL;  

        echo "Classes AEQ: " . PHP_EOL;
        foreach ($this->classesAEQ as $classe => $emoções) {
            echo "- Classe: " . $classe . PHP_EOL;
            foreach ($emoções as $emocao) {
                echo "  * Emoção: " . $emocao['nome'] . PHP_EOL;
                echo "    Antes: " . ($emocao['antes'] ? 'Sim' : 'Não') . PHP_EOL;
                echo "    Durante: " . ($emocao['durante'] ? 'Sim' : 'Não') . PHP_EOL;
                echo "    Depois: " . ($emocao['depois'] ? 'Sim' : 'Não') . PHP_EOL;
            }
        }
    }
}

class ClasseAeq {
    private $nomeClasse;

    public function __construct($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }

    public function getNomeClasse() {
        return $this->nomeClasse;
    }

    public function setNomeClasse($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }
}

