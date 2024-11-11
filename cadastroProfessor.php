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
$tipo_usuario = 'professor'; // Definindo como professor

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
$sqlPessoa = "INSERT INTO Pessoa (Nome, Username, Email, Telefone, Endereco, CPF, Senha, TipoUsuario) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmtPessoa = $conn->prepare($sqlPessoa);

// Verifica se a preparação foi bem-sucedida
if ($stmtPessoa === false) {
    die("Erro na preparação: " . $conn->error);
}

// Vincula os parâmetros à consulta
$stmtPessoa->bind_param("ssssssss", $nome, $username, $email, $telefone, $endereco, $cpf, $senha, $tipo_usuario);

// Executa a consulta e verifica o resultado
if ($stmtPessoa->execute()) {
    // Recuperando o ID da Pessoa inserida
    $idPessoa = $stmtPessoa->insert_id;

    // Agora, inserindo na tabela Professor
    $sqlProfessor = "INSERT INTO Professor (CPF) VALUES (?)";
    $stmtProfessor = $conn->prepare($sqlProfessor);

    if ($stmtProfessor === false) {
        die("Erro na preparação do professor: " . $conn->error);
    }

    // Vincula os parâmetros à consulta
    $stmtProfessor->bind_param("is", $idPessoa, $cpf);

    // Executa a consulta para inserir o CPF na tabela Professor
    if ($stmtProfessor->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar no Professor: " . $stmtProfessor->error;
    }

    // Fecha a conexão da tabela Professor
    $stmtProfessor->close();
} else {
    echo "Erro ao cadastrar na Pessoa: " . $stmtPessoa->error;
}

// Fecha as conexões
$stmtCheck->close();
$stmtPessoa->close();
$conn->close();
?>
