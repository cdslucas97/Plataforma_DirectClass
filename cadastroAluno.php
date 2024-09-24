©<!-- --><?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddirectclass";

$conn = new mysqli($servername, $username, $password, $dbname);

$nome = $_POST['nome'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? ''; 
$telefone = $_POST['telefone'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "INSERT * INTO pessoa WHERE Nome = nome AND Username = username AND Email = email AND Telefone = telefone AND Endereco = endereco AND Cpf = cpf AND Senha = senha;" 
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conn->close();
?>
