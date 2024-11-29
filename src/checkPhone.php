<?php


function checkPhone($phone, $name)
{
    $file = 'data/submissions.json';

    $existingData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    foreach ($existingData as $submission) {
        if ($submission['phone'] === $phone) {
            die('Вы уже отправили заявку.');
        }
    }

    $existingData[] = ['name' => $name, 'phone' => $phone];
    file_put_contents($file, json_encode($existingData));
}


