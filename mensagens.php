<?php
session_start(); // Inicia a sessão

// Debug: Verifica se a sessão está ativa
if (!isset($_SESSION['cpfUsuario'])) {
    die("Erro: Usuário não está logado. Variável de sessão não encontrada.");
} else {
    // Debug: Exibe o CPF do usuário logado
    echo "Usuário logado com CPF: " . $_SESSION['cpfUsuario'];
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$remetenteCpf = $_SESSION['cpfUsuario']; // Obtém o CPF do usuário logado

// Verifica se é uma requisição POST para enviar uma mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinatarioCpf = $_POST['destinatario_cpf'] ?? ''; // Obtém o CPF do destinatário
    $conteudo = $_POST['conteudo'] ?? '';

    if (!empty($destinatarioCpf) && !empty($conteudo)) {
        $stmt = $conn->prepare("INSERT INTO Mensagem (remetente_cpf, destinatario_cpf, conteudo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $remetenteCpf, $destinatarioCpf, $conteudo);
        $stmt->execute();
        $stmt->close();
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Destinatário e conteúdo não podem ser vazios.";
    }
}

// Verifica se é uma requisição GET para recuperar mensagens
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT remetente_cpf, conteudo, data_envio FROM Mensagem WHERE destinatario_cpf = ? ORDER BY data_envio DESC");
    $stmt->bind_param("s", $remetenteCpf);
    $stmt->execute();
    $result = $stmt->get_result();

    $mensagens = [];
    while ($row = $result->fetch_assoc()) {
        $mensagens[] = $row;
    }
    echo json_encode($mensagens);
}

$conn->close();
?>
