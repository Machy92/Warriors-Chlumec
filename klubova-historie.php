<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warriors Chlumec</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
</head>
<body>
    <nav>
    <?php include 'header.php'; ?>
    </nav>
</body>

<main>
    <h1>Vítejte na stránkách týmu Warriors Chlumec</h1>
    <p>Aktuální informace o týmu, zápasech a hráčských statistikách.</p>
</main>

<?php include 'footer.php'; ?>

</html>