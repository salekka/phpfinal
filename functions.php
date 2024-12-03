<?php
//Функция для безопасной загрузки цитат из файла
function loadQuotes($filename) 
{
    //Проверка существования файла, возврат пустого массива если файл не найден
    if (!file_exists($filename)) 
    {
        return [];
    }
    
    //Чтение файла с игнорированием пустых строк и переносов
    $quotes = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    //Преобразование каждой строки цитаты в структурированный массив
    return array_map(function($quote) 
    {
        // Разделение строки по символу '|'
        $parts = explode('|', $quote);
        return 
        [
            //Экранирование текста цитаты для безопасности
            'text' => htmlspecialchars($parts[0]),
            //Использование времени из файла или текущего времени
            'time' => $parts[1] ?? date('Y-m-d H:i:s'),
            //Преобразование количества лайков, по умолчанию 0
            'likes' => intval($parts[2] ?? 0),
            //Преобразование количества дизлайков, по умолчанию 0
            'dislikes' => intval($parts[3] ?? 0)
        ];
    }, 
    $quotes);
}

//Функция для безопасного сохранения цитат в файл
function saveQuotes($quotes, $filename) 
{
    //Санитизация цитат перед сохранением
    $sanitizedQuotes = array_map(function($quote) 
    {
        return implode('|', 
        [
            //Замена символов '|' и переноса строки на пробелы
            str_replace(['|', "\n"], [' ', ' '], $quote['text']),
            $quote['time'],
            $quote['likes'],
            $quote['dislikes']
        ]);
    }, $quotes);
    
    //Запись санитизированных цитат в файл
    file_put_contents($filename, implode("\n", $sanitizedQuotes));
}

//Функция генерации случайной цитаты из существующих
function generateRandomQuote($quotesFile) 
{
    // Загрузка существующих цитат
    $quotes = loadQuotes($quotesFile);
    
    // Проверка достаточного количества цитат
    if (count($quotes) < 10) 
    {
        return "Недостаточно цитат для генерации";
    }
    
    //Сбор случайных слов из 10 случайных цитат
    $randomWords = [];
    foreach (array_rand($quotes, 10) as $key) 
    {
        $quoteWords = explode(' ', $quotes[$key]['text']);
        $randomWords[] = $quoteWords[array_rand($quoteWords)];
    }
    
    // Объединение первых 10 случайных слов
    return implode(' ', array_slice($randomWords, 0, 10));
}

//Функция обновления количества лайков/дизлайков
function updateQuoteLikes($filename, $index, $type) 
{
    //Загрузка цитат
    $quotes = loadQuotes($filename);
    
    // Увеличение счетчика лайков/дизлайков для конкретной цитаты
    if (isset($quotes[$index])) 
    {
        $quotes[$index][$type]++;
        //Сохранение обновленных цитат
        saveQuotes($quotes, $filename);
    }
}

//Функция добавления комментария к цитате
function addComment($quoteIndex, $comment) 
{
    //Путь к файлу комментариев
    $commentsFile = 'quotes/comments.txt';
    
    //Санитизация комментария
    $sanitizedComment = htmlspecialchars(trim($comment));
    
    //Формирование строки комментария с индексом цитаты и временем
    $commentData = implode('|', 
    [
        $quoteIndex, 
        $sanitizedComment, 
        date('Y-m-d H:i:s')
    ]);
    
    //Добавление комментария в файл
    file_put_contents($commentsFile, $commentData . "\n", FILE_APPEND);
}

//Функция получения комментариев для конкретной цитаты
function getComments($quoteIndex) 
{
    //Путь к файлу комментариев
    $commentsFile = 'quotes/comments.txt';
    
    //Возврат пустого массива, если файл не существует
    if (!file_exists($commentsFile)) 
    {
        return [];
    }
    
    //Чтение всех комментариев
    $comments = file($commentsFile, FILE_IGNORE_NEW_LINES);
    $quoteComments = [];
    
    //Фильтрация комментариев для конкретной цитаты
    foreach ($comments as $comment) 
    {
        $parts = explode('|', $comment);
        if ($parts[0] == $quoteIndex)
        {
            $quoteComments[] = 
            [
                'text' => $parts[1],
                'time' => $parts[2]
            ];
        }
    }
    
    //Возврат найденных комментариев
    return $quoteComments;
}
?>