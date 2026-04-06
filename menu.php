<?php
function renderMenu() {
    $current = $_GET['p'] ?? 'viewer';
    $currentSort = $_GET['sort'] ?? 'byid';
    
    $html = '<div id="menu">';
    
    // Основные пункты
    $items = [
        'viewer' => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    foreach ($items as $key => $label) {
        $active = ($current === $key) ? ' class="active"' : '';
        $html .= "<a href=\"/lab9/?p={$key}\"{$active}>{$label}</a>";
    }
    
    // Подменю для просмотра
    if ($current === 'viewer') {
        $html .= '<div id="submenu">';
        $sorts = [
            'byid'   => 'По умолчанию',
            'surname'=> 'По фамилии',
            'birth'  => 'По дате рождения'
        ];
        foreach ($sorts as $key => $label) {
            $active = ($currentSort === $key) ? ' class="active"' : '';
            $html .= "<a href=\"/lab9/?p=viewer&sort={$key}\"{$active}>{$label}</a>";
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}
?>