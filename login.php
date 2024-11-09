<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Query para verificar usuário e tipo
$sql = "SELECT TipoUsuario FROM Pessoa WHERE (Email = ? OR Username = ?) AND Senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tipoUsuario = $row['TipoUsuario'];
    echo "success:$tipoUsuario";  // Retorna "success:aluno" ou "success:professor"
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
