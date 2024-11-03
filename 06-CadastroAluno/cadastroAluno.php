<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Capturando os dados do formulário
$nome = $_POST['nome'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? ''; 
$telefone = $_POST['telefone'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$senha = $_POST['senha'] ?? '';
$tipo_usuario = 'aluno'; // Definindo como aluno

// Verifica se email, CPF ou username já estão cadastrados
$sqlCheck = "SELECT * FROM Pessoa WHERE Email = ? OR CPF = ? OR Username = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("sss", $email, $cpf, $username);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    die("Erro: Email, CPF ou Username já cadastrados.");
}

// Inserindo os dados na tabela Pessoa
$sql = "INSERT INTO Pessoa (Nome, Username, Email, Telefone, Endereco, CPF, Senha, TipoUsuario) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verifica se a preparação foi bem-sucedida
if ($stmt === false) {
    die("Erro na preparação: " . $conn->error);
}

// Vincula os parâmetros à consulta
$stmt->bind_param("ssssssss", $nome, $username, $email, $telefone, $endereco, $cpf, $senha, $tipo_usuario);

// Executa a consulta e verifica o resultado
if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";

    // Agora, insira o CPF na tabela Aluno
    $sqlAluno = "INSERT INTO Aluno (CPF) VALUES (?)";
    $stmtAluno = $conn->prepare($sqlAluno);
    $stmtAluno->bind_param("s", $cpf);

    // Executa a consulta para inserir na tabela Aluno
    if ($stmtAluno->execute()) {
        echo "";
    } else {
        echo "Erro ao cadastrar aluno: " . $stmtAluno->error;
    }

    // Fecha a declaração de Aluno
    $stmtAluno->close();
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fecha as conexões
$stmtCheck->close();
$stmt->close();
$conn->close();
?>
