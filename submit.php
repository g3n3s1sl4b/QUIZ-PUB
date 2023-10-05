<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $telegramBotToken = "2080212883:AAE4Qs7lmG3jigf60I5SNrfDzgZnI11KhTA";
        $chatId = "116324420";

        $telegramMessage = "
        Ваш официальный доход: " . implode(", ", $data["Ваш официальный доход ?"]) . "
Ваш трудовой статус: " . implode(", ", $data["Ваш трудовой статус ?"]) . "
Общая сумма задолженности: " . implode(", ", $data["Общая сумма задолженности ?"]) . "
Потребуется сбор документов: " . implode(", ", $data["Потребуется сбор документов ?"]) . "
У Вас есть имущество: " . implode(", ", $data["У Вас есть имущество ?"]) . "
Укажите тип вашего долга: " . implode(", ", $data["Укажите тип вашего долга"]) . "
Что вас сейчас беспокоит: " . implode(", ", $data["Что вас сейчас беспокоит ?"]) . "
Номер телефона: " . $data["Номер телефона"] . "
";

        $telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$chatId&text=" . urlencode($telegramMessage);
        file_get_contents($telegramApiUrl);
    
include 'toamo.php';
}
}
