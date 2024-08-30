<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $mensagem = $conn->real_escape_string($_POST['mensagem']);

    $sql = "INSERT INTO sugestoes (nome, email, mensagem) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $mensagem);
    
    if ($stmt->execute()) {
        echo "Sugestão enviada com sucesso!";
    } else {
        echo "Erro ao enviar sugestão: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
