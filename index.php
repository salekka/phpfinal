<?php
//Подключение файла с функциями для работы с цитатами
require_once 'functions.php';

//Загрузка цитат из файла 
$quotes = loadQuotes('quotes/quotes.txt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Форум цитат Джейсона Стетхема</title>
    <link rel="stylesheet" href="css/index_style.css">
</head>
<body>
    <div class="statham-background left"></div>
    <div class="statham-background right"></div>
    
    <div class="container">
        <header>
            <h1>Добро пожаловать на лучший форум, лучшего мужика! - Джейсон Стетхэм</h1>
            <!-- Навигационное меню -->
            <nav>
                <a href="index.php">Главная</a>
                <a href="add_quote.html">Добавить цитату</a>
                <a href="generate_quote.html">Сгенерировать цитату</a>
            </nav>
        </header>
        <main>
            <!-- Цикл для вывода всех загруженных цитат -->
            <?php foreach($quotes as $index => $quote): ?>
                <div class="quote-block">
                    <!-- Вывод текста цитаты -->
                    <p><?php echo $quote['text']; ?></p> 
                    <div class="quote-meta">
                        <!-- Вывод времени добавления цитаты -->
                        <span>Добавлено: <?php echo $quote['time']; ?></span>
                        <div class="quote-actions">
                            <!-- Форма для лайков и дизлайков -->
                            <form method="post" action="like.php">
                                <!-- Скрытое поле с индексом цитаты -->
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <!-- Кнопка лайка с отображением количества лайков -->
                                <button type="submit" name="action" value="like">👍 <?php echo $quote['likes']; ?></button>
                                <!-- Кнопка дизлайка с отображением количества дизлайков -->
                                <button type="submit" name="action" value="dislike">👎 <?php echo $quote['dislikes']; ?></button>
                            </form>
                        </div>
                    </div>
                    <div class="comments">
                        <!-- Форма для добавления комментариев -->
                        <form method="post" action="comment.php">
                            <!-- Скрытое поле с индексом цитаты -->
                            <input type="hidden" name="quote_index" value="<?php echo $index; ?>">
                            <!-- Поле ввода комментария -->
                            <input type="text" name="comment" placeholder="Ваш комментарий">
                            <!-- Кнопка отправки комментария -->
                            <button type="submit">Отправить</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>