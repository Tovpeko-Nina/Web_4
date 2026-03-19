<?php
date_default_timezone_set('Europe/Moscow');
?>

<?php
// Функция преобразует число в ссылку на соответствующую таблицу умножения (если число <= 9)
function outNumAsLink($x) {
    // ВАЖНО: при переходе по таким ссылкам тип вёрстки сбрасывается (html_type не передаётся)
    if ($x <= 9 && $x >= 2) {
        return '<a href="?content=' . $x . '">' . $x . '</a>';
    }
    // Для чисел >9 (результат умножения) ссылку не ставим
    return $x;
}

// Функция выводит один столбец таблицы умножения для числа $n
function outRow($n) {
    for ($i = 2; $i <= 9; $i++) {
        // Формируем строку вида "2x3=6", где цифры (кроме результата) — ссылки
        echo outNumAsLink($n) . 'x' . outNumAsLink($i) . '=' . outNumAsLink($i * $n) . '<br>';
    }
}

// --- Определяем текущие параметры ---
// Тип вёрстки: сохраняем значение, если параметр передан
$html_type = isset($_GET['html_type']) ? $_GET['html_type'] : 'TABLE';
// Содержимое: если параметр content передан, используем его, иначе null (вся таблица)
$content = isset($_GET['content']) ? (int)$_GET['content'] : null;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №5: Таблица умножения</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">

    <!-- ШАПКА: Главное меню (табличная / блочная вёрстка) -->
    <div class="header">
        <?php
        // Ссылка для табличной вёрстки (сохраняем текущий content, если есть)
        echo '<a href="?html_type=TABLE';
        if ($content !== null) {
            echo '&content=' . $content;
        }
        echo '"';
        // Проверяем, передан ли параметр html_type и равен ли он TABLE
        if (isset($_GET['html_type']) && $_GET['html_type'] === 'TABLE') {
            echo ' class="selected"';
        }
        echo '>Табличная верстка</a>';

        // Ссылка для блочной вёрстки (сохраняем текущий content, если есть)
        echo '<a href="?html_type=DIV';
        if ($content !== null) {
            echo '&content=' . $content;
        }
        echo '"';
        // Проверяем, передан ли параметр html_type и равен ли он DIV
        if (isset($_GET['html_type']) && $_GET['html_type'] === 'DIV') {
            echo ' class="selected"';
        }
        echo '>Блочная верстка</a>';
        ?>
    </div>

    <!-- ОСНОВНАЯ ЧАСТЬ: левое меню + контент -->
    <div class="main">
        <!-- Левое меню (выбор множителя) -->
        <div class="sidebar">
            <?php
            // Ссылка "Всё" (вся таблица). Не передаёт content.
            echo '<a href="?html_type=' . $html_type . '"';
            // Проверяем, что параметр content НЕ передан
            if (!isset($_GET['content'])) {
                echo ' class="selected"';
            }
            echo '>Всё</a>';

            // Ссылки для цифр 2..9
            for ($i = 2; $i <= 9; $i++) {
                echo '<a href="?html_type=' . $html_type . '&content=' . $i . '"';
                // Проверяем, передан ли параметр content и равен ли он текущему i
                if (isset($_GET['content']) && $_GET['content'] == $i) {
                    echo ' class="selected"';
                }
                echo '>' . $i . '</a>';
            }
            ?>
        </div>

        <!-- Контент: таблица умножения -->
        <div class="content">
            <?php
            // Функция вывода всей таблицы или одного столбца в зависимости от вёрстки
            if ($html_type === 'TABLE') {
                // --- ТАБЛИЧНАЯ ВЁРСТКА ---
                echo '<div class="table-layout">';
                echo '<table>';
                if ($content === null) {
                    // Вся таблица: 8 столбцов (со 2 по 9)
                    echo '<tr>';
                    for ($col = 2; $col <= 9; $col++) {
                        echo '<td>';
                        echo '<strong>Таблица на ' . $col . '</strong><br>';
                        for ($row = 2; $row <= 9; $row++) {
                            echo outNumAsLink($col) . ' x ' . outNumAsLink($row) . ' = ' . outNumAsLink($col * $row) . '<br>';
                        }
                        echo '</td>';
                    }
                    echo '</tr>';
                } else {
                    // Один столбец
                    echo '<tr><td class="single-column">';
                    echo '<strong>Таблица на ' . $content . '</strong><br>';
                    for ($row = 2; $row <= 9; $row++) {
                        echo outNumAsLink($content) . ' x ' . outNumAsLink($row) . ' = ' . outNumAsLink($content * $row) . '<br>';
                    }
                    echo '</td></tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                // --- БЛОЧНАЯ ВЁРСТКА ---
                echo '<div class="block-layout">';
                if ($content === null) {
                    // Вся таблица: много блоков .ttRow
                    for ($col = 2; $col <= 9; $col++) {
                        echo '<div class="ttRow">';
                        echo '<strong>Таблица на ' . $col . '</strong><br>';
                        for ($row = 2; $row <= 9; $row++) {
                            echo outNumAsLink($col) . ' x ' . outNumAsLink($row) . ' = ' . outNumAsLink($col * $row) . '<br>';
                        }
                        echo '</div>';
                    }
                } else {
                    // Один столбец
                    echo '<div class="ttSingleRow">';
                    echo '<strong>Таблица на ' . $content . '</strong><br>';
                    for ($row = 2; $row <= 9; $row++) {
                        echo outNumAsLink($content) . ' x ' . outNumAsLink($row) . ' = ' . outNumAsLink($content * $row) . '<br>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="footer">
        <?php
        // Определяем тип вёрстки текстом
        $typeStr = ($html_type === 'TABLE') ? 'Табличная верстка' : 'Блочная верстка';
        // Определяем содержимое
        if ($content === null) {
            $contentStr = 'полная таблица умножения';
        } else {
            $contentStr = 'столбец таблицы умножения на ' . $content;
        }
        // Текущая дата и время
        $now = date('d.m.Y H:i:s');
        echo "<span>$typeStr</span> | <span>$contentStr</span> | <span>$now</span>";
        ?>
    </div>

</div>
</body>
</html>