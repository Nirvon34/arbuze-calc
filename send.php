<?php
header('Content-Type: application/json; charset=utf-8');

// Получаем данные
$inn     = $_POST['inn'] ?? '';
$phone   = $_POST['phone'] ?? '';
$email   = $_POST['email'] ?? '';
$tariff  = $_POST['tariff'] ?? '';
$region  = $_POST['region'] ?? '';

// Валидация
if (!preg_match('/^\d{12}$/', $inn)) {
    http_response_code(400);
    echo json_encode(['error' => 'ИНН должен содержать 12 цифр']);
    exit;
}

if (!preg_match('/^\d{11}$/', $phone)) {
    http_response_code(400);
    echo json_encode(['error' => 'Телефон должен содержать 11 цифр']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверный формат email']);
    exit;
}

// Отправка письма
$to = 'your@email.com'; // 👉 замени на свой email
$subject = 'Новая заявка с калькулятора';
$message = "Тариф: $tariff\nРегион: $region\nИНН: $inn\nТелефон: $phone\nEmail: $email";
$headers = "From: no-reply@yourdomain.com\r\n";

mail($to, $subject, $message, $headers);

echo json_encode(['success' => true]);
