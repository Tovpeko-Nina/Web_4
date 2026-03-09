<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР3 - Товпеко Н.И. 241-352</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <div class="header-text">
                <h1>Лабораторная работа №3</h1>
                <p>Товпеко Н.И. 241-352</p>
            </div>
        </div>
    </header>

    <main>
        <div class="content">
            <?php
            // Инициализация хранилища (текущее число на экране)
            if (!isset($_GET['store'])) {
                $_GET['store'] = '';
            }

            // Инициализация счётчика нажатий
            if (!isset($_GET['counter'])) {
                $_GET['counter'] = 0;
            }

            // Обработка нажатия кнопки (цифра или сброс)
            if (isset($_GET['key'])) {
                // Увеличиваем счётчик нажатий
                $_GET['counter']++;

                if ($_GET['key'] === 'reset') {
                    // Сброс: очищаем хранилище
                    $_GET['store'] = '';
                } else {
                    // Добавляем цифру к хранилищу
                    $_GET['store'] .= $_GET['key'];
                }
            }
            ?>

            <!-- Калькулятор -->
            <div class="calculator">
                <!-- Окно просмотра результата -->
                <div class="result"><?php echo htmlspecialchars($_GET['store']); ?></div>

                <!-- Кнопки цифр (ссылки) -->
                <div class="buttons">
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <a class="button" href="?key=<?php echo $i; ?>&store=<?php echo urlencode($_GET['store']); ?>&counter=<?php echo $_GET['counter']; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    <a class="button" href="?key=0&store=<?php echo urlencode($_GET['store']); ?>&counter=<?php echo $_GET['counter']; ?>">0</a>
                    <!-- Кнопка сброса -->
                    <a class="button reset" href="?key=reset&store=<?php echo urlencode($_GET['store']); ?>&counter=<?php echo $_GET['counter']; ?>">СБРОС</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p> Общее число нажатий: <?php echo $_GET['counter']; ?></p>
        </div>
    </footer>
</body>
</html>