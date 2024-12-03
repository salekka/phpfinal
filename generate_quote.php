<?php
//Подключение файла с функциями для работы с цитатами
require_once 'functions.php';

//Генерация случайной цитаты из существующих цитат в файле
$generatedQuote = generateRandomQuote('quotes/quotes.txt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сгенерированная цитата</title>
    <link rel="stylesheet" href="css/index_style.css">
</head>
<body>
    <div class="statham-background left"></div>
    <div class="statham-background right"></div>
    <div class="container">
        <header>
            <h1>Сгенерированная цитата</h1>
            <nav>
                <a href="index.php">Главная</a>
                <a href="add_quote.html">Добавить цитату</a>
                <a href="generate_quote.html">Сгенерировать цитату</a>
            </nav>
        </header>

        <main>
            <div class="generated-quote-block">
                <p><?php echo htmlspecialchars($generatedQuote); ?></p>
                <a href="generate_quote.html" class="btn">Сгенерировать еще</a>
            </div>
        </main>
    </div>
</body>
</html>