<?php

// Telegram bot tokenini olish (Railway Variables yoki qo'lda yozish mumkin)
$TOKEN = getenv("8014932469:AAFsZHhQKhaqDqlwtKJanPuwVZ6Z85K8xbU"); // Railway Variable
$API_URL = "https://api.telegram.org/bot8014932469:AAFsZHhQKhaqDqlwtKJanPuwVZ6Z85K8xbU/";

// Foydalanuvchidan kelgan ma'lumotni olish
$update = json_decode(file_get_contents("php://input"), TRUE);
$message = $update["message"] ?? null;

if ($message) {
    $chat_id = $message["chat"]["id"];
    $text = $message["text"] ?? "";

    if ($text == "/start") {
        sendMessage($chat_id, "👋 *Salom!* Men Telegram User Info botiman.\nℹ️ *Mavjud buyruqlar:*\n/info - Foydalanuvchi ma'lumotlari\n/help - Yordam olish", "Markdown");
    } elseif ($text == "/info") {
        $user_info = getUserInfo($message["from"]);
        sendMessage($chat_id, $user_info, "Markdown");
    } elseif ($text == "/help") {
        sendMessage($chat_id, "🆘 *Yordam:*\n📌 /start - Bot haqida\n📌 /info - Foydalanuvchi ma'lumotlari\n📌 /help - Yordam olish", "Markdown");
    } else {
        sendMessage($chat_id, "❌ *Noto'g'ri buyruq!* Buyruqlarni tekshiring: /help", "Markdown");
    }
}

// Foydalanuvchi haqida ma'lumot olish funksiyasi
function getUserInfo($user) {
    $first_name = $user["first_name"] ?? "Noma'lum";
    $last_name = $user["last_name"] ?? "";
    $username = $user["username"] ?? "Mavjud emas";
    $user_id = $user["id"];

    return "👤 *Foydalanuvchi Ma'lumoti:*\n" .
           "🆔 *ID:* `$user_id`\n" .
           "👤 *Ism:* $first_name $last_name\n" .
           "📛 *Username:* @$username";
}

// Xabar yuborish funksiyasi
function sendMessage($chat_id, $text, $parse_mode = "HTML") {
    global $API_URL;
    $url = $API_URL . "sendMessage";
    $post_fields = [
        "chat_id" => $chat_id,
        "text" => $text,
        "parse_mode" => $parse_mode
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

?>
