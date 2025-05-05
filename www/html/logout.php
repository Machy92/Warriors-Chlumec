<?php
session_start();

// Zničíme session
session_destroy();

// Uložíme zprávu o odhlášení
session_start(); // Musíme session znovu spustit, aby šlo nastavit zprávu
$_SESSION["message"] = "👋 Úspěšně jste se odhlásili.";
$_SESSION["message_type"] = "success";

header("Location: index.php");
exit;
?>
