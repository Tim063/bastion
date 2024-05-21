<?php
// Проверяем, была ли отправлена форма для добавления кейса
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_case'])) {
    // Получаем данные из формы
    $category = sanitize_text_field($_POST['category']);
    $happen = sanitize_text_field($_POST['happen']);
    $activity = sanitize_text_field($_POST['activity']);
    $result = sanitize_text_field($_POST['result']);

    // Проверяем, что все поля заполнены
    if (!empty($happen) && !empty($activity) && !empty($result)) {
        global $wpdb;
        $tablename = $wpdb->prefix . "cases";

        // Вставляем новый кейс в базу данных
        $wpdb->insert(
            $tablename,
            array(
                'category' => $category,
                'happen' => $happen,
                'activity' => $activity,
                'result' => $result
            ),
            array('%s', '%s', '%s')
        );
    }
}

// Выводим форму для добавления кейса
?>
<style>
    .add-case-form-name {
        font-size: 20px;
        display: block;
        margin-bottom: 5px;
    }

    .add-case-form input[type="text"] {
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .add-case-form input[type="submit"] {
        background-color: #1E1F1E;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-case-form input[type="submit"]:hover {
        background-color: #6D6D6D;
    }
</style>

<h1>Добавить кейс</h1>
<form class="add-case-form" method="post" action="">
    <label for="happen" class="add-case-form-name">Категория:</label>
    <input type="text" id="category" name="category"><br><br>
    
    <label for="happen" class="add-case-form-name">Что случилось:</label>
    <textarea id="happen" name="happen" rows="10" cols="150"></textarea><br><br>

    <label for="activity" class="add-case-form-name">Проведенная работа:</label>
    <textarea id="activity" name="activity" rows="10" cols="150"></textarea><br><br>

    <label for="result" class="add-case-form-name">Результат:</label>
    <textarea id="result" name="result" rows="10" cols="150"></textarea><br><br>

    <input type="submit" name="add_case" value="Добавить кейс">
</form>
