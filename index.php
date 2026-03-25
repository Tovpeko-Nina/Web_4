<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР4 - Товпеко Н.И. 241-352</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <div class="header-text">
                <h1>Лабораторная работа №4</h1>
                <p>Товпеко Н.И. 241-352</p>
            </div>
        </div>
    </header>

    <main>
        <div class="content">
            <?php

            // 1. Инициализация переменной с числом колонок
            $numberOfColumns = 3; //  число колонок

            // 2. Массив со структурами таблиц (минимум 10 элементов)
            $tableStructures = array(
                "Яблоки*Бананы*Апельсины#5 кг*3 кг*2 кг",
                "Книга*Автор*Год#Война и мир*Толстой*1869#Преступление и наказание*Достоевский*1866",
                "Модель*Процессор*ОЗУ#ThinkPad*i5*8 ГБ#MacBook Air*M1*8 ГБ#XPS 13*i7*16 ГБ",
                "Студент*Группа*Оценка#Иванов*7*5#Петров*7*4",
                "Страна*Столица*Население#Франция*Париж*67.4 млн#Германия*Берлин*83.2 млн",
                "Город*Основан*Регион#Москва*1147*ЦФО#СПб*1703*СЗФО",
                "Язык*Дата создания*Рейтинг#PHP*1995*78%#C++*1983*62%",
                "Дисциплина*Семестр*Часы#Физика*3*144#Информатика*2*128",
                "Имя*Возраст*Город#Анна*25*Москва#Павел*30*Казань",
                "Производитель*Модель*Год выпуска#Samsung*Galaxy S23*2023#Apple*iPhone 14*2022" 
            );

            // 3. Функция для формирования одной строки таблицы
            function getTR($data, $cols) {
                // Разбиваем строку на ячейки по разделителю '*'
                $cells = explode('*', $data);
                $ret = '<tr>';

                // Проходим по требуемому количеству колонок
                for ($i = 0; $i < $cols; $i++) {
                    // Если ячейка с таким индексом существует, используем её, иначе - пустая ячейка
                    $cellContent = isset($cells[$i]) ? htmlspecialchars($cells[$i]) : '&nbsp;'; 
                    $ret .= '<td>' . $cellContent . '</td>';
                }

                $ret .= '</tr>';
                return $ret;
            }

            // 4. Функция для вывода полной таблицы
            function outTable($structure, $tableNumber, $cols) {
                echo "<h2>Таблица №" . $tableNumber . "</h2>";

                // Проверка на нулевое количество колонок
                if ($cols <= 0) {
                    echo "<p>Неправильное число колонок.</p>";
                    return;
                }

                // Разбиваем структуру на строки по разделителю '#'
                $rows = explode('#', $structure);
                $rows = array_filter($rows, 'strlen'); // Удаляем пустые строки (например, если структура заканчивается на #)

                // Проверка, есть ли строки вообще
                if (empty($rows)) {
                    echo "<p>В таблице нет строк.</p>";
                    return;
                }

                $rowsHtml = '';
                $hasNonEmptyRow = false;

                // Перебираем все строки
                foreach ($rows as $rowData) {
                    // Проверяем, есть ли в строке ячейки (не пустая ли она после разбора)
                    $cellsInRow = explode('*', $rowData);
                    $cellsInRow = array_filter($cellsInRow, 'strlen'); // Удаляем пустые ячейки

                    if (!empty($cellsInRow)) {
                        // Если есть хотя бы одна непустая ячейка, генерируем HTML для строки
                        $rowsHtml .= getTR($rowData, $cols);
                        $hasNonEmptyRow = true;
                    }
                }

                // Финальные проверки перед выводом таблицы
                if (!$hasNonEmptyRow) {
                    echo "<p>В таблице нет строк с ячейками.</p>";
                } else {
                    echo '<table border="1" cellpadding="5" cellspacing="0">' . $rowsHtml . '</table>';
                }
            }

            // 5. Основная логика: перебираем массив и выводим таблицы
            $tableCounter = 1;
            foreach ($tableStructures as $structure) {
                outTable($structure, $tableCounter++, $numberOfColumns);
            }

            ?>
        </div>
    </main>

    <footer>
        <?php
        echo "<p>"."</p>";
        ?>
    </footer>
</body>
</html>