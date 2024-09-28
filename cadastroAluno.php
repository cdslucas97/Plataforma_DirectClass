<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddirectclass";

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Capturar o corpo da requisição JSON
$data = file_get_contents('php://input');
$dados = json_decode($data, true);

// Verificar se os dados foram recebidos corretamente
if (is_null($dados)) {
    die("Erro: Dados não recebidos.");
}

// Extrair as variáveis do JSON decodificado
$nome = $dados['nome'] ?? '';
$username = $dados['username'] ?? '';
$email = $dados['email'] ?? ''; 
$telefone = $dados['telefone'] ?? '';
$endereco = $dados['endereco'] ?? '';
$cpf = $dados['cpf'] ?? '';
$senha = $dados['senha'] ?? '';

// Verificar se todos os campos estão preenchidos
if (empty($nome) || empty($username) || empty($email) || empty($telefone) || empty($endereco) || empty($cpf) || empty($senha)) {
    die("Erro: Todos os campos são obrigatórios.");
}

// Preparar a query de inserção
$sql = "INSERT INTO pessoa (Nome, Username, Email, Telefone, Endereco, Cpf, Senha) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Preparar a declaração SQL
$stmt = $conn->prepare($sql);

// Verificar se a declaração foi preparada corretamente
if ($stmt === false) {
    die("Erro ao preparar a declaração: " . $conn->error);
}

// Associar os parâmetros (todos strings)
$stmt->bind_param("sssssss", $nome, $username, $email, $telefone, $endereco, $cpf, $senha);

// Executar a query
if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();
?>
