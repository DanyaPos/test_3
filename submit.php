<?php
require_once 'src/checkPhone.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($phone)) {
        die('Пожалуйста, заполните все поля.');
    }

    checkPhone($phone, $name);

    $data = [
        'stream_code' => 'vv4uf',
        'client' => [
            'phone' => $phone,
            'name' => $name,
        ],
    ];
    $jsonData = json_encode($data);

    $url = 'https://order.drcash.sh/v1/order';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer RLPUUOQAMIKSAB2PSGUECA',
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        header('Location: thankyou.php');
        exit;
    } else {
        echo 'Произошла ошибка при отправке данных. Попробуйте снова.';
    }
} else {
    header('Location: index.php');
    exit;
}

