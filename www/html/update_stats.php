<?php
// Ochrana proti neautorizovanému spuštění
if (!isset($_GET['key']) || $_GET['key'] !== 'mojetajneheslo') {
    http_response_code(403);
    exit('Přístup zamítnut.');
}

// Cesta k JSON souboru
$path = __DIR__ . '/hraci.json';

// Načtení dat
$jsonData = file_get_contents($path);
$players = json_decode($jsonData, true);

// Úprava statistik
foreach ($players as &$player) {
    if (strtolower($player['position']) === 'brankář') {
        $player['saves'] += rand(0, 5);
        $player['goals_against'] += rand(0, 3);
        $player['matches'] += 1;
        $player['shots_against'] = $player['saves'] + $player['goals_against'];
        $player['save_pct'] = round(($player['saves'] / max($player['shots_against'], 1)) * 100, 2);
    } else {
        $player['goals'] += rand(0, 2);
        $player['assists'] += rand(0, 2);
        $player['points'] = $player['goals'] + $player['assists'];
        $player['matches'] += 1;
    }
}

// Uložení změn
file_put_contents($path, json_encode($players, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// Výstup
echo "Statistiky byly aktualizovány: " . date("Y-m-d H:i:s") . PHP_EOL;
