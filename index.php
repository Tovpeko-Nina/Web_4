<?php
session_start();

// Инициализация истории и счётчика загрузок
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
    $_SESSION['iteration'] = 0;
}
$_SESSION['iteration']++;

// Вспомогательная функция: проверка, является ли строка числом
function isnum($x) {
    if (!isset($x) || $x === "") return false;
    if ($x[0] == '.') return false;
    // Разрешаем "0" и "0.5", но запрещаем "00", "01" и т.д.
    if ($x[0] == '0' && strlen($x) > 1 && $x[1] != '.') return false;
    if ($x[strlen($x) - 1] == '.') return false;

    $point_count = false;
    for ($i = 0; $i < strlen($x); $i++) {
        $c = $x[$i];
        if (!ctype_digit($c) && $c != '.') return false;
        if ($c == '.') {
            if ($point_count) return false;
            $point_count = true;
        }
    }
    return true;
}

// Функция вычисления выражения БЕЗ скобок
function calculate($val) {
    if ($val === "") return 'Выражение не задано!';
    if (isnum($val)) return $val;

    // Сложение
    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        foreach ($args as $arg) {
            $res = calculate($arg);
            if (!isnum($res)) return $res;
            $sum += (float)$res;
        }
        return (string)$sum;
    }

    // Вычитание
    $args = explode('-', $val);
    if (count($args) > 1) {
        $result = calculate($args[0]);
        if (!isnum($result)) return $result;
        for ($i = 1; $i < count($args); $i++) {
            $sub = calculate($args[$i]);
            if (!isnum($sub)) return $sub;
            $result -= (float)$sub;
        }
        return (string)$result;
    }

    // Умножение
    $args = explode('*', $val);
    if (count($args) > 1) {
        $product = 1;
        foreach ($args as $arg) {
            if (!isnum($arg)) return 'Неправильная форма числа!';
            $product *= (float)$arg;
        }
        return (string)$product;
    }

    // Деление (/ или :)
    $args = preg_split('/[\/:]/', $val);
    if (count($args) > 1) {
        $div = calculate($args[0]);
        if (!isnum($div)) return $div;
        for ($i = 1; $i < count($args); $i++) {
            $d = calculate($args[$i]);
            if (!isnum($d)) return $d;
            if ((float)$d == 0) return 'Деление на ноль!';
            $div /= (float)$d;
        }
        return (string)$div;
    }

    return 'Недопустимые символы в выражении';
}

// Проверка правильности скобок
function SqValidator($val) {
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') $open++;
        elseif ($val[$i] == ')') {
            $open--;
            if ($open < 0) return false;
        }
    }
    return $open == 0;
}

// Вычисление выражений СО скобками
function calculateSq($val) {
    if (!SqValidator($val)) return 'Неправильная расстановка скобок';

    $start = strpos($val, '(');
    if ($start === false) return calculate($val);

    $end = $start + 1;
    $open = 1;
    while ($open > 0 && $end < strlen($val)) {
        if ($val[$end] == '(') $open++;
        elseif ($val[$end] == ')') $open--;
        $end++;
    }

    $left = substr($val, 0, $start);
    $middle = substr($val, $start + 1, $end - $start - 2);
    $right = substr($val, $end);

    $middleResult = calculateSq($middle);
    if (!isnum($middleResult)) return $middleResult;

    return calculateSq($left . $middleResult . $right);
}

// Обработка POST-запроса
$res = null;
$displayResult = false;

if (
    isset($_POST['val']) &&
    isset($_POST['iteration']) &&
    ($_POST['iteration'] + 1 == $_SESSION['iteration'])
) {
    $expr = trim($_POST['val']);
    $res = calculateSq($expr);

    if (isnum($res)) {
        $displayResult = true;
    } else {
        $displayResult = false;
    }

    // Сохраняем в историю
    $_SESSION['history'][] = htmlspecialchars($expr) . ' = ' . htmlspecialchars($res);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Арифметический калькулятор</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .result { margin-bottom: 20px; font-weight: bold; background: #f0f0f0; padding: 10px; }
        .history { margin-top: 30px; border-top: 1px solid #ccc; padding-top: 10px; }
        .history div { font-family: monospace; }
    </style>
</head>
<body>

<h2>Калькулятор</h2>

<?php if ($displayResult && $res !== null): ?>
    <div class="result">
        Результат: <?= htmlspecialchars($res) ?>
    </div>
<?php elseif ($res !== null && !$displayResult): ?>
    <div class="result" style="color: red;">
        Ошибка: <?= htmlspecialchars($res) ?>
    </div>
<?php endif; ?>

<form method="post">
    <label>Выражение (целые и дробные числа, + - * / : и скобки):</label><br>
    <input type="text" name="val" size="40" required>
    <input type="hidden" name="iteration" value="<?= $_SESSION['iteration'] ?>">
    <br><br>
    <input type="submit" value="Вычислить">
</form>

<div class="history">
    <h3>История вычислений</h3>
    <?php
    foreach ($_SESSION['history'] as $line) {
        echo '<div>' . htmlspecialchars($line) . '</div>';
    }
    ?>
</div>

</body>
</html>