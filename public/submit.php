<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $selectedOptionsObject = $data["selectedOptions"];
        $phone = $selectedOptionsObject["Номер телефона"];

        $telegramBotToken = "YOUR_TELEGRAM_BOT_TOKEN";
        $chatId = "YOUR_CHAT_ID";

        $telegramMessage = "Номер телефона: $phone\nВыбранные варианты: " . json_encode($selectedOptionsObject);
        $telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$chatId&text=" . urlencode($telegramMessage);
        file_get_contents($telegramApiUrl);

        // Дополнительная логика для отправки данных в AmoCrm
        // Шаг 1: Авторизация в AmoCRM
        $subdomain = 'your_subdomain'; // Замените на ваш поддомен AmoCRM
        $user_login = 'your_login'; // Ваш логин в AmoCRM
        $user_hash = 'your_api_key'; // Ваш API-ключ

        $auth_data = [
            'USER_LOGIN' => $user_login,
            'USER_HASH' => $user_hash,
        ];

        $link = 'https://' . $subdomain . '.amocrm.ru/private/api/auth.php?type=json';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($auth_data));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt'); // Здесь используется путь к файлу cookie.txt для хранения куки-сессии
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Обработка ответа на авторизацию
        $response = json_decode($out, true);

        if ($response && isset($response['response']['auth'])) {
            // Авторизация успешна, продолжаем дальше

            // Шаг 2: Создание сделки и контакта
            $lead_name = 'Новая сделка'; // Название сделки
            $contact_name = 'Имя контакта'; // Имя контакта
            $contact_phone = 'Телефон контакта'; // Телефон контакта
            $contact_email = 'Email контакта'; // Email контакта

            // Создание сделки
            $leads['request']['leads']['add'] = [
                [
                    'name' => $lead_name,
                    'status_id' => 142, // ID статуса сделки в AmoCRM
                ],
            ];

            $link = 'https://' . $subdomain . '.amocrm.ru/private/api/v2/json/leads/set';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($leads));
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

            $out = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            // Обработка ответа на создание сделки
            $response = json_decode($out, true);

            if ($response && isset($response['response']['leads']['add'])) {
                // Сделка создана успешно, получаем её ID
                $lead_id = $response['response']['leads']['add'][0]['id'];

                // Создание контакта и связывание его с сделкой
                $contacts['request']['contacts']['add'] = [
                    [
                        'name' => $contact_name,
                        'linked_leads_id' => [$lead_id],
                        'custom_fields' => [
                            [
                                'id' => 1, // ID поля "Телефон" в AmoCRM
                                'values' => [
                                    [
                                        'value' => $contact_phone,
                                        'enum' => 'MOB',
                                    ],
                                ],
                            ],
                            [
                                'id' => 2, // ID поля "Email" в AmoCRM
                                'values' => [
                                    [
                                        'value' => $contact_email,
                                        'enum' => 'WORK',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ];

                $link = 'https://' . $subdomain . '.amocrm.ru/private/api/v2/json/contacts/set';

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
                curl_setopt($curl, CURLOPT_URL, $link);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contacts));
                curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
                curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

                $out = curl_exec($curl);
                $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                // Обработка ответа на создание контакта
                $response = json_decode($out, true);

                if ($response && isset($response['response']['contacts']['add'])) {
                    // Контакт создан успешно

                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Ошибка при создании контакта']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Ошибка при создании сделки']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка авторизации в AmoCRM']);
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Неверные данные"]);
    }
}
