<?php
$page_title = "Галерея - Кофейня у дома";
$current_page = 'gallery';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ; ?> - Товпеко Н.И., 241-352, Лабораторная работа №1</title>
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
            <h1>Галерея нашей кофейни</h1>

                <h2>О галерее</h2>
                <p>В данном разделе представлены фотографии интерьера кофейни «У дома», процесса приготовления напитков и готовой продукции. Все изображения являются собственностью заведения и отражают фактическое состояние помещений и качество выпускаемой продукции.</p>
                <p>Фотографирование интерьера и продукции разрешено. При публикации в социальных сетях просим указывать хештег #кофейняудома или отмечать официальную страницу заведения.</p>

            
                <div class="photo-gallery">
                    <?php
                    $coffee_num = (date('s') % 2 == 0) ? 1 : 2;
                    echo '<div class="photo-item">';
                    echo '<img src="coffe' . $coffee_num . '.jpg" alt="Кофе дня">';
                    echo '<div class="photo-caption">';
                    echo ($coffee_num == 1) ? 'Классический эспрессо' : 'Авторский латте';
                    echo '</div>';
                    echo '</div>';

                    $dessert_num = (date('s') % 2 == 0) ? 1 : 2;
                    echo '<div class="photo-item">';
                    echo '<img src="dessert' . $dessert_num . '.jpg" alt="Десерт дня">';
                    echo '<div class="photo-caption">';
                    echo ($dessert_num == 1) ? 'Чизкейк' : 'Морковный торт';
                    echo '</div>';
                    echo '</div>';

                    $croissant_num = (date('s') % 2 == 0) ? 1 : 2;
                    echo '<div class="photo-item">';
                    echo '<img src="croissant' . $croissant_num . '.jpg" alt="Выпечка дня">';
                    echo '<div class="photo-caption">';
                    echo ($croissant_num == 1) ? 'Круассан' : 'Ягодный круассан';
                    echo '</div>';
                    echo '</div>';
                    ?>
             </div>
            
            <h2>Интерьер</h2>
            <div class="photo-gallery">
                <?php
                // Динамическая фотография интерьера
                $interior_num = (date('s') % 2 == 0) ? 1 : 2;
                echo '<div class="photo-item">';
                echo '<img src="interior' . $interior_num . '.jpg" alt="Интерьер">';
                echo '<div class="photo-caption">';
                echo ($interior_num == 1) ? 'Утренний интерьер' : 'Вечерняя атмосфера';
                echo '</div>';
                echo '</div>';
                ?>
            </div>
            
            <h2>Отзывы наших гостей</h2>
            <table>
                <?php
                echo '<tr>';
                echo '<th>Дата</th>';
                echo '<th>Гость</th>';
                echo '<th>Отзыв</th>';
                echo '</tr>';
                ?>
                <tr>
                    <td><?php echo date('d.m.Y', strtotime('-1 day')); ?></td>
                    <td><?php echo "Анна"; ?></td>
                    <td><?php echo "Лучший кофе в районе! Очень уютно."; ?></td>
                </tr>
                <tr>
                    <td><?php echo date('d.m.Y', strtotime('-2 days')); ?></td>
                    <td><?php echo "Михаил"; ?></td>
                    <td><?php echo "Отличное место для работы. Wi-Fi быстрый."; ?></td>
                </tr>
                <tr>
                    <td><?php echo date('d.m.Y', strtotime('-3 days')); ?></td>
                    <td><?php echo "Елена"; ?></td>
                    <td><?php echo "Обожаю их чизкейк! Приду еще."; ?></td>
                </tr>
            </table>
        </div>
    </main>

    <footer>
        <?php echo "Сформировано " . date('d.m.Y') . " в " . date('H:i:s'); ?>
    </footer>
</body>
</html>