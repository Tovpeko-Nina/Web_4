<?php
$mysqli = new mysqli('localhost', 'root', '', 'notebook');
if ($mysqli->connect_error) {
    echo 'Ошибка БД';
    exit;
}

$message = '';

// Обработка POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_contact'])) {
    $id = (int)$_POST['id'];
    $surname = $mysqli->real_escape_string($_POST['surname']);
    $name = $mysqli->real_escape_string($_POST['name']);
    $patronymic = $mysqli->real_escape_string($_POST['patronymic']);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $comment = $mysqli->real_escape_string($_POST['comment']);
    
    $sql = "UPDATE contacts SET 
            surname='$surname', name='$name', patronymic='$patronymic',
            gender='$gender', birth_date='$birth_date', phone='$phone',
            address='$address', email='$email', comment='$comment'
            WHERE id=$id";
    $mysqli->query($sql);
    $message = '<p style="color:green">Данные изменены</p>';
}

// Определяем текущую запись
$currentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$current = null;
if ($currentId > 0) {
    $res = $mysqli->query("SELECT * FROM contacts WHERE id=$currentId");
    $current = $res->fetch_assoc();
}
if (!$current) {
    $res = $mysqli->query("SELECT * FROM contacts ORDER BY id LIMIT 1");
    $current = $res->fetch_assoc();
    if ($current) $currentId = $current['id'];
}

// Список всех записей
$allRes = $mysqli->query("SELECT id, surname, name FROM contacts ORDER BY surname, name");
?>
<h2>Редактирование записи</h2>
<?php echo $message; ?>
<div class="edit-links">
    <?php while ($row = $allRes->fetch_assoc()): ?>
        <?php if ($row['id'] == $currentId): ?>
            <strong><?php echo htmlspecialchars($row['surname'] . ' ' . $row['name']); ?></strong><br>
        <?php else: ?>
            <a href="/lab9/?p=edit&id=<?php echo $row['id']; ?>">
                <?php echo htmlspecialchars($row['surname'] . ' ' . $row['name']); ?>
            </a><br>
        <?php endif; ?>
    <?php endwhile; ?>
</div>

<?php if ($current): ?>
<form method="post" action="/lab9/?p=edit&id=<?php echo $current['id']; ?>">
    <input type="hidden" name="id" value="<?php echo $current['id']; ?>">
    <input type="text" name="surname" value="<?php echo htmlspecialchars($current['surname']); ?>" required><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($current['name']); ?>" required><br>
    <input type="text" name="patronymic" value="<?php echo htmlspecialchars($current['patronymic']); ?>"><br>
    <select name="gender">
        <option value="male" <?php echo $current['gender']=='male' ? 'selected' : ''; ?>>Мужской</option>
        <option value="female" <?php echo $current['gender']=='female' ? 'selected' : ''; ?>>Женский</option>
    </select><br>
    <input type="date" name="birth_date" value="<?php echo $current['birth_date']; ?>" required><br>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($current['phone']); ?>" required><br>
    <textarea name="address"><?php echo htmlspecialchars($current['address']); ?></textarea><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($current['email']); ?>"><br>
    <textarea name="comment"><?php echo htmlspecialchars($current['comment']); ?></textarea><br>
    <input type="submit" name="edit_contact" value="Изменить запись">
</form>
<?php else: ?>
    <p>Записей пока нет</p>
<?php endif; ?>
<?php $mysqli->close(); ?>