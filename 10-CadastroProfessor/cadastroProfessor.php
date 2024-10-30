<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

$conn = new mysqli($servername, $username, $password, $dbname);

$nome = $_POST['nome'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? ''; 
$telefone = $_POST['telefone'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$senha = $_POST['senha'] ?? '';

$sqlCheck = "SELECT * FROM pessoa WHERE Email = ? OR Cpf = ? OR Username = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("sss", $email, $cpf, $username);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    die("Erro: Email, CPF ou Username já cadastrados.");
}

$sql = "INSERT INTO pessoa (Nome, Username, Email, Telefone, Endereco, Cpf, Senha, Cargo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$cargo = 'aluno';
$stmt->bind_param("ssssssss", $nome, $username, $email, $telefone, $endereco, $cpf, $senha, $cargo);

if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
