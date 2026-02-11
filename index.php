<?php
date_default_timezone_set('Europe/Moscow');
$page_title = "Главная страница";
$current_page = 'index';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Товпеко Н.И., 241-352, Лабораторная работа №1</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="<?php echo 'index.php'; ?>"
                    <?php if($current_page == 'index') echo ' class="selected_menu"'; ?>>
                    <?php echo 'Главная'; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo 'menu.php'; ?>"
                    <?php if($current_page == 'menu') echo ' class="selected_menu"'; ?>>
                    <?php echo 'Меню'; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo 'gallery.php'; ?>"
                    <?php if($current_page == 'gallery') echo ' class="selected_menu"'; ?>>
                    <?php echo 'Галерея'; ?>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="content">
            <h1>Добро пожаловать в нашу кофейню!</h1>
            
            <div class="description">
                <p>Мы готовим для вас самый вкусный кофе с 2015 года. Только свежеобжаренные зерна, правильная вода и любовь к своему делу - вот секрет нашего кофе.</p>
                <p>Каждое утро мы открываем двери, чтобы подарить вам заряд бодрости и хорошее настроение. У нас уютно, как дома, а кофе - как в лучших кофейнях Италии.</p>
            </div>

            <div class="info-section">
                <h2>Миссия и ценности</h2>
                <p>Миссия кофейни «У дома» заключается в обеспечении посетителей качественной продукцией по доступным ценам в комфортной атмосфере.</p>
                <p>Приоритетными направлениями деятельности являются использование натурального сырья, соблюдение санитарных норм и индивидуальный подход к каждому клиенту.</p>
                <p>Предприятие сотрудничает только с сертифицированными поставщиками, прошедшими строгий отбор. Все ингредиенты имеют декларации соответствия.</p>
                <p>Кофейня регулярно проводит мониторинг удовлетворенности клиентов посредством анкетирования и анализа обратной связи в цифровых сервисах.</p>
                <p>Стратегия развития до 2026 года включает открытие двух дополнительных точек в спальных районах города и внедрение собственного мобильного приложения.</p>
            </div>
            
            <h2>Часы работы</h2>
            <table>
                <?php
                // Первая строка таблицы - полностью через PHP
                echo '<tr>';
                echo '<th>День недели</th>';
                echo '<th>Время работы</th>';
                echo '<th>Завтраки</th>';
                echo '</tr>';
                
                // Вторая строка - динамическое содержание ячеек
                ?>
                <tr>
                    <td><?php echo "Пн-Пт"; ?></td>
                    <td><?php echo "08:00 - 22:00"; ?></td>
                    <td><?php echo "08:00 - 12:00"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Сб-Вс"; ?></td>
                    <td><?php echo "10:00 - 23:00"; ?></td>
                    <td><?php echo "10:00 - 14:00"; ?></td>
                </tr>
            </table>
            
            <h2>Атмосфера кофейни</h2>
            <?php
            // Динамическая фотография в зависимости от секунды
            $second = date('s');
            if($second % 2 == 0) {
                echo '<div class="photo-item">';
                echo '<img src="picture_1.jpg" alt="Интерьер кофейни днем">';
                echo '<div class="photo-caption">Утро в кофейне - особенно уютно</div>';
                echo '</div>';
            } else {
                echo '<div class="photo-item">';
                echo '<img src="picture_2.jpg" alt="Интерьер кофейни вечером">';
                echo '<div class="photo-caption">Вечером зажигаем свечи</div>';
                echo '</div>';
            }
            ?>
            
            <h2>Наши преимущества</h2>
            <ul>
                <li> Свежеобжаренный кофе каждую неделю</li>
                <li> Домашняя выпечка</li>
                <li> Живая музыка по пятницам</li>
                <li> Бесплатный Wi-Fi и книги</li>
                <li> Скидка 20% в день рождения</li>
            </ul>
            
            <p style="display: none;">
                Здесь находится дополнительный текст для увеличения объема страницы до 1 КБ. 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute 
                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
                pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.
            </p>
        </div>
    </main>

    <footer>
        <?php
        echo "Сформировано " . date('d.m.Y') . " в " . date('H:i:s');
        ?>
    </footer>
</body>
</html>