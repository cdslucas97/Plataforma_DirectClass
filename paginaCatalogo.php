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

// Recebendo parâmetros da URL (GET)
$disciplina = isset($_GET['disciplina']) ? $_GET['disciplina'] : '';
$localidade = isset($_GET['localidade']) ? $_GET['localidade'] : '';
$aulaOnline = isset($_GET['aulaOnline']) && $_GET['aulaOnline'] == 'true';

// Montando a consulta SQL para buscar professores filtrados
$sql = "SELECT Professor.*, Disciplina.Nome AS DisciplinaNome
        FROM Professor
        JOIN ProfessorDisciplina ON Professor.IDProfessor = ProfessorDisciplina.IDProfessor
        JOIN Disciplina ON ProfessorDisciplina.IDDisciplina = Disciplina.IDDisciplina
        WHERE 1=1";

// Filtro por Disciplina
if (!empty($disciplina)) {
    $sql .= " AND Disciplina.IDDisciplina = '$disciplina'";
}

// Filtro por Localidade (se necessário adicionar essa coluna no Professor)
if (!empty($localidade) && !$aulaOnline) {
    $sql .= " AND Professor.Localidade = '$localidade'";
}

// Filtro por Aula Online (caso essa coluna exista na tabela Professor)
if ($aulaOnline) {
    $sql .= " AND Professor.AulaOnline = 1";
}

$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - DirectClass</title>
    <link rel="stylesheet" href="paginaCatalogo.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="logo-button">
            <a href="homepage.php" class="btn-logo">DirectClass</a>
        </div>
        <div class="login-button">
            <a href="login.php" class="btn-login">Login</a>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <div class="catalog-container">
        <!-- Filtros (Lado Esquerdo) -->
        <aside class="filter-sidebar">
            <h3>Filtros</h3>

            <!-- Filtro de Disciplina -->
            <label for="disciplina">Disciplina:</label>
            <select id="disciplina" required>
                <option value="">Selecione uma disciplina</option>
                <?php
                // Carregar as disciplinas do banco de dados dinamicamente
                $sqlDisciplinas = "SELECT * FROM Disciplina";
                $disciplinas = $conn->query($sqlDisciplinas);
                while ($row = $disciplinas->fetch_assoc()) {
                    echo "<option value='" . $row['IDDisciplina'] . "'>" . $row['Nome'] . "</option>";
                }
                ?>
            </select>

            <!-- Filtro de Localidade -->
            <label for="localidade">Localidade:</label>
            <input type="text" id="localidade" placeholder="Digite sua cidade">
            <input type="checkbox" id="aulaOnline" name="aulaOnline"> Aula Online

            <!-- Filtro de Conteúdo -->
            <label for="conteudo">Conteúdo:</label>
            <select id="conteudo">
                <option>Selecione o conteúdo</option>
            </select>

            <!-- Filtro de Preço -->
            <label for="preco-min">Preço Mínimo:</label>
            <input type="text" id="preco-min" placeholder="R$ Mínimo">
            
            <label for="preco-max">Preço Máximo:</label>
            <input type="text" id="preco-max" placeholder="R$ Máximo">

            <!-- Filtro de Disponibilidade -->
            <h4>Disponibilidade:</h4>
            <div class="disponibilidade-checkboxes">
                <label><input type="checkbox"> Segunda</label>
                <label><input type="checkbox"> Terça</label>
                <label><input type="checkbox"> Quarta</label>
                <label><input type="checkbox"> Quinta</label>
                <label><input type="checkbox"> Sexta</label>
                <label><input type="checkbox"> Sábado</label>
                <label><input type="checkbox"> Domingo</label>
            </div>

            <!-- Horários -->
            <label for="horario-inicio">Horário Início:</label>
            <input type="text" id="horario-inicio" placeholder="00:00">

            <label for="horario-fim">Horário Fim:</label>
            <input type="text" id="horario-fim" placeholder="23:59">

            <!-- Botão Filtrar -->
            <button class="btn-filtrar" onclick="validarCampos()">Filtrar</button>

            <!-- Mensagem de erro customizada -->
            <div id="error-message" style="display:none; color:red; margin-top: 15px;"></div>
        </aside>

        <!-- Lista de Professores (Lado Direito) -->
        <section class="professor-list">
            <h2>Professores Disponíveis</h2>
            <?php
            // Verificar se há resultados
            if ($result->num_rows > 0) {
                while ($professor = $result->fetch_assoc()) {
                    echo "
                    <div class='professor-card'>
                        <img src='professor.jpg' alt='Foto do Professor'>
                        <div class='professor-info'>
                            <h3>{$professor['Nome']}</h3>
                            <p>Preço: R$ {$professor['PrecoHora']} / hora</p>
                            <p>Disponibilidade: {$professor['Disponibilidade']}</p>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>Nenhum professor encontrado com esses filtros.</p>";
            }
            ?>
        </section>
    </div>

    <!-- Link para o arquivo JavaScript da página de catálogo -->
    <script src="paginaCatalogo.js"></script>
</body>
</html>

<?php
$conn->close();
?>
