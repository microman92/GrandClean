<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = !empty($_POST['name']) ? $_POST['name'] : '';
    $tel = !empty($_POST['tel']) ? $_POST['tel'] : '';
    $msg = !empty($_POST['msg']) ? $_POST['msg'] : '';

    $tg_bot_token = '7860969702:AAH6tNq9iFqkJa_OZBRcr4eosKLveRaQB2g';
    $chat_id = '73466138';

    $text = "Получена обратная связь:\n\nИмя: $name\nТелефон: $tel\nСообщение: $msg";
    $url = "https://api.telegram.org/bot$tg_bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($text);

    // Инициализация cURL с запросом к Telegram API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if (isset($response_data['ok']) && $response_data['ok']) {
        echo json_encode(['status' => 'success', 'message' => 'Сообщение отправлено в Telegram']);
    } else {
        $error_message = isset($response_data['description']) ? $response_data['description'] : 'Неизвестная ошибка';
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при отправке в Telegram: ' . $error_message]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Некорректный метод запроса']);
}
?>
