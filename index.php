<?php
header('Content-Type: text/html; charset=utf-8');

// Инициализация переменных для сохранения введенных данных при повторном тесте
$saved_fio = '';
$saved_group = '';
$random_a = mt_rand(0, 100) + mt_rand(0, 100) / 100; // Случайное число от 0 до 100 с дробной частью
$random_b = mt_rand(0, 100) + mt_rand(0, 100) / 100;
$random_c = mt_rand(0, 100) + mt_rand(0, 100) / 100;

// Проверяем, были ли переданы GET-параметры от кнопки "Повторить тест"
if (isset($_GET['FIO']) && isset($_GET['GROUP'])) {
    $saved_fio = htmlspecialchars($_GET['FIO']);
    $saved_group = htmlspecialchars($_GET['GROUP']);
}

// Проверяем, была ли отправлена форма (POST-запрос с данными)
$form_processed = false;
$result = null;
$out_text = '';
$task_name = '';
$user_answer = null;
$computed_result = null;
$test_passed = false;

if (isset($_POST['A']) && isset($_POST['TASK'])) {
    $form_processed = true;
    
    // Получаем данные из формы
    $fio = htmlspecialchars(trim($_POST['FIO']));
    $group = htmlspecialchars(trim($_POST['GROUP']));
    $about = htmlspecialchars(trim($_POST['ABOUT']));
    $task = $_POST['TASK'];
    $a = str_replace(',', '.', $_POST['A']); // Заменяем запятую на точку для корректного вычисления
    $b = str_replace(',', '.', $_POST['B']);
    $c = str_replace(',', '.', $_POST['C']);
    $user_answer_raw = trim($_POST['RESULT']);
    $mail = htmlspecialchars(trim($_POST['MAIL']));
    $send_mail_flag = isset($_POST['send_mail']);
    $view_mode = $_POST['view_mode']; // 'browser' или 'print'
    
    // Преобразуем в числа с плавающей точкой
    $a_num = floatval($a);
    $b_num = floatval($b);
    $c_num = floatval($c);
    
    // Определяем название задачи и вычисляем результат
    $computed_result = null;
    switch ($task) {
        case 'triangle_area':
            $task_name = 'Площадь треугольника (по формуле Герона)';
            // Формула Герона: sqrt(p * (p - a) * (p - b) * (p - c)), где p = (a + b + c) / 2
            $p = ($a_num + $b_num + $c_num) / 2;
            $computed_result = sqrt($p * ($p - $a_num) * ($p - $b_num) * ($p - $c_num));
            $computed_result = round($computed_result, 2);
            break;
        case 'triangle_perimeter':
            $task_name = 'Периметр треугольника';
            $computed_result = round($a_num + $b_num + $c_num, 2);
            break;
        case 'parallelepiped_volume':
            $task_name = 'Объем параллелепипеда';
            $computed_result = round($a_num * $b_num * $c_num, 2);
            break;
        case 'arithmetic_mean':
            $task_name = 'Среднее арифметическое';
            $computed_result = round(($a_num + $b_num + $c_num) / 3, 2);
            break;
        case 'hypotenuse':
            $task_name = 'Гипотенуза прямоугольного треугольника (катеты A и B)';
            $computed_result = round(sqrt(pow($a_num, 2) + pow($b_num, 2)), 2);
            break;
        case 'quadratic_roots':
            $task_name = 'Корни квадратного уравнения (A*x^2 + B*x + C = 0)';
            $discriminant = pow($b_num, 2) - 4 * $a_num * $c_num;
            if ($discriminant >= 0) {
                $x1 = round((- $b_num + sqrt($discriminant)) / (2 * $a_num), 2);
                $x2 = round((- $b_num - sqrt($discriminant)) / (2 * $a_num), 2);
                $computed_result = "x1 = $x1, x2 = $x2";
            } else {
                $computed_result = "Нет действительных корней";
            }
            break;
        default:
            $task_name = 'Неизвестная задача';
            $computed_result = null;
    }
    
    // Обработка пользовательского ответа
    if ($user_answer_raw === '') {
        $user_answer = 'Задача самостоятельно решена не была';
        $test_passed = false;
    } else {
        $user_answer = htmlspecialchars($user_answer_raw);
        // Сравнение для числовых результатов
        if (is_numeric($computed_result) && is_numeric(str_replace(',', '.', $user_answer_raw))) {
            $user_num = floatval(str_replace(',', '.', $user_answer_raw));
            $test_passed = (abs($computed_result - $user_num) < 0.0001);
        } else {
            // Для строковых результатов (например, корни уравнения)
            $test_passed = ($user_answer_raw == $computed_result);
        }
    }
    
    // Формируем текст отчета
    $out_text = "<div class='report'>";
    $out_text .= "<h3>Результаты тестирования</h3>";
    $out_text .= "<p><strong>ФИО:</strong> $fio</p>";
    $out_text .= "<p><strong>Группа:</strong> $group</p>";
    if (!empty($about)) {
        $out_text .= "<p><strong>О себе:</strong> $about</p>";
    }
    $out_text .= "<p><strong>Тип задачи:</strong> $task_name</p>";
    $out_text .= "<p><strong>Входные данные:</strong> A = " . number_format($a_num, 2, '.', '') . 
                 ", B = " . number_format($b_num, 2, '.', '') . 
                 ", C = " . number_format($c_num, 2, '.', '') . "</p>";
    $out_text .= "<p><strong>Ваш ответ:</strong> $user_answer</p>";
    $out_text .= "<p><strong>Вычисленный программой результат:</strong> " . 
                 (is_numeric($computed_result) ? number_format($computed_result, 2, '.', '') : $computed_result) . "</p>";
    
    if ($test_passed) {
        $out_text .= "<p class='success'><strong>Тест пройден</strong></p>";
    } else {
        $out_text .= "<p class='error'><strong>Ошибка: тест не пройден</strong></p>";
    }
    $out_text .= "</div>";
    
    // Вывод отчета в браузер
    echo $out_text;
    
    // Отправка email, если установлен флажок
    if ($send_mail_flag && !empty($mail)) {
        $plain_text = strip_tags(str_replace(['<br>', '</p>', '<p>', '<div>', '</div>', '<h3>', '</h3>', '<strong>', '</strong>'], "\r\n", $out_text));
        $plain_text = preg_replace('/\s+/', ' ', $plain_text);
        $subject = '=?UTF-8?B?' . base64_encode('Результаты тестирования') . '?=';
        $headers = "From: auto@testlab.ru\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
        
        if (mail($mail, $subject, $plain_text, $headers)) {
            echo "<p class='mail-notice'>Результаты теста были автоматически отправлены на e-mail $mail</p>";
        } else {
            echo "<p class='mail-error'>Ошибка при отправке письма. Пожалуйста, проверьте адрес электронной почты.</p>";
        }
    }
    
    // Кнопка "Повторить тест" только для версии в браузере
    if ($view_mode == 'browser') {
        $encoded_fio = urlencode($fio);
        $encoded_group = urlencode($group);
        echo "<a href='?FIO=$encoded_fio&GROUP=$encoded_group' class='repeat-button'>Повторить тест</a>";
    }
    
} // Конец обработки формы

