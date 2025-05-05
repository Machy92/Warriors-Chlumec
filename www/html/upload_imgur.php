<?php

// API klientské ID (získané z Imgur API konzole)
$client_id = '3b096ce2a0494dd';  // Zde nahraď tvým vlastní Client ID

// API endpoint pro nahrání obrázku
$upload_url = 'https://api.imgur.com/3/image';

// Fotka, kterou chceme nahrát (představme si, že máš obrázek 'foto.jpg')
$image_path = '1.jpg';  // Zde nahraď cestou k obrázku, který chceš nahrát

// Inicializujeme cURL
$ch = curl_init();

// Nastavíme cURL parametry
curl_setopt($ch, CURLOPT_URL, $upload_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => new CURLFile($image_path)));

// Spustíme požadavek
$response = curl_exec($ch);

// Zavřeme cURL
curl_close($ch);

// Zpracujeme odpověď
$response_data = json_decode($response, true);

// Pokud je odpověď úspěšná, vypíšeme URL obrázku
if (isset($response_data['data']['link'])) {
    echo "Obrázek byl úspěšně nahrán! Odkaz na obrázek: " . $response_data['data']['link'];
} else {
    echo "Nahrání obrázku selhalo.";
}

?>
