<?php
// Configurações de conexão ao banco de dados
$servername = "localhost";
$username = "root"; // Usuário do MySQL (ou outro usuário que você configurou)
$password = ""; // Senha do MySQL (geralmente vazio no XAMPP)
$dbname = "directclass"; // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - DirectClass</title>
    <link rel="stylesheet" href="homepage.css">
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

    <!-- Mensagem de boas-vindas -->
    <section class="intro">
        <h2>Encontre o professor certo para você!</h2>
    </section>

    <!-- Formulário de busca -->
    <section class="search-form">
        <form id="searchForm">
            <div class="form-group">
                <label for="disciplina">Disciplina:</label>
                <select id="disciplina" name="disciplina" required>
                    <option value="">Selecione uma disciplina</option>
                    <?php
                    // Consulta para buscar as disciplinas
                    $sql = "SELECT IDDisciplina, Nome FROM Disciplina";
                    $result = $conn->query($sql);

                    // Verifica se há resultados e preenche o select
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["IDDisciplina"] . "'>" . $row["Nome"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhuma disciplina disponível</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="localidade">Localidade:</label>
                <input type="text" id="localidade" name="localidade" placeholder="Informe a sua cidade">
                <input type="checkbox" id="aulaOnline" name="aulaOnline"> Aula Online
            </div>

            <button type="button" class="btn-search" id="buscar">Buscar</button>
            <!-- Mensagem de erro -->
            <div id="error-message" style="display:none; color: red; margin-top: 10px;"></div>
        </form>
    </section>

    <!-- Link para o arquivo JavaScript da homepage -->
    <script src="homepage.js"></script>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
