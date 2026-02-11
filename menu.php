<?php
$page_title = "Меню - Кофейня у дома";
$current_page = 'menu';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Товпеко Н.И., 241-352,  Лабораторная работа №1</title>
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
            <h1>Наше меню</h1>

                <div class="about-section">
                    <h2>О нашей кофейне</h2>
                    <p>Кофейня «У дома» основана в 2010 году. За время работы мы зарекомендовали себя как надежное заведение с высоким уровнем обслуживания и стабильным качеством продукции.</p>
                    <p>Мы используем 100% арабику высшего сорта от проверенных поставщиков из Эфиопии, Колумбии и Коста-Рики. Обжарка зерен производится малыми партиями каждые 3 дня, что гарантирует сохранность вкусо-ароматических свойств. Приготовление напитков осуществляется на профессиональном оборудовании La Marzocco.</p>
                    <p>Все сотрудники проходят обязательное обучение и сертификацию. Мы регулярно повышаем квалификацию персонала и внедряем современные стандарты обслуживания.</p>
                </div>
            
            <h2>Кофейная карта</h2>
            <table>
                <?php
                // Первая строка таблицы - полностью через PHP
                echo '<tr>';
                echo '<th>Напиток</th>';
                echo '<th>Объем</th>';
                echo '<th>Цена</th>';
                echo '</tr>';
                
                // Остальные строки - динамическое содержание ячеек
                $coffee_items = [
                    ['Эспрессо', '30 мл', '150'],
                    ['Американо', '200 мл', '180'],
                    ['Капучино', '300 мл', '250'],
                    ['Латте', '400 мл', '280'],
                    ['Раф', '350 мл', '300']
                ];
                
                foreach($coffee_items as $item) {
                    echo '<tr>';
                    echo '<td>' . $item[0] . '</td>';
                    echo '<td>' . $item[1] . '</td>';
                    echo '<td>' . $item[2] . ' ₽</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            
            <h2>Десерты</h2>
            <table>
                <?php
                echo '<tr>';
                echo '<th>Название</th>';
                echo '<th>Вес</th>';
                echo '<th>Цена</th>';
                echo '</tr>';
                ?>
                <tr>
                    <td><?php echo "Чизкейк"; ?></td>
                    <td><?php echo "150 г"; ?></td>
                    <td><?php echo "320 ₽"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Морковный торт"; ?></td>
                    <td><?php echo "120 г"; ?></td>
                    <td><?php echo "280 ₽"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Брауни"; ?></td>
                    <td><?php echo "100 г"; ?></td>
                    <td><?php echo "250 ₽"; ?></td>
                </tr>
            </table>


            
            <h2>Сегодня рекомендуем</h2>
            <div class="photo-gallery">
                <?php
                // Динамическая фотография в зависимости от секунды
                $second = date('s');
                $photo_num = ($second % 2 == 0) ? 1 : 2;
                
                echo '<div class="photo-item">';
                echo '<img src="coffee' . $photo_num . '.jpg" alt="Кофе дня">';
                echo '<div class="photo-caption">Кофе дня - специальное предложение!</div>';
                echo '<div class="price">' . (($photo_num == 1) ? '200 ₽' : '220 ₽') . '</div>';
                echo '</div>';
                
                // Вторая фотография - десерт
                $dessert_num = (date('s') % 2 + 1);
                echo '<div class="photo-item">';
                echo '<img src="cake' . $dessert_num . '.jpg" alt="Десерт дня">';
                echo '<div class="photo-caption">Десерт дня</div>';
                echo '<div class="price">' . (($dessert_num == 1) ? '280 ₽' : '300 ₽') . '</div>';
                echo '</div>';
                ?>
            </div>
        </div>
    </main>

    <footer>
        <?php echo "Сформировано " . date('d.m.Y') . " в " . date('H:i:s'); ?>
    </footer>
</body>
</html>