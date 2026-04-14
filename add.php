<?php
$message = ''; //Переменная для хранения сообщения об успехе/ошибке
$form_data = []; // Для сохранения введенных данных при ошибке

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_contact'])) {
    // Подключение к БД
    $mysqli = new mysqli('localhost', 'root', '', 'notebook');
    if ($mysqli->connect_error) {
        $message = '<span style="color:red">Ошибка подключения к БД</span>';
    } else {
        // Получение данных
        $surname = trim($_POST['surname']);
        $name = trim($_POST['name']);
        $patronymic = trim($_POST['patronymic']);
        $gender = $_POST['gender'];
        $birth_date = $_POST['birth_date'];
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $email = trim($_POST['email']);
        $comment = trim($_POST['comment']);
        
        $errors = [];
        
        // Валидация данных
        if (empty($surname)) {
            $errors[] = "Фамилия обязательна для заполнения";
        } elseif (strlen($surname) < 2) {
            $errors[] = "Фамилия должна содержать минимум 2 символа";
        } elseif (strlen($surname) > 50) {
            $errors[] = "Фамилия не должна превышать 50 символов";
        } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $surname)) {
            $errors[] = "Фамилия может содержать только буквы, пробелы и дефисы";
        }
        
        if (empty($name)) {
            $errors[] = "Имя обязательно для заполнения";
        } elseif (strlen($name) < 2) {
            $errors[] = "Имя должно содержать минимум 2 символа";
        } elseif (strlen($name) > 50) {
            $errors[] = "Имя не должно превышать 50 символов";
        } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $name)) {
            $errors[] = "Имя может содержать только буквы, пробелы и дефисы";
        }
        
        if (!empty($patronymic)) {
            if (strlen($patronymic) > 50) {
                $errors[] = "Отчество не должно превышать 50 символов";
            } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]+$/u', $patronymic)) {
                $errors[] = "Отчество может содержать только буквы, пробелы и дефисы";
            }
        }
        
        if (!in_array($gender, ['male', 'female'])) {
            $errors[] = "Укажите корректный пол";
        }
        
        if (empty($birth_date)) {
            $errors[] = "Дата рождения обязательна";
        } else {
            $date_check = date_parse($birth_date);
            if (!$date_check['error_count'] == 0) {
                $errors[] = "Некорректный формат даты";
            } else {
                $birth_timestamp = strtotime($birth_date);
                $min_date = strtotime('1900-01-01');
                $max_date = strtotime(date('Y-m-d'));
                if ($birth_timestamp < $min_date || $birth_timestamp > $max_date) {
                    $errors[] = "Дата рождения должна быть от 1900 года до текущей даты";
                }
            }
        }
        
        if (empty($phone)) {
            $errors[] = "Телефон обязателен для заполнения";
        } elseif (!preg_match('/^[\d\s\+\(\)-]{10,20}$/', $phone)) {
            $errors[] = "Телефон должен содержать 10-20 символов (цифры, +, -, пробелы, скобки)";
        }
        
        if (!empty($address) && strlen($address) > 200) {
            $errors[] = "Адрес не должен превышать 200 символов";
        }
        
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Некорректный формат email";
            } elseif (strlen($email) > 100) {
                $errors[] = "Email не должен превышать 100 символов";
            }
        }
        
        if (!empty($comment) && strlen($comment) > 500) {
            $errors[] = "Комментарий не должен превышать 500 символов";
        }
        
        // Если ошибок нет - сохраняем в БД
        if (empty($errors)) {
            $surname_esc = $mysqli->real_escape_string($surname);
            $name_esc = $mysqli->real_escape_string($name);
            $patronymic_esc = $mysqli->real_escape_string($patronymic);
            $phone_esc = $mysqli->real_escape_string($phone);
            $address_esc = $mysqli->real_escape_string($address);
            $email_esc = $mysqli->real_escape_string($email);
            $comment_esc = $mysqli->real_escape_string($comment);
            
            $sql = "INSERT INTO contacts (surname, name, patronymic, gender, birth_date, phone, address, email, comment)
                    VALUES ('$surname_esc', '$name_esc', '$patronymic_esc', '$gender', '$birth_date', '$phone_esc', '$address_esc', '$email_esc', '$comment_esc')";
            
            if ($mysqli->query($sql)) {
                $message = '<span style="color:green">✓ Запись успешно добавлена</span>';
                // Очищаем форму
                $form_data = [];
            } else {
                $message = '<span style="color:red">✗ Ошибка: запись не добавлена. ' . $mysqli->error . '</span>';
                $form_data = $_POST;
            }
        } else {
            $message = '<div style="color:red"><strong>Ошибки валидации:</strong><ul>';
            foreach ($errors as $error) {
                $message .= '<li>' . htmlspecialchars($error) . '</li>';
            }
            $message .= '</ul></div>';
            $form_data = $_POST;
        }
        $mysqli->close();
    }
} else {
    // Инициализация пустых данных для формы
    $form_data = [
        'surname' => '', 'name' => '', 'patronymic' => '',
        'gender' => 'male', 'birth_date' => '', 'phone' => '',
        'address' => '', 'email' => '', 'comment' => ''
    ];
}
?>
<h2>Добавление записи</h2>
<?php echo $message; ?>
<form method="post" action="/lab9/?p=add" id="addForm">
    <div class="form-group">
        <label for="surname">Фамилия <span class="required">*</span>:</label>
        <input type="text" id="surname" name="surname" 
               value="<?php echo htmlspecialchars($form_data['surname'] ?? ''); ?>" 
               required minlength="2" maxlength="50"
               pattern="[А-Яа-яЁёA-Za-z\s-]+"
               title="Только буквы, пробелы и дефисы">
        <small class="field-hint">От 2 до 50 символов, только буквы</small>
    </div>
    
    <div class="form-group">
        <label for="name">Имя <span class="required">*</span>:</label>
        <input type="text" id="name" name="name" 
               value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>" 
               required minlength="2" maxlength="50"
               pattern="[А-Яа-яЁёA-Za-z\s-]+"
               title="Только буквы, пробелы и дефисы">
        <small class="field-hint">От 2 до 50 символов, только буквы</small>
    </div>
    
    <div class="form-group">
        <label for="patronymic">Отчество:</label>
        <input type="text" id="patronymic" name="patronymic" 
               value="<?php echo htmlspecialchars($form_data['patronymic'] ?? ''); ?>"
               maxlength="50"
               pattern="[А-Яа-яЁёA-Za-z\s-]*"
               title="Только буквы, пробелы и дефисы">
        <small class="field-hint">Необязательно, максимум 50 символов</small>
    </div>
    
    <div class="form-group">
        <label for="gender">Пол <span class="required">*</span>:</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php echo ($form_data['gender'] ?? 'male') == 'male' ? 'selected' : ''; ?>>Мужской</option>
            <option value="female" <?php echo ($form_data['gender'] ?? '') == 'female' ? 'selected' : ''; ?>>Женский</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="birth_date">Дата рождения <span class="required">*</span>:</label>
        <input type="date" id="birth_date" name="birth_date" 
               value="<?php echo htmlspecialchars($form_data['birth_date'] ?? ''); ?>"
               required min="1900-01-01" max="<?php echo date('Y-m-d'); ?>">
        <small class="field-hint">От 1900 года до текущей даты</small>
    </div>
    
    <div class="form-group">
        <label for="phone">Телефон <span class="required">*</span>:</label>
        <input type="tel" id="phone" name="phone" 
               value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>"
               required pattern="[\d\s\+\(\)-]{10,12}"
               placeholder="+7 (123) 456-78-90"
               title="10-12 символов: цифры, +, -, пробелы, скобки">
        <small class="field-hint">10-12 символов: цифры, +, -, пробелы, скобки</small>
    </div>
    
    <div class="form-group">
        <label for="address">Адрес:</label>
        <textarea id="address" name="address" maxlength="200"
                  placeholder="Полный адрес проживания"><?php echo htmlspecialchars($form_data['address'] ?? ''); ?></textarea>
        <small class="field-hint">Необязательно, максимум 200 символов</small>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" 
               value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
               maxlength="100"
               placeholder="example@domain.com">
        <small class="field-hint">Необязательно, формат: name@domain.com</small>
    </div>
    
    <div class="form-group">
        <label for="comment">Комментарий:</label>
        <textarea id="comment" name="comment" maxlength="500"
                  placeholder="Дополнительная информация"><?php echo htmlspecialchars($form_data['comment'] ?? ''); ?></textarea>
        <small class="field-hint">Необязательно, максимум 500 символов</small>
    </div>
    
    <div class="form-group">
        <input type="submit" name="add_contact" value="Добавить запись">
        <input type="reset" value="Очистить форму">
    </div>
</form>
