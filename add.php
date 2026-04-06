<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_contact'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'notebook');
    if ($mysqli->connect_error) {
        $message = '<span style="color:red">Ошибка подключения к БД</span>';
    } else {
        $surname = $mysqli->real_escape_string($_POST['surname']);
        $name = $mysqli->real_escape_string($_POST['name']);
        $patronymic = $mysqli->real_escape_string($_POST['patronymic']);
        $gender = $_POST['gender'];
        $birth_date = $_POST['birth_date'];
        $phone = $mysqli->real_escape_string($_POST['phone']);
        $address = $mysqli->real_escape_string($_POST['address']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $comment = $mysqli->real_escape_string($_POST['comment']);
        
        $sql = "INSERT INTO contacts (surname, name, patronymic, gender, birth_date, phone, address, email, comment)
                VALUES ('$surname', '$name', '$patronymic', '$gender', '$birth_date', '$phone', '$address', '$email', '$comment')";
        
        if ($mysqli->query($sql)) {
            $message = '<span style="color:green">Запись добавлена</span>';
        } else {
            $message = '<span style="color:red">Ошибка: запись не добавлена</span>';
        }
        $mysqli->close();
    }
}
?>
<h2>Добавление записи</h2>
<?php echo $message; ?>
<form method="post" action="/lab9/?p=add">
    <input type="text" name="surname" placeholder="Фамилия" required><br>
    <input type="text" name="name" placeholder="Имя" required><br>
    <input type="text" name="patronymic" placeholder="Отчество"><br>
    <select name="gender" required>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
    </select><br>
    <input type="date" name="birth_date" required><br>
    <input type="text" name="phone" placeholder="Телефон" required><br>
    <textarea name="address" placeholder="Адрес"></textarea><br>
    <input type="email" name="email" placeholder="Email"><br>
    <textarea name="comment" placeholder="Комментарий"></textarea><br>
    <input type="submit" name="add_contact" value="Добавить запись">
</form>