<?php
require_once 'config.php';
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processamento do formulário de sugestões
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $sugestao = $conn->real_escape_string($_POST['sugestao']);

    $sql = "INSERT INTO sugestoes (nome, email, mensagem) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $sugestao);
    
    if ($stmt->execute()) {
        $mensagem = "Sugestão enviada com sucesso!";
    } else {
        $mensagem = "Erro ao enviar sugestão: " . $stmt->error;
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte - Açaí da Jade</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/suporte.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Açaí da Jade</div>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="pedido.html">Pedido</a></li>
                <li><a href="suporte.php">Suporte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1 class="fade-in">Suporte ao Cliente</h1>
        
        <div class="container suporte-container fade-in">
            <div class="tabs">
                <button class="tab-button active" onclick="openTab(event, 'perguntas')">Perguntas Frequentes</button>
                <button class="tab-button" onclick="openTab(event, 'sugestoes')">Sugestões</button>
                <button class="tab-button" onclick="openTab(event, 'contato')">Contato</button>
            </div>

            <div id="perguntas" class="tab-content active">
                <h2>Perguntas Frequentes</h2>
                <div class="faq-item">
                    <h3>Como faço um pedido?</h3>
                    <p>Para fazer um pedido, basta acessar a página "Pedido" no menu principal, escolher seus itens e seguir as instruções de checkout.</p>
                </div>
                <div class="faq-item">
                    <h3>Quais são as formas de pagamento?</h3>
                    <p>Aceitamos pagamentos em dinheiro, cartão de crédito/débito e PIX.</p>
                </div>
                <!-- Adicione mais itens de FAQ conforme necessário -->
            </div>

            <div id="sugestoes" class="tab-content">
                <h2>Envie sua Sugestão</h2>
                <?php if ($mensagem): ?>
                    <p class="mensagem"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <form id="sugestao-form" method="POST" action="">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="sugestao">Sua sugestão:</label>
                        <textarea id="sugestao" name="sugestao" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn">Enviar Sugestão</button>
                </form>
            </div>

            <div id="contato" class="tab-content">
                <h2>Entre em Contato</h2>
                <p>Se você não encontrou a resposta para sua pergunta, entre em contato conosco:</p>
                <ul>
                    <li><i class="fas fa-envelope"></i> Email: suporte@acaidajade.com</li>
                    <li><i class="fas fa-phone"></i> Telefone: (21) 1234-5678</li>
                    <li><i class="fas fa-whatsapp"></i> WhatsApp: (21) 98765-4321</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Açaí da Jade. Todos os direitos reservados.</p>
    </footer>

    <script src="scripts/main.js"></script>
    <script src="scripts/nav.js"></script>
    <script>
    function openTab(evt, tabName) {
        var i, tabContent, tabButtons;
        tabContent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].style.display = "none";
        }
        tabButtons = document.getElementsByClassName("tab-button");
        for (i = 0; i < tabButtons.length; i++) {
            tabButtons[i].className = tabButtons[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    </script>
</body>
</html>
