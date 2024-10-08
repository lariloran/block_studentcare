<?php
// get_perguntas_aeq.php
require __DIR__ . '/../db/db.php'; 
header('Content-Type: application/json');

$sql = 'SELECT * FROM mdl_ifcare_pergunta';
$stmt = $pdo->query($sql);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>
