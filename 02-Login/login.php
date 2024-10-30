<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "directclass";

$conn = new mysqli($servername, $username, $password, $dbname);

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "SELECT * FROM pessoa WHERE (Email = ? OR Username = ?) AND Senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email,$email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
