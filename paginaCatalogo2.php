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

// Processa a solicitação para agendar aula
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['acao']) && $data['acao'] === 'agendarAula' && isset($data['CPFProfessor'])) {
        $CPFProfessor = $data['CPFProfessor'];

        // Insere o agendamento da aula na tabela aulas_agendadas
        $sql = "INSERT INTO aulas_agendadas (CPFProfessor) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $CPFProfessor);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Erro ao agendar a aula."]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
}

// Novo endpoint para listar aulas agendadas
if (isset($_GET['action']) && $_GET['action'] === 'listarAulas') {
    $sql = "SELECT CPFProfessor, DataHoraAgendamento FROM aulas_agendadas";
    $result = $conn->query($sql);

    $aulas = [];
    while($row = $result->fetch_assoc()) {
        $aulas[] = $row;
    }

    echo json_encode($aulas);
    $conn->close();
    exit;
}

// Consulta disciplinas ou professores
if (isset($_GET['disciplinaId'])) {
    $disciplinaId = $_GET['disciplinaId'];

    $sql = "SELECT pr.Nome, p.CPF, pr.HorarioInicio, pr.HorarioFim, pr.PrecoHora 
            FROM Professor pr
            JOIN Pessoa p ON pr.CPF = p.CPF
            WHERE pr.DisciplinaID = ?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $disciplinaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $professores = [];
    while($row = $result->fetch_assoc()) {
        $professores[] = $row;
    }

    echo json_encode($professores);
    $stmt->close();
} else {
    $sql = "SELECT IDDisciplina, Nome FROM Disciplina";
    $result = $conn->query($sql);

    $disciplinas = [];
    while($row = $result->fetch_assoc()) {
        $disciplinas[] = $row;
    }

    echo json_encode($disciplinas);
}

$conn->close();
?>
