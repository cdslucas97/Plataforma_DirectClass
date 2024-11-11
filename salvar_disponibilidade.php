<?php
// Configurações de conexão com o banco de dados
$host = 'localhost'; // ou o endereço do seu servidor
$dbname = 'directclass';
$username = 'root';  // seu usuário do banco
$password = '';  // sua senha do banco

// Criação da conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    exit();
}

// Verificação do envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $diaSemana = $_POST['diaSemana'];
    $horarioInicio = $_POST['horarioInicio'];
    $horarioFim = $_POST['horarioFim'];

    // Verifica se o professor está logado e obtem o ID
    session_start();
    if (!isset($_SESSION['CPF'])) {
        echo "Você não está logado.";
        exit();
    }
    $idProfessor = $_SESSION['idProfessor'];

    // Prepara o comando SQL para inserir a disponibilidade
    $sqlDisponibilidade = "INSERT INTO Disponibilidade (DiaSemana, HorarioInicio, HorarioFim) 
                           VALUES (:diaSemana, :horarioInicio, :horarioFim)";
    $stmt = $pdo->prepare($sqlDisponibilidade);
    $stmt->bindParam(':diaSemana', $diaSemana);
    $stmt->bindParam(':horarioInicio', $horarioInicio);
    $stmt->bindParam(':horarioFim', $horarioFim);
    
    if ($stmt->execute()) {
        // Obtém o ID da última disponibilidade inserida
        $idDisponibilidade = $pdo->lastInsertId();

        // Relaciona a disponibilidade ao professor
        $sqlProfessorDisponibilidade = "INSERT INTO ProfessorDisponibilidade (IDProfessor, IDDisponibilidade) 
                                        VALUES (:idProfessor, :idDisponibilidade)";
        $stmt2 = $pdo->prepare($sqlProfessorDisponibilidade);
        $stmt2->bindParam(':idProfessor', $idProfessor);
        $stmt2->bindParam(':idDisponibilidade', $idDisponibilidade);

        if ($stmt2->execute()) {
            echo "Disponibilidade salva com sucesso!";
        } else {
            echo "Erro ao salvar a disponibilidade do professor.";
        }
    } else {
        echo "Erro ao salvar a disponibilidade.";
    }
}
?>
