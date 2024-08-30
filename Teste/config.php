<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // deixe vazio se não tiver senha
define('DB_NAME', 'acai_da_jade');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
