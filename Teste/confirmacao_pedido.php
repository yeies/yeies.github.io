pr<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
    
    $sql = "SELECT p.*, GROUP_CONCAT(ap.adicional SEPARATOR ', ') as adicionais
            FROM pedidos p
            LEFT JOIN adicionais_pedido ap ON p.id = ap.pedido_id
            WHERE p.id = ?
            GROUP BY p.id";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    
    $stmt->bind_param("i", $pedido_id);
    if (!$stmt->execute()) {
        die("Erro na execução da consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();
    
    if ($pedido === null) {
        die("Pedido não encontrado");
    }
    
    $stmt->close();
} else {
    header("Location: index.html");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pedido - Açaí da Jade</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/confirmacao_pedido.css">
</head>
<body>
    <header>
        <!-- Seu cabeçalho aqui -->
    </header>

    <main>
        <h1>Pedido Confirmado</h1>
        <div class="pedido-detalhes">
            <h2>Detalhes do Pedido #<?php echo $pedido['id']; ?></h2>
            <p><strong>Sabor:</strong> <?php echo htmlspecialchars($pedido['sabor']); ?></p>
            <p><strong>Tamanho:</strong> <?php echo htmlspecialchars($pedido['tamanho']); ?></p>
            <p><strong>Adicionais:</strong> 
                <?php 
                if (!empty($pedido['adicionais'])) {
                    echo htmlspecialchars($pedido['adicionais']);
                } else {
                    echo 'Nenhum';
                }
                ?>
            </p>
            <p><strong>Observações:</strong> <?php echo htmlspecialchars($pedido['observacoes'] ?? 'Nenhuma'); ?></p>
            <p><strong>Endereço de Entrega:</strong> <?php echo htmlspecialchars($pedido['rua'] . ', ' . $pedido['numero'] . ', ' . $pedido['complemento'] . ' - ' . $pedido['bairro']); ?></p>
            <p><strong>Forma de Pagamento:</strong> <?php echo htmlspecialchars($pedido['forma_pagamento']); ?></p>
            <p><strong>Valor Total:</strong> R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></p>
        </div>
        <a href="index.html" class="btn">Voltar para a Página Inicial</a>
    </main>

    <footer>
        <!-- Seu rodapé aqui -->
    </footer>
</body>
</html>
