<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат сортировки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1, h2, h3 {
            color: #333;
        }
        h3 {
            margin: 15px 0 10px 0;
            font-size: 16px;
        }
        .algorithm-name {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #2196F3;
        }
        .input-data {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }
        .validation-success {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #4CAF50;
        }
        .validation-error {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #f44336;
        }
        .iteration {
            font-family: monospace;
            padding: 8px;
            margin: 5px 0;
            border-left: 3px solid #4CAF50;
            background-color: #f9f9f9;
            font-size: 13px;
        }
        .iteration-number {
            font-weight: bold;
            color: #2196F3;
        }
        .array-state {
            font-family: monospace;
        }
        .result {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            border-left: 4px solid #4CAF50;
        }
        strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        
        // Функция проверки: является ли аргумент НЕ числом
        function arg_is_not_Num($arg) {
            if($arg === '') return true;
            // Удаляем пробелы в начале и конце
            $arg = trim($arg);
            // Проверяем, является ли строка числом (включая отрицательные и дробные)
            if(is_numeric($arg)) {
                return false;
            }
            return true;
        }
        
        // 1. Сортировка выбором
        function selectionSort(&$arr, &$iterations) {
            $n = count($arr);
            $iterations = 0;
            $swaps = 0;
            echo "<h3>Процесс сортировки выбором:</h3>";
            
            for($i = 0; $i < $n - 1; $i++) {
                $min = $i;
                for($j = $i + 1; $j < $n; $j++) {
                    if($arr[$j] < $arr[$min]) {
                        $min = $j;
                    }
                }
                if($min != $i) {
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$min];
                    $arr[$min] = $temp;
                    $swaps++;
                }
                $iterations++;
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Итерация " . $iterations . ":</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                if($min == $i) {
                    echo " (минимальный элемент уже на месте)";
                }
                echo "</div>";
            }
        }
        
        // 2. Пузырьковая сортировка 
        function bubbleSort(&$arr, &$iterations) {
            $n = count($arr);
            $iterations = 0;
            echo "<h3>Процесс пузырьковой сортировки:</h3>";
            
            // Выводим исходное состояние
            echo "<div class='iteration'>";
            echo "<span class='iteration-number'>Начальное состояние:</span> ";
            echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
            echo "</div>";
            
            for($i = 0; $i < $n - 1; $i++) {
                $swapped = false;
                for($j = 0; $j < $n - $i - 1; $j++) {
                    if($arr[$j] > $arr[$j + 1]) {
                        $temp = $arr[$j];
                        $arr[$j] = $arr[$j + 1];
                        $arr[$j + 1] = $temp;
                        $swapped = true;
                    }
                }
                $iterations++;
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Проход " . $iterations . " (после " . ($n - $i - 1) . " сравнений):</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
                if(!$swapped) {
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>Досрочное завершение: массив отсортирован</span>";
                    echo "</div>";
                    break;
                }
            }
        }
        
        // 3. Сортировка Шелла
        function shellSort(&$arr, &$iterations) {
            $n = count($arr);
            $iterations = 0;
            echo "<h3>Процесс сортировки Шелла:</h3>";
            
            // Выводим исходное состояние
            echo "<div class='iteration'>";
            echo "<span class='iteration-number'>Начальное состояние:</span> ";
            echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
            echo "</div>";
            
            for($gap = floor($n / 2); $gap > 0; $gap = floor($gap / 2)) {
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Шаг = " . $gap . ":</span>";
                echo "</div>";
                
                for($i = $gap; $i < $n; $i++) {
                    $temp = $arr[$i];
                    $j = $i;
                    while($j >= $gap && $arr[$j - $gap] > $temp) {
                        $arr[$j] = $arr[$j - $gap];
                        $j -= $gap;
                    }
                    $arr[$j] = $temp;
                    $iterations++;
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>  Итерация " . $iterations . " (вставка элемента " . $i . "):</span> ";
                    echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                    echo "</div>";
                }
            }
        }
        
        // 4. Сортировка садового гнома
        function gnomeSort(&$arr, &$iterations) {
            $n = count($arr);
            $iterations = 0;
            echo "<h3>Процесс сортировки садового гнома:</h3>";
            
            // Выводим исходное состояние
            echo "<div class='iteration'>";
            echo "<span class='iteration-number'>Начальное состояние:</span> ";
            echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
            echo "</div>";
            
            $i = 1;
            $step = 0;
            
            while($i < $n) {
                if($i == 0 || $arr[$i - 1] <= $arr[$i]) {
                    $i++;
                } else {
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$i - 1];
                    $arr[$i - 1] = $temp;
                    $i--;
                }
                $step++;
                $iterations++;
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Шаг " . $step . " (позиция i=" . $i . "):</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
            }
        }
        
        // 5. Быстрая сортировка
        function quickSort(&$arr, $left, $right, &$iterations, &$stepCounter) {
            if($left >= $right) return;
            
            $pivot = $arr[floor(($left + $right) / 2)];
            $l = $left;
            $r = $right;
            $partitionChanged = false;
            
            while($l <= $r) {
                while($arr[$l] < $pivot) $l++;
                while($arr[$r] > $pivot) $r--;
                if($l <= $r) {
                    $temp = $arr[$l];
                    $arr[$l] = $arr[$r];
                    $arr[$r] = $temp;
                    $l++;
                    $r--;
                    $partitionChanged = true;
                }
            }
            
            if($partitionChanged) {
                $iterations++;
                $stepCounter++;
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Шаг " . $stepCounter . " (разбиение):</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
            }
            
            quickSort($arr, $left, $r, $iterations, $stepCounter);
            quickSort($arr, $l, $right, $iterations, $stepCounter);
        }
        
        function quickSortWrapper(&$arr, &$iterations) {
            $iterations = 0;
            $stepCounter = 0;
            echo "<h3>Процесс быстрой сортировки:</h3>";
            echo "<div class='iteration'>";
            echo "<span class='iteration-number'>Исходное состояние:</span> ";
            echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
            echo "</div>";
            quickSort($arr, 0, count($arr) - 1, $iterations, $stepCounter);
        }
        
        // 6. Встроенная сортировка
        function builtinSort(&$arr, &$iterations) {
            $iterations = 1;
            echo "<h3>Используется встроенная функция sort():</h3>";
            echo "<div class='iteration'>";
            echo "<span class='iteration-number'>Исходный массив:</span> ";
            echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
            echo "</div>";
            sort($arr);
            echo "<div class='iteration'>";
            echo "<span class='iteration-number'>После сортировки:</span> ";
            echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
            echo "</div>";
        }
        
        $algorithmNames = [
            0 => "Сортировка выбором",
            1 => "Пузырьковая сортировка",
            2 => "Сортировка Шелла",
            3 => "Сортировка садового гнома",
            4 => "Быстрая сортировка",
            5 => "Встроенная функция PHP (sort)"
        ];
        
        // 1. Проверка наличия данных
        if(!isset($_POST['element0'])) {
            echo "<div class='validation-error'>";
            echo "<strong>Ошибка:</strong> Массив не задан, сортировка невозможна.";
            echo "</div>";
            exit();
        }
        
        $arrLength = isset($_POST['arrLength']) ? (int)$_POST['arrLength'] : 0;
        
        if($arrLength == 0) {
            echo "<div class='validation-error'>";
            echo "<strong>Ошибка:</strong> Массив пуст, сортировка невозможна.";
            echo "</div>";
            exit();
        }
        
        // 2. Проверка элементов на числа
        $inputArray = [];
        $hasError = false;
        
        for($i = 0; $i < $arrLength; $i++) {
            $fieldName = 'element' . $i;
            if(!isset($_POST[$fieldName])) {
                echo "<div class='validation-error'>";
                echo "<strong>Ошибка:</strong> Элемент с индексом $i отсутствует.";
                echo "</div>";
                $hasError = true;
                break;
            }
            $value = trim($_POST[$fieldName]);
            if($value === '' || !is_numeric($value)) {
                echo "<div class='validation-error'>";
                echo "<strong>Ошибка:</strong> Элемент массива \"" . htmlspecialchars($value) . "\" (индекс $i) не является числом.";
                echo "</div>";
                $hasError = true;
                break;
            }
            $inputArray[] = (float)$value;
        }
        
        if($hasError) {
            exit();
        }
        
        // 3. Получение выбранного алгоритма
        $algorithm = isset($_POST['algorithm']) ? (int)$_POST['algorithm'] : 0;
        
        // 4. Вывод информации
        echo "<div class='algorithm-name'>";
        echo "<h2>" . $algorithmNames[$algorithm] . "</h2>";
        echo "</div>";
        
        echo "<div class='input-data'>";
        echo "<strong>Входные данные:</strong><br>";
        echo "[" . implode(", ", array_map(function($v) { return round($v, 4); }, $inputArray)) . "]";
        echo "</div>";
        
        echo "<div class='validation-success'>";
        echo "Проверка входных данных: все элементы являются числами. Сортировка возможна.";
        echo "</div>";
        
        // Создаем копию массива для сортировки
        $arr = $inputArray;
        
        // 5. Засекаем время
        $timeStart = microtime(true);
        
        // 6. Запуск сортировки
        $iterations = 0;
        
        switch($algorithm) {
            case 0:
                selectionSort($arr, $iterations);
                break;
            case 1:
                bubbleSort($arr, $iterations);
                break;
            case 2:
                shellSort($arr, $iterations);
                break;
            case 3:
                gnomeSort($arr, $iterations);
                break;
            case 4:
                quickSortWrapper($arr, $iterations);
                break;
            case 5:
                builtinSort($arr, $iterations);
                break;
            default:
                selectionSort($arr, $iterations);
        }
        
        // 7. Вычисляем затраченное время
        $timeEnd = microtime(true);
        $timeElapsed = $timeEnd - $timeStart;
        
        // 8. Вывод результатов
        echo "<div class='result'>";
        echo "Сортировка завершена, проведено $iterations итераций.<br>";
        echo "Сортировка заняла " . number_format($timeElapsed, 6) . " секунд.<br>";
        echo "<strong>Отсортированный массив:</strong> [" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]";
        echo "</div>";
        
        ?>
    </div>
</body>
</html>