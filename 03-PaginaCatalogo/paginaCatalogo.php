<?php
// Configurações de conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // ou sua senha do banco de dados
$dbname = "directclass";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se estamos carregando as disciplinas
if (isset($_GET['loadDisciplinas']) && $_GET['loadDisciplinas'] === 'true') {
    $disciplinas = [];
    $sqlDisciplinas = "SELECT IDDisciplina, Nome FROM Disciplina";
    $resultDisciplinas = $conn->query($sqlDisciplinas);

    if ($resultDisciplinas->num_rows > 0) {
        while ($row = $resultDisciplinas->fetch_assoc()) {
            $disciplinas[] = $row;
        }
    }
    
    echo json_encode($disciplinas); // Retorna as disciplinas em formato JSON
    $conn->close();
    exit; // Encerra o script aqui para evitar que ele continue
}

// A partir deste ponto é a lógica de buscar professores com base nos filtros
$disciplina = isset($_GET['disciplina']) ? $_GET['disciplina'] : '';
$localidade = isset($_GET['localidade']) ? $_GET['localidade'] : '';
$aulaOnline = isset($_GET['aulaOnline']) && $_GET['aulaOnline'] == 'true';
$precoMin = isset($_GET['precoMin']) ? $_GET['precoMin'] : '';
$precoMax = isset($_GET['precoMax']) ? $_GET['precoMax'] : '';
$horarioInicio = isset($_GET['horarioInicio']) ? $_GET['horarioInicio'] : '';
$horarioFim = isset($_GET['horarioFim']) ? $_GET['horarioFim'] : '';
$diasSemana = isset($_GET['diasSemana']) ? explode(',', $_GET['diasSemana']) : [];

// Montando a consulta SQL para buscar professores filtrados
$sql = "SELECT Professor.*, Disciplina.Nome AS DisciplinaNome
        FROM Professor
        JOIN ProfessorDisciplina ON Professor.IDProfessor = ProfessorDisciplina.IDProfessor
        JOIN Disciplina ON ProfessorDisciplina.IDDisciplina = Disciplina.IDDisciplina
        WHERE 1=1";

// Filtros
if (!empty($disciplina)) {
    $sql .= " AND Disciplina.IDDisciplina = '$disciplina'";
}

if (!empty($localidade) && !$aulaOnline) {
    $sql .= " AND Professor.Localidade = '$localidade'";
}

if ($aulaOnline) {
    $sql .= " AND Professor.AulaOnline = 1";
}

if (!empty($precoMin)) {
    $sql .= " AND Professor.PrecoHora >= '$precoMin'";
}

if (!empty($precoMax)) {
    $sql .= " AND Professor.PrecoHora <= '$precoMax'";
}

if (!empty($horarioInicio)) {
    $sql .= " AND Professor.HorarioInicio >= '$horarioInicio'";
}

if (!empty($horarioFim)) {
    $sql .= " AND Professor.HorarioFim <= '$horarioFim'";
}

if (!empty($diasSemana)) {
    $diasFiltrados = implode("', '", $diasSemana);
    $sql .= " AND Disponibilidade.DiaSemana IN ('$diasFiltrados')";
}

// Executando a consulta
$result = $conn->query($sql);

// Buscando as disciplinas para preencher no HTML
$disciplinas = [];
$sqlDisciplinas = "SELECT IDDisciplina, Nome FROM Disciplina";
$resultDisciplinas = $conn->query($sqlDisciplinas);

if ($resultDisciplinas->num_rows > 0) {
    while ($row = $resultDisciplinas->fetch_assoc()) {
        $disciplinas[] = $row;
    }
}

// Retorna o resultado como JSON para ser consumido pelo JavaScript (AJAX)
$professores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $professores[] = $row;
    }
}
echo json_encode($professores);

// Fechar a conexão
$conn->close();
?>
