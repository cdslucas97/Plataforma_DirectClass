<?php
// Configurações de conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "directclass";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar as disciplinas
$sql = "SELECT IDDisciplina, Nome FROM Disciplina";
$result = $conn->query($sql);

// Criando array de disciplinas
$disciplinas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disciplinas[] = $row;
    }
}

// Enviando os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($disciplinas);

// Fechando a conexão com o banco de dados
$conn->close();
?>
