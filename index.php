<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР2 - Вариант 6 - Товпеко Н.И. - 241-352</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <div class="header-text">
                <h1>Лабораторная работа №2 (Вариант 6)</h1>
                <p>Товпеко Н.И. | Группа: 241-352</p>
            </div>
        </div>
    </header>

    <main>
        <div class="content">
            <?php
            // ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕННЫХ
            $start_value = -5;      // Начальное значение аргумента
            $encounting = 15;        // Количество вычисляемых значений
            $step = 0.5;             // Шаг изменения аргумента
            $min_value = -50;        // Минимальное значение функции для остановки
            $max_value = 500;        // Максимальное значение функции для остановки
            $type = 'E';             // Тип верстки (A, B, C, D, E)

            // Подготовка к вычислениям
            $x = $start_value;
            $results = [];
            $computation_stopped = false;

            // Функция вычисления по варианту 6 (исправленная формула)
            function calculateValue($x) {
                // f(x) = x² · 0.33 + 4, при x ≤ 10
                if ($x <= 10) {
                    return $x * $x * 0.33 + 4;
                }
                // 18 · x - 3, при x > 10 и x < 20
                elseif ($x < 20) {
                    return 18 * $x - 3;
                }
                // 1/(x * 0.1 - 2) + 3, при x ≥ 20
                else {
                    $denominator = $x * 0.1 - 2;
                    // Проверка деления на ноль
                    if ($denominator == 0) {
                        return "error";
                    }
                    return (1 / $denominator) + 3;
                }
            }

            // ЦИКЛ ВЫЧИСЛЕНИЙ
            for ($i = 0; $i < $encounting; $i++, $x += $step) {
                $f = calculateValue($x);
                
                // Проверка остановки по мин/макс
                if ($i > 0 && is_numeric($f) && ($f >= $max_value || $f < $min_value)) {
                    $computation_stopped = true;
                    break;
                }
                
                // Сохраняем результат
                $results[] = [
                    'number' => $i + 1,
                    'x' => round($x, 3),
                    'f' => is_numeric($f) ? round($f, 3) : $f
                ];
            }

            // ВЫВОД РЕЗУЛЬТАТОВ
            echo "<h2>Результаты табулирования функции (Вариант 6)</h2>";
            echo "<p>f(x) = x²·0.33 + 4, при x ≤ 10</p>";
            echo "<p>f(x) = 18·x - 3, при 10 < x < 20</p>";
            echo "<p>f(x) = 1/(x·0.1 - 2) + 3, при x ≥ 20</p>";
            echo "<hr>";

            if (empty($results)) {
                echo "<p>Нет результатов для отображения.</p>";
            } else {
                // Конструкция выбора для типа верстки
                switch ($type) {
                    case 'A': // Простая верстка
                        foreach ($results as $res) {
                            echo "f(" . $res['x'] . ") = " . $res['f'] . "<br>";
                        }
                        break;
                        
                    case 'B': // Маркированный список
                        echo "<ul>";
                        foreach ($results as $res) {
                            echo "<li>f(" . $res['x'] . ") = " . $res['f'] . "</li>";
                        }
                        echo "</ul>";
                        break;
                        
                    case 'C': // Нумерованный список
                        echo "<ol>";
                        foreach ($results as $res) {
                            echo "<li>f(" . $res['x'] . ") = " . $res['f'] . "</li>";
                        }
                        echo "</ol>";
                        break;
                        
                    case 'D': // Таблица
                        echo '<table class="result-table">';
                        echo '<thead><tr><th>№</th><th>x</th><th>f(x)</th></tr></thead>';
                        echo '<tbody>';
                        foreach ($results as $res) {
                            echo "<tr><td>{$res['number']}</td><td>{$res['x']}</td><td>{$res['f']}</td></tr>";
                        }
                        echo '</tbody></table>';
                        break;
                        
                    case 'E': // Блочная верстка
                        echo '<div class="block-container">';
                        foreach ($results as $res) {
                            echo '<div class="block-item">f(' . $res['x'] . ') = ' . $res['f'] . '</div>';
                        }
                        echo '</div>';
                        break;
                        
                    default:
                        echo "<p style='color:red;'>Неизвестный тип верстки!</p>";
                }
            }

            // СТАТИСТИКА
            $numericValues = array_filter(array_column($results, 'f'), 'is_numeric');

            if (!empty($numericValues)) {
                $sum = array_sum($numericValues);
                $count = count($numericValues);
                $average = $sum / $count;
                $max = max($numericValues);
                $min = min($numericValues);
                
                echo '<div class="summary">';
                echo "<p><strong>Статистика:</strong></p>";
                echo "<p>Сумма: " . round($sum, 3) . "</p>";
                echo "<p>Среднее арифметическое: " . round($average, 3) . "</p>";
                echo "<p>Максимум: " . round($max, 3) . "</p>";
                echo "<p>Минимум: " . round($min, 3) . "</p>";
                echo '</div>';
            }

            if ($computation_stopped) {
                echo "<p style='color: orange;'><strong>Внимание:</strong> Вычисления остановлены. Значение функции вышло за пределы [{$min_value}, {$max_value}].</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <?php
        // Вывод типа верстки в подвале
        $footer_type = 'E'; // Должно совпадать с $type выше
        echo "Тип верстки: " . htmlspecialchars($footer_type);
        ?>
    </footer>
</body>
</html>