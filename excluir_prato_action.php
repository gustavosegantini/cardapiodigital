<?php
require '../conect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $conn = conectarBD();
    $sql = "DELETE FROM pratos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>