// Если форма еще не была обработана (первая загрузка или после "Повторить тест")
if (!$form_processed) {
    // Генерируем случайные числа для полей A, B, C
    $a_val = number_format(mt_rand(0, 10000) / 100, 2, '.', '');
    $b_val = number_format(mt_rand(0, 10000) / 100, 2, '.', '');
    $c_val = number_format(mt_rand(0, 10000) / 100, 2, '.', '');
    
    // Если есть сохраненные данные из GET, используем их
    $fio_value = $saved_fio;
    $group_value = $saved_group;
    
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Лабораторная работа А-6: Тестирование</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: #f5f5f5;
            }
            .form-container {
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .form-row {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
                flex-wrap: wrap;
            }
            .form-row label {
                width: 180px;
                font-weight: bold;
                text-align: left;
                margin-right: 10px;
            }
            .form-row input[type="text"],
            .form-row input[type="email"],
            .form-row select,
            .form-row textarea {
                flex: 1;
                min-width: 200px;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .form-row textarea {
                resize: vertical;
            }
            .form-row input[type="checkbox"] {
                width: auto;
                margin-left: 190px;
            }
            .checkbox-row {
                margin-left: 190px;
            }
            .submit-row {
                margin-top: 20px;
                text-align: left;
            }
            .submit-row button {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .submit-row button:hover {
                background-color: #45a049;
            }
            .report {
                background: white;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .success {
                color: green;
                font-weight: bold;
            }
            .error {
                color: red;
                font-weight: bold;
            }
            .mail-notice {
                background: #e7f3fe;
                padding: 10px;
                border-left: 4px solid #2196F3;
                margin: 10px 0;
            }
            .repeat-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #008CBA;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                border: 1px solid #007B9E;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .repeat-button:hover {
                background-color: #005f7a;
            }
            .hidden-field {
                display: none;
            }
            hr {
                margin: 20px 0;
            }
            @media print {
                body {
                    background: white;
                    margin: 0;
                    padding: 0;
                }
                .form-container, .repeat-button {
                    display: none;
                }
                .report {
                    box-shadow: none;
                    padding: 0;
                }
            }
        </style>
        <script>
            function toggleEmailField() {
                var checkbox = document.getElementById('send_mail_checkbox');
                var emailDiv = document.getElementById('email_div');
                if (checkbox.checked) {
                    emailDiv.style.display = 'flex';
                } else {
                    emailDiv.style.display = 'none';
                }
            }
            
            // Инициализация при загрузке страницы
            document.addEventListener('DOMContentLoaded', function() {
                toggleEmailField();
            });
        </script>
    </head>
    <body>
        <div class="form-container">
            <form method="post" action="">
                <!-- Скрытое поле для определения версии просмотра -->
                <input type="hidden" name="view_mode" id="view_mode" value="browser">
                
                <div class="form-row">
                    <label for="FIO">ФИО:</label>
                    <input type="text" name="FIO" id="FIO" value="<?php echo $fio_value; ?>" required>
                </div>
                
                <div class="form-row">
                    <label for="GROUP">Номер группы:</label>
                    <input type="text" name="GROUP" id="GROUP" value="<?php echo $group_value; ?>" required>
                </div>
                
                <div class="form-row">
                    <label for="A">Значение А:</label>
                    <input type="text" name="A" id="A" value="<?php echo $a_val; ?>" required>
                </div>
                
                <div class="form-row">
                    <label for="B">Значение В:</label>
                    <input type="text" name="B" id="B" value="<?php echo $b_val; ?>" required>
                </div>
                
                <div class="form-row">
                    <label for="C">Значение С:</label>
                    <input type="text" name="C" id="C" value="<?php echo $c_val; ?>" required>
                </div>
                
                <div class="form-row">
                    <label for="RESULT">Ваш ответ:</label>
                    <input type="text" name="RESULT" id="RESULT">
                </div>
                
                <div class="form-row">
                    <label for="ABOUT">Немного о себе:</label>
                    <textarea name="ABOUT" id="ABOUT" rows="3"></textarea>
                </div>
                
                <div class="form-row">
                    <label for="TASK">Выберите задачу:</label>
                    <select name="TASK" id="TASK">
                        <option value="triangle_area">Площадь треугольника (по формуле Герона)</option>
                        <option value="triangle_perimeter">Периметр треугольника</option>
                        <option value="parallelepiped_volume">Объем параллелепипеда</option>
                        <option value="arithmetic_mean">Среднее арифметическое</option>
                        <option value="hypotenuse">Гипотенуза прямоугольного треугольника</option>
                        <option value="quadratic_roots">Корни квадратного уравнения</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <label for="view_mode_select">Версия:</label>
                    <select name="view_mode_select" id="view_mode_select" onchange="document.getElementById('view_mode').value = this.value;">
                        <option value="browser">Версия для просмотра в браузере</option>
                        <option value="print">Версия для печати</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <input type="checkbox" name="send_mail" id="send_mail_checkbox" onclick="toggleEmailField()">
                    <label for="send_mail_checkbox" style="width: auto;">Отправить результат теста по e-mail</label>
                </div>
                
                <div class="form-row" id="email_div" style="display: none;">
                    <label for="MAIL">Ваш e-mail:</label>
                    <input type="email" name="MAIL" id="MAIL">
                </div>
                
                <div class="submit-row">
                    <button type="submit">Проверить</button>
                </div>
            </form>
        </div>
    </body>
    </html>
    <?php
} // Конец вывода формы
?>