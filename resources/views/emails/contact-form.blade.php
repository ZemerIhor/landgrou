<!DOCTYPE html>
<html>
<head>
    <title>Нове повідомлення з форми зворотнього зв’язку</title>
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Нове повідомлення з форми зворотнього зв’язку</h1>
    <p><span class="label">Ім'я:</span> {{ htmlspecialchars($name) }}</p>
    <p><span class="label">Email:</span> {{ htmlspecialchars($email) }}</p>
    <p><span class="label">Телефон:</span> {{ htmlspecialchars($phone ?? 'Не вказано') }}</p>
    <p><span class="label">Тема:</span> {{ htmlspecialchars($subject) }}</p>
    <p><span class="label">Повідомлення:</span> {{ htmlspecialchars($formMessage) }}</p> <!-- Line 35: Fixed from $message -->
    <p><span class="label">Рейтинг:</span> {{ htmlspecialchars($rating) }} зір{{ $rating == 1 ? 'ка' : 'ки' }}</p>
</div>
</body>
</html>
