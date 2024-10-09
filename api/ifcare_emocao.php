<?php
// get_emocoes_aeq.php
require __DIR__ . '/../db/db.php'; // Ajuste o caminho conforme necessário
header('Content-Type: application/json');

// Obter o parâmetro classeaeq_id da URL
$classeId = isset($_GET['classeaeq_id']) ? (int)$_GET['classeaeq_id'] : 0;

// Verifique se o classeId é válido
if ($classeId <= 0) {
    echo json_encode(['error' => 'ID da classe inválido']);
    exit;
}

// Consulta para buscar emoções da classe
$sql = 'SELECT * FROM mdl_ifcare_emocao WHERE classeaeq_id = :classeaeq_id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['classeaeq_id' => $classeId]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retornar as emoções como JSON
echo json_encode($data);
?>
