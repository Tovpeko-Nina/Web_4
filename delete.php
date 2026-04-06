<?php
$mysqli = new mysqli('localhost', 'root', '', 'notebook');
if ($mysqli->connect_error) {
    echo 'Ошибка БД';
    exit;
}

$message = '';
if (isset($_GET['del_id'])) {
    $delId = (int)$_GET['del_id'];
    $res = $mysqli->query("SELECT surname, name FROM contacts WHERE id=$delId");
    if ($row = $res->fetch_assoc()) {
        $fullName = $row['surname'] . ' ' . mb_substr($row['name'], 0, 1) . '.';
        $mysqli->query("DELETE FROM contacts WHERE id=$delId");
        $message = "<p style='color:green'>Запись с фамилией {$fullName} удалена</p>";
    } else {
        $message = "<p style='color:red'>Запись не найдена</p>";
    }
}

$listRes = $mysqli->query("SELECT id, surname, name FROM contacts ORDER BY surname, name");
?>
<h2>Удаление записи</h2>
<?php echo $message; ?>
<div class="delete-links">
    <?php while ($row = $listRes->fetch_assoc()): ?>
        <a href="?p=delete&del_id=<?php echo $row['id']; ?>">
            <?php echo htmlspecialchars($row['surname'] . ' ' . mb_substr($row['name'], 0, 1) . '.'); ?>
        </a><br>
    <?php endwhile; ?>
</div>
<?php $mysqli->close(); ?>