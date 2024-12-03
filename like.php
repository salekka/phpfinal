<?php
//Подключение файла с функциями для работы с цитатами
require_once 'functions.php';

//Проверка, что запрос является POST-запросом
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Получение индекса цитаты из POST-данных
    $index = $_POST['index'];
    
    //Получение типа действия (лайк или дизлайк)
    $action = $_POST['action'];
    
    //Проверка, что действие - лайк
    if ($action === 'like') 
    {
        //Обновление количества лайков для конкретной цитаты
        updateQuoteLikes('quotes/quotes.txt', $index, 'likes');
    } 
    //Проверка, что действие - дизлайк
    elseif ($action === 'dislike') 
    {
        //Обновление количества дизлайков для конкретной цитаты
        updateQuoteLikes('quotes/quotes.txt', $index, 'dislikes');
    }
    
    //Перенаправление пользователя обратно на главную страницу
    header('Location: index.php');
    
    // Завершение выполнения скрипта после перенаправления
    exit();
}
?>