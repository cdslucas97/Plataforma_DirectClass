<?php
// Ativar exibição de erros para ajudar na depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados: " . $conn->connect_error]));
}

// Verifica se o parâmetro disciplinaId foi passado
if (isset($_GET['disciplinaId'])) {
    $disciplinaId = $_GET['disciplinaId']; // Recebe o ID da disciplina da query string

    // Consulta para buscar os professores que lecionam essa disciplina
    $sql = "SELECT pr.Nome, p.CPF, pr.HorarioInicio, pr.HorarioFim, pr.PrecoHora 
            FROM Professor pr
            JOIN Pessoa p ON pr.CPF = p.CPF
            WHERE pr.DisciplinaID = ?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $disciplinaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $professores = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $professores[] = $row;
        }
    } else {
        $professores = []; // Nenhum professor encontrado
    }

    echo json_encode($professores); // Retorna os professores em formato JSON

    $stmt->close();
} else {
    // Caso não haja o parâmetro disciplinaId, retorna todas as disciplinas
    $sql = "SELECT IDDisciplina, Nome FROM Disciplina";
    $result = $conn->query($sql);

    $disciplinas = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $disciplinas[] = $row;
        }
    }

    echo json_encode($disciplinas); // Retorna as disciplinas em formato JSON
}

$conn->close();
?>
