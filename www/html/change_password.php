<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user_email'];
$oldPassword = $_POST['old_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($newPassword !== $confirmPassword || strlen($newPassword) < 6) {
    header("Location: profil.php?heslo=chyba");
    exit;
}

// 1. Přihlášení pro ověření starého hesla
$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc2NDAyMTMsImV4cCI6MjA2MzIxNjIxM30.h_DdvClVy4-xbEkQ3AWQose3dqPaxPQ1gl-LaLhwtCE'; // zkráceno pro přehlednost
$headers = [
    "apikey: $supabaseKey",
    "Content-Type: application/json"
];

$loginPayload = json_encode([
    "email" => $email,
    "password" => $oldPassword
]);

$ch = curl_init("$supabaseUrl/auth/v1/token?grant_type=password");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $loginPayload,
    CURLOPT_HTTPHEADER => $headers
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    header("Location: profil.php?heslo=chyba");
    exit;
}

$data = json_decode($response, true);
$accessToken = $data['access_token'] ?? null;

if (!$accessToken) {
    header("Location: profil.php?heslo=chyba");
    exit;
}

// 2. Změna hesla
$headers = [
    "apikey: $supabaseKey",
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json"
];

$changePayload = json_encode([
    "password" => $newPassword
]);

$ch = curl_init("$supabaseUrl/auth/v1/user");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => $changePayload,
    CURLOPT_HTTPHEADER => $headers
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    header("Location: profil.php?heslo=ok");
} else {
    header("Location: profil.php?heslo=chyba");
}
exit;
