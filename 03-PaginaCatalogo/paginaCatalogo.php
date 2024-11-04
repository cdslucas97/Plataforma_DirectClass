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

// Carregar disciplinas
if (isset($_GET['loadDisciplinas']) && $_GET['loadDisciplinas'] === 'true') {
    $disciplinas = [];
    $sqlDisciplinas = "SELECT IDDisciplina, Nome FROM Disciplina";
    $resultDisciplinas = $conn->query($sqlDisciplinas);

    if ($resultDisciplinas->num_rows > 0) {
        while ($row = $resultDisciplinas->fetch_assoc()) {
            $disciplinas[] = $row;
        }
    }
    
    echo json_encode($disciplinas);
    $conn->close();
    exit;
}

// Carregar conteúdos de uma disciplina específica
if (isset($_GET['disciplina_id'])) {
    $disciplinaId = $_GET['disciplina_id'];
    $conteudos = [];
    $sqlConteudos = "SELECT conteudo.IDConteudo, conteudo.Nome
                     FROM conteudo
                     JOIN disciplinaConteudo ON conteudo.IDConteudo = disciplinaConteudo.IDConteudo
                     WHERE disciplinaConteudo.IDDisciplina = ?";
    $stmt = $conn->prepare($sqlConteudos);
    $stmt->bind_param("i", $disciplinaId);
    $stmt->execute();
    $resultConteudos = $stmt->get_result();

    while ($row = $resultConteudos->fetch_assoc()) {
        $conteudos[] = $row;
    }

    echo json_encode($conteudos);
    $conn->close();
    exit;
}

// Carregar professores com base nos filtros
if (isset($_GET['disciplina']) && !empty($_GET['disciplina'])) {
    $disciplina = $_GET['disciplina'];
    $localidade = isset($_GET['localidade']) ? $_GET['localidade'] : '';
    $aulaOnline = isset($_GET['aulaOnline']) && $_GET['aulaOnline'] == 'true';
    $precoMin = isset($_GET['precoMin']) ? $_GET['precoMin'] : '';
    $precoMax = isset($_GET['precoMax']) ? $_GET['precoMax'] : '';
    $horarioInicio = isset($_GET['horarioInicio']) ? $_GET['horarioInicio'] : '';
    $horarioFim = isset($_GET['horarioFim']) ? $_GET['horarioFim'] : '';
    $diasSemana = isset($_GET['diasSemana']) ? explode(',', $_GET['diasSemana']) : [];

    // Consulta para buscar professores filtrados
    $sql = "SELECT Professor.*, Disciplina.Nome AS DisciplinaNome
            FROM Professor
            JOIN ProfessorDisciplina ON Professor.IDProfessor = ProfessorDisciplina.IDProfessor
            JOIN Disciplina ON ProfessorDisciplina.IDDisciplina = Disciplina.IDDisciplina
            WHERE Disciplina.IDDisciplina = ?";

    // Array para parâmetros de filtragem
    $params = ["i", $disciplina];

    // Filtros opcionais
    if (!empty($localidade) && !$aulaOnline) {
        $sql .= " AND Professor.Localidade = ?";
        $params[0] .= "s"; // Tipo de dado é string
        $params[] = $localidade;
    }

    if ($aulaOnline) {
        $sql .= " AND Professor.AulaOnline = 1";
    }

    if (!empty($precoMin)) {
        $sql .= " AND Professor.PrecoHora >= ?";
        $params[0] .= "d"; // Tipo de dado é decimal
        $params[] = $precoMin;
    }

    if (!empty($precoMax)) {
        $sql .= " AND Professor.PrecoHora <= ?";
        $params[0] .= "d";
        $params[] = $precoMax;
    }

    if (!empty($horarioInicio)) {
        $sql .= " AND Professor.HorarioInicio >= ?";
        $params[0] .= "s";
        $params[] = $horarioInicio;
    }

    if (!empty($horarioFim)) {
        $sql .= " AND Professor.HorarioFim <= ?";
        $params[0] .= "s";
        $params[] = $horarioFim;
    }

    if (!empty($diasSemana)) {
        $diasFiltrados = implode("', '", $diasSemana);
        $sql .= " AND Disponibilidade.DiaSemana IN ('$diasFiltrados')";
    }

    // Preparando a consulta com os filtros
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    // Recuperando os dados dos professores
    $professores = [];
    while ($row = $result->fetch_assoc()) {
        $professores[] = $row;
    }

    // Retornando os dados em JSON
    echo json_encode($professores);
    $conn->close();
    exit;
}

// Fechar a conexão caso não haja outro encerramento acima
$conn->close();
?>