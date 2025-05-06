<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

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

// Načtení údajů o uživateli včetně jména a příjmení
$stmt = $conn->prepare("SELECT email, jmeno, prijmeni FROM users WHERE id = :id");
$stmt->bindParam(':id', $_SESSION["user_id"]);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$profileImage = "images/default.png"; // Zatím pevně nastavená profilovka
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil uživatele</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            min-height: calc(100vh - 100px); /* Odsazení od footeru */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-card {
            max-width: 500px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 4px solid #ddd;
        }
        .card-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .card-body {
            padding: 40px;
            text-align: center;
        }
        .btn-danger {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container profile-container">
    <div class="card profile-card">
        <div class="card-body">
            <img src="<?= $profileImage ?>" alt="Profilová fotka" class="profile-img">
            <h3 class="card-title"><?= htmlspecialchars($user["jmeno"] . " " . $user["prijmeni"]) ?></h3>
            <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
            <a href="logout.php" class="btn btn-danger mb-2">Odhlásit se</a>
            <br>
            <a href="change-password.php" class="btn btn-danger">Změnit heslo</a>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
