<?php
session_start();

// Připojení k databázi
$host = "postgres";
$dbname = "warriorschlumec";
$user = "postgres";
$password = "qwerty";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Chyba připojení: " . $e->getMessage());
}

// Kontrola, zda je uživatel přihlášen
if (!isset($_SESSION["user_id"])) {
    die("Přístup odepřen. Musíte být přihlášen.");
}

// Kontrola, zda je zadáno ID článku
if (!isset($_GET["id"])) {
    die("Chyba: Nebylo zadáno ID článku.");
}

$article_id = $_GET["id"];

// Smazání článku
$stmt = $conn->prepare("DELETE FROM articles WHERE id = :id");
$stmt->bindParam(":id", $article_id, PDO::PARAM_INT);
$stmt->execute();

// Přesměrování zpět na aktuality
header("Location: aktuality.php?deleted=success");
exit;
?>
