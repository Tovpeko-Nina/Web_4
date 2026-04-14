<?php
function getContactsList($sort, $page) {
    $mysqli = new mysqli('localhost', 'root', '', 'notebook');
    if ($mysqli->connect_error) {
        return 'Ошибка подключения к БД: ' . $mysqli->connect_error;
    }
    
    // Сортировка
    switch ($sort) {
        case 'surname':
            $orderBy = "surname ASC, name ASC";
            break;
        case 'birth':
            $orderBy = "birth_date ASC";
            break;
        default:
            $orderBy = "id ASC";
    }
    
    // Общее количество записей
    $totalRes = $mysqli->query("SELECT COUNT(*) AS cnt FROM contacts");
    $totalRow = $totalRes->fetch_assoc();
    $total = $totalRow['cnt'];
    
    if ($total == 0) {
        $mysqli->close();
        return '<p>В таблице нет данных.</p>';
    }
    
    $perPage = 10;
    $pages = ceil($total / $perPage);
    if ($page >= $pages) $page = $pages - 1;
    if ($page < 0) $page = 0;
    $offset = $page * $perPage;
    
    $sql = "SELECT * FROM contacts ORDER BY $orderBy LIMIT $offset, $perPage";
    $result = $mysqli->query($sql);
    
    // НАЧАЛО ТАБЛИЦЫ
    $html = '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    
    // ЗАГОЛОВКИ ТАБЛИЦЫ
    $html .= '<thead>';
    $html .= '<tr style="background-color: #f2f2f2;">';
    $html .= '<th>ID</th>';
    $html .= '<th>Фамилия</th>';
    $html .= '<th>Имя</th>';
    $html .= '<th>Отчество</th>';
    $html .= '<th>Пол</th>';
    $html .= '<th>Дата рождения</th>';
    $html .= '<th>Телефон</th>';
    $html .= '<th>Адрес</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Комментарий</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    
    // ТЕЛО ТАБЛИЦЫ
    $html .= '<tbody>';
    
    while ($row = $result->fetch_assoc()) {
        $gender = ($row['gender'] == 'male') ? 'Мужской' : 'Женский';
        
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['patronymic']) . '</td>';
        $html .= '<td>' . $gender . '</td>';
        $html .= '<td>' . htmlspecialchars($row['birth_date']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody>';
    $html .= '</table>';
    
    // Пагинация
    if ($pages > 1) {
        $html .= '<div class="pagination" style="margin-top: 15px;">';
        for ($i = 0; $i < $pages; $i++) {
            if ($i == $page) {
                $html .= '<span class="current" style="padding: 5px 10px; margin: 2px; background-color: #ddd; font-weight: bold;">' . ($i + 1) . '</span>';
            } else {
                $html .= '<a href="/lab9/?p=viewer&sort=' . urlencode($sort) . '&pg=' . $i . '" style="padding: 5px 10px; margin: 2px; border: 1px solid #ccc; text-decoration: none;">' . ($i + 1) . '</a>';
            }
        }
        $html .= '</div>';
    }
    
    $mysqli->close();
    return $html;
}
?>
