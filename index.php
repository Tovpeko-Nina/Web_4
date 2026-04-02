<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа А-7: Сортировка массивов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        td {
            padding: 5px;
        }
        .element_row {
            padding: 5px;
        }
        .element_row input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .element_index {
            font-weight: bold;
            color: #555;
            text-align: right;
            padding-right: 10px;
        }
        select, input[type="button"], input[type="submit"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        select {
            width: 100%;
            margin: 10px 0;
        }
        input[type="button"] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        input[type="submit"] {
            background-color: #2196F3;
            color: white;
            border: none;
        }
        input[type="button"]:hover {
            background-color: #45a049;
        }
        input[type="submit"]:hover {
            background-color: #0b7dda;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        hr {
            margin: 20px 0;
        }
    </style>
    <script>
        function setHTML(element, txt) {
            if(element.innerHTML !== undefined) {
                element.innerHTML = txt;
            } else {
                var range = document.createRange();
                range.selectNodeContents(element);
                range.deleteContents();
                var fragment = range.createContextualFragment(txt);
                element.appendChild(fragment);
            }
        }

        function addElement() {
            var t = document.getElementById('elements');
            var index = t.rows.length;
            var row = t.insertRow(index);
            
            var celIndex = row.insertCell(0);
            celIndex.className = 'element_index';
            setHTML(celIndex, (index + 1).toString());
            
            var celInput = row.insertCell(1);
            celInput.className = 'element_row';
            var celContent = '<input type="text" name="element' + index + '">';
            setHTML(celInput, celContent);
            
            document.getElementById('arrLength').value = t.rows.length;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Сортировка массива</h1>
        <form action="sort.php" method="post" target="_blank">
            <table id="elements">
                <tr>
                    <td class="element_index">1</td>
                    <td class="element_row"><input type="text" name="element0"></td>
                </tr>
            </table>
            
            <input type="hidden" name="arrLength" id="arrLength" value="1">
            
            <select name="algorithm">
                <option value="0">Сортировка выбором</option>
                <option value="1">Пузырьковый алгоритм</option>
                <option value="2">Алгоритм Шелла</option>
                <option value="3">Алгоритм садового гнома</option>
                <option value="4">Быстрая сортировка</option>
                <option value="5">Встроенная функция PHP (sort)</option>
            </select>
            
            <div class="button-group">
                <input type="button" value="Добавить еще один элемент" onclick="addElement();">
                <input type="submit" value="Сортировать массив">
            </div>
        </form>
    </div>
</body>
</html>