<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $jmeno = $_POST["jmeno"];
    $pozice = $_POST["pozice"];

    $supabaseUrl = "https://opytqyxheeezvwncboly.supabase.co";
    $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc2NDAyMTMsImV4cCI6MjA2MzIxNjIxM30.h_DdvClVy4-xbEkQ3AWQose3dqPaxPQ1gl-LaLhwtCE"; // tvůj klíč

    // 1. Registrace uživatele přes Supabase Auth
    $data = [
        "email" => $email,
        "password" => $password
    ];

    $ch = curl_init("$supabaseUrl/auth/v1/signup");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);

    $response = curl_exec($ch);
    $userData = json_decode($response, true);
    curl_close($ch);

    if (isset($userData["user"]["id"])) {
        $user_id = $userData["user"]["id"];
        
        // 2. Vložení do tabulky profiles
        $profileData = [
            "id" => $user_id,
            "jmeno" => $jmeno,
            "pozice" => $pozice,
            "vytvoreno" => date('c') // ISO8601 čas, např. 2025-05-19T17:45:00+00:00
        ];

        $ch2 = curl_init("$supabaseUrl/rest/v1/profiles");
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($profileData));
        curl_setopt($ch2, CURLOPT_HTTPHEADER, [
            "apikey: $apiKey",
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json",
            "Prefer: return=representation"
        ]);
        curl_setopt($ch2, CURLOPT_POST, true);

        $profileResponse = curl_exec($ch2);
        curl_close($ch2);

        header("Location: login.php?registered=1");
        exit();
    } else {
        $error = "Registrace selhala: " . $userData["msg"];
    }
}
?>

<!-- HTML formulář -->
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Registrace uživatele</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" class="p-4 border bg-white shadow-sm rounded">
        <div class="mb-3">
            <label>E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Heslo:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jméno:</label>
            <input type="text" name="jmeno" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Pozice:</label>
            <input type="text" name="pozice" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Registrovat</button>
    </form>
</div>
</body>
</html>
