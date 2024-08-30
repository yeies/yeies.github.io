<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug
echo "POST data:<br>";
var_dump($_POST);
echo "<br>";

// Debug para adicionais
if (isset($_POST['adicionais'])) {
    echo "Adicionais selecionados:<br>";
    var_dump($_POST['adicionais']);
} else {
    echo "Nenhum adicional selecionado<br>";
}

require_once 'config.php';

// Teste de conexão com o banco de dados
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão com o banco de dados bem-sucedida!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = null; // Definindo como null para pedidos sem usuário registrado
    $sabor = $conn->real_escape_string($_POST['sabor']);
    $tamanho = $conn->real_escape_string($_POST['tamanho']);
    $valor_total = floatval($_POST['valor_total']);
    $observacoes = isset($_POST['observacoes']) ? $conn->real_escape_string($_POST['observacoes']) : '';
    $rua = $conn->real_escape_string($_POST['rua']);
    $numero = $conn->real_escape_string($_POST['numero']);
    $complemento = isset($_POST['complemento']) ? $conn->real_escape_string($_POST['complemento']) : '';
    $bairro = $conn->real_escape_string($_POST['bairro']);
    $forma_pagamento = $conn->real_escape_string($_POST['pagamento']);

    $sql = "INSERT INTO pedidos (usuario_id, sabor, tamanho, valor_total, observacoes, rua, numero, complemento, bairro, forma_pagamento) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("issdssssss", $usuario_id, $sabor, $tamanho, $valor_total, $observacoes, $rua, $numero, $complemento, $bairro, $forma_pagamento);
    
    if ($stmt->execute()) {
        $pedido_id = $stmt->insert_id;
        
        if (isset($_POST['adicionais']) && is_array($_POST['adicionais'])) {
            $adicionais = $_POST['adicionais'];
            $sql_adicional = "INSERT INTO adicionais_pedido (pedido_id, adicional) VALUES (?, ?)";
            $stmt_adicional = $conn->prepare($sql_adicional);
            
            if ($stmt_adicional === false) {
                die("Erro na preparação da consulta de adicionais: " . $conn->error);
            }

            foreach ($adicionais as $adicional) {
                $stmt_adicional->bind_param("is", $pedido_id, $adicional);
                if (!$stmt_adicional->execute()) {
                    echo "Erro ao inserir adicional: " . $stmt_adicional->error . "<br>";
                }
            }
            
            $stmt_adicional->close();
        } else {
            echo "Nenhum adicional para processar<br>";
        }
        
        header("Location: confirmacao_pedido.php?id=" . $pedido_id);
        exit();
    } else {
        echo "Erro ao processar o pedido: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
