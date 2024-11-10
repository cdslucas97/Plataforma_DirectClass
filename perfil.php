<?php
session_start();

// Habilita a exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o usuário está logado
if (!isset($_SESSION['cpf_pessoa'])) {
    http_response_code(401);
    echo json_encode(["error" => "Usuário não autenticado."]);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Falha na conexão com o banco de dados."]);
    exit();
}

$cpf = $_SESSION['cpf_pessoa'];

$sql = "SELECT Nome, Username, TipoUsuario FROM Pessoa WHERE CPF = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    echo json_encode($usuario);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Usuário não encontrado."]);
}

$stmt->close();
$conn->close();
?>
