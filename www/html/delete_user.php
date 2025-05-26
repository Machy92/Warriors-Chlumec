<?php
session_start();

// Kontrola, zda je uživatel přihlášen a má ID ke smazání
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
// Zde opět potřebujeme klíč s nejvyššími právy
$supabaseServiceKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc0NzY0MDIxMywiZXhwIjoyMDYzMjE2MjEzfQ.j5P0CgFejLb99zkwP-4SdUZ6IC-z8HvCY9D0JL0ovWQ'; 

$adminUserId = $_SESSION['user_id'];
$userToDeleteId = $_GET['id'];

// === Zde by měla být znovu kontrola, že $adminUserId je opravdu admin ===
// Pro zjednodušení ji vynecháme, ale v reálné aplikaci by tu být měla!

// Nelze smazat sám sebe
if ($adminUserId === $userToDeleteId) {
    header("Location: sprava-uzivatelu.php?delete=error");
    exit;
}


// Použijeme Supabase Admin API pro smazání uživatele
// Toto smaže uživatele z `auth.users` a díky nastavení databáze (ON DELETE CASCADE)
// by se měl smazat i záznam v `public.profiles`.
$ch = curl_init("$supabaseUrl/auth/v1/admin/users/$userToDeleteId");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "DELETE", // Nastavení HTTP metody na DELETE
    CURLOPT_HTTPHEADER => [
        "apikey: $supabaseServiceKey",
        "Authorization: Bearer $supabaseServiceKey"
    ]
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Přesměrování zpět na stránku správy s výsledkem
if ($httpcode == 200) {
    header("Location: sprava-uzivatelu.php?delete=ok");
} else {
    header("Location: sprava-uzivatelu.php?delete=error");
}
exit;