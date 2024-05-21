<?php
// Проверка, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка наличия идентификатора записи и нового значения
    if (isset($_POST['entry_id']) && isset($_POST['new_value'])) {
        // Получаем идентификатор записи и новое значение из формы
        $entry_id = $_POST['entry_id'];
        $new_value = sanitize_text_field($_POST['new_value']); // Фильтрация ввода для безопасности

        // Обновляем значение в таблице базы данных
        global $wpdb;
        $table_name = $wpdb->prefix . "count";
        $wpdb->update(
            $table_name,
            array('value' => $new_value), // Новое значение
            array('id' => $entry_id), // Условие для обновления записи
            array('%s'), // Формат нового значения
            array('%d') // Формат условия
        );

        // Опционально: перезагружаем страницу после обновления
        echo "<script>window.location.reload();</script>";
    }
}

// Выводим форму и таблицу с данными
global $wpdb;
$table_name = $wpdb->prefix . "count";
$nonce = wp_create_nonce('update_value_nonce');

echo "<h1>Все счетчики</h1>";

echo "<table width='100%' border='1' style='border-collapse: collapse;'>
    <tr>
        <th>№</th>
        <th>Имя счетчика</th>
        <th>Значение</th>
        <th>Новое значение</th>
        <th>Действие</th>
    </tr>";

$entriesList = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

if (count($entriesList) > 0) {
    $count = 1;
    foreach ($entriesList as $entry) {
        $id = $entry->id;
        $name = $entry->nameCount;
        $value = $entry->value;

        echo "<tr>
                <td>$count</td>
                <td>$name</td>
                <td>$value</td>
                <td><form method='post'>
                        <input type='hidden' name='entry_id' value='$id'>
                        <input type='text' name='new_value' placeholder='Введите новое значение'>
                    </td>
                <td><button type='submit'>Сохранить</button></form></td>
            </tr>";
        $count++;
    }
} else {
    echo "<tr><td colspan='5'>Нет значений</td></tr>";
}

echo "</table>";
?>
